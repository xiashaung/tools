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

//  $abc = new abc();
//$abc->log();
//$abc->chromeLog();

echo Redis::set('a','abcd',4);
