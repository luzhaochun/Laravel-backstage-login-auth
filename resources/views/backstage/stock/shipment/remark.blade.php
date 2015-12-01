<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/css/select.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script type="text/javascript" src="/js/backstage/stock/admin/add.js"></script>  
</head>
<body>
<form id="frm_shipment_remark" class="formbody" action="{{url('/StockShipment/remark')}}" method="post"> 
    <ul class="forminfo uew-select">
        <li>
            <span>备注:</span>
            <textarea style="width: 435px;" name="remark" cols="" rows="" class="textinput"><?php echo $remark;?></textarea>
        </li>
        <li style="padding-left: 82px;">
            <label>&nbsp;</label>
            <input type="hidden" value="<?php echo $id;?>" name="id" id="id" />
            <input type="submit" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="submit-msg"></label>
        </li>
    </ul>
</form>
</body>
</html>

