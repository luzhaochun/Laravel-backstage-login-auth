<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Logics;

use Illuminate\Support\Facades\DB;

class StockShipmentListLogic extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'stock_shipment_list';
    
    public function getProductList($shipmentId){
        return self::where('shipment_id','=',$shipmentId)->select('id','product_name','product_count')->get()->toArray();
    }

    public function getShipmentProductList($data = [],$shipmentId){
        if (!empty($data['idSort'])) {
            $orderValue = $data['idSort'];
        } else {
            $orderValue = 'desc';
        }
        $list = DB::table($this->table)
            ->where('shipment_id','=',$shipmentId)
            ->orderBy('id', $orderValue)
            ->take($data['pageSize'])
            ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
            ->get();
        $count = 0;
        if (!empty($list)) {
            $count = DB::table($this->table)
                ->where('shipment_id','=',$shipmentId)
                ->count();
        }
        return [$list, $count];
    }
}
