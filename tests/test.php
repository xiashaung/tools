<?php
require_once "../vendor/autoload.php";
function task1()
{
    for ($i=1;$i<5;$i++){
        echo "task1 runing $i \n";
        yield;
    }
}

function task2()
{
    for ($i=1;$i<8;$i++){
        echo "task2 runing $i \n";
        yield;
    }
}

function getTaskId()
{
    return new \Tools\Coroutine\SystemCall(function(\Tools\Coroutine\Task $task,\Tools\Coroutine\Scheduler $scheduler){
        $task->setSendValue($task->getTaskId());
        $scheduler->schedule($task);
    });
}

function newTask(\Generator $generator)
{
    return new \Tools\Coroutine\SystemCall(function(\Tools\Coroutine\Task $task,\Tools\Coroutine\Scheduler $scheduler)use($generator){
        $task->setSendValue($scheduler->newTask($generator));
        $scheduler->schedule($task);
    });
}

function killTask($tid)
{
    return new \Tools\Coroutine\SystemCall(function(\Tools\Coroutine\Task $task,\Tools\Coroutine\Scheduler $scheduler)use($tid){
        $task->setSendValue($scheduler->killTask($tid));
        $scheduler->schedule($task);
    });
}

function task(){
    $tid = (yield getTaskId());
    $childTid = (yield newTask(childTask()));

    for ($i = 1; $i <= 6; $i++) {
        echo "Parent task $tid iteration $i.\n";
        yield;

        if ($i == 3) yield killTask($childTid);
    }
}

function childTask() {
    $tid = (yield getTaskId());
    while (true) {
        echo "Child task $tid still alive!\n";
        yield;
    }
}


$sch  = new \Tools\Coroutine\Scheduler();

$sch->newTask(task());

$sch->run();
