<?php
namespace Demo;
use OssClient;
//路径  extend/OSS
class Oss
{
    //OOS 配置
    public $OSS_ACCESS_ID = '';
    public $OSS_ACCESS_KEY = '';
    public $OSS_ENDPOINT = '';
    public $OSS_TEST_BUCKET = '';
    //oss文件上传配置
    public $OSS_MAXSIZE = '1048576';    //1M
    public $OSS_EXTS = array(// 设置附件上传类型
        'image/jpg',
        'image/gif',
        'image/png',
        'image/jpeg',
        'application/octet-stream',//阿里云好像都是通过二进制上传，似乎上面4个后缀设置起到什么用？
    );
    //oss
    public function ossImg($fFiles = null,$name = null,$isthumb = 0){
        if($fFiles == null || $name == null){
            var_dump(null);
            die();
        }
        //oss上传
        $bucketName = $this->OSS_TEST_BUCKET;
        $ossClient = new \OSS\OssClient($this->OSS_ACCESS_ID, $this->OSS_ACCESS_KEY, $this->OSS_ENDPOINT, false);
        //图片
        $rs = $this->ossUpPic($fFiles,$name,$ossClient,$bucketName,$isthumb);
        if($rs['code']==1){
            //图片
            $img['img'] = $rs['msg'];
            //如返回里面有缩略图：
            if(!empty($rs['thumb'])){
                $img['thumb'] = $rs['thumb'];
            }
            return $img;
        }else{
            $this->error('图片有误：'.$rs['msg']);
            return;
        }
    }
    function ossUpPic($fFiles,$name,$ossClient,$bucketName,$isThumb=0){
        $fType = $fFiles['type'];
        $back = array(
            'code'=>0,
            'msg'=>'',
        );
        if(!in_array($fType, $this->OSS_EXTS)){
            $back['msg']='文件格式不正确';
            return $back;
            exit;
        }
        $fSize = $fFiles['size'];
        if($fSize > $this->OSS_MAXSIZE){
            $back['msg'] = '文件超过了1M';
            return $back;
            exit;
        }
        $fname = $fFiles['name'];
        $ext = substr($fname,stripos($fname,'.'));
        $fup_n = $fFiles['tmp_name'];
        $file_n = time().'_'.rand(100,999);
        $object = $name."/".$file_n.$ext;//目标文件名
        if (is_null($ossClient)){
            exit(1);
        };
        $ossClient->uploadFile($bucketName, $object, $fup_n);
        if($isThumb == 1){
            $back['thumb']= $object."?x-oss-process=image/resize,h_300,w_300";
        }
        $back['code']=1;
        $back['msg'] = $object;
        return $back;
    }

}