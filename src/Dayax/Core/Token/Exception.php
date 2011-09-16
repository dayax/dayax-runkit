<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core\Token;

/**
 * Exception Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class Exception extends \Dayax\Core\Exception
{
    public function getMessageDir()
    {
        return __DIR__.'/Resources/messages';
    }
}

