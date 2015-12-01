$(document).ready(function () {
    $('.tablelist tbody tr:odd').addClass('odd');
    $(document).on('click', '#add_menu', function () {
        layer.open({
            title: '新增菜单',
            type: 2,
            area: ['700px', '450px'],
            fix: true, //不固定
            maxmin: true,
            content: '/AuthGroup/menuAdd',
        });
    });


    //update menu sort value
    $(document).on('focusout', '.menu_sort_edit', function () {
        var _target = $(this);
        var _sort = _target.val();
        var _id = _target.attr('data-id');
        if (!/^[1-9]*[1-9]\d*$/.test(_sort)) {
            layer.msg('排序请输入大于0的整数');
            $(this).val(_target.attr('data-value'));
        } else {
            $.ajax({
                url: "/AuthGroup/updatemenusort",
                data: {id: _id, sort: _sort},
                type: "get",
                dataType: "json",
                success: function (rtn) {
                    if (rtn) {
                        layer.msg('更新成功');
                        _target.attr('data-value', _sort);
                    } else {
                        layer.msg('更新失败');
                        _target.val(_target.attr('data-value'));
                    }

                }
            })
        }
    })
    
    //change role status
    $(document).on('click',".link_menu_status",function(){
        var _target = $(this);
        var status_text = _target.html();
        var id = _target.attr('data-id');
        if(status_text=='不显示') {
            var msg = "确认显示该菜单吗？";
        }else {
            var msg = "确认不显示该菜单吗？";
        }
        layer.confirm(msg, {icon: 3}, function (index) {
            $.ajax({
                url:"/AuthGroup/changemenustatus",
                data:{id:id},
                success:function(result){
                    if(result && _target.html()=='显示'){
                        _target.html('').html('不显示');
                    }else if(result && _target.html()=='不显示'){
                        _target.html('').html('显示');
                    }
                    layer.closeAll();
                }
            });
        });
    });  
    /**add sub menu**/
    $(document).on('click', '.add_sub_menu', function () {
        var target = $(this);
        layer.open({
            title: '新增子菜单',
            type: 2,
            area: ['700px', '450px'],
            fix: true,
            maxmin: true,
            content: '/AuthGroup/menuAdd?id='+target.attr('data-id'),
        });
    });
    
    /**edit menu*/
    $(document).on('click','.edit_menu',function(){
        var target = $(this);
        layer.open({
            title: '编辑菜单',
            type: 2,
            area: ['700px', '450px'],
            fix: true,
            maxmin: true,
            content: '/AuthGroup/menuEdit?id='+target.attr('data-id'),
        });
    });
    
    /*
     * delete menu
     */
    $(document).on('click',".del_menu",function(){
        var target = $(this);
        layer.confirm("确定删除该菜单吗？", {icon: 2}, function (index) {
            $.ajax({
                url:"/AuthGroup/menudel",
                data:{id:target.attr("data-id")},
                type:"get",
                dataType:"json",
                success:function(rtn){
                   if(rtn == 1){
                       window.location.reload();
                   }else{
                       layer.msg('删除失败');
                   }
                }
            });
        });
    });
})