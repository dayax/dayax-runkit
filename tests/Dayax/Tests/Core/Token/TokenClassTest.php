<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dayax\Tests\Core\Token;
use Dayax\Core\Token\Stream;
use Dayax\Core\Token\TokenNamespace;

/**
 * NamespaceTest Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class TokenClassTest extends \Dayax\Core\Test\TestCase
{
    /**
     * @dataProvider getTestName
     */
    public function testGetName($file,$shortName,$className)
    {
        $s = Stream::factory($file);        
        $this->assertTrue($s->hasClass($className));
        
        $t = $s->getTokenForClass($className);        
        //$this->assertTrue(is_object($t));
        $this->assertEquals($shortName,$t->getShortName());
        $this->assertEquals($className,$t->getName());
    }
    
    public function getTestName()
    {
        $fixDir = __DIR__.'/fixtures/';
        return array(
            array($fixDir.'classInNamespace.php','TestClass','Foo\\Bar\\TestClass'),
            array($fixDir.'multipleNamespacesWithBrace.php','TestClassInBar','Foo\\Bar\\TestClassInBar'),
            array($fixDir.'multipleNamespacesWithBrace.php','TestClassInBaz','Foo\\Baz\\TestClassInBaz'),
            array($fixDir.'multipleNamespacesWithOneClassUsingBraces.php', 'TestClassInBar', 'Foo\\Bar\\TestClassInBar'),
            array($fixDir.'multipleNamespacesWithOneClassUsingBraces.php', 'TestClassInBaz', 'Foo\\Baz\\TestClassInBaz'),
        );
    }
}

