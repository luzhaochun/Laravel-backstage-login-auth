$(document).ready(function ($) {
    /******** 产品列表 ********/
    $('.tablelist tbody tr:odd').addClass('odd');
    // 回车搜索
    $("#searchName").keypress(function (e) {
        if (e.keyCode == 13)
            $(".searchProduct").trigger('click');
    });

    // 产品列表搜索
    $(".searchProduct").on('click', function () {
        window.location = getUrlParams('/Product/index');
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

        window.location = getUrlParams('/Product/index');
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

    $(".tablelist").on('click', 'a.label-danger', function(){
        var id = $(this).attr('rel');
        layer.confirm('确定删除该产品吗？', {
            title: '提示',
            icon: 3,
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: '/Product/del',
                dataType: 'json',
                type: 'post',
                data: {'id': id},
                success: function(data){
                    layer.msg(data.msg, {time: 2500, icon: (data.status == true ? 1 : 5)}, function () {
                        window.location.href = '/Product/index';
                    });
                }
            });
        }, function(){
        });
    });

    jQuery.validator.addMethod("positiveNumber",function(value,element){
        var reg = /(^[1-9]\d*(\.\d{1,2})?$)|(^[0]{1}(\.\d{1,2})?$)/;
        if(Math.abs(value) == 0){ return true;}else{
            return this.optional(element) || (reg.test(value));
        }
    },"请输入正确的价格");

    $("#validate-form-Drugstore").validate({
        rules: {
            product_name: {
                required: true,
                remote: {
                    url: '/Product/checkNameUnique',
                    type: "post",
                    dataType: "json",
                    data:{
                        'product_name': function () {
                            return $("#product_name").val();
                        },
                        'type' : function () {
                            return $("#productAdd").val();
                        }
                    }
                }
            },
            sort :{
                required : true,
                digits : true
            },
            product_sn :{
                required : true
            },
            weight :{
                required : true,
                min : 0
            },
            supplier_id :{
                required : true
            },
            score :{
                min : 0
            },
            market_price :{
                required : true,
                positiveNumber : true
            },
            price :{
                required : true,
                positiveNumber : true
            },
            promotion_price:{
                required : true,
                positiveNumber : true
            },
            wholesale_price :{
                required : true,
                positiveNumber : true
            },
            product_cost_price :{
                required : true,
                positiveNumber : true
            },
            outer_packing_charge :{
                positiveNumber : true
            },
            bottled_charge :{
                positiveNumber : true
            },
            clerk_retail_ratio :{
                digits : true,
                maxlength : 3
            },
            clerk_network_ratio :{
                digits : true,
                maxlength : 3
            },
            drugstore_network_ratio :{
                digits : true,
                maxlength : 3
            },
            partner_retail_ratio :{
                digits : true,
                maxlength : 3
            },
            partner_network_ratio :{
                digits : true,
                maxlength : 3
            },
            business_retail_ratio :{
                digits : true,
                maxlength : 3
            },
            business_network_ratio :{
                digits : true,
                maxlength : 3
            },
            retail_tax_ratio :{
                digits : true,
                maxlength : 3
            },
            network_tax_ratio :{
                digits : true,
                maxlength : 3
            },
            operating_costs_retail_ratio :{
                digits : true,
                maxlength : 3
            },
            operating_costs_network_ratio :{
                digits : true,
                maxlength : 3
            },
            user_retail_ratio :{
                digits : true,
                maxlength : 3
            },
            user_network_ratio :{
                digits : true,
                maxlength : 3
            },
            brief:{
                required:true
            }
        },
        messages: {
            product_name : {
                required:"产品名称不为空",
                remote : "该产品已经存在，请重新输入"
            },
            sort:{
                required : "排序不为空",
                digits : "请输入正整数"
            },
            product_sn :{
                required : "产品编号不为空"
            },
            weight :{
                required : "重量不为空",
                min: "请输入整数"
            },
            supplier_id :{
                required : "请选择供应商"
            },
            score :{
                min : '请输入大于0数字'
            },
            market_price :{
                required : "市场价格不为空"
            },
            price :{
                required :"销售价格不为空"
            },
            promotion_price:{
                required :"促销价格不为空"
            },
            wholesale_price :{
                required : "批发价不为空"
            },
            product_cost_price :{
                required : '产品成本价不为空'
            },
            clerk_retail_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            clerk_network_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            drugstore_network_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            partner_retail_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            partner_network_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            business_retail_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            business_network_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            retail_tax_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            network_tax_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            operating_costs_retail_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            operating_costs_network_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            user_retail_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            user_network_ratio :{
                digits : '请输入正整数',
                maxlength:'输入长度不超过3位'
            },
            brief:{
                required:'产品简介不为空'
            }
        }
    })
});