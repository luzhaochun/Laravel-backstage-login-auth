<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="/js/backstage/auth/rulelist.js"></script>
    </head>
    <body style="min-width: 500px;">
        <div class="rightinfo tab-content">
            <form name="myform" action="{{url('/AuthGroup/rulelist')}}" method="post" id="myform">
                <table class="tablelist">
                    <thead>
                        <tr>
                            <tr>
                                <th style="width:2%;padding-left: 5px;"><input type="checkbox" id="check_box"/>全选</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list as $vo){ ?>
                            <tr data-child="<?php echo $vo['hasChild'];?>"
                                <?php echo $vo['level'] == 0 ? "class=\"top_level\"" : "class=\"low_level\"";?>
                                data-level="<?php echo $vo['level'];?>">
                                <td style='border-top: 1px solid #ddd;padding-left:<?php echo (30+$vo['level']*30);?>px;'>
                                <span style="padding-left: 20px;display: initial;" class="collexpa <?php if($vo['hasChild']>0) echo "collapser";?>"></span>
                                    <input <?php echo !empty($vo['flag']) ? 'checked':''; ?> type='checkbox' name='addRuleIds[]' value="<?php echo $vo['id'];?>"
                                        level="<?php echo $vo['level'];?>"
                                        <?php if(!empty($vo['flag']) && $vo['flag'] == 1){ echo " checked";} ?>
                                        onclick='javascript:checknode(this);'><?php echo $vo['nodeName'];?>
                                        <input type='hidden' name='allRuleIds[]' value='<?php echo $vo['id'];?>'>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" class="aui_footer">
                                <div></div>
                                <div style="float:right;" class="aui_buttons">
                                    <input type="hidden" value="<?php echo $id;?>" id="id" name="id" />
                                    <button type="button" class="btn btn-success btn-sm btn_auth_save">确定</button>
                                    <button type="button" class="btn btn-danger btn-sm btn_auth_close">关闭</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </body>

</html>
