$(document).ready(function ($) {
    $('.tablelist tbody tr:odd').addClass('odd');
    // 回车搜索
    $("#searchName").keypress(function (e) {
        if (e.keyCode == 13)
            $(".searchAdmin").trigger('click');
    });

    // 管理员列表搜索
    $(".searchAdmin").on('click', function () {
        window.location = getUrlParams('/SystemLogs/loginList');
    });

    // 排序
    $(".tablelist tr").on('click', 'th.sorting', function(){
        var that = $(this);
        var sortType = $("#sortType").val() ? $("#sortType").val() : '';
        var sortName = that.data('sort-name');

        // 排序置空
        $("#sortName").val('');
        $("#sortType").val('');

        // 排序类型
        $("#sortName").val(sortName); // 设置当前点击的排序类型

        if(sortType == 'ASC')
            $("#sortType").val('DESC');
        else
            $("#sortType").val('ASC');

        window.location = getUrlParams('/SystemLogs/loginList');
    });

    // 通过参数获取相应Url
    function getUrlParams(url){
        var sortName = $("#sortName").val();
        var sortType = $("#sortType").val();
        var pageNo = $("#pageNo").val();
        var pageSize = $("#pageSize").val();
        var searchName = $("#searchName").val();
        return url + '?sortName=' + sortName + '&sortType=' + sortType + '&pageNo=' + pageNo + '&pageSize=' + pageSize + '&searchName=' + searchName;
    }
});