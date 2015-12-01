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
    <script>


        $(document).ready(function(){
            $('.tablelist tbody tr:odd').addClass('odd');
        });

        checkedIds = new Array;
        var json_data = <?php echo json_encode($paperlist);?>;
        for(var i in json_data){
            checkedIds.push(json_data[i]);
        }


        //勾选复选框时触发
        function checkName(obj){
//            checkedIds = $('#sub_ids').val();

            if($(obj ).is(':checked')){
                checkedIds.push(obj.val());
            }else{
                checkedIds.splice(jQuery.inArray(obj.val(),checkedIds),1);
            }
            $('#sub_ids').val(checkedIds);

        }


        //弹窗的分页
        //分页
        function home_page(obj){
            var url = obj.attr('ajax_href');
            $.ajax({
                type:'post',
                url:url,
                datatype : 'json',
                data:'checkids='+checkedIds,
                success:function(data){
                    var json = eval("(" + data + ")");
                    $('.checkboxType').html(json.str);
                    $('.ajax_page').html(json._page);
                }
            })
        }
    </script>
    {{--<script type="text/javascript" src="/js/backstage/paper/checkPaper.js"></script>--}}
</head>
<body style="min-width: 500px;">
<div class="rightinfo tab-content">
    <table class="tablelist">
        <thead>
        <tr>
            <th style="width:2%;padding-left: 5px;"></th>
            <th style="width:5%;">ID</th>
            <th style="width:50%;">题目名称</th>
        </tr>
        </thead>
        <tbody class="checkboxType">
        <?php
        if(!empty($list)){
        foreach($list as $item){ ?>
        <tr>
            <td style="text-align:center;padding-left: 5px;">
                <input  type="checkbox" name="addMids[]" onclick='checkName($(this))' value="<?php echo $item->id; ?>"
                <?php if(in_array($item->id,$paperlist)){echo 'checked';}  ?>>
                <input type="hidden" name="paperId" id="paperId" value="<?php echo $paperId;?>">
            </td>
            <td style="width: 8%;">
                <span style="display: inline;"><?php echo $item->id;?></span>
            </td>
            <td><?php echo $item->problem;?></td>
        </tr>
        <?php } }else{ ?>
        <tr>
            <td colspan="3">暂无查询数据！</td>
        </tr>
        <?php } ?>
        <input type="hidden" name="sub_ids" value="<?php echo implode(',',$paperlist);?>" id="sub_ids"/>
        </tbody>
    </table>
    <div class="ajax_page">
        <?php
        echo $paginator->show_ajax();
        ?>
    </div>


</body>

</html>
