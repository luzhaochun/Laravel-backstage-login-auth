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
    <script type="text/javascript" src="/js/layer/layer.js"></script>
    <script type="text/javascript" src="/js/backstage/stock/shelf/shelfadd.js"></script>
    
</head>
<body>


<form id="shelfAddForm" class="formbody" action="{{url('/StockManage/shelfAdd')}}" method="post">
<!--    <div class="formtitle"><span>新增报损</span></div>-->
    <ul class="forminfo uew-select">
        <li>
            <span>货位编码</span>
            <input id="no" name="no" class="dfinput" value="" />
            <label id="no-error" class="error" for="no"></label>
        </li>
        <li>
            <span>是否显示</span>
            <input type="radio" id="state" name="state"  value="1" checked="checked">显示</input>
            <input type="radio" id="state" name="state"  value="0">隐藏</input>
        </li>
        <li>
            <label>&nbsp;</label><input type="submit" class="sure" value="保存" style="margin-left: 83px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--            <a href="{{url('/StockManage/damageIndex')}}"><input type="button" class="cancel" value="返回"/></a>-->
            <label class="submit-msg"></label>
        </li>
    </ul>
</form>
</body>
</html>





