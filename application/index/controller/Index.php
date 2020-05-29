<?php
namespace app\index\controller;

use think\facade\Request;

class Index
{
    public function index()
    {
        return json(['status'=>'thinkvue OK.']);
    }

}
