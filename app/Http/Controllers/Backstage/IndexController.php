<?php

namespace App\Http\Controllers\Backstage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class IndexController extends \App\Http\Controllers\Backstage\Controller {

    public function __construct() {
        DB::connection()->enableQueryLog();
    }
    public function main(Request $request) {
        //get left menu
        if(empty($request->session()->get('admin_roleid')) || empty($request->session()->get('admin_userid'))){
            $request->session()->flush();
            return redirect()->guest('login');
        }
        $menuLogic = new \App\Logics\MenuLogic();
        $this->data['load_url'] = $menuLogic->getLoadUrl($this->checkLogin());
        $this->data['title'] = "益点点后台管理系统";
        return view('backstage.layouts.master', $this->data);
    }

    public function index() {
        return view('backstage.indexs.index');
    }

    public function top() {
        return view('backstage.publics.top');
    }

    public function left() {
        $menuLogic = new \App\Logics\MenuLogic();
        $this->data['mainMenu'] = $menuLogic->getSubMenus(0,$this->checkLogin());
        $this->data['load_url'] = $menuLogic->getLoadUrl($this->checkLogin());
        return view('backstage.publics.left',  $this->data);
    }

    public function footer() {
        return view('backstage.publics.footer');
    }

}
