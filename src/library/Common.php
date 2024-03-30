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

    /**
     * 判定是否在cli模式
     * @return bool
     */
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
     * @param int $length 长度
     * @param string $type 类型
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
            $code .= $string[mt_rand(0, $strlen)];
        }
        return $code;
    }

    /**
     * 正则检测路由是否是网络链接
     * @isUrl
     * @param $url
     * @return bool [description]
     */
    public static function isUrl($url)
    {
        $pattern = "#(http|https)://(.*\.)?.*\..*#i";
        if (preg_match($pattern, $url)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证是否为手机号码
     * @param $string 手机号
     * @param string $rule 自定义段落
     * @return bool
     */
    public static function isMobile($string, $rule = '3|4|5|7|8|9')
    {
        return !!preg_match('/^1[' . $rule . ']\d{9}$/', $string);
    }

    /**
     * 获取字符串中图片地址
     * @param string $string 字符串内容
     * @param string $order 要获取哪张图片，all，0第一张图片
     * @return array|mixed|string
     */
    public static function getStringImages(string $string = '', $order = 'all')
    {
        $images = [];
        if ($string != '') {
            $pattern = "/<img .*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
            preg_match_all($pattern, $string, $match);
            if (isset($match[1]) && !empty($match[1])) {
                $images = $match[1];
            }
        } else {
            return '';
        }
        $match = array_filter($images);
        if ($order !== 'all') {
            return $images[intval($order)];
        } else {
            return $images;
        }
    }

    /**
     * 删除字符串中html标签
     * @param $string
     * @return string
     */
    public static function deleteHtml($string)
    {
        $string = strip_tags($string);
        $rule = "[&nbsp;|&ldquo;|&rdquo;| ]"; // 注意这里最后是个空格
        return preg_replace($rule, "", $string);
    }
}
