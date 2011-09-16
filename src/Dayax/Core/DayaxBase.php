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

/**
 * DayaxBase Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
abstract class DayaxBase
{
    static protected $loader;
    
    static protected $shortcut = array();
    
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
            self::$loader->register();
                    
        }
        return self::$loader;
    }    
    
    static public function registerShortcut($class)
    {
        
    }
    
    static public function getBinDir()
    {
        return realpath(__DIR__.'/../../../bin');
    }
    
    static public function getVendorDir()
    {
        return realpath(__DIR__.'/../../../vendor');
    }
    
    static public function __callStatic($name,$args)
    {
        
    }
    
    /**
     * @return Symfony\Component\Finder\Finder
     */
    static public function finder()
    {
        return new \Symfony\Component\Finder\Finder();
    }
   
}
