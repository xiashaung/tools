<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/31
 * Time: 16:40
 */
namespace Tools\singleton;
use Tools\singleton\Redis;
set_time_limit(0);
class ApiController  extends \Thread
{
    public $class;

    public $mentod;

    public $data;

    function __construct($class,$mentod)
    {
        $this->class = $class;
        $this->mentod = $mentod;
    }

    function run()
    {
        parent::run();
        $class = $this->class;
        $menthd = $this->mentod;
       $data = $class->$menthd();
         if($data){
            $this->data = serialize($data);
        }
    }
}