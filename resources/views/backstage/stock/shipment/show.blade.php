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
<div class="rightinfo">
    <table class="tablelist" style="width: 590px;">
        <thead>
        <tr>
            <th style="width: 25%;">Title</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>出货单据号:</b></td>
                <td><?php echo $info->order_no;?></td>
            </tr>
             <tr>
                <td style="text-align: right;padding-right: 10px;"><b>出货编码:</b></td>
                <td><?php echo $info->pack_code;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>收货人姓名:</b></td>
                <td><?php echo $info->consignee_name;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>收货人电话	:</b></td>
                <td><?php echo $info->consignee_tel;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>收货地址:</b></td>
                <td><?php echo $info->consignee_address;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>销售订单号:</b></td>
                <td><?php echo $info->sales_order_no;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>销售订单创建时间:</b></td>
                <td><?php echo $info->sales_order_date;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>预计发货时间:</b></td>
                <td><?php echo $info->expected_delivery_date;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>状态:</b></td>
                <td><?php echo $state[$info->state];?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>创建时间:</b></td>
                <td><?php echo $info->create_date;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>操作人姓名:</b></td>
                <td><?php echo $info->operater_name;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>操作时间:</b></td>
                <td><?php echo $info->operate_date;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>发货单:</b></td>
                <td><?php echo $info->waybill_no;?></td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;"><b>备注:</b></td>
                <td><?php echo $info->remark;?></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>

