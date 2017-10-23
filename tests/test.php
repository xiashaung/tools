<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/9/11
 * Time: 14:56
 */
require '../vendor/autoload.php';
use Tools\traits\crypt;
use Tools\traits\Log;
use Tools\singleton\Redis;
use Tools\tools\tools;
class abc
{
    use crypt,Log;

    public  $logs;

    public static function add()
    {
        $add  = crypt::crypt_encode('qwewqe');
        return crypt::crypt_decode('qwewqe',$add);
    }

    public function log()
    {
        $this->logs = $this->record('work','info','admin');
        $this->logs->alert('asdasdasd',['a'=>'b']);
    }

    public function chromeLog()
    {
       $this->chrome('work','info')->info('asdsadsadasd');
    }

//    public function push()
//    {
//       $push = new \Tools\jpush\push('17712184635','all',['action'=>2]);
//        $push->all();
//    }
}

function task1()
{
    for ($i=1;$i<=5;$i++){
        echo "This is task 1 iteration $i.\n";
        yield;
    }
}

function task2()
{
    for ($i=1;$i<=10;$i++){
        echo "This is task 2 iteration $i.\n";
        yield;
    }
}

var_dump(\Tools\tools\Request::input());
 echo '<pre>';

