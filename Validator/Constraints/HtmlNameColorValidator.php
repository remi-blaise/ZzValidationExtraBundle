<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
	Symfony\Component\Validator\ConstraintValidator,
	Zz\ValidationExtraBundle\Validator\ValidateCheckingIsValidMethod;

class HtmlNameColorValidator extends ConstraintValidator
{
	use ValidateCheckingIsValidMethod;
	
	protected $colors = [ 'aqua','black','blue','fuchsia','gray','green','lime','maroon','navy','olive','orange','purple','red','silver','teal','white','yellow' ];
	
	public function isValid ( $value, Constraint $constraint ) {
		if ( in_array(strtolower($value), $this->colors) )
		{
			return true;
		}
		return false;
	}
}