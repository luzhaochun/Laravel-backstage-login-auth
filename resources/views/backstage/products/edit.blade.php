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
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li><a href="/Product/index">产品列表</a></li>
        <li>编辑</li>
    </ul>
</div>
<div class="formbody">
    <div id="usual1" class="usual">
        <div class="itab">
            <ul>
                <li><a href="#tab1" class="selected">基本信息</a></li>
                <li><a href="#tab2">价格信息</a></li>
                <li><a href="#tab3">详细信息</a></li>
                <li><a href="#tab4">其他信息</a></li>
            </ul>
        </div>
        <div id="tab1" class="tabson">
            <ul class="forminfo">
                <li><span>产品名称<b>*</b></span>
                    <input id="product_name" name="product_name" class="dfinput" placeholder="产品名称" disabled value="{{$editProductInfo->product_name}}" style="width:518px;"/>
                </li>
                <li><span>英文名称</span>
                    <input id="en_product_name" name="en_product_name" value="{{$editProductInfo->en_product_name}}" class="dfinput" placeholder="英文名称" style="width:518px;"/>
                </li>
                <li><span>产品编号<b>*</b></span>
                    <input id="product_sn" name="product_sn" disabled value="{{$editProductInfo->product_sn}}" class="dfinput" placeholder="产品编号" style="width:518px;"/>
                </li>
                <li><span>产品类型</span>
                    <cite>
                        <input name="type" type="radio" value="0" <?php echo empty($editProductInfo->type) ? 'checked="checked"' : '';?> />普通销售产品
                        <input name="type" type="radio" value="1" <?php echo $editProductInfo->type=='1' ? 'checked="checked"' : '';?> />免费抽奖产品
                        <input name="type" type="radio" value="2" <?php echo $editProductInfo->type=='2' ? 'checked="checked"' : '';?> />新品预热
                    </cite>
                </li>

                <!-- 新品预热模块 -->
                <div id="new_product_preheating" style="border:1px solid #ddd;display: block;">
                    <div class="form-group">
                        <label for="dtp_input1" class="col-md-2 control-label">新品预热开始时间<label style="color:red;">*</label></label>
                        <div class="input-group date form_datetime col-md-2" data-date="{{$editProductInfo->new_start_time}}" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="new_start_time">
                            <input name="new_start_time" id="new_start_time" class="form-control" size="16" type="text" value="{$info.new_start_time}" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input1" value="" />
                        <label for="new_start_time" class="error"></label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">新品预热天数<label style="color:red;">*</label></label>
                        <div class="col-md-4">
                            <select class="select2able" name="preheating_days" id="preheating_days">
                                <option value="0">请选择天数</option>
                                <?php foreach($init_preheating_days as $day):?>
                                <option value="<?php echo $day; ?>" <?php if($info['preheating_days'] == $day): ?> selected="selected" <?php endif;?> ><?php echo $day; ?>天</option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">新品预热预计结束时间</label>
                        <div class="col-md-4">
                            <input class="form-control" disabled  value="{$info.end_start_time}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">预热期折扣率(%)<label style="color:red;">*</label></label>
                        <div class="col-md-7">
                            <span style="line-height:35px;float:left;vertical-align: middle;">第1天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text" name="preheat_discount_rate[1]" value="{$info.preheat_discount_rate.1}">
                            </div>
                            <span style="line-height:35px;float:left;vertical-align: middle;">第2天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text"  name="preheat_discount_rate[2]" value="{$info.preheat_discount_rate.2}">
                            </div>
                            <span style="line-height:35px;float:left;vertical-align: middle;">第3天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text" name="preheat_discount_rate[3]" value="{$info.preheat_discount_rate.3}">
                            </div>
                            <span style="line-height:35px;float:left;vertical-align: middle;">第4天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text" name="preheat_discount_rate[4]" value="{$info.preheat_discount_rate.4}">
                            </div>
                            <span style="line-height:35px;float:left;vertical-align: middle;">第5天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text" name="preheat_discount_rate[5]" value="{$info.preheat_discount_rate.5}">
                            </div>
                            <span style="line-height:35px;float:left;vertical-align: middle;">第6天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text" name="preheat_discount_rate[6]" value="{$info.preheat_discount_rate.6}">
                            </div>
                            <span style="line-height:35px;float:left;vertical-align: middle;">第7天</span>
                            <div class="col-md-1">
                                <input class="form-control" placeholder="折扣率" type="text" name="preheat_discount_rate[7]" value="{$info.preheat_discount_rate.7}">
                            </div>
                        </div>
                    </div>
                </div>

                <li><span>是否促销</span>
                    <cite>
                        <input name="is_promotion" type="radio" value="1"/>是
                        <input name="is_promotion" type="radio" value="0" checked="checked"/>否
                    </cite>
                </li>
                <li><span>产品推荐位置</span>
                    @if(!empty($positionList))
                        <cite style="padding-bottom: 9px;">
                        @foreach($positionList as $item)
                            <input name="recommand_position[]" id="recommand_position[{{$item->id}}]" type="checkbox" value="{{$item->id}}"/>{{$item->position_name}}
                        @endforeach
                        </cite>
                    @endif
                </li>
                <li><span>产品功效类别</span>
                    @if(!empty($productFuncList))
                        <cite>
                            @foreach($productFuncList as $item)
                                <input name="cate[]" id="cate[{{$item->id}}]" type="checkbox" value="{{$item->id}}"/>{{$item->cat_name}}
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
                <li>
                    <span>&nbsp;</span><label class="error">注：文件大小不得超过200KB</label>
                </li>
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
                            <div class="uew-select-value ue-state-default" style="width: 320px;">
                                <em class="uew-select-text"><?=!empty($supplierList) ? $supplierList[0]->supplier_name : ''?></em>
                                <em class="uew-icon uew-icon-triangle-1-s"></em>
                            </div>
                            <select id="roleSelect" name="role_id" class="select1" style="width: 345px;">
                                <option value="">--</option>
                                @foreach($supplierList as $item)
                                    <option value="<?=$item->id?>" <?=!empty($groupList[0]) && $groupList[0]->id == $item->id ? 'selected="selected"' : ''?>><?=$item->supplier_name?></option>
                                @endforeach
                            </select></div>
                    </div>
                </li>
                <li><span>赠送积分</span>
                    <input id="score" name="score" type="text" class="dfinput" placeholder="赠送积分" style="width:518px;"/>
                </li>
                <li><span>允许积分购买</span>
                    <cite>
                        <input name="is_allow_score_buy" type="radio" value="1" checked="checked"/>是
                        <input name="is_allow_score_buy" type="radio" value="0"/>否
                    </cite>
                </li>
                <li><span>积分购买限制</span>
                    <cite>
                        <input name="score_purchase_limit" type="radio" value="1" checked="checked"/>不限制
                        <input name="score_purchase_limit" type="radio" value="0"/>限制
                    </cite>
                </li>
                <li><span>是否上限</span>
                    <cite>
                        <input name="is_online" type="radio" value="1" checked="checked"/>是
                        <input name="is_online" type="radio" value="0"/>否
                    </cite>
                </li>
                <li><span>&nbsp;</span>
                    <input type="button" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:history.go(-1);"><input type="button" class="cancel" value="返回"/></a>
                    <label class="submit-msg"></label>
                </li>
            </ul>
        </div>
        <div id="tab2" class="tabson">
            <ul class="forminfo">
                <li><span>市场价<b>*</b></span>
                    <input id="market_price" name="market_price" type="text" class="dfinput" placeholder="市场价" style="width:518px;"/>
                </li>
                <li><span>销售价格<b>*</b></span>
                    <input id="price" name="price" type="text" class="dfinput" placeholder="销售价格" style="width:518px;"/>
                </li>
                <li><span>促销价格<b>*</b></span>
                    <input id="promotion_price" name="promotion_price" type="text" class="dfinput" placeholder="促销价格" style="width:518px;"/>
                </li>
                <li><span>批发价<b>*</b></span>
                    <input id="wholesale_price" name="wholesale_price" type="text" class="dfinput" placeholder="批发价" style="width:518px;"/>
                </li>
                <li><span>产品成本价<b>*</b></span>
                    <input id="product_cost_price" name="wholesale_price" type="text" class="dfinput" placeholder="产品成本价" style="width:518px;"/>
                </li>
                <li><span>外包装费</span>
                    <input id="outer_packing_charge" name="outer_packing_charge" type="text" class="dfinput" placeholder="外包装费" style="width:518px;"/>
                </li>
                <li><span>瓶装费</span>
                    <input id="bottled_charge" name="bottled_charge" type="text" class="dfinput" placeholder="瓶装费" style="width:518px;"/>
                </li>
                <li><span>&nbsp;</span>
                    <input type="button" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:history.go(-1);"><input type="button" class="cancel" value="返回"/></a>
                    <label class="submit-msg"></label>
                </li>
            </ul>
        </div>
        <div id="tab3" class="tabson">
            <ul class="forminfo">
                <li><span>产品简介<b>*</b></span>
                    <input id="brief" name="brief" type="text" class="dfinput" placeholder="产品简介" style="width:518px;"/>
                </li>
                <li><span>产品图片</span>
                    <div class="formDiv" style="width: 492px; border-radius: 1px;  height: auto; border-top: solid 1px #a7b5bc; border-left: solid 1px #a7b5bc; border-right: solid 1px #ced9df; border-bottom: solid 1px #ced9df; font-size: 12px; padding: 13px; background: url(/images/inputbg.gif) repeat-x">
                        <span id="spanButtonPlaceholder"></span>
                        <div id="divFileProgressContainer"></div>
                        <div id="thumbnails">
                            <ul id="pic_list" style="margin: 5px;">
                            </ul>
                            <label class="error">注：文件大小不得超过200KB</label>
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
                    <div class="formDiv"><script type="text/plain" name="description" id="myEditor" style="width:1000px;height:240px;"></script></div>
                </li>
                <li><span>&nbsp;</span>
                    <input type="button" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:history.go(-1);"><input type="button" class="cancel" value="返回"/></a>
                    <label class="submit-msg"></label>
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
                <li><span>&nbsp;</span>
                    <input type="button" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:history.go(-1);"><input type="button" class="cancel" value="返回"/></a>
                    <label class="submit-msg"></label>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $("#usual1 ul").idTabs();
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
    </script>
</div>
</body>
</html>
