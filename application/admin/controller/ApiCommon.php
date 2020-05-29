<?php
// +----------------------------------------------------------------------
// | Description: Api基类，验证权限
// +----------------------------------------------------------------------
// | 验证权限，子类可通过 `$GLOBALS['userInfo']` 获取当前会话用户信息
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use app\common\adapter\AuthAdapter;
use app\common\controller\Common;

class ApiCommon extends Common
{
    public function initialize()
    {
        parent::initialize();
        $authkey = $this->params['authkey'];
        $sessionid = $this->params['sessionid'];

        //调试
        if(config('debgu_auto_login')){
            ['authkey'=>$authkey, 'sessionid'=>$sessionid] =model('User')->loginDemo(1);
        }
        $cache = cache('Auth_'.$authkey);
        
        // 校验sessionid和authkey
        if (empty($sessionid)||empty($authkey)||empty($cache)) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>-1001, 'error'=>'登录已失效']));
        }

        // 检查账号有效性
        $userInfo = $cache['userInfo'];
        $map[]=['id','=',$userInfo['id']];
        $map[]=['status','=',1]; 
        if (!Db::name('admin_user')->where($map)->value('id')) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>-1003, 'error'=>'账号已被删除或禁用']));   
        }
        // 更新缓存，防止缓存过期
        cache('Auth_'.$authkey, $cache, config('LOGIN_SESSION_VALID'));
        $authAdapter = new AuthAdapter($authkey);
        $request = Request();
        $ruleName = $request->module().'-'.$request->controller() .'-'.$request->action(); 
        if (!$authAdapter->checkLogin($ruleName, $cache['userInfo']['id'])) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>-1002,'error'=>'没有权限']));
        }
        $GLOBALS['userInfo'] = $userInfo;
    }
}
