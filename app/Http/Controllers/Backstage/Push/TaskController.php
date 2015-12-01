<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Backstage\Push;

use App\Models\GroundStaffTask;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Libraries\YddPaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class TaskController extends \App\Http\Controllers\Backstage\Controller {

    public function index(Request $request) {
        $params = $request->all();
        $params['pageNo'] = !empty($params['pageNo']) ? $params['pageNo'] : config('config.page_no');
        $params['pageSize'] = isset($params['pageSize']) ? $params['pageSize'] : config('config.page_size');
        $model = new GroundStaffTask();
        list($result, $count) = $model->showTaskList($params);
        $page = new Paginator($result, $params['pageSize'], $params['pageNo']);
        $this->data['list'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $params['pageSize'], $params['pageNo'], $params);
        $this->data['paginator'] = $paginator;
        $this->data['searchName'] = !empty($request->get('searchName')) ? $request->get('searchName') : '';
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : 'desc';
        return view('backstage.pushs.task.index', $this->data);
    }

 

}
