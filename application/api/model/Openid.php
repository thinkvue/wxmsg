<?php

namespace app\api\model;

use app\common\model\Common;

class Openid extends Common
{
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'api_user_openid';

    /**
	* thinkphp模型一对多关联
	*/
	public function tokens()
	{
		return $this->hasMany('token','openid_id');
	}

    /**
     * 获取令牌后的用户openid
     * @param {string} $token 用户令牌 
     * @return: 用户信息
     */
    public function getOpenid($token)
    {
        if(!$token){
            $this->error='参数不正确，token不可为空';
            $this->errcode=-2002;
            return false;
        }
        $data=$this
            ->alias('a')
            ->join('api_user_token b','a.id=b.openid_id')
            ->where('b.token',$token)
            ->field(['a.id'=>'id','a.user_id'=>'user_id','a.wechat_id'=>'wechat_id','a.openid'=>'openid','b.id'=>'token_id','b.token'=>'token','b.remark'=>'remark'])
            ->find();
        if(!$data){
            $this->error='没有找到相应的token，请确认token是否被重置或者删除';
            $this->errcode=-3004;
            return false;
        }
        return $data;
    }
}