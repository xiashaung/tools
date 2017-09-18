<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/9/13
 * Time: 10:37
 */

namespace Tools\jpush;


class push
{
    protected  $app = array();

    protected  $registrationId;

    protected $iosUsers = [];

    protected $andriodUsers= [];

    protected $ios = [];

    protected $andriod = [];

    protected  $extra;

    protected $content;

    protected  $platform;

    public function __construct($content,$platform,$extra = [])
    {
        $this->content = $content;
        $this->platform = $platform;
        $this->extra = $extra;
        $this->getApp();
    }

    /**
     * @param $username string 传入用户id或者手机号
     * @param $type string 用户id或手机号
     * @return $this
     */
    public function push($username,$type)
    {
        if ($type=='用户ID'){
            $this->getregistrationIdByUserId($username);
        }else{
            $this->getregistrationIdByUsername($username);
        }
        return $this;
    }

    /**
     * 执行推送方法
     */
    public  function pushAll()
    {
        if (count($this->andriod)>0){
            $this->pushAndriod();
        }

        if (count($this->ios)>0){
            $this->pushIos();
        }
    }

    /**
     * 全员推送 慎用
     */
    public function all()
    {
        $this->andriodAll();
        $this->iosAll();
    }
    /**
     * 执行安卓推送
     */
    public function pushAndriod()
    {
        $app = $this->getApp();
        foreach ($this->andriod as $k=> $v){
            if (count($v)>0){
                if ($k==0){
                    $k=1;
                }
                $jpush = new jpush($app[$k]['APP_KEY'],$app[$k]['MASTER_SECRET'],$this->content,$this->extra,array_values($v),$k);
                $jpush->andriod();
            }
        }
    }

    /**
     * 执行ios推送
     */
    public function pushIos()
    {
        $app = $this->getApp();
        foreach ($this->ios as $k=> $v){
            if (count($v)>0){
                if ($k==0){
                    $k=1;
                }
                $jpush = new jpush($app[$k]['APP_KEY'],$app[$k]['MASTER_SECRET'],$this->content,$this->extra,array_values($v),$k);
                $jpush->ios();
            }
        }
    }

    /**
     * 往所有平台的所有用户发送消息
     */
    public  function platformAll()
    {
        switch ($this->platform){
            case 'all':
                $this->iosAll();
                $this->andriodAll();
                break;
            case 'ios':
                $this->iosAll();
                break;
            case 'andriod':
                $this->andriodAll();
                break;
        }
    }

    /**
     * 给所有ios版本的所有人发送信息
     */
    protected function iosAll()
    {
        foreach ($this->getApp() as $k => $v){
            $jpush = new jpush($v['APP_KEY'],$v['MASTER_SECRET'],$this->content,$this->extra,[],$k);
            $jpush->all('ios');
        }
    }

    /**
     * 给安卓所有用户发送信息
     */
    protected function andriodAll()
    {
        $app = $this->getApp();
        foreach ($this->andriod as $k=> $v){
            if ($k==0){
                $k=1;
            }
            $jpush = new jpush($app[$k]['APP_KEY'],$app[$k]['MASTER_SECRET'],$this->content,$this->extra,[]);
            $jpush->andriod();
        }
    }

    public  function getregistrationIdByUsername($username)
    {
        if (is_array($username)){
            $username =  implode(',',$username);
        }
        $list = M('user_jpush')->join('s_user on s_user_jpush.user_id = s_user.id')->field('s_user_jpush.*')->where('s_user.username in ('.$username.')')->select();
        $this->iosOrAndriod($list);
    }

    public function getregistrationIdByUserId($UserId)
    {
        if (is_array($UserId)){
            $UserId =  implode(',',$UserId);
        }
        $list = M('user_jpush')->join('s_user on s_user_jpush.user_id = s_user.id')->field('s_user_jpush.*')->where('s_user.id in ('.$UserId.')')->select();
        $this->iosOrAndriod($list);
    }

    /**
     * @param $list
     * 处理数据 先分开安卓和ios用户
     */
    public function iosOrAndriod($list)
    {
        foreach ($list as $k => $v){
            if ($v['device_type']==1){
                $this->iosUsers[] = $list[$k];
            }elseif ($v['device_type']==2){
                if ($v['registration_id']){
                    $this->andriodUsers[] = $list[$k];
                }
            }
        }
        $this->useIoswithJpushType();
        $this->useAndriodWithJpushType();
    }

    /**
     * 吧ios用户安装jpush_type 分类
     */
    public function useIoswithJpushType()
    {
        foreach ($this->iosUsers as $k => $v){
            if (!isset($this->ios[$v['jpush_type']])){
                if ($v['registration_id']){
                    $this->ios[$v['jpush_type']][] = $v['registration_id'];
                }
            }else{
                if ($v['registration_id']){
                    $this->ios[$v['jpush_type']][] = $v['registration_id'];
                }
            }
        }
    }

    public function useAndriodWithJpushType()
    {
        foreach ($this->andriodUsers as $k => $v){
            if (!isset($this->andriod[$v['jpush_type']])){
                if ($v['registration_id']){
                    $this->andriod[$v['jpush_type']][] = $v['registration_id'];
                }
            }else{
                if ($v['registration_id']){
                    $this->andriod[$v['jpush_type']][] = $v['registration_id'];
                }
            }
        }
    }
    /**
     * @return array
     */
    public function getApp()
    {
        return $this->app = jpushApps();
    }

    /**
     * @param array $app
     */
    public function setApp(array $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     */
    public function getAndriod()
    {
        return $this->andriod;
    }

    /**
     * @param array $andriod
     */
    public function setAndriod(array $andriod)
    {
        $this->andriod = $andriod;
    }

    /**
     * @return array
     */
    public function getAndriodUsers()
    {
        return $this->andriodUsers;
    }

    /**
     * @param array $andriodUsers
     */
    public function setAndriodUsers(array $andriodUsers)
    {
        $this->andriodUsers = $andriodUsers;
    }

    /**
     * @return array
     */
    public function getIos()
    {
        return $this->ios;
    }

    /**
     * @param array $ios
     */
    public function setIos(array $ios)
    {
        $this->ios = $ios;
    }

    /**
     * @return array
     */
    public function getIosUsers()
    {
        return $this->iosUsers;
    }

    /**
     * @param array $iosUsers
     */
    public function setIosUsers(array $iosUsers)
    {
        $this->iosUsers = $iosUsers;
    }

    /**
     * @return mixed
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * @param mixed $registrationId
     */
    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;
    }
}