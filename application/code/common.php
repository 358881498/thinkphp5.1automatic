<?php
//打印数组
function dd($data){
    echo "<pre>";
    if(empty($data)){
        var_dump($data);
        return;
    }
    if(is_object($data)){
        $data = $data->toArray();
        foreach($data as $k=>$v){
            if(is_object($v)){
                $data[$k] = $v->toArray();
            }
        }
        print_r($data);
        return;
    }
    print_r($data);
    return;
}
//请求返回json
function resJson($code = 0, $code1 = 200,$data = '',$message = ''){
    //调用配置文件中定义好的常量
    $res = [
        'message' => config($code)['message'],
        'data' => $data,
    ];
    if(!empty($message)){
        $res['message'] = $message;
    }
    return json($res,$code1);
}
