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
use Dayax\Core\Runkit\ReflectionClass;

/**
 * ClassManipulator class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class Manipulator
{
    protected $className;
    protected $sourceFile;
    
    protected $sources = array();
    
    protected $generatedName    = "";
    
    protected $isMethodAdded = false;
    
    static protected $cacheDir = null;        
    
    /**
     * @var Dayax\Core\Token\TokenClass
     */
    protected $cToken = null;
    
    protected $classDef = array();
    
    protected $methodDef = array();
    
    protected $onEval = false;
    
    protected $buffer = '';
    
    public function __construct($className, $sourceFile)
    {        
        if(!is_file($sourceFile)){
            throw new Exception('runkit.file_not_exists',$className,$sourceFile);
        }        
        $this->compiler = new Compiler($sourceFile);        
        $this->className = $this->generatedName = $className; 
        $this->classDef = $this->compiler->getClassDefinition($className);
        $this->cToken = $this->compiler->getTokenForClass($className);
        $this->methodDef = $this->classDef['methods'];
        $this->sources = @file($sourceFile);
        $this->sourceFile = $sourceFile;
        if (false===$this->compiler->getClassDefinition($className)) {
            throw new Exception('runkit.class_not_exists', $className, $sourceFile);
        }
        $this->changeClassName('###CLASS_NAME###');
    }        
    
    static public function setCacheDir($dir)
    {
        if(!is_dir($dir)){
            if(!@mkdir($dir,0777,true)){
                throw new Exception('manipulator.cache_dir_unwritable');
            }
        }
        self::$cacheDir = $dir;
    }
    
    public function redefineMethod($methodName,$definition)
    {   
        $token = $this->compiler->getTokenForMethod($this->className, $methodName);
        $definition = $this->indent($this->calcIndent($this->sources[$token->getLine()+1]),$definition);
        
        $this->compiler->replaceLine($token->getLine()+2, $definition);
        if($token->getLine()+2!==$token->getEndLine()-1){
            $this->compiler->ignoreLines(range($token->getLine()+2,$token->getEndLine()-1));
        }
        return $this;
    }
    
    /**
     * @return Dayax\Core\Runkit\Compiler
     */
    protected function changeClassName($newClassName)
    {
        $token = $this->cToken;        
        $this->compiler->changeToken($token->getId()+2,$newClassName);        
        return $this;
    }
    
    protected $compiled = null;
    
    public function getCompiled()
    {
        $this->compile();
        $this->compiled = strtr($this->compiled, array(
            '###CLASS_NAME###' => $this->generatedName
        ));
        return $this->compiled;
    }        
    
    protected function hash($text)
    {
        return hash('crc32',$text);
    }
    
    protected function getCacheFileName($file,$line)
    {                
        $dir = self::$cacheDir.DIRECTORY_SEPARATOR.$this->hash(dirname($this->sourceFile)).DIRECTORY_SEPARATOR.basename($this->sourceFile,'.php');
        $fileName = $this->hash($line.' '.$file);        
        return $dir.DIRECTORY_SEPARATOR.$fileName.'.meta';
    }
    
    protected function getCache()
    {
        $stack = debug_backtrace();
        $file = $line = null;
        for ($i = 0; $i < count($stack); $i++) {
            $cs = $stack[$i];
            if (isset($cs['file']) && ($cs['file'] !== __FILE__)) {
                $file = $cs['file'];
                $line = $cs['line'];
                break;
            }
        }
        $cacheFile = $this->getCacheFileName($file, $line);        
        if((filemtime($this->sourceFile) >  @filemtime($cacheFile))||(filemtime($file)>  filemtime($cacheFile))){
            if(!is_dir($dir=dirname($cacheFile))){
                @mkdir($dir,0777,true);
            }            
            file_put_contents($cacheFile, $this->doCompile(),LOCK_EX);
            chmod($cacheFile,0777);            
        }
        return file_get_contents($cacheFile);
    }
    
    protected function compile()
    {
        if(!is_dir(self::$cacheDir)){            
            $this->compiled = $this->doCompile();            
        }else{            
            $this->compiled = $this->getCache();
        }
        
    }
    
    protected function doCompile()
    {
        return $this
            ->compiler
            ->stripPhpTags()
            ->getCompiled();
    }
    
    public function newInstance()
    {           
        register_shutdown_function(array($this,'shutdown'));        
        $buffer = $this->getCompiled();       
        $this->onEval = true;
        $this->buffer = $buffer;
        if(false===@eval($buffer)){
            throw new Exception("failed to eval \n".$buffer);
        }        
        $this->onEval = false;
        $this->buffer = '';
        
        $args = func_get_args();
        $r = new \ReflectionClass($this->generatedName);
        if(is_object($r->getConstructor())){
            return $r->newInstanceArgs($args);
        }else{
            return $r->newInstance();
        }        
    }
    
    public function shutdown()
    {
        if(false===$this->onEval){
            return;
        }
        print_r(error_get_last());
        echo $this->buffer;
    }
            
    public function addMethod($definition)
    {                
        $def = $this->methodDef;
        $names = array_keys($def);
        $name = array_pop($names);
        $token = $this->compiler->getTokenForMethod($this->className, $name);        
        $line = $token->getEndLine();        
        $indent = $this->calcIndent($this->sources[$token->getLine()-1]);
        
        if(!$this->isMethodAdded){
            $this->compiler->replaceLine($line, $this->indent($indent, "}"));
            $this->isMethodAdded = true;
        }
        $this->compiler->replaceLine($line, $this->indent($indent,$definition));
        return $this;
    }
    
    protected function calcIndent($text)
    {        
        return substr($text,0,strlen($text)-strlen(ltrim($text)));
    }
    
    protected function indent($indent,$text)
    {
        $exp = explode("\n",$text);
        $texts = array();
        foreach($exp as $text){
            $texts[] = "\n".$indent.$text;
        }                
        return implode("",$texts);
    }
    
    public function useUniqueName()
    {
        $this->generatedName = uniqid($this->className."_");        
        return $this;
    }
}
