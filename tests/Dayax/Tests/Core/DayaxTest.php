<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core\Test;

/**
 * DayaxTest Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class DayaxTest extends \PHPUnit_Framework_TestCase
{
    public function testLoader()
    {
        $mock=$this->getMockForAbstractClass('Dayax\Core\DayaxBase');             
        ;
        $mock->expects($this->any())
             ->method('getFoo')
             ->will($this->returnValue(true))
        ;        
        $this->assertTrue(is_object($mock->getLoader()));        
    }    
}

