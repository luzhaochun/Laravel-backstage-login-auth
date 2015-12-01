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
            <th style="width: 25%;">ID</th>
            <th>产品名称</th>
            <th>产品数量</th>
        </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($list)){ 
                foreach($list as $v){ ?>
                <tr>
                    <td><em><?php echo $v->id;?></em></td>
                    <td><?php echo $v->product_name;?></td>
                    <td><?php echo $v->product_count;?></td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="3"><b>暂无查询数据</b></td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="width: 590px;">
        <?php if($paginator->totalNum > 0) echo $paginator->show();?>
    </div>
</div>
</body>
</html>

