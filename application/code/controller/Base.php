<?php
namespace app\code\controller;
use think\Controller;
use think\Db;
use think\Url;
use think\Response;
class Base extends Controller
{
    //空方法
    public function _empty()
    {
        return $this->error('空方法！');
    }
    //查询数据库所有表信息
    protected function tables()
    {
        $tables = Db::query('show table status');
        return $tables;
    }
    //查询表中所有字段信息
    protected function columns($table){
        $columns = Db::query("SHOW FULL COLUMNS FROM ".$table);
        return $columns;
    }
    
    
}
