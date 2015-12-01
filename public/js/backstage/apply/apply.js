$(document).ready(function ($) {
    $(".click").click(function () {
        $(".tip").fadeIn(200);
    });
    $(".tiptop a, .sure, .cancel").click(function () {
        $(".tip").fadeOut(200);
    });

    $('.tablelist tbody tr:odd').addClass('odd');
    //$("input[type='checkbox']").selectCheckBox();

    $("#roleSelect").on('change', function(){
        $("#addAdminForm .forminfo .uew-select-text").html($(this).find("option:selected").text());
    });

    $("#addAdminForm").on('click', 'input.sure', function(){
        $("#addAdminForm").submit();
    });

    $(document).on('click', '.itemShow', function(){
        var id = $(this).closest('tr').find('td.itemid').text();
        //页面层
        layer.open({
            title: '查看详情',
            type: 2,
            btn: ['取消'],
            cancel: function (index){}, // 取消
            skin: 'layui-layer-rim', //加上边框
            area: ['500px','700px'], //宽高
            content: '/Apply/show?id='+id
        });
    });

    $(".tablelist .itemdelete").on('click', function(){
        var id = $(this).closest('tr').find('td.itemid').text();
        layer.confirm('确定删除该条申请提现记录吗？', {
            title: '提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: '/Apply/del',
                dataType: 'json',
                type: 'post',
                data: {'id': id},
                success: function(data){
                    if(data.status == true)
                        layer.msg(data.msg, {time: 2000, icon: 1}, function () {
                            window.location = '/Apply/index';
                        });
                    else
                        layer.msg(data.msg, {time: 3000, icon: 5}, function () {
                            window.location = '/Apply/index';
                        });
                }
            });

        }, function(){
        });
    });

    $(".tablelist .itemcancel").on('click', function(){
        var id = $(this).closest('tr').find('td.itemid').text();
        layer.confirm('确定取消该条申请提现记录吗？', {
            title: '提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: '/Apply/cancel',
                dataType: 'json',
                type: 'post',
                data: {'id': id},
                success: function(data){
                    if(data.status == true)
                        layer.msg(data.msg, {time: 2000, icon: 1}, function () {
                            window.location = '/Apply/index';
                        });
                    else
                        layer.msg(data.msg, {time: 3000, icon: 5}, function () {
                            window.location = '/Apply/index';
                        });
                }
            });

        }, function(){
        });
    });


    $(document).on('click', '.itemRemittance', function(){
        var id = $(this).closest('tr').find('td.itemid').text();
        //页面层
        layer.open({
            title: '汇款',
            type: 2,
            skin: 'layui-layer-rim', //加上边框
            area: ['600px','420px'], //宽高
            content: '/Apply/completed?id='+id
        });
    });



});