<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/29
 * Time: 14:55
 */

namespace Tools\singleton;


class Method   extends \Thread
{
     public $menthod = null;

     public $class = null;

     public $data = null;

    function __construct($class,$method)
    {
        $this->class = $class;

        $this->menthod = $method;
    }

    function run()
    {
        parent::run();
        $class = $this->class;
        $menthod = $this->menthod;
        $data =  $class->$menthod();
        if ($data){
            $this->data = $data;
        }
    }
}