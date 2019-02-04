<?php

namespace App\Http\Validation;

use Aura\Filter\FilterFactory;

class Validator
{
	public static $filter;
	public static $errors = [];

	public static function initialize() {
		self::$filter = (new FilterFactory)->newSubjectFilter();
		return self::$filter;
	}

	public static function check($data)
	{
		$valid = self::$filter->apply($data);

		if (!$valid) {
		    $failures = self::$filter->getFailures();
		    $messages = $failures->getMessages();

		    foreach ($messages as $field => $errors) {
		       foreach ($errors as $error) {
		       		self::$errors[] = $error;
		        }
		    }
		}

		return self::$errors;
	}
}