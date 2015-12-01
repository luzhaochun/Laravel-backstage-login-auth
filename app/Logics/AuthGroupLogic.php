<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Logics;
use Illuminate\Support\Facades\DB;

class AuthGroupLogic extends \Illuminate\Database\Eloquent\Model{
    protected $table = "auth_group";
    
    public function roleList(){
        return self::where('is_active','=','1')->orderBy('id', 'asc')->get()->toArray();
    }
    public function getAuthGroup(){
        $result = self::where('is_active','=','1')->select('id','name')->orderBy('id')->get()->toArray();
        $temp = [];
        foreach($result as $item){
            $temp[$item['id']]=$item['name'];
        }
        return $temp;
    }
    
    public function getAuthRuleIds($id){
        $temp = [];
        $record = self::where('id','=',$id)->first()->toArray();     
        if(!empty($record['rules'])){
            $temp = explode(',', $record['rules']);
        }
        return $temp;
    }
    
    public function updateAuthRule($authGroupId, $authRuleId, $add = true){
        $authRuleIds = $this->getAuthRuleIds($authGroupId);
        if (!empty($add)) {
            if (!in_array($authRuleId, $authRuleIds)) {
                $authRuleIds[] = $authRuleId;
            }
        } else {
            if(array_search($authRuleId, $authRuleIds) !== false) {
                unset($authRuleIds[array_search($authRuleId, $authRuleIds)]);
            }
        }
        DB::table($this->table)->where('id','=',$authGroupId)->update(['rules'=>implode(',', $authRuleIds)]);
    }
}
