<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
	Symfony\Component\Validator\ConstraintValidator,
	Symfony\Component\Validator\Validation,
	Symfony\Component\Validator\Constraints as Assert;

class ColorValidator extends ConstraintValidator
{
	// Contains all formats (without 'All', 'Name', etc.) with their validator's id as index
	protected $formats = [ 'Hex' => 'hex', 'CssName' => 'cssname', 'HtmlName' => 'htmlname' ];
	
	public function validate ( $value, Constraint $constraint )
	{
		// If it's not valid: contruct the message and add a violation
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
	
	public function isValid ( $value, Constraint $constraint ) {
		// If 'formats' property is a string: convert it into an array
		if ( is_string($constraint->formats) ) {
			$constraint->formats = [$constraint->formats];
		}
		
		// If it's not an array of string: throw an InvalidArgumentException
		if ( !is_array($constraint->formats) ) {
			throw new \InvalidArgumentException ('The \'formats\' arguments of Color constraint must be a string or an array of strings.');
		}
		$validator = Validation::createValidator();
		$cons = new Assert\All ([ new Assert\Type ('string') ]);
		$errors = $validator->validateValue($constraint->formats, $cons);
		if ( count($errors) !== 0 ) {
			throw new \InvalidArgumentException ('The \'formats\' arguments of Color constraint must be a string or an array of strings.');
		}
		
		$constraint->formats = array_map('strtolower', $constraint->formats);
		
		// Process each "complex" value
		if ( in_array('all', $constraint->formats, true) ) {
			$constraint->formats = $this->formats;
		} elseif ( $keys = array_keys($constraint->formats, 'name', true) ) {
			foreach ( $keys as $key ) {
				unset( $constraint->formats[$key] );
			}
			array_merge( $constraint->formats, ['cssname', 'htmlname'] );
		}
		
		// Check foreach format if the value is valid
		foreach ( $constraint->formats as $format ) {
			if ( !in_array( $format, $this->formats ) ) {
				throw new \InvalidArgumentException ('The \'format\' ' . $format . ' is not valid.');
			}
			
			$class = '\Zz\ValidationExtraBundle\Validator\Constraints\\' . array_search($format, $this->formats) . 'ColorValidator';
			$validator = new $class;
			if ( call_user_func([$validator, 'isValid'], $value, $constraint) ) {
				return true;
			}
		}
		return false;
	}
}