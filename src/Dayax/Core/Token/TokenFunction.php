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

use Dayax\Core\Token\TokenScope;

/**
 * TokenFunction class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class TokenFunction extends TokenScope
{

    protected $arguments;
    protected $ccn;
    protected $name;
    protected $signature;

    public function getArguments()
    {
        if ($this->arguments !== NULL) {
            return $this->arguments;
        }

        $this->arguments = array();
        $i = $this->id + 3;
        $tokens = $this->stream->getTokens();
        $typeHint = NULL;

        while ($tokens[$i]->getType()!='TokenCloseBracket') {
            if ($tokens[$i]->getType()=='TokenString') {
                $typeHint = (string) $tokens[$i];
            } else if ($tokens[$i]->getType()=='TokenVariable') {
                $this->arguments[(string) $tokens[$i]] = $typeHint;
                $typeHint = NULL;
            }

            $i++;
        }

        return $this->arguments;
    }

    public function getName()
    {
        if ($this->name !== NULL) {
            return $this->name;
        }

        $tokens = $this->stream->getTokens();

        if ($tokens[$this->id + 2]->getType()=='TokenString') {
            $this->name = (string) $tokens[$this->id + 2];
        } else if ($tokens[$this->id + 2]->getType()=='TokenAmpersand' &&
                $tokens[$this->id + 3]->getType()=='TokenString') {
            $this->name = (string) $tokens[$this->id + 3];
        } else {
            $this->name = 'anonymous function';
        }

        return $this->name;
    }

    public function getCCN()
    {
        if ($this->ccn !== NULL) {
            return $this->ccn;
        }

        $this->ccn = 1;
        $end = $this->getEndTokenId();
        $tokens = $this->stream->getTokens();

        for ($i = $this->id; $i <= $end; $i++) {
            $r = new \ReflectionClass($tokens[$i]);            
            switch ($r->getShortName()) {
                case 'TokenIf':
                case 'TokenElseif':
                case 'TokenFor':
                case 'TokenForeach':
                case 'TokenWhile':
                case 'TokenCase':
                case 'TokenCatch':
                case 'TokenBooleanAnd':
                case 'TokenLogicalAnd':
                case 'TokenBooleanOr':
                case 'TokenLogicalOr':
                case 'TokenQuestionMark': {
                        $this->ccn++;
                }
                break;
            }
        }

        return $this->ccn;
    }

    public function getSignature()
    {
        if ($this->signature !== NULL) {
            return $this->signature;
        }

        $this->signature = '';

        $i = $this->id + 2;
        $tokens = $this->stream->getTokens();        
        while ($tokens[$i]->getType()!='TokenCloseBracket') {            
            $this->signature .= $tokens[$i++];
        }

        $this->signature .= ')';

        return $this->signature;
    }

}