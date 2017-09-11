<?php
namespace Tools\traits;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
trait Log
{

    protected static $level;

    public  $log;

    protected static $levels = [
        'info'=>Logger::INFO,
        'debug'=>Logger::DEBUG,
        'notice'=>Logger::NOTICE,
        'error'=>Logger::ERROR,
        'alert'=>Logger::ALERT,
    ];

    public  function records($name,$level,$dirname)
    {
        $this->log = \Tools\singleton\log::logInterface()->handle($name);
        $this->checkdir($dirname,$name);
       $this->log->pushHandler(new StreamHandler('/alidata/www/'.$dirname.'/log/'.$name.'/'.$name.'-'.date('Y-m-d').'.log',self::$level[$level]));
        return $this->log;
    }

    protected function checkdir($dirname,$name)
    {
        if (!file_exists('/alidata/www/'.$dirname.'/log/'.$name)){
            @mkdir('/alidata/www/'.$dirname.'/log/'.$name);
            @chmod('/alidata/www/'.$dirname.'/log/'.$name,0777);
        }
        if (!file_exists('/alidata/www/'.$dirname.'/log/'.$name.'/'.$name.'-'.date('Y-m-d').'.log')){
            @touch('/alidata/www/'.$dirname.'/log/'.$name.'/'.$name.'-'.date('Y-m-d').'.log');
            @chmod('/alidata/www/'.$dirname.'/log/'.$name.'/'.$name.'-'.date('Y-m-d').'.log',0777);
        }
    }
}