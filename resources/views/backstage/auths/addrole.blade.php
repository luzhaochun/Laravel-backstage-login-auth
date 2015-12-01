<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>无标题文档</title>
        <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/auth/addrole.js')}}"></script>
    </head>
    <body>
        <div class="place">
            <span>位置：</span>
            <ul class="placeul">
                <li><a href="{{url('/index/index')}}">首页</a></li>
                <li><a href="#">系统管理</a></li>
                <li><a href="{{url('/AuthGroup/index')}}">角色列表</a></li>
                <li>新增角色</li>
            </ul>
        </div>
        <div class="formtitle"><span>新增管理员</span></div>
        <div style="margin-top: 30px;margin-left: 30px;">
            <form id="frm_add_role" class="formbody" action="{{url('/AuthGroup/add')}}" method="post">
                <ul class="forminfo uew-select">
                    <li>
                        <span>角色名称</span>
                        <input id="name" name="name" class="dfinput" value=""/>
                        <label id="name-error" class="error" for="name"></label>
                    </li>
                    <li style="padding-left: 82px;">
                        <label>&nbsp;</label><input type="submit" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
                        <a href="javascript:history.go(-1);"><input type="button" class="cancel" value="返回"/></a>
                        <label class="submit-msg"></label>
                    </li>
                </ul>
            </form>
        </div>
    </body>
</html>