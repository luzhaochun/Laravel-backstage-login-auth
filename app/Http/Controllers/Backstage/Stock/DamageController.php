<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Backstage\Stock;
use App\Libraries\YddPaginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;



class DamageController extends \App\Http\Controllers\Backstage\Controller{
    
    public function damageIndex(Request $request){
        $data = $request->all();
        $data['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $data['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        $stockDamageModel = new \App\Models\StockDamage();
        if(!empty($request->get('searchName'))){
            $data['searchName'] = trim($request->get('searchName'));
        }
        list($result,$count) = $stockDamageModel->getDamageListData($data);
        $page = new Paginator($result, $data['pageSize'], $data['pageNo']);
        $this->data['items'] = $page->items();
        //实例化分页
        $paginator = new YddPaginator($count, $data['pageSize'], $data['pageNo'], $data);
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : "desc";
        $this->data['searchName'] = !empty($data['searchName']) ? $data['searchName'] : "";
        $this->data['paginator'] = $paginator;
        return view('backstage.stock.damageIndex',$this->data);
    }
    
    
    //新增报损
    public function damageAdd(Request $request){
        $stockDamageModel = new \App\Models\StockDamage();
        $this->data['shelf'] = $stockDamageModel->getShelfList();
        //print_r($this->data['shelf']);die;
        if($request->isMethod('post')){
            $res = Validator::make($request->all(), [
                'product_name' => 'required',
                'product_count'=> 'required',
                'product_batch'  => 'required',
                'product_no'  => 'required'
            ]);
            if($res->fails()){
                $data['product_name'] = strval(trim(Input::get('product_name')));
                $data['product_count']= strval(trim(Input::get('product_count')));
                $data['product_batch']  = strval(trim(Input::get('product_batch')));
                $data['shelf_no']  = strval(trim(Input::get('shelf_no')));
                $data['shelf_id']  = strval(trim(array_search($data['shelf_no'], $this->data['shelf'])));
                $data['remark']  = strval(trim(Input::get('remark')));
                $data['operater_name']  = $request->session()->get('admin_username');
                $data['operater_id']  = $request->session()->get('admin_userid');
                $data['operate_date']  = date('Y-m-d,H:i:s');
                //print_r($data);die;
                if(DB::table('stock_damaged')->insert($data)){
                    return json_encode(['status'=>true,'msg'=>'保存成功']); 
                }else{
                    return json_encode(['status'=>false,'msg'=>'保存失败']);
                }
            }else{
                return json_encode(['status'=>false,'msg'=>'保存失败']);
            }
            
        }
            return view('backstage.stock.damageAdd',  $this->data);
    }
    
    //编辑报损
    public function damageEdit (Request $request){
        $stockDamageModel = new \App\Models\StockDamage();
        $this->data['shelf'] = $stockDamageModel->getShelfList();
        if($request->isMethod('post')){
            $res = Validator::make($request->all(), [
                    'product_name' => 'required',
                    'product_count'=> 'required',
                    'product_batch' => 'required',
                    'shelf_no'  => 'required'
                ]);
                if(!$res->fails()){
                    $data['product_name'] = strval(trim(Input::get('product_name')));
                    $data['product_count']= strval(trim(Input::get('product_count')));
                    $data['product_batch']  = strval(trim(Input::get('product_batch')));
                    $data['shelf_no']  = strval(trim(Input::get('shelf_no')));
                    $data['shelf_id']  = strval(trim(array_search($data['shelf_no'], $this->data['shelf'])));
                    $data['remark']  = strval(trim(Input::get('remark')));
                    $data['operater_name']  = $request->session()->get('admin_username');
                    $data['operater_id']  = $request->session()->get('admin_userid');
                    $data['operate_date']  = date('Y-m-d,H:i:s');
                    if(DB::table('stock_damaged')->where('id','=',$request->get('damage_id'))->update($data)){
                        return json_encode(['status'=>true,'msg'=>'保存成功']); 
                    }else{
                        return json_encode(['status'=>false,'msg'=>'保存失败']);
                    }
                }else{   
                     return json_encode(['status'=>false,'msg'=>'保存失败']);
                }
        }else{
            $this->data['id'] = $request->get('id');
            $this->data['damageInfo'] = DB::table('stock_damaged')->find($this->data['id']);
            //print_r( $this->data['damageInfo']);die;
            return view('backstage.stock.damageEdit',  $this->data);
        }
    }

    //删除报损
    public function damageDel(Request $request){
        if(!empty($request->input('id'))){
            if(DB::table('stock_damaged')->where('id','=',  intval($request->input('id')))->delete()){
                echo json_decode(true);exit;
            }else{
                echo json_encode(false);exit;
            }
        }else{
            echo json_encode(false);exit;
        }
    }
}