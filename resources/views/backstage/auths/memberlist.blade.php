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
    <body style="min-width: 500px;">
        <div class="rightinfo tab-content">
            <table class="tablelist">
                <thead>
                    <tr>
                        <tr>
                            <th style="width:2%;padding-left: 5px;"></th>
                            <th style="width:5%;">ID</th>
                            <th style="width:50%;">用户名称</th>
                            <th>角色</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($list)){
                            foreach($list as $item){ ?>
                            <tr>
                                <td style="text-align:center;padding-left: 5px;">
                                    <input disabled type="checkbox" name="xxxx" value="<?php echo $item->id; ?>"
                                           <?php echo $item->flag == 1 ? 'checked' : ''; ?>
                                </td>
                                <td style="width: 8%;">
                                        <span style="display: inline;"><?php echo $item->id;?></span>
                                </td>
                                <td><?php echo $item->user_name;?></td>
                                <td><?php echo $rolelist[$item->role_id];?></td>
                            </tr>
                        <?php } }else{ ?>
                        <tr>
                            <td colspan="6">暂无查询数据，请添加用户！</td>
                        </tr>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
            <?php
                echo $paginator->show();
            ?>
        </div>
    </body>

</html>
