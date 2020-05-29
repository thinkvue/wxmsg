<?php
// +----------------------------------------------------------------------
// | Description: 图片上传
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;

class Upload extends Controller
{   
    public function index()
    {	

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $file = request()->file('file');
        if (!$file) {
        	return resultArray(['error' => '请上传文件']);
        }
        
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(Env::get('root_path') . '/public/uploads');
        if ($info) {
            return resultArray(['data' =>  'uploads/' . $info->getSaveName()]);
        }
        
        return resultArray(['error' =>  $file->getError()]);
    }
}
 