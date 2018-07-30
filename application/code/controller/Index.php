<?php
namespace app\code\controller;
use Build;
use think\Loader;
class Index extends Base
{
    //首页
    public function index()
    {
        return view();
    }
    //公共文件页面
    public function common(){
        return view();
    }
    //中间件
    public function middleware(){
        return view();
    }
}