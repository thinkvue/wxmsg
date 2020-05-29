<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\cms\model;

use app\common\model\Common;

class CmsArticle extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'cms_article';

	/**
	 * [getDataList 获取列表]
	 * @param string $userId 用户ID（非客户ID）
	 * @param int $page 页数
	 * @param string $key 搜索关键字
	 * @return    [array]                         
	 */
	public function getDataList($catId=0,$page=1,$key=null,$order=1)
	{	
		if($catId != 0)
			$map[]=["catid", "=" ,$catId];
		elseif($catId==0)
			$map[]=["catid", ">", 1];
		if($key)
			$map[]=["title|content|summary","like","'%{$key}%'"];
		$order=$order==1 ? ['hits'=>'desc','sort'=>'desc'] : ['sort'=>'desc','id'=>'desc'];
		$data = $this
				->where($map)
				->field(['content'], true)
				->page($page,config('ListMember'))
				->order($order)
				// ->fetchSql(true)
				->select()
				->toArray();
		return $data;		
	}

}