<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2018/2/26
 * Time: 13:43
 */

namespace Tools\Coroutine;

/**
 * Class SystemCall
 * @package Tools\Coroutine
 * 通过系统调用 简化代码
 */
class SystemCall
{
    public $callback;

    /**
     * SystemCall constructor.
     * @param callable $callback
     * 系统调用
     */
    public function __construct(callable  $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param Task $task
     * @param Scheduler $scheduler
     * @return mixed
     * 如果把当前类当做函数调用
     */
    public function __invoke(Task $task,Scheduler $scheduler)
    {
        $callback = $this->callback;
        return  $callback($task,$scheduler);
    }
}