<?php
set_time_limit(0);
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
use \Tools\singleton\ThreadSingleton;
class abc
{
//    use Log;

    public  $logs;

    public static function add()
    {
        $add  = crypt::crypt_encode('qwewqe');
        return crypt::crypt_decode('qwewqe',$add);
    }

    public function log()
    {
//        $this->logs = $this->record('work','info','admin');
//        $this->logs->alert('asdasdasd',['a'=>'b']);
    }

    public function chromeLog()
    {
//       $this->chrome('work','info')->info('asdsadsadasd');
    }

//    public function push()
//    {
//       $push = new \Tools\jpush\push('17712184635','all',['action'=>2]);
//        $push->all();
//    }
}

//function task1()
//{
//    for ($i=1;$i<=5;$i++){
//        echo "This is task 1 iteration $i.\n";
//        yield;
//    }
//}
//
//function task2()
//{
//    for ($i=1;$i<=10;$i++){
//        echo "This is task 2 iteration $i.\n";
//        yield;
//    }
//}
//\Tools\tools\Thread::run('https://imxs.top?message=记录日志111');

//$th = new ThreadSingleton('https://imxs.top');
//$th->start();
//var_dump($th->datas);

class tests
{
    function index()
    {
        $k = 0;
       for ($i=0;$i<10000;$i++){
            $k += $i;
       }
       return $k;
    }
}

class tests1
{
    function index()
    {
        ini_set('memory_limit',0);
        for ($i=0;$i<1000;$i++){
//            $file = fopen('/users/xiashuang/Desktop/www/tools/tests/test.log','a+');
//            fwrite($file,'测试日志记录'.$i);
//            fclose($file);
        }
        return 11111;
    }
}

class tests2
{
    function index()
    {
        $k = 0;
        for ($i=0;$i<10000;$i++){
            $k += $i;
        }
        return $k;
    }
}

class tests4
{
    function index()
    {
        return '执行过后的方法4';
    }
}
 $tes[] = new tests();
 $tes[] = new tests1();
 $tes[] = new tests2();
 $tes[] = new tests4();
 $tes[] = new tests4();

//echo $test->index();
//$th = \Tools\tools\Thread::method($test,'index');
//echo $th->data;
$s = microtime(true);
foreach ($tes as $k => $v){
    $list[$k] = new \Tools\singleton\Method($v,'index');
    $list[$k]->start();
}
 $arr2 =[];
foreach ($list as $k => $v){
    while($list[$k]->isRunning()){
       usleep(10);
    }
    if ($list[$k]->join()){
        $arr2[] = $list[$k]->data;
    }
}
$e = microtime(true);
echo '多线程'.($e-$s);

//$st = microtime(true);
//foreach ($tes as $k){
//    $arr3 = $k->index();
//}
//$et = microtime(true);
//echo 'for循环'.($et-$st);
echo '<pre>';

//var_dump(\Tools\tools\Thread::run('https://imxs.top'

class  ThisTest extends  TestCase
{
    public function testPthreads()
    {
        $tes[] = new tests();
        $tes[] = new tests1();
        $tes[] = new tests2();
        $tes[] = new tests4();
        $tes[] = new tests4();
        foreach ($tes as $k => $v){
            $list[$k] = new \Tools\singleton\Method($v,'index');
            $list[$k]->start();
        }
        $arr2 =[];
        foreach ($list as $k => $v){
            while($list[$k]->isRunning()){
                usleep(10);
            }
            if ($list[$k]->join()){
                $arr2[] = $list[$k]->data;
            }
        }
    }
}




