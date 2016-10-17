<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests;
use Storage;
use Qiniu\Auth as QiAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class UploadController extends ApiController
{
    // url
    public $url = 'http://oewvb9bk1.bkt.clouddn.com/';
    // AK
    public $accessKey = 'WVchuY_EyKgxqPPs1a39lMdjHc-vQX_3detPjdgn';
    // SK
    public $secretKey = '3LE9DwPpBwZZmt1b2xVA4gl-w4i4XoHno_3Ana8T';
    // 上传的空间
    public $bucket = 'lovechun4ever';
    // 文件的公共前缀
    public $prefix = 'image/article/';
    // 鉴权对象
    public $auth;
    // 空间管理对象
    public $bucketMgr;
    // 上传对象
    public $uploadMgr;
    // 图片样式
    public $imgClass = '?imageView2/2/w/565/interlace/1/q/50';

    public function __construct(){
        $this->auth = new QiAuth($this->accessKey, $this->secretKey);
        $this->bucketMgr = new BucketManager($this->auth);
        $this->uploadMgr = new UploadManager();
    }

    public function index(){

        $marker = '';
        $limit = 100;
        list($iterms, $marker, $err) = $this->bucketMgr->listFiles($this->bucket, $this->prefix, $marker, $limit);
        if ($err !== null) {
            echo "\n====> list file err: \n";
            var_dump($err);
        } else {
            return response()->json($iterms);
        }

    }

    public function uploadToCloud(Request $request){

        $file = $request->file('file');
        $allowed_extensions = ["png", "jpg"];
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return response()->json(
                [
                    'ret_code' => 'fail',
                    'ret_msg' => '请上传.PNG或.JPG格式的文件！',
                ]
            );
        }

        // 生成上传 Token
        $token = $this->auth->uploadToken($this->bucket);
        // 要上传文件的本地路径
        $filePath = $file->getRealPath();
        // 上传到七牛后保存的文件名
        $key = 'image/article/' . time() . rand(999,9999) . "." . $file->getClientOriginalExtension();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $this->uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return response()->json(
                [
                    'ret_code' => 'fail',
                    'ret_msg' => 'qiniu error',
                ]
            );
        } else {
            return response()->json(
                [
                    'ret_code' => 'success',
                    'ret_msg' => $this->url . $ret['key'] . $this->imgClass,
                ]
            );
        }
    }

}
