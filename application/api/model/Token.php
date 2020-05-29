<?php

namespace app\api\model;

use app\common\model\Common;
use think\model\concern\SoftDelete;

class Token extends Common
{
    use SoftDelete;
    //软删除
    protected $deleteTime = 'delete_time';

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'api_user_token';

    protected $userInfo=[];

    /**
	* 获取OPENID，thinkphp模型一对多关联
	*/
	public function openids()
	{
		return $this->hasMany('openid','user_id');
	}

    /**
     * 列表
     * @param {string} $param 包含authkey
     * @return: token列表
     */
    public function list($param)
    {
        if(!$this->check($param))
            return false;
        $data=$this->where('user_id',$this->userInfo['id'])->select()->toArray();
        return $data;
    }

    /**
     * 添加token
     * @param {string} $param 包含authkey
     * @return: 用户信息
     */
    public function add($param)
    {
        if(!$this->check($param))
            return false;
        $openidModel=model('openid');
        $openidId=$openidModel
            ->where(['user_id'=>$this->userInfo['id'],'wechat_id'=>$param['wechat_id']])
            ->value('id');
        if(!$openidId){
            $this->error = '非法请求，服务器拒绝服务：Token/Add';
            $this->errcode = -2002;
            return false;
        }
        $data=[
            'user_id'   => $this->userInfo['id'],
            'openid_id'    => $openidId,
            'token'     => randomkeys(),
            'remark'    => $param['remark'],
        ];
        $this->save($data);
        return $this->list($param);
    }

    /**
     * 删除token
     * @param {string} $param 包含authkey、id
     * @return: 用户信息
     */
    public function del($param)
    {
        if(!$this->check($param))
            return false;
        $tokenData=$this->get($param['id']);
        if($tokenData && $tokenData['user_id']==$this->userInfo['id'])
            $tokenData->delete();
        return $this->list($param);
    }

    /**
     * 检查参数，并获取用户信息
     * @param {array} $param
     * @return: 标准返回
     */
    public function check($param)
    {
        if(!isset($param['authkey']) || !cache('userInfo'.$param['authkey'])){
            $this->error = '登录超时，请重新登录！';
            $this->errcode = -1001;
            return false;
        }
        $this->userInfo=cache('userInfo'.$param['authkey']);
        cache('userInfo'.$param['authkey'],$this->userInfo,config('LOGIN_SESSION_VALID'));
        return true;
    }
}