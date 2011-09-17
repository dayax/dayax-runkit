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
 * Tokenizer class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class Stream implements \ArrayAccess,  \Countable,  \SeekableIterator
{
    protected $customTokens = array(
        '(' => 'TokenOpenBracket',
        ')' => 'TokenCloseBracket',
        '[' => 'TokenOpenSquare',
        ']' => 'TokenCloseSquare',
        '{' => 'TokenOpenCurly',
        '}' => 'TokenCloseCurly',
        ';' => 'TokenSemicolon',
        '.' => 'TokenDot',
        ',' => 'TokenComma',
        '=' => 'TokenEqual',
        '<' => 'TokenLt',
        '>' => 'TokenGt',
        '+' => 'TokenPlus',
        '-' => 'TokenMinus',
        '*' => 'TokenMult',
        '/' => 'TokenDiv',
        '?' => 'TokenQuestionMark',
        '!' => 'TokenExclamationMark',
        ':' => 'TokenColon',
        '"' => 'TokenDoubleQuotes',
        '@' => 'TokenAt',
        '&' => 'TokenAmpersand',
        '%' => 'TokenPercent',
        '|' => 'TokenPipe',
        '$' => 'TokenDollar',
        '^' => 'TokenCaret',
        '~' => 'TokenTilde',
        '`' => 'TokenBacktick'
    );
    
    protected $source;
    protected $sourceFileName = null;
    protected $sourceHash= null;
    
    protected $tokens = null;
    
    protected $classes = null;
    
    protected $functions = null;
    
    protected $classTokens = array();        
        
    protected $isParsed = false;            
    
    private function __construct($fileName)
    {
        $this->sourceFileName = $fileName;
        $this->source = file($fileName);
        $this->parse();        
    }
    
    public function getTokens()
    {
        return $this->tokens;
    }
    
    protected function parse()
    {                                    
        $line = 1;
        $tokens = token_get_all(file_get_contents($this->sourceFileName));
        $numTokens = count($tokens);
        for($i=0;$i<$numTokens;$i++){
            $token = $tokens[$i];
            unset($tokens[$i]);
            if(is_array($token)){
                $text = $token[1];
                $name = substr(token_name($token[0]),2);
                $exp=explode("_",$name);
                array_walk($exp, create_function('&$v,$k','$v=ucfirst(strtolower($v));'));                
                $tokenClass = 'Token'.implode('',$exp);
            }else{
                $text = $token;
                $tokenClass =$this->customTokens[$token];
            }
            $lines = substr_count($text,"\n");
            $line += $lines;
            $ob = $this->createToken($tokenClass,$text,$line,$i);
            $this->tokens[]=$ob;
        }
        $this->parseNamespaces();
        $this->parseClassesFunctions();
        $this->isParsed = true;
        
    }
    
    static protected function generateTokenDefinition($class)
    {        
        $definition = <<<EOC
namespace Dayax\Core\Token;
use Dayax\Core\Token\Token;
class $class extends Token
{    
}
EOC;
        
        return $definition;
    }

    protected function createToken($tokenClass,$text,$line,$i)
    {
        try{
            $class = 'Dayax\Core\Token\\'.$tokenClass;            
            return new $class($this,$i,$text,$line);
        }catch(Exception $e){
            
        }
        
    }    
    
    protected function parseNamespaces()
    {        
        $cNamespace = false;        
        foreach($this->tokens as $token){
            switch($token->getType()){
                case 'TokenNamespace':
                    $cNamespace = $token;               
                    break;
                case 'TokenClass':                    
                    if(is_object($cNamespace)) $token->setTokenNamespace($cNamespace);                
                    break;
            }
        }
    }
    
    protected function parseClassesFunctions()
    {        
        $this->classes = array();
        $this->functions = array();
        $class = false;
        $classEndLine = false;
        foreach($this->tokens as $token){
            switch($token->getType()){
                case 'TokenClass':{
                    $class = $token->getName();
                    $classEndLine = $token->getEndLine();                    
                    $this->classes[$class] = array(
                        'methods'   => array(),
                        'docblock'  => $token->getDocBlock(),
                        'startLine' => $token->getLine(),
                        'endLine'   => $classEndLine,
                        'id'        => $token->getId(),                        
                    );
                    $this->classTokens[$class] = $token;                    
                }
                break;
                case 'TokenFunction':{
                    $name = $token->getName();
                    $tmp = array(
                        'docblock'  => $token->getDocBlock(),
                        'signature' => $token->getSignature(),
                        'startLine' => $token->getLine(),
                        'endLine'   => $token->getEndLine(),
                        'ccn'       => $token->getCCN(),
                        'id'        => $token->getId(),
                    );
                    if($class===FALSE){
                        $this->functions[$name] = $tmp;
                    }else{
                        $this->classes[$class]['methods'][$name] = $tmp;
                    }
                }
                break;
                case 'TokenCloseCurly':{
                    if(
                            $classEndLine!==false && 
                            $classEndLine==$token->getLine()
                    ){
                        $class = FALSE;
                        $classEndLine = FALSE;
                    }
                }
                break;
            }
        }
    }
    
    public function count()
    {
        return count($this->tokens);
    }  
    
    public function rewind()
    {
        $this->pos = 0;
    }
    
    public function valid()
    {
        return isset($this->tokens[$this->pos]);
    }
    
    public function key()
    {
        return $this->pos;
    }
    
    public function current()
    {
        return $this->tokens[$this->pos];
    }
    public function next()
    {
        $this->pos++;
    }
    
    public function offsetExists($offset)
    {
        return isset($this->tokens[$offset]);
    }
    
    public function offsetGet($offset)
    {
        return $this->tokens[$offset];
    }
    
    public function offsetSet($offset,$value)
    {
        $this->tokens[$offset] = $value;
    }
    
    public function offsetUnset($offset)
    {
        unset($this->tokens[$offset]);
    }
    
    public function seek($position)
    {
        $this->pos = $position;
        if(!$this->valid()){
            throw new \OutOfBoundsException('Invalid seek position.');
        }
    }
    
    public function getClasses()
    {     
        return $this->classes;
    }
    
    public function getClass($className)
    {
        return isset($this->classes[$className]) ? $this->classes[$className]:false;
    }
    
    public function getTokenForClass($className)
    {
        
        return isset($this->classTokens[$className]) ? $this->classTokens[$className]:false;
    }
    
    public function getClassMethod($className,$method)
    {
        if(isset($this->classes[$className])){
            return $this->classes[$className]['methods'][$method];
        }
    }
    
    public function hasClass($className)
    {
        $classes = $this->getClasses();
        return isset($classes[$className]);
    }
    
    public function getLineContent($line)
    {
        return $this->source[$line-1];
    }
    
    static public function setCacheDir($dir)
    {
        if(!is_writable($dir)){
            throw new Exception('cache_dir_unwritable',$dir);
        }
        self::$cacheDir = $dir;
    }
    
    static public function getCacheDir()
    {
        return self::$cacheDir;
    }
    
    /**
     *
     * @param       string $fileName
     * @return      Dayax\Core\Token\Stream
     */
    static public function factory($sourceFile)
    {   
        static $isRegistered = false;        
        if(!$isRegistered){
            spl_autoload_register(array('Dayax\Core\Token\Stream','autoload'));
        }
        if(!is_file($sourceFile)){
            throw new Exception('stream.file_unreadable',$fileName);
        }
        $cDir = \dx::getCacheDir().'/stream';
        $file = hash('crc32', dirname($sourceFile)) . DIRECTORY_SEPARATOR . basename($sourceFile, '.php') . '.meta.class';
        $cacheFile = $cDir . DIRECTORY_SEPARATOR . $file;
        clearstatcache();
        if (!is_file($cacheFile) || (filemtime($sourceFile) > filemtime($cacheFile))) {
            if (!is_dir($dir = dirname($cacheFile))) {
                mkdir($dir,0777,true);
            }
            $ob = new self($sourceFile);
            file_put_contents($cacheFile, serialize(array($ob)), LOCK_EX);
        }
        $data = unserialize(file_get_contents($cacheFile, LOCK_EX));
        $ob = $data[0];
        
        return $ob;        
    }
    
    static public function autoload($class)
    {
        $ns = 'Dayax\\Core\\Token';        
        if(false===strpos($class,$ns)){
            return;
        } 
        $cName = str_replace($ns.'\\', '', $class)."\n";
        eval(self::generateTokenDefinition($cName));
    }        
}
