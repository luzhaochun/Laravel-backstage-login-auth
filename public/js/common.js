/**
 * Created by linwenshan on 15/11/19.
 * 公共js
 */

/*
    数据提交，返回错误信息，点击消失错误消息
 */
$(document).ready(function ($) {
    $("div.error_tips").on('click', function () {
        $(this).css('display', 'none');
    })
})


/*
    form表单返回时调用
 */
function confirmAct(){

    var uploadmessage = document.getElementById("uploadMessage");
    if(uploadmessage){
        var message = uploadmessage.innerHTML;
        if(message == undefined || message == '' || message == null){
            history.back();
        }else{
            if(confirm(message))
            {
                //return true;
                history.back();
            }else{
                return false;
            }
        }
    }else{
        history.back();
    }

}