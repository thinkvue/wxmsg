<?php
// +----------------------------------------------------------------------
// | Description: 用户组
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\Common;

class Group extends Common 
{
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
	protected $name = 'admin_group';

	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @return    [array]                         
	 */
	public function getDataList()
	{
		$cat = new \com\Category('admin_group', array('id', 'pid', 'title', 'title'));
		$data = $cat->getList('', 0, 'id');
		
		return $data;
	}
}