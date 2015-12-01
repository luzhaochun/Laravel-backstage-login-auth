<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>益点点后台管理系统</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/util.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
    <script type="text/javascript" src="/js/backstage/stock/shelf/shelflist.js"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/StockManage/shelfIndex">库存管理</a></li>
        <li>货位管理</li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <form method="get" action="{{ url('/StockManage/shelfIndex') }}" name="frm_search" id="frm_search">
            <ul class="toolbar">
                <label>搜索:货位编号 </label>
                <a><input name="searchName" id="searchName" class="scinput" value="<?php echo $searchName;?>"/></a>
                <a><input type="submit" class="searchAdmin sure" value="搜索"/></a>
            </ul>
        </form>
        <ul class="toolbar1" style="cursor:pointer">
            <li id="add_shelf" class="add_shelf" ><span><img src="/images/t01.png" /></span>新增</li>
        </ul>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th class="sorting id_sort" title="按ID排序" style="width: 3%;">ID
                <i class="sort"><img src="/images/px.gif"/></i>
            </th>
            <th>货位编码</th>
            <th>货位状态</th>
            <th style="width: 5%;">操作</th>
        </tr>
        </thead>
        <tbody>
        
        @if(!empty($items))
            @foreach($items as $item)
            <tr>
                <td class="itemid"><?=$item->id?></td>
                <td><?=$item->no?></td>
                    <td>
                        @if($item->state==1)
                        显示
                        @else
                        隐藏
                        @endif
                    </td>
                <td><a href="#" class="tablelink edit_shelf" id="edit_shelf" data-id="<?php echo $item->id ?>">编辑</a>
                    <a href="#" class="tablelink shelfDel" data-id="<?php echo $item->id ?>">删除</a></td>
            </tr>
            @endforeach
        @else
            <tr><td colspan="4"><b>暂无查询数据</b></td></tr>
        @endif

        </tbody>
        <input id="idSort" name="idSort" value="<?php echo $idSort;?>" type="hidden"/>
    </table>
    <?php if($paginator->totalNum>0) echo $paginator->show();?>
</div>
</body>
</html>





