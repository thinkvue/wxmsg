<?php
// +----------------------------------------------------------------------
// | Description: Api基础类，验证权限
// +----------------------------------------------------------------------
/**
 * 权限操作控制器基类，验证权限，子类可通过 `$GLOBALS['userInfo']` 获取当前用户的信息
 */
namespace app\api\controller;

use app\common\controller\Common;

class Token extends Common
{
    /**
     * 获取token列表
     * @param {null} Null
     * @return: {json} 标准返回
     */
    public function list()
    {
        $model=model('token');
        $data=$model->list($this->param);
        if(!is_array($data) && !$data)
            return resultArray(['error'=>$model->getError()],$model->getErrcode());
        return resultArray(['data'=>['token'=>$data]]);
    }

    /**
     * 添加token
     * @param {array} param 至少包含remark 和wechat_id
     * @return: {json} 标准返回
     */
    public function add()
    {
        $model=model('token');
        $data=$model->add($this->param);
        if(!is_array($data) && !$data)
            return resultArray(['error'=>$model->getError()],$model->getErrcode());
        return resultArray(['data'=>['token'=>$data]]);
    }

    /**
     * 删除token
     * @param {array} param 至少包含id 
     * @return: {json} 标准返回
     */
    public function delete()
    {
        $model=model('token');
        $data=$model->del($this->param);
        if(!is_array($data) && !$data)
            return resultArray(['error'=>$model->getError()],$model->getErrcode());
        return resultArray(['data'=>['token'=>$data]]);
    }
}
