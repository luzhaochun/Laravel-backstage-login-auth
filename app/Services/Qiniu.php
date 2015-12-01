<?php
/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 15/8/6
 * Time: 下午1:43
 */

namespace Services;

use Illuminate\Support\Facades\Config;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class Qiniu {

    //访问 key
    private $accessKey;

    //密钥
    private $secretKey;

    private $bucket;

    private $token;

    private $err;

    private $ret;

    /**
     * @var array 七牛域名 绑定
     */
    private $qiniu_domain = array(
        'product-images' => 'https://dn-yidd-product-images.qbox.me',
        'article-images' => 'https://dn-yidd-article-images.qbox.me',
        'avator-images' => 'https://dn-yidd-avator-images.qbox.me',
        'drugstore-images' => 'https://dn-yidd-drugstore-images.qbox.me',
        'id-images' => 'https://dn-yidd-id-images.qbox.me',
        'ue-images' => 'https://dn-yidd-ue-images.qbox.me',
        'topic-images' => 'https://dn-yidd-topic-images.qbox.me',
        'slide-images' => 'https://dn-ydd-slide-images.qbox.me',
        'test-paper-images' => 'https://dn-ydd-test-paper-images.qbox.me',
        'event-images' => 'https://dn-yidd-event-images.qbox.me',
        'audio' => 'https://dn-yidd-audio.qbox.me',
        'video' => 'https://dn-yidd-video.qbox.me',
        'group-images' => 'https://dn-yidd-group-images.qbox.me',
    );

    /**
     * @param $bucket 七牛空间名称
     * @param bool $require_auth 是否需要权限
     */
    public function __construct($bucket,$require_auth = false){

        $this->bucket = $bucket;
        if($require_auth){
            $this->accessKey = Config::get('config.access_key');
            $this->secretKey = Config::get('config.secret_key');
            $this->auth = new Auth($this->accessKey, $this->secretKey);
            $this->token = $this->auth->uploadToken($this->bucket);
        }
    }


    /**
     * @param $key 唯一存储名称
     * @param $filePath 本地上传文件路径
     */
    public function upload($key, $filePath){
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($this->token, $key, $filePath);
        if ($err !== null) {
            $this->err = $err;
        } else {
            $this->ret = $ret;
            $this->DeleteLocalImage($filePath);
            return true;
        }
    }

    /**
     * 删除
     * 唯一存储名称
     * @param $key
     */
    public function delete($key){
        $bucketMgr = new BucketManager($this->auth);
        $err = $bucketMgr->delete($this->bucket, $key);
        if ($err !== null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $key 唯一存储名称
     * @return string
     */
    public function getFileUrl($key){
        return $this->qiniu_domain[$this->bucket].'/'.$key;
    }

    /*
     * 获取存储空间https地址
     *
     */
    public function getDomain(){
        return $this->qiniu_domain[$this->bucket].'/';
    }

    /**
     * 获取 token
     * @return string
     */
    public function getToken(){
        return $this->token;
    }

    /**
     * 返回错误
     * @return mixed
     */
    public function getErr(){
        return $this->err;
    }

    /**
     * 返回七牛返回值
     * @return mixed
     */
    public function getReturn(){
        return $this->ret;
    }

    //删除本地图片
    public function DeleteLocalImage($filePath){
        $result = @unlink ($filePath);
        return $result;
    }

}