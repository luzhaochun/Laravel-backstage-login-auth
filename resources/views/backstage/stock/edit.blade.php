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
        <script type="text/javascript" src="/js/backstage/stock/admin/edit.js"></script>
    </head>
    <body>
        <div class="place">
            <span>位置：</span>
            <ul class="placeul">
                <li><a href="/index">首页</a></li>
                <li><a href="/StockManage/index">库存管理</a></li>
                <li>编辑人员</li>
            </ul>
        </div>
        @if (session('status'))

                <div class="error_tips">
                    <div class="error_message">
                        {{ session('status') }}
                    </div>
                </div>

        @endif
        <form id="editAdminForm" class="formbody" action="{{url('/StockManage/editAdmin')}}" method="post">
            <div class="formtitle"><span>编辑人员</span></div>
            <ul class="forminfo uew-select">
                <li>
                    <span>用户名称</span>
                    <input id="user_name" name="name" class="dfinput" value="<?php echo $adminInfo->name; ?>" />
                    <label id="name-error" class="error" for="user_name"></label>
                </li>
                <li>
                    <span>登陆名</span>
                    <input id="login" name="login" class="dfinput" value="<?php echo $adminInfo->login; ?>" />
                    <label id="login-error" class="error" for="login"></label>
                </li>
                <li>
                    <span>密码</span>
                    <input id="password" name="pwd" type="password" class="dfinput" value="" />
                    <label id="pwd-error" class="error" for="pwd"></label>
                </li>
                <li>
                    <span>确认密码</span>
                    <input name="confirmpwd" type="password" class="dfinput" value="" />
                    <label id="confirmpwd-error" class="error" for="confirmpwd"></label>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $id; ?>" />
                    <input type="submit" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{url('/StockManage/index')}}"><input type="button" class="cancel" value="返回"/></a>
                    <label class="submit-msg"></label>
                </li>
            </ul>
        </form>
    </body>
</html>



