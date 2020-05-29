<?php

namespace app\api\validate;
use think\Validate;
/**
* 设置模型
*/
class Login extends Validate{

	protected $rule = array(
		'mobile'    => 'require|mobile',
        'msgcode'   => 'require|checkMsgcode', //msgcode
        'authkey'   => 'require|length:32'
	);
	protected $message = array(
		'mobile.require'    => '手机号必须填写',
		'mobile.mobile'     => '手机号格式不正确，请核对',
		'msgcode.require'   => '手机验证码必须填写',
        'msgcode.checkMsgcode'   => '手机验证码不正确，请核对',
        'authkey'           => '非法请求，服务器拒绝服务：Login',
    );
    
    protected function checkMsgcode($value,$param,$data) 
    {
        if($data['msgcode'] <1000 || $data['msgcode'] >9999)
            return "验证码格式不正确";
        if($data['msgcode']!=cache('msgcode'.$data['mobile']))
            return false;
        cache('msgcode'.$data['mobile'],null);
        return true;
    }
}