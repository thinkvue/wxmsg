<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminCustomer extends Validate{

	protected $rule = array(
		'name'			=>'require|length:2,50',
		'sex'			=>'require|length:1,2',
		'mobile'		=>'require|mobile|unique:customer',
		// 'company'		=>'require|length:2,100',
		'business'		=>'require',
		'city'			=>'require',
		'contact'		=>'require|between:0,10'
	);
	protected $message = array(
		'name.require'		=>'请输入客户姓名',
		'name.length'		=>'客户姓名有误，请重新输入',
		'sex.require'		=>'请输入客户性别',
		'sex.length'		=>'客户性别有误，请重新输入',
		'mobile.require'	=>'请输入客户手机号',
		'mobile.mobile'	=>'客户手机号不合法，请重新输入',
		'mobile.unique'	=>'已经存在该客户，录入失败',
		// 'company.require'	=>'请输入客户公司名称',
		// 'company.length'	=>'公司名称不合法，请重新输入',
		'business.require'	=>'请输入客户主营业务',
		'city.require'		=>'请选择客户所在城市',
		'contact'			=>'请选择联系选项'
	);
}