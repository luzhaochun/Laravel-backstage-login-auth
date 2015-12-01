<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>无标题文档</title>
        <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/jscal2.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/border-radius.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/win2k.css') }}"/>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/push/useredit.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/util.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/backstage/apply/apply.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>       
        <script type="text/javascript" src="{{ URL::asset('/js/calendar/calendar.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('/js/calendar/lang/en.js') }}"></script>
 
    </head>
    <body>
        <div style="margin-top: 30px;margin-left: 30px;">
            <form id="saveStaff" class="formbody" action="{{url('/Pushuser/edit')}}" method="post">
                <ul class="forminfo uew-select">
                    <li>
                        <span>真实姓名</span>
                        <input id='name' name="name" class="dfinput" value="{{$staff->name}}" placeholder="真实姓名"/>
                         <label id="name-error" class="error" for="name"></label>
                         <input id="id" type="hidden" value="{{$staff->id}}" name="id"></input>
                     </li>
                    <li>
                        <span>登陆ID</span>
                        <input id="login_id" name="login_id" class="dfinput" value="{{$staff->login_id}}" placeholder="登陆ID"/>
                        <label id="login_id-error" class="error" for="login_id"></label>                        
                    </li>
                    <li>
                        <span>登陆密码</span>
                        <input id="login_pwd" name="login_pwd" class="dfinput" value="" type="password" placeholder="登陆密码"/>
                        <label id="login_pwd-error" class="error" for="login_pwd"></label>
                        
                    </li>
                    <li>
                        <span>确认密码</span>
                        <input id="confirmpwd" name="confirmpwd" class="dfinput" value="" type="password" placeholder="确认密码"/>
                        <label id="confirmpwd-error" class="error" for="confirmpwd"></label>
                        
                    </li>
                    <li>
                        <span>手机号码</span>
                        <input name="phone" id="phone" type="text" class="dfinput" value="{{$staff->phone}}" placeholder="手机号码"/>
                        <label id="phone-error" class="error" for="phone"></label>
                        
                    </li>
                    <li>
                        <span>生日</span>
                        <input name="birthday" id="apply_start_time" value="{{$staff->birthday}}" type="text" class="date scinput"></input>
                    </li>
                    <li>
                        <span>性别</span>                     
                        <cite>
                            <input type="radio" name="sexuality" value="1" @if($staff->sexuality==1)checked="checked "@endif> 男</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="sexuality" value="2" @if($staff->sexuality==2)checked="checked "@endif> 女</input>
                        </cite>
                    </li>
                    <li>
                        <span>是否活动</span>
                        <cite>
                            <input type="radio" name="is_active" value="1" @if($staff->is_active==1)checked="checked "@endif> 正常</input>&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="is_active" value="0" @if($staff->is_active==0)checked="checked "@endif> 冻结</input>
                        </cite>
                        
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
 <script>
     Calendar.setup({
                    weekNumbers: true,
                    inputField : "apply_start_time",
                    trigger    : "apply_start_time",
                    dateFormat: "%Y-%m-%d %H:%M:%S",
                    showTime: true,
                    minuteStep: 1,
                    onSelect   : function() {this.hide();}
                });
</script>