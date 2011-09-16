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

use Dayax\Core\Runkit\Compiler;

/**
 * CompilerTest class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class CompilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Compiler
     */
    protected $c;
    
    public function setUp()
    {
        $this->c = new Compiler(__DIR__.'/fixtures/source');
        
    }
    
    public function testStripComments()
    {        
        $this->assertStringEqualsFile(__DIR__.'/fixtures/sWithStrippedComments', $this->c->getCompiled());
    }
    
    public function testStripPhpTags()
    {   
        $this->c->stripPhpTags();
        $this->assertStringEqualsFile(__DIR__.'/fixtures/sWithStrippedPhpTags', $this->c->getCompiled());
    }
    
    public function testIgnoreLine()
    {
        $this->c->ignoreLines(21);
        $this->assertStringEqualsFile(__DIR__.'/fixtures/sWithIgnoreLine', $this->c->getCompiled());
    }
    
    public function testReplaceLine()
    {
        $this->c->replaceLine(21, 'return "Foo Bar";');
        $this->assertStringEqualsFile(__DIR__.'/fixtures/sWithReplaceLine', $this->c->getCompiled());
    }    
}
