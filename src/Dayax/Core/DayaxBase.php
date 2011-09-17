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

require_once __DIR__.'/Exception.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Dayax\Core\Util\Inflector;
/**
 * DayaxBase Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
abstract class DayaxBase
{
    static protected $loader;
    
    static protected $shortcut = array(        
        'file' => 'Dayax\\Core\\Util\File',
        'inflector'=> 'Dayax\\Core\\Util\\Inflector',
    );
    
    static protected $lang = 'en';
    static protected $cacheDir = null;


    /**
     * @return Symfony\Component\ClassLoader\UniversalClassLoader
     */
    static public function getLoader()
    {
        if(!is_object(self::$loader)){
            if(!class_exists('Symfony\\Component\\ClassLoader\\UniversalClassLoader')){
                require_once __DIR__.'/../../../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
            }
            self::$loader = new UniversalClassLoader();
            self::$loader->registerNamespaces(array(
                'Dayax' => __DIR__.'/../..',
                'Symfony'=>__DIR__.'/../../../vendor/symfony/src'
            ));
        }
        return self::$loader;
    }    
    
    static protected function register()
    {
        spl_autoload_register(array('Dayax\\Core\\DayaxBase','autoload'));
        //register_shutdown_function(array('Dayax\\Core\\DayaxBase','shutdown'));
    }
    
    static public function shutdown()
    {        
        //Exception::writeCacheFile();
    }
    
    static public function autoload($className)
    {
        if(false===strpos($className,'Dayax\\')){
            return;
        }
        if(false===strpos($className,'Exception')){
            return;
        }
        $exp = explode('\\',$className);
        $class = array_pop($exp);
        Exception::factory(implode('\\',$exp));
    }
    
    static public function getLanguage()
    {
        return self::$lang;
    }
    
    static public function getBinDir()
    {
        return realpath(__DIR__.'/../../../bin');
    }
    
    static public function getVendorDir()
    {
        return realpath(__DIR__.'/../../../vendor');
    }
    
    static public function getRootDir()
    {
        return realpath(__DIR__.'/../../..');
    }
    
    /**
     * @return Symfony\Component\Finder\Finder
     */
    static public function finder()
    {
        return new \Symfony\Component\Finder\Finder();
    }
    
    /**
     * @param   mixed A class name or a manipulator object
     * @return Dayax\Core\Runkit\ReflectionClass
     */
    static public function reflection($className)
    {
        return new \Dayax\Core\Runkit\ReflectionClass($className);
    }
    
    /**
     * Create new manipulator
     * @param   string $className
     * @param   string $sourceFile
     * @return Dayax\Core\Runkit\Manipulator 
     */
    static public function manipulator($className,$sourceFile)
    {
        return new \Dayax\Core\Runkit\Manipulator($className, $sourceFile);
    }
    
    static public function __callStatic($name,$args)
    {
        $exp = explode('_', Inflector::underscore($name));
        $sname = array_shift($exp);
        $method = implode('',$exp);        
        if(!isset(self::$shortcut[$sname])){
            throw new Exception('dayax.shortcut_unregistered',$sname);
        }
        $class = self::$shortcut[$sname];
        $r = new \ReflectionClass($class);
        if(''==$method){
            return $r->newInstanceArgs($args);
        }else{            
            if(!$r->hasMethod($method)){
                throw new Exception('dayax.shortcut_invalid_method',$name,$class,$method);
            }
            return call_user_func_array(array($class,$method), $args);
        }        
    }
   
    static public function registerShortcut($name,$class)
    {
        if(!class_exists($class)){
            throw new Exception('dayax.shortcut_invalid_class',$name,$class);
        }
        self::$shortcut[$name] = $class;
    }

    static public function getCacheDir()
    {
        if(is_null(self::$cacheDir)){
            self::$cacheDir = self::getRootDir().'/cache';            
        }
        if(!is_dir(self::$cacheDir)){
            mkdir(self::$cacheDir, 0777, true);
        }
        return self::$cacheDir;
    }
    
    static public function setCacheDir($dir)
    {        
        if(!is_dir($dir)){
            $parent = dirname($dir);
            if(!is_dir($parent)){
                throw new Exception('dayax.invalid_cache_dir',$dir,$parent);
            }
            if(!is_writable($parent)){
                throw new Exception('dayax.cache_dir_unwritable',$dir,$parent);
            }
            mkdir($dir);
        }
        self::$cacheDir = $dir;
    }
    
    static public function initialize()
    {
        static $initialized = false;
        if($initialized){
            return;
        }
        self::getLoader()->register();
        self::register();
        Exception::readCacheFile();
        $initialized = true;
    }
}
