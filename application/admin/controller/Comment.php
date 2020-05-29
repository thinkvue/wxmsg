<?php
// +----------------------------------------------------------------------
// | Description: 评论
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Comment extends ApiCommon
{
    public function List()
    {
        $customer_id = $this->param['id'];
        if(!$customer_id)
            return resultArray(['error'=>'参数不正确'],-2002);
        if(!model('CustomerShow')->getDataForUser($customer_id))
            return resultArray(['error' =>'没有找到数据或者没有权限'],-3004);
        $page = $this->param['page']??1;
        $key = $this->param['key'];
        $data = model('Comment')->getDataList($customer_id, $page, $key);
        return resultArray(['data' =>$data]);
    }    
}
 