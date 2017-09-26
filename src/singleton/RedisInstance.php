<?php

namespace Tools\singleton;


class RedisInstance
{
    protected static $instance;

    protected static function getInstance()
    {
        if (!static::$instance){
            static::$instance =  self::connect();
        }

        return static::$instance;
    }

    /**
     * @return \Redis
     * redis本地连接
     */
    protected static  function localhost()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        return $redis;
    }

    /**
     * @return \Redis
     * * thinkPHP的连接redis方式
     */
    protected static function thinkPHP()
    {
        $redis  = new \Redis();
        $redis->connect(C('redis_init.IP'), C('redis_init.PORT'));
        $redis->auth(C('redis_init.pwd'));
        return $redis;
    }

    /**
     * @return \Redis
     *  * 优先连接本地 否则连接ThinkPhp
     */
    protected static function connect()
    {
        if (static::localhost()){
            return static::localhost();
        }
        if (static::thinkPHP()){
            return static::thinkPHP();
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
        $redis->select($args[count($args)-1]);
        unset($args[count($args)-1]);
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