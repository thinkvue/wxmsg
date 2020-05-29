<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\cms\controller;

use app\common\controller\Common;

class Article extends Common
{
    public function cateList()
    {
        return resultArray(['data' =>model('CmsCate')->getDataList()]);
    }

    public function articleList()
    {
        $page = $this->param['page']??1;
        $order = $this->param['order']??1;
        $cateid = $this->param['cateid']??0;
        $key = $this->param['key'];
        $data = model('CmsArticle')->getDataList($cateid,$page,$key,$order);
        return resultArray(['data' =>$data]);
    } 

    public function article()
    {
        $id = $this->param['id'];
        if(!$id)
            return resultArray(['error' =>'缺少参数，服务器拒绝服务'],-2002);
        $model=model('CmsArticle');
        $data = $model->getDataById($id);
        if(!$data)
            return resultArray(['error'=>$model->getError()],$model->getErrcode());
        return resultArray(['data' =>$data]);
    }     
}
 