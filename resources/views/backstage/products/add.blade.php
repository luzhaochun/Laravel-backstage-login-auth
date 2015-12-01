<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>益点点后台管理系统 - {{$title}}</title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/css/select.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" charset="utf-8">
        window.UEDITOR_HOME_URL = "/ueditor/";
    </script>
    <script type="text/javascript" src="{{ URL::asset('/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/ueditor/ueditor.all.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.idTabs.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/select-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/swf-upload/js/swfupload.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/swf-upload/js/handlers.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/product/product.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/jscal2.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/border-radius.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/win2k.css') }}"/>
    <script type="text/javascript" src="{{ URL::asset('/js/calendar/calendar.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/calendar/lang/en.js') }}"></script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/Product/index">产品列表</a></li>
        <li>添加</li>
    </ul>
</div>
<div class="formbody">
    <form id="validate-form-Drugstore" class="usual" action="{{url('/')}}" method='post' enctype="multipart/form-data">
        <div class="itab">
            <ul>
                <li><a href="#tab1" class="selected">基本信息</a></li>
                <li><a href="#tab2">价格信息</a></li>
                <li><a href="#tab3">详细信息</a></li>
                <li><a href="#tab4">其他信息</a></li>
            </ul>
        </div>
        <div id="tab1" class="tabson">
            <ul class="forminfo productBasicInfo">
                <li><span>产品名称<b>*</b></span>
                    <input id="product_name" name="product_name" type="text" class="dfinput" placeholder="产品名称" style="width:518px;"/>
                </li>
                <li><span>英文名称</span>
                    <input id="en_product_name" name="en_product_name" type="text" class="dfinput" placeholder="英文名称" style="width:518px;"/>
                </li>
                <li><span>产品编号<b>*</b></span>
                    <input id="product_sn" name="product_sn" type="text" class="dfinput" placeholder="产品编号" style="width:518px;"/>
                </li>
                <li><span>产品类型</span>
                    <cite>
                        <input name="type" type="radio" value="0" checked="checked"/> 普通销售产品&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="type" type="radio" value="1"/> 免费抽奖产品&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="type" type="radio" value="2"/> 新品预热&nbsp;&nbsp;&nbsp;&nbsp;
                    </cite>
                </li>

                <!-- 新品预热模块 -->
                <div id="new_product_preheating" style="display: none;">
                    <li><span>新品预热开始时间<b>*</b></span>
                        <input name="apply_start_time" style="width: 252px;" readonly id="apply_start_time" placeholder="新品预热开始时间" class="date scinput">
                    </li>
                    <li style="margin-top: 10px;"><span>新品预热天数<b>*</b></span>
                        <div class="vocation">
                            <div class="uew-select">
                                <div class="uew-select-value ue-state-default" style="width: 252px; padding: 0px;"></div>
                                <select id="dayNumSelect" name="role_id" class="select1" style="width: 252px; top: 1px; height: 32px;">
                                    <option value="0">请选择天数</option>
                                    @foreach($init_preheating_days as $day)
                                        <option value="{{$day}}">{{$day.'天'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </li>
                    <li><span>新品预热结束时间</span>
                        <input name="apply_end_time" style="width: 252px;" disabled="disabled" id="apply_end_time" placeholder="新品预热预计结束时间" class="date scinput">
                    </li>
                    <li><span>预热期折扣率(%)<b>*</b></span>
                        <div>
                            @foreach($init_preheating_days as $day)
                                第{{$day}}天
                                <input class="discountInput" placeholder="折扣率" name="preheat_discount_rate[{{intval($day)}}]">
                            @endforeach
                        </div>
                    </li>
                </div>
                <li><span>是否促销</span>
                    <cite>
                        <input name="is_promotion" type="radio" value="1"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="is_promotion" type="radio" value="0" checked="checked"/> 否&nbsp;&nbsp;&nbsp;&nbsp;
                    </cite>
                </li>
                <li><span>产品推荐位置</span>
                    @if(!empty($positionList))
                        <cite style="padding-bottom: 9px;">
                        @foreach($positionList as $item)
                            <input name="recommand_position[]" id="recommand_position[{{$item->id}}]" type="checkbox" value="{{$item->id}}"/> {{$item->position_name}}&nbsp;&nbsp;&nbsp;&nbsp;
                        @endforeach
                        </cite>
                    @endif
                </li>
                <li><span>产品功效类别</span>
                    @if(!empty($productFuncList))
                        <cite>
                            @foreach($productFuncList as $item)
                                <input name="cate[]" id="cate[{{$item->id}}]" type="checkbox" value="{{$item->id}}"/> {{$item->cat_name}}&nbsp;&nbsp;&nbsp;&nbsp;
                            @endforeach
                        </cite>
                    @endif
                </li>
                <li><span>产品规格</span>
                    <input id="product_specifications" name="product_specifications" type="text" class="dfinput" placeholder="产品规格" style="width:518px;"/>
                </li>
                <li><span>包装规格</span>
                    <input id="packing_specifications" name="packing_specifications" type="text" class="dfinput" placeholder="包装规格" style="width:518px;"/>
                </li>
                <li><span>商品图片</span>
                    <cite><input id="image" name="image" type="file"/></cite>
                </li>
                <li><span>&nbsp;</span><label style="color: #ff0000;">注：文件大小不得超过200KB</label></li>
                <li><span>库存</span>
                    <input id="stock_number" name="stock_number" type="text" class="dfinput" placeholder="库存" style="width:518px;"/>
                </li>
                <li><span>重量<b>*</b></span>
                    <input id="weight" name="weight" type="text" class="dfinput" placeholder="重量" style="width:518px;"/>
                </li>
                <li><span>排序<b>*</b></span>
                    <input id="sort" name="sort" type="text" class="dfinput" placeholder="排序" style="width:518px;"/>
                </li>
                <li><span>供应商<b>*</b></span>
                    <div class="vocation">
                        <div class="uew-select">
                            <div class="uew-select-value ue-state-default" style="width: 518px; padding: 0px;"></div>
                            <select id="supplier_id" name="supplier_id" class="select1" style="width: 518px; top: 1px; height: 32px;">
                                <option value="">请选择供应商</option>
                                @foreach($supplierList as $item)
                                    <option value="<?=$item->id?>" <?=!empty($groupList[0]) && $groupList[0]->id == $item->id ? 'selected="selected"' : ''?>><?=$item->supplier_name?></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <label id="supplier_id-error" class="error" for="supplier_id"></label>
                </li>
                <li><span>赠送积分</span>
                    <input id="score" name="score" type="text" class="dfinput" placeholder="赠送积分" style="width:518px;"/>
                </li>
                <li><span>允许积分购买</span>
                    <cite>
                        <input name="is_allow_score_buy" type="radio" value="1" checked="checked"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="is_allow_score_buy" type="radio" value="0"/> 否&nbsp;&nbsp;&nbsp;&nbsp;
                    </cite>
                </li>
                <li><span>积分购买限制</span>
                    <cite>
                        <input name="score_purchase_limit" type="radio" value="1" checked="checked"/> 不限制&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="score_purchase_limit" type="radio" value="0"/> 限制&nbsp;&nbsp;&nbsp;&nbsp;
                    </cite>
                </li>
                <li><span>是否上限</span>
                    <cite>
                        <input name="is_online" type="radio" value="1" checked="checked"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="is_online" type="radio" value="0"/> 否&nbsp;&nbsp;&nbsp;&nbsp;
                    </cite>
                </li>
            </ul>
        </div>
        <div id="tab2" class="tabson">
            <ul class="forminfo productPriceInfo">
                <li><span>市场价<b>*</b></span>
                    <input id="market_price" name="market_price" class="dfinput" placeholder="市场价" style="width:518px;"/>
                </li>
                <li><span>销售价格<b>*</b></span>
                    <input id="price" name="price" class="dfinput" placeholder="销售价格" style="width:518px;"/>
                </li>
                <li><span>促销价格<b>*</b></span>
                    <input id="promotion_price" name="promotion_price" class="dfinput" placeholder="促销价格" style="width:518px;"/>
                </li>
                <li><span>批发价<b>*</b></span>
                    <input id="wholesale_price" name="wholesale_price" class="dfinput" placeholder="批发价" style="width:518px;"/>
                </li>
                <li><span>产品成本价<b>*</b></span>
                    <input id="product_cost_price" name="product_cost_price" class="dfinput" placeholder="产品成本价" style="width:518px;"/>
                </li>
                <li><span>外包装费</span>
                    <input id="outer_packing_charge" name="outer_packing_charge" class="dfinput" placeholder="外包装费" style="width:518px;"/>
                </li>
                <li><span>瓶装费</span>
                    <input id="bottled_charge" name="bottled_charge" class="dfinput" placeholder="瓶装费" style="width:518px;"/>
                </li>
            </ul>
        </div>
        <div id="tab3" class="tabson">
            <ul class="forminfo productDetailInfo">
                <li><span>产品简介<b>*</b></span>
                    <input id="brief" name="brief" type="text" class="dfinput" placeholder="产品简介" style="width:518px;"/>
                </li>
                <li><span>产品图片</span>
                    <div class="formDiv">
                        <span id="spanButtonPlaceholder"></span>
                        <div id="divFileProgressContainer"></div>
                        <div id="thumbnails">
                            <ul id="pic_list" style="margin: 5px;">
                            </ul>
                            <label style="color: #ff0000;">注：文件大小不得超过200KB</label>
                        </div>
                    </div>
                    <input type="hidden" value="" name="photo_album" id="photo_album" />
                </li>
                <li><span>seo标题</span>
                    <input id="meta_title" name="meta_title" type="text" class="dfinput" placeholder="seo标题" style="width:518px;"/>
                </li>
                <li><span>seo关键词</span>
                    <input id="meta_keywords" name="meta_keywords" type="text" class="dfinput" placeholder="seo关键词" style="width:518px;"/>
                </li>
                <li><span>seo描述</span>
                    <input id="meta_description" name="meta_description" type="text" class="dfinput" placeholder="seo描述" style="width:518px;"/>
                </li>
                <li><span>产品描述</span>
                    <div style="margin-left: 86px;"><script type="text/plain" name="description" id="myEditor" style="width:1000px;height:240px;"></script></div>
                </li>
            </ul>
        </div>
        <div id="tab4" class="tabson">
            <ul class="forminfo productOtherInfo">
                <li><b>普通商品</b></li>
                <li><span>店员分成零售比例</span>
                    <input id="clerk_retail_ratio" name="clerk_retail_ratio" type="text" class="dfinput" placeholder="店员分成零售比例" style="width:518px;"/> %
                </li>
                <li><span>店员分成网络比例</span>
                    <input id="clerk_network_ratio" name="clerk_network_ratio" type="text" class="dfinput" placeholder="店员分成网络比例" style="width:518px;"/> %
                </li>
                <li><span>药店分成网络比例</span>
                    <input id="drugstore_network_ratio" name="drugstore_network_ratio" type="text" class="dfinput" placeholder="药店分成网络比例" style="width:518px;"/> %
                </li>
                <li><span>地当合作伙伴分成零售比例</span>
                    <input id="partner_retail_ratio" name="partner_retail_ratio" type="text" class="dfinput" placeholder="地当合作伙伴分成零售比例" style="width:518px;"/> %
                </li>
                <li><span>地当合作伙伴分成网络比例</span>
                    <input id="partner_network_ratio" name="partner_network_ratio" type="text" class="dfinput" placeholder="地当合作伙伴分成网络比例" style="width:518px;"/> %
                </li>
                <li><span>业务提成分成零售比例</span>
                    <input id="business_retail_ratio" name="business_retail_ratio" type="text" class="dfinput" placeholder="业务提成分成零售比例" style="width:518px;"/> %
                </li>
                <li><span>业务提成分成网络比例</span>
                    <input id="business_network_ratio" name="business_network_ratio" type="text" class="dfinput" placeholder="业务提成分成网络比例" style="width:518px;"/> %
                </li>
                <li><span>零售增值税率</span>
                    <input id="retail_tax_ratio" name="retail_tax_ratio" type="text" class="dfinput" placeholder="零售增值税率" style="width:518px;"/> %
                </li>
                <li><span>网络增值税率</span>
                    <input id="network_tax_ratio" name="network_tax_ratio" type="text" class="dfinput" placeholder="网络增值税率" style="width:518px;"/> %
                </li>
                <li><span>运营成本分成零售比例</span>
                    <input id="operating_costs_retail_ratio" name="operating_costs_retail_ratio" type="text" class="dfinput" placeholder="运营成本分成零售比例" style="width:518px;"/> %
                </li>
                <li><span>顾客零售积分比例</span>
                    <input id="user_retail_ratio" name="user_retail_ratio" type="text" class="dfinput" placeholder="顾客零售积分比例" style="width:518px;"/> %
                </li>
                <li><span>顾客线上积分比例</span>
                    <input id="user_network_ratio" name="user_network_ratio" type="text" class="dfinput" placeholder="顾客线上积分比例" style="width:518px;"/> %
                </li>

                <li><b>促销商品</b></li>
                <li><span>药店分成比例</span>
                    <input id="promotion_drugstore_ratio" name="promotion_drugstore_ratio" type="text" class="dfinput" placeholder="药店分成比例" style="width:518px;"/> %
                </li>
            </ul>
        </div>
        <ul id="productTabBtn" class="forminfo productBasicInfo">
            <li><span>&nbsp;</span>
                <input type="submit" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:history.go(-1);"><input type="button" class="cancel" value="返回"/></a>
                <label class="submit-msg"></label>
            </li>
        </ul>
        <input type="hidden" id="productAdd" name="productAdd" value="add"/>
    </form>
    <script type="text/javascript">
        $("#validate-form-Drugstore ul").idTabs(function(id, list, set){
            // 保存和返回按钮排版美观
            var ulClass = $(id).find('ul').attr('class').replace('forminfo ','');
            $("#productTabBtn").removeClass().addClass('forminfo ' + ulClass);
            return true;
        });
        $('.tablelist tbody tr:odd').addClass('odd');

        var swfu;
        window.onload = function () {
            swfu = new SWFUpload({
                upload_url: "/Product/uploadImg",
                post_params: {"PHPSESSID": "<?php echo session_id();?>"},
                file_size_limit : "2 MB",
                file_types : "*.jpg;*.png;*.gif;*.bmp",
                file_types_description : "JPG Images",
                file_upload_limit : "100",
                file_queue_error_handler : fileQueueError,
                file_dialog_complete_handler : fileDialogComplete,
                upload_progress_handler : uploadProgress,
                upload_error_handler : uploadError,
                upload_success_handler : uploadSuccess,
                upload_complete_handler : uploadComplete,
                button_image_url : "/js/swf-upload/images/upload.png",
                button_placeholder_id : "spanButtonPlaceholder",
                button_width: 113,
                button_height: 33,
                button_text : '',
                button_text_style : '.spanButtonPlaceholder { font-family: Helvetica, Arial, sans-serif; font-size: 16pt;} ',
                button_text_top_padding: 0,
                button_text_left_padding: 0,
                button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
                button_cursor: SWFUpload.CURSOR.HAND,
                flash_url : "/js/swf-upload/swf/swfupload.swf",
                custom_settings : {
                    upload_target : "divFileProgressContainer"
                },
                debug: false
            });
        };

        var um = UE.getEditor('myEditor', {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下七个
            toolbar: [
                'source | undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |',
                'insertorderedlist insertunorderedlist | selectall cleardoc paragraph | fontfamily fontsize',
                '| justifyleft justifycenter justifyright justifyjustify |',
                'link unlink | image video  | map',
                '| horizontal print preview', 'drafts', 'formula'
            ],
            //focus时自动清空初始化时的内容
            autoClearinitialContent: false,
            //关闭字数统计
            wordCount: false,
            //关闭elementPath
            elementPathEnabled: false,
            //默认的编辑区域高度
            initialFrameHeight: 300
            //更多其他参数，请参考umeditor.config.js中的配置项
        });
        um.render("textarea");

        if($('input:radio[name="type"]:checked').val() == '2'){
            $('#new_product_preheating').show();
        }

        $('input:radio[name="type"]').bind('click', function(){
            if($(this).is(':checked') && $(this).val() == '2'){
                $('#new_product_preheating').show();
            }else{
                $('#new_product_preheating').hide();
            }
        });

        Calendar.setup({
            weekNumbers: true,
            inputField : "apply_start_time",
            trigger    : "apply_start_time",
            dateFormat: "%Y-%m-%d %H:%M:%S",
            showTime: true,
            minuteStep: 1,
            onSelect   : function() {this.hide();}
        });
    </script>
</div>
</body>
</html>
