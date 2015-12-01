<?php
/**
 * 题卷管理
 * User: linwenshan
 * Date: 15/11/16
 * Time: 上午10:28
 */

namespace App\Http\Controllers\Backstage\Question;

use App\Libraries\YddPaginator;
use App\Models\Paper;
use App\Models\QuestionBank;
use App\Models\RPaperQuestionBank;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Services\Qiniu;
use Illuminate\Support\Facades\Redirect;
use App\Services\Util;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Backstage\Controller;
use Illuminate\Support\Facades\Input;
class PaperController extends Controller{
    //题卷管理列表
    public function index(){
        $data = Input::get();
        $data['pageNo'] = isset($data['pageNo']) ? $data['pageNo'] : 1;
        $data['pageSize'] = isset($data['pageSize']) ? $data['pageSize'] : 10;
        $this->data['title'] = '题卷管理';
        $model = new Paper();

        list($result, $count) = $model->getPaperListData($data);

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

        return view('backstage.papers.index',$this->data);
    }

    //新增题卷
    public function add(Request $request){
        if($request->isMethod('post')){
            $this->validate($request,
                [
                    'company_id' => 'required|int',
                    'paper_name' => 'required',
                    'getway' => 'required'
                ]);
            $data = array(
                'company_id' => $request->input('company_id'),
                'paper_name' => $request->input('paper_name'),
                'number' => $request->input('number') ? $request->input('number') : 0,
                'is_active' => '1',
                'update_time' => date('Y-m-d H:i:s'),
                'answer_number' => 0,
                'avg_value' => 0,
                'is_random'=>$request->input('is_random') ? $request->input('is_random') : '0',
                'getway' => trim(implode(',',$request->input('getway')),',')
            );
            $PaperModel = new Paper();
            $paperResultId = $PaperModel->addPaperData($data);
            if($paperResultId){
                    if($request->hasFile('fileImg')) {
                        $file = $request->file('fileImg');
                        $clientName = $file->getClientOriginalName();
                        $entension = $file->getClientOriginalExtension(); //上传文件的后缀.
                        $newName = md5(date('ymdhis') . $clientName) . "." . $entension;
                        $path = $file -> move(public_path().'/Upload/images',$newName);
                        //判断文件是否存在
                        if(file_exists($path)){
                            //七牛云改名
                            $bucketType = 9;
                            $filename = Util::getUtilData()->create_qiniu_unqiue_name($bucketType,$paperResultId,$path);
                            if($filename != false){
                                $space = Config::get('config.bucket_key')[$bucketType];;
                                //上传七牛云
                                $QiniuServices = new Qiniu($space,true);
                                $uplode_result = $QiniuServices->upload($filename,$path);
                                if($uplode_result === false){
                                    $file_message = '，但是图片上传失败';
                                }else{
                                    $paper = Paper::find($paperResultId);
                                    $paper->paper_image = $filename;
                                    $paper->bucket_space = $space;
                                    $paper->save();
                                }
                                @unlink($path);
                            }
                        }
                    }
                return redirect('/PaperRoll/index');
            }else{
                return redirect('PaperRoll/add')->with('status','保存失败，请重试');
            }
            exit;
        }
        return view('backstage.papers.add');
    }

    //编辑题卷管理
    public function edit(Request $request){
       // DB::connection()->enableQueryLog();

        $id = $request->input('id');
        $paperResult = Paper::where('id',$id)->first();
        if($request->isMethod('post')){
            $this->validate($request,
                [
                    'company_id' => 'required|int',
                    'paper_name' => 'required',
                    'getway' => 'required'
                ]);
            $data = array(
                'company_id' => $request->input('company_id'),
                'paper_name' => $request->input('paper_name'),
                'update_time' => date('Y-m-d H:i:s'),
                'is_random'=>$request->input('is_random') ? $request->input('is_random') : '0',
                'getway' => trim(implode(',',$request->input('getway')),',')
            );
            $PaperModel = new Paper();
            //判断是否为固定题目  固定则自动判断
            if($data['is_random'] == 0) {
                $data['number'] = $PaperModel->countNumbers($id);
            }else{
                $data['number'] = empty($request->input('number')) ? 0 : $request->input('number');
            }

            //判断是否有图片上传
            if($request->input('fileImg')){
                $data['paper_image'] = $request->input('fileImg');
            }
            $Result = DB::table('paper')->where(['id'=>$id])->update($data);
            if($Result){
                return redirect('/PaperRoll/index');
            }else{
                return redirect('PaperRoll/edit?id='.$id)->with('status','保存失败，请重试');
            }
            exit;
        }
        $bucketType = 9;
        $space = Config::get('config.bucket_key')[$bucketType];;
        //七牛云
        $QiniuServices = new Qiniu($space);
        $companyModel = new \App\Models\Company();
        $companyInfor = $companyModel->getCompanyData($paperResult->company_id);
        $this->data['paperInfor'] = $paperResult;
        $this->data['imagesUrl'] = $QiniuServices->getDomain();
        $this->data['companyInfor'] = $companyInfor;
        $this->data['PaperWay'] = explode(',',$paperResult->getway);
        return view('backstage.papers.edit',$this->data);
    }

