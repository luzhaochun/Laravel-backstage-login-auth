<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Requests\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController {
    use AuthorizesRequests,DispatchesJobs,ValidatesRequests;
    protected $data = [];
    public function __construct() {
        DB::connection()->enableQueryLog();
    }
    public function checkLogin() {
        if (empty(Session::get('admin_userid'))) {
            return 0;
        } else {
            return Session::get('admin_userid');
        }
    }
    
    public function getLastSql(){
        $queries = DB::getQueryLog();
        $a = end($queries);
        $tmp = str_replace('?', "'".'%s'."'", $a["query"]);
        return vsprintf($tmp, $a['bindings']);  
    }

}
