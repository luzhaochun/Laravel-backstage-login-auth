<?php
/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 15/11/17
 * Time: 下午2:50
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WithdrawCashApplication extends Model {

    protected $table = 'withdraw_cash_application';

    public $timestamps = false; // 此方法解决ORM的create_at update_at delete_at默认字段的更新

    /**
     * 获取提现列表
     * @param $paras 请求参数数组
     */
    public function getApplyList($params){
//        if(!empty($data['idSort'])){
//            $orderField = 'admin.id';
//            $orderValue = $data['idSort'];
//        }
//        if(!empty($data['timeSort'])){
//            $orderField = 'admin.update_time';
//            $orderValue = $data['timeSort'];
//        }
//        if(empty($orderField)){
//            $orderField = 'admin.update_time';
//            $orderValue = 'DESC';
//        }

        $data = array();
        $list = DB::table($this->table)
            ->join('clerk', $this->table.'.clerk_id', '=', 'clerk.id')
            ->leftjoin('capital_account','capital_account.id','=',$this->table.'.account_id')
            ->select($this->table.'.*','clerk.name','clerk.phone','clerk.id_number','capital_account.account_type_name')
            ->where(function ($query) use ($params) {
                if($params['state'] != -1){
                    $query->where($this->table.'.state',$params['state']);
                }
            })
            ->where(function ($query) use ($params) {
                if($params['active'] != -1){
                    $query->where($this->table.'.is_active',$params['is_active']);
                }
            })
            ->where(function ($query) use ($params) {
                if($params['apply_start_time'] != '' && $params['apply_end_time'] ){
                    $query->where($this->table.'.request_time','>=',$params['apply_start_time'])
                        ->where($this->table.'.request_time','<=',$params['apply_end_time']);
                } else if($params['apply_start_time'] != ''){
                    $query->where($this->table.'.request_time','>=',$params['apply_start_time']);
                }else if($params['apply_end_time'] != ''){
                    $query->where($this->table.'.request_time','<=',$params['apply_end_time']);
                }
            })
            ->where(function ($query) use ($params) {
                // 搜索条件
                if(!empty($params['keyword']))
                    $query->where('clerk.name', 'like', '%'.trim($params['keyword']).'%')
                        ->orWhere('clerk.phone', 'like', '%'.trim($params['keyword']).'%')
                        ->orWhere($this->table.'.serial_number', 'like', '%'.trim($params['keyword']).'%');
            })
            ->orderBy($this->table.'.id', 'DESC')
            ->take($params['pageSize'])
            ->skip($params['pageNo'] > 1 ? ($params['pageNo'] - 1) * $params['pageSize'] : 0)
            ->get();

        $count = 0;
        if(!empty($list)){
            $count = DB::table($this->table)
                ->join('clerk', $this->table.'.clerk_id', '=', 'clerk.id')
                ->select($this->table.'.*','clerk.name')
                ->where($this->table.'.is_active', '1')
                ->where(function ($query) use ($params) {
                    // 搜索条件
                    if(!empty($params['keyword']))
                        $query->where('clerk.name', 'like', '%'.trim($params['keyword']).'%')
                            ->orWhere('clerk.phone', 'like', '%'.trim($params['keyword']).'%')
                            ->orWhere($this->table.'.serial_number', 'like', '%'.trim($params['keyword']).'%');
                })
                ->count();
        }

        return [$list, $count];
    }

    /**
     * 获取申请详情
     * @param $id
     */
    public function getApplyInfo($id){
        $info = DB::table($this->table)
            ->join('clerk', $this->table.'.clerk_id', '=', 'clerk.id')
            ->join('capital_account','capital_account.id','=',$this->table.'.account_id')
            ->leftjoin('r_clerk_and_drugstore','r_clerk_and_drugstore.clerk_id','=','clerk.id')
            ->leftjoin('drugstore','r_clerk_and_drugstore.drugstore_id','=','drugstore.id')
            ->select($this->table.'.*','clerk.name','clerk.phone','clerk.id_number','capital_account.account_type_name','capital_account.account_name','capital_account.other_info','capital_account.account_number','drugstore.name AS drugstore_name')
            ->where($this->table.'.id','=',$id)
            ->first();

        return $info;
    }

    /**
     * 完成提现申请
     */
    public function completed($id,$serial_number){
        //提现申请
        $apply_info = DB::table($this->table)->where('id',$id)->where('state','0')->where('is_active','1')->select('money','clerk_id')->first();
        if(!empty($apply_info)){
            //店员帐户
            $clerk_info = DB::table('clerk')->where('is_active','1')->where('id',$apply_info->clerk_id)->first();

            //交易流水额度
            $journal_accout = DB::table('journal_accout')->where('clerk_id',$apply_info->clerk_id)->where('state','0')->where('is_active','1')->sum('money');

            //提现余额
            $balance = $journal_accout - $apply_info->money;

            if($balance >= 0){ //提现金额应小于或等红包总额
                DB::beginTransaction();

                //更改提现状态
                $withdraw_result = DB::table($this->table)->where('id',$id)->update(['state'=>'1','serial_number'=>$serial_number,'done_time'=> date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s')]);

                //更改交易流水记录
                $journal_update_result = DB::table('journal_accout')->where('clerk_id',$apply_info->clerk_id)->where('state','0')->where('is_active','1')->update(['state'=>'1','update_time'=>date('Y-m-d H:i:s')]);

                //添加交易流水记录 提现记录
                $journal_add_data = [
                    'type' => '2', //支出
                    'money' => $apply_info->money,
                    'state' => '1', //已兑换
                    'is_active' => '1',
                    'update_time' => date('Y-m-d H:i:s'),
                    'clerk_id' => $apply_info->clerk_id
                ];
                $journal_add_result = DB::table('journal_accout')->insert($journal_add_data);

                //尚有余额
                if($balance > 0){
                    //添加交易流水记录 提现记录
                    $journal_add_data = array(
                        'type' => '1', //收入
                        'money' => $balance,
                        'state' => '0',
                        'is_active' => '1',
                        'update_time' => date('Y-m-d H:i:s'),
                        'clerk_id' => $apply_info->clerk_id
                    );
                    $journal_add_result_2 = DB::table('journal_accout')->insert($journal_add_data);
                }

                $status = ($balance > 0) ? ($withdraw_result && $journal_update_result && $journal_add_result && $journal_add_result_2) : ($withdraw_result && $journal_update_result && $journal_add_result) ;

                //不存在错误提交事业
                if ($status != false){
                    // 提交事务
                    DB::commit();
                    $data = array(
                        'status' => '1',
                        'msg'    => '提现成功'
                    );
//                    $this->recordSystemLog(0,'提现成功');
                }else{
                    // 事务回滚
                    DB::rollback();
                    //提现失败
//                        $withdraw_data = array('state'=>'2','done_time'=> date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'));
//                        $withdraw_model->where('id='.$id)->save($withdraw_data);
                    $data = array(
                        'status' => '-1',
                        'msg'    => '提现失败'
                    );
                }
            }else{
                $data = array(
                    'status' => '-2',
                    'msg'    => '提现失败，提现金额应小于或等红包总额'
                );
            }
        }else{
            $data = array(
                'status' => '-3',
                'msg'    => '提现失败，必须为申请状态'
            );
        }
        return $data;
    }

    /**
     * 删除
     */
    public function del($id){
        $info = $this->where('is_active','1')->find($id);
        if(count($info) > 0){
            $info->is_active = '0';
            $status = $info->save();
            return $status;
        }else{
            return false;
        }
    }

    /**
     * 取消
     */
    public function cancel($id){
        $info = $this->where('state','0')->find($id);
        if(count($info) > 0){

            //开启事务
            DB::beginTransaction();

            //更改店员帐户
            $update_user_status = DB::table('clerk')->where('id',$info->clerk_id)->increment('balance',$info->money);

            //提现失败 更改状态
            $update_apply_status = DB::table($this->table)->where('id',$id)->update(['state'=>'2','done_time'=> date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s')]);

            if($update_user_status && $update_apply_status){
                DB::commit();
                return true;
            }else{
                DB::rollback();
                return false;
            }
        }else{
            return false;
        }
    }



}