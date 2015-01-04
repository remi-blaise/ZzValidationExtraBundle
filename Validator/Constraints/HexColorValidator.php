<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
	Symfony\Component\Validator\ConstraintValidator,
	Zz\ValidationExtraBundle\Validator\ValidateCheckingIsValidMethod;

class HexColorValidator extends ConstraintValidator
{
	use ValidateCheckingIsValidMethod;
	
	public function isValid ( $value, Constraint $constraint ) {
		if ( is_null($constraint->requireHash) ) {
			$hashReg = '#?';
		} else if ( $constraint->requireHash === true ) {
			$hashReg = '#';
		} else if ( $constraint->requireHash === false ) {
			$hashReg = '';
		} else {
			throw new \Exception('The requireHash option value is invalid');
		}
		
		if ( preg_match('/^' . $hashReg . '([0-9a-fA-F]{6}|[0-9a-fA-F]{3})$/', $value) )
		{
			return true;
		}
		return false;
	}
}