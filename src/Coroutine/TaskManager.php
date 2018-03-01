<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2018/2/27
 * Time: 16:02
 */

namespace Tools\Coroutine;


class TaskManager
{
    /**
     * @return SystemCall
     * 获取任务id
     */
    public static function getTaskId()
    {
        return new SystemCall(function(Task $task,Scheduler $scheduler){
            $task->setSendValue($task->getTaskId());
            $scheduler->schedule($task);
        });
    }

    /**
     * @param \Generator $generator
     * @return SystemCall
     * 新建任务
     */
    public static function newTask(\Generator $generator)
    {
        return new SystemCall(function(Task $task,Scheduler $scheduler)use($generator){
            $task->setSendValue($scheduler->newTask($generator));
            $scheduler->schedule($task);
        });
    }

    /**
     * @param $tid
     * @return SystemCall
     * 结束一个任务
     */
    public static function killTask($tid)
    {
        return new SystemCall(function(Task $task,Scheduler $scheduler)use($tid){
            $task->setSendValue($scheduler->killTask($tid));
            $scheduler->schedule($task);
        });
    }

//    public function waitForRead($sockets)
//    {
//        return new SystemCall(function(Task $task,Scheduler $scheduler)use($sockets){
//            $task->setSendValue($scheduler->killTask($sockets));
//            $scheduler->schedule($task);
//        });
//    }
//
//    public function waitForWrite($socket) {
//        return new SystemCall(
//            function(Task $task, Scheduler $scheduler) use ($socket) {
//                $scheduler->waitForWrite($socket, $task);
//            }
//        );
//    }
}