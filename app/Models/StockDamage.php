<?php

/**
 * 人员管理数据.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockDamage extends Model {

    protected $stock_admin = 'stock_admin';
    protected $stock_damaged = 'stock_damaged';
    protected $stock_shelf = 'stock_shelf';

    //人员管理列表首页
    public function getAdminListData($data) {
        if (!empty($data['idSort'])) {
            $orderValue = $data['idSort'];
        } else {
            $orderValue = 'desc';
        }
        $list = DB::table($this->stock_admin)
                ->where(function($query) use ($data) {
                    if (!empty($data['searchName']))
                        $query->where('stock_admin.name', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('stock_admin.login', 'like', '%' . $data['searchName'] . '%');
                })->orderBy('stock_admin.id', $orderValue)
                ->take($data['pageSize'])
                ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
                ->select('stock_admin.*')
                ->get();
        $count = 0;
        if (!empty($list)) {
            $count = DB::table($this->stock_admin)
                            ->where(function($query) use ($data) {
                                if (!empty($data['searchName']))
                                    $query->where('stock_admin.name', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('stock_admin.login', 'like', '%' . $data['searchName'] . '%');
                            })->count();
        }
        return [$list, $count];
    }
    
    
    
    //报损管理列表首页
    public function getDamageListData($data) {
        if (!empty($data['idSort'])) {
            $orderValue = $data['idSort'];
        } else {
            $orderValue = 'desc';
        }
        $list = DB::table($this->stock_damaged)
                ->where(function($query) use ($data) {
                    if (!empty($data['searchName']))
                        $query->where('stock_damaged.product_name', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('stock_damaged.product_batch', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('stock_damaged.shelf_no', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('stock_damaged.operater_name', 'like', '%' . $data['searchName'] . '%');
                })->orderBy('stock_damaged.id', $orderValue)
                ->take($data['pageSize'])
                ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
                ->select('stock_damaged.*')
                ->get();
        $count = 0;
        if (!empty($list)) {
            $count = DB::table($this->stock_damaged)
                            ->where(function($query) use ($data) {
                                if (!empty($data['searchName']))
                                    $query->where('stock_damaged.product_name', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('stock_damaged.product_batch', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('stock_damaged.shelf_no', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('stock_damaged.operater_name', 'like', '%' . $data['searchName'] . '%');
                            })->count();
        }
        return [$list, $count];
    }
    
    //获取货架信息
    public function getShelfList(){
        $shelf = DB::table('stock_shelf')
            ->select('id', 'no')
            ->orderBy('id')
            ->get();
        $temp = [];
        foreach ($shelf as $value){
            $temp[$value->id] = $value->no;
        }
        return $temp;
    }
    
    //货位管理列表首页
    public function getShelfListData($data) {
        if (!empty($data['idSort'])) {
            $orderValue = $data['idSort'];
        } else {
            $orderValue = 'desc';
        }
        $list = DB::table($this->stock_shelf)
                ->where(function($query) use ($data) {
                    if (!empty($data['searchName']))
                        $query->where('stock_shelf.no', 'like', '%' . $data['searchName'] . '%');
                })->orderBy('stock_shelf.id', $orderValue)
                ->take($data['pageSize'])
                ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
                ->select('stock_shelf.*')
                ->get();
        $count = 0;
        if (!empty($list)) {
            $count = DB::table($this->stock_shelf)
                            ->where(function($query) use ($data) {
                                if (!empty($data['searchName']))
                                    $query->where('stock_shelf.no', 'like', '%' . $data['searchName'] . '%');
                            })->count();
        }
        return [$list, $count];
    }

}
