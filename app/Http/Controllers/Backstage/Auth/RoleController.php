<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Backstage\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class RoleController extends \App\Http\Controllers\Backstage\Controller{
    public function index(){
        $authGroupLogic = new \App\Logics\AuthGroupLogic();
        $this->data['groupList'] = $authGroupLogic->roleList();
        return view('backstage.auths.list', $this->data);
    }
    
    public function add(Request $request){
        if($request->isMethod('post')){
            $res = $this->validate($request, [
               'name'=>'required|unique:auth_group,is_active,1'
            ]);
            if(empty($res)){
                if(DB::table('auth_group')->insert(['name'=>$request->input('name')])){
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
            return view('backstage.auths.addrole');
        }
    }
    
    public function edit(Request $request){
        $list = [];
        if(empty($request->input('name')) || empty($request->input('id'))){
            $list['status'] = 'N';
            $list['msg'] = '编辑失败';
            return json_encode($list);
        }
        $name = strval(trim($request->input('name')));
        $id = intval(trim($request->input('id')));
        //check current edit role if exists
        $authGroupLogic = new \App\Logics\AuthGroupLogic();
        $res = DB::table('auth_group')->where('name','=',$name)->where('is_active','=','1')->where('id','!=',$id)->first();
        if(!empty($res)){
            $list['status'] = 'N';
            $list['msg'] = '该角色名称已经存在';
            return json_encode($list);
        }
        if(DB::table('auth_group')->where('id','=',$id)->update(['name'=>$name])){
            $list['status'] = 'Y';
            $list['msg'] = '编辑成功';
        }else{
            $list['status'] = 'N';
            $list['msg'] = '编辑失败';
        }
        return json_encode($list);
    }
    
    public function delete(Request $request){
        if(!empty(DB::table('auth_group')->whereIn('id',explode(',',rtrim($request->get('ids'),',')))->update(['is_active'=>'0']))) return json_encode(true);
        return json_decode(false);
    }
    
    public function memberlist(Request $request){
        $adminLogic = new \App\Logics\AdminLogic();
        $authGroupLogic = new \App\Logics\AuthGroupLogic();
        $authGroupAccessLogic = new \App\Logics\AuthGroupAccessLogic();
        $map['id'] = $request->get('id');
        $map['pageNo'] = !empty($request->get('pageNo')) ? $request->get('pageNo') : config('config.page_no');
        $map['pageSize'] = !empty($request->get('pageSize')) ? $request->get('pageSize') : config('config.page_size');
        $this->data['id'] = $request->get('id');
        //get all data info
        list($result,$count) = $adminLogic->getAdminList($map['pageNo'],$map['pageSize']);
        $page = new Paginator($result, $map['pageSize'], $map['pageNo']);
        $this->data['list'] = $page->items();
        $paginator = new \App\Libraries\YddPaginator($count, $map['pageSize'], $map['pageNo'],$map);
        foreach ($map as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = urlencode($val);
        }
        $this->data['rolelist'] = $authGroupLogic->getAuthGroup();
        $behaveMemberIds = $authGroupAccessLogic->getBehaveMemberIds($request->get('id'));
        foreach ($this->data['list'] as &$v){
            $v->flag = in_array($v->id, $behaveMemberIds);
        }
        $this->data['paginator'] = $paginator;
        return view('backstage.auths.memberlist',$this->data);
    }
    
    public function rulelist(Request $request){
        $menuLogic = new \App\Logics\MenuLogic();
        $authGroupLogic = new \App\Logics\AuthGroupLogic();
        if($request->isMethod('post')){
            $id = $request->get('id');
            $addRuleIds = !empty($request->get('addRuleIds')) ? $request->get('addRuleIds') : [];
            $allRuleIds = $request->get('allRuleIds');
            foreach ($allRuleIds as $v) {
                $authGroupLogic->updateAuthRule($id, $v, in_array($v, $addRuleIds));
            }
            return redirect()->back();
        }else{
            $this->data['id'] = $request->get('id');
            if(Cache::has('menulist')){
                $this->data['list'] = Cache::get('menulist');
            }else{
                $menuList = $menuLogic->getAllList();
                $this->data['list'] = $menuLogic->showTreeRule($menuLogic->buildAllRuleToTree($menuList));
                Cache::put('menulist',$this->data['list'],\Carbon\Carbon::now()->addMinute(30));
            }
            $authRuleIds = $authGroupLogic->getAuthRuleIds($this->data['id']);
            if(!empty($authRuleIds)){
                foreach ($this->data['list'] as &$v) {
                    if(in_array($v['id'], $authRuleIds)) {
                        $v['flag'] = 1;
                    }
                }
            }
            return view('backstage.auths.rulelist',$this->data);
        }
    }
    
    public function changeStatus(Request $request){
        $res = DB::table('auth_group')->where('id','=',  intval($request->input('id')))->first();
        if(!empty($res->id)){
            $status = $res->status == 1 ? 0 : 1;
            $res = DB::table('auth_group')->where('id','=',  intval($request->input('id')))->update(['status'=>$status]);
            return json_encode($res);
        }
        return json_encode(false);
    }
    
    public function checkRoleNameUnique(Request $request){
        $res = DB::table('auth_group')->where('name','=',strval(trim($request->get('name'))))->where('is_active','=','1')->first();
        if(!empty($res->id)) return json_encode (false);
        return json_encode(true);
    } 
}

