<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core;

/**
 * Exception Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class Exception extends \Exception
{

    /**
     * @var string Error id
     */
    protected $id;
    
    /**
     * @var array The message cache
     */
    static protected $cache    = array();
    
    static protected $untranslatedMessage = array();
    
    public function __construct($message)
    {
        $this->id = $message;
        $args = func_get_args();
        array_shift($args);
        
        $message = $this->translateMessage($message);
        $tokens = array();
        for($i=0;$i<count($args);$i++){            
            $tokens['{'.$i.'}']=$args[$i];
        }        
        parent::__construct(strtr($message,$tokens));
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    static public function getMessageDir()
    {
        return \dx::getRootDir().'/src/Dayax/Core/Resources/exception';
    }
    
    protected function getMessageFile()
    {
        $dir = self::getMessageDir();
        if(!file_exists($file=$dir.'/messages.'.DayaxBase::getLanguage().'.txt')){
            $file = $dir.'/messages.txt';
        }
        return $file;
    }
    
    protected function translateMessage($key)
    {
        $file = $this->getMessageFile();
        
        if(!isset(self::$cache[$file][$key])){
            self::$untranslatedMessage[] = $key;
        }
        return isset(self::$cache[$file][$key]) ? self::$cache[$file][$key]:$key;
    }
    
    static public function getUntranslatedMessage()
    {
        return self::$untranslatedMessage;
    }
    
    static public function factory($namespace)
    {
        $eval = <<<EOC
namespace $namespace;

class Exception extends \Dayax\Core\Exception
{
}
EOC;
        eval($eval);
        
    }   
    
    static public function getCachedMessage()
    {
        return self::$cache;
    }
    static public function readCacheFile()
    {
        $cacheFile = \dx::getCacheDir().'/exception.messages.php';        
        if(is_file($cacheFile)){
            require_once($cacheFile);
        }        
        $finder = \dx::finder()
                ->name('*.txt')
                ->in(self::getMessageDir())
                ->files()
        ;
        $flag = false;
        foreach($finder as $file){
            $mFile = $file->getRealpath();
            if (!isset(self::$cache[$mFile]) || (filemtime($mFile) > @filemtime($cacheFile))) {
                $flag=true;                
                foreach (file($mFile) as $content) {
                    if (trim($content) == ''){                                                                                     
                        continue;
                    }
                    list($id,$message) =  explode('=', $content);                    
                    self::$cache[$mFile][trim($id)] = trim($message);
                }                
            }
        }
        
        if($flag){            
            $data = var_export(self::$cache,true);
            $tpl = "<?php\n/* generated at: %s*/\nself::\$cache = %s;";
            $contents = sprintf($tpl,date('Y-m-d h:m:s'),$data);            
            file_put_contents($cacheFile, $contents, LOCK_EX);
            chmod($file, 0777);
        }
    }
}
