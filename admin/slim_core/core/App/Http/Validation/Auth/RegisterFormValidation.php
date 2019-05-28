<?php

namespace App\Http\Validation\Auth;

use App\Http\Validation\Validator;

class RegisterFormValidation extends Validator
{
	public static function validate($data) 
	{
		$filter = self::initialize();

		$filter->validate('name')
		    ->isNotBlank()
			->setMessage('Имя обязательно к заполнению.');
			
		$filter->validate('email')
		    ->isNotBlank()
		    ->is('email')
		    ->setMessage('Email обязателен к заполнению.');

		$filter->validate('password')
		   ->isNotBlank()
		   ->is('strlenMin', 6)
		   ->is('strlenMax', 16)
		   ->setMessage('Пароль обязателен к заполнению.');

		return self::check($data);
	}	
}