<?php
// +----------------------------------------------------------------------
// | Description: 系统配置
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\Common;

class SystemConfig extends Common 
{

	/**
	 * 获取配置列表
	 * @param  array   $param  [description]
	 */
	public function getDataList()
	{
		$list = $this->where('group',0)->select();
		$data = array();
        foreach ($list as $key => $val) {
            $data[$val['name']] = $val['value'];
        }
        return $data;
	}

	/**
	 * 批量修改配置
	 * @param  array   $param  [description]
	 */
	public function createData($param)
	{
		$list = [
		    ['id' => 1, 'value' => $param['SYSTEM_NAME']],
		    ['id' => 2, 'value' => $param['SYSTEM_LOGO']],
		    ['id' => 3, 'value' => $param['LOGIN_SESSION_VALID']],
		    ['id' => 4, 'value' => $param['IDENTIFYING_CODE']],	
		    ['id' => 5, 'value' => $param['LOGO_TYPE']],			
		];
		if ($this->saveAll($list)) {
			$data = $this->getDataList();
			cache('DB_CONFIG_DATA', $data, 3600);
			return $data;
		}
		$this->error = '更新失败';
		return false;
	}

	/**
	 * 获取openid配置列表
	 * @param  array   $param  [description]
	 */
	public function getOpenidDataList()
	{
		$list = $this->where('group',1)->select();
		$data = array();
        foreach ($list as $key => $val) {
            $data[$val['name']] = $val['value'];
        }
        return $data;
	}

	/**
	 * 修改openid
	 * @param  array   $param  [description]
	 */
	public function saveConfigs($param)
	{
		$list = getSystemConfig();
		$data =[];
		foreach ($list as $k => $v)
		{
			if(isset($param[$v['name']]))
				$list[$v['name']]['value']=$param[$v['name']];
			$data[]=$list[$v['name']];
		}
		if ($this->saveAll($data)) {
				cache('thinkvue', null);
			return getSystemConfig();
		}
		$this->error = '更新失败';
		return false;
	}
}