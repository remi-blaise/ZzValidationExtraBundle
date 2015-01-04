<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
	Symfony\Component\Validator\ConstraintValidator,
	Zz\ValidationExtraBundle\Validator\ValidateCheckingIsValidMethod;

class ColorValidator extends ConstraintValidator
{
	use ValidateCheckingIsValidMethod;
	
	public function isValid ( $value, Constraint $constraint ) {
		if ( is_string($constraint->types) ) {
			if ( strtolower($constraint->types) === 'all' ) {
				$allTypes = [];
				foreach ( new \DirectoryIterator(dirname(__FILE__)) as $file ) {
					if ( $file->isFile () ) {
						if ( preg_match('#(\w+)Color\.php#', $file->getFilename(), $matches) ) {
							$allTypes[] = $matches[1];
						}
					}
				}
				$constraint->types = $allTypes;
			} else {
				$constraint->types = [$constraint->types];
			}
		}
		if ( !is_array($constraint->types) ) {
			throw new \InvalidArgumentException ('The \'types\' arguments of Color constraint must be a string or an array of strings.');
		}
		
		foreach ( $constraint->types as $type ) {
			if ( !is_string($type) ) {
				throw new \InvalidArgumentException ('The \'types\' arguments of Color constraint must be a string or an array of strings.');
			}
			if ( !class_exists($class = ucfirst(strtolower($type)) . 'ColorValidator') && is_subclass_of($class, 'Color') ) {
				throw new \InvalidArgumentException ('The \'type\' ' . $type . ' is not a XXXColor constraint.');
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