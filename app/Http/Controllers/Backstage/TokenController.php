<?php

namespace App\Http\Controllers\Backstage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Services\Qiniu;
use App\Services\Util;
class TokenController extends \App\Http\Controllers\Backstage\Controller {
    //获取七牛云的token
    public function getQiniuToken() {
        $data = Input::get();
        $type = !empty($data['QiniuType']) ? $data['QiniuType'] : 1;
        $backet = Config::get('config.bucket_key')[$type];
        $qiniu_model = new Qiniu($backet,true);
        return  json_encode(['uptoken'=>$qiniu_model->getToken()]);
    }


    //获取图片的名称
    public function getQiniuImageName(Request $request){
        $bucketType = $request->input('QiniuType');
        $id = empty($request->input('id')) ? false: $request->input('id');
        $filename = Util::getUtilData()->javascript_create_qiniu_unqiue_name($bucketType,$id);
        return $filename;
    }




}
