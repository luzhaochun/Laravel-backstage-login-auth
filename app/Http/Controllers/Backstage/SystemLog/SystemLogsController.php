<?php

namespace App\Http\Controllers\Backstage\SystemLog;

use App\Libraries\YddPaginator;
use App\Models\SystemLog;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

class SystemLogsController extends \App\Http\Controllers\Backstage\Controller {
    // 登录日志
    public function loginList() {
        $params = Input::get();

        $pageNo = $params['pageNo'] = isset($params['pageNo']) ? $params['pageNo'] : 0;
        $pageSize = $params['pageSize'] = isset($params['pageSize']) ? $params['pageSize'] : 15; // 默认一页15个

        $this->data['title'] = '登录日志';

        $model = new SystemLog();
        list($this->data['loginList'], $this->data['count']) = $model->getLoginList($params);

        // 分页数据
        $page = new Paginator($this->data['loginList'], $pageSize, $pageNo);
        $this->data['items'] = $page->items();

        // 分页页码及参数
        $paginator = new YddPaginator($this->data['count'], $pageSize, $pageNo, $params);
        foreach ($params as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = $val;
        }
        $this->data['paginator'] = $paginator;

        return view('backstage.systemlogs.loginlog', $this->data);
    }

    // 操作日志
    public function operateList(){
        $params = Input::get();

        $pageNo = $params['pageNo'] = isset($params['pageNo']) ? $params['pageNo'] : 0;
        $pageSize = $params['pageSize'] = isset($params['pageSize']) ? $params['pageSize'] : 15; // 默认一页15个

        $this->data['title'] = '操作日志';

        $model = new SystemLog();
        list($this->data['loginList'], $this->data['count']) = $model->getOperateList($params);

        // 分页数据
        $page = new Paginator($this->data['loginList'], $pageSize, $pageNo);
        $this->data['items'] = $page->items();

        // 分页页码及参数
        $paginator = new YddPaginator($this->data['count'], $pageSize, $pageNo, $params);
        foreach ($params as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = $val;
        }
        $this->data['paginator'] = $paginator;

        return view('backstage.systemlogs.operatelog', $this->data);
    }
}
