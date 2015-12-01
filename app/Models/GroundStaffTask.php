<?php

    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    
    class GroundStaffTask extends Model
    {
        protected  $table="ground_staff_task";
        
        public $timestamps=false;
        
        /*  
         * 
         */
        public function showTaskList($data){
            if(!empty($data['idSort'])){
                $orderField = 'id';
                $orderValue = $data['idSort'];
            }else{
                $orderField = 'id';
                $orderValue = 'desc';
            }
            $list=DB::table('ground_staff_task')
                    ->join('ground_staff', 'ground_staff.id', '=', 'ground_staff_task.ground_staff_id')
                    ->join('collect_clerk','collect_clerk.id','=','ground_staff_task.collect_clerk_id')
                    ->select('ground_staff_task.id','ground_staff_task.task_time','ground_staff_task.content','ground_staff_task.is_complete','ground_staff_task.update_time','collect_clerk.name AS clerk_name','ground_staff.name AS staff_name')
                    ->where(function ($query) use ($data) {
                // 搜索条件
                        if(!empty($data['searchName']))
                            $query->where('collect_clerk.name', 'like', '%'.trim($data['searchName']).'%')
                                  ->orWhere('ground_staff.name', 'like', '%'.trim($data['searchName']).'%');   
                     })
                    ->orderBy($orderField, $orderValue)
                    ->take($data['pageSize'])
                    ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
                    ->get();

                $count=DB::table('ground_staff_task')
                    ->join('ground_staff', 'ground_staff.id', '=', 'ground_staff_task.ground_staff_id')
                    ->join('collect_clerk','collect_clerk.id','=','ground_staff_task.collect_clerk_id')
                    ->where(function ($query) use ($data) {
                // 搜索条件
                    if(!empty($data['searchName']))
                        $query->where('collect_clerk.name', 'like', '%'.trim($data['searchName']).'%')
                                  ->orWhere('ground_staff.name', 'like', '%'.trim($data['searchName']).'%');                                
                    })                                           
                    ->count();           
        
            return [$list, $count];
        }                                
        
    }


