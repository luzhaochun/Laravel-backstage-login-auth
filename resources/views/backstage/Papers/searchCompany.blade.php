<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/css/select.css" rel="stylesheet" type="text/css" />
    <link href="/js/jquery-ui-1.11.4.dialog/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/util.js"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/paper/index.js')}}"></script>
    <script>
        //勾选复选框时触发
        function checkName(obj){
            $('#chooseId').val($(obj).val());
            $('#chooseName').val($(obj).attr('attr_value'));
        }

    </script>
    {{--<script type="text/javascript" src="/js/backstage/paper/checkPaper.js"></script>--}}
</head>
<body style="min-width: 500px;">
<div class="rightinfo tab-content">
    <li>
        <div class="">
            <input id="companyNameSearch" name="companyNameSearch" placeholder="企业名称" class="short dialog-error-input"/>
            <input type="button"  class="chooses searchCompanyName" value="搜索">
        </div>
    </li>
    <table class="tablelist">
        <thead>
        <tr>
            <th style="width:5%;padding-left: 5px;"></th>
            <th style="width:10%;">ID</th>
            <th style="width:50%;">企业名称</th>
        </tr>
        </thead>
        <tbody class="checkboxType">
        <?php
        if(!empty($list)){
        foreach($list as $item){ ?>
        <tr>
            <td style="text-align:center;padding-left: 5px;">
                <input  type="radio" name="companyId" onclick="checkName($(this))" attr_value="<?php echo $item->name;?>" value="<?php echo $item->id; ?>"
                <?php if($item->id == $id){echo 'checked';}  ?>>
            </td>
            <td style="width: 8%;">
                <span style="display: inline;"><?php echo $item->id;?></span>
            </td>
            <td><?php echo $item->name;?></td>
        </tr>
        <?php } }else{ ?>
        <tr>
            <td colspan="6">暂无查询数据！</td>
        </tr>
        <?php } ?>
        </tbody>
        <input type="hidden" id="chooseName" value="">
        <input type="hidden" id="chooseId" value="">
    </table>


</body>

</html>
