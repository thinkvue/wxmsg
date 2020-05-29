<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\cms\model;

use app\common\model\Common;

class CmsCate extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'cms_cate';

    /**
     * 一对多关联文章
     */
    public function articles()
    {
        return $this->hasMany('CmsArticle');
    }    


	/**
	 * [getDataList 获取列表]
	 * @param string $userId 用户ID（非客户ID）
	 * @param int $page 页数
	 * @param string $key 搜索关键字
	 * @return    [array]                         
	 */
	public function getDataList()
	{	
		$map="id > 1";
		$data = $this
				->where($map)
				->select()
				->toArray();
		return $data;		
	}

}