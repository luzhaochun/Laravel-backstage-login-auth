/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $("#frm_area").validate({
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
                                parent.window.location.href ="/Area/index";
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
                required: true
            },
            code: {
                required: true,
                digits: true,
                remote: {
                    url: "/Area/checkCodeUnique",
                    type: "get",
                    dataType: "json",
                    data: {
                        code: function () {
                            return $("#frm_area #code").val();
                        },
                        type: 'add'
                    }
                }
            },
            zone_number: {
                digits: true
            },
        },
        messages: {
            name: {
                required: '地区名称非空'
            },
            code: {
                required: '地区码非空',
                remote: '地区码唯一',
                digits: '请输入整数',
            },
            zone_number: {
                digits: '请输入整数'
            },
        }
    })
})

