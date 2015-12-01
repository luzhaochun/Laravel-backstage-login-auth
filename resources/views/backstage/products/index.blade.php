<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>益点点后台管理系统 - {{$title}}</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/product/product.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/User/index">商城管理</a></li>
        <li>产品列表</li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <label>搜索：产品名称 </label>
            <a><input name="searchName" id="searchName" class="scinput" value="<?php echo !empty($paginator->pageData['searchName']) ? $paginator->pageData['searchName'] : '';?>"/></a>
            <a><input type="button" class="searchProduct sure" value="搜索"/></a>
        </ul>
        <ul class="toolbar1">
            <a href="{{url('/Product/add')}}"><li><span><img src="/images/t01.png"/></span>新增</li></a>
        </ul>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th width="6%" class="sorting" title="按ID排序" data-sort-name="id">ID<i class="sort"><img src="/images/px.gif"/></i></th>
            <th width="12%">产品名称</th>
            <th>产品规格</th>
            <th width="10%">包装规格</th>
            <th width="7%">市场价格</th>
            <th width="7%">销售价格</th>
            <th width="7%">批发价格</th>
            <th width="7%">库存</th>
            <th width="5%">是否促销</th>
            <th width="10%" class="sorting" title="按更新时间排序" data-sort-name="update_time">最新更新时间<i class="sort"><img src="/images/px.gif"/></i></th>
            <th width="10%">操作</th>
        </tr>
        </thead>
        <tbody>
        @if (!empty($productList))
            @foreach ($productList as $item)
                <tr>
                    <td class="itemid"><?php echo $item->id;?></td>
                    <td><?php echo $item->product_name;?></td>
                    <td><?php echo $item->product_specifications;?></td>
                    <td><?php echo $item->packing_specifications;?></td>
                    <td><?php echo $item->market_price;?></td>
                    <td><?php echo $item->price;?></td>
                    <td><?php echo $item->wholesale_price;?></td>
                    <td><?php echo $item->stock_number;?></td>
                    <td><?php echo ($item->is_promotion == '1' ? '<span class="label label-success">是</span>' : '<span class="label label-default">否</span>');?></td>
                    <td><?php echo $item->update_time;?></td>
                    <td>
                        <a href="{{ url('/Product/edit?id='.$item->id) }}" class="tablelink label label-info" rel="<?php echo $item->id;?>">编辑</a>
                        <a href="javascript:void(0);" class="tablelink label <?php echo ($item->stock_number == 1 ? 'label-danger' : 'label-default')?>" rel="<?php echo $item->id;?>">删除</a>
                        <a href="javascript:void(0);" class="tablelink itemdelete label label-success" rel="<?php echo $item->id;?>">查看</a>
                    </td>
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