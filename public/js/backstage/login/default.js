/**
 * 
 */
$(function() {
	$('.loginbox').css({
		'position' : 'absolute',
		'left' : ($(window).width() - 692) / 2
	});
	$(window).resize(function() {
		$('.loginbox').css({
			'position' : 'absolute',
			'left' : ($(window).width() - 692) / 2
		});
	});
	$('#frm_login').on('click','#btn_login',function(){
		if($('#user_name').val() == ""){
			$('#error_tip').html('').html('请输入用户名');
			return false;
		}
		if($("#password").val() == ""){
			$('#error_tip').html('').html('请输入密码');
			return false;
		}
		$('#frm_login').submit();
	});
	$("#frm_login").on('focus','#user_name',function(){
		$('#error_tip').html('');
	});
	$("#frm_login").on('focus','#password',function(){
		$('#error_tip').html('');
	})
});