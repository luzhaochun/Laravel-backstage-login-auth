<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎登录益点点后台管理系统</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/js/jquery.js"></script>
<script src="/js/cloud.js" type="text/javascript"></script>
<script src="/js/backstage/login/default.js" type="text/javascript"></script>

</head>
<body style="background-color:#1c77ac; background-image:url(images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  
<div class="logintop">    
    <span>欢迎登录益点点后台管理界面平台</span>    
    <ul>
    <li><a href="#">回首页</a></li>
    <li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    </ul>    
    </div>    
    <div class="loginbody">  
    <span class="systemlogo"></span>
    <form action="/login" method="post" name="frm_login" id="frm_login">   
    {!! csrf_field() !!}    
    <div class="loginbox">  
	    <ul>
		    <li><input name="user_name" id="user_name" type="text" class="loginuser" value="" placeholder="请输入用户名" /></li>  
		    <li><input name="password" id="password" type="password" class="loginpwd" value="" placeholder="密码" /></li>
		    <li><input name="btn_login" id="btn_login" type="submit" class="loginbtn" value="登录" /><label>
		    <input name="remember_me" type="checkbox" value="1" checked="checked" />记住密码</label></li>
		    <li><label id="error_tip" style="padding-left: 1px;color:red;">{{$error}}</label></li>
	    </ul>  
    </div> 
    </form>
    </div>
    <div class="loginbm">版权所有<?php echo date('Y');?>&nbsp;<a href="http://www.yidd365.com/" target="blank" >yidd365.com</a>  仅供学习交流，勿用于任何商业用途</div>  
</body>

</html>
