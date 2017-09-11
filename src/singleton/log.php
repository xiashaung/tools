<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/9/11
 * Time: 16:39
 */

namespace Tools\singleton;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class log
 * @package Tools\singleton
 * 单例 实例化monolog日志
 */
class log
{
   private static $log;

    private function __construct(){}


    private function __clone(){}

    public static function logInterface()
    {
        if (!static::$log) {
            return self::$log = new self();
        }else{
            return self::$log;
        }
    }

    public function handle($name)
    {
        return new Logger($name);
    }
}