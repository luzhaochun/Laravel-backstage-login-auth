<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Logics;
use Illuminate\Support\Facades\DB;
class MenuLogic extends \Illuminate\Database\Eloquent\Model{
    protected $table = 'menu';
    
    /**
     * 数据库pid 转化为树状结构
     * @param unknown $allRuleList
     * @param number $pid
     * @param number $level
     * @return list
     */
    public function buildAllRuleToTree($allRuleList, $pid = 0, $level = 0) {
        $newList = [];
        foreach ($allRuleList as $v) {
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level;
                $newList[] = $v;
            }
        }    
        foreach ($newList as $k => $v) {
            $newList[$k]['hasChild'] = count($this->buildAllRuleToTree($allRuleList, $v['id'], $level + 1));
            $newList[$k]['sub'] = $this->buildAllRuleToTree($allRuleList, $v['id'], $level + 1);
        }
        return $newList;
    }

    /**
     * 树状结构转化为列表结构
     * @param unknown $treeRuleList
     * @return multitype:unknown
     */
    public function showTreeRule($treeRuleList) {
        $newList = array();
        foreach ($treeRuleList as $k => $v) {
            $sub = $v['sub'];
            unset($v['sub']);
            $v['nodeName'] = !empty($v['nodeName']) ? $v['nodeName'] :
                    $this->getPrefixFromLevel($v['level'], (count($treeRuleList) - 1) == $k) . $v['name'];
            $newList[] = $v;
            if (!empty($sub)) {
                $tmpNewList = $this->showTreeRule($sub);
                foreach ($tmpNewList as $tmpk => $tmpv) {
                    $tmpv['nodeName'] = $tmpv['nodeName'] ? $tmpv['nodeName'] :
                            $this->getPrefixFromLevel($tmpv['level'], (count($tmpNewList) - 1) == $tmpk) . $tmpv['name'];
                    $newList[] = $tmpv;
                }
            }
        }
        return $newList;
    }

    /**
     * 通过层级获取前缀
     */
    public function getPrefixFromLevel($level, $end = false) {
        $prefix = "";
        $num = $level * 6;
        for ($i = 0; $i < $num; $i++) {
            if ($i % 6 == 0) {
                $prefix .= '│';
            } else {
                $prefix .= '&nbsp;';
            }
        }
        return $prefix . ($end ? '└─' : '├─');
    }

    /*
     * get submenu list
     */

    public function getSubMenus($id = 0, $uid = 0) {
        $res =self::where('parent_id','=',$id)
                ->where('sort','>','0')
                ->where('is_active','=','1')
                ->orderBy('sort', 'asc')
                ->get();
        $subMenus = $res->toArray();
        foreach ($subMenus as $k => $v) {
            if (!$this->checkRule(strtolower($v['module']), $uid)) {
                unset($subMenus[$k]);
            }
        }
        
        if (!empty($subMenus)) {
            foreach ($subMenus as $key => $value) {
                $subMenus[$key]['sub'] = $this->getNextSubNode($value['id'], $uid);
            }
        }
        return [$subMenus, []][is_null($subMenus)];
    }

    /*
     * directly get new grade node info,don't recurrent
     */

    public function getNextSubNode($pid, $uid) {
        $res =self::where('parent_id','=',$pid)->where('sort','>','0')->where('is_active','=','1')->orderBy('sort', 'asc')->get();
        $subMenus = $res->toArray();
        foreach ($subMenus as $k => $v) {
            if (!$this->checkRule(strtolower($v['module']), $uid)) {
                unset($subMenus[$k]);
            }
        }
        return [$subMenus, []][is_null($subMenus)];
    }

    public function checkRule($rule, $uid, $type = 1, $mode = 'url') {
        static $Auth = null;
        if (!$Auth) {
            $Auth = new \App\Services\Auth();
        }
        if (!$Auth->check($rule, $uid, $type, $mode)) {
            return false;
        }
        return true;
    }

    public function getParentNode($url) {
        if (empty($url))
            return null;
        $temp = $this->field('id')->where(['is_active' => '1', 'parent_id' => 0])->select();
        if (empty($temp))
            return null;
        $str = [];
        foreach ($temp as $key => $value) {
            $str[] = $value['id'];
        }
        $map['is_active'] = ['eq', '1'];
        $map['_string'] = " LOWER(module) = '" . strtolower($url) . "'";
        $result = $this->field('parent_id')->where($map)->find();
        if (in_array($result['parent_id'], $str))
            return null;
        if (!empty($result) && $result['parent_id'] != 0) {
            $result = $this->field('module')->where(['id' => $result['parent_id']])->find();
            if (!empty($result)) {
                return $result['module'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function searchParents($allRuleList, $id) {
        foreach ($allRuleList as $node) {
            if ($node['id'] == $id) {
                if ($node['parent_id'] != '0') {
                    $pid = $node['parent_id'];
                    $searchPid = $this->searchParents($allRuleList, $node['parent_id']);
                    $pid = ($searchPid ? $searchPid . ',' : '') . $pid;
                    return $pid;
                } else {
                    return '';
                }
            }
        }
    }
    
    public function checkMenuExist($url){
        if(empty($url)) return false;
        if(!empty(DB::select(" select * from y_menu where lower(module) = '".  strtolower($url)."'"))) return true;
        return false;
    }
    
    public function getAllList(){
        return self::where('sort','>','0')->where('is_active','=','1')->orderBy('sort', 'asc')->get()->toArray();
    }
    
    public function getMenuById($id){
        return self::where('id','=',  intval($id))->first()->toArray();
    }
    
    public function getLoadUrl($login_id){
        $menu= $this->getSubMenus(0,$login_id);
        $i = 0;$temp = [];$load_url = "";
        foreach($menu as $key =>$value){
            $temp[$i] = $value;
            $i++;
        }
        if(isset($temp[0]['sub']) && sizeof($temp[0]['sub']) <= 0){
            $load_url = $temp[0]['module'];
        }else{
            $load_url = $temp[0]['sub'][0]['module'];
        }
        return $load_url;
    }
}
