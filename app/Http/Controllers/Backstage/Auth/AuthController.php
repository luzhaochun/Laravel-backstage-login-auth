<?php

namespace App\Http\Controllers\Backstage\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class AuthController extends \App\Http\Controllers\Backstage\Controller {
    public function menulist(){
        if(Cache::has('menulist')){
            $this->data['list'] = Cache::get('menulist');
        }else{
            $menuLogic = new \App\Logics\MenuLogic();
            $menuList = $menuLogic->getAllList();
            $this->data['list'] = $menuLogic->showTreeRule($menuLogic->buildAllRuleToTree($menuList));
            Cache::put('menulist',$this->data['list'],  \Carbon\Carbon::now()->addMinute(30));
        }
        return view('backstage.auths.menu', $this->data);
    }
    
    public function menuAdd(Request $request){
        if($request->isMethod('post')){
            $res = $this->validate($request, [
               'module'=>'required|unique:menu,is_active,1',
               'name'  => 'required',
               'sort'  => 'required|min:1'
            ]);
            if(empty($res)){
                $data['module'] = strval(trim(Input::get('module')));
                $data['name'] = strval(trim(Input::get('name')));
                $data['display'] = intval(Input::get('display'));
                $data['sort'] = intval(Input::get('sort'));
                $data['new_class'] = strval(trim(Input::get('new_class')));
                $data['parent_id'] = !empty(Input::get('parent_id')) ? intval(Input::get('parent_id')) : 0;
                if(DB::table('menu')->insert($data)){
                    //remove cache:menulist
                    if(Cache::has('menulist')){
                        Cache::forget('menulist');
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
            //get all menu list
            if(Cache::has('menulist')){
                $this->data['list'] = Cache::get('menulist');
            }else{
                $menuLogic = new \App\Logics\MenuLogic();
                $menuList = $menuLogic->getAllList();
                $this->data['list'] = $menuLogic->showTreeRule($menuLogic->buildAllRuleToTree($menuList));
            }
            $this->data['menuid'] = !empty(Input::get('id')) ? intval(Input::get('id')) : 0;
            return view('backstage.auths.addmenu',  $this->data);
        }
    }
    
    public function menuEdit(Request $request){
        $menuLogic = new \App\Logics\MenuLogic();
        if($request->isMethod('post')){
            $res = $this->validate($request, [
               'module'=>'required:menu',
               'name'  => 'required',
               'sort'  => 'required|min:1'
            ]);
            if(empty($res)){
                $data['module'] = strval(trim(Input::get('module')));
                $data['name'] = strval(trim(Input::get('name')));
                $data['display'] = intval(Input::get('display'));
                $data['sort'] = intval(Input::get('sort'));
                $data['new_class'] = strval(trim(Input::get('new_class')));
                $data['parent_id'] = !empty(Input::get('parent_id')) ? intval(Input::get('parent_id')) : 0;
                if(DB::table('menu')->where('id','=',Input::get('menu_id'))->update($data)){
                    //remove cache:menulist
                    if(Cache::has('menulist')){
                        Cache::forget('menulist');
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
            if(Cache::has('menulist')){
                $this->data['list'] = Cache::get('menulist');
            }else{
                $menuList = $menuLogic->getAllList();
                $this->data['list'] = $menuLogic->showTreeRule($menuLogic->buildAllRuleToTree($menuList));
            }
            $this->data['id'] = !empty(Input::get('id')) ? intval(Input::get('id')) : 0;
            //get menu info 
            $this->data['menuinfo'] = $menuLogic->getMenuById($this->data['id']);
            return view('backstage.auths.editmenu',  $this->data);
        }
    }
    
    
    public function checkMenuModuleUnique(){
        $menuLogic = new \App\Logics\MenuLogic();
        if(trim(strval(Input::get('type'))) == 'add'){
            $result = $menuLogic::where('module','=',  trim(strval(Input::get('module'))))
                    ->where('is_active','=','1')
                    ->get()
                    ->toArray();
        }else{
            $result = $menuLogic::where('module','=',  trim(strval(Input::get('module'))))
                    ->where('is_active','=','1')
                    ->where('id','!=',  intval(Input::get('id')))
                    ->get()
                    ->toArray();
        }
        if(!empty($result)) return json_encode(false);
        return json_encode(true);
    }
    
    public function updatemenusort(Request $request){
        $res = DB::table('menu')->where('id','=',  intval(Input::get('id')))->update(['sort'=>intval(Input::get('sort'))]);
        if($res == 1){
            //remove cache:menulist
            if(Cache::has('menulist')){
                Cache::forget('menulist');
            }
            return json_encode(true);
        }else{
            return json_encode(false);
        }    
    }
    
    public function changemenustatus(){
        $menuLogic = new \App\Logics\MenuLogic();
        $display = $menuLogic->getMenuById(trim(Input::get('id')))['display'];
        $res = DB::table('menu')->where('id','=',  intval(Input::get('id')))->update(['display'=>($display == 1 ? 0 : 1)]);
        if($res == 1){
            //remove cache:menulist
            if(Cache::has('menulist')){
                Cache::forget('menulist');
            }
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }
    
    public function menuDel(Request $request){
        if(!empty($request->input('id'))){
            if(DB::table('menu')->where('id','=',  intval($request->input('id')))->update(['is_active'=>'0'])){
                //remove cache:menulist
                if(Cache::has('menulist')){
                    Cache::forget('menulist');
                }
                echo json_decode(true);exit;
            }else{
                echo json_encode(false);exit;
            }
        }else{
            echo json_encode(false);exit;
        }
    }
}
