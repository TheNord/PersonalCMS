<?php

namespace App\Http\Validation\Auth;

use App\Http\Validation\Validator;

class LoginFormValidation extends Validator
{
	public static function validate($data) 
	{
		$filter = self::initialize();

		$filter->validate('email')
		    ->isNotBlank()
		    ->is('email')
		    ->setMessage('Email обязателен к заполнению.');

		$filter->validate('password')
		   ->isNotBlank()
		   ->setMessage('Пароль обязателен к заполнению.');

		return self::check($data);
	}	
}