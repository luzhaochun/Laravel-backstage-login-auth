<?php
/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 15/11/17
 * Time: 下午2:15
 */

namespace App\Http\Controllers\Backstage\Drugstore;

use App\Models\WithdrawCashApplication;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use App\Libraries\YddPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class MapController extends \App\Http\Controllers\Backstage\Controller {

    public function index(){
        $params = Input::get();
        $params['state'] = isset($params['state']) ? intval($params['state']) : '';

        $drugstore = new \App\Models\Drugstore();
        $list = $drugstore->getDrugstoreListByState($params['state']);

        $drugstore_state = ['1'=>'初恰','2'=>'有意向','3'=>'无意向','4'=>'深入洽谈','5'=>'已签约','6'=>'已铺货'];

        $data = array('list'=>json_encode($list),'params'=>$params,'drugstore_state'=>$drugstore_state);

        return view('backstage.Drugstore.Map.index',$data);

    }

}