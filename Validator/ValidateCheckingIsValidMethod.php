<?php

namespace Zz\ValidationExtraBundle\Validator;

trait ValidateCheckingIsValidMethod {
	public function validate ( $value, Constraint $constraint )
	{
		if ( !$this->isValid($value, $constraint) ) {
			$this->context->addViolation ($constraint->message, array('%color%' => $value));
		}
	}
}