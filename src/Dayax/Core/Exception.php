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
    
    public function getMessageDir()
    {
        return __DIR__ . '/Resources/exception';
    }
    
    protected function getMessageFile()
    {
        $dir = $this->getMessageDir();
        if(!file_exists($file=$dir.'/messages.'.DayaxBase::getLanguage().'.txt')){
            $file = $dir.'/messages.txt';
        }
        return $file;
    }
    
    protected function translateMessage($key)
    {
        $file = $this->getMessageFile();
        if(!isset(self::$cache[$file]) && is_file($file)){
            foreach(file($file) as $content){
                if(trim($content)=='') continue;
                list($id,$message) = explode('=',$content);
                self::$cache[$file][trim($id)] = trim($message);
            }
        }        
        return isset(self::$cache[$file][$key]) ? self::$cache[$file][$key]:$key;
    }            
    
}
