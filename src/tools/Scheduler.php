<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/19
 * Time: 21:52
 */

namespace Tools\tools;


class Scheduler
{
    protected $maxTaskId;

    protected $taskMap = [];

    protected $taskQueue;

    public function __construct()
    {
        $this->taskQueue = new \SplQueue();
    }

    public function newTask(\Generator $generator)
    {
        $tid = ++$this->maxTaskId;
        $task = new task($tid,$generator);
        $this->taskMap[$tid] = $task;
        $this->scheduler($task);
        return $tid;
    }

    public function  scheduler(task $task)
    {
        $this->taskQueue->enqueue($task);
    }


    public function run()
    {
        while (!$this->taskQueue->isEmpty()){
            $task = $this->taskQueue->dequeue();
            $rec = $task->run();

            if ($rec instanceof SystemCall){
                $rec($task,$this);
                continue;
            }
            if ($task->isFinished()){
                unset($this->taskMap[$task->getTaskId()]);
            }else{
                $this->scheduler($task);
            }
        }
    }
}