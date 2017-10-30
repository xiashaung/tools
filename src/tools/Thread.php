<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/28
 * Time: 10:24
 */

namespace Tools\tools;

use Tools\singleton\Method;
use Tools\singleton\ThreadSingleton;;

class Thread
{

    const POST = 100;

    const GET = 200;

    /**
     * @param $url string 要单独执行的url
     * @param int $type int 类型
     * @param null $data json类型 post方式下要传入的参数
     * @return ThreadSingleton 返回类 如果要取数据 $thread->data
     */
    public static function run($url,$type = self::GET,$data = null)
    {
        $thread = new ThreadSingleton($url,$type,$data);
        $thread->start();
        return $thread;
    }

    /**
     * @param object $class  要执行的类
     * @param $menthod  string 要执行的方法
     * @param $join boolean 当前线程是否要等待执行完毕,如果有返回结果,false表示不需要等待执行
     * @return Method  返回执行过的类 如果要取数据 $thread->data
     */
    public static function method($class,$menthod,$join=false)
    {
        $thread = new Method($class,$menthod);
        if ($thread->start()){
//            if ($join){
//                $thread->join();
//            }
            return $thread;
        }else{
           return new Method($class,$menthod);
        }

    }

}


