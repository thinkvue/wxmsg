<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Member extends ApiCommon
{
    
    public function save()
    {
        $CustomerModel = model('user');
        $param = $this->param;
        $data = $CustomerModel->createStaffer($param);
        if (!$data) {
            return resultArray(['error' => $CustomerModel->getError()],$CustomerModel->getErrcode());
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function List()
    {
        $page = $this->param['page']??1;
        $key = $this->param['key'];
        $data = model('user')->getStaffer($page, $key);
        return resultArray(['data' =>$data]);
    }   
}
 