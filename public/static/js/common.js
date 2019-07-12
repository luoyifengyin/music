//jquery.validate表单验证
$(document).ready(function(){
	//登录表单验证
	$("#loginForm").validate({
		rules:{
			username:{
				required:true,//必填
				minlength:6, //最少6个字符
				maxlength:12,//最多12个字符
			},
			password:{
				required:true,
				minlength:6, 
				maxlength:12,
			},
		},
		//错误信息提示
		messages:{
			username:{
				required:"必须填写用户名",
				minlength:"用户名至少为6个字符",
				maxlength:"用户名至多为12个字符",
				remote: "用户名已存在",
			},
			password:{
				required:"必须填写密码",
				minlength:"密码至少为6个字符",
				maxlength:"密码至多为12个字符",
			},
		},

	});
	//注册表单验证
	$("#registerForm").validate({
		rules:{
			username:{
				required:true,//必填
				minlength:6, //最少6个字符
				maxlength:12,//最多20个字符
				remote:{
				},
			},
			password:{
				required:true,
				minlength:6, 
				maxlength:12,
			},
			confirm_password:{
				required:true,
				minlength:6,
				equalTo:'.password'
			},
		},
		//错误信息提示
		messages:{
			username:{
				required:"必须填写用户名",
				minlength:"用户名至少为6个字符",
				maxlength:"用户名至多为12个字符",
				remote: "用户名已存在",
			},
			password:{
				required:"必须填写密码",
				minlength:"密码至少为6个字符",
				maxlength:"密码至多为12个字符",
			},
			confirm_password:{
				required: "请再次输入密码",
				minlength: "确认密码不能少于6个字符",
				equalTo: "两次输入密码不一致",//与另一个元素相同
			},
		},
	});
});
