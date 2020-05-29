<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Db;
use app\common\model\Common;

class Menu extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'admin_menu';
	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @return    [array]                         
	 */
	public function getDataList()
	{	
        $cat = new \com\Category('admin_menu', array('id', 'pid', 'title', 'title'));     
        $data = $cat->getList('', 0, 'sort'); 
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
		$data = $this
				->alias('menu')
				->where('menu.id', $id)
				->join('admin_rule rule', 'menu.rule_id=rule.id', 'LEFT') 
				->field('menu.*, rule.title as rule_name')
				->find();
		if (!$data) {
			$this->error = '暂无此数据';
			return false;
		}
		return $data;
	}


	/**
	 * 整理菜单树形结构
	 * @param  array   $param  [description]
	 */
    protected function getMenuTree()
    {	
    	$userInfo = $GLOBALS['userInfo'];
    	if (!$userInfo) {
    		return [];
    	}
    	
    	$u_id = $userInfo['u_id'];
    	if ($u_id === 1) {
			$map[]= ['status','=',1]; 
    		$menusList = Db::name('admin_menu')->where($map)->order('sort asc')->select();
    	} else {
    		$groups = model('User')->get($u_id)->groups;
    		
            $ruleIds = [];
    		foreach($groups as $k => $v) {
    			$ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
			}
			$ruleMap[] = ['id','in', $ruleIds];
            $ruleMap[] = ['status','=',1];
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $ruleIds =  Db::name('admin_rule')->where($ruleMap)->column('id');
            // empty($ruleIds)&&$ruleIds = ''; //TODO:NOTEPAD
    		$menuMap[] = ['status','=',1]; 
            $menuMap[] = ['rule_id','in',$ruleIds];
            $menusList =  Db::name('admin_menu')->where($menuMap)->order('sort asc')->select();
        }
        if (!$menusList) {
            return [];
        }
        //处理成树状
        $tree = new \com\Tree();
        $menusList = $tree->list_to_tree($menusList, 'id', 'pid', 'child', 0, true, array('pid'));
        $menusList = memuLevelClear($menusList);
        
        return $menusList? $menusList: [];
    }

}