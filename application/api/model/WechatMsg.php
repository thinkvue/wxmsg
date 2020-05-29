<?php

namespace app\api\model;

use app\common\model\Common;

class WechatMsg extends Common
{
    //软删除
    protected $deleteTime = 'delete_time';

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'api_wechat_msg';

    /**
     * 发送微信模板消息
     * @param {Object} $param 至少包含title、token 
     * @return: 标准返回
     */
    public function sendMsg($param)
    {
        if(!isset($param['title']) || !isset($param['token'])){
            $this->errcode=-2002;
            $this->error='缺少参数，请查看API';
            return false;
        }
        $openidModel=model('Openid');
        $data=$openidModel->getOpenid($param['token']);
        if(!$data){
            $this->error=$openidModel->error;
            $this->errcode=$openidModel->errcode;
            return false;
        }
        $param['openid']=$data['openid'];
        $param['wechat_id']=$data['wechat_id'];
        if(!isset($param['keyword1']))
            $param['keyword1']=$data['remark'];
        if(isset($param['settime']))
            $param['settime']=$param['settime']<31536000?time()+$param['settime']:$param['settime'];
        $template_model=model('template');
        if(isset($param['template_id'])){ 
            $tp_id=$template_model->where(['id'=>$param['template_id'],'wechat_id'=>$param['wechat_id']])->find();
            if(!$tp_id){
                $this->error="该公众号下不存在指定的模板ID";
                $this->errcode=-2002;
                return false;
            }
        }
        else
            $param['template_id']=$template_model->getIdByWechatid($param['wechat_id']);
        $this->allowField(true)->save($param);
        return "已加入消息队列";
    }
}