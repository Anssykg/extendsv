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
 * 发送消息
 * Class SendMessage
 * @package Extendsv\Wechat
 */
class SendMessage
{
    /**
     * 发送小程序订阅消息，即时性需用用户同意
     * @sendSubscribeMsg
     * @param $params
     * @return bool|string [description]
     */
    public static function sendWeappSubscribeMsg($params)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=" . WeChatPublicAccount::$access_token;
        $data = [
            'touser' => $params['openid'],
            'template_id' => $params['weapp_template_msg']['template_id'],
            'lang' => 'zh_CN',
            'data' => $params['weapp_template_msg']['data'],
        ];
        $params = $data;
        return HttpHandle::post_curls($url, json_encode($params, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 发送小程序模板消息，以小程序为主可以发送公众号消息
     * @sendTemplateMsg
     * @param $params
     * @return bool|string [description]
     */
    public static function sendWeappTemplateMsg($params)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=" . WeChatPublicAccount::$access_token;
        $data = [
            'touser' => $params['openid'],
            'weapp_template_msg' => $params['weapp_template_msg'] ?? [],
            'mp_template_msg' => $params['mp_template_msg'] ?? [],
        ];
        if (!$data['weapp_template_msg']) unset($data['weapp_template_msg']);
        if (!$data['mp_template_msg']) unset($data['mp_template_msg']);
        $params = $data;
        return HttpHandle::post_curls($url, json_encode($params, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 发送公众号模板消息
     * @sendMpTemplateMsg
     * @param $params
     * @return bool|string [description]
     */
    public static function sendMpTemplateMsg($params)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . WeChatPublicAccount::$access_token;
        $data = [
            'touser' => $params['openid'],
            'template_id' => $params['template_id'],
            'miniprogram' => $params['miniprogram'] ?? [],
            'url' => $params['url'] ?? [],
            'data' => $params['data'],
        ];
        if (!$data['miniprogram']) unset($data['miniprogram']);
        if (!$data['url']) unset($data['url']);
        $params = $data;
        return HttpHandle::post_curls($url, json_encode($params, JSON_UNESCAPED_UNICODE));
    }
}
