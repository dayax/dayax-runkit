<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Tests\Core\Runkit;

use Dayax\Core\Test\TestCase;
use Dayax\Core\Runkit\Manipulator;
use Dayax\Core\Token\Stream;

/**
 * ClassManipulatorTest class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class ManipulatorTest extends TestCase 
{
    /**
     * @var Dayax\Core\Runkit\Manipulator
     */
    protected $m;
    
    protected function setUp()
    {        
        $this->m = new Manipulator('Foo',__DIR__.'/fixtures/source');
    }
    
    /**
     * @expectedException           Dayax\Core\Runkit\Exception
     * @expectedExceptionMessage    Can't manipulate class "Hello". File "World" not exists
     */
    public function testConstructWithFalseFile()
    {        
        $x = new Manipulator('Hello','World');
    }            

    /**
     * @expectedException           Dayax\Core\Runkit\Exception
     * @expectedExceptionMessage    Class definition not exist in file
     */
    public function testConstructWithFalseClass()
    {        
        $x = new Manipulator('Hello',__DIR__.'/fixtures/source');
    }            
    
    public function testAddMethod()
    {
        $this->m = new Manipulator('CFoo',__DIR__.'/fixtures/CFoo.php');
        $def1 = <<<EOC
public function world()
{
    return "Foo World";
}
EOC;
        $def2 = <<<EOC
public function helloWorld()
{
    return "Hello World";
}
EOC;
        $this->m->addMethod($def1);
        $this->m->addMethod($def2);
        $r = new \ReflectionClass($this->m->newInstance());
        $this->assertTrue($r->hasMethod('world'));        
        $this->assertTrue($r->hasMethod('helloWorld'));
    }
    
    
    public function testRedefineMethod()
    {
        $def = <<<EOC
\$bar = "Hello World";
return \$bar;
EOC;
        $ob=$this->m->redefineMethod('hello', $def)->newInstance();
        $this->assertEquals('Hello World',$ob->hello());
    }
    
    public function testNewInstance()
    {
        
    }
}
