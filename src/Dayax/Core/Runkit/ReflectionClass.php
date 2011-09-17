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

/**
 * ReflectionClass class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class ReflectionClass extends \ReflectionClass
{
    public function __construct($className)
    {
        $className = $this->initializeClass($className);
        parent::__construct($className);
    }
    
    protected function initializeClass($className)
    {
        if($className instanceof Manipulator){
            $m = $className;
        }else{
            if(class_exists($className,false)){
                $r = new \ReflectionClass($className);
                $file = $r->getFileName();
            }else{
                $file = \dx::getLoader()->findFile($className);
            }
            if(!is_file($file)){
                throw new Exception('reflection.file_not_found',$className,$file);
            }
            $m = new Manipulator($className,$file);
        }
        $m->declareClass();
        return $m->getGeneratedName();
    }
}
