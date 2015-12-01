<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>益点点后台管理系统 - {{$title}}</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/css/select.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/admin/admin.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script type="text/javascript" src="/js/backstage/stock/admin/edit.js"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/Admin/index">管理员管理</a></li>
        <li>编辑管理员</li>
    </ul>
</div>

<form id="saveAdminForm" class="formbody" action="{{url('/Admin/edit')}}" method="post">
    <div class="formtitle"><span>编辑管理员</span></div>
    <ul class="forminfo uew-select">
        <li>
            <span>管理员名称</span>
            <input id="user_name" name="user_name" class="dfinput" value="{{!empty($admin) ? $admin->user_name : ''}}"/>
            <label id="user_name-error" class="error" for="user_name"></label>
        </li>
        <li>
            <span>角色</span>
            <div class="vocation">
                <div class="uew-select">
                    <div class="uew-select-value ue-state-default" style="width: 320px;">
                        <em class="uew-select-text">{{!empty($groupList) ? $groupList[!empty($admin->role_id) ? $admin->role_id - 1 : 0]->name : ''}}</em>
                        <em class="uew-icon uew-icon-triangle-1-s"></em>
                    </div>
                    <select id="roleSelect" name="role_id" class="select1" style="width: 345px;">
                        @foreach($groupList as $item)
                        <option value="<?=$item->id?>" {{!empty($groupList[!empty($admin->role_id) ? $admin->role_id - 1 : 0]) && $groupList[!empty($admin->role_id) ? $admin->role_id - 1 : 0]->id == $item->id ? 'selected="selected"' : ''}}><?=$item->name?></option>
                        @endforeach
                    </select></div>
            </div>
        </li>
        <li>
            <span>密码</span>
            <input id="password" name="password" type="password" class="dfinput" value=""/>
            <label id="password-error" class="error" for="password"></label>
        </li>
        <li>
            <span>确认密码</span>
            <input name="confirmpwd" type="password" class="dfinput" value=""/>
            <label id="confirmpwd-error" class="error" for="confirmpwd"></label>
        </li>
        <li>
            <input type="button" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{url('/Admin/index')}}"><input type="button" class="cancel" value="返回"/></a>
            <label class="submit-msg"></label>
        </li>
    </ul>
    <input class="saveType" type="hidden" name="saveType" value="edit"/>
    <input class="editId" type="hidden" name="editId" value="{{!empty($admin) ? $admin->id : ''}}"/>
</form>
</body>
</html>