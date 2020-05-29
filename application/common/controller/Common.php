<?php
// +----------------------------------------------------------------------
// | Description: 解决跨域问题
// +----------------------------------------------------------------------

namespace app\common\controller;

use think\Controller;

class Common extends Controller
{
    public $param;
    public function initialize()
    {
        parent::initialize();
        /*防止跨域*/      
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authkey, sessionid");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Expose-Headers:*'); 
        $this->param = input(); 
        $header=$this->request->header();
        $this->param['authkey']=isset($header['authkey'])?$header['authkey']:randomkeys();
        $this->param['sessionid']=isset($header['sessionid'])?$header['sessionid']:randomkeys();
    }

    public function object_array($array) 
    {  
        if (is_object($array)) {  
            $array = (array)$array;  
        } 
        if (is_array($array)) {  
            foreach ($array as $key=>$value) {  
                $array[$key] = $this->object_array($value);  
            }  
        }  
        return $array;  
    }
}
 