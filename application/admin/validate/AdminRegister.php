<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminRegister extends Validate{
    
    protected $rule = array(
		'realname'		=>'require|length:2,50',
		'sex'			=>'require|length:1,2',
		'mobile'		=>'require|mobile',
		'msgcode'		=>'require|checkMsgCode',
		'business'		=>'require',
		'city'			=>'require',
		'alipay'		=>'require',
    );
    
	protected $message = array(
		'realname'  		=>'输入姓名有误，请重新输入',
		'sex'				=>'输入性别有误，请重新输入',
		'mobile.require'	=>'请输入手机号',
		'mobile.mobile'	    =>'手机号不合法，请重新输入',
		'msgcode'       	=>'手机验证码不正确',
		'business'	        =>'请输入主营业务',
		'city'	        	=>'请选择所在城市',
		'alipay'	        =>'请输入的支付宝账号',
    );

    protected function checkMsgCode ($value,$param,$data) 
    {
        $mobile=$data['mobile'];
        $msgCode=cache('msgcode'.$mobile);
        cache('msgCode'.$mobile,null);
        if($data['msgcode']==$msgCode)
            return true;
        else
            return false;
    }    
}