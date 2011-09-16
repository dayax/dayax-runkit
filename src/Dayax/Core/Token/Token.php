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

/**
 * Token class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
abstract class Token
{    
    protected $text;
    
    protected $line;
    
    protected $id;
    
    /**
     *
     * @var Dayax\Core\Consoletoken\Stream
     */
    protected $stream;
        
    public function __construct($tokenizer,$id,$text,$line)
    {
        $this->id = $id;
        $this->text = $text;
        $this->line = $line;
        $this->stream = $tokenizer;
        $this->initialize();
    }
    
    public function initialize(){}
    
    public function __toString()
    {
        return $this->text;
    }
    
    public function getLine()
    {
        return $this->line;
    }        
    
    public function getType()
    {
        $r = new \ReflectionClass($this);
        return $r->getShortName();
    }
    
    public function getId()
    {
        return $this->id;
    }        
}
