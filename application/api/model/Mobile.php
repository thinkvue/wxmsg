<?php

namespace app\api\model;

use app\common\model\Common;
use think\Model;

class Mobile extends Model
{
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'api_mobile_city';

    /**
     * 获取手机段信息
     * @param {type} 
     * @return: 
     */
    public function getMobile($param)
    {
        $reg='/^[1](([3][0-9])|([4][5-9])|([5][0-3,5-9])|([6][5,6])|([7][0-8])|([8][0-9])|([9][1,8,9]))[0-9]{4,8}$/';
        if(!isset($param['mobile']) || !preg_match($reg,$param['mobile'])){
            $this->error = "手机号或者手机段不正确";
            $this->errcode=-2002;
            return false;
        }
        $mobile=$param['mobile'];
        if(strlen($mobile)>7)
            $mobile=substr($mobile,0,7);
        $data=$this->getByMobile($mobile);
        if($data){
            $data['merge']="{$data['province']}{$data['city']} {$data['isp']}";
            return $data;
        }
        $this->errcode=-1;
        $this->error='数据库中没有此数据';
        return false;
    }
}