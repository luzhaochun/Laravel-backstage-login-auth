<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/css/select.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/paper/index.js')}}"></script>
    <script>
        QiniuType = 9;//空间类型
        QiniuId = <?php echo $paperInfor->id;?>; //要生成的文件名称  id
        QiniuBucket ='<?php echo $imagesUrl;?>'; //七牛云HTTPS空间路径
    </script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/PaperRoll/index">题卷管理</a></li>
        <li>新增题卷</li>
    </ul>
</div>
@if (session('status'))

        <div class="error_tips">
            <div class="error_message">
                {{ session('status') }}
            </div>
        </div>

@endif

<form id="addAdminForm" class="formbody" action="{{url('/PaperRoll/edit')}}" method="post" >
    <div class="formtitle"><span>编辑题卷</span></div>
    <ul class="forminfo uew-select">
        <li>
            <span>选择企业</span>
            <input id="company_name" type="text" name="company_name" disabled readOnly="true" class="dfinput"  value="<?php echo empty($companyInfor->name) ? '': $companyInfor->name;?>"/>
            <input id="company_id" name="company_id" type="hidden"  value="<?php echo empty($companyInfor->id) ? '' : $companyInfor->id;?>"/>
            <input type="button" class="chooses searchCompany"  value="选择"  data-id="<?php echo $companyInfor->id;?>">
            <label id="company_id-error" class="error" for="company_id"></label>
        </li>
        <li>
            <span>题卷名称</span>
            <input id="paper_name" name="paper_name" class="dfinput" value="<?php echo $paperInfor->paper_name;?>"/>
            <label id="paper_name-error" class="error" for="paper_name"></label>
        </li>
        <?php if($paperInfor->paper_image){?>
        <li id="loadImages">
            <span>&nbsp;&nbsp;</span>
           <span>
               {{--<a id="pickfiles">sdfaf</a>--}}
               <div >
                    <img src = "<?php echo $imagesUrl.$paperInfor->paper_image;?>" style="width:100px;height: 100px;"><div id="uploadMessage"></div>
               </div>

           </span>
        </li>
        <?php }?>
        <li>
            <span>图片</span>
           <span>
               <div id="container">
                   <input type="file" id ="pickfiles" name="file"  />
               </div>

           </span>
        </li>
        <li>
            <span>题库来源方式</span>
            <div class="brief">
                <span><input type="checkbox" name="getway[]" <?php if(in_array(1,$PaperWay)){echo 'checked';}?> value="1">本题卷选择企业题库</span>
                <span><input type="checkbox" name="getway[]" <?php if(in_array(2,$PaperWay)){echo 'checked';}?> value="2">其他企业题库</span>
                <span><input type="checkbox" name="getway[]" <?php if(in_array(3,$PaperWay)){echo 'checked';}?> value="3">公共题库</span>
                <span><label id="getway[]-error" class="error" for="getway[]"></label></span>
            </div>
        </li>
        <li>
            <span>是否随机</span>
           <div class="brief">
                <span><input type='radio' name="is_random"  value="1" <?php if($paperInfor->is_random == '1'){echo 'checked';}?>/>随机</span>
                <span><input type='radio' name="is_random"  value="0" <?php if($paperInfor->is_random == '0'){echo 'checked';}?>/>固定</span>
                <label id="is_random-error" class="error" for="is_random"></label>
           </div>
        </li>
        <li class="choose_number">
            <span>题库数量</span>
            <div class="brief">
                <input id="number" name="number" class="dfinput" value="<?php echo $paperInfor->number;?>"/>
            </div>
        </li>
        <li>
            <input type="hidden" id="fileUplodeImg" name="fileImg" value="<?php echo $paperInfor->paper_image;?>">
            <input type="hidden" name="id" value="<?php echo $paperInfor->id;?>">
            <label>&nbsp;</label><input type="submit" class="chooses" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a  sharf="{{url('/PaperRoll/index')}}"  onclick ="confirmAct();"><input type="button" class="cancel"  value="返回"/></a>
            <label class="submit-msg"></label>
        </li>
    </ul>
</form>
<div id="addAdminDialog" class="tip">
    <form class="formdialog" id="addForm" action="{{url('/Admin/add')}}" method="post">
        <ul class="admindialoginfo">
            <li>
                <span>企业名称</span>
                <div class="popup-input-label">
                    <input id="companyNameSearch" name="companyNameSearch" class="short dialog-error-input"/>
                    <input type="button"  class="searchCompany" value="搜索">
                </div>
            </li>
            <li>
                <ul id="choose_radios" style="border: solid 2px #ddd;padding:10px;">
                    <li style="border-bottom: #999 dotted 1px;height: 34px;"><span style="padding-top: 10px"><input class="choose_radio" type="radio" name="drugstoreId" value="0"></span><span>益点点大药房</span></li>
                    <li style="border-bottom: #999 dotted 1px;height: 34px;"><span style="padding-top: 10px"><input  type="radio" name="drugstoreId" value="1"></span><span>益点点大药房</span></li>
                    <li style="border-bottom: #999 dotted 1px;height: 34px;"><span style="padding-top: 10px"><input  type="radio" name="drugstoreId" value="2"></span><span>益点点大药房</span></li>
                    <li style="border-bottom: #999 dotted 1px;height: 34px;"><span style="padding-top: 10px"><input  type="radio" name="drugstoreId" value="3"></span><span>益点点大药房</span></li>
                    <li style="border-bottom: #999 dotted 1px;height: 34px;"><span style="padding-top: 10px"><input  type="radio" name="drugstoreId" value="4"></span><span>益点点大药房</span></li>
                    <li style="border-bottom: #999 dotted 1px;height: 34px;"><span style="padding-top: 10px"><input  type="radio" name="drugstoreId" value="5"></span><span>益点点大药房</span></li>
                </ul>
                <ul>
                    <li style="padding-left:10px;"><span>上一页</span><span>1</span><span>2</span><span>3</span><span>下一页</span></li>
                </ul>
            </li>
        </ul>
    </form>
</div>
<script type="text/javascript" src="{{ URL::asset('/js/main.js')}}"></script>
</div>
</body>
</html>