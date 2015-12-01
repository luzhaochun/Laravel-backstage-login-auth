<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>无标题文档</title>
        <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/auth/addarea.js')}}"></script>
    </head>
    <body>
        <div style="margin-top: 30px;margin-left: 30px;">
            <form id="frm_area" class="formbody" action="{{url('/Area/add')}}" method="post">
                <ul class="forminfo uew-select">
                    <li>
                        <span>地区名称</span>
                        <input id="name" name="name" placeholder="地区名称" class="dfinput" value=""/>
                        <label id="name-error" class="error" for="name"></label>
                    </li>
                    <li>
                        <span>地区码（邮编）</span>
                        <input class="dfinput" placeholder="地区码（邮编）" type="text" name="code" id="code">
                        <label id="code-error" class="error" for="code"></label>
                    </li>
                    <li>
                        <span>电话区号：</span>
                        <input class="dfinput" placeholder="电话区号" type="text" name="zone_number" id="zone_number">
                        <label id="zone_number-error" class="error" for="zone_number"></label>
                    </li>
                    <li>
                        <span>状态</span>
                        <cite>
                            <input name="status" type="radio" value="1" checked="checked">可用&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name="status" type="radio" value="0">禁用</cite>
                    </li>
                    <li>
                        <span>选择父地区：</span>                     
                        <select id="parent_id" name="parent_id" class="dfselect">
                            <option value="0">第一层目录</option>
                            <?php
                            foreach ($list as $item) {?>
                                <option value="<?php echo $item['code'];?>"><?php echo $item['nodeName'];?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <li style="padding-left: 82px;">
                        <label>&nbsp;</label><input type="submit" class="sure" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="submit-msg"></label>
                    </li>
                </ul>
            </form>
        </div>
    </body>
</html>