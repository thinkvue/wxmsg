<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

//MISS路由，严格路由，未声明的地址重定位，
//不可注释掉，因为跨域请求一般会发送一条OPTIONS的请求，如果服务器没有正确响应，浏览器安全策略会判为没有跨域权限
Route::miss('admin/base/miss');

return [
    // 定义资源路由
    '__rest__'=>[
        'admin/rules'		   =>'admin/rules',
        'admin/groups'		   =>'admin/groups',
        'admin/users'		   =>'admin/users',
        'admin/menus'		   =>'admin/menus',
        'admin/structures'	   =>'admin/structures',
        'admin/posts'          =>'admin/posts',
    ],

	// 【基础】登录
	'admin/base/login' => ['admin/base/login', ['method' => 'POST']],
	// 【基础】记住登录
	'admin/base/relogin'	=> ['admin/base/relogin', ['method' => 'POST']],
	// 【基础】修改密码
	'admin/base/setInfo' => ['admin/base/setInfo', ['method' => 'POST']],
	// 【基础】退出登录
	'admin/base/logout' => ['admin/base/logout', ['method' => 'POST']],
	// 【基础】获取配置
	'admin/base/getConfigs' => ['admin/base/getConfigs', ['method' => 'POST|GET']],
	// 【基础】获取验证码
	'admin/base/getVerify' => ['admin/base/getVerify', ['method' => 'GET']],
	// 【基础】上传图片
	'admin/upload' => ['admin/upload/index', ['method' => 'POST']],
	'upload' => ['admin/upload/index', ['method' => 'POST']],
	// 保存系统配置
	'admin/systemConfigs' => ['admin/systemConfigs/save', ['method' => 'POST']],
	// 【规则】批量删除
	'admin/rules/deletes' => ['admin/rules/deletes', ['method' => 'POST']],
	// 【规则】批量启用/禁用
	'admin/rules/enables' => ['admin/rules/enables', ['method' => 'POST']],
	// 【用户组】批量删除
	'admin/groups/deletes' => ['admin/groups/deletes', ['method' => 'POST']],
	// 【用户组】批量启用/禁用
	'admin/groups/enables' => ['admin/groups/enables', ['method' => 'POST']],
	// 【用户】批量删除
	'admin/users/deletes' => ['admin/users/deletes', ['method' => 'POST']],
	// 【用户】批量启用/禁用
	'admin/users/enables' => ['admin/users/enables', ['method' => 'POST']],
	// 【菜单】批量删除
	'admin/menus/deletes' => ['admin/menus/deletes', ['method' => 'POST']],
	// 【菜单】批量启用/禁用
	'admin/menus/enables' => ['admin/menus/enables', ['method' => 'POST']],
	// 【组织架构】批量删除
	'admin/structures/deletes' => ['admin/structures/deletes', ['method' => 'POST']],
	// 【组织架构】批量启用/禁用
	'admin/structures/enables' => ['admin/structures/enables', ['method' => 'POST']],
	// 【部门】批量删除
	'admin/posts/deletes' => ['admin/posts/deletes', ['method' => 'POST']],
	// 【部门】批量启用/禁用
    'admin/posts/enables' => ['admin/posts/enables', ['method' => 'POST']],

	// 【部门】批量启用/禁用
	'admin/base/loginbyopenid' => ['Admin/Base/loginByOpenid', ['method' => 'POST|GET']],

// +-------------------------------------------------------------
// |  以下不在开源项目内
// +-------------------------------------------------------------
	//测试
	'test' => ['admin/test/index', ['method' => 'POST|GET']],
	//佣金列表
	'admin/commission/list' => ['admin/commission/list', ['method' => 'POST|GET']],
	//客户列表
	'admin/customer/list' => ['admin/customer/list', ['method' => 'POST|GET']],
	//保存客户
	'admin/customer/save' => ['admin/customer/save', ['method' => 'POST|GET']],
	//检查客户是否已经存在
	'admin/customer/check' => ['admin/customer/check', ['method' => 'POST|GET']],
	//下线列表
	'admin/member/list' => ['admin/member/list', ['method' => 'POST|GET']],
	//新增下线
	'admin/member/save' => ['admin/member/save', ['method' => 'POST|GET']],
	//CMS主题列表
	'cms/article/articleList' => ['cms/article/articleList', ['method' => 'POST|GET']],
	//手机验证码
	'admin/base/mobilecode' => ['admin/base/mobilecode', ['method' => 'POST|GET']],
	//用户注册
	'admin/base/register' => ['admin/base/register', ['method' => 'POST|GET']],
	//用户登录-通过手机验证码
	'admin/base/loginbymsgcode' => ['admin/base/loginbymsgcode', ['method' => 'POST|GET']],
	//API公开接口:查询手机
	'mobile/[:mobile]' => 'api/info/mobile',
	//API公开接口:查询IP
	'ip' => ['api/info/ip', ['method' => 'POST|GET']],
	//API公开接口：发送微信消息
	'msg' => ['api/info/msg', ['method' => 'POST|GET']],
	//API用户通过微信网页登录
	'api/info/loginbywechat'=>['api/info/loginbywechat', ['method' => 'POST|GET']],
	//API用户客户端记录登录
	'api/info/relogin'=>['api/info/relogin', ['method' => 'POST|GET']],
	//API用户通过手机验证码登录
	'api/info/login'=>['api/info/login', ['method' => 'POST|GET']],
	//API用户所属令牌列表
	'api/token/list'=>['api/token/list', ['method' => 'POST|GET']],
	//API用户增加令牌
	'api/token/add'=>['api/token/add', ['method' => 'POST']],
	//API用户删除令牌
	'api/token/delete'=>['api/token/delete', ['method' => 'POST']],
	//demo
	'demo/:key'=>'demo/test/get',
];