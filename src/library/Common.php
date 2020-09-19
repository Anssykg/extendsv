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

    private static $file_size = 204800;
    private static $file_imgs = ['jpg', 'jpeg', 'png', 'bmp'];
    public static $error_msg = '';

    /**
     * 获取图片信息
     * @getNetworkImg
     * @param $url
     * @return array [description]
     */
    public static function getNetworkImg($url)
    {
        $suffix = pathinfo($url, PATHINFO_EXTENSION);
        ob_start();
        readfile($url);
        $content = ob_get_contents(); //获取图片的二进制流
        ob_end_clean();
        $size = strlen($content);
        //$filename = '4561.'.$ext;
        //$fp2 = @fopen($filename, "a");//生成预存图片流文件
        //fwrite($fp2, $content);//向当前目录的流文件写入图片信息
        //fclose($fp2);
        if ($size > self::$file_size) {
            self::$error_msg = "上传或加载的图片太大，{$size}";
            return false;
        }
        if (!in_array($suffix, self::$file_imgs)) {
            self::$error_msg = "图片的后缀格式错误，{$suffix}";
            return false;
        }
        return compact('size', 'suffix', 'content');//返回新的文件名
    }

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
}
