$(function () {
    $("#frm_menu").validate({
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                beforeSubmit: function () {
                    layer.load();
                },
                success: function (data) {
                    if (data.status == true) {
                        layer.open({
                            type: 0,
                            title: false,
                            skin: 'text-green',
                            content: '新增成功！',
                            btn: false,
                            closeBtn: false,
                            time: 2000, // 2秒后执行end回调
                            end: function () { 
                                parent.window.location.href ="/AuthGroup/menulist";
                                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                                parent.layer.close(index);
                            }
                        });
                    } else {
                        $(".submit-msg", form).html(data.msg).removeClass('text-green').addClass('text-red').show();
                    }
                },
                error: function (e) {
                    $(".submit-msg", form).html('新增失败！').removeClass('text-green').addClass('text-red').show();
                    layer.closeAll();
                }
            });
            return false; // 阻止表单自动提交事件
        },
        rules: {
            module: {
                required: true,
                remote: {
                    url: "/AuthGroup/checkMenuModuleUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        module: function () {
                            return $("#module").val();
                        },
                        type: 'add'
                    }
                }
            },
            name: {
                required: true,
            },
            sort: {
                required: true,
                digits: true
            }
        },
        messages: {
            module: {
                required: "名称不为空",
                remote: '该名称已存在，请重新输入'
            },
            name: {
                required: "标题不为空"
            },
            sort: {
                required: "排序不为空",
                digits: "排序请输入正整数"
            }
        }
    })
})