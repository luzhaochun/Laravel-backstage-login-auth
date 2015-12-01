<?php

namespace App\Logics;

use Illuminate\Support\Facades\DB;

class AdminLogic extends \Illuminate\Database\Eloquent\Model {

    protected $table = "admin";

    public function getAdminInfoByUsername($username = "") {
        return DB::table('admin')
                        ->where('is_active', '1')
                        ->where('user_name', $username)
                        ->select('id', 'user_name', 'password', 'role_id')->first();
    }
    
    
    public function getAdminList($page_no,$page_size){
        $list = DB::table('admin')
            ->join('auth_group', 'auth_group.id', '=', 'admin.role_id')
            ->select('admin.*','auth_group.name AS role_name')
            ->where('admin.is_active', '1')
            ->orderBy('admin.id', 'asc')
            ->take($page_size)
            ->skip($page_no > 1 ? ($page_no - 1) * $page_size : 0)
            ->get();
        $count = DB::table('admin')
            ->join('auth_group', 'auth_group.id', '=', 'admin.role_id')
            ->select('admin.*','auth_group.name AS role_name')
            ->where('admin.is_active', '1')
            ->count();
        return [$list, $count];
    }

}
