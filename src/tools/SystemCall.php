<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/19
 * Time: 22:18
 */

namespace Tools\tools;


class SystemCall
{
     protected $callable;

    public function __call(callable  $callable)
    {
        $this->callable = $callable;
    }

    public function __invoke(task $task,Scheduler $scheduler)
    {
        $callable = $this->callable;
        return $callable($task,$scheduler);
    }
}