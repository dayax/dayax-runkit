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
class TokenNamespaceTest extends \Dayax\Core\Test\TestCase
{
    /**
     * @covers TokenNamespace::getName
     */
    public function testGetName()
    {
        $s = Stream::factory(__DIR__.'/fixtures/classInNamespace.php');
        foreach ($s as $token) {
            if ($token instanceof TokenNamespace) {
                $this->assertSame('Foo\\Bar', $token->getName());
            }
        }
    }
}

