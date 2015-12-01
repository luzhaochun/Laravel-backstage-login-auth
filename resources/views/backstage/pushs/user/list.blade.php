<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <link href="/css/select.css" rel="stylesheet" type="text/css" />
        <link href="/js/jquery-ui-1.11.4.dialog/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/push/userlist.js')}}"></script>
    </head>
    <body>
       <div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/Admin/index">地推端</a></li>
        <li>用户管理</li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <form method="get" action="{{url('/Pushuser/index')}}"> 
        <ul class="toolbar">
            <label>搜索：登录名称/真实姓名/联系电话 </label>
            <a><input name="searchName" id="searchName" class="scinput" value="<?php echo $searchName;?>"/></a>
            <a><input type="submit" class="searchAdmin sure" value="搜索"/></a>
        </ul>
        </form>
        <ul class="toolbar1">
            <li id="add_menu" class="add_menu"><span><img src="/images/t01.png" /></span>新增</li>
        </ul>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th style="width: 3%;"class="sorting adminId" title="按ID排序">ID<i class="sort"><img src="/images/px.gif"/></i></th>
            <th>登陆名称</th>
            <th>真实姓名</th>
            <th>联系电话</th>
            <th style="width: 5%;text-align: center;">是否活动</th>
            <th style="width: 8%;text-align: center;" title="按更新时间排序">最新更新时间</th>
            <th style="width: 7%;">操作</th>
        </tr>
        </thead>
        <tbody>
        @if (!empty($list))
        @foreach ($list as $vo)
        <tr>
            <td class="itemid">{{$vo->id}}</td>
            <td>{{$vo->login_id}}</td>
            <td>{{$vo->name}}</td>
            <td>{{$vo->phone}}</td>
            <td style="text-align: center;">
                @if($vo->is_active==1)
                <span class="label label-success">正常</span>
                @else
                <span class="label label-default">冻结</span>
                @endif
            </td>
            <td style="text-align: center;">{{$vo->update_time}}</td>    
            <td>
                <a href="javascript:void(0);" class="tablelink itemedit label label-info">编辑</a>
                @if($vo->is_active==1)
                <a href="javascript:void(0);" data-id="<?php echo $vo->id;?>" class="tablelink itemdelete label label-danger"> 删除</a>
                @elseif($vo->is_active==0)
                <a href="javascript:void(0);" class="label label-default"> 删除</a>
                @endif
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="8">暂无查询数据！</td>
        </tr>
        @endif
        </tbody>
        <input id="idSort" name="idSort" value="<?php echo $idSort;?>" type="hidden"/>
    </table>
     <?php echo $paginator->show(); ?>
</div>
</body>
</html>