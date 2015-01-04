<?php

namespace Zz\ValidationExtraBundle\Validator;

use Symfony\Component\Validator\Constraint;

trait ValidateCheckingIsValidMethod {
	public function validate ( $value, Constraint $constraint )
	{
		if ( !$this->isValid($value, $constraint) ) {
			if ( is_array($constraint->types) ) {
				$types = '';
				foreach ( $constraint->types as $type ) {
					$types .= $type;
					if( $type !== $constraint->types[count($constraint->types)-1] ) {
						$types .= ',';
					}
				}
			} else {
				$types = $constraint->types;
			}
			$this->context->addViolation ($constraint->message, ['%color%' => $value, '%types%' => $types]);
		}
	}
}