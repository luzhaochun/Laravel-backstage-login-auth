<?php
/**
 * 题卷表数据.
 * User: linwenshan
 * Date: 15/11/16
 * Time: 下午2:19
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Paper extends Model{
    protected  $table = 'paper';
    protected $fillable = ['company_id','paper_name','number','is_active','answer_number','avg_value','is_random','getway','update_time'];
    public $timestamps = false;
    //题卷列表首页
    public function getPaperListData($data){
        $list = DB::table($this->table)
            ->leftJoin('company','company.id','=','paper.company_id')
            ->where(function($query) use ($data){
                if(!empty($data['searchName']))
                    $query->where('company.name', 'like', '%'.$data['searchName'].'%')
                        ->orWhere('paper.paper_name', 'like', '%'.$data['searchName'].'%');

            })
            ->orderBy('paper.is_active','desc')
            ->orderBy('paper.id','desc')
            ->take($data['pageSize'])
            ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0) 
            ->select('paper.*','company.name AS company_name')
            ->get();
        $count = 0;
        if($list){
            $count = DB::table($this->table)
                ->LeftJoin('company','company.id','=','paper.company_id')
                ->where(function($query) use ($data){
                    if(!empty($data['searchName']))
                        $query->where('company.name', 'like', '%'.$data['searchName'].'%')
                            ->orWhere('paper.paper_name', 'like', '%'.$data['searchName'].'%');

                })
                ->count();
        }
        return [$list,$count];
    }

    //新增题卷
    public function addPaperData($data){
        $paperResult = Paper::create($data);
        return $paperResult->id;
    }

    //统计题目个数
    public function countNumbers($id){
        $where= ['paper.id'=>$id];
        $count = DB::table($this->table)
            ->join('r_paper_question_bank','r_paper_question_bank.paper_id','=','paper.id')
            ->join('question_bank',function($join){
                $join->on('question_bank.id','=','r_paper_question_bank.question_bank_id')
                    ->on('question_bank.is_active','=',DB::raw("'1'"));
            })
            ->where($where)
            ->count();
        return $count ? $count : 0;
    }


}