<?php

namespace App\Http\Controllers\Backstage\Admin;

use App\Libraries\YddPaginator;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

class AdminController extends \App\Http\Controllers\Backstage\Controller {

    public function index() {
        $params = Input::get();
        $params['pageNo'] = isset($params['pageNo']) ? $params['pageNo'] : 0;
        $params['pageSize'] = isset($params['pageSize']) ? $params['pageSize'] : 15;

        $this->data['title'] = '管理员管理';
        $model = new Admin();

        list($result, $count) = $model->getAdminList($params);
        $page = new Paginator($result, $params['pageSize'], $params['pageNo']);
        $this->data['items'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $params['pageSize'], $params['pageNo'], $params);
        foreach ($params as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = $val;
        }
        $this->data['paginator'] = $paginator;
        $this->data['groupList'] =  $model->getAuthGroup(); // 角色组
        return view('backstage.admins.index', $this->data);
    }

    // 新增管理员
    public function add(Request $request){
        $this->data['title'] = '添加管理员';
        if($request->isMethod('post')){
            $data = Input::get();
            $model = new Admin();
            $model->addAdmin($data);
            echo json_encode(['status'=>true, 'msg'=>'保存成功']);
            exit();
        }
        $model = new Admin();
        $this->data['groupList'] =  $model->getAuthGroup(); // 角色组
        return view('backstage.admins.add', $this->data);
    }

    // 编辑管理员
    public function edit(Request $request){
        $id = Input::get('id');
        $this->data['title'] = '编辑管理员';
        $model = new Admin();
        if($request->isMethod('post')){
            $data = Input::get();
            if($model->saveAdmin($data))
                echo json_encode(['status'=>true, 'msg'=>'管理员更新成功！']);
            else
                echo json_encode(['status'=>false, 'msg'=>'管理员更新失败！']);
            exit();
        }
        if(!empty($id)){
            $this->data['admin'] = $model->getAdmin($id);
            $this->data['groupList'] = $model->getAuthGroup(); // 角色组
        }
        return view('backstage.admins.edit', $this->data);
    }

    // 删除管理员
    public function delete(){
        $id = Input::get('id');
        if(!empty($id)){
            $model = new Admin();
            if($model->deleteAdmin($id)){
                echo json_encode(['status'=>true, 'msg'=>'删除成功！']);
                exit();
            }
        }
        echo json_encode(['status'=>false, 'msg'=>'id为空，删除失败！']);
    }

    // 管理员名称唯一性校验
    public function checkNameUnique(){
        $type = Input::get('type');
        $user_name = Input::get('user_name');
        $model = new Admin();
        $id = ($type == 'edit' ? Input::get('id') : '');
        $result = $model->checkUserName($user_name, $id);
        if(!empty($result)) return json_encode(false);
        return json_encode(true);
    }
}
