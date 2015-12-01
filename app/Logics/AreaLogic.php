<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Logics;
use Illuminate\Support\Facades\DB;

class AreaLogic extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'area';

    public function getAreaList() {
        return self::where('is_active', '=', '1')->get()->toArray();
    }

    public function buildAllAreaToTree($allRuleList = [], $pid = 0, $level = 0) {
        $newList = [];
        foreach ($allRuleList as $k => $v) {
            if ($v['parent_id'] == $pid) {
                unset($allRuleList['$k']);
                $v['level'] = $level;
                $v['sub'] = $this->buildAllAreaToTree($allRuleList, $v['code'], $level + 1);
                $newList[] = $v;
            }
        }
        return $newList;
    }

    public function showTreeArea($treeRuleList) {
        $newList = [];
        foreach ($treeRuleList as $k => $v) {
            $sub = $v['sub'];
            unset($v['sub']);
            $v['nodeName'] = !empty($v['nodeName']) ? $v['nodeName'] :
                    $this->getPrefixFromLevel($v['level'], (count($treeRuleList) - 1) == $k) . $v['name'];
            $newList[] = $v;
            if (!empty($sub)) {
                $tmpNewList = $this->showTreeArea($sub);
                foreach ($tmpNewList as $tmpk => $tmpv) {
                    $tmpv['nodeName'] = $tmpv['nodeName'] ? $tmpv['nodeName'] :
                            $this->getPrefixFromLevel($tmpv['level'], (count($tmpNewList) - 1) == $tmpk) . $tmpv['name'];
                    $newList[] = $tmpv;
                }
            }
        }
        return $newList;
    }

    public function getPrefixFromLevel($level, $end = false) {
        $num = $level * 9;
        $prefix ='';
        for ($i=0; $i < $num; $i++) {
            if ($i % 9 == 0) {
                $prefix .= '|';
            } else {
                $prefix .= '&nbsp;';
            }
        }
        return $prefix . ($end ? '└─' : '├─');
    }
    
    public function getLevelByCode($code = 0){
        $res = DB::table($this->table)->where('code','=',$code)->first();
        return !empty($res->level) ? $res->level : 0;
    }
    
    public function getAreaKeyValue(){
        $temp = [];
        $array = self::where('is_active', '=', '1')->select('code','name')->get()->toArray();
        foreach ($array as $value){
            $temp[$value['code']] = $value['name'];
        }
        return $temp;
    }

}
