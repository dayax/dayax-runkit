<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core\Token;

use Dayax\Core\Token\Token;

/**
 * ScopeToken class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
abstract class TokenScope extends Token
{
    protected $endTokenId;

    public function getDocblock()
    {
        $tokens = $this->stream->getTokens();

        for ($i = $this->id - 2; $i > $this->id - 6; $i -= 2) {
            if (isset($tokens[$i]) &&
                $tokens[$i]->getType()=='TokenDocComment') {
                return (string)$tokens[$i];
            }
        }
    }

    public function getEndTokenId()
    {
        $block  = 0;
        $i      = $this->id;
        $tokens = $this->stream->getTokens();
        while ($this->endTokenId === NULL && isset($tokens[$i])) {
            if ($tokens[$i]->getType()=='TokenOpenCurly') {
                $block++;
            }
            else if ($tokens[$i]->getType()=='TokenCloseCurly') {
                $block--;
                if ($block === 0) {
                    $this->endTokenId = $i;
                }
            }
            $i++;
        }
        if ($this->endTokenId === NULL) {
            $this->endTokenId = $this->id;
        }
        return $this->endTokenId;
    }

    public function getEndLine()
    {
        return $this->stream[$this->getEndTokenId()]->getLine();
    }
}
