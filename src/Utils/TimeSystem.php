<?php
/**
 * @Created by 666.
 * @User: Anssykg
 * @Date: 2020/7/22 0022
 * @Time: 下午 22:56
 */

namespace Extendsv\Utils;

class TimeSystem
{
    /**
     * 获取当前时间
     * @getNowTimeStr
     * @return false|string [description]
     */
    public static function getNowTimeStr()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 获取当日开始时间
     * @getStartTimeStr
     * @return false|string [description]
     */
    public static function getStartTimeStr()
    {
        return date('Y-m-d 00:00:00');
    }

    /**
     * 获取当日结束时间
     * @getEndTimeStr
     * @return false|string [description]
     */
    public static function getEndTimeStr()
    {
        return date('Y-m-d 23:59:59');
    }

    /**
     * 获取当前开始时间戳
     * @getStartTimeNum
     * @return false|int [description]
     */
    public static function getStartTimeNum()
    {
        return strtotime(date('Y-m-d 00:00:00'));
    }

    /**
     * 获取当前结束时间戳
     * @getEndTimeNum
     * @return false|int [description]
     */
    public static function getEndTimeNum()
    {
        return strtotime(date('Y-m-d 23:59:59'));
    }

    /**
     * 获取时间日期数组
     * @get_time_str_array
     * @return array [description]
     */
    public static function getTimeStrArray()
    {
        //当天
        $now_day_arr = [
            'start' => date('Y-m-d 00:00:00'),
            'end' => date('Y-m-d H:i:s'),
        ];
        //昨天
        $yst_day_arr = [
            'start' => date('Y-m-d 00:00:00', strtotime('-1 day')),
            'end' => date('Y-m-d 23:59:59', strtotime('-1 day')),
        ];
        //本周
        $this_week_arr = [
            'start' => date('Y-m-d H:i:s', strtotime("-7 day", strtotime("next Monday", time()))),
            'end' => date('Y-m-d H:i:s'),
        ];
        //一周内
        $within_week_arr = [
            'start' => date('Y-m-d H:i:s', strtotime("-7 day", time())),
            'end' => date('Y-m-d H:i:s'),
        ];
        //当月
        $this_month_arr = [
            'start' => date('Y-m-1 00:00:00'),
            'end' => date('Y-m-d H:i:s'),
        ];
        //今天号数
        $nd = date("d");
        //本月最后一天号数
        $nt = date("t");
        //上个月最后一天号数
        $lt = date("t", strtotime("-1 month"));
        $yst_month_time_str = date('Y-m-d H:i:s', strtotime("-1 month"));
        if ($nt > $lt) {
            if ($nd > $lt) {
                $yst_month_time_str = date('Y-m-1 00:00:00');
            }
        }
        if ($nt < $lt) {
            if ($nt == $nd) {
                $yst_month_time_str = date('Y-m-d H:i:s', strtotime("-1 day", strtotime("-1 month")));
            }
        }
        //上个月的现在
        //一月内
        $within_month_arr = [
            'start' => $yst_month_time_str,
            'end' => date('Y-m-d H:i:s'),
        ];
        //上个月
        $yst_month_arr = [
            'start' => date('Y-m-1 00:00:00', strtotime("-1 month")),
            'end' => date('Y-m-t 23:59:59', strtotime("-1 month")),
        ];
        //今年
        $tis_year_arr = [
            'start' => date('Y-1-1 00:00:00'),
            'end' => date('Y-m-d H:i:s'),
        ];
        return compact('now_day_arr', 'yst_day_arr', 'this_week_arr', 'within_week_arr', 'this_month_arr', 'within_month_arr', 'yst_month_arr', 'tis_year_arr', 'yst_month_time_str');
    }


    /**
     * 获取n月后的今天
     * @param $n
     * @return false|string
     */
    public static function getNextMonthTimeStr($n)
    {
        $nd = date("d");//今天多少号
        $nt = date("t");//当月最多多少号
        $lt = date("t", strtotime($n . " month"));//n月后最多多少号
        $newxtMonthTimeStr = date('Y-m-d H:i:s', strtotime($n . " month"));
        if ($nt > $lt) {//当月号数比n月后号数大
            if ($nd > $lt) {//今天号数比n月后号数大
                //取n月后下个月的第一天
                $newxtMonthTimeStr = date('Y-m-1 H:i:s', strtotime($n + 1 . " month"));
            }
        }
        return $newxtMonthTimeStr;
    }

    /**
     * 获取n月前的今天
     * @param $n
     * @return false|string
     */
    public static function getPreMonthTimeStr($n)
    {
        $nd = date("d");//今天多少号
        $nt = date("t");//当月最多多少号
        $lt = date("t", strtotime("-" . $n . " month"));//n月前最多多少号
        $preMonthTimeStr = date('Y-m-d H:i:s', strtotime("-" . $n . " month"));
        if ($nt > $lt) {//当月号数比n月后号数大
            if ($nd > $lt) {//今天号数比n月后号数大
                $preMonthTimeStr = date('Y-m-1 00:00:00', strtotime("-" . ($n - 1) . " month"));
            }
        }
        if ($nt < $lt) {
            if ($nt == $nd) {
                $preMonthTimeStr = date('Y-m-d H:i:s', strtotime("-1 day", strtotime("-" . $n . " day")));
            }
        }
        return $preMonthTimeStr;
    }
}
