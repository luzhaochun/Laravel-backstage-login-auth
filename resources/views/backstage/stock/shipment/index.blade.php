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
    <script type="text/javascript" src="/js/backstage/stock/shipment/index.js"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index/index">首页</a></li>
        <li><a href="javascript:void(0);">库存管理</a></li>
        <li>出库管理</li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <form method="get" action="{{ url('/StockShipment/index') }}" name="frm_search" id="frm_search">
            <ul class="toolbar">
                <label>搜索：出货单据号/销售订单号/收货人/收货人电话</label>
                <a><input name="searchName" id="searchName" class="scinput" value="<?php echo $searchName;?>"/></a>
                <a><input type="submit" class="searchAdmin sure" value="搜索"/></a>
            </ul>
        </form>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th class="sorting id_sort" title="按ID排序" style="width: 4%;">ID
                <i class="sort"><img src="/images/px.gif"/></i>
            </th>
            <th>出货单据号</th>
            <th>出货编码</th>
            <th>收货人</th>
            <th>收货人电话</th>
            <th>销售订单号</th>
            <th>预计发货时间</th>
            <th>状态</th>
            <th>操作人</th>
            <th>操作时间</th>
            <th>发货单号</th>
            <th>备注</th>
            <th style="width: 12%;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        if(!empty($list)){ 
            foreach($list as $v){ ?>
            <tr>
                <td><em><?php echo $v->id;?></em></td>
                <td><?php echo $v->order_no;?></td>
                <td><?php echo $v->pack_code;?></td>
                <td><?php echo $v->consignee_name;?></td>
                <td><?php echo $v->consignee_tel;?></td>
                <td><?php echo $v->sales_order_no;?></td>
                <td><?php echo $v->expected_delivery_date;?></td>
                <td><?php echo $state[$v->state];?></td>
                <td><?php echo $v->operater_name;?></td>
                <td><?php echo $v->operate_date;?></td>
                <td><?php echo $v->waybill_no;?></td>
                <td><?php echo $v->remark;?></td>
                <td>
                    <a href="javascript:void(0);" data-id="<?php echo $v->id;?>" class="tablelink shipment_detail label label-info">详细</a>
                    <a href="javascript:void(0);" data-id="<?php echo $v->id;?>" class="tablelink shipment_products label label-success" data-id="<?=$v->id?>">出库产品</a>
                    <a href="javascript:void(0);" data-remark="<?php echo $v->remark;?>" data-order_no="<?php echo $v->order_no;?>" data-id="<?php echo $v->id;?>" class="tablelink shipment_remark label label-default" data-id="<?=$v->id?>">备注</a>
                </td>
            </tr>
        <?php } }else{ ?>
            <tr><td colspan="13"><b>暂无查询数据</b></td></tr>
        <?php } ?>
        </tbody>
        <input id="idSort" name="idSort" value="<?php echo $idSort;?>" type="hidden"/>
    </table>
    <?php if($paginator->totalNum > 0) echo $paginator->show();?>
</div>
</body>
</html>

