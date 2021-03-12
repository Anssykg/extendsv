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
        //当月
        $cur_month_arr = [
            'start' => date('Y-m-1 00:00:00'),
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
        //上个月的现在
        $yst_month_time_str = date("Y-m-d H:i:s", strtotime("-1 month"));
        return compact('now_day_arr', 'yst_day_arr', 'cur_month_arr', 'yst_month_arr', 'tis_year_arr', 'yst_month_time_str');
    }
}
