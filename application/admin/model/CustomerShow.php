<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\Common;

class CustomerShow extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'admin_customer_show';

    public function getDataForUser($customer_id)
    {
        $data = $this
                ->where(['customer_id'=> $customer_id,'user_id'=>$GLOBALS['userInfo']['id']])
                ->find();
        if($data)
            return $data;
        else{
            $this->error = '没有找到数据或者没有权限';
            return false;
        }
    }

}