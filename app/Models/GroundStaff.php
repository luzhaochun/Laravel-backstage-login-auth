<?php

    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    
    class GroundStaff extends Model
    {
        protected  $table="ground_staff";
        
        public $timestamps=false;
        
        /*  
         * 
         */
        public function showUserList($data){
            if(!empty($data['idSort'])){
                $orderField = 'id';
                $orderValue = $data['idSort'];
            }else{
                $orderField = 'id';
                $orderValue = 'desc';
            }
            $list=DB::table('ground_staff')
                    ->select('id','name','phone','is_active','update_time','login_id')
                    ->where('id','>' ,0)
                    ->where(function ($query) use ($data) {
                // 搜索条件
                        if(!empty($data['searchName']))
                            $query->where('name', 'like', '%'.trim($data['searchName']).'%')
                                  ->orWhere('login_id', 'like', '%'.trim($data['searchName']).'%')
                                  ->orWhere('phone', 'like', '%'.trim($data['searchName']).'%');  
                     })
                    ->orderBy($orderField, $orderValue)
                    ->take($data['pageSize'])
                    ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
                    ->get();

                $count=DB::table('ground_staff')
                    ->where('id','>' ,0)
                    ->where(function ($query) use ($data) {
                // 搜索条件
                    if(!empty($data['searchName']))
                        $query->where('name', 'like', '%'.trim($data['searchName']).'%')
                              ->orWhere('login_id', 'like', '%'.trim($data['searchName']).'%')
                              ->orWhere('phone', 'like', '%'.trim($data['searchName']).'%');  
                    })                                           
                    ->count();           
        
            return [$list, $count];
        }
                    
        
        public function userAdd($data){
            $staff=new self();
            $staff->name=trim($data['name']);
            $staff->phone=trim($data['phone']);
            $staff->sexuality= $data['sexuality'];
            $staff->login_id= trim($data['login_id']);
            $staff->login_pwd= md5(trim($data['login_pwd']));
            $staff->birthday= $data['birthday'];
            $staff->is_active=$data['is_active'];
            $staff->update_time = date('Y-m-d H:i:s');
            $staff->save();
        }
        
        public function userDel($id){
        $admin = new self();
        $admin->where('id', $id)
            ->update(['is_active'=>'0']);
        return true;
        }
        
        
    }


