<?php
require_once "../vendor/autoload.php";
function task1()
{
    echo 'wait start'.PHP_EOL;
    for ($i=1;$i<10;$i++){
        sleep($i);
        yield $i;
    }

    echo 'wait end'.PHP_EOL;
}

function task2()
{
//    for ($i=1;$i<8;$i++){
//        echo "task2 runing $i \n";
//        yield;
//    }

    echo '没有'.PHP_EOL;
    yield;
    echo '阻塞'.PHP_EOL;
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


//function task(){
//    $tid = (yield getTaskId());
//    $childTid = (yield newTask(childTask()));
//
//    for ($i = 1; $i <= 6; $i++) {
//        echo "Parent task $tid iteration $i.\n";
//        yield;
//
//        if ($i == 3) yield killTask($childTid);
//    }
//}

function childTask() {
    $tid = (yield getTaskId());
    while (true) {
        echo "Child task $tid still alive!\n";
        yield;
    }
}

$st = microtime(true);
$sch  = new \Tools\Coroutine\Scheduler();

$sch->newTask(task1());
$sch->newTask(task2());

$sch->run();

echo microtime(true) - $st.PHP_EOL;


function task3()
{
    echo 'wait start'.PHP_EOL;
    for ($i=1;$i<10;$i++){
        sleep($i);
    }

    echo 'wait end'.PHP_EOL;
}

function task4()
{
//    for ($i=1;$i<8;$i++){
//        echo "task2 runing $i \n";
//        yield;
//    }

    echo '没有'.PHP_EOL;
//    yield;
    echo '阻塞'.PHP_EOL;
}
$st3 = microtime(true);
task3();

task4();
echo microtime(true) - $st3.PHP_EOL;
