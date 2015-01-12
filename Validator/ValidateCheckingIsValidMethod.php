<?php

namespace Zz\ValidationExtraBundle\Validator;

use Symfony\Component\Validator\Constraint;

trait ValidateCheckingIsValidMethod {
	public function validate ( $value, Constraint $constraint )
	{
		if ( !$this->isValid($value, $constraint) ) {
			if ( is_array($constraint->formats) ) {
				$formats = '';
				foreach ( $constraint->formats as $format ) {
					$formats .= $format;
					if( $format !== $constraint->formats[count($constraint->formats)-1] ) {
						$formats .= ',';
					}
				}
			} else {
				$formats = $constraint->formats;
			}
			$this->context->addViolation ($constraint->message, ['%color%' => $value, '%formats%' => $formats]);
		}
	}
}