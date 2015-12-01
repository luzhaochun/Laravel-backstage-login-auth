<?php
/**
 * 题库列表
 * User: linwenshan
 * Date: 15/11/27
 * Time: 下午3:06
 */
namespace App\Http\Controllers\Backstage\Question;
use App\Libraries\YddPaginator;
use App\Models\QuestionBank;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Backstage\Controller;
use Illuminate\Support\Facades\Input;
class QuestionController extends Controller{

    //题库列表
    public function index(){
        $data = Input::get();
        $data['pageNo'] = isset($data['pageNo']) ? $data['pageNo'] : 1;
        $data['pageSize'] = isset($data['pageSize']) ? $data['pageSize'] : 10;
        $this->data['title'] = '题库管理';
        $model = new QuestionBank();

        list($result, $count) = $model->getQuestionList($data);

        $page = new Paginator($result, $data['pageSize'], $data['pageNo']);
        $this->data['items'] = $page->items();
        // 实例化分页
        $paginator = new YddPaginator($count, $data['pageSize'], $data['pageNo'], $data);
        foreach ($data as $key => $val) {
            // 参数获取进行分页处理
            $paginator->pageData[$key] = urlencode($val);
        }

        $this->data['paginator'] = $paginator;
        $this->data['search'] = $data;

        return view('backstage.Questions.index',$this->data);
    }

    //题库添加
    public function add(Request $request){

        return view('backstage.Questions.add');
    }

    //题库编辑
    public function edit(Request $request){

        return view('backstage.Questions.edit',$this->data);
    }

    //题库删除
    public function del(Request $request){

    }

    //恢复题库
    public function recovery(Request $request){

    }

    //获取文章列表
    public function getMaterialList(){
        return view('backstage.Questions.list',$this->data);
    }






}