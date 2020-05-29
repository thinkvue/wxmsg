<?php

namespace app\admin\validate;

use think\Validate;
/**
 * 发送验证码短信的参数验证器
 * @param {type} 
 * @return: 
 */
class SendMessage extends Validate
{
    protected $rule = [
      'mobile'      => 'require|mobile',
      'timestamp'   => 'require|number|between:1584892800,1900425600', //时间戳 2020/3/23~2030/3/23
      'code'        => 'require|length:32',
      'token'       => 'require|checkToken',
    ];

    protected $message = [
      'mobile'        => '手机不正确',
      'timestamp'     => '本地时间不正确',
      'code'          => '验证码不正确',
      'token'         => '非法请求，服务器拒绝服务:MsgCode',
    ];

    protected function checkToken ($value,$param,$data) 
    {
        if(abs($data['timestamp']-time()) >300)
            return "本机时间误差过大，请调整后重新运行";
        if($value==md5(sha1($data['mobile'].md5($data['timestamp']).$data['code'])))
            return true;
        else
            return false;
    }
}