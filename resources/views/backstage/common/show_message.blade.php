<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>提示</title>
<style type="text/css">
<!--
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
.showMsg h5{background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ padding:46px 12px 10px 45px; font-size:14px; height:64px; text-align:left}
.showMsg .bottom{ background:#e4ecf7; margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
.showMsg .ok,.showMsg .guery{background: url(/msg_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
-->
</style>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>

    <script style="text/javascript">
        function redirect(url){
            location.href = url;
        }
        function dialog_close(index){
            window.top.rightFrame.location.reload();
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }
    </script>
</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5>提示</h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:330px"><?php echo $msg?></div>
    <div class="bottom">
    <?php if(($url_forward=='goback' || $url_forward=='') && $layer_index == 0) {?>
        <a href="javascript:history.back();" >[点击这里返回上一页]</a>
	<?php } elseif($url_forward=="close") {?>
	<input type="button" name="close" value="<?php echo L('close');?> " onClick="window.close();">
	<?php } elseif($url_forward=="blank") {?>
	
	<?php } elseif($url_forward) {
	?>
	<a href="<?php echo $url_forward?>">点击这里跳转</a>
	<script language="javascript">setTimeout("redirect('<?php echo $url_forward?>');",<?php echo $timeout ?>);</script>
	<?php }?>

	<?php if ($layer_index):?><script style="text/javascript">setTimeout("dialog_close(<?php echo $layer_index ?>);",<?php echo $timeout ?>);</script><?php endif;?>
        </div>
</div>

</body>
</html>