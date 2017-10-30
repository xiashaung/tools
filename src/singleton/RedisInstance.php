<?php

namespace Tools\singleton;


class RedisInstance
{
    protected static $instance;

    public static $database;

    protected static function getInstance()
    {
        if (!static::$instance){
            static::$instance =  self::connect();
        }

        return static::$instance;
    }

    /**
     * @return bool|\Redis
     */
    protected static  function localhost()
    {
        $redis = new \Redis();
       try{
           $redis->connect('127.0.0.1',6379);
       }catch (\RedisException $e){
          return false;
       }
        return $redis;
    }

    /**
     * @return bool|\Redis
     * thinkPHP的连接redis方式
     */
    protected static function thinkPHP()
    {
        $redis  = new \Redis();
        try{
            $redis->connect(C('redis_init.IP'), C('redis_init.PORT'));
            $redis->auth(C('redis_init.pwd'));
        }catch (\RedisException $e){
            return  false;
        }
        return $redis;
    }

    /**
     * @return \Redis
     *  * 优先连接本地 否则连接ThinkPhp
     */
    protected static function connect()
    {
        if (static::thinkPHP()){
            return static::thinkPHP();
        }
        if (static::localhost()){
            return static::localhost();
        }
    }

    /**
     * 参数至少一个,最后一个参数为选择的redis database数据库
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $redis = static::getInstance();

        if (!$redis){
            throw new \Exception('redis client config not found');
        };
        if (!static::$database){
            throw new \Exception('database must be set!');
        }
        $redis->select(static::$database);
        switch (count($args)) {
            case 0:
                return $redis->$method();
            case 1:
                return $redis->$method($args[0]);
            case 2:
                return $redis->$method($args[0], $args[1]);
            case 3:
                return $redis->$method($args[0], $args[1], $args[2]);
            case 4:
                return $redis->$method($args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array([$redis, $method], $args);
        }
    }
}