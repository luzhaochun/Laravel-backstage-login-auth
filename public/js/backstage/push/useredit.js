$(function () { 
    $("#saveStaff").validate({
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                beforeSubmit: function () {
                    layer.load();
                },
                success: function (data) {
                    if (data.status == true) {
                        $(".submit-msg", form).html(data.msg).removeClass('text-red').addClass('text-green').show();
                        layer.open({
                            type: 0,
                            title: false,
                            skin: 'text-green',
                            content: '编辑成功！',
                            btn: false,
                            closeBtn: false,
                            time: 2000, // 2秒后执行end回调
                            end: function () { 
                                parent.window.location.href ="/Pushuser/index";
                                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                                parent.layer.close(index);
                            }
                        });
                    } else {
                        $(".submit-msg", form).html(data.msg).removeClass('text-green').addClass('text-red').show();
                        setTimeout(window.location.reload(),3000);
                    }
                }
            });
            return false; // 阻止表单自动提交事件
        },
        rules: {
            name: {
                required: true,
            },
            login_id: {
                required: true,
                remote: {
                    url: "/Pushuser/ajax_check",
                    type: "get",
                    dataType: "json",
                    data: {
                        login_id: function () {
                            return $("#login_id").val();
                        },
                        id:function(){
                            return $("#id").val();
                        },
                        type: "edit"
                    }
                }
            },
            confirmpwd: { 
                equalTo : "#login_pwd"
            },
            phone: {
                required: true,
                minlength:11,
                maxlength:11                                
            },
            login_pwd:{
                minlength:5
            }
        },
        messages: {
            name: {
                required: "用户名称不为空"
            },
            login_id: {
                required: "登录名不为空",
                remote: "登陆名唯一,请重新确认"
            },
             login_pwd:{
                minlength: $.validator.format("密码不能小于{0}个字符")
            },
            confirmpwd: {
                equalTo : "确认密码不一致,请重新输入"
            },
            phone: {
                required: "手机号不为空",
                minlength: $.validator.format("手机号不能小于{0}个字符"),
                maxlength: $.validator.format("手机号不能大于{0}个字符")
            }
        }
    })
})