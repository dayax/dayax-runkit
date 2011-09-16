<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Tests\Core\Token;

use Dayax\Core\Token\Stream;

/**
 * StreamTest class.
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class StreamTest extends \PHPUnit_Framework_TestCase
{    

    protected function setUp()
    {        
        $stream = Stream::factory(__DIR__.'/fixtures/Foo.php');
    }
    
    public function testCaching()
    {                
        
    }
    
}
