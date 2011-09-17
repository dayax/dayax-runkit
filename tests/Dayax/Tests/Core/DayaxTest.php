<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Tests\Core;

class Foo
{
    protected $argument = null;
    
    public function __construct($argument=null)
    {
        $this->argument = $argument;
    }
    static public function bar($argument = null)
    {
        return is_null($argument) ? 'bar':$argument;
    }        
    
    public function hello()
    {
        return is_null($this->argument) ? 'Hello World':$this->argument;
    }
}

/**
 * DayaxTest Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class DayaxTest extends \PHPUnit_Framework_TestCase
{    
    public function testShortcut()
    {
        \dx::registerShortcut('foo', 'Dayax\\Tests\\Core\\Foo');
        
        $this->assertEquals('bar',\dx::fooBar(),'Shortcut is calling static method.');
        $this->assertEquals('Foo Bar',\dx::fooBar('Foo Bar'),'Shortcut is called with parameter.');
        $this->assertTrue(is_object(\dx::foo()), 'Shortcut returning new object');
        $this->assertEquals('Hello World',\dx::foo()->hello(),'Shortcut called object method');
        $this->assertEquals('Foo Bar',\dx::foo('Foo Bar')->hello(),'Shortcut passed constructor arguments');
    }
    
    /**
     * @expectedException           Dayax\Core\Exception
     * @expectedExceptionMessage    Please ensure that "/foo" directory is exists
     */
    public function testSetCacheDirInvalidParentDir()
    {
        \dx::setCacheDir('/foo/test');
    }

    /**
     * @expectedException           Dayax\Core\Exception
     * @expectedExceptionMessage    Please ensure that "/" directory is writable.
     */
    public function testSetCacheDirUnwritableParentDir()
    {
        \dx::setCacheDir('/foo');
    }

}

