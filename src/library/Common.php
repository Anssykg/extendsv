<?php
/**
 * @Created by 666.
 * @User: Anssykg
 * @Date: 2020/7/22 0022
 * @Time: 下午 22:56
 */

namespace Extendsv\library;

class Common
{
    /**
     * 判断是否是json格式
     * @jsonValidate
     * @param $string
     * @return bool [description]
     */
    public static function jsonValidate($string)
    {
        if (is_string($string)) {
            @json_decode($string);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

    //TODO 判定是否在cli模式
    function is_cli()
    {
        return preg_match("/cli/i", php_sapi_name()) ? true : false;
    }

    /**
     * 验证数组是否存在某一个key
     * @array_key_isset
     * @param $key
     * @param $array
     * @return bool [description]
     */
    public static function array_key_isset($key, $array)
    {
        return in_array($key, array_flip($array));
    }

    /**
     * 生成订单唯一id
     * @getNewOrderId
     * @param int $uid
     * @param string $key
     * @return string [description]
     */
    public static function getNewOrderId($uid = 0, $key = 'OI')
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = number_format((floatval($msec) + floatval($sec)) * 1000, 0, '', '');
        $orderId = $key . $msectime . $uid . mt_rand(10000, 99999);
        return $orderId;
    }

    /**
     * 二维数据按照某些字段进行的升序或者降序排列.
     *
     * @param array $sortArr 排序字段数组例：[['field'=>'score','sort'=>SORT_DESC],['field'=>'create_time','sort'=>SORT_ASC]]
     *                       field需要排序的字段，sort排序顺序,SORT_DESC 降序,SORT_ASC 升序
     * @param array $arrList ,需要排序的二维数组
     *
     * @return array 排序后的数组
     * */
    public static function arrayArrange($sortArr, $arrList)
    {
        $sortFlog = [];
        foreach ($sortArr as $k => $v) {
            $sortFlog[] = array_column($arrList, $v['field']);
            $sortFlog[] = $v['sort'];
        }
        $sortFlog[] = &$arrList;
        call_user_func_array('array_multisort', $sortFlog);

        return $arrList;
    }

    /**
     * 获取随机字符串
     * @random
     * @param int $length   长度
     * @param string $type  类型
     * @return string [description]
     */
    public static function random($length = 6, $type = 'all')
    {
        $config = array(
            'number' => '1234567890',
            'en_small' => 'abcdefghijklmnopqrstuvwxyz',
            'en_big' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'en_all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        );
        if (!isset($config[$type])) {
            $type = 'all';
        }
        $string = $config[$type];
        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        return $code;
    }
}
