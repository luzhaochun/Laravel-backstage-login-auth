<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SystemLog extends Model
{
    protected $table = 'system_logs';

    public $timestamps = false;

    /**
     * 获取登录日志信息
     * @param null $params 参数
     * @return array
     */
    public function getLoginList($params = null){
        $orderField = !empty($params['sortName']) ? $params['sortName'] : 'update_time';  // 排序字段
        $orderValue = !empty($params['sortType']) ? $params['sortType'] : 'DESC';  // 排序

        $list = DB::table('system_logs')
            ->where('type', '1')
            ->where(function ($query) use ($params) {
                // 搜索条件
                if(!empty($params['searchName']))
                    $query->where('log_info', 'like', '%'.trim($params['searchName']).'%')
                        ->orWhere('admin_name', 'like', '%'.trim($params['searchName']).'%');
            })
            ->orderBy($orderField, $orderValue)
            ->take($params['pageSize'])
            ->skip($params['pageNo'] > 1 ? ($params['pageNo'] - 1) * $params['pageSize'] : 0)
            ->get();

        $count = DB::table('system_logs')
            ->where('type', '1')
            ->where(function ($query) use ($params) {
                // 搜索条件
                if(!empty($params['searchName']))
                    $query->where('log_info', 'like', '%'.trim($params['searchName']).'%')
                        ->orWhere('admin_name', 'like', '%'.trim($params['searchName']).'%');
            })
            ->count();
        return [$list, $count];
    }

    /**
     * 获取操作日志信息
     * @param null $params 参数
     * @return array
     */
    public function getOperateList($params = null){
        $orderField = !empty($params['sortName']) ? $params['sortName'] : 'update_time';  // 排序字段
        $orderValue = !empty($params['sortType']) ? $params['sortType'] : 'DESC';  // 排序

        $list = DB::table('system_logs')
            ->where('type', '0')
            ->where(function ($query) use ($params) {
                // 搜索条件
                if(!empty($params['searchName']))
                    $query->where('log_info', 'like', '%'.trim($params['searchName']).'%')
                        ->orWhere('admin_name', 'like', '%'.trim($params['searchName']).'%');
            })
            ->orderBy($orderField, $orderValue)
            ->take($params['pageSize'])
            ->skip($params['pageNo'] > 1 ? ($params['pageNo'] - 1) * $params['pageSize'] : 0)
            ->get();

        $count = DB::table('system_logs')
            ->where('type', '0')
            ->where(function ($query) use ($params) {
                // 搜索条件
                if(!empty($params['searchName']))
                    $query->where('log_info', 'like', '%'.trim($params['searchName']).'%')
                        ->orWhere('admin_name', 'like', '%'.trim($params['searchName']).'%');
            })
            ->count();
        return [$list, $count];
    }

    /**
     * 写入日志
     * @param $data
     */
    public static function logWrite($data){
        DB::table('system_logs')->insert($data);
    }
}