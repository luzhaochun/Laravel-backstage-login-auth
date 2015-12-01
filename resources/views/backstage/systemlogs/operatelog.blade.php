<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>益点点后台管理系统 - {{$title}}</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/systemlog/operatelog.js')}}"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="{{url('/index')}}">首页</a></li>
        <li><a href="#">系统管理</a></li>
        <li>操作日志</li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <label>搜索（日志信息/用户名称） </label>
            <a><input name="searchName" id="searchName" class="scinput" value="<?php echo !empty($paginator->pageData['searchName']) ? $paginator->pageData['searchName'] : '';?>"/></a>
            <a><input type="button" class="searchAdmin sure" value="搜索"/></a>
        </ul>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th class="sorting" title="按ID排序" data-sort-name="id">ID<i class="sort"><img src="/images/px.gif"/></i></th>
            <th class="sorting" width='20%' data-sort-name="update_time">更新时间<i class="sort"><img src="/images/px.gif"/></i></th>
            <th class="sorting" data-sort-name="module">操作模块<i class="sort"><img src="/images/px.gif"/></i></th>
            <th class="hidden-xs">日志信息</th>
            <th class="hidden-xs">登陆IP</th>
            <th class="sorting" data-sort-name="admin_id">用户ID<i class="sort"><img src="/images/px.gif"/></i></th>
            <th class="sorting" data-sort-name="admin_name">用户名称<i class="sort"><img src="/images/px.gif"/></i></th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($loginList))
            @foreach($loginList as $item)
                <tr>
                    <td class="itemid"><?php echo $item->id;?></td>
                    <td><?php echo $item->update_time;?></td>
                    <td><?php echo $item->module;?></td>
                    <td><?php echo $item->log_info;?></td>
                    <td><?php echo $item->ip;?></td>
                    <td><?php echo $item->admin_id;?></td>
                    <td><?php echo $item->admin_name;?></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <?php echo $paginator->show(); ?>
    <input id="sortName" name="sortName" value="<?php echo !empty($paginator->pageData['sortName']) ? $paginator->pageData['sortName'] : '';?>" type="hidden"/>
    <input id="sortType" name="sortType" value="<?php echo !empty($paginator->pageData['sortType']) ? $paginator->pageData['sortType'] : '';?>" type="hidden"/>
    <input id="pageNo"   name="pageNo"   value="<?php echo !empty($paginator->pageData['pageNo'])   ? $paginator->pageData['pageNo']   : '';?>" type="hidden"/>
    <input id="pageSize" name="pageSize" value="<?php echo !empty($paginator->pageData['pageSize']) ? $paginator->pageData['pageSize'] : '';?>" type="hidden"/>
</div>
</body>
</html>