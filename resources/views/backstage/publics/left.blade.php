<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>无标题文档</title>
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript" src="/js/jquery.js"></script>
        <script language="JavaScript" src="/js/backstage/left.js"></script>
    </head>

    <body style="background:#f0f9fd;">  
        <div class="lefttop"><span></span>益点点</div>

        <dl class="leftmenu">
            <?php foreach($mainMenu as $item){ ?>
                <dd>
                    <div class="title">
                        <span><img src="/<?php echo $item['new_class'];?>" /></span>
                        <?php if(count($item['sub'])>0){ ?>
                            <?php echo $item['name'];?>
                        <?php }else{ ?>
                            <a href="{{ url($item['module']) }}" target="rightFrame"><?php echo $item['name'];?></a>
                        <?php } ;?>
                    </div>
                    <?php if(count($item['sub'])>0){ ?>
                    <ul class="menuson">
                        <?php foreach($item['sub'] as $v){ ?>
                        <li class="<?php echo strtolower($v['module']) == strtolower($load_url) ? "active" : "";?>">
                            <div class="header">
                                <cite></cite>
                                <a href="{{ url($v['module']) }}" target="rightFrame"><?php echo $v['name'];?></a>
                                <i></i>
                            </div>
                        </li>
                        <?php } ?>
                    </ul> 
                    <?php } ?>
                </dd>
            <?php } ?>
        </dl>
    </body>
</html>
