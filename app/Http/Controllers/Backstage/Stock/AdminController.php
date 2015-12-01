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

class AdminController extends Controller {

    public function index(Request $request) {
        $data = $request->all();
        $data['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $data['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        $stockDamageModel = new \App\Models\StockDamage();
        if(!empty($request->get('searchName'))){
            $data['searchName'] = trim($request->get('searchName'));
        }
        list($result, $count) = $stockDamageModel->getAdminListData($data);
        $page = new Paginator($result, $data['pageSize'], $data['pageNo']);
        $this->data['items'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $data['pageSize'], $data['pageNo'], $data);
        $this->data['idSort'] = !empty($request->get('idSort')) ? $request->get('idSort') : "desc";
        $this->data['searchName'] = !empty($data['searchName']) ? $data['searchName'] : "";
        $this->data['paginator'] = $paginator;
        return view('backstage.stock.index', $this->data);
    }
    
    // 新增人员
    public function add(Request $request){
        if($request->isMethod('post')){
            $res = Validator::make($request->all(), [
                'name' => 'required',
                'login'=> 'required|unique:stock_admin',
                'pwd'  => 'required'
            ]);
            if(!$res->fails()){
                $data['name'] = strval(trim(Input::get('name')));
                $data['login']= strval(trim(Input::get('login')));
                $data['pwd']  = md5(trim(Input::get('pwd')));
                //print_r($data);die;
                if(DB::table('stock_admin')->insert($data)){
                    return Redirect::to('StockManage/index');
                }else{
                    return Redirect::to('StockManage/addAdmin')->with('message', '新增失败!');  
                }
            }else{
                 return Redirect::to('StockManage/addAdmin')->with('message', '新增失败!');     
            }
        }
        return view('backstage.stock.add');
    }
    
    //编辑人员
    public function edit(Request $request){  
        if($request->isMethod('post')){
            $res = Validator::make($request->all(), [
                    'name' => 'required:stock_admin',
                    'login'=> 'required'
                ]);
                if(!$res->fails()){
                    $data['name'] = strval(trim(Input::get('name')));
                    $data['login']= strval(trim(Input::get('login')));
                    if(empty($request->get('pwd'))){
                        $data['pwd']  = md5(trim(Input::get('pwd')));
                    }
                    if(DB::table('stock_admin')->where('id','=',$request->get('admin_id'))->update($data)){
                        return Redirect::to('StockManage/index');
                    }else{
                        return redirect('StockManage/editAdmin?id='.$request->get('admin_id'))->with('status','编辑失败，请重试');
                    }
                }else{   
                     return redirect('StockManage/editAdmin?id='.$request->get('admin_id'))->with('status','编辑失败');
                }
        }else{
            $this->data['id'] = $request->get('id');
            $this->data['adminInfo'] = DB::table('stock_admin')->find($this->data['id']);
            //vardump(data);die;
            return view('backstage.stock.edit',  $this->data);
        }
        
    }
    
    //检查库存用户唯一性
    public function checkAdminExist(Request $request){
        if(strval(trim($request->get('type'))) == 'add'){
            $result = DB::table('stock_admin')->where('login','=',$request->get('login'))->first();
        }else{
            $result = DB::table('stock_admin')->where('login','=',$request->get('login'))->where('id','!=',strval($request->get('id')))->first();
        }
        if(!empty($result)) return json_encode(false);
        return json_encode(true);
    }
    
    //删除成员
    public function delAdmin(Request $request){
        if(!empty($request->input('id'))){
            if(DB::table('stock_admin')->where('id','=',  intval($request->input('id')))->delete()){
                echo json_decode(true);exit;
            }else{
                echo json_encode(false);exit;
            }
        }else{
            echo json_encode(false);exit;
        }
    }
}
