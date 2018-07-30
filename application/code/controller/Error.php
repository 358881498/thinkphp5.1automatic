<?php

namespace app\code\controller;
use think\Controller;
use think\Request;

class Error extends Controller
{
    //空控制器
    public function index(Request $request)
    {
        return $this->error($request->controller().'是空控制器！');
    }
}