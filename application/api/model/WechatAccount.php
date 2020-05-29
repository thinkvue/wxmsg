<?php

namespace app\api\model;

use app\common\model\Common;

class WechatAccount extends Common
{
    //软删除
    protected $deleteTime = 'delete_time';
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'api_wechat_account';

    /**
	* thinkphp模型一对多关联
	*/
	public function openids()
	{
		return $this->hasMany('openid','wechat_id');
	}
}