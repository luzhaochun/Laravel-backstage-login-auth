<?php

namespace App\Http\Controllers\Backstage\Product;

use App\Libraries\YddPaginator;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use App\Services\Util;
use Services\Qiniu;

class ProductController extends \App\Http\Controllers\Backstage\Controller {
    // 产品列表
    public function index() {
        $params = Input::get();
        $params['pageNo'] = isset($params['pageNo']) ? $params['pageNo'] : 0;
        $params['pageSize'] = isset($params['pageSize']) ? $params['pageSize'] : 15;

        $this->data['title'] = '产品列表';

        $model = new Product();
        list($this->data['productList'], $count) = $model->getProductList($params);

        $page = new Paginator($this->data['productList'], $params['pageSize'], $params['pageNo']);
        $this->data['items'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $params['pageSize'], $params['pageNo'], $params);
        foreach ($params as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = $val;
        }
        $this->data['paginator'] = $paginator;

        return view('backstage.products.index', $this->data);
    }

    // 新增产品
    public function add(Request $request){
        $this->data['title'] = '添加产品';
        $model = new Product();

        // 获取产品推荐位置
        $this->data['positionList'] = $model->getPositionList();

        // 获取产品的所有产品功效数据
        $this->data['productFuncList'] = $model->getProductFuncList();

        // 供应商
        $this->data['supplierList'] = $model->getProductSupplier();

        // 初始预热天数
        $this->data['init_preheating_days'] = range(1,7);

        if($request->isMethod('post')){
            $data = Input::get();
        }

        return view('backstage.products.add', $this->data);
    }

    // 编辑产品
    public function edit(){
        $id = Input::get('id');
        if(empty($id))
            return view('backstage.error');

        $this->data['title'] = '编辑产品';
        $model = new Product();
        $this->data['editProductInfo'] = $model->getProductDetails($id);
        $this->data['init_preheating_days'] = range(1,7);
        return view('backstage.products.edit', $this->data);
    }

    // 删除产品
    public function delete(){
        $id = Input::get('id');
        $model = new Product();
        if($model->productDel($id)){
            echo json_encode(['status'=>true, 'msg'=>'删除成功！']);
            exit();
        }
        echo json_encode(['status'=>false, 'msg'=>'删除失败！']);
    }

    // 上传图片（产品图片--幻灯片）
    public function uploadImg(){
        $file = Input::file('Filedata');
        $destPath = public_path() . '/Upload/images/'; // 上传图片本地路径

        $clientName = $file->getClientOriginalName(); // 上传文件名称
        $entension = $file->getClientOriginalExtension(); //上传文件的后缀.

        $newName = md5(date('ymdhis') . $clientName) . "." . $entension;
        $path = $file->move($destPath, $newName);

        if(file_exists($path)){
            $filename = Util::getUtilData()->javascript_create_qiniu_unqiue_name(8, false, $path); // 幻灯片
            if(!empty($filename)){
                $space = Config::get('config.bucket_key')[8];
                //上传七牛云
                $QiniuServices = new Qiniu($space,true);
                if($QiniuServices->upload($filename, $path)){
                    // 上传成功，删除本地
                    @unlink($path);
                    echo $QiniuServices->getFileUrl($filename);
                    exit;
                }
                echo '上传失败！';
            }
        }
    }

    // 产品名称唯一性校验
    public function checkNameUnique(){
        $productName = Input::get('product_name');
        $type = Input::get('type');
        $id = ($type == 'edit' ? Input::get('id') : '');
        $model = new Product();
        $result = $model->checkNameUnique($productName, $id);
        if(!empty($result)) return json_encode(false);
        return json_encode(true);
    }
}
