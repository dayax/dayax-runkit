<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core\Util;

use Symfony\Component\Finder\Finder;

/**
 * Provides basic utility to manipulate the file system.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class File
{
    protected $handlers = array();
    /**
     * Copies a file.
     *
     * This method only copies the file if the origin file is newer than the target file.
     *
     * By default, if the target already exists, it is not overriden.
     *
     * To override existing files, pass the "override" option.
     *
     * @param string $originFile  The original filename
     * @param string $targetFile  The target filename
     * @param array  $options     An array of options
     */
    public function copy($originFile, $targetFile, $options = array())
    {
        if (!array_key_exists('override', $options)) {
            $options['override'] = false;
        }

        // we create target_dir if needed
        if (!is_dir(dirname($targetFile))) {
            $this->mkdirs(dirname($targetFile));
        }

        $mostRecent = false;
        if (file_exists($targetFile)) {
            $statTarget = stat($targetFile);
            $stat_origin = stat($originFile);
            $mostRecent = ($stat_origin['mtime'] > $statTarget['mtime']) ? true : false;
        }

        if ($options['override'] || !file_exists($targetFile) || $mostRecent) {
            $this->logSection('file+', $targetFile);
            copy($originFile, $targetFile);
        }
    }

    /**
     * Creates a directory recursively.
     *
     * @param  string $path  The directory path
     * @param  int    $mode  The directory mode
     *
     * @return bool true if the directory has been created, false otherwise
     */
    public function mkdirs($path, $mode = 0777)
    {
        if (is_dir($path)) {
            return true;
        }

        $this->logSection('dir+', $path);

        return @mkdir($path, $mode, true);
    }

    /**
     * Creates empty files.
     *
     * @param mixed $files  The filename, or an array of filenames
     */
    public function touch($files)
    {
        if (!is_array($files)) {
            $files = array($files);
        }

        foreach ($files as $file) {
            $this->logSection('file+', $file);

            touch($file);
        }
    }

    /**
     * Removes files or directories.
     *
     * @param string|array|\Traversable $files A filename, an array of files, or a \Traversable instance to remove
     */
    public function remove($files)
    {
        $files = iterator_to_array($this->toIterator($files));
        $files = array_reverse($files);
        foreach ($files as $file) {
            if (!file_exists($file)) {
                continue;
            }

            if (is_dir($file) && !is_link($file)) {
                $this->remove(new \FilesystemIterator($file));                
                rmdir($file);
                $this->logSection('dir-', $file);
            } else {
                unlink($file);
                $this->logSection('file-', $file);
            }
        }
    }
    
    /**
     * Removes files or directories.
     *
     * @param mixed $files  A filename or an array of files to remove
     */
    public function oldremove($files)
    {

        $files = array_reverse($files);
        foreach ($files as $file) {
            if (is_dir($file) && !is_link($file)) {
                $this->logSection('dir-', $file);

                rmdir($file);
            } else {
                $this->logSection(is_link($file) ? 'link-' : 'file-', $file);

                unlink($file);
            }
        }
    }

    /**
     * Change mode for an array of files or directories.
     *
     * @param array   $files  An array of files or directories
     * @param integer $mode   The new mode
     * @param integer $umask  The mode mask (octal)
     */
    public function chmod($files, $mode, $umask = 0000)
    {
        $currentUmask = umask();
        umask($umask);

        if (!is_array($files)) {
            $files = array($files);
        }

        foreach ($files as $file) {
            $this->logSection(sprintf('chmod %o', $mode), $file);
            chmod($file, $mode);
        }

        umask($currentUmask);
    }

    /**
     * Renames a file.
     *
     * @param string $origin  The origin filename
     * @param string $target  The new filename
     */
    public function rename($origin, $target)
    {
        // we check that target does not exist
        if (is_readable($target)) {
            throw new Exception(sprintf('Cannot rename because the target "%s" already exist.', $target));
        }

        $this->logSection('rename', $origin . ' > ' . $target);
        rename($origin, $target);
    }

    /**
     * Creates a symbolic link or copy a directory.
     *
     * @param string $originDir      The origin directory path
     * @param string $targetDir      The symbolic link name
     * @param bool   $copyOnWindows  Whether to copy files if on windows
     */
    public function symlink($originDir, $targetDir, $copyOnWindows = false)
    {
        if ('\\' == DIRECTORY_SEPARATOR && $copyOnWindows) {
            $finder = Finder::type('any');
            $this->mirror($originDir, $targetDir, $finder);
            return;
        }

        $ok = false;
        if (is_link($targetDir)) {
            if (readlink($targetDir) != $originDir) {
                unlink($targetDir);
            } else {
                $ok = true;
            }
        }

        if (!$ok) {
            $this->logSection('link+', $targetDir);
            symlink($originDir, $targetDir);
        }
    }

    /**
     * Creates a symbolic link using a relative path if possible.
     *
     * @param string $originDir      The origin directory path
     * @param string $targetDir      The symbolic link name
     * @param bool   $copyOnWindows  Whether to copy files if on windows
     */
    public function relativeSymlink($originDir, $targetDir, $copyOnWindows = false)
    {
        if ('\\' != DIRECTORY_SEPARATOR || !$copyOnWindows) {
            $originDir = $this->calculateRelativeDir($targetDir, $originDir);
        }

        $this->symlink($originDir, $targetDir, $copyOnWindows);
    }

    /**
     * Mirrors a directory to another.
     *
     * @param string   $originDir  The origin directory
     * @param string   $targetDir  The target directory
     * @param Finder   $finder     An Finder instance
     * @param array    $options    An array of options (see copy())
     */
    public function mirror($originDir, $targetDir,Finder $finder, $options = array())
    {
        foreach ($finder->in($originDir) as $file) {
            /*if (is_dir($originDir . DIRECTORY_SEPARATOR . $file)) {
                $this->mkdirs($targetDir . DIRECTORY_SEPARATOR . $file);
            } else if (is_file($originDir . DIRECTORY_SEPARATOR . $file)) {
                $this->copy($originDir . DIRECTORY_SEPARATOR . $file, $targetDir . DIRECTORY_SEPARATOR . $file, $options);
            } else if (is_link($originDir . DIRECTORY_SEPARATOR . $file)) {
                $this->symlink($originDir . DIRECTORY_SEPARATOR . $file, $targetDir . DIRECTORY_SEPARATOR . $file);
            } else {
                throw new Exception(sprintf('Unable to guess "%s" file type.', $file));
            }*/
            $target = $targetDir.'/'.str_replace($originDir.DIRECTORY_SEPARATOR, '', $file->getPathname());
            if(is_dir($file)){
                $this->mkdirs($target);
            }elseif(is_file($file)){
                $this->copy($file,$target,$options);
            }elseif(is_link($file)){
                $this->symlink($file, $target);
            }else{
                throw new Exception('file.mirror_file_type',$file);
            }
        }
    }

    /**
     * Executes a shell command.
     *
     * @param string $cmd            The command to execute on the shell
     * @param array  $stdoutCallback A callback for stdout output
     * @param array  $stderrCallback A callback for stderr output
     *
     * @return array An array composed of the content output and the error output
     */
    public function execute($cmd, $stdoutCallback = null, $stderrCallback = null)
    {
        $this->logSection('exec ', $cmd);

        $descriptorspec = array(
            1 => array('pipe', 'w'), // stdout
            2 => array('pipe', 'w'), // stderr
        );

        $process = proc_open($cmd, $descriptorspec, $pipes);
        if (!is_resource($process)) {
            throw new RuntimeException('Unable to execute the command.');
        }

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $output = '';
        $err = '';
        while (!feof($pipes[1]) || !feof($pipes[2])) {
            foreach ($pipes as $key => $pipe) {
                if (!$line = fread($pipe, 128)) {
                    continue;
                }

                if (1 == $key) {
                    // stdout
                    $output .= $line;
                    if ($stdoutCallback) {
                        call_user_func($stdoutCallback, $line);
                    }
                } else {
                    // stderr
                    $err .= $line;
                    if ($stderrCallback) {
                        call_user_func($stderrCallback, $line);
                    }
                }
            }

            usleep(100000);
        }

        fclose($pipes[1]);
        fclose($pipes[2]);

        if (($return = proc_close($process)) > 0) {
            throw new RuntimeException('Problem executing command.', $return);
        }

        return array($output, $err);
    }

    /**
     * Replaces tokens in an array of files.
     *
     * @param array  $files       An array of filenames
     * @param string $beginToken  The begin token delimiter
     * @param string $endToken    The end token delimiter
     * @param array  $tokens      An array of token/value pairs
     */
    public function replaceTokens($files, $beginToken, $endToken, $tokens)
    {
        if (!is_array($files)) {
            $files = array($files);
        }

        foreach ($files as $file) {
            $content = file_get_contents($file);
            foreach ($tokens as $key => $value) {
                $content = str_replace($beginToken . $key . $endToken, $value, $content, $count);
            }

            $this->logSection('tokens', $file);

            file_put_contents($file, $content);
        }
    }

    /**
     * Logs a message in a section.
     *
     * @param string $section  The section name
     * @param string $message  The message
     * @param int    $size     The maximum size of a line
     */
    protected function logSection($section, $message, $size = null)
    {
        /*if (!$this->dispatcher) {
            return;
        }

        $message = $this->formatter ? $this->formatter->formatSection($section, $message, $size) : $section . ' ' . $message . "\n";

        $this->dispatcher->notify(new sfEvent($this, 'command.log', array($message)));*/        
        foreach($this->handlers as $handler){
            call_user_func(array($handler,'onFileLogSection'), $section,$message,$size);
        }
    }

    /**
     * Calculates the relative path from one to another directory.
     *
     * If the paths share no common path the absolute target dir is returned.
     *
     * @param string $from The directory from which to calculate the relative path
     * @param string $to   The target directory
     *
     * @return string
     */
    protected function calculateRelativeDir($from, $to)
    {
        $from = $this->canonicalizePath($from);
        $to = $this->canonicalizePath($to);

        $commonLength = 0;
        $minPathLength = min(strlen($from), strlen($to));

        // count how many chars the strings have in common
        for ($i = 0; $i < $minPathLength; $i++) {
            if ($from[$i] != $to[$i]) {
                break;
            }

            if (DIRECTORY_SEPARATOR == $from[$i]) {
                $commonLength = $i + 1;
            }
        }

        if ($commonLength) {
            if (extension_loaded('mbstring')) {
                $levelUp = mb_substr_count(mb_strcut($from, $commonLength), DIRECTORY_SEPARATOR);
            } else {
                $levelUp = substr_count($from, DIRECTORY_SEPARATOR, $commonLength);
            }

            // up that many level
            $relativeDir = str_repeat('..' . DIRECTORY_SEPARATOR, $levelUp);

            // down the remaining $to path
            $relativeDir .= substr($to, $commonLength);

            return $relativeDir;
        }

        return $to;
    }

    /**
     * @param string A filesystem path
     *
     * @return string
     */
    protected function canonicalizePath($path)
    {
        if (empty($path)) {
            return '';
        }

        $out = array();
        foreach (explode(DIRECTORY_SEPARATOR, $path) as $i => $fold) {
            if ('' == $fold || '.' == $fold) {
                continue;
            }

            if ('..' == $fold && $i > 0 && '..' != end($out)) {
                array_pop($out);
            } else {
                $out[] = $fold;
            }
        }

        $result = DIRECTORY_SEPARATOR == $path[0] ? DIRECTORY_SEPARATOR : '';
        $result .= implode(DIRECTORY_SEPARATOR, $out);
        $result .= DIRECTORY_SEPARATOR == $path[strlen($path) - 1] ? DIRECTORY_SEPARATOR : '';

        return $result;
    }
    
    public function registerHandler(FileLogInterface $handler)
    {
        $this->handlers[] = $handler;
    }
    
    protected function toIterator($files)
    {
        if (!$files instanceof \Traversable) {
            $files = new \ArrayObject(is_array($files) ? $files : array($files));
        }

        return $files;
    }
    
}

interface FileLogInterface
{
    public function onFileLogSection($section,$message,$size=null);
}
