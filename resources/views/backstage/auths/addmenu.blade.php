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
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/auth/menu.js')}}"></script>
    </head>
    <body>
        <div style="margin-top: 30px;margin-left: 30px;">
            <form id="frm_menu" class="formbody" action="{{url('/AuthGroup/menuAdd')}}" method="post">
                <ul class="forminfo uew-select">
                    <li>
                        <span>名称</span>
                        <input id="module" name="module" class="dfinput" value=""/>
                        <label id="module-error" class="error" for="module"></label>
                    </li>
                    <li>
                        <span>标题</span>
                        <input id="name" name="name" class="dfinput" value=""/>
                        <label id="name-error" class="error" for="name"></label>
                    </li>
                    <li>
                        <span>状态</span>
                        <cite><input name="display" type="radio" value="1" checked="checked">显示&nbsp;&nbsp;&nbsp;&nbsp;<input name="display" type="radio" value="0">不显示</cite>
                    </li>
                    <li>
                        <span>排序</span>
                        <input name="sort" id="sort" type="text" class="dfinput" value=""/>
                        <label id="sort-error" class="error" for="sort"></label>
                    </li>
                    <li>
                        <span>icon样式</span>
                        <input name="new_class" id="new_class" type="text" class="dfinput" value=""/>
                        <label id="new_class-error" class="error" for="new_class"></label>
                    </li>
                    <li>
                        <span>选择父类</span>                     
                        <select id="parent_id" name="parent_id" class="dfselect">
                            <option value="0">第一层目录</option>
                            <?php
                            foreach ($list as $item) {?>
                                <option value="<?php echo $item['id'];?>"
                                <?php if($menuid == $item['id']){ echo " selected ";};?>><?php echo $item['nodeName'];?></option>
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