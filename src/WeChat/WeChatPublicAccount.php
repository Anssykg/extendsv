<?php
/**
 * @Created by 666.
 * @User: yuankaiguo
 * @Date: 2020/7/22 0022
 * @Time: 下午 22:56
 */

namespace Extendsv\WeChat;

use Extendsv\library\HttpHandle;

/**
 * Class WeChatPublicAccount
 * @package Extendsv\Wechat
 */
class WeChatPublicAccount
{
    static $appid = '';
    static $secret = '';
    static $access_token = '';

    /**
     * 获取微信access_token 小程序/公众号
     * @get_access_token
     * @return false|mixed [description]
     */
    public static function get_access_token()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . self::$appid . '&secret=' . self::$secret;
        $tokenData = Method::http_send_curl($url, $params = false, 0, 1);
        if (!empty($tokenData['access_token'])) {
            $access_token = $tokenData['access_token'];
            self::$access_token = $access_token;
        } else {
            return false;
        }
        return $access_token;
    }
}
