$(document).ready(function() {
        $("#shelfAddForm").validate({
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
                                parent.window.location.href ="/StockManage/shelfIndex";
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
            no  : {
                required : true,
                remote: {
                    url: "/StockManage/checkShelfNoExist",
                    type: "get",
                    dataType: "json",
                    data: {
                        no: function () {
                            return $("#no").val();
                        },
                        type: "add"
                    }
                }
            }
            
             
        },
        messages: {
            no : {
                required : "货位编码不为空",
                remote: "货位编码已存在,请重新确认"
            }

        }
    })
});





