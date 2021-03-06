<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>益点点后台管理系统 - {{$title}}</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/util.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/paper/index.js')}}"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/Paper/index">题卷管理</a></li>
        <li>题卷列表</li>
    </ul>
</div>
<div class="rightinfo">
    <form id="search_form" action="{{url('PaperRoll/index')}}" method="post">
    <div class="tools">
        <ul class="toolbar">
            <label>搜索：企业名称/题卷名称名称 </label>
            <a><input name="searchName" id="searchName" class="scinput" value="<?=!empty($search['searchName']) ? $search['searchName'] : ''?>"/></a>
            <a><input type="submit" class="scbtn" value="搜索"/></a>
        </ul>
        <ul class="toolbar1">
            <a href="{{url('PaperRoll/add')}}"><li ><span><img src="/images/t01.png"/></span>新增</li></a>
        </ul>
    </div>
    </form>

    <table class="tablelist">
        <thead>
        <tr>
            {{--<th><input name="" type="checkbox" value=""/></th>--}}
            <th style="width:5%;">ID</th>
            <th style="width:15%;">企业名称</th>
            <th style="width:15%;">题卷名称</th>
            <th>题数</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if (!empty($items))
        @foreach ($items as $item)
        <tr>
            {{--<td><input name="" type="checkbox" value=""/></td>--}}
            <td class="itemid"><?=$item->id?></td>
            <td><?=$item->company_name?></td>
            <td><?=$item->paper_name?></td>
            <td><?=$item->number?></td>
            <td>@if ($item->is_active == 1)有效@else失效@endif</td>
            <td><a href="{{url('PaperRoll/edit?id='.$item->id)}}" class="tablelink">编辑</a>|<a href="#" class="tablelink itemdelete"> 删除</a>
                @if ($item->is_random == 0)|<a href="#" data-id="<?=$item->id?>" class="tablelink btn_scan_admin"> 选择题卷列表</a>@endif</td>
        </tr>
        @endforeach
        @endif
        </tbody>
        <input id="searchValue" name="searchValue" value="<?=!empty($paginator->pageData['searchName']) ? $paginator->pageData['searchName'] : ''?>" type="hidden"/>
        <input id="pageNo" name="pageNo" value="<?=!empty($paginator->pageData['pageNo']) ? $paginator->pageData['pageNo'] : ''?>" type="hidden"/>
        <input id="pageSize" name="pageSize" value="<?=!empty($paginator->pageData['pageSize']) ? $paginator->pageData['pageSize'] : ''?>" type="hidden"/>
    </table>

    <?php
        echo $paginator->show();
    ?>


</div>
</body>
</html>

