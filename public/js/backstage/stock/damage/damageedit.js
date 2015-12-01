$(document).ready(function() {
        $("#damageEditForm").validate({
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
                            content: '编辑成功！',
                            btn: false,
                            closeBtn: false,
                            time: 2000, // 2秒后执行end回调
                            end: function () {
                                parent.window.location.href ="/StockManage/damageIndex";
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
            product_name  : {
                required : true
            },
            product_count : {
                required : true,
                digits : true,
                min : 1
            },
            product_batch : {
                required : true,
            },
            shelf_no : {   
               required : true, 
            }  
        },
        messages: {
            product_name : {
                required : "产品名称不为空",
            },
            product_count : {
                required : "产品数量不为空",
                digits : "请输入大于0的整数",
                min : "请输入大于0的整数",
            }, 
            product_batch : {
                required : "产品编号不为空",
            },
            shelf_no : {
                 required : "请选择货架编码"
            }
        }
    })
});


