/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    $("#frm_edit_menu").validate({
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                type: 'post',
                dataType: 'json',
                beforeSubmit: function () {
                    layer.load();
                },
                success: function (data) {
                    var index = parent.layer.getFrameIndex(window.name);
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
                                parent.layer.close(index);
                            }
                        });
                    } else {
                        $(".submit-msg", form).html(data.msg).removeClass('text-green').addClass('text-red').show();
                    }
                    window.location.reload();
                },
                error: function (e) {
                    $(".submit-msg", form).html('编辑失败！').removeClass('text-green').addClass('text-red').show();
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
                            return $("#frm_edit_menu #module").val();
                        },
                        type: 'edit',
                        id: function () {
                            return $("#frm_edit_menu #menu_id").val();
                        }
                    }
                }
            },
            name: {
                required: true
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
                required: "标题不为空",
            },
            sort: {
                required: "排序不为空",
                digits: "排序请输入正整数"
            }
        }
    })

})
