<?php
/**
 * 扩展类库
 * User: linwenshan
 * Date: 15/11/19
 * Time: 上午10:15
 */
namespace App\Services;

class Util{

    private static $_instance;
    public static function getUtilData(){
        if(!self::$_instance){
            self::$_instance = new Util();
        }
        return self::$_instance;
    }

    /**
     *  七牛文件命令规则
    1. 身份证：id_用户ID_时间戳.png
    2. 头像：avatar_用户ID_时间戳.png
    3. 药店营业执照：bl_药店名称_时间戳.png
    4. 产品图片：product_产品ID_时间戳.png
    5. 文章列表图片：artile_文章ID_时间戳.png
     *
     *  * $id = 数据编号
     * $type = 所代表的空间名称
     *
     *
     * 4【'product'=>'产品图片'】id必传
     * 5【'article'=>'文章图片'】id必传
     * 8【'slide'=>'幻灯片'】 id 非必传
     * 9【'test_paper'=>'题卷图片'】 id 必传
     * 10【'event'=>'活动图片'】id必传
     *
     *
     * @param $bucketType
     * @param intval $id
     * @param string $filename
     * @return string
     */

    public function create_qiniu_unqiue_name($bucketType,$id=false,$filename = ''){
        $arr = [4=>'product',5=>'article',8=>'slide',9=>'test_paper',10=>'event'];
        $name = $arr[$bucketType] ? $arr[$bucketType] : false;
        if($name === false){
            return false;
        }
        if($id === false){
            $file_prefix =  $name.'_';
        }else{
            $file_prefix = $name.'_'.$id.'_';
        }
        $ext = '';
        if($filename != ''){
            $ext = substr($filename,strrpos($filename,'.'));
        }
        list($u, $s) = explode(' ',microtime());
        $s = date('ymdhis',$s);
        $result = $s.($u* pow(10,2));
        if(strpos($result,'.')){
            list($result,$useless) = explode('.',$result);
        }
        $name = $file_prefix.$result.$this->getRandCode(6);
        return $name.$ext;
    }

    /**
     *  七牛文件命令规则 ---javascript web 上传命名规则
    1. 身份证：id_用户ID_时间戳.png
    2. 头像：avatar_用户ID_时间戳.png
    3. 药店营业执照：bl_药店名称_时间戳.png
    4. 产品图片：product_产品ID_时间戳.png
    5. 文章列表图片：artile_文章ID_时间戳.png
     *
     *  * $id = 数据编号
     * $type = 所代表的空间名称
     *
     *
     * 4【'product'=>'产品图片'】id必传
     * 5【'article'=>'文章图片'】id必传
     * 8【'slide'=>'幻灯片'】 id 非必传
     * 9【'test_paper'=>'题卷图片'】 id 必传
     * 10【'event'=>'活动图片'】id必传
     * 13【'group'=>'群组头像'】id必传
     *
     *
     * @param $bucketType
     * @param intval $id
     * @param string $filename
     * @return string
     */

    public function javascript_create_qiniu_unqiue_name($bucketType,$id=false){
        $arr = [4=>'product',5=>'article',8=>'slide',9=>'test_paper',10=>'event',13=>'group'];
        $name = $arr[$bucketType] ? $arr[$bucketType] : false;
        if($name === false){
            return false;
        }
        if($id === false){
            $file_prefix =  $name.'_';
        }else{
            $file_prefix = $name.'_'.$id.'_';
        }
        list($u, $s) = explode(' ',microtime());
        $s = date('ymdhis',$s);
        $result = $s.($u* pow(10,2));
        if(strpos($result,'.')){
            list($result,$useless) = explode('.',$result);
        }
        return $file_prefix.$result.$this->getRandCode(6);
    }

    /**
     * 获取直定长度随机码
     * @param type $length
     * @param type $type 0 纯数字 1 数字、小写字母 2 数字、小写字母、大写字母
     * @return string
     */
    function getRandCode($length = 6,$type = 0)
    {
        if($type == 0) {
            $str = '0123456789';
        }else if($type == 1){
            $str = '0123456789abcdefghijklmnopqrstuvwxyz';
        }else{
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $len = strlen($str);
        $retStr = '';
        for($i=0;$i<$length;$i++){
            $retStr .= $str[rand(0, $len-1)];
        }
        return $retStr;
    }

}