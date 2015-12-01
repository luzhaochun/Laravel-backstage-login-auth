$(function () { 
    $("#editAdminForm").validate({
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
                        id: function(){
                            return $("#admin_id").val();
                        },
                        type: "edit"
                    }
                }
            },
            confirmpwd: { 
                equalTo : "#password"
            }
        },
        messages: {
            name: {
                required: "用户名称不为空"
            },
            login: {
                required: "登录名不为空",
                remote: "登陆名唯一,请重新确认"
            },
            confirmpwd: {
                equalTo : "确认密码不一致,请重新输入"
            }
        }
    })
})