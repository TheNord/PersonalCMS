<?php

namespace App\Http\Validation\Auth;

use App\Http\Validation\Validator;

class RegisterFormValidation extends Validator
{
	public static function validate($data) 
	{
		$filter = self::initialize();

		$filter->validate('email')
		    ->isNotBlank()
		    ->is('email')
		    ->setMessage('The email is required.');

		$filter->validate('password')
		   ->isNotBlank()
		   ->is('strlenMin', 6)
		   ->is('strlenMax', 16)
		   ->setMessage('The password is required.');

		return self::check($data);
	}	
}