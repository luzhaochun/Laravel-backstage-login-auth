<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Drugstore extends Model
{
    protected $table = 'drugstore';

    public $timestamps = false;

    public function getDrugstoreListByState($state = ''){
        $list = DB::table($this->table)->where('is_active','1')->whereNotNull('state')->where(function($query) use ($state){
            if($state != ''){
                $query->where('state',$state);
            }
        })->select('id','name','lng','lat','state')->get();
        return $list;
    }


}