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
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/auth/arealist.js')}}"></script>
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
                    <li id="add_area"><span><img src="/images/t01.png" /></span>新增地区</li>
                </ul>
            </div>
            <table class="tablelist">
                <thead>
                    <tr>
                        <th style="width: 4%">id</th>
                        <th style="width: 35%;">地区</th>
                        <th>邮编</th>
                        <th>区号</th>
                        <th style="width: 8%;text-align:center;">状态</th>
                        <th style="width: 6%;text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($list)){
                            foreach($list as $item){ ?>
                            <tr>
                                <td><?php echo $item['id'];?></td>
                                <td style="width: 8%;"><?php echo $item['nodeName'];?></td>
                                <td><?php echo $item['code'];?></td>
                                <td><?php echo $item['zone_number'];?></td>
                                <td style="text-align:center;cursor: pointer;color:red; " class="link_menu_status" data-id="<?php echo $item['id'];?>"><?php echo $item['status']==1 ? '可用': '禁用';?></td>
                                <td class="hidden-xs" style="width: 6%;text-align:center;">
                                    <div class="btn-group" style="margin: 0 10px 0px 0px;">
                                        <a href="#" class="tablelink edit_area" data-id="<?php echo $item['id'];?>">编辑</a>
                                        <a href="#" class="tablelink del_area" data-id="<?php echo $item['id'];?>">删除</a>
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
