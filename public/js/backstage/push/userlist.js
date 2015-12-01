
//异行换色
$(document).ready(function () {
    $('.tablelist tbody tr:odd').addClass('odd');
    $(document).on('click', '#add_menu', function () {
        layer.open({
            title: '新增用户',
            type: 2,
            area: ['700px', '450px'],
            fix: true, //不固定
            maxmin: true,
            content: '/Pushuser/add',
        });
    });
     // 回车搜索
    $("#searchName").keypress(function(e){
        if(e.keyCode == 13)
            $(".searchAdmin").trigger('click');
    });
     // 管理员列表按ID排序
    $(".tablelist").on('click', '.adminId', function(){
        var current_url = window.location.href;
        var id_sort_value = $("table.tablelist #idSort").val();
        if(id_sort_value == "desc"){
            id_sort_value = "asc";
        }else{
            id_sort_value = "desc";
        }
        if(current_url.indexOf('?') != -1){
            current_url += "&idSort=" + id_sort_value;
        }else{
            current_url += "?idSort=" + id_sort_value;
        }
        window.location.href = current_url;
    });
    
//    $(".tablelist").on('click','.updateTime',function){
//        var current_url=window.location.href;
//        var uptime_value=$('table.tablelist #timeSort').val();
//        
//    }

    // 管理员列表按更新时间排序
    $(".tablelist").on('click', '.updateTime', function(){
        $("#idSort").val('');
        var idSort = $("#timeSort").val();
        if(idSort == 'ASC')
            $("#timeSort").val('DESC');
        else
            $("#timeSort").val('ASC');
        window.location = getUrlParams('/Pushuser/index');
    }); 
    /**edit menu*/
    $(".tablelist").on('click','.itemedit', function(){
        layer.open({
            title: '编辑菜单',
            type: 2,
            area: ['700px', '560px'],
            fix: true,
            maxmin: true,
            content: '/Pushuser/edit?id='+$(this).closest('tr').find('td.itemid').text(),
        });
    });
    
    /*
     * delete menu
     */
    $(".tablelist .itemdelete").on('click', function(){
        var target = $(this);
        layer.confirm("确定删除该用户吗？", {icon: 2}, function (index) {
            $.ajax({
                url:"/Pushuser/del",
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