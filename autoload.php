<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.munthi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/src/Dayax/Core/DayaxBase.php';

use Dayax\Core\DayaxBase;

class dx extends DayaxBase
{
    
}

dx::getLoader()->register();

\Dayax\Core\Runkit\Manipulator::setCacheDir(__DIR__.'/cache/manipulator');
\Dayax\Core\Token\Stream::setCacheDir(__DIR__.'/cache/manipulator');