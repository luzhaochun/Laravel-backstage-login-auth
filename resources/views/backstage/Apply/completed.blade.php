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
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/apply/apply_form.js')}}"></script>
</head>
<body>

<form id="addSerialNumber" class="formbody" action="{{url('/Apply/completed')}}" method="post">
    <ul class="forminfo uew-select">
        <li>
            <span>帐户类型</span>
            <div class="show_text">{{$info->account_type_name}}</div>
        </li>
        <li>
            <span>帐户名</span>
            <div class="show_text">{{$info->account_name}}</div>
        </li>
        <li>
            <span>帐户号</span>
            <div class="show_text">{{$info->account_number}}</div>
        </li>
        <li>
            <span>开户网点</span>
            <div class="show_text">{{$info->other_info}}</div>
        </li>
        <li>
            <span>汇款金额</span>
            <div class="show_text">&yen;{{$info->money}}</div>
        </li>
        <li>
            <span>汇款流水号</span>
            <input id="serial_number" name="serial_number" type="text" class="dfinput" value=""/>
            <label id="serial_number-error" class="error" for="serial_number"></label>
        </li>
        <li style="padding-left: 82px;">
            <input name="id" type="hidden" value="{{$info->id}}" />
            <label>&nbsp;</label><input type="submit" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="submit-msg"></label>
        </li>
    </ul>
</form>
</body>
</html>
