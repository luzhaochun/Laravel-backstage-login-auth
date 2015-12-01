$(function () {
    $("#addAdminForm").validate({
        rules: {
            name: {
                required: true,
            },
            login: {
                required: true,
                remote: {
                    url: "/StockManage/checkAdminExist",
                    type: "get",
                    dataType: "json",
                    data: {
                        login: function () {
                            return $("#login").val();
                        },
                        type: "add"
                    }
                }
            },
            pwd: {
                required: true,
                
            },
            confirmpwd: {
                required: true,
                equalTo : "#password"
            }
        },
        messages: {
            name: {
                required: "用户名称不为空",
                //remote: "该角色已存在,请重新确认"
            },
            login: {
                required: "登录名不为空",
                remote: "登陆名唯一,请重新确认"
            },
            pwd: {
                required: "密码不为空"
            },
            confirmpwd: {
                required: "确认密码不为空",
                equalTo : "确认密码不一致,请重新输入"
            }
        }
    })
})