    //删除题卷
    public function del(Request $request){
        $id = $request->input('id');
        $result = DB::table('paper')->where(['id'=>$id])->update(['is_active'=>'0','update_time'=>date('Y-m-d H:i:s')]);
        if($result != false){
            echo json_encode(['status'=>true, 'msg'=>'删除成功！']);
        }else{
            echo json_encode(['status'=>false, 'msg'=>'删除失败！']);
        }
    }

    //选择题库
    public function check_paper(Request $request){
        $this->validate($request,
            [
                'id' => 'required|int'
            ]);
        $questionBank = new QuestionBank();
        $id = $request->input('id');//题卷ID
        if($request->ajax()){
            $data = Input::get();
            $checkids = $request->input('checkids') ? $request->input('checkids') : '0';
            $data['id'] = $id;
            $data['pageNo'] = isset($data['pageNo']) ? $data['pageNo'] : 1;
            $data['pageSize'] = isset($data['pageSize']) ? $data['pageSize'] : 1;
            list($result, $count) = $questionBank->getListData($data['pageNo'], $data['pageSize']);
            $paperModel = new RPaperQuestionBank();
            $paperlist = $paperModel->getPaperInfor($id);
            $newarr = array_merge($paperlist,explode(',',$checkids));
            if($result){
                $str = '';
                foreach($result as $vo){
                    $checkState = in_array($vo->id,$newarr) ? 'checked' :'';
                    $str .= '<tr><td>';
                    $str .="<input type='checkbox' name='addMids[]' value=".$vo->id." onclick='checkName($(this))' ".$checkState." />";
                    $str .='<input type="hidden" name="paperId" id="paperId" value="'.$id.'">';
                    $str .="<td style='width: 8%;'><span style='display: inline;'>".$vo->id."</span></td>";
                    $str .="<td>".$vo->problem."</td>";
                    $str .='</tr>';
                }
                $str .= "<script>$('.tablelist tbody tr:odd').addClass('odd');</script>";
                $str .='<input type="hidden" name="sub_ids" id="sub_ids" value="'.$checkids.'">';
            }
            //分页
            $page = new Paginator($result, $data['pageSize'],$data['pageNo']);
            // 实例化分页
            $paginator = new YddPaginator($count, $data['pageSize'], $data['pageNo'] , $data);
            foreach ($data as $key => $val) {
                // 参数获取进行分页处理
                $paginator->pageData[$key] = urlencode($val);
            }

            echo json_encode(['str'=>$str,'_page'=>$paginator->show_ajax()]);
        }else {
                $data['id'] = $id;
                $data['pageNo'] = isset($data['pageNo']) ? $data['pageNo'] : 1;
                $data['pageSize'] = isset($data['pageSize']) ? $data['pageSize'] : 15;
                list($result, $count) = $questionBank->getListData($data['pageNo'], $data['pageSize']);
                //        print_r($result);
                $page = new Paginator($result, $data['pageSize'], $data['pageNo']);
                $this->data['list'] = $page->items();
                // 实例化分页
                $paginator = new YddPaginator($count, $data['pageSize'], $data['pageNo'], $data);
                foreach ($data as $key => $val) {
                    // 参数获取进行分页处理
                    $paginator->pageData[$key] = urlencode($val);
                }
                $paperModel = new RPaperQuestionBank();
                $paperlist = $paperModel->getPaperInfor($id);
                $this->data['paginator'] = $paginator;
                $this->data['paperlist'] = $paperlist;
                $this->data['paperId'] = $id;
                return view('backstage.papers.check_paper', $this->data);
        }
    }


    //保存提交的固定题目选择
    public function saveData(Request $request){
        if ($request->isMethod('post')) {
            //var_dump($request->input());
            if(empty($request->input('sub_ids'))){
                echo json_encode(['status'=>false,'msg'=>'题库必填']);exit;
            }
            $id = $request->input('id');
            $addMids = array_unique(explode(',',$request->input('sub_ids')));
            $papeRModel = new RPaperQuestionBank();
            $result = $papeRModel->updatepaperinfo($id,$addMids);
            echo json_encode(['status'=>$result['status'],'message'=>$result['message']]);
        }
    }

    //选择企业
    public function searchCompany(Request $request){
        $companyModel = new \App\Models\Company();
        $id = $request->input('id');
        if($request->ajax()){
            $name = $request->input('searName');
            if(!empty($name)){
                $list = $companyModel->getSearchData($name);
            }else{
                $list = $companyModel->getCompanyList();
            }
            $str = '';
            if($list){
                foreach($list as $value){
                    $str .= '<tr><td style=="text-align:center;padding-left: 5px;">';
                    $str .="<input type='radio' name='companyId' value='".$value->id."'>";
                    $str .='</td><td style="width: 8%;"> <span style="display: inline;">'.$value->id.'</span>';
                    $str .='</td><td>'.$value->name.'</td></tr>';
                }
            }
            if($str === ''){
                $str .= '<tr><td colspan="3">暂无查询数据！</td></tr>';
            }
            echo json_encode(['str'=>$str]);
        }else{
            $this->data['id'] = $id ? $id : 0;
            $list = $companyModel->getCompanyList();
            $this->data['list'] = $list;
            return view('backstage.papers.searchCompany', $this->data);
        }
    }
}