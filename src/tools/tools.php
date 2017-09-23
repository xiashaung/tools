<?php

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
       $now = new DateTime();
        $then = DateTime::createFromFormat('Y-m-d',date('Y-m-d',$time));
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
        $dateObj = new DateTime($time);
        $dateIntervalObj = new DateInterval($add);
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
        $dateObj = new DateTime($time);
        $dateIntervalObj = new DateInterval($add);
        $dateObj->sub($dateIntervalObj);
        return $dateObj->format('Y-m-d H:i:s');
    }

    /**
     * @param $time string 需要加减的时间
     * @param $next string 下一个日期 如 next Monday
     * @return string 返回加减的字符串
     */
    public static function timeMod($time,$next)
    {
        $dateObj = new DateTime($time);
        $dateObj->modify($next);
        return $dateObj->format('Y-m-d H:i:s');
    }
}