<?php
// +----------------------------------------------------------------------
// | Description: 系统配置
// +----------------------------------------------------------------------

namespace app\admin\controller;

class SystemConfigs extends ApiCommon
{
    public function save()
    {
        $configModel = model('SystemConfig');
        $param = $this->param;
        $data = $configModel->createData($param);
        cache('DB_CONFIG_DATA', null); //清除缓存
        if (!$data) {
            return resultArray(['error' => $configModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);	
    }

}
 