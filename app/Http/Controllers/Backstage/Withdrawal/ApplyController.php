<?php
/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 15/11/17
 * Time: 下午2:15
 */

namespace App\Http\Controllers\Backstage\Withdrawal;
use App\Models\WithdrawCashApplication;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use App\Libraries\YddPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ApplyController extends \App\Http\Controllers\Backstage\Controller {

    protected $aplly_status = array(
        0 => '申请',1 => '完成', 2 => '失败', 3 => '已汇款'
    );

    public function index(){

        $params = Input::get();
        $params['pageNo'] = isset($params['pageNo']) ? intval($params['pageNo']) : 1;
        $params['pageSize'] = isset($params['pageSize']) ? intval($params['pageSize']) : Config::get('config.default_pageSize');
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : '';
        $params['state'] = isset($params['state']) ? intval($params['state']) : -1;
        $params['active'] = isset($params['active']) ? intval($params['active']) : -1;
        $params['apply_start_time'] = isset($params['apply_start_time']) ? strval($params['apply_start_time']) : '';
        $params['apply_end_time'] = isset($params['apply_end_time']) ? strval($params['apply_end_time']) : '';

        $model = new WithdrawCashApplication();
        list($result, $count) = $model->getApplyList($params);
        $page = new Paginator($result, $params['pageSize'], $params['pageNo']);
        $data['items'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $params['pageSize'], $params['pageNo'], $params);
        foreach ($params as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = urlencode($val);
        }
        $data['paginator'] = $paginator;
        $data['aplly_status'] = $this->aplly_status;
        $data['params'] = $params;

        return view('backstage.Apply.index',$data);

    }

    /**
     * 查看详情
     */
    public function show(){

        $id = Input::get('id');

        $model = new WithdrawCashApplication();
        $info = $model->getApplyInfo($id);

        return view('backstage.Apply.show',array('info'=>$info,'aplly_status'=>$this->aplly_status));
    }

    /**
     * 删除
     */
    public function del(){
        $id = Input::get('id');
        $model = new WithdrawCashApplication();
        $status = $model->del($id);
        if($status){
            log_records('删除提现申请','1');
            $msg = '删除成功';
        }else{
            $msg = '删除失败';
        }
        $data = array('msg'=>$msg,'status'=>$status);

        return response()->json($data);

    }

    /**
     * 取消
     */
    public function cancel(){
        $id = Input::get('id');
        $model = new WithdrawCashApplication();
        $status = $model->cancel($id);
        if($status){
            log_records('取消提现申请','1');
            $msg = '取消成功';
        }else{
            $msg = '取消失败';
        }
        $data = array('msg'=>$msg,'status'=>$status);

        return response()->json($data);
    }

    /**
     * 完成汇款
     */
    public function completed(Request $request){
        $id = Input::get('id');

        if($request->isMethod('post')){

            $serial_number = Input::get('serial_number');

            if($serial_number == ''){
                show_message('汇款流水号不能为空','goback',1000,0);exit;
            }

            $model = new WithdrawCashApplication();
            $data = $model->completed($id,$serial_number);
            if($data['status'] == '1'){
                log_records('提现申请汇款','1');
                show_message('汇款成功','',1000,1);exit;
            }else{
                show_message($data['msg'],'goback',1000,0);exit;
            }

        }else{
            $model = new WithdrawCashApplication();
            $info = $model->getApplyInfo($id);
        }

        return view('backstage.Apply.completed',array('info'=>$info));
    }

}