<?php

namespace app\api\model;

use app\common\model\Common;

class User extends Common
{
    //软删除
    protected $deleteTime = 'delete_time';

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'api_user';

    /**
	* 获取OPENID，thinkphp模型一对多关联
	*/
	public function openids()
	{
		return $this->hasMany('openid','user_id');
	}

    /**
     * 通过手机验证码登录，如果之前缓存了openid数据，则关联或者更新
     * @param {string} $param 包含手机号、验证码
     * @return: 用户信息
     */
    public function login($param)
    {
        $validate = validate('Login');
        if(!$validate->check($param)){
            $this->error=$validate->getError();
            $this->errcode=-2002;
            return false;
        }
        $userInfo=$this->getByMobile($param['mobile']);       
        if(!$userInfo){
            $param['password']=randomkeys();
            $this->allowField('mobile,password')->save($param);
            $userInfo=$this->getByMobile($param['mobile']);
        }
        if ($userInfo['status'] === 0) {
			$this->error = '帐号被禁用，登录失败';
			$this->errcode = -1006;
			return false;
        }
        //更新/添加openid
        $openidInfo=cache('openid'.$param['authkey']);
        if(!$openidInfo){
            $this->error = "非法请求，请从微信登录";
            $this->errcode=-2002;
            return false;
        }
        cache('openid'.$param['authkey'],null);
        $openidModel=model('openid');
        $openid_id=$openidModel->getFieldByOpenid($openidInfo['openid'],'id');
        $openidData=[
            'user_id'   => $userInfo['id'],
            'wechat_id' => $openidInfo['wechat_id'],
            'openid'    => $openidInfo['openid'],
        ];
        if(!$openid_id)
            $openidData['id'] =$openid_id;
        $id=$openidModel->save($openidData);
        $tokenModel=model('token');
        $tokenData=[
            'user_id'   => $userInfo['id'],
            'openid_id'    => $openidModel->id,
            'token'     => randomkeys(),
            'remark'    => '系统生成',
        ];
        $tokenModel->save($tokenData);
        cache('userInfo'.$param['authkey'], $userInfo, config('LOGIN_SESSION_VALID'));
        $secret['mobile'] = $userInfo['mobile'];
        $secret['password'] = $userInfo['password'];
        $data=[
            'userInfo' => $userInfo,
            'rememberKey'=>encrypt($secret)
        ];
        return $data;
    }

    /**
     * 通过openid登录
     * @param {string} $param 包含openid、wechat_id、authkey
     * @return: 用户信息
     */
    public function loginByOpenid($param)
    {
        if(!isset($param['authkey'])){
            $this->error = '非法请求，服务器拒绝服务：AuthKey';
            $this->errcode = -2002;
            return false;
        }
        if(isset($param['openid']) && strlen($param['openid'])<10){
            $this->error = '获取微信授权出错，登录失败';
            $this->errcode = -4002;
            return false;
        }
        $userInfo=$this->hasWhere('openids',['openid'=>$param['openid']])->find();
        if(!$userInfo){
            cache('openid'.$param['authkey'],$param,3600);
            $this->error='当前微信账号暂未关联账户';
            $this->errcode = -1005;
            return false;
        }
        if ($userInfo['status'] == 0) {
			$this->error = '登录失败，帐号被禁用';
			$this->errcode = -1006;
			return false;
        }
        cache('userInfo'.$param['authkey'], $userInfo, config('LOGIN_SESSION_VALID'));
        $secret['mobile'] = $userInfo['mobile'];
        $secret['password'] = $userInfo['password'];
        $data=[
            'userInfo' => $userInfo,
            'rememberKey'=>encrypt($secret)
        ];
        return $data;
    }

   /**
     * 通过保存在客户端的rememberKey登录
     * @param {string} $param 包含rememberKey
     * @return: 用户信息
     */
    public function relogin($param)
    {
        $data = decrypt($param['rememberKey']);
        if(!isset($data['mobile']) || !isset($data['password'])){
            $this->error = '非法请求，服务器拒绝服务：RememberKey';
            $this->errcode = -2002;
            return false;
        }
        $mobile = $data['mobile'];
        $password = $data['password'];
        $userInfo=$this->where(['mobile'=>$mobile, 'password'=>$password])->find();
        if(!$userInfo){
            $this->error = '非法请求，服务器拒绝服务：UserInfo';
            $this->errcode = -2002;
            return false;
        }
        if ($userInfo['status'] === 0) {
			$this->error = '帐号被禁用，登录失败';
			$this->errcode = -1006;
			return false;
        }
        cache('userInfo'.$param['authkey'], $userInfo, config('LOGIN_SESSION_VALID'));
        $data=[
            'userInfo' => $userInfo,
            'rememberKey'=>$param['rememberKey']
        ];
        return $data;
    }    
}