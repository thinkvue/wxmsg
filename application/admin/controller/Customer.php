<?php
// +----------------------------------------------------------------------
// | Description: 客户
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Customer extends ApiCommon
{
    
    public function save()
    {
        $CustomerModel = model('Customer');
        $param = $this->param;
        $data = $CustomerModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $CustomerModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function List()
    {
        $page = $this->param['page']??1;
        $key = $this->param['key'];
        $userid = $GLOBALS['userInfo']['id'];
        $data = model('Customer')->getDataList($userid, $page, $key);
        return resultArray(['data' =>$data]);
    }

    public function check()
    {
        $mobile = $this->param['mobile'];
        $data = model('Customer')->where('mobile',$mobile)->find();
        if(!$data)
            return resultArray(['data' =>'OK']);
        else
            return resultArray(['error'=>"已存在该客户，无法继续录入"]);
    }


}
 