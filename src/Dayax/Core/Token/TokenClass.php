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
 * ClassToken class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class TokenClass extends TokenScope
{
    protected $tokenNamespace;
    protected $className = null;
    public function setTokenNamespace(TokenNamespace $token)
    {
        $this->tokenNamespace = $token;
        $ns = (string)$token->getName();        
        $this->className = $ns."\\".$this->getShortName();        
    }
        
    public function getName()
    {        
        return is_null($this->className) ? $this->getShortName():$this->className;
    }
    
    public function getShortName()
    {
        return (string)$this->stream[$this->id + 2];
    }
    
    public function hasParent()
    {
        return $this->stream[$this->id + 4]->getType()=='TokenExtends';
    }

    public function getParent()
    {
        if (!$this->hasParent()) {
            return FALSE;
        }
        $i         = $this->id + 6;
        $tokens    = $this->stream->tokens();
        $className = (string)$tokens[$i];
        while (!$tokens[$i+1]->getType()=='TokenWhitespace') {
            $className .= (string)$tokens[++$i];
        }
        return $className;
    }
}
