<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Logics;

class AuthGroupAccessLogic extends \Illuminate\Database\Eloquent\Model{
    protected $table = "auth_group_access";
    
    public function getBehaveMemberIds($authGroupId) {
        $temp = [];
        $behaveMemberIds = self::where('group_id','=',intval($authGroupId))->get()->toArray();
        if (!empty($behaveMemberIds)) {
            foreach ($behaveMemberIds as $v) {
                $temp[] = $v['uid'];
            }
        }
        return $temp;
    }
}

