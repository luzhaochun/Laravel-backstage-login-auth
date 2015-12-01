/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    $('.tablelist tbody tr:odd').addClass('odd');
    $(document).on('click', '#add_area', function () {
        layer.open({
            title: '新增地区',
            type: 2,
            area: ['700px', '450px'],
            fix: true, //不固定
            maxmin: true,
            content: '/Area/add',
        });
    });

    $(document).on('click', '.edit_area', function () {
        var id = $(this).attr('data-id');
        layer.open({
            title: '编辑地区',
            type: 2,
            area: ['700px', '450px'],
            fix: true, //不固定
            maxmin: true,
            content: '/Area/edit?id='+id,
        });
    })
    
    $(document).on('click',".del_area",function(){
        var target = $(this);
        layer.confirm("确定删除该地区吗？", {icon: 2}, function (index) {
             window.location.href = "/Area/del?id="+target.attr("data-id");
        });
    })

})