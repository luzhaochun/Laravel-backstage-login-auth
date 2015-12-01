<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $table = 'admin';

    public $timestamps = false; // 此方法解决ORM的create_at update_at delete_at默认字段的更新

    /**
     * @param $data
     * @return array
     */
    public function getAdminList($data){
        if(!empty($data['idSort'])){
            $orderField = 'admin.id';
            $orderValue = $data['idSort'];
        }
        if(!empty($data['timeSort'])){
            $orderField = 'admin.update_time';
            $orderValue = $data['timeSort'];
        }
        if(empty($orderField)){
            $orderField = 'admin.update_time';
            $orderValue = 'DESC';
        }

        $list = DB::table('admin')
            ->join('auth_group', 'auth_group.id', '=', 'admin.role_id')
            ->select('admin.*','auth_group.name AS role_name')
            ->where('admin.is_active', '1')
            ->where(function ($query) use ($data) {
                // 搜索条件
                if(!empty($data['searchName']))
                    $query->where('admin.user_name', 'like', '%'.trim($data['searchName']).'%')
                    ->orWhere('auth_group.name', 'like', '%'.trim($data['searchName']).'%');
            })
            ->orderBy($orderField, $orderValue)
            ->take($data['pageSize'])
            ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
            ->get();

        // 总数，分页使用
        $count = DB::table('admin')
            ->join('auth_group', 'auth_group.id', '=', 'admin.role_id')
            ->select('admin.*','auth_group.name AS role_name')
            ->where('admin.is_active', '1')
            ->where(function ($query) use ($data) {
                // 搜索条件
                if(!empty($data['searchName']))
                    $query->where('admin.user_name', 'like', '%'.trim($data['searchName']).'%')
                        ->orWhere('auth_group.name', 'like', '%'.trim($data['searchName']).'%');
            })
            ->count();
        return [$list, $count];
    }

    /**
     * @return mixed
     */
    public function getAuthGroup(){
        $group = DB::table('auth_group')
            ->select('id', 'name')
            ->where('is_active', '1')
            ->orderBy('id')
            ->get();
        return $group;
    }

    /**
     * @param $user_name 名称
     * @param null $id 编辑情况下带id
     * @return mixed
     */
    public function checkUserName($user_name, $id = null){
        return DB::table('admin')
            ->where('user_name', $user_name)
            ->Where('is_active', '1')
            ->where(function($query) use($id){
                if(!empty($id))
                    $query->where('id', '<>', $id);
            })
            ->get();
    }

    /**
     * @param $data 新增管理员信息
     */
    public function addAdmin($data){
        $admin = new self();
        $admin->user_name = trim($data['user_name']);
        $admin->password = MD5(trim($data['password']));
        $admin->role_id = $data['role_id'];
        $admin->is_active = '1';
        $admin->update_time = date('Y-m-d H:i:s');
        $admin->save();
    }

    /**
     * @param $data 更改数据
     * @return bool 保存是否成功
     */
    public function saveAdmin($data){
        if(empty($data['editId']))
            return false;
        $admin = new self();
        $admin->where('id', $data['editId'])
            ->update(['user_name'=>trim($data['user_name']), 'password'=>MD5(trim($data['password'])), 'role_id'=>$data['role_id'], 'is_active'=>'1', 'update_time'=>date('Y-m-d H:i:s')]);
        return true;
    }

    /**
     * @param $id 删除管理员id
     * @return bool 删除是否成功
     */
    public function deleteAdmin($id){
        if(empty($id))
            return false;
        $admin = new self();
        $admin->where('id', $id)
            ->update(['is_active'=>'0']);
        return true;
    }

    /**
     * @param $id 管理员id
     * @return mixed
     */
    public function getAdmin($id){
        return DB::table('admin')->find($id);
    }
}