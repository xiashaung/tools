<?php
namespace  Tools\tools;

class tools
{
    /**
     * 检查生日是否合法
     * @param int $minAge 最小年龄
     * @param int $maxAge 最大年龄
     * @param string $birthday 生日日期
     * @return bool 生日合法 返回年龄 不合法 返回false
     */
    public static function checkBirthDay($birthday,$minAge = 18,$maxAge = 100)
    {
        $time = strtotime($birthday);
        $timeA = explode(' ',$birthday);
        $timeArr = explode('-',$timeA[0]);
        //检查当前日期是否合法 如2月30号 为不合法日期
        //参数 月 日 年
        if (!checkdate($timeArr[1],$timeArr[2],$timeArr[0])){
          return false;
        }
       $now = new \DateTime();
        $then = \DateTime::createFromFormat('Y-m-d',date('Y-m-d',$time));
        $age = $now->diff($then);
        if ( ($age->y>$minAge) && ($age->y<=$maxAge)){
            return $age;
        }else{
            return false;
        }
    }

    /**
     * @param $time string 需要加减的时间
     * @param $add string dateInterval 类的参数
     * @return string 返回加减的字符串
     */
    public static function timeAdd($time,$add)
    {
        $dateObj = new \DateTime($time);
        $dateIntervalObj = new \DateInterval($add);
        $dateObj->add($dateIntervalObj);
        return $dateObj->format('Y-m-d H:i:s');
    }

    /**
     * @param $time string 需要加减的时间
     * @param $add string dateInterval 类的参数
     * @return string 返回加减的字符串
     */
    public static function timeSub($time,$add)
    {
        $dateObj = new \DateTime($time);
        $dateIntervalObj = new \DateInterval($add);
        $dateObj->sub($dateIntervalObj);
        return $dateObj->format('Y-m-d H:i:s');
    }

    /**
     * @param $time string 需要加减的时间
     * @param $next string 下一个日期 如 next Monday
     * @return string 返回获得的真实时间
     */
    public static function timeMod($time,$next)
    {
        $dateObj = new \DateTime($time);
        $dateObj->modify($next);
        return $dateObj->format('Y-m-d H:i:s');
    }

    /**
     * 不带时分秒的时间差
     * @param $start_time string 开始时间
     * @param $end_time  string 结束时间
     * @return \DateInterval|false
     */
    public static function subTime($start_time,$end_time)
    {
       $st = date_create(date('Y-m-d',strtotime($start_time)));
       $et = date_create(date('Y-m-d',strtotime($end_time)));
        return date_diff($st,$et);
    }

    /**
     * 带时分秒的时间差
     * @param $start_time string 开始时间
     * @param $end_time  string 结束时间
     * @return \DateInterval|false
     */
    public static function subTimeWithHis($start_time,$end_time)
    {
        $st = date_create($start_time);
        $et = date_create($end_time);
        return date_diff($st,$et);
    }

    /**
     * 通常用作计算倒计时时间用
     * @param $time string 时间
     * @return int 返回时间差
     */
    public static function subTimeToTimestamps($time)
    {
       return time() - strtotime($time);
    }


    /**
     * 用身份证前两位数获取当前身份证来自什么省份
     * @param $key int 身份证的前两位数
     * @return mixed  返回数据库对应的省 直辖市
     */
    public static function getProvinceByCardNo($key)
    {
        $area = array(
            11 => "北京",
            12 => "天津",
            13 => "河北",
            14 => "山西",
            15 => "内蒙古",
            21 => "辽宁",
            22 => "吉林",
            23 => "黑龙江",
            31 => "上海",
            32 => "江苏",
            33 => "浙江",
            34 => "安徽",
            35 => "福建",
            36 => "江西",
            37 => "山东",
            41 => "河南",
            42 => "湖北",
            43 => "湖南",
            44 => "广东",
            45 => "广西",
            46 => "海南",
            50 => "重庆",
            51 => "四川",
            52 => "贵州",
            53 => "云南",
            54 => "西藏",
            61 => "陕西",
            62 => "甘肃",
            63 => "青海",
            64 => "宁夏",
            65 => "新疆",
            71 => "台湾",
            81 => "香港",
            82 => "澳门",
            91 => "国外"
        );

        return $area[$key];
    }

    /**
     * @param $amount float  需格式化的金额
     * @param $round  int round函数保留的小数位数
     * @return string 返回格式化后的数据
     */
    public static function formatAmount($amount,$round = 2)
    {
       $list = str_split(strrev((int)$amount),4);
        $count = count($list);
        if ($count==1){
            return round($amount,2).'元';
        }
        if ($count==2){
            return round(strrev($list[1]).'.'.$list[0],$round).'万元';
        }
        if ($count==3){
            return round(strrev($list[2]).'.'.$list[1],$round).'亿';
        }
        if ($count==4){
            return round(strrev($list[2]).'.'.$list[1],$round).'万亿';
        }

    }

}
