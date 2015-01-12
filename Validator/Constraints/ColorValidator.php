<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
	Symfony\Component\Validator\ConstraintValidator;

class ColorValidator extends ConstraintValidator
{
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
	
	public function isValid ( $value, Constraint $constraint ) {
		if ( is_string($constraint->formats) ) {
			if ( strtolower($constraint->formats) === 'all' ) {
				$allFormats = [];
				foreach ( new \DirectoryIterator(dirname(__FILE__)) as $file ) {
					if ( $file->isFile () ) {
						if ( preg_match('#(\w+)ColorValidator\.php#', $file->getFilename(), $matches) ) {
							$allFormats[] = $matches[1];
						}
					}
				}
				$constraint->formats = $allFormats;
			} else {
				$constraint->formats = [$constraint->formats];
			}
		}
		if ( !is_array($constraint->formats) ) {
			throw new \InvalidArgumentException ('The \'formats\' arguments of Color constraint must be a string or an array of strings.');
		}
		
		foreach ( $constraint->formats as $format ) {
			if ( !is_string($format) ) {
				throw new \InvalidArgumentException ('The \'formats\' arguments of Color constraint must be a string or an array of strings.');
			}
			if ( !class_exists($class = ucfirst(strtolower($format)) . 'ColorValidator') && is_subclass_of($class, 'Color') ) {
				throw new \InvalidArgumentException ('The \'format\' ' . $format . ' is not a XXXColor constraint.');
			}
			$class = 'Zz\ValidationExtraBundle\Validator\Constraints\\' . $class;
			$validator = new $class;
			if ( call_user_func([$validator, 'isValid'], $value, $constraint) ) {
				return true;
			}
		}
		return false;
	}
}