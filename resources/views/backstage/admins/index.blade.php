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
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/Admin/index">管理员管理</a></li>
        <li>管理员列表</li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <label>搜索：管理员/角色名称 </label>
            <a><input name="searchName" id="searchName" class="scinput" value="<?php echo !empty($paginator->pageData['searchName']) ? $paginator->pageData['searchName'] : '';?>"/></a>
            <a><input type="button" class="searchAdmin sure" value="搜索"/></a>
        </ul>
        <ul class="toolbar1">
            <a href="{{url('/Admin/add')}}"><li><span><img src="/images/t01.png"/></span>新增</li></a>
        </ul>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th class="sorting adminId" title="按ID排序">ID<i class="sort"><img src="/images/px.gif"/></i></th>
            <th>管理员名称</th>
            <th>角色名称</th>
            <th class="sorting updateTime" title="按更新时间排序">最新更新时间<i class="sort"><img src="/images/px.gif"/></i></th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if (!empty($items))
        @foreach ($items as $item)
        <tr>
            <td class="itemid"><?=$item->id?></td>
            <td><?=$item->user_name?></td>
            <td><?=$item->role_name?></td>
            <td><?=$item->update_time?></td>
            <td><a href="{{ url('/Admin/edit?id='.$item->id) }}" class="tablelink label label-info" rel="<?php echo $item->id;?>">编辑</a> <a href="javascript:void(0);" class="tablelink itemdelete label label-danger" rel="<?php echo $item->id;?>">删除</a></td>
        </tr>
        @endforeach
        @endif
        </tbody>
        <input id="idSort" name="idSort" value="<?php echo !empty($paginator->pageData['idSort']) ? $paginator->pageData['idSort'] : '';?>" type="hidden"/>
        <input id="timeSort" name="timeSort" value="<?php echo !empty($paginator->pageData['timeSort']) ? $paginator->pageData['timeSort'] : '';?>" type="hidden"/>
        <input id="pageNo" name="pageNo" value="<?php echo !empty($paginator->pageData['pageNo']) ? $paginator->pageData['pageNo'] : '';?>" type="hidden"/>
        <input id="pageSize" name="pageSize" value="<?php echo !empty($paginator->pageData['pageSize']) ? $paginator->pageData['pageSize'] : '';?>" type="hidden"/>
    </table>

    <?php echo $paginator->show(); ?>

    <div id="addAdminDialog" class="tip">
        <form class="formdialog" id="addForm" action="{{url('/Admin/add')}}" method="post">
           <ul class="admindialoginfo">
               <li>
                   <span>管理员名称</span>
                   <div class="dialog-input-label">
                       <input id="user_name" name="user_name" class="dfinput dialog-error-input"/>
                       <label id="user_name-error" class="error" for="user_name"></label>
                   </div>
               </li>
               <li>
                   <span>角色</span>
                   <div class="vocation">
                       <div class="uew-select">
                           <div class="uew-select-value ue-state-default" style="width: 320px;">
                               <em class="uew-select-text"><?php echo !empty($groupList) ? $groupList[0]->name : '';?></em>
                               <em class="uew-icon uew-icon-triangle-1-s"></em>
                           </div>
                           <select id="roleSelect" name="role_id" class="select1" style="width: 345px;">
                               @foreach($groupList as $item)
                                   <option value="<?=$item->id?>" <?php echo !empty($groupList[0]) && $groupList[0]->id == $item->id ? 'selected="selected"' : '';?>><?=$item->name?></option>
                               @endforeach
                           </select></div>
                   </div>
               </li>
               <li>
                   <span>密码</span>
                   <div class="dialog-input-label">
                       <input id="password" name="password" type="password" class="dfinput dialog-error-input"/>
                       <label id="password-error" class="error" for="password"></label>
                   </div>
               </li>
               <li>
                   <span>确认密码</span>
                   <div class="dialog-input-label">
                       <input name="confirmpwd" type="password" class="dfinput dialog-error-input"/>
                       <label id="confirmpwd-error" class="error" for="confirmpwd"></label>
                   </div>
               </li>
           </ul>
        </form>
    </div>
</div>
</body>
</html>