<?php

namespace Tools\singleton;

use \Symfony\Component\HttpFoundation\Request as fromRequest;

/**
 * Class Request
 * @package Tools\tools
 * @method static all()
 * @method  static keys()
 * @method  static set($key, $value)
 * @method  static has($key)
 * @method  static remove($key)
 * @method  static count()
 * @method  static getBoolean($key, $default = false)
 * @method  static getInt($key, $default = 0)
 * @method  static getAlnum($key, $default = '')
 * @method  static getAlpha($key, $default = '')
 * @method  static replace(array $parameters = array())
 */
class RequestInstance extends fromRequest
{
    /**
     * @param $key
     * @return mixed
     * 获取字段值
     */
   public static function input($key = null)
   {
      if (!$key){
          return static::all();
      }else{
          return static::instance()->get($key);
      }
   }

   public static function instance()
   {
       return   fromRequest::createFromGlobals();
   }

   public function __isset($key)
   {
       return $this->__get($key);
   }

    public static function method()
    {
        $instance = static::instance();
        return  $instance->getMethod() == 'GET'?$instance->query:$instance->request;
    }

    public function __get($key)
   {
      $all = static::all();

       if (array_key_exists($key,$all)){
           return $all[$key];
       }else{
           return null;
       }
   }
    /**
     * @param $method
     * @param $args
     * @return mixed
     *继承自Symfonyhttp组件的request query是get请求 requset 是post请求
     *仅是简单的扩展 复杂可参考laravel Illuminate\Http命名空间下的request文件
     */
    public static function __callStatic($method,$args)
    {
        $request = static::method();
        switch (count($args)) {
            case 0:
                return $request->$method();
            case 1:
                return $request->$method($args[0]);
            case 2:
                return $request->$method($args[0], $args[1]);
            case 3:
                return $request->$method($args[0], $args[1], $args[2]);
            case 4:
                return $request->$method($args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array([$request, $method], $args);
        }
    }
}