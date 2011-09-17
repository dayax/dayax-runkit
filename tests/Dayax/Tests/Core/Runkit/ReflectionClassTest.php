<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Dayax\Core\Runkit\ReflectionClass;

/**
 * ReflectionClass Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class ReflectionClassTest extends Dayax\Core\Test\TestCase
{
    public function testConstruct()
    {                
        //$this->assertTrue(is_object(\dx::reflection('Dayax\\Core\\DayaxBase')),'Construct with class name.');
        
        $file = __DIR__.'/fixtures/TestReflection.php';
        $m = \dx::manipulator('TestReflection',$file);
        $this->assertTrue(is_object(\dx::reflection($m)),'Construct with manipulator object.');        
    }
}

