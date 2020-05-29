<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\Common;

class Comment extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'admin_comment';
	/**
	 * [getDataList 获取列表]
	 * @param string $userId 用户ID（非客户ID）
	 * @param int $page 页数
	 * @param string $key 搜索关键字
	 * @return    [array]                         
	 */
	public function getDataList($customer_id,$page=1,$key='')
	{	
        if(!model('CustomerShow')->getDataForUser($customer_id)){
            $this->error = '没有找到数据或者没有权限';
            return [];
        }
        $map="customer_id={$customer_id}";
		if($key)
            $map=$map . " and (nickname like '%{$key}%' OR content like '%{$key}%')";
		$data = $this
				->where($map)
                ->page($page,config('ListMember'))
                ->order('id','DESC')
                // ->fetchSql()
				->select()
				->toArray();
		return $data;		
	}

	/**
	 * [getDataById 根据主键获取详情]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:16:34+0800
	 * @param     string                   $id [主键]
	 * @return    [array]                       
	 */
	public function getDataById($id = '')
	{
        $data = $this->get($id);
        if($data)
            return $data;
        else{
            $this->error = '没有找到数据';
            return $data;		
        }
	}




}