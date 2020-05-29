<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminStaffer extends Validate{
    
    protected $rule = array(
		'realname'			=>'require|length:2,50',
		'sex'			=>'require|length:1,2',
		'mobile'		=>'require|mobile|unique:user',
		'company'		=>'require|length:2,100',
		'business'		=>'require',
		'city'			=>'require',
    );
    
	protected $message = array(
		'realname.require'		=>'请输入合作伙伴姓名',
		'realname.length'		=>'合作伙伴姓名有误，请重新输入',
		'sex.require'		=>'请输入合作伙伴性别',
		'sex.length'		=>'合作伙伴性别有误，请重新输入',
		'mobile.require'	=>'请输入合作伙伴手机号',
		'mobile.mobile'	=>'合作伙伴手机号不合法，请重新输入',
		'mobile.unique'	=>'已经存在该合作伙伴，录入失败',
		'company.require'	=>'请输入合作伙伴公司名称',
		'company.length'	=>'公司名称不合法，请重新输入',
		'business.require'	=>'请输入合作伙伴主营业务',
		'city.require'		=>'请选择合作伙伴所在城市',
	);
}