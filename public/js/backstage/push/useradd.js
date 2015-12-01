$(function () {
    $("#addStaff").validate({
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
                            content: '新增成功！',
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
            login_id: {
                required: true,
                remote: {
                    url: "/Pushuser/ajax_check"+ ($(".editId").val() ? '?id=' + $(".editId").val() : ''),
                    type: "get",
                    dataType: "json",
                    data: {
                        login_id: function () {
                            return $("#login_id").val();
                        },
                        type: 'add'
                    }
                }
            },
            name: {
                required: true,
            },
            phone: {
                required: true,
                minlength:11,
                maxlength:11                                
            },
            login_pwd:{
                required:true,
                minlength:5
            }
        },
        messages: {
            login_id: {
                required: "登陆ID不为空",
                remote: '该名称已存在，请重新输入'
            },
            login_pwd:{
                required:"密码不能为空",
                minlength: $.validator.format("密码不能小于{0}个字符")
            },
            name: {
                required: "姓名不为空"
            },
            phone: {
                required: "手机号不为空",
                minlength: $.validator.format("手机号不能小于{0}个字符"),
                maxlength: $.validator.format("手机号不能大于{0}个字符")
            }
        }
    });
    
    
    
    
})

//$(function () {
//    $("#frm_menu").validate({
//        rules: {
//            login_id: {
//                required: true,
//                remote: {
//                    url: "Pushuser/checkUser",
//                    type: "get",
//                    dataType: "json",
//                    data: {
//                        longin_id: function () {
//                            return $("#login_id").val();
//                        },
//                        type: 'add'
//                    }
//                }
//            },
//            name: {
//                required: true,
//            },
//            phone: {
//                required: true,
//                minlength:11,
//                maxlength:11                                
//            },
//            login_pwd:{
//                required:true,
//                minlength:5
//            }
//        },
//        messages: {
//            login_id: {
//                required: "ID不为空",
//                remote: '该名称已存在，请重新输入'
//            },
//            login_pwd:{
//                required:"密码不能为空",
//                minlength: $.validator.format("密码不能小于{0}个字符")
//            },
//            name: {
//                required: "姓名不为空"
//            },
//            phone: {
//                required: "手机号不为空",
//                minlength: $.validator.format("手机号不能小于{0}个字符"),
//                maxlength: $.validator.format("手机号不能大于{0}个字符")
//            }
//        }
//    })
//})