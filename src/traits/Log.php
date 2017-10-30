<?php
namespace Tools\traits;

use Monolog\Handler\ChromePHPHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Tools\singleton\logs;
/**
 * Class Log
 * @package Tools\traits
 * 自定义日志类
 */
trait Log
{

    public static  $log;

    protected static $levels = [
        'info'=>Logger::INFO,
        'debug'=>Logger::DEBUG,
        'notice'=>Logger::NOTICE,
        'error'=>Logger::ERROR,
        'alert'=>Logger::ALERT,
    ];

    /**
     * @param $name  string 所属文件夹名
     * @param $level string 级别
     * @param $dirname string 项目名
     * @return Logger 返回logger 对象
     */
    public static  function record($name,$level,$dirname)
    {
        self::$log = logs::logInterface()->handle($name);
        static::checkdir($dirname,$name);
        self::$log->pushHandler(new StreamHandler('/alidata/www/'.$dirname.'/log/'.$name.'/'.$name.'-'.date('Y-m-d').'.log',self::$levels[$level]));
        return self::$log;
    }

    /**
     * 此方法用来把日志输出到chrome控制台
     * @param $name string 调试的项目名
     * @param $level string 级别
     * @return Logger
     */
    public static function chrome($name,$level)
    {
        self::$log = \Tools\singleton\log::logInterface()->handle($name);
        self::$log->pushHandler(new ChromePHPHandler(self::$levels[$level]));
        return self::$log;
    }

    /**
     * @param $dirname string 项目名
     * @param $name  string 文件夹名
     */
    protected static function checkdir($dirname,$name)
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