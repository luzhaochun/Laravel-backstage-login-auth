<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <link href="/css/select.css" rel="stylesheet" type="text/css" />
        <link href="/js/jquery-ui-1.11.4.dialog/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/auth/menulist.js')}}"></script>
    </head>
    <body>
        <div class="place">
            <span>位置：</span>
            <ul class="placeul">
                <li><a href="{{url('/index/index')}}">首页</a></li>
                <li><a href="#">系统管理</a></li>
                <li><a href="#">菜单列表</a></li>
            </ul>
        </div>
        <div class="rightinfo">
            <div class="tools">
                <ul class="toolbar">
                    <li id="add_menu" class="add_menu"><span><img src="/images/t01.png" /></span>新增菜单</li>
                </ul>
            </div>
            <table class="tablelist">
                <thead>
                    <tr>
                        <th style="width: 8%">排序</th>
                        <th style="width: 8%;text-align:center;">ID</th>
                        <th style="width: 20%">名称</th>
                        <th>标题</th>
                        <th style="width: 8%;text-align:center;">状态</th>
                        <th style="width: 12%;text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($list)){
                            foreach($list as $item){ ?>
                            <tr>
                                <td>
                                    <input style="border:1px solid buttonface;border-radius: 2px;" class="input-text menu_sort_edit" value="<?php echo $item['sort'];?>" name="sort" data-value="<?php echo $item['sort'];?>" data-id="<?php echo $item['id'];?>" size="10">
                                </td>
                                <td style="width: 8%;text-align:center;"><?php echo $item['id'];?></td>
                                <td><?php echo $item['module'];?></td>
                                <td><?php echo $item['nodeName'];?></td>
                                <td style="cursor: pointer;color:red;width: 8%;text-align:center; " class="link_menu_status" data-id="<?php echo $item['id'];?>"><?php echo $item['display']==1 ? '显示': '不显示';?></td>
                                <td class="hidden-xs" style="width: 12%;text-align:center;">
                                    <div class="btn-group" style="margin: 0 10px 0px 0px;">
                                        <a href="#" class="tablelink add_sub_menu" data-id="<?php echo $item['id'];?>">添加子菜单</a>
                                        <a href="#" class="tablelink edit_menu" data-id="<?php echo $item['id'];?>">编辑</a>
                                        <a href="#" class="tablelink del_menu" data-id="<?php echo $item['id'];?>">删除</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } }else{ ?>
                        <tr>
                            <td colspan="6">暂无查询数据，请添加菜单！</td>
                        </tr>
                        <?php } ?>
                    </tr> 

                </tbody>
            </table>
        
        </div>
    </body>

</html>
