<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Backstage\Push;

use App\Models\GroundStaff;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Libraries\YddPaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class UserController extends \App\Http\Controllers\Backstage\Controller {

    public function index(Request $request) {
        $params = $request->all();
        $params['pageNo'] = !empty($params['pageNo']) ? $params['pageNo'] : config('config.page_no');
        $params['pageSize'] = isset($params['pageSize']) ? $params['pageSize'] : config('config.page_size');
        $model = new GroundStaff();
        list($result, $count) = $model->showUserList($params);
        $page = new Paginator($result, $params['pageSize'], $params['pageNo']);
        $this->data['list'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $params['pageSize'], $params['pageNo'], $params);
        $this->data['paginator'] = $paginator;
        $this->data['searchName'] = !empty($request->get('searchName')) ? $request->get('searchName') : '';
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : 'desc';
        return view('backstage.pushs.user.list', $this->data);
    }

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $data = Input::get();
            $modle = new GroundStaff();
            $modle->userAdd($data);
            echo json_encode(['status' => true, 'msg' => '保存成功']);
            exit();
        }
        return view('backstage.pushs.user.add');
    }

    public function delete(Request $request) {
        if (!empty($request->input('id'))) {
            if (DB::table('ground_staff')->where('id', '=', intval($request->get('id')))->update(array('is_active' => 0))) {
                echo json_decode(true);
                exit;
            } else {
                echo json_encode(false);
                exit;
            }
        } else {
            echo json_encode(false);
            exit;
        }
    }

    public function checkUser(Request $request) {
        if (strval(trim($request->get('type'))) == 'add') {
            $result = DB::table('ground_staff')->where('login_id', '=', $request->get('login_id'))->first();
        } else {
            $result = DB::table('ground_staff')
                    ->where('login_id', '=', strval(trim($request->get('login_id'))))
                    ->where('id', '!=', intval(trim($request->get('id'))))->first();
        }
        if (!empty($result))
            return json_encode(false);
        return json_encode(true);
    }

    public function edit(Request $request) {
        if ($request->isMethod('post')) {
            $newStaff = array();
            $newStaff['name'] = strval(trim(Input::get('name')));
            $newStaff['login_id'] = strval(trim(Input::get('login_id')));
            if (!empty($request->get('login_pwd'))) {
                $data['login_pwd'] = md5(trim(Input::get('login_pwd')));
            }
            $newStaff['phone'] = trim(Input::get('phone'));
            $newStaff['birthday'] = trim(Input::get('birthday'));
            $newStaff['sexuality'] = trim(Input::get('sexuality'));
            $newStaff['is_active'] = trim(Input::get('is_active'));
            if (DB::table('ground_staff')->where('id', '=', $request->get('id'))->update($newStaff)) {
                echo json_encode(['status' => true, 'msg' => '保存成功']);
            } else {
                echo json_encode(['status' => false, 'msg' => '保存失败']);
            }
        } else {
            $id = $request->get('id');
            $this->data['staff'] = DB::table('ground_staff')->where('id', $id)->first();
            return view('backstage.pushs.user.edit', $this->data);
        }
    }

}
