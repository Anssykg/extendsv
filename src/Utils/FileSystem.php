<?php
/**
 * @Created by 666.
 * @User: Anssykg
 * @Date: 2020/7/22 0022
 * @Time: 下午 22:56
 */

namespace Extendsv\Utils;

class FileSystem
{
    /**
     * 获取图片信息(支持本地和网络图片)
     * @getNetworkImg
     * @param $url
     * @return array [description]
     */
    public static function getNetworkImg($url)
    {
        $file_size = 1024 * 20480;//限制文件大小k
        $file_imgs = ['jpg', 'jpeg', 'png', 'bmp'];
        $suffix = pathinfo($url, PATHINFO_EXTENSION);
        $name = basename($url);
        ob_start();
        readfile($url);
        $content = ob_get_contents(); //获取图片的二进制流
        ob_end_clean();
        $size = strlen($content);
        if ($size > $file_size) {
            return false;
        }
        if (!in_array($suffix, $file_imgs)) {
            return false;
        }
        return compact('size', 'name', 'suffix', 'content');//返回文件大小，后缀+文件流
    }

    /**
     * 创建目录
     * @param string $dirPath 需要创建的目录
     * @param integer $permissions 目录权限
     * @return  bool
     */
    public static function createDirectory($dirPath, $permissions = 0755)
    {
        if (!is_dir($dirPath)) {
            try {
                return mkdir($dirPath, $permissions, true) && chmod($dirPath, $permissions);
            } catch (\Throwable $throwable) {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * 移动文件到另一位置
     * @param string $source 源位置
     * @param string $target 目标位置
     * @param bool $overwrite 是否覆盖目标文件
     * @return  bool
     */
    public static function moveFile($source, $target, $overwrite = true)
    {
        if (!file_exists($source)) return false;
        if (file_exists($target) && $overwrite == false) return false;
        elseif (file_exists($target) && $overwrite == true) {
            if (!unlink($target)) return false;
        }
        $targetDir = dirname($target);
        if (!self::createDirectory($targetDir, 777)) return false;
        return rename($source, $target);
    }

    /**
     * 文件复制另一位置
     * @param string $source 源位置
     * @param string $target 目标位置
     * @param bool $overwrite 是否覆盖目标文件
     * @return bool
     */
    public static function copyFile($source, $target, $overwrite = true)
    {
        if (!file_exists($source)) return false;
        if (file_exists($target) && $overwrite == false) return false;
        elseif (file_exists($target) && $overwrite == true) {
            if (!unlink($target)) return false;
        }
        $targetDir = dirname($target);
        if (!self::createDirectory($targetDir, 777)) return false;
        return copy($source, $target);
    }

    /**
     * 网络图片保存到服务器
     * @downNetworkImageDisk
     * @param $url      网络图片地址
     * @param $target   目标地址
     * @return bool [description]
     */
    public static function downNetworkImageDisk($url, $target)
    {
        ob_start();
        readfile($url);
        $content = ob_get_contents(); //获取图片的二进制流
        ob_end_clean();
        $targetDir = dirname($target);
        if (!self::createDirectory($targetDir, 777)) return false;
        $fp2 = @fopen($target, "a");//生成预存图片流文件
        fwrite($fp2, $content);//向当前目录的流文件写入图片信息
        fclose($fp2);
        return true;
    }

    /**
     * 浏览器下载网络文件
     * 支持多种文件格式
     * @downNetworkFile
     * @param $url  网络文件地址
     */
    public static function downNetworkFile($url)
    {
        $file_name = str_replace(dirname($url) . '/', '', $url);
        $file = fopen($url, "rb");
        Header("Content-type:  application/octet-stream ");
        Header("Accept-Ranges:  bytes ");
        Header("Content-Disposition:  attachment;  filename= $file_name");
        while (!feof($file)) {
            echo fread($file, 32768);
            ob_flush();
            flush();
        }
        fclose($file);
    }

    /**
     * CURL 检测远程文件是否在
     * @param $url
     * @return bool
     */
    public static function curlFileExist($url)
    {
        $ch = curl_init();
        try {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $contents = curl_exec($ch);
            if (preg_match("/404/", $contents)) return false;
            if (preg_match("/403/", $contents)) return false;
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
