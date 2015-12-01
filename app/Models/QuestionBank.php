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
class QuestionBank extends Model{
    protected  $table = 'question_bank';
//    protected $fillable = ['company_id','paper_name','number','is_active','answer_number','avg_value','is_random','getway','update_time'];
    public $timestamps = false;
    //题卷管理  题库列表首页
    public function getListData($page,$roller=15){
        $question_list = DB::table($this->table)->where(['is_active' => '1'])->take($roller)->skip($page > 1 ? ($page - 1) * $roller : 0)->orderBy('id','asc')->get();
        $count = 0;
        if($question_list){
            $count = DB::table($this->table)->where(['is_active' => '1'])->count();
        }
        return [($question_list ? $question_list : []),$count];
    }
    //题库管理  列表
    public function getQuestionList($data){
        $list = QuestionBank::problem(!empty($data['searchName']) ? $data['searchName'] : false)->take($data['pageSize'])->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
            ->orderBy('question_bank.is_active','desc')->orderBy('question_bank.id','asc')->select()->get();
        $count = 0;
        if($list){
            $count = QuestionBank::problem(!empty($data['searchName']) ? $data['searchName'] : false)->count();
        }
        return [$list,$count];
    }

    //题库管理   题库列表条件
    public function scopeProblem($query,$searchName)
    {
        if($searchName !== false){
            return $query->where('question_bank.problem','like','%'.$searchName.'%');
        }
    }


}