<?php
namespace Tools;

use JPush\Client as jiguang;
use JPush\Exceptions\APIRequestException;
use JPush\Exceptions\JPushException;

class jpush
{
    protected  $app_key;

    protected  $app_secret;

    protected  $client;

    protected  $test;

    public $platform = '';

    public  $content = '';

    public $extra = [];

    public  $app_version = 1;

    protected  $options;

    protected  $registrationId;

    /**
     * JpushS constructor.
     * @param $app_key string 极光推送appkey
     * @param $app_secret string 极光推送秘钥
     * @param string $content
     * @param array $extra 额外的数组 key value 形式
     * @param int $app_version 要推送的app版本
     * @param $registrationId array 要推送的极光id
     */
    public function  __construct($app_key,$app_secret,$content = '',$extra = [],$registrationId,$app_version = 1)
    {
        $this->app_key = $app_key ;
        $this->app_secret = $app_secret;
        $this->content = $content;
        $this->extra = $extra;
        $this->app_version = $app_version;
        $this->registrationId = $registrationId;
        $this->options = $this->getOptions();
    }

    /**
     * @param $platform
     *  push执行方法
     * 给所有平台发送同样的消息
     */
    public function all($platform)
    {
        try{

            $this->getClient()
                ->push()
                ->addAllAudience()
                ->setPlatform($platform)
                ->setNotificationAlert($this->content)
                ->iosNotification($this->content, [
                    'sound' => 'default',
                    'badge' => '+1',
                    'extras' => $this->extra])
                ->androidNotification($this->content, [
                    'title' => '云端金融',
                    'priority' => 1,
                    'extras' => $this->extra])
                ->options($this->options)
                ->send();
        }catch (JPushException $e) {
            print  $e;
        }catch (APIRequestException $e){
            print  $e;
        }
    }

    /**
     * 仅往ios平台发送推送
     */
    public function ios()
    {
        if (count($this->registrationId)>1000){
            $registrationIds = array_chunk($this->registrationId,1000);
            foreach ($registrationIds as $k=>$v){
                try{
                    $this->getClient()
                        ->push()
                        ->addRegistrationId($v)
                        ->setPlatform('ios')
                        ->iosNotification($this->content, [
                            'sound' => 'default',
                            'badge' => '+1',
                            'extras' => $this->extra])
                        ->options($this->options)
                        ->send();
                }catch (JPushException $e) {
                    print  $e;
                }catch (APIRequestException $e){
                    print  $e;
                }
            }
        }else{
            try{
                $this->getClient()
                    ->push()
                    ->addRegistrationId($this->registrationId)
                    ->setPlatform('ios')
                    ->iosNotification($this->content, [
                        'sound' => 'default',
                        'badge' => '+1',
                        'extras' => $this->extra])
                    ->options($this->options)
                    ->send();
            }catch (JPushException $e) {
                print  $e;
            }catch (APIRequestException $e){
                print  $e;
            }
        }
    }

    /**
     * 往安卓平台发送推送
     */
    public function andriod()
    {
        if (count($this->registrationId)>1000){
            $registrationIds = array_chunk($this->registrationId,1000);
            foreach ($registrationIds as $k=>$v){
                try{
                    $this->getClient()
                        ->push()
                        ->addRegistrationId($v)
                        ->setPlatform('android')
                        ->androidNotification($this->content, [
                            'title' => '云端金融',
                            'priority' => 1,
                            'extras' => $this->extra])
                        ->options($this->options)
                        ->send();
                }catch (JPushException $e) {
                    print  $e;
                }catch (APIRequestException $e){
                    print  $e;
                }
            }
        }else{
            try{
                $this->getClient()
                    ->push()
                    ->addRegistrationId($this->registrationId)
                    ->setPlatform('android')
                    ->androidNotification($this->content, [
                        'title' => '云端金融',
                        'priority' => 1,
                        'extras' => $this->extra])
                    ->options($this->options)
                    ->send();
            }catch (JPushException $e) {
                print  $e;
            }catch (APIRequestException $e){
                print  $e;
            }
        }
    }

    /**
     * @return jiguang
     */
    public function getClient()
    {
        return $this->client = new jiguang($this->app_key,$this->app_secret,'/alidata/www/nadmin/jpush.log');
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }


    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getAppVersion()
    {
        return $this->app_version;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param int $app_version
     */
    public function setAppVersion(int $app_version)
    {
        $this->app_version = $app_version;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param array $extra
     */
    public function setExtra(array $extra)
    {
        $this->extra = $extra;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options = array(
            'apns_production'=>config('jpush.apns_production'),
        );
    }
}