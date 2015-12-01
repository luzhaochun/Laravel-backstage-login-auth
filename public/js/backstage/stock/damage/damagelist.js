
$(document).ready(function ($) {
    $(".click").click(function () {
        $(".tip").fadeIn(200);
    });
    $(".tiptop a, .sure, .cancel").click(function () {
        $(".tip").fadeOut(200);
    });

    $('.tablelist tbody tr:odd').addClass('odd');
    //$("input[type='checkbox']").selectCheckBox();

    //新增弹窗

    $(document).on('click', '#add_damage', function () {
        layer.open({
            title: '新增报损',
            type: 2,
            area: ['700px', '450px'],
            fix: true, //不固定
            maxmin: true,
            content: '/StockManage/damageAdd',
        });
    });

    //编辑弹窗

    $(document).on('click', '.edit_damage', function () {
        var target = $(this);
        layer.open({
            title: '编辑报损',
            type: 2,
            area: ['700px', '450px'],
            fix: true, //不固定
            maxmin: true,
            content: '/StockManage/damageEdit?id=' + target.attr('data-id'),
        });
    });


// 回车搜索
    $("#searchName").keypress(function (e) {
        if (e.keyCode == 13)
            $(".searchAdmin").trigger('click');
    });

    $("table.tablelist").on('click', '.id_sort', function () {
        var current_url = window.location.href
        var id_sort_value = $("table.tablelist #idSort").val();
        if (id_sort_value == "desc") {
            id_sort_value = "asc";
        } else {
            id_sort_value = "desc";
        }
        if (current_url.indexOf('?') != -1) {
            current_url += "&idSort=" + id_sort_value;
        } else {
            current_url += "?idSort=" + id_sort_value;
        }
        window.location.href = current_url;
    })


//删除成员
    $(document).on('click', ".damageDel", function () {
        var target = $(this);
        layer.confirm("确定删除该成员吗？", {icon: 2}, function (index) {
            $.ajax({
                url: "/StockManage/damageDel",
                data: {id: target.attr("data-id")},
                type: "get",
                dataType: "json",
                success: function (rtn) {
                    if (rtn == 1) {
                        window.location.reload();
                    } else {
                        layer.msg('删除失败');
                    }
                }
            });
        });
    });
});



