<?php

namespace App\Http\Validation;

class ProfileFormValidation extends Validator
{
	public static function validate($data) 
	{
		$filter = self::initialize();

		$filter->validate('name')
		    ->isNotBlank()
		    ->setMessage('Имя обязательно к заполнению.');

		$filter->validate('password')
		   ->isNotBlank()
		   ->setMessage('Пароль обязателен к заполнению.');

		return self::check($data);
	}	
}