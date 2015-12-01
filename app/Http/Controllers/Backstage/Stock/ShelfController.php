<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Backstage\Stock;
use App\Libraries\YddPaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Backstage\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class ShelfController extends Controller{
    
    public function shelfIndex(Request $request){
        $data = $request->all();
        $data['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $data['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        $stockDamageModel = new \App\Models\StockDamage();
        if(!empty($request->get('searchName'))){
            $data['searchName'] = trim($request->get('searchName'));
        }
        list($result, $count) = $stockDamageModel->getShelfListData($data);
        $page = new Paginator($result, $data['pageSize'], $data['pageNo']);
        $this->data['items'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $data['pageSize'], $data['pageNo'], $data);
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : "desc";
        $this->data['searchName'] = !empty($data['searchName']) ? $data['searchName'] : "";
        $this->data['paginator'] = $paginator;
        
        return view('backstage.stock.shelfIndex',$this->data);
    }
    
    //新增货位
    public function shelfAdd(Request $request) {
        if($request->isMethod('post')){
            $res = Validator::make($request->all(),[
                'no' => 'required|unique:stock_shelf',
                'state' => 'required',
            ]);
            if(!$res->fails()){
                $data['no']  = strval(trim(Input::get('no')));
                $data['state']  = strval(trim(Input::get('state')));
                if(DB::table('stock_shelf')->insert($data)){
                    return json_encode(['status'=>true,'msg'=>'保存成功']);
                }else{
                    return json_encode(['status'=>false,'msg'=>'保存失败']);
                }
            }else{
                return json_encode(['status'=>false,'msg'=>'保存失败']);
            }
        }
        return view('backstage.stock.shelfAdd');
    }
    
    //检查货位编码是否存在
    public function checkShelfNoExist(Request $request){
        if(strval(trim($request->get('type'))) == 'add'){
            $result = DB::table('stock_shelf')->where('no','=',$request->get('no'))->first();
        }else{
            $result = DB::table('stock_shelf')->where('no','=',$request->get('no'))->where('id','!=',strval($request->get('id')))->first();
        }
        if(!empty($result)) return json_encode(false);
        return json_encode(true);
    }
    
    //编辑货位
    public function shelfEdit(Request $request){
        if($request->isMethod('post')){
            $res = Validator::make($request->all(),[
                'no' => 'required|unique:stock_shelf',
                'state' => 'required',
            ]);
            if(!$res->fails()){
                $data['no']  = strval(trim(Input::get('no')));
                $data['state']  = strval(trim(Input::get('state')));
                if(DB::table('stock_shelf')->where('id','=',$request->get('shelf_id'))->update($data)){
                    return json_encode(['status'=>true,'msg'=>'保存成功']); 
                }else{
                    return json_encode(['status'=>false,'msg'=>'保存失败']);
                }
            }else{   
                 return json_encode(['status'=>false,'msg'=>'保存失败']);
            }
        
        }else{
            $this->data['id'] = $request->get('id');
            $this->data['shelfInfo'] = DB::table('stock_shelf')->find($this->data['id']);
            //print_r( $this->data['shelfInfo']);die;
            return view('backstage.stock.shelfEdit',  $this->data);
        }
    }
    
    //删除货位
    public function shelfDel(Request $request){
        if(!empty($request->input('id'))){
            if(DB::table('stock_shelf')->where('id','=',intval($request->input('id')))->delete()){
                return json_encode(true);
            }else{
                return json_encode(false);
            }
        }else{
            return json_encode(false);
        }
    }
}
