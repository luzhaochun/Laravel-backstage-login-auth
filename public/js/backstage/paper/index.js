
$(document).ready(function ($) {

    $('.tablelist tbody tr:odd').addClass('odd');

    $(".tablelist .itemdelete").on('click', function(){
        var id = $(this).closest('tr').find('td.itemid').text();
        layer.confirm('确定删除该题卷吗？', {
            title: '提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: '/PaperRoll/del',
                dataType: 'json',
                type: 'post',
                data: {'id': id},
                success: function(data){
                    if(data.status == true)
                        layer.msg(data.msg, {time: 2000, icon: 1}, function () {
                            window.location = '/PaperRoll/index';
                        });
                    else
                        layer.msg(data.msg, {time: 3000, icon: 5}, function () {
                            window.location = '/PaperRoll/index';
                        });
                }
            });

        }, function(){
        });
    });




    //加载题库选择页面

    $(document).on('click', '.btn_scan_admin', function () {
        var _id = $(this).attr('data-id');
        layer.open({
            btn:['提交','取消'],
            title: '题库列表',
            type: 2,
            area: ['500px', '500px'],
            fix: false, //不固定
            maxmin: true,
            content: "/PaperRoll/check_paper?id=" + _id,
            yes: function(index, layero){ //或者使用btn1
                var formData = layer.getChildFrame('body');
                var subCheckedIds = formData.find('#sub_ids').val();
                var paperId = formData.find('#paperId').val();
                $.ajax({
                    type:'post',
                    data:'sub_ids='+subCheckedIds+'&id='+paperId,
                    url:'/PaperRoll/saveData',
                    success:function(data){
                        var json = eval("(" + data + ")");
                        layer.msg(json.message, {time: 2500, icon: (json.status == true ? 1 : 5)}, function () {
                            window.location = '/PaperRoll/index';
                        });
                    }
                })
            },cancel: function(index){ //或者使用btn2
                layer.closeAll();
            }
        });
    });


    //加载企业选择页面

    $(document).on('click', '.searchCompany', function () {
        var _id = $(this).attr('data-id');
        layer.open({
            btn:['选择','取消'],
            title: '企业列表',
            type: 2,
            area: ['500px', '500px'],
            fix: false, //不固定
            maxmin: true,
            content: "/PaperRoll/searchCompany?id=" + _id,
            yes: function(index, layero){ //或者使用btn1
                var formData = layer.getChildFrame('body');
                $('#company_id').val(formData.find('#chooseId').val());
                $('#company_name').val(formData.find('#chooseName').val());
                layer.closeAll();
            },cancel: function(index){ //或者使用btn2
                layer.closeAll();
            }
        });
    });


    //搜索企业数据
    $(document).on('click','.searchCompanyName',function(){
            var searname = $('#companyNameSearch').val();
            $.ajax({
                type:'post',
                url:'/PaperRoll/searchCompany',
                datatype : 'json',
                data:'searName='+searname,
                success:function(data){
                    var json = eval("(" + data + ")");
                    $('.checkboxType').html(json.str);
                }
            })
    })


    /**
     *    选择题库方式 OR 固定    start
     *     lws
     *     2015年11月19日17:22:06
     */
    $('input:radio[name="is_random"]').click(function(){
        cur = $(this).val();
        if(cur == 1){
            $('.choose_number').show();
        }else{
            $('.choose_number').hide();
        }
    });
    var is_random = $("input[name='is_random']:checked").val();
    if(is_random == 1){
        $('.choose_number').show();
    }else{
        $('.choose_number').hide();
    }
    /*   选择题库方式 OR 固定    end  */



    /*
     * 表单验证
     */
    $("#addAdminForm,#addForm").validate({
        ignore:"",
        rules: {
            paper_name:{
                required:true
            },
            company_id :{
                required:true
            },
            'getway\[\]': {
                required:true
            }
        },
        messages: {
            paper_name : "题卷名称必填",
            company_id: "企业必填",
            'getway\[\]':"请选择一个题库"
        }
    });


});