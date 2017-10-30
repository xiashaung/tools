<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/28
 * Time: 08:59
 */

namespace Tools\tools;


class swoole
{
    public static $swoole = null;
     public function  __construct()
     {
         if (!self::$swoole)self::$swoole = new \swoole_http_client('127.0.0.1',80);
     }

}