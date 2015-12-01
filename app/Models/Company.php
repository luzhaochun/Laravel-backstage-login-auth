<?php
/**
 * 企业表.
 * User: linwenshan
 * Date: 15/11/16
 * Time: 下午2:19
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Company extends Model{
    protected  $table = 'company';

    public $timestamps = false;
    //根据条件搜索企业
    public function getSearchData($name){
        $list = Company::CompanySearch($name)->select('name','id')->get();
        return count($list)>0 ? [] : $list;
    }

    //题卷列表首页查询条件
    public function scopeCompanySearch($query,$searchName)
    {
        if($searchName!==false){
            return $query->where('company.name', 'like', '%'.$searchName.'%');
        }
    }

    //获取所有企业
    public function getCompanyList(){
        $list = Company::where(['is_active'=>'1'])->select('id','name')->get();
        return empty($list) ? [] : $list;
    }

    //获取关联的企业
    public function getCompanyData($id){
        $infor = Company::where(['id'=>$id])->select('id','name')->first();
        return  $infor ? $infor : [];
    }
}