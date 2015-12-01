<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'event_products';

    public $timestamps = false; // 此方法解决ORM的create_at update_at delete_at默认字段的更新

    /**
     * 产品列表
     * @param $data
     * @return array
     */
    public function getProductList($data){
        $orderField = !empty($data['sortName']) ? $data['sortName'] : 'update_time';  // 排序字段
        $orderValue = !empty($data['sortType']) ? $data['sortType'] : 'DESC';  // 排序

        $list = DB::table('event_products')
            ->select('*')
            ->where('is_active', '1')
            ->where(function ($query) use ($data) {
                // 搜索条件
                if(!empty($data['searchName']))
                    $query->where('product_name', 'like', '%'.trim($data['searchName']).'%');
            })
            ->orderBy($orderField, $orderValue)
            ->take($data['pageSize'])
            ->skip($data['pageNo'] > 1 ? ($data['pageNo'] - 1) * $data['pageSize'] : 0)
            ->get();

        $count = DB::table('event_products')
            ->select('*')
            ->where('is_active', '1')
            ->where(function ($query) use ($data) {
                // 搜索条件
                if(!empty($data['searchName']))
                    $query->where('product_name', 'like', '%'.trim($data['searchName']).'%');
            })
            ->count();
        return [$list, $count];
    }

    /**
     * 产品删除
     * @param $id
     * @return bool
     */
    public function productDel($id){
        if(empty($id))
            return false;
        $product = new self();
        $product->where('id', $id)
            ->update(['is_active'=>'0', 'update_time'=>date('Y-m-d H:i:s', time())]);
        return true;
    }

    /**
     * 获取产品推荐位置
     * @return mixed
     */
    public function getPositionList(){
        return DB::table('product_recommend_position')
            ->select('id', 'position_name')
            ->where('is_active', '1')
            ->orderBy('sort', 'DESC')
            ->get();
    }

    /**
     * 获取产品的所有产品功效数据
     * @return mixed
     */
    public function getProductFuncList(){
        //该产品关联的产品列表
        return DB::table('product_func_category')
            ->select('id', 'cat_name')
            ->where('is_active', '1')
            ->Where('is_display', '1')
            ->orderBy('id', 'ASC')
            ->get();
    }

    /**
     * 获取供应商
     * @return mixed
     */
    public function getProductSupplier(){
        return DB::table('product_supplier')
            ->select('id', 'supplier_name')
            ->where('is_active', '1')
            ->orderBy('sort', 'DESC')
            ->get();
    }

    /**
     * 获取产品编辑信息
     * @param $id
     * @return mixed
     */
    public function getProductDetails($id){
        $list = DB::table('event_products')
            ->join('event_product_details', 'event_product_details.product_id', '=', 'event_products.id')
            ->select('event_products.*', 'event_product_details.id AS eid', 'event_product_details.brief', 'event_product_details.photo_album', 'event_product_details.description', 'event_product_details.meta_title', 'event_product_details.meta_keywords', 'event_product_details.meta_description')
            ->where('event_products.id', $id)
            ->get();
        return array_shift($list);
    }

    /**
     * 检查产品名称唯一性
     * @param $productName
     * @param string $id
     * @return mixed
     */
    public function checkNameUnique($productName, $id=''){
        return DB::table('event_products')
            ->where('product_name', $productName)
            ->Where('is_active', '1')
            ->where(function($query) use($id){
                if(!empty($id))
                    $query->where('id', '<>', $id);
            })
            ->get();
    }
}