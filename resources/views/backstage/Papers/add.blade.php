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
    <script type="text/javascript" src="{{ URL::asset('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/paper/index.js')}}"></script>
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

<form id="addAdminForm" class="formbody" action="{{url('/PaperRoll/add')}}" method="post" enctype="multipart/form-data">
    <div class="formtitle"><span>新增题卷</span></div>
    <ul class="forminfo uew-select">
        <li>
            <span>选择企业</span>
            <input id="company_name" type="text" name="company_name" disabled readOnly="true" class="dfinput"  value=""/>
            <input id="company_id" name="company_id" type="hidden"  value=""/>
            <input type="button" class="chooses searchCompany"  value="选择"  data-id="0">
            <label id="company_id-error" class="error" for="company_id"></label>
        </li>
        <li>
            <span>题卷名称</span>
            <input id="paper_name" name="paper_name" class="dfinput" value=""/>
            <label id="paper_name-error" class="error" for="paper_name"></label>
        </li>
        <li>
            <span>图片</span>
           <span>
               {{--<a id="pickfiles">sdfaf</a>--}}
               <input type="file" name="fileImg"  />
           </span>
        </li>
        <li>
            <span>题库来源方式</span>
            <div class="brief">
                <span><input type="checkbox" name="getway[]" value="1">本题卷选择企业题库</span>
                <span><input type="checkbox" name="getway[]" value="2">其他企业题库</span>
                <span><input type="checkbox" name="getway[]" value="3">公共题库</span>
                <span><label id="getway[]-error" class="error" for="getway[]"></label></span>
            </div>
        </li>
        <li>
            <span>是否随机</span>
           <div class="brief">
                <span><input type='radio' name="is_random"  value="1" checked/>随机</span>
                <span><input type='radio' name="is_random"  value="0"/>固定</span>
                <label id="is_random-error" class="error" for="is_random"></label>
           </div>
        </li>
        <li class="choose_number">
            <span>题库数量</span>
            <div class="brief">
                <input id="number" name="number" class="dfinput" value="0"/>
            </div>
        </li>
        <li>
            <label>&nbsp;</label><input type="submit" class="chooses" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{url('/Admin/index')}}"><input type="button" class="cancel" value="返回"/></a>
            <label class="submit-msg"></label>
        </li>
    </ul>
</form>
</div>
</body>
</html>