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
use Dayax\Core\Token\Token;

/**
 * TokenNamespace Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class TokenNamespace extends TokenScope
{
    protected $name;
    
    public function initialize()
    {                        

    }

    
    public function getName()
    {   
        if(is_null($this->name)){
            $tokens = $this->stream->getTokens();
            $namespace = (string) $tokens[$this->id + 2];
            for ($i = $this->id + 3;; $i += 2) {
                if (isset($tokens[$i]) &&
                        $tokens[$i] instanceof TokenNsSeparator) {
                    $namespace .= '\\' . $tokens[$i + 1];
                } else {
                    break;
                }
            }
            $this->name = $namespace;
        }
        return $this->name;
    }    
}

