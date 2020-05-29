<?php
// +----------------------------------------------------------------------
// | Description: 佣金
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Commission extends ApiCommon
{
    public function list()
    {
        $page = $this->param['page']??1;
        $key = $this->param['key'];
        $userid = $GLOBALS['userInfo']['id'];
        $data = model('Commission')->getDataList($userid, $page, $key);
        return resultArray(['data' =>$data]);
    }
}
 