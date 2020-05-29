<?php
// +----------------------------------------------------------------------
// | Description: 基础类，无需验证权限，所有操作可公开访问。
// +----------------------------------------------------------------------

namespace app\admin\controller;

use com\verify\HonrayVerify;
use app\common\controller\Common;

class Base extends Common
{
    public function login()
    {   
        $userModel = model('User');
        $param = $this->param;
        $username = $param['username'];
        $password = $param['password'];
        $verifyCode = !empty($param['verifyCode'])? $param['verifyCode']: '';
        $isRemember = !empty($param['isRemember'])? $param['isRemember']: '';
        $data = $userModel->login($username, $password, $verifyCode, $isRemember);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    public function relogin()
    {   
        $userModel = model('User');
        $param = $this->param;
        $data = decrypt($param['rememberKey']);
        $username = $data['username'];
        $password = $data['password'];

        $data = $userModel->login($username, $password, '', true, true);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }    

    public function register()
    {
        $CustomerModel = model('user');
        $param = $this->param;
        $data = $CustomerModel->register($param);
        if (!$data) {
            return resultArray(['error' => $CustomerModel->getError()],$CustomerModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }    

    public function logout()
    {
        $param = $this->param;
        cache('Auth_'.$param['authkey'], null);
        return resultArray(['data'=>'退出成功']);
    }

    public function getConfigs()
    {
        $systemConfig = cache('DB_CONFIG_DATA'); 
        if (!$systemConfig) {
            //获取所有系统配置
            $systemConfig = model('admin/SystemConfig')->getDataList();
            cache('DB_CONFIG_DATA', null);
            cache('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
        }
        return resultArray(['data' => $systemConfig]);
    }

    public function getVerify()
    {
        $captcha = new HonrayVerify(config('captcha'));
        return $captcha->entry();
    }

    public function setInfo()
    {
        $userModel = model('User');
        $param = $this->param;
        $old_pwd = $param['old_pwd'];
        $new_pwd = $param['new_pwd'];
        $auth_key = $param['auth_key'];
        $data = $userModel->setInfo($auth_key, $old_pwd, $new_pwd);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    public function loginByOpenid()
    {
        $code=$this->param['code'];
        $openid_data=getTokenOpenid($code);
        if($openid_data['code']<0)
            return resultArray(['error' => $openid_data['msg']],$openid_data['code']);
        $userModel = model('User');
        $data = $userModel->loginByOpenid($openid_data['openid']);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    public function loginByMsgcode()
    {
        $userModel = model('User');
        $data = $userModel->loginByMsgcode($this->param);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }    

    public function mobileCode() {
        $param= $this->param;
        $validate= validate('SendMessage');
        if(!$validate->check($param)) 
            return resultArray(['error' =>$validate->getError()],-2002);
        $code=rand(1000,9999);
        cache('msgcode'.$param['mobile'],$code,600);
        $retData=sendSmsVerify($code,$param['mobile']);
        if($retData['code']>0){
            $data=model('user')->where('mobile',$param['mobile'])->field('sex,city,business')->find();
            return resultArray(['data' =>$data]);
        }
        else
            return resultArray(['error' =>$retData['msg']]);
    }


    // miss 路由：处理没有匹配到的路由规则
    public function miss()
    {
        $url=$this->request->url(true);
        return resultArray(['error' =>'该URL不存在:'.$url],$code=-4001);
    }


}
 