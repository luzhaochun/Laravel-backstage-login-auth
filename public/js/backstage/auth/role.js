/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $('.tablelist tbody tr:odd').addClass('odd');
    $("input[type='checkbox']").selectCheckBox();
    $(".tab-content").on('click', ".role_name_edit", function () {
        $(this).parent().hide();
        $(this).parent().siblings('div').show();
    });
    $(".tab-content").on('click', ".role_name_save", function () {
        var _target = $(this);
        var id = _target.siblings("input[type='text']").attr("data-id");
        var name = _target.siblings("input[type='text']").prop('value');
        if (id == "" || name == "") {
            layer.msg('角色不为空,请输入');
            return;
        }
        $.ajax({
            url: "/AuthGroup/edit",
            data: {id: id, name: name},
            type: "POST",
            dataType: "json",
            success: function (rtn) {
                if (rtn.status == 'Y') {
                    _target.parent('div').hide();
                    _target.parent().siblings('span').show().children('span').html('').html(name);
                } else {
                    layer.msg(rtn.msg);
                }
            }
        });
    });
    
    //change role status
    $(".tab-content").on('click', ".link_role_status", function () {
        var _target = $(this);
        var status_text = _target.html();
        var id = _target.attr('data-id');
        if (status_text == '启用') {
            var msg = "确认禁用该角色吗？";
        } else {
            var msg = "确认启用该角色吗？";
        }
        layer.confirm(msg, {icon: 3}, function (index) {
            $.ajax({
                url: "/AuthGroup/changestatus",
                data: {id: id},
                success: function (result) {
                    if (result && _target.html() == '启用') {
                        _target.html('').html('禁用');
                    } else if (result && _target.html() == '禁用'){
                        _target.html('').html('启用');
                    }
                    layer.close(index);
                }
            });
        });
    });
    
    //role delete
    $(".tab-content").on('click', "#dodelete", function () {
        var checked = $("tbody input[type='checkbox']:checked");
        if (checked.length <= 0) {
            layer.msg('请选择删除项');
            return;
        }
        var ids = '';
        checked.each(function () {
            ids += $(this).attr("data-id") + ",";
        });
        layer.confirm("您确认删除吗？", {icon: 2}, function (index) {
            $.ajax({
                url: "/AuthGroup/delete",
                data: {ids: ids},
                dataType: 'json',
                type: "post",
                success: function (rtn) {
                    if (rtn) {
                        window.location.reload();
                    } else {
                        layer.msg("删除失败！");
                    }
                }
            })
        });
    });
    
    $(document).on('click', '.btn_scan_admin', function () {
        var _id = $(this).attr('data-id');
        layer.open({
            title: '成员列表',
            type: 2,
            area: ['800px', '500px'],
            fix: false, //不固定
            maxmin: true,
            content: "/AuthGroup/memberlist?id=" + _id
        });
    });
    
    $(document).on('click', '.btn_select_auth', function () {
        var _id = $(this).attr('data-id');
        layer.open({
            title: '选择权限',
            type: 2,
            area: ['900px', '700px'],
            fix: false,
            maxmin: true,
            content: "/AuthGroup/rulelist?id=" + _id
        });
    });
    
    
})