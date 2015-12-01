$(document).ready(function ($) {
    $(".click").click(function () {
        $(".tip").fadeIn(200);
    });
    $(".tiptop a, .sure, .cancel").click(function () {
        $(".tip").fadeOut(200);
    });

    $('.tablelist tbody tr:odd').addClass('odd');
    //$("input[type='checkbox']").selectCheckBox();

    // 回车搜索
    $("#searchName").keypress(function(e){
        if(e.keyCode == 13)
            $(".searchAdmin").trigger('click');
    });

    // 管理员列表搜索
    $(".searchAdmin").on('click', function(){
        window.location = getUrlParams('/Admin/index');
        /*$.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            data: {'searchName': name},
            success: function(result){
                if(result.successful){
                    var params = [];
                    for(var s in result.data){
                        params.push(s);
                    }
                    console.log(params);
                    url += '?' + params.join('&');
                    console.log(url);
                }
            }
        });*/
    });

    // 管理员列表按ID排序
    $(".tablelist").on('click', '.adminId', function(){
        $("#timeSort").val('');
        var idSort = $("#idSort").val();
        if(idSort == 'DESC')
            $("#idSort").val('ASC');
        else
            $("#idSort").val('DESC');
        window.location = getUrlParams('/Admin/index');
    });

    // 管理员列表按更新时间排序
    $(".tablelist").on('click', '.updateTime', function(){
        $("#idSort").val('');
        var idSort = $("#timeSort").val();
        if(idSort == 'ASC')
            $("#timeSort").val('DESC');
        else
            $("#timeSort").val('ASC');
        window.location = getUrlParams('/Admin/index');
    });

    // 通过参数获取相应Url
    function getUrlParams(url){
        var idSort = $("#idSort").val();
        var timeSort = $("#timeSort").val();
        var pageNo = $("#pageNo").val();
        var pageSize = $("#pageSize").val();
        var searchValue = $("#searchName").val();
        return url + '?idSort=' + idSort + '&timeSort=' + timeSort + '&pageNo=' + pageNo + '&pageSize=' + pageSize + '&searchName=' + searchValue;
    }

    $("#roleSelect").on('change', function(){
        $("#addAdminForm .forminfo .uew-select-text").html($(this).find("option:selected").text());
    });

    $("#addAdminForm, #saveAdminForm").validate({
        // 表单提交句柄，为一回调函数，带一个参数：form
        submitHandler: function(form){
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                //forceSync: true,
                beforeSubmit: function(){
                    layer.load();
                },
                success: function(data){
                    layer.closeAll();
                    if(data.status == true){
                        $(".submit-msg", form).html(data.msg).removeClass('text-red').addClass('text-green').show();
                        layer.open({
                            type: 0,
                            title: false,
                            skin: 'text-green',
                            content: '发布成功！',
                            btn: false,
                            closeBtn: false,
                            time: 2000, // 2秒后执行end回调
                            end: function(){
                                window.location.href = '/Admin/index';
                            }
                        });
                    }else{
                        $(".submit-msg", form).html(data.msg).removeClass('text-green').addClass('text-red').show();
                    }
                },
                error: function(e){
                    $(".submit-msg", form).html('系统错误，请联系管理员！').removeClass('text-green').addClass('text-red').show();
                    layer.closeAll();
                }
            });
            return false; // 阻止表单自动提交事件
        },
        rules: {
            user_name:{
                required:true,
                remote: {
                    url: "/Admin/checkNameUnique" + ($(".editId").val() ? '?id=' + $(".editId").val() : ''),
                    type: "post",
                    dataType: "json",
                    data:{
                        'user_name': function(){return $("#user_name").val()},
                        'type': ($(".saveType").val() ? $(".saveType").val() : '')
                    }
                }
            },
            password :{
                required:true,
                minlength: 5
            },
            confirmpwd: {
                equalTo: "#password"
            }
        },
        messages: {
            user_name : {
                required:"管理员名称不为空",
                remote : "该管理员名称已存在"
            },
            password: {
                required: "密码不能为空",
                minlength: $.validator.format("密码不能小于{0}个字符")
            },
            confirmpwd: {
                equalTo: "两次输入密码不一致"
            }
        }
    });

    $("#addAdminForm").on('click', 'input.sure', function(){
        $("#addAdminForm").submit();
    });
    $("#saveAdminForm").on('click', 'input.sure', function(){
        $("#saveAdminForm").submit();
    });

    /*$(document).on('click', '#adminAdd', function(){
        //页面层
        layer.open({
            title: '新增管理员',
            type: 1,
            btn: ['保存', '取消'],
            yes: function (index, layero) { // 保存
                $("#addForm").validator();
                $("#addForm").submit();
            },
            cancel: function (index){}, // 取消
            skin: 'layui-layer-rim', //加上边框
            area: ['520px'], //宽高
            content: $('#addAdminDialog').html()
        });
    });*/

    $(".tablelist .itemdelete").on('click', function(){
        var id = $(this).attr('rel');
        layer.confirm('确定删除该管理员吗？', {
            title: '提示',
            icon: 3,
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: '/Admin/delete',
                dataType: 'json',
                type: 'post',
                data: {'id': id},
                success: function(data){
                    layer.msg(data.msg, {time: 2500, icon: (data.status == true ? 1 : 5)}, function () {
                        window.location = '/Admin/index';
                    });
                }
            });
        }, function(){
        });
    });
});