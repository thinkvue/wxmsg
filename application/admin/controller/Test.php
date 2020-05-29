<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;


class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\facade\Response
     */
    public function index()
    {
        // $secret['username'] = '13265551113';
        // $secret['password'] = '8496347029470b4940f601cb6e7564c3';
        // dump(encrypt($secret)); 
        cache('msgcode13265551113',6666);
        cache('msgcode13925551015',6666);
        dump("已加入消息队列");
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\facade\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\facade\Request  $request
     * @return \think\facade\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\facade\Request  $request
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\facade\Response
     */
    public function delete($id)
    {
        //
    }
}
