<?php
namespace Tools\singleton;

use Tools\tools\Thread;

class ThreadSingleton  extends \Thread
{
     protected $url = null;

     protected $type = null;

     public $data = null;
    function __construct($url,$type = Thread::GET,$datas = null)
    {
        $this->url = $url;
        $this->type = $type;
        $this->data = $datas;
    }

    function run()
    {
        switch ($this->type){
            case  200:
                $this->data = $this->curlGet();
                break;
            case  200:
                $this->data = $this->curlPost();
                break;
        }
    }

    function curlGet()
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }

    function curlPost()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($this->data,true));
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}