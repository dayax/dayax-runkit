<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.munthi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Tests\Core\Util;

use Dayax\Core\Test\TestCase;
use Dayax\Core\Util\File;
use Dayax\Core\Util\FileLogInterface;
use Symfony\Component\Finder\Finder;

//use Dayax\Core\Util\Finder;

define("DS", DIRECTORY_SEPARATOR);

class myFile extends File
{

    public function calculateRelativeDir($from, $to)
    {
        return parent::calculateRelativeDir($from, $to);
    }

    public function canonicalizePath($path)
    {
        return parent::canonicalizePath($path);
    }

}

class FooLogFileHandler implements FileLogInterface
{
    protected $message;
    public function onFileLogSection($section,$message,$size=null)
    {
         $this->message = sprintf("%s >> %s %s",$section,$message,$size);
    }
    
    public function getMessage()
    {
        return $this->message;
    }
}


class FileTest extends TestCase
{
    protected $filesystem;
    
    protected function setUp()
    {
        $this->filesystem = new myFile();
        $this->filesystem->registerHandler(new FooLogFileHandler());
    }
    
    protected function tearDown()
    {
        $finder = new Finder();
        
        if(is_dir(__DIR__.'/fixtures/target')){
            foreach($finder->files()->in(__DIR__.'/fixtures/target') as $file){
                unlink($file);                        
            }
            foreach($finder->directories()->in(__DIR__.'/fixtures/target')  as $dir)
            {
                rmdir($dir);
            }
        }
    }
    
    public function testCanonicalizesPaths()
    {
        ////$t->diag('sfFilesystem canonicalizes pathes');
        $this->assertEquals($this->filesystem->canonicalizePath('..' . DS . DS . '.' . DS . '..' . DS . 'dir4' . DS . DS . '.' . DS . 'dir5' . DS . 'dir6' . DS . '..' . DS . DS . 'dir7' . DS), '..' . DS . '..' . DS . 'dir4' . DS . 'dir5' . DS . 'dir7' . DS, '->canonicalizePath() correctly resolves "\\.." and "\\."');        
    }

    public function testCalculatesRelativePaths()
    {
//$t->diag('sfFilesystem calculates relative pathes');
        $common = DS . 'tmp' . DS . 'sfproject' . DS;
        $source = $common . 'web' . DS . 'myplugin';
        $target = $common . 'plugins' . DS . 'myplugin' . DS . 'web';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), '..' . DS . 'plugins' . DS . 'myplugin' . DS . 'web', '->calculateRelativeDir() correctly calculates the relative path');

        $source = $common . 'web' . DS . 'myplugin';
        $target = $common . 'webplugins' . DS . 'myplugin' . DS . 'web';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), '..' . DS . 'webplugins' . DS . 'myplugin' . DS . 'web', '->calculateRelativeDir() correctly calculates the relative path for dirs that share chars');

        $source = $common . 'web' . DS . 'myplugin';
        $target = $common . 'web' . DS . 'otherplugin' . DS . 'sub';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), 'otherplugin' . DS . 'sub', '->calculateRelativeDir() works without going up one dir');

        $source = 'c:\sfproject\web\myplugin';
        $target = 'd:\symfony\plugins\myplugin\web';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), 'd:\symfony\plugins\myplugin\web', '->calculateRelativeDir() returns absolute path when no relative path possible');

        $source = $common . 'web' . DS . 'myplugin';
        $target = $common . 'web' . DS . 'myotherplugin' . DS . 'sub';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), 'myotherplugin' . DS . 'sub', '->calculateRelativeDir() correctly calculates the relative path for dirs that share chars');

        $source = $common . 'web' . DS . 'myplugin';
        $target = $common . 'web' . DS . 'motherplugin' . DS . 'sub';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), 'motherplugin' . DS . 'sub', '->calculateRelativeDir() correctly calculates the relative path for dirs that share chars');

        // http://trac.symfony-project.org/ticket/5488
        $source = $common . '..' . DS . 'web' . DS . 'myplugin';
        $target = $common . 'lib' . DS . 'vendor' . DS . 'symfony' . DS . 'plugins' . DS . 'myplugin' . DS . 'web';
        $this->assertEquals($this->filesystem->calculateRelativeDir($source, $target), '..' . DS . 'sfproject' . DS . 'lib' . DS . 'vendor' . DS . 'symfony' . DS . 'plugins' . DS . 'myplugin' . DS . 'web', '->calculateRelativeDir() correctly calculates the relative path for dirs that share chars');
    }
    
    /**
     *  @dataProvider getTestCopy
     */
    public function testCopy($source,$target)
    {
        $this->filesystem->copy($source,$target);
        $this->assertTrue(is_file($target));
    }
    
    public function getTestCopy()
    {
        $source = __DIR__.'/fixtures/source';
        $target = __DIR__.'/fixtures/target';
        return array(
          array($source.'/foo',$target.'/bar'),
        );
    }
}