<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Logics;

use Illuminate\Support\Facades\DB;

class StockShipmentLogic extends \Illuminate\Database\Eloquent\Model {

    protected $table = "stock_shipment";
    protected $shipment_state = array(
        0 => '删除',
        1 => '<span style="color:#808080;">未出货</span>',
        2 => '<span style="color:#6600EE;">正在出货</span>',
        3 => '<span style="color:green;">已发出</span>',
        4 => '已发货有缺货',
        5 => '缺货已发',
    );

    public function getShipmentList($data) {
        if (!empty($data['idSort'])) {
            $orderValue = $data['idSort'];
        } else {
            $orderValue = 'desc';
        }

        $list = DB::table($this->table)
                ->where(function($query) use ($data) {
                    if (!empty($data['searchName']))
                        $query->where('order_no', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('pack_code', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('consignee_name', 'like', '%' . $data['searchName'] . '%')
                        ->orWhere('consignee_tel', 'like', '%' . $data['searchName'] . '%');
                })->where(function($query) use($data) {
                    if (!empty($data['order_no'])) {
                        $query->where('order_no', 'like', '%' . $data['order_no'] . '%');
                    }
                })->where(function($query) use($data) {
                    if (!empty($data['sales_order_no'])) {
                        $query->where('sales_order_no', 'like', '%' . $data['sales_order_no'] . '%');
                    }
                })->where(function($query) use($data) {
                    if (!empty($data['consignee_name'])) {
                        $query->where('consignee_name', 'like', '%' . $data['consignee_name'] . '%');
                    }
                })->where(function($query) use($data) {
                    if (!empty($data['consignee_tel'])) {
                        $query->where('consignee_tel', 'like', '%' . $data['consignee_tel'] . '%');
                    }
                })->where(function($query) use($data) {
                    if (isset($data['state']) && is_numeric($data['state'])) {
                        $query->where('state', '=', $data['state']);
                    }
                })->where(function($query) use($data) {
                    if (!empty($data['start_time']) && !empty($data['end_time'])) {
                        $query->where($this->table . '.operate_date', '>=', $data['start_time'])
                        ->where($this->table . '.operate_date', '<=', $data['end_time']);
                    } else if (!empty($data['start_time'])) {
                        $query->where($this->table . '.operate_date', '>=', $data['start_time']);
                    } else if (!empty($data['apply_end_time'])) {
                        $query->where($this->table . '.operate_date', '<=', $data['end_time']);
                    }
                })->orderBy('id', $orderValue)
                ->take($data['pageSize'])
                ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
                ->get();
        $count = 0;
        if (!empty($list)) {
            $count = DB::table($this->table)
                            ->where(function($query) use ($data) {
                                if (!empty($data['searchName']))
                                    $query->where('order_no', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('pack_code', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('consignee_name', 'like', '%' . $data['searchName'] . '%')
                                    ->orWhere('consignee_tel', 'like', '%' . $data['searchName'] . '%');
                            })->where(function($query) use($data) {
                        if (!empty($data['order_no'])) {
                            $query->where('order_no', 'like', '%' . $data['order_no'] . '%');
                        }
                    })->where(function($query) use($data) {
                        if (!empty($data['sales_order_no'])) {
                            $query->where('sales_order_no', 'like', '%' . $data['sales_order_no'] . '%');
                        }
                    })->where(function($query) use($data) {
                        if (!empty($data['consignee_name'])) {
                            $query->where('consignee_name', 'like', '%' . $data['consignee_name'] . '%');
                        }
                    })->where(function($query) use($data) {
                        if (!empty($data['consignee_tel'])) {
                            $query->where('consignee_tel', 'like', '%' . $data['consignee_tel'] . '%');
                        }
                    })->where(function($query) use($data) {
                        if (isset($data['state']) && is_numeric($data['state'])) {
                            $query->where('state', '=', $data['state']);
                        }
                    })->where(function($query) use($data) {
                        if (!empty($data['start_time']) && !empty($data['end_time'])) {
                            $query->where($this->table . '.operate_date', '>=', $data['start_time'])
                                    ->where($this->table . '.operate_date', '<=', $data['end_time']);
                        } else if (!empty($data['start_time'])) {
                            $query->where($this->table . '.operate_date', '>=', $data['start_time']);
                        } else if (!empty($data['apply_end_time'])) {
                            $query->where($this->table . '.operate_date', '<=', $data['end_time']);
                        }
                    })->count();
        }
        return [$list, $count];
    }

    public function getState($state) {
        if (array_key_exists($state, $this->shipment_state)) {
            return $this->shipment_state[$state];
        } else {
            return '<span style="color:red;">异常</span>';
        }
    }

    public function stateList($css = true) {
        if ($css) {
            return $this->shipment_state;
        } else {
            return [
                0 => '删除',
                1 => '未出货',
                2 => '正在出货',
                3 => '已发出',
                4 => '已发货有缺货',
                5 => '缺货已发',
            ];
        }
    }

    public function getStockShipmentInfo($id) {
        return DB::table($this->table)->where('id', '=', $id)->first();
    }

}
