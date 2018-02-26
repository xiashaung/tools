<?php
namespace Tools\Coroutine;

/**
 * Class Scheduler
 * @package Tools\Coroutine
 * 多任务调用
 */
class Scheduler
{
    protected $maxTaskId = 0;

    protected $taskMap = []; // taskId => task

    protected $taskQueue;

    /**
     * Scheduler constructor.
     * 创建队列
     */
    public function __construct()
    {
        $this->taskQueue = new \SplQueue();
    }

    /**
     * @param \Generator $generator 迭代器/生成器
     * @return int 返回任务id
     *
     */
    public function newTask(\Generator $generator)
    {
        $id = ++$this->maxTaskId;
        $task = new Task($id, $generator);
        $this->taskMap[$id] = $task;
        $this->schedule($task);
        return $id;
    }

    /**
     * @param Task $task
     * 把任务加入队列
     */
    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    /**
     * 启动任务
     */
    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            //从队列中取出一个任务
            $task = $this->taskQueue->dequeue();
            //开始运行
            $reval = $task->run();

            /**
             * 如果是系统调用
             */
            if ($reval instanceof SystemCall) {
                $reval($task, $this);
                continue;
            }
            //如果运行接口 则删除当前任务 没有则继续加入队列并执行
            if ($task->isFinished()) {
                unset($this->taskMap[$task->getTaskId()]);
            } else {
                $this->schedule($task);
            }
        }
    }

    /**
     * @param $tid
     * @return bool
     * 杀掉一个正在进行的任务
     */
    public function killTask($tid)
    {
       if (!isset($this->taskMap[$tid])){
           return false;
       }

       unset($this->taskMap[$tid]);

        foreach ($this->taskQueue as $k => $task){
            if ($tid==$task->getTaskId()){
                unset($this->taskMap[$k]);
                break;
            }
        }

        return true;
    }
}
