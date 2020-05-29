<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\Common;
use app\admin\model\CustomerShow;

class Customer extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'admin_customer';


	/**
	 * [createData 新建]
	 * @param     array                    $param [description]
	 * @return    [array]                         [description]
	 */
	public function createData($param)
	{
		// 验证
		$validate = validate($this->name);
		if (!$validate->check($param)) {
			$this->error = $validate->getError();
			return false;
		}
		try {
			$customer_id=$this->data($param)->allowField(true)->save();
		} catch(\Exception $e) {
			$this->error = '添加失败';
			return false;
		}
		$customerShow=new CustomerShow;
		$data[]=[
			'customer_id'		=> $customer_id,
			'user_id'			=> $GLOBALS['userInfo']['id'], 
			'name'				=> $param['name'],
		];
		if($GLOBALS['userInfo']['pid'])
			$data[]=[
				'customer_id'		=> $customer_id,
				'user_id'			=> $GLOBALS['userInfo']['pid'], 
				'name'				=> '【下线】客户' . rand(1000000,9999999),
			];
		if($GLOBALS['userInfo']['gid'])
			$data[]=[
				'customer_id'		=> $customer_id,
				'user_id'			=> $GLOBALS['userInfo']['gid'], 
				'name'				=> '【下下线】客户' . rand(1000000,9999999),
			];
		$count=$customerShow->saveAll($data);
		if ($count>0) 
			return true;
		else
			$this->error = '添加失败';
			return false;
	}

	/**
	 * [getDataList 获取列表]
	 * @param string $userId 用户ID（非客户ID）
	 * @param int $page 页数
	 * @param string $key 搜索关键字
	 * @return    [array]                         
	 */
	public function getDataList($userId,$page=1,$key=null)
	{	
		$map="show.user_id={$userId}";
		if($key)
			$map=$map . " and (show.name like '%{$key}%' OR this.company like '%{$key}%' OR this.mobile like '%{$key}%')";
		$data = model('Customer')
				->alias('this')
				->where($map)
				->join([config('database.prefix').'admin_customer_show'=>'show'],'this.id=show.customer_id')
				->field([
					'this.id'			=>'id',
					'show.name'			=>'name',
					'this.sex'			=>'sex',
					'this.mobile'		=>'mobile',
					'this.company'		=>'company',
					'this.business'		=>'business',
					'this.city'			=>'city',
					'this.contact'		=>'contact',
					'this.sign'			=>'sign',
					'this.create_time'	=>'create_time',
					'this.delete_time'	=>'delete_time',
					'this.remark'		=>'remark',])
				->page($page,config('ListMember'))
				// ->fetchSql(true)
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