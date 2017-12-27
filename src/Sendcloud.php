<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/12
 * Time: 8:54
 *
 */

namespace Badtomcat\Mail;


class Sendcloud
{
    protected $key;
    protected $user;

    /***
     * Sendcloud constructor.
     * @param $user
     * @param $key
     */
    public function __construct($user, $key)
    {

        $this->key = $key;
        $this->user = $user;
    }

    public function send($to, $subject, $html)
    {
        $url = 'http://api.sendcloud.net/apiv2/mail/send';

        //您需要登录SendCloud创建API_USER，使用API_USER和API_KEY才可以进行邮件的发送。
        $param = array(
            'apiUser' => $this->user,
            'apiKey' => $this->key,
            'from' => 'service@sendcloud.im',
            'fromName' => 'SendCloud',
            'to' => $to,
            'subject' => $subject,
            'html' => $html,
            'respEmailId' => 'true');

        $data = http_build_query($param);

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            ));

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        //{"result":true,"statusCode":200,"message":"璇锋眰鎴愬姛","info":{"emailIdList":[
        //"1514353827005_92396_12812_5675.sc-10_9_13_213-inbound0$531164479@qq.com"]}}
        $ret = json_decode($result);
//        if ()
        return $ret;
    }
}