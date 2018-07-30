<?php
/**
 * Created by PhpStorm.
 * User: YCH
 * Date: 2018/7/23
 * Time: 14:54
 */

namespace app\code\controller;
use app\index\Build;
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
    //配置文件
    public function extra(){
        return view();
    }
    //获取模块
    public function mokuai(){
        $dir = dirname(dirname(dirname(__FILE__)));
        $files = array();
        if(is_dir($dir)){
            $child_dirs = scandir($dir);
            foreach($child_dirs as $child_dir){
                if($child_dir != '.' && $child_dir != '..' && $child_dir != "extra" && !strstr($child_dir, '.')){
                    $files[] = $child_dir;
                }
            }
        }
        return $files;
    }
    /*
     * 验证器
     * */
    //验证器页面
    public function validata1(){
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        return view();
    }
    //选择验证器信息
    public function validata2(){
        $name = input("validata_name");
        $this->assign('validata_name',$name);
        $table = input("table");
        if($table!=''){
            $cls = $this->columns($table);
            $this->assign('cls',$cls);
        }
        $mokuai = $this->mokuai();
        $this->assign('mokuai',$mokuai);
        return view();
    }
    //生成验证器代码
    public function validata3(){
        $vals = input('param.');
        $cls = $this->columns($vals['table']);
        $data = $this->validata($cls,$vals);
        $fields = "";
        if(empty($data['ss'])){
            foreach($cls as $c){
                if($c['Key'] != 'PRI'){
                    $fields.= "'".$c['Field']."',";
                }
            }
            $fields = trim($fields,',');
        }else{
            foreach($data['ss'] as $c){
                $fields.= "'".$c."',";
            }
            $fields = trim($fields,',');
        }
        if($vals['is_code'] == 2){

        }else{
            if(empty($vals['validata_name'])){
                $this->assign('table',$vals['table']);
            }else{
                $this->assign('table',$vals['validata_name']);
            }
            if(input('mokuai')){
                $mokuai = input('mokuai');
            }else{
                $mokuai = 'index';
            }
            $this->assign('rs',$data['rs']);
            $this->assign('ms',$data['ms']);
            $this->assign('fields',$fields);
            $this->assign('mokuai',$mokuai);
            return view();
        }

    }
    private function _getf($c){
        if($c['Comment']!=''){
            return $c['Comment'];
        }else
            return $c['Field'];
    }
    private function _name($k, $name, $value){
        if(empty($name)){
            $data = $this->_getf($k).$value;
        }else{
            $data = $name .$value;
        }
        return $data;
    }
    //验证器代码
    public function validata($cls,$vals){
        $ms = array();
        $rs = array();
        $ss = array();
        for($k=0;$k<count($cls);$k++){
            $c = $cls[$k]['Field'];
            if(isset($vals[$c])){
                if($vals[$c]=='on'){
                    $ss[] = $c;
                }
            }
            if(isset($vals[$c.'_'.'require'])){
                if($vals[$c.'_'.'require']=='on'){
                    $rs[$c][]='require';
                    $ms[$c.'.require'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'必填');
                }
            }
            if(isset($vals[$c.'_'.'number'])){
                if($vals[$c.'_'.'number']=='on'){
                    $rs[$c][]='number';
                    $ms[$c.'.number'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为数字');
                }
            }
            if(isset($vals[$c.'_'.'float'])){
                if($vals[$c.'_'.'float']=='on'){
                    $rs[$c][]='float';
                    $ms[$c.'.float'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为小数');
                }
            }
            if(isset($vals[$c.'_'.'boolean'])){
                if($vals[$c.'_'.'boolean']=='on'){
                    $rs[$c][]='boolean';
                    $ms[$c.'.boolean'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为布尔');
                }
            }
            if(isset($vals[$c.'_'.'email'])){
                if($vals[$c.'_'.'email']=='on'){
                    $rs[$c][]='email';
                    $ms[$c.'.email'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为邮箱格式');
                }
            }
            if(isset($vals[$c.'_'.'accepted'])){
                if($vals[$c.'_'.'accepted']=='on'){
                    $rs[$c][]='accepted';
                    $ms[$c.'.accepted'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为是和否');
                }
            }
            if(isset($vals[$c.'_'.'date'])){
                if($vals[$c.'_'.'date']=='on'){
                    $rs[$c][]='date';
                    $ms[$c.'.date'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为日期');
                }
            }
            if(isset($vals[$c.'_'.'alpha'])){
                if($vals[$c.'_'.'alpha']=='on'){
                    $rs[$c][]='alpha';
                    $ms[$c.'.alpha'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为字母');
                }
            }
            if(isset($vals[$c.'_'.'array'])){
                if($vals[$c.'_'.'array']=='on'){
                    $rs[$c][]='array';
                    $ms[$c.'.array'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为数组');
                }
            }
            if(isset($vals[$c.'_'.'alphaNum'])){
                if($vals[$c.'_'.'alphaNum']=='on'){
                    $rs[$c][]='alphaNum';
                    $ms[$c.'.alphaNum'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为字母数字');
                }
            }
            if(isset($vals[$c.'_'.'alphaDash'])){
                if($vals[$c.'_'.'alphaDash']=='on'){
                    $rs[$c][]='alphaDash';
                    $ms[$c.'.alphaDash'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为字母数字下划线等');

                }
            }
            if(isset($vals[$c.'_'.'activeUrl'])){
                if($vals[$c.'_'.'activeUrl']=='on'){
                    $rs[$c][]='activeUrl';
                    $ms[$c.'.activeUrl'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为域名/IP');

                }
            }
            if(isset($vals[$c.'_'.'url'])){
                if($vals[$c.'_'.'url']=='on'){
                    $rs[$c][]='url';
                    $ms[$c.'.url'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为URL');
                }
            }
            if(isset($vals[$c.'_'.'ip'])){
                if($vals[$c.'_'.'ip']=='on'){
                    $rs[$c][]='ip';
                    $ms[$c.'.ip'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为ip');

                }
            }
            if(isset($vals[$c.'_'.'phone'])){
                if($vals[$c.'_'.'phone']=='on'){
                    $rs[$c][]='regex:/^1[345789]\d{9}$/';
                    $ms[$c.'.phone'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为手机号格式');
                }
            }
            if(isset($vals[$c.'_'.'shen'])){
                if($vals[$c.'_'.'shen']=='on'){
                    $rs[$c][]='regex:/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/i';
                    $ms[$c.'.shen'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'为身份证格式');
                }
            }
            if(isset($vals[$c.'_'.'regex'])){
                if($vals[$c.'_'.'regex']!=''){
                    $rs[$c][]='regex:'.$vals[$c.'_'.'regex'];
                    $ms[$c.'.regex'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'无法通过验证');
                }
            }
            if(isset($vals[$c.'_'.'confirm'])){
                if($vals[$c.'_'.'confirm']!=''){
                    $rs[$c][]='confirm:'.$vals[$c.'_'.'confirm'];
                    $ms[$c.'.confirm'] = $this->_name($cls[$k],'和'.$vals[$c.'_'.'confirm'],'不一致');
                }
            }
            if(isset($vals[$c.'_'.'max'])){
                if($vals[$c.'_'.'max']!=''){
                    $rs[$c][]='max:'.$vals[$c.'_'.'max'];
                    $ms[$c.'.max'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'最大值为'.$vals[$c.'_'.'max']);

                }
            }
            if(isset($vals[$c.'_'.'min'])){
                if($vals[$c.'_'.'min']!=''){
                    $rs[$c][]='min:'.$vals[$c.'_'.'min'];
                    $ms[$c.'.min'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'最小值为'.$vals[$c.'_'.'min']);
                }
            }
            if(isset($vals[$c.'_'.'before'])){
                if($vals[$c.'_'.'before']!=''){
                    $rs[$c][]='before:'.$vals[$c.'_'.'before'];
                    $ms[$c.'.before'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'必须在'.$vals[$c.'_'.'before'].'之前');
                }
            }
            if(isset($vals[$c.'_'.'after'])){
                if($vals[$c.'_'.'after']!=''){
                    $rs[$c][]='after:'.$vals[$c.'_'.'after'];
                    $ms[$c.'.after'] = $this->_name($cls[$k],$vals[$c.'_'.'name'],'必须在'.$vals[$c.'_'.'before'].'之后');
                }
            }
        }
        $data = [
            'rs' => $rs,
            'ms' => $ms,
            'ss' => $ss,
        ];
        return $data;
    }
    /*
     * 生成模型代码
     * */
    //模型页面
    public function model1(){
        $this->assign('type',input('id'));
        $this->assign('mokuai',$this->mokuai());
        //代码
        $tables = $this->tables();
        $this->assign('tables',$tables);
        return view();
    }
    //数据表名转换成符合模型命名规格的字符串
    public function parseName($name, $type = 0, $ucfirst = true){
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
    //生成模型代码
    public function model2(){
        $data = input('param.');
        if(empty($data['table'])){
            $this->error('缺少表');
            return;
        }
        $model = empty($data['model']) ? 'Model': $data['model'];
        $mokuai = empty($data['mokuai']) ? 'index': $data['mokuai'];
        $cls = $this->columns($data['table']);
        $key = $autotime = $issoftdelete = null;
        foreach ($cls as $c){
            if($c['Key']=='PRI'){
                $key = $c['Field'];
            }else if($c['Field'] == 'create_time'){
                $autotime = 1;
                $type = $c['Type'];
                $this->assign('type',$type);
            }else if($c['Field'] == 'update_time'){
                $autotime= 1;
                $type = $c['Type'];
                $this->assign('type',$type);
            }else if($c['Comment'] == '软删除'){
                $issoftdelete = 1;
                $this->assign('delfield',$c['Field']);
            }
        }
        $array[] = $data['table'];
        $data['table'] = $this->parseName(array_pop($array), 1);
        $this->assign('table',$data['table']);
        $this->assign('modelLayer',$data['modelLayer']);
        $this->assign('model',$model);
        $this->assign('mokuai',$mokuai);
        $this->assign('autotime',$autotime);
        $this->assign('issoftdelete',$issoftdelete);
        $this->assign('pk',$key);
        return view();
    }
    //生成模型文件
    public function model3(){
        $data = input('param.');
        $model = empty($data['model']) ? 'Model': $data['model'];
        $mokuai = empty($data['mokuai']) ? 'index': $data['mokuai'];
        $modelLayer = input('modelLayer');
        if(!empty($data['table'])){
            //一个模型文件
            $cls = $this->columns($data['table']);
            $key = $autotime = $issoftdelete = $type = $delfield = null;
            foreach ($cls as $c){
                if($c['Key']=='PRI'){
                    $key = $c['Field'];
                }else if($c['Field'] == 'create_time'){
                    $autotime = 1;
                    $type = $c['Type'];
                }else if($c['Field'] == 'update_time'){
                    $autotime= 1;
                    $type = $c['Type'];
                }else if($c['Comment'] == '软删除'){
                    $issoftdelete = 1;
                    $delfield = $c['Field'];
                }
            }
            $table = $data['table'];
            $array[] = $data['table'];
            $t = $this->parseName(array_pop($array), 1);
            $modelbuild = $this->modelbuild($mokuai,$modelLayer,$t);
            $build = new Build;
            if($modelLayer == 'model'){
                //数据层
                $txt = $this->modeltxt($mokuai,$model,$t,$table,$key,$autotime,$type,$issoftdelete,$delfield);
                $build->run($modelbuild,$txt);
                $this->success('数据层模型完成');
            }elseif($modelLayer == 'logic'){
                //逻辑层
                $txt = $this->logictxt($mokuai,$t,$key);
                $build->run($modelbuild,$txt);
                $this->success('逻辑层模型完成');
            }else{
                //服务层
                $txt = $this->servicetxt($mokuai,$t);
                $build->run($modelbuild,$txt);
                $this->success('服务层模型完成');
            }
        }else{
            //全部模型文件
            //代码
            $tables = $this->tables();
            $build = new Build;
            if($modelLayer == 'model'){
                //数据层
                foreach ($tables as $table){
                    $array = null;
                    $array[] = $table['Name'];
                    $t = $this->parseName(array_pop($array), 1);
                    $modelbuild = $this->modelbuild($mokuai,$modelLayer,$t);
                    $cls = $this->columns($table['Name']);
                    $key = $autotime = $issoftdelete = $type = $delfield = null;
                    foreach ($cls as $c){
                        if($c['Key']=='PRI'){
                            $key = $c['Field'];
                        }else if($c['Field'] == 'create_time'){
                            $autotime = 1;
                            $type = $c['Type'];
                        }else if($c['Field'] == 'update_time'){
                            $autotime= 1;
                            $type = $c['Type'];
                        }else if($c['Comment'] == '软删除'){
                            $issoftdelete = 1;
                            $delfield = $c['Field'];
                        }
                    }
                    $txt = $this->modeltxt($mokuai,$model,$t,$table['Name'],$key,$autotime,$type,$issoftdelete,$delfield);
                    $build->run($modelbuild,$txt);
                }
                $this->success('数据层模型完成');
            }
            elseif($modelLayer == 'logic'){
                //逻辑层
                foreach ($tables as $table){
                    $array = null;
                    $array[] = $table['Name'];
                    $t = $this->parseName(array_pop($array), 1);
                    $modelbuild = $this->modelbuild($mokuai,$modelLayer,$t);
                    $cls = $this->columns($table['Name']);
                    $key = null;
                    foreach ($cls as $c){
                        if($c['Key']=='PRI'){
                            $key = $c['Field'];
                        }
                    }
                    $txt = $this->logictxt($mokuai,$t,$key);
                    $build->run($modelbuild,$txt);
                }
                $this->success('逻辑层模型完成');
            }
            else{
                //服务层
                foreach ($tables as $table){
                    $array = null;
                    $array[] = $table['Name'];
                    $t = $this->parseName(array_pop($array), 1);
                    $modelbuild = $this->modelbuild($mokuai,$modelLayer,$t);
                    $txt = $this->servicetxt($mokuai,$t);
                    $build->run($modelbuild,$txt);
                }
                $this->success('服务层模型完成');
            }
        }
    }
    //服务层
    public function servicetxt($mokuai,$table){
        $txt = "<?php
namespace app\\$mokuai\service;
use think\Model;
//服务层模型 -- 调用逻辑层模型 -- 与控制器交互
class $table extends Model
{
    //查询
    public function findData()
    {
        \$where = \$this->getWhere(input('param.'));
        \$data = model('$table','logic')
            ->getAll(\$where);
        return \$data;
    }
    //添加
    public function add()
    {
        \$post = \$this->getData(input('param.'));
        \$data = model('$table','logic')
            ->add(\$post);
        return \$data;
    }
    //编辑
    public function edit()
    {
        \$post = \$this->getData(input('param.'));
        \$data = model('$table','logic')
            ->updateWhere(\$post);
        return \$data;
    }
    //删除
    public function del()
    {
        \$where = \$this->getWhere(input('param.'));
        \$data = model('$table','logic')
            ->del(\$where);
        return \$data;
    }
    //组成数据
    public function getData(\$data = null)
    {
        return \$data;
    }
    //组成查询条件
    public function getWhere(\$where = null)
    {
        return \$where;
    }
}";
        return $txt;
    }
    //逻辑层
    public function logictxt($mokuai,$table,$key){
        $txt = "<?php
namespace app\\$mokuai\logic;
use think\Model;
//逻辑层模型 -- 调用数据层模型 -- 编写其他逻辑
class $table extends Model
{
    //获取多条数据
    public function getAll(\$where = null)
    {
        \$res = model('$table')
            ->all(\$where);
        return \$res;
    }
    //获取分页数据
    public function getPage(\$where = null)
    {
        \$res = model('$table')
            ->where(\$where)
            ->paginate(config(\"list_rows\"),false,['query'=>request()->param()]);
        return \$res;
    }
    //获取一条数据
    public function getOne(\$where = 1)
    {
        //默认获取主键为1的数据
        \$res = model('$table')
            ->get(\$where);
        return \$res;
    }
    //查找并更新
    public function getAndEdit(\$where = null, \$data = null)
    {
        if(empty(\$data) || empty(\$where)){
            return '\$data或\$where变量为空';
        }
        //默认获取主键为1的数据
        \$res = model('$table')
            ->get(\$where)
            ->save(\$data);
        return \$res;
    }
    //主键更新
    public function updateid(\$data)
    {
        \$res = model('$table')
            ->update(\$data);
        return \$res;
    }
    //条件更新
    public function updateWhere(\$data,\$where)
    {
        \$res = model('$table')
            ->where(\$where)
            ->update(\$data);
        return \$res;
    }
    //批量更新
    public function allSave(\$data)
    {
        //\$data必须为二维数组
        \$res = model('$table')
            ->saveAll(\$data);
        return \$res;
    }
    //add -- 过滤非数据表字段
    public function add(\$data)
    {
        //返回自增主键
        \$res = model('$table')
            ->allowField(true)
            ->save();
        return \$res->$key;
    }
    //批量add
    public function addAll(\$data)
    {
        //\$data必须为二维数组
        \$res = model('$table')
            ->saveAll(\$data);
        return \$res;
    }
    //delete
    public function del(\$where)
    {
        \$res = model('$table')
            ->destroy(\$where);
        return \$res;
    }
}";
        return $txt;
    }
    //数据层
    public function modeltxt($mokuai,$model,$t,$table,$key,$autotime,$type,$issoftdelete,$delfield){
        $txt = "<?php
namespace app\\$mokuai\\model;\n
use think\\Model;\n";
        if($issoftdelete){
            $txt .= "use traits\\model\\SoftDelete;\n";
        }
        $txt .= "//数据层模型 -- 绑定关联模型 -- 编写特殊需求数据
class $t extends $model
{
    protected \$table = '$table';
    protected \$pk = '$key';\n";
        if($issoftdelete){
            $txt .= "
    use SoftDelete;
    protected \$deleteTime = '$delfield';";
        }
        if($autotime){
            $txt .= "protected \$autoWriteTimestamp = '$type';\n";
        }
        $txt .= "
    //一对一关联模型
    public function hasOne1()
    {
        return \$this->hasOne('');
    }
    //一对多关联模型
    public function hasMany1()
    {
        return \$this->hasMany('');
    }
    //远程一对多关联模型
    public function topics1()
    {
        return \$this->hasManyThrough('','');
    }
    //一对一、一对多的相对关联模型
    public function belongsTo1()
    {
        return \$this->belongsTo('');
    }
    //多对多关联模型
    public function belongsToMany1()
    {
        return \$this->belongsToMany('');
    }
}
        ";
        return $txt;
    }
    //生成文件的数据
    public function modelbuild($mokuai,$modelLayer,$table = null){
        $data[$mokuai] = [
            '__dir__' => [$modelLayer],
            "$modelLayer"  => [$table],
        ];
        return $data;
    }
    //生成文件的数据
    public function cbuild($mokuai,$controller,$table){
        $data[$mokuai] = [
            '__dir__' => [$controller],
            "$controller"  => [ucfirst($table)],
        ];
        return $data;
    }

    /*
     * 控制器
     * */
    //公共控制器
    public function basecontroller(){
        if(input('mokuai')){
            $mokuai = input('mokuai');
        }else{
            $mokuai = 'index';
        }
        $this->assign('mokuai',$mokuai);
        return view();
    }
    //登录控制器
    public function logincontroller(){
        if(input('mokuai')){
            $mokuai = input('mokuai');
        }else{
            $mokuai = 'index';
        }
        $this->assign('mokuai',$mokuai);
        return view();
    }
    //空控制器
    public function errorontroller(){
        if(input('mokuai')){
            $mokuai = input('mokuai');
        }else{
            $mokuai = 'index';
        }
        $this->assign('mokuai',$mokuai);
        return view();
    }
    //控制器
    public function controller1(){
        $mokuai = $this->mokuai();
        $this->assign('mokuai',$mokuai);
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        $this->assign('type',input('id'));
        return view();
    }
    //获取模型
    public function controller_step2(){
        $mokuai = input('mokuai');
        if(empty($mokuai)){
            return false;
        }
        $dir1 = dirname(dirname(dirname(__FILE__))).'\\'.$mokuai."\\model";
        $files = array();
        if(is_dir($dir1)){
            $child_dirs = scandir($dir1);
            foreach($child_dirs as $child_dir){
                if(strstr($child_dir, '.php')){
                    $files['model'][] = basename($child_dir,".php");
                }
            }
        }
        return json($files);
    }
    //生成控制器文件
    public function controller2(){
        $mokuai = input('mokuai');
        $modelLayer = input('modelLayer');
        $controller = input('controller');
        $controller_name = input('controller_name');
        $function_name = input('function_name');
        $type = input('type');
        $model = input('model');

        $controller_name = empty($controller_name) ? 'index':$controller_name;
        $function_name = empty($function_name) ? 'index':$function_name;
        $model = empty($model) ? 'model':$model;
        $controller = empty($controller) ? 'Model':$controller;
        $mokuai = empty($mokuai) ? 'index':$mokuai;

        $modelbuild = $this->cbuild($mokuai,'controller',$controller_name);
        $txt = $this->controllerbuild($mokuai,$modelLayer,$controller,$controller_name,$function_name,$type,$model);
        $build = new Build;
        $build->run($modelbuild,$txt);
        $this->success('控制器完成');
    }
    //控制器文件代码
    public function controllerbuild($mokuai,$modelLayer,$controller,$controller_name,$function_name,$type,$model){
        $txt = "<?php
namespace app\\$mokuai\controller;
use think\Controller;
class ".ucfirst($controller_name)." extends $controller
{
    //list
    public function ".$function_name."List()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        if(empty($type)){
            $txt .="
        return view();
    }";
        }else{
            $txt .="
        return res('200');
    }";
        }
        $txt .= "
    //edit
    public function ".$function_name."Edit()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        if(empty($type)){
            $txt .="
        return view();
    }";
        }else {
            $txt .= "
        return res('200');
    }";
        }
        $txt .= "
    //add
    public function ".$function_name."Add()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        if(empty($type)){
            $txt .="
        return view();
    }";
        }else {
            $txt .= "
        return res('200');
    }";
        }
        $txt .= "
    //del
    public function ".$function_name."Del()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        if(empty($type)){
            $txt .="
        return view();
    }
}";
        }else {
            $txt .= "
        return res('200');
    }
}";
        }
        return $txt;
    }
    //生成控制器代码
    public function controller3(){
        $data = input('param.');
        if(!$data['model']){
            $this->error('选择model');
        }
        $this->assign('function_name',$data['function_name']);
        $this->assign('type',$data['type']);
        $this->assign('modelLayer',$data['modelLayer']);
        $this->assign('model',$data['model']);
        return view();
    }
    /*
     * 视图
     * */
    public function form1(){
        return view();
    }
    public function table1(){
        return view();
    }
    /*
    * demo
    * */
    //阿里云短信接口
    public function demo(){
        $this->assign('type',input('id'));
        return view();
    }
}