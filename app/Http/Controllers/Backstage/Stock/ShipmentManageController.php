<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 出库单管理
 */

namespace App\Http\Controllers\Backstage\Stock;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Logics\StockShipmentLogic;
use Illuminate\Support\Facades\DB;

class ShipmentManageController extends \App\Http\Controllers\Backstage\Controller {
    public function index(Request $request) {
        $stockShipmentLogic = new StockShipmentLogic();
        $map = $request->all();
        $map['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $map['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        list($result, $count) = $stockShipmentLogic->getShipmentList($map);
        $page = new Paginator($result, $map['pageSize'], $map['pageNo']);
        $paginator = new \App\Libraries\YddPaginator($count, $map['pageSize'], $map['pageNo'], $map);
        $this->data['paginator'] = $paginator;
        $this->data['list'] = $page->items();
        $this->data['state'] = $stockShipmentLogic->stateList();
        $this->data['searchName'] = !empty($request->get('searchName')) ? $request->get('searchName') : "";
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : 'desc';
        return view('backstage.stock.shipment.index', $this->data);
    }

    public function show(Request $request) {
        $stockShipmentLogic = new StockShipmentLogic();
        $areaLogic = new \App\Logics\AreaLogic();
        $this->data['arealist'] =$areaLogic->getAreaKeyValue();
        $this->data['info'] = $stockShipmentLogic->getStockShipmentInfo($request->get('id'));
        $this->data['state'] = $stockShipmentLogic->stateList();
        return view('backstage.stock.shipment.show',$this->data);
    }

    public function productList(Request $request) {
        $stockShipmentListLogic = new \App\Logics\StockShipmentListLogic();
        $map = $request->all();
        $map['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $map['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        list($result, $count) = $stockShipmentListLogic->getShipmentProductList($map,$request->get('id'));
        $page = new Paginator($result, $map['pageSize'], $map['pageNo']);
        $paginator = new \App\Libraries\YddPaginator($count, $map['pageSize'], $map['pageNo'], $map);
        $this->data['paginator'] = $paginator;
        $this->data['list'] = $page->items();
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : 'desc';
        return view('backstage.stock.shipment.products', $this->data);
    }
    public function remark(Request $request) {
        if($request->isMethod('post')){
            if(DB::table('stock_shipment')->where('id','=',intval($request->get('id')))->update(['remark'=> strval($request->get('remark'))])){
                show_message('修改成功','',1000,1);exit;
            }else{
                show_message('修改失败','goback',1000,0);exit;
            }
            
        }else{
            $this->data['id'] = $request->get('id');
            $this->data['remark'] = $request->get('remark');
            return view('backstage.stock.shipment.remark', $this->data); 
        }
        
    }
    
    public function search(Request $request) {
        $stockShipmentLogic = new StockShipmentLogic();
        $map = $request->all();
        $map['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $map['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        list($result, $count) = $stockShipmentLogic->getShipmentList($map);
        $page = new Paginator($result, $map['pageSize'], $map['pageNo']);
        $paginator = new \App\Libraries\YddPaginator($count, $map['pageSize'], $map['pageNo'], $map);
        $this->data['paginator'] = $paginator;
        $this->data['list'] = $page->items();
        $this->data['state'] = $stockShipmentLogic->stateList();
        $this->data['select_state'] =$stockShipmentLogic->stateList(false);
        $this->data['searchName'] = !empty($request->get('searchName')) ? $request->get('searchName') : "";
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : 'desc';
        $this->data['search_order_no'] = !empty($request->get('order_no')) ? $request->get('order_no') : "";
        $this->data['search_sales_order_no'] = !empty($request->get('sales_order_no')) ? $request->get('sales_order_no') : "";
        $this->data['search_consignee_name'] = !empty($request->get('consignee_name')) ? $request->get('consignee_name') : "";
        $this->data['search_consignee_tel'] = !empty($request->get('consignee_tel')) ? $request->get('consignee_tel') : "";
        $this->data['search_state'] = is_numeric($request->get('state')) ? $request->get('state') : 'temp';
        $this->data['search_start_time'] = !empty($request->get('start_time')) ? $request->get('start_time') : "";
        $this->data['search_end_time'] = !empty($request->get('end_time')) ? $request->get('end_time') : "";
        return view('backstage.stock.shipment.search', $this->data);
    }

}
