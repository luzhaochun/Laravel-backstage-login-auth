<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/css/select.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script type="text/javascript" src="/js/layer/layer.js"></script>
    <script type="text/javascript" src="/js/backstage/stock/damage/damageadd.js"></script>
    
</head>
<body>


<form id="damageAddForm" class="formbody" action="{{url('/StockManage/damageAdd')}}" method="post">
<!--    <div class="formtitle"><span>新增报损</span></div>-->
    <ul class="forminfo uew-select">
        <li>
            <span>产品名称</span>
            <input id="product_name" name="product_name" class="dfinput" value="" />
            <label id="product_name-error" class="error" for="product_name"></label>
        </li>
        <li>
            <span>产品数量</span>
            <input id="product_count" name="product_count" class="dfinput" value="" />
            <label id="product_count-error" class="error" for="product_count"></label>
        </li>
        <li>
            <span>产品编号</span>
            <input id="product_batch" name="product_batch" class="dfinput" value="" />
            <label id="product_batch-error" class="error" for="product_batch"></label>
        </li>
        <li>
            <span>货架编号</span>
            <div class="vocation">
                <div class="uew-select">
                    <div class="uew-select-value ue-state-default" style="width: 320px;">
                        <em class="uew-select-text"></em>
                        <em class="uew-icon uew-icon-triangle-1-s"></em>
                    </div>
                    <select id="roleSelect" name="shelf_no" class="select1" style="width: 345px;">
                        <option value="" >----请选择----</option>
                        if(!empty($shelf)){
                            @foreach($shelf as $key => $item)
                            <option value="<?php echo $item;?>"><?php echo $item;?></option>
                            @endforeach
                        }
                    </select></div>
            </div>
            <label id="shelf_no-error" class="error" for="shelf_no"></label>
        </li>
        <li>
            <span>备注</span>
            <input id="remark" name="remark" class="dfinput" value="" />
            <label id="remark-error" class="error" for="remark"></label>
        </li>
        <li>
            <label>&nbsp;</label><input type="submit" class="sure" value="保存" style="margin-left: 83px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--            <a href="{{url('/StockManage/damageIndex')}}"><input type="button" class="cancel" value="返回"/></a>-->
            <label class="submit-msg"></label>
        </li>
    </ul>
</form>
</body>
</html>



