<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Backstage\Auth;
use App\Logics\AreaLogic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AreaController extends \App\Http\Controllers\Backstage\Controller{
    
    public function index(){
        $areaLogic = new AreaLogic();
        
        if(Cache::has('arealist')){
            $this->data['list'] = Cache::get('arealist');
        }else{
            $arealist = $areaLogic->showTreeArea($areaLogic->buildAllAreaToTree($areaLogic->getAreaList()));
            Cache::put('arealist',$arealist,\Carbon\Carbon::now()->addMinute(30));
            $this->data['list'] = $arealist;  
        }
        
        return view('backstage.auths.area.index',$this->data);
    }
    
    public function add(Request $request){
        $areaLogic = new AreaLogic();
        if($request->isMethod('post')){
             $res =  Validator::make($request->all(), [
               'code'  => 'required|integer|unique:area,is_active,1',
               'name'=>'required'
               
            ]);
            if(!$res->fails()){
                $data['name'] = strval(trim($request->get('name')));
                $data['code'] = trim($request->get('code'));
                $data['zone_number'] = trim($request->get('zone_number'));
                $data['status'] = intval(trim($request->get('status')));
                $data['parent_id'] = intval($request->get('parent_id'));
                $data['is_active'] = '1';
                $data['level'] = !empty($areaLogic->getLevelByCode($data['parent_id'])) ? $areaLogic->getLevelByCode($data['parent_id']) + 1 : 1;
                if(DB::table('area')->insert($data)){
                    //remove cache:menulist
                    if(Cache::has('arealist')){
                        Cache::forget('arealist');
                    }
                    echo json_encode(['status'=>true, 'msg'=>'新增成功！']);
                    exit();
                }else{
                    echo json_encode(['status'=>false, 'msg'=>'新增失败！']);
                    exit();
                }
            }else{
                echo json_encode(['status'=>false, 'msg'=>'新增失败！']);
                exit();
            }
        }else{
            if(Cache::has('arealist')){
                $this->data['list'] = Cache::get('arealist');
            }else{
                $arealist = $areaLogic->showTreeArea($areaLogic->buildAllAreaToTree($areaLogic->getAreaList()));;
                Cache::put('arealist',$arealist,\Carbon\Carbon::now()->addMinute(30));
                $this->data['list'] = $arealist;  
            }
            return view('backstage.auths.area.add',$this->data);
        }
    }
    
    public function edit(Request $request){
        $areaLogic = new AreaLogic();
        if($request->isMethod('post')){
            $data['name'] = strval(trim($request->get('name')));
            $data['code'] = trim($request->get('code'));
            $data['zone_number'] = trim($request->get('zone_number'));
            $data['status'] = intval(trim($request->get('status')));
            $data['parent_id'] = intval($request->get('parent_id'));
            $data['level'] = !empty($areaLogic->getLevelByCode($data['parent_id'])) ? $areaLogic->getLevelByCode($data['parent_id']) + 1 : 1;
            $res =  Validator::make($request->all(), [
               'code'  => 'required|integer:area',
               'name'=>'required'
            ]);
            if(!$res->fails()){
                if(DB::table('area')->where('id','=',  intval($request->get('id')))->update($data)){
                    if(Cache::has('arealist')){
                        Cache::forget('arealist');
                    }
                    echo json_encode(['status'=>true, 'msg'=>'编辑成功！']);
                    exit();
                }else{
                    echo json_encode(['status'=>false, 'msg'=>'编辑失败！']);
                    exit();
                }
            }else{
                echo json_encode(['status'=>false, 'msg'=>'编辑失败！']);
                exit();
            }
            
        }else{
            if(Cache::has('arealist')){
                $this->data['list'] = Cache::get('arealist');
            }else{
                $arealist = $areaLogic->showTreeArea($areaLogic->buildAllAreaToTree($areaLogic->getAreaList()));;
                Cache::put('arealist',$arealist,\Carbon\Carbon::now()->addMinute(30));
                $this->data['list'] = $arealist;  
            }
            $this->data['areainfo'] = DB::table('area')->where('id','=',  intval($request->get('id')))->first();
            return view('backstage.auths.area.edit',$this->data);
        }
    }
    
    public function del(Request $request){
        if(DB::table('area')->where('id','=',$request->get('id'))->update(['is_active'=>'0'])){
            if(Cache::has('arealist')){
                Cache::forget('arealist');
            }
        }
        return redirect('Area/index');
    }
    
    public function getAreaInfo(){
        
    }
    
    public function checkNameUnique(){
        
    }
    
    public function checkCodeUnique(Request $request){
        if($request->get('type') == 'add'){
            $result = DB::table('area')->where('code','=',  intval(trim($request->get('code'))))->where('is_active','=','1')->first();
        }else{
            $result = DB::table('area')
                    ->where('code','=',  intval(trim($request->get('code'))))
                    ->where('id','!=',  intval(trim($request->get('id'))))
                    ->where('is_active','=','1')->first();
        }
        if(!empty($result)) return json_encode(false);
        return json_encode(true);
    }
    
    public function checkZoneNumberUnique(){
        
    }
    
}