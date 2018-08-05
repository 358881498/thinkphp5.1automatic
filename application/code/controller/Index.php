<?php
namespace app\code\controller;
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
        $code = input('code');
        if($code){
            $name = input('middleware_name');
            if(empty($name)){
                $this->error('中间件名字必填');
            }
            $this->assign('name',ucfirst($name));
        }
        $this->assign('code',$code);
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
    /*
     * 控制器
     * */
    //生成控制器文件
    public function controller2(){
        $controller_name = input('controller_name');
        if(empty($controller_name)){
            $this->error('缺少控制器名');
        }
        $mokuai = input('mokuai');
        $modelLayer = input('modelLayer');
        $controller = input('controller');
        $function_name = input('function_name');
        $model = input('model');
        $auth = input('auth');
        $function_name = empty($function_name) ? $controller_name:$function_name;
        $model = empty($model) ? 'model':$model;
        $controller = empty($controller) ? 'Model':$controller;
        $mokuai = empty($mokuai) ? 'index':$mokuai;
        $modelbuild = $this->cbuild($mokuai,'controller',$controller_name);
        $resources = input('resources');
        if($resources){
            $txt = $this->resourcescontrollerbuild($mokuai,$modelLayer,$controller,$controller_name,$function_name,$model,$auth);
        }else{
            $txt = $this->controllerbuild($mokuai,$modelLayer,$controller,$controller_name,$function_name,$model,$auth);
        }
        app('build')->run($modelbuild,$txt);
        $this->success('控制器完成');
    }
    //资源控制器文件代码
    public function resourcescontrollerbuild($mokuai,$modelLayer,$controller,$controller_name,$function_name,$model,$auth){
        $txt = "<?php
namespace app\\$mokuai\\controller;
use think\\Controller;
class ".ucfirst($controller_name)." extends $controller
{
";
        if($auth){
            $txt .="
    //设置控制器中间件
    protected \$middleware = ['$auth'];
    ";
        }
        $txt .="
    protected function initialize()
    {
        //初始化

    }
    //index -- GET
    public function index()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .="
        return json();
    }";
        $txt .= "
    //创建 -- GET
    public function create()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .= "
        return json();
    }";
        $txt .= "
    //保存 -- POST
    public function save()
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .= "
        return json();
    }";
        $txt .= "
    //读取 -- GET
    public function read(\$id)
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .= "
        return json();
    }";
        $txt .= "
    //编辑 -- GET
    public function edit(\$id)
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .= "
        return json();
    }";
        $txt .= "
    //更新 -- PUT
    public function update(\$id)
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .= "
        return json();
    }";
        $txt .= "
    //删除 -- DELETE
    public function delete(\$id)
    {";
        if($modelLayer == 'model'){
            $txt .="
        \$model = model('$model');";
        }else{
            $txt .="
        \$model = model('$model','$modelLayer');";
        }
        $txt .= "
        return json();
    }
}";
        return $txt;
    }
    //控制器文件代码
    public function controllerbuild($mokuai,$modelLayer,$controller,$controller_name,$function_name,$model,$auth){
        $txt = "<?php
namespace app\\$mokuai\\controller;
use think\\Controller;
class ".ucfirst($controller_name)." extends $controller
{
";
        if($auth){
            $txt .="
    //设置控制器中间件
    protected \$middleware = ['$auth'];
    ";
        }
        $txt .="
    protected function initialize()
    {
        //初始化

    }
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
            $txt .="
        return json();
    }";
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
            $txt .= "
        return json();
    }";
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
            $txt .= "
        return json();
    }";
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
            $txt .= "
        return json();
    }
}";
        return $txt;
    }
    //生成控制器代码
    public function controller3(){
        $data = input('param.');
        $this->assign('function_name',$data['function_name']);
        return view();
    }
    //控制器页面
    public function controller1(){
        $mokuai = $this->mokuai();
        $this->assign('mokuai',$mokuai);
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        $this->assign('type',input('id'));
        return view();
    }
    //分层控制器
    public function eventcontroller(){
        $name = input('event_name') ? ucfirst(input('event_name')) : null;
        if(!$name){
            $this->error('分层控制器名字必填');
        }
        if(input('mokuai')){
            $mokuai = input('mokuai');
        }else{
            $mokuai = 'index';
        }
        if(input('file') == 1){
            $modelbuild = $this->cbuild($mokuai,'event',$name);
            $txt = $this->eventControllerCode($mokuai,$name);
            app('build')->run($modelbuild,$txt);
            $this->success('分层控制器创建完成');
        }else{
            $this->assign('mokuai',$mokuai);
            $this->assign('name',$name);
            return view();
        }
    }
    //分层控制器文件代码
    public function eventControllerCode($mokuai,$name){
        $txt = "<?php
namespace app\\$mokuai\\event;

class $name
{
    public function insert()
    {
        return 'insert';
    }

    public function update(\$id)
    {
        return 'update:'.\$id;
    }

    public function delete(\$id)
    {
        return 'delete:'.\$id;
    }
}
";
        return $txt;
    }
    //空控制器
    public function errorcontroller(){
        if(input('mokuai')){
            $mokuai = input('mokuai');
        }else{
            $mokuai = 'index';
        }
        if(input('file') == 1){
            $modelbuild = $this->cbuild($mokuai,'controller','Error');
            $txt = $this->errorControllerCode($mokuai);
            app('build')->run($modelbuild,$txt);
            $this->success('空控制器创建完成');
        }else{
            $this->assign('mokuai',$mokuai);
            return view();
        }
    }
    //空控制器文件代码
    public function errorControllerCode($mokuai){
        $txt = "<?php
namespace app\\$mokuai\\controller;
use think\\Controller;
use think\\Request;
//空控制器
class Error extends Controller
{
    //空控制器
    public function index(Request \$request)
    {
        return \$this->error(\$request->controller().'是空控制器！');//可跳转到404
    }
}
";
        return $txt;
    }
    //公共控制器
    public function basecontroller(){
        if(input('mokuai')){
            $mokuai = input('mokuai');
        }else{
            $mokuai = 'index';
        }
        if(input('file') == 1){
            $modelbuild = $this->cbuild($mokuai,'controller','Base');
            $txt = $this->baseControllerCode($mokuai);
            app('build')->run($modelbuild,$txt);
            $this->success('公共控制器创建完成');
        }else{
            $this->assign('mokuai',$mokuai);
            return view();
        }
    }
    //公共控制器文件代码
    public function baseControllerCode($mokuai){
        $txt = "<?php
namespace app\\$mokuai\\controller;
use think\\Controller;
use think\\Db;
use think\\Url;
use think\\Response;
use think\\Request;
use think\\Loader;
use think\\facade\\Hook;
use Demo;
class Base extends Controller
{
    //定义前置方法名
    protected \$beforeActionList = [
        'base',
    ];
    //空方法
    public function _empty()
    {
        return \$this->error('空方法');//可跳转到404
    }
    //前置方法
    public function base()
    {

    }
}";
        return $txt;
    }
    /*
     * 生成模型
     * */
    //生成模型文件
    public function model3(){
        $data = input('param.');
        $model = empty($data['model']) ? 'Model': $data['model'];
        $mokuai = empty($data['mokuai']) ? 'index': $data['mokuai'];
        $modelLayer = input('modelLayer');
        if(!empty($data['table'])){
            //一个模型文件
            $cls = $this->columns($data['table']);
            $res =  $this->timestamp($cls);
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
            if($modelLayer == 'model'){
                //数据层
                $tablename = $this->table($table);
                if(strstr($tablename, '中间表') || strstr($tablename, '关联表')){
                    $txt = $this->pivottxt($mokuai,$t,$autotime,$type);
                }else{
                    $txt = $this->modeltxt($mokuai,$model,$t,$table,$key,$autotime,$type,$issoftdelete,$delfield,$res['time']);
                }
                app('build')->run($modelbuild,$txt);
                $this->success('数据层模型完成');
            }elseif($modelLayer == 'logic'){
                //逻辑层
                $txt = $this->logictxt($mokuai,$t,$key);
                app('build')->run($modelbuild,$txt);
                $this->success('逻辑层模型完成');
            }else{
                //服务层
                $txt = $this->servicetxt($mokuai,$t);
                app('build')->run($modelbuild,$txt);
                $this->success('服务层模型完成');
            }
        }
        else{
            //全部模型文件
            //代码
            $tables = $this->tables();
            if($modelLayer == 'model'){
                //数据层
                foreach ($tables as $table){
                    $array = null;
                    $array[] = $table['Name'];
                    $t = $this->parseName(array_pop($array), 1);
                    $modelbuild = $this->modelbuild($mokuai,$modelLayer,$t);
                    $cls = $this->columns($table['Name']);
                    $res =  $this->timestamp($cls);
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
                    $tablename = $this->table($table['Name']);
                    if(strstr($tablename, '中间表') || strstr($tablename, '关联表')){
                        $txt = $this->pivottxt($mokuai,$t,$autotime,$type);
                    }else{
                        $txt = $this->modeltxt($mokuai,$model,$t,$table['Name'],$key,$autotime,$type,$issoftdelete,$delfield,$res['time']);
                    }
                    app('build')->run($modelbuild,$txt);
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
                    app('build')->run($modelbuild,$txt);
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
                    app('build')->run($modelbuild,$txt);
                }
                $this->success('服务层模型完成');
            }
        }
    }
    //中间表代码
    public function pivottxt($mokuai, $t, $autotime, $type){
        $txt = "<?php
namespace app\\$mokuai\\model\\$t;\n
use think\\model\\Pivot;\n
class Access extends Pivot
{
";
        if($autotime){
            $txt .= "//设置自动写入时间戳的字段类型
    protected \$autoWriteTimestamp = '$type';\n}";
        }else{
            $txt .= "\n}";
        }
        return $txt;
    }
    //数据层
    public function modeltxt($mokuai,$model,$t,$table,$key,$autotime,$type,$issoftdelete,$delfield,$time){
        $txt = "<?php
namespace app\\$mokuai\\model;\n
use think\\Model;\n";
        if($issoftdelete){
            $txt .= "use traits\\model\\SoftDelete;\n";
        }
        $txt .= "//数据层模型 -- 绑定关联模型 -- 编写特殊需求数据
class $t extends $model
{
    //绑定表
    protected \$table = '$table';
    //绑定主键
    protected \$pk = '$key';\n";
        if($issoftdelete){
            $txt .= "
    //使用软删除
    use SoftDelete;
    //设置软删除字段
    protected \$deleteTime = '$delfield';
    ";
        }
        if($autotime){
            $txt .= "//设置自动写入时间戳的字段类型
    protected \$autoWriteTimestamp = '$type';\n";
        }
    if(!empty($time)){
            $txt .= "   //设置类型自动转换
    protected \$type = [\n";
        foreach ($time as $k=>$v){
            $txt .= "       '".$v['Field']."' => '".$v['type']."',\n";
        }
        $txt .= "    ];";
    }
        $txt .= "

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }

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
    //生成模型代码
    public function model2(){
        $data = input('param.');
        if(empty($data['table'])){
            $this->error('缺少表');
            return;
        }
        $table = $this->table($data['table']);
        if(strstr($table, '中间表') || strstr($table, '关联表')){
            $this->assign('associated',1);
        }else{
            $this->assign('associated',2);
        }
        $model = empty($data['model']) ? 'Model': $data['model'];
        $mokuai = empty($data['mokuai']) ? 'index': $data['mokuai'];
        $cls = $this->columns($data['table']);
        $res =  $this->timestamp($cls);
        $array[] = $data['table'];
        $data['table'] = $this->parseName(array_pop($array), 1);
        $this->assign('table',$data['table']);
        $this->assign('modelLayer',$data['modelLayer']);
        $this->assign('model',$model);
        $this->assign('mokuai',$mokuai);
        $this->assign('autotime',$res['autotime']);
        $this->assign('issoftdelete',$res['issoftdelete']);
        $this->assign('delfield',$res['delfield']);
        $this->assign('type',$res['type']);
        $this->assign('pk',$res['key']);
        $this->assign('time',$res['time']);
//        dd($res['time']);
        return view();
    }
    public function timestamp($cls){
        $data = [
            'key' => null,
            'autotime' => null,
            'type' => null,
            'issoftdelete' => null,
            'delfield' => null,
            'time' => array(),
        ];
        foreach ($cls as $c){
            if($c['Key']=='PRI'){
                $data['key'] = $c['Field'];
            }else if($c['Field'] == 'create_time'){
                $data['autotime'] = 1;
                $data['type'] = $c['Type'];
            }else if($c['Field'] == 'update_time'){
                $data['autotime'] = 1;
                $data['type'] = $c['Type'];
            }else if($c['Comment'] == '软删除'){
                $data['issoftdelete'] = 1;
                $data['delfield'] = $c['Field'];
            }else if($c['Type'] == "datetime" || $c['Type'] == "timestamp"){
                $data['time'][] = [
                    'Field' => $c['Field'],
                    'type' => $c['Type'],
                ];
            }
        }
        return $data;
    }
    //模型页面
    public function model1(){
        $this->assign('type',input('id'));
        $this->assign('mokuai',$this->mokuai());
        //代码
        $tables = $this->tables();
        $this->assign('tables',$tables);
        return view();
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
    //生成验证器
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
        }
        else{
            foreach($data['ss'] as $c){
                $fields.= "'".$c."',";
            }
            $fields = trim($fields,',');
        }
        if($vals['is_code'] == 2){
            //生成验证器文件
            $mokuai = input('mokuai');
            $dir = 'validata';
            $name = input('validata_name') ?? $this->parseName(input('table'),1);
            $name = ucfirst($name);
            $build = $this->modelbuild($mokuai, $dir, $name);
            $txt = $this->validatacode($mokuai, $name, $data, $fields);
            app('build')->run($build,$txt);
        }
        else{
            //生成验证器代码
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
    //验证器生成文件代码
    private function validatacode($mokuai, $name, $data, $fields){
        $txt = "<?php
namespace app\\$mokuai\\validate;

use think\\Validate;

class $name extends Validate
{
    protected \$rule = [
    ";
        foreach($data['rs'] as $k => $v){
    $txt .="    '$k' => '".implode('|', $v)."',
    ";
        }
        $txt .="
    ];
    protected \$message = [
    ";
        foreach($data['ms'] as $k => $v){
    $txt .="    '$k' => '$v',
    ";
        }
        $txt .="
    ];
    protected \$scene = [
        'add'   =>  [$fields],
        'edit'  =>  [$fields],

    ];
}";
        return $txt;
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
    //验证代码
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
}