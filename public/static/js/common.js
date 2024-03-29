﻿//jquery.validate表单验证
$(document).ready(function(){
	//登录表单验证
	$("#loginForm").validate({
		rules:{
			username:{
				required:true,//必填
				minlength:2, //最少2个字符
				maxlength:20,//最多20个字符
			},
			password:{
				required:true,
				minlength:6, 
				maxlength:16,
			},
		},
		//错误信息提示
		messages:{
			username:{
				required:"必须填写用户名",
				minlength:"用户名至少为2个字符",
				maxlength:"用户名至多为20个字符",
			},
			password:{
				required:"必须填写密码",
				minlength:"密码至少为6个字符",
				maxlength:"密码至多为16个字符",
			},
		},

	});
	//注册表单验证
	$("#registerForm").validate({
		rules:{
			username:{
				required:true,//必填
				minlength:2, //最少1个字符
				maxlength:20,//最多20个字符
			},
			password:{
				required:true,
				minlength:6, 
				maxlength:16,
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
				minlength:"用户名至少为2个字符",
				maxlength:"用户名至多为20个字符",
			},
			password:{
				required:"必须填写密码",
				minlength:"密码至少为6个字符",
				maxlength:"密码至多为16个字符",
			},
			confirm_password:{
				required: "请再次输入密码",
				minlength: "确认密码不能少于6个字符",
				equalTo: "两次输入密码不一致",//与另一个元素相同
			},
		},
	});
	//自定义密码验证规则
	jQuery.validator.addMethod("password", function(value, element) { 
		var reg = /^[0-9a-zA-Z_]+$/;
		return reg.test(value);
	},  "密码中只能包含数字、字母或下划线"); 
});
