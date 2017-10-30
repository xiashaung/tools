<?php
namespace Tools\singleton;

use Monolog\Logger;

/**
 * Class log
 * @package Tools\singleton
 * 单例 实例化monolog日志
 */
class logs
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