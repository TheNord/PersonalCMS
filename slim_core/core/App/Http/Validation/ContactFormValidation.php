<?php

namespace App\Http\Validation;

class ContactFormValidation extends Validator
{
	public static function validate($data) 
	{
		$filter = self::initialize();

		$filter->validate('name')
	    ->isNotBlank()
	    ->setMessage('The name is required.');

		$filter->validate('email')
		    ->isNotBlank()
		    ->is('email')
		    ->setMessage('The email is required.');

		$filter->validate('message')
		   ->isNotBlank()
		   ->is('strlenMin', 5)
		   ->is('strlenMax', 255)
		   ->setMessage('The message is required.');

		/*   
		$filter->validate('agreed')
		    ->is('callback', function($subject, $field) {
		   return $subject->{$field} === true;    
		})->setMessage('Need confirm rules.');
		*/

		return self::check($data);
	}	
}