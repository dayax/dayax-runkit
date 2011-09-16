<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core\Runkit;

use Dayax\Core\Runkit\Exception;
use Dayax\Core\Token\Stream;

/**
 * Compiler class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class Compiler
{
    protected $source;
    
    protected $stripComments = true;
    
    protected $stripPhpTags = false;        
    
    protected $ignoredLines = array();
    protected $replacedLines = array();
    protected $strippedLines = array();
    protected $changedToken = array();    
    
    protected $compiled = '';
    
    protected $isCompiled = false;
    
    /**
     * @var Stream
     */
    protected $stream;
    
    public function __construct($source=null)
    {
        if(!is_null($source)){
            $this->setSource($source);
        }
    }    
    
    public function setSource($source)
    {
        if(is_file($source)){
            if(!is_readable($source)){
                throw new Exception('runkit.compiler.file_not_readable',$source);
            }
        }
        $this->source = file_get_contents($source);
        $this->stream = Stream::factory($source);
        return $this;
    }
    
    public function stripComments()
    {
        $this->stripComments = true;        
        return $this;
    }
    
    public function unstripComments()
    {
        $this->stripComments = false;        
        return $this;
    }
    
    public function stripPhpTags()
    {
        $this->stripPhpTags = true;        
        return $this;
    }
    
    public function unstripPhpTags()
    {
        $this->stripPhpTags = false;        
        return $this;
    }  
    
    public function ignoreLines($lines)
    {        
        $this->ignoredLines = array_merge($this->ignoredLines,(array) $lines);        
        return $this;
    }
    
    public function replaceLine($line, $contents)
    {
        
        if(!isset($this->replacedLines[$line])) $this->replacedLines[$line] = array();
        $this->replacedLines[$line]= array_merge($this->replacedLines[$line],(array)$contents);
        return $this;
    }
    
    public function stripLines($lines)
    {
        $this->strippedLines = array_merge($this->strippedLines,(array) $lines);
        return $this;
    }
    
    public function changeToken($id,$token)
    {
        $this->changedToken[$id] = $token;
        return $this;
    }
    
    public function getCompiled()
    {
        $this->compile();        
        return $this->compiled;
    }
    
    /**
     * @param string $name 
     * @return Dayax\Core\Token\TokenClass
     */
    public function getTokenForClass($name)
    {
        $classes = $this->stream->getClasses();        
        if(isset($classes[$name])){
            $id = $classes[$name]['id'];
            return $this->stream[$id];
        }else{
            return null;
        }
    }
    
    /**
     * @param string $className
     * @param string $methodName 
     * @return Dayax\Core\Token\TokenFunction
     */   
    public function getTokenForMethod($className,$methodName)
    {
        if(false===$this->stream->hasClass($className)) return false;
        $def = $this->stream->getClassMethod($className, $methodName);
        return $this->stream[$def['id']];
    }
        
    public function getClassDefinition($className)
    {
        return $this->stream->getClass($className);
    }
    
    /**
     * @param   integer $id
     * @return  Dayax\Core\Token\Token
     */
    public function getToken($id)
    {
        return isset($this->stream[$id]) ? $this->stream[$id]:false;
    }
    
    
    protected function compile()
    {        
        $ignored = array();
        $rLines = $this->replacedLines;
        $iLines = $this->ignoredLines;
        $sLines = $this->strippedLines;
        $cToken = $this->changedToken;
        $this->compiled = '';  
        
        foreach($this->stream as $id=>$token){
            $type = $token->getType();
            $line = $token->getLine();            
            if(isset($rLines[$line]) && $type!=='TokenWhitespace'){                
                $token = implode("",$rLines[$line]);
                unset($rLines[$line]);
                $sLines[] = $line;
            }elseif(in_array($line,$sLines)){
                continue;
            }elseif(in_array($type,array('TokenComment','TokenDocComment')) && $this->stripComments){
                continue;
            }elseif($this->stripPhpTags && in_array($type,array('TokenOpenTag','TokenCloseTag'))){
                continue;
            }elseif(in_array($line,array_merge($ignored,$this->ignoredLines))){
                continue;
            }elseif(isset($cToken[$id])){
                $token = $cToken[$id];
            }            
            $this->compiled .= $token;
        }
        /* remove unnecessary empty line */
        $this->compiled=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", PHP_EOL, $this->compiled);        
        $this->isCompiled = true;
    }
    
    
    
}
