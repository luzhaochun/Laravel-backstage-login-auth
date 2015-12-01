<?php
/**
 * 题库表数据.
 * User: linwenshan
 * Date: 15/11/16
 * Time: 下午2:19
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class RPaperQuestionBank extends Model{
    protected  $table = 'r_paper_question_bank';
    protected $fillable = ['paper_id','question_bank_id'];
    public $timestamps = false;

    //获取题卷关联题库的id
    public function getPaperInfor($id){
        $list = RPaperQuestionBank::where(['paper_id'=>$id])->select('question_bank_id')->get();
        return empty($list) ? [] : array_column($this->objOrArray($list),'question_bank_id');
    }

    //对象转数组
    public function objOrArray($list){
        $newlist = [];
        foreach($list  as $key=>$value){
            $newlist[]['question_bank_id'] = $value->question_bank_id;
        }
        return $newlist;
    }


    //固定题卷更新操作
    public function updatepaperinfo($id,$addRuleIds){
        $paperModel = new \App\Models\Paper();
        DB::beginTransaction();//开启事务
        $result = DB::table($this->table)->where(['paper_id'=>$id])->get();
        if($result != false){
            $del_result = DB::table($this->table)->where(['paper_id'=>$id])->delete();
        }else{
            $del_result = true;
        }
        if(!empty($addRuleIds)){
            $arr = [];
            foreach($addRuleIds as $value){
                $arr[] = ['paper_id'=>$id,'question_bank_id'=>$value];
            }
            $insert_result = DB::table($this->table)->insert($arr);
            $paper_result = $paperModel->where(['id'=>$id])->update(['number'=>count($addRuleIds)]);
        }else{
            $insert_result = true;
            $paper_result = true;
        }
        if($del_result != false && $insert_result != false && $paper_result != false){
            DB::commit();
            return ['status'=>true,'message'=>'保存成功'];
        }else{
            DB::rollback();
            return ['status'=>false,'message'=>'保存失败'];
        }


    }
}