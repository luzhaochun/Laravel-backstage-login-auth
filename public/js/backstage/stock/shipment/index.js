/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $(".click").click(function () {
        $(".tip").fadeIn(200);
    });
    $(".tiptop a, .sure, .cancel").click(function () {
        $(".tip").fadeOut(200);
    });

    $('.tablelist tbody tr:odd').addClass('odd');
    //$("input[type='checkbox']").selectCheckBox();

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
    });
    
    $("table.tablelist").on('click','.shipment_detail',function(){
        var id = $(this).attr('data-id');
        layer.open({
            title: '出库详细',
            type: 2,
            area: ['600px', '648px'],
            fix: true, //不固定
            maxmin: true,
            btn: ['关闭'],
            cancel: function (index){}, // 取消
            content: '/StockShipment/show?id='+id,
        });
    });
    //出库产品
    $("table.tablelist").on('click','.shipment_products',function(){
        var id = $(this).attr('data-id');
        layer.open({
            title: '出库产品',
            type: 2,
            area: ['600px', '648px'],
            fix: true, //不固定
            maxmin: true,
            btn: ['关闭'],
            cancel: function (index){}, // 取消
            content: '/StockShipment/product_list?id='+id,
        });
    });
    
    $("table.tablelist").on('click','.shipment_remark',function(){
        var id = $(this).attr('data-id');
        var order_no = $(this).attr('data-order_no');
        var remark = $(this).attr('data-remark')
        layer.open({
            title: '出库产品:出货单据号:'+order_no,
            type: 2,
            area: ['600px', '300px'],
            fix: true, //不固定
            maxmin: true,
            content: '/StockShipment/remark?id='+id+'&remark='+remark,
        });
    });
    
})