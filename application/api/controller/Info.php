<?php
/*
 * @Author: thinkvue@thinkvue.cn
 * @URL: https://thinkvue.com
 * @Date: 2020-05-30 23:11:29
 * @LastEditors: thinkvue@thinkvue.cn
 * @LastEditTime: 2020-05-31 00:27:29
 * @FilePath: \\gitee\\application\\api\\controller\\Info.php
 * @Description:  
 */ 
// +----------------------------------------------------------------------
// | Description: 公开API
// +----------------------------------------------------------------------

namespace app\api\controller;

use app\common\controller\Common;
use com\ip\IpLocation;

class Info extends Common
{
    /**
     * 发送微信模板消息
     * @param {array} <title,token [,color,keyword1,keyword2,keyword3,remark,template_id,settime]> 
     * @return: {json} {"code":1/-1,"data":"","error":""}
     */
    public function msg()
    {
        $model=model('WechatMsg');
        $data=$model->sendMsg($this->param);
        if(!$data)
            return resultArray(['error'=>$model->getError()],$model->getErrcode());
        return resultArray(['data'=>$data]);        
    }

    /**
     * 微信登录
     * @param {array} param 至少包含code，微信auth三方授权机制中的code 
     * @return: {json} 标准返回
     */
    public function loginByWechat()
    {
        if(!isset($this->param['code']))
            return resultArray(['error' =>'非法请求，服务器拒绝服务：LoginByWechat'],-2002);
        $code=$this->param['code'];
        $wechat_id= isset($this->param['wechat_id'])?$this->param['wechat_id']:1;
        $openid_data=getTokenOpenid($code,$wechat_id);
        // $openid_data=['code'=>1,'openid'=>'oapHA51t3smfchRbFVfrodwX6TGY']; // TODO:调试
        if($openid_data['code']<0)
            return resultArray(['error' => $openid_data['msg']],$openid_data['code']);
        $this->param['openid']=$openid_data['openid'];
        $userModel = model('User');
        $data = $userModel->loginByOpenid($this->param);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    /**
     * 以保存在客户端的rememberKey登录
     * @param {array} param 至少包含rememberKey 
     * @return: {json} 标准返回
     */
    public function relogin()
    {   
        $userModel = model('User');
        $data = $userModel->relogin($this->param);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()],$userModel->getErrcode());
        } 
        return resultArray(['data' => $data]);
    }

    /**
     * 通过手机验证码登录
     * @param {array} param 至少包含mobile和msgcode
     * @return: {json} 标准返回
     */
    public function login()
    {
        $model=model('User');
        $data=$model->login($this->param);
        if(!$data)
            return resultArray(['error'=>$model->getError()],$model->getErrcode());
        return resultArray(['data'=>$data]);        
    }
}
