<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <link href="/css/select.css" rel="stylesheet" type="text/css" />
        <link href="/js/jquery-ui-1.11.4.dialog/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/util.js"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="/js/backstage/auth/role.js"></script>
    </head>
    <body>
        <div class="place">
            <span>位置：</span>
            <ul class="placeul">
                <li><a href="{{url('/index/index')}}">首页</a></li>
                <li><a href="#">系统管理</a></li>
                <li><a href="#">角色列表</a></li>
            </ul>
        </div>
        <div class="rightinfo tab-content">
            <div class="tools">
                <ul class="toolbar">
                    <li id="add_menu" class="add_menu"><a href="/AuthGroup/add"><span><img src="/images/t01.png" /></span>新增角色</a></li>
                </ul>
            </div>
            <table class="tablelist">
                <thead>
                    <tr>
                        <tr>
                            <th style="width:2%;padding-left: 5px;"><input type="checkbox" value="" id="check_box" style="display: block;"></th>
                            <th style="width:38%;">角色名称</th>
                            <th style="width:38%;">角色状态</th>
                            <th>成员列表</th>
                            <th class="hidden-xs">权限列表</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($groupList)){
                            foreach($groupList as $item){ ?>
                            <tr>
                                <td style="text-align:center;padding-left: 5px;">
                                    <input data-id="<?php echo $item['id'];?>" type="checkbox" value="" style="display: block;" />
                                </td>
                                <td style="width: 8%;">
                                    <span id="link_edit_div">
                                        <span style="display: inline;"><?php echo $item['name'];?></span>
                                        <a href="javascript:;" class="text-link role_name_edit" style="color:blue;">编辑</a>
                                    </span>
                                    <div id="link_save_div" style="display:none;">
                                        <input style="border: 1px solid buttonface;border-radius: 2px;height: 22px;" type="text" id="input_<?php echo $item['id'];?>" data-id="<?php echo $item['id'];?>" name="title" value="<?php echo $item['name'];?>" />
                                        <a class="text-link role_name_save" href="javaScript:;" style="color:blue;">保存</a>
                                    </div>
                                </td>
                                <td><a href="javascript:;" style="color:red;" data-id="<?php echo $item['id'];?>" class="link_role_status"><?php echo $item['status'] == '1' ? '启用' : '禁用'; ?></a></td>
                                <td><span data-id="<?php echo $item['id'];?>" class="btn_scan_admin" style="cursor:pointer;color:#009999">查看成员</span></td>
                                <td class="hidden-xs" style="width: 12%;text-align:center;">
                                    <span type="button" data-id="<?php echo $item['id'];?>" style="cursor:pointer;color:#009999" class="btn_select_auth">选择权限</span>
                                </td>
                            </tr>
                        <?php } }else{ ?>
                        <tr>
                            <td colspan="6">暂无查询数据，请添加角色！</td>
                        </tr>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
            <?php if(!empty($groupList)){ ?>
            <div style="margin-top:13px;">
                <label for="check_box">全选/取消</label> <input type="submit" class="btn btn-danger-outline" name="dodelete" id="dodelete" value="删除">
                <span style="color:#ff0000;display:initial;">(请勿修改管理员组状态)</span>
            </div>
            <?php } ?>
        </div>
    </body>

</html>
