<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\Common;

class Commission extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'admin_commission';
	/**
	 * [getDataList 获取列表]
	 * @param string $userId 用户ID（非客户ID）
	 * @param int $page 页数
	 * @param string $key 搜索关键字
	 * @return    [array]                         
	 */
	public function getDataList($userId,$page=1,$key=null)
	{	
		$map[]=['comm.user_id','=',$userId];
		if($key) $map[]=['show.name','like',"%{$key}%"];
		$data = $this
				->alias('comm')
				->where($map)
				->join([config('database.prefix').'admin_customer_show'=>'show'],'comm.customer_id=show.customer_id')
				->field([
					'show.name'			=> 'name',
					'comm.money'		=> 'money',
					'comm.create_time'	=> 'create_time',
					'comm.update_time'	=> 'update_time',
					'comm.status'		=> 'status',
					'comm.remark'		=> 'remark'])
				->page($page,config('ListMember'))
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
		$map[]=['comm.user_id'=> $id];
		$data = $this
				->alias('comm')
				->where($map)
				->join([config('database.prefix').'admin_customer_show'=>'show'],'comm.customer_id=show.customer_id')
				->field([
					'show.name'			=> 'name',
					'comm.money'		=> 'money',
					'comm.create_time'	=> 'create_time',
					'comm.update_time'	=> 'update_time',
					'comm.status'		=> 'status',
					'comm.remark'		=> 'remark'])
				->find();
		return $data;		
	}




}