$(function () {
    $("#frm_add_role").validate({
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $(".submit-msg", form).html('').html(data.msg).removeClass('text-green').addClass('text-red').show();
                },
                error: function (e) {
                    $(".submit-msg", form).html('').html('新增失败！').removeClass('text-green').addClass('text-red').show();
                }
            });
            return false; // 阻止表单自动提交事件
        },
        rules: {
            name: {
                required: true,
                remote: {
                    url: "/AuthGroup/checkRoleNameUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        name: function () {
                            return $("#name").val();
                        }
                    }
                }
            }
        },
        messages: {
            name: {
                required: "角色名称不为空",
                remote: "该角色已存在,请重新确认"
            }
        }
    })
})