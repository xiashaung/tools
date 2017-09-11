<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/9/11
 * Time: 14:56
 */
require '../../vendor/autoload.php';
use Tools\traits\crypt;
use Tools\traits\Log;

class abc
{
    use crypt,Log;

    public static function add()
    {
        $add  = crypt::crypt_encode('qwewqe',1);
        return crypt::crypt_decode('qwewqe',$add);
    }

    public function log()
    {
       $this->records('work','info','admin')->addInfo('这是个日志类');
    }
}

  $abc = new abc();
$abc->log();
