<?php 
namespace app\index\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username'		=> 'require|max:20|unique:user',
		'password'		=> 'require|between:6,16',
		'ip'			=> 'ip',
		'sex'			=> 'in',
		'birthday'		=> 'date',
		'description'	=> 'max:255',
	];
}
