<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Color extends Constraint
{
	public $message = 'The color supplied (%color%) is invalid (for types: %types%).';
	public $types = 'All';
	
	/**
	 * Takes one of these values:
	 * null = The hash isn't checked
	 * true = The hash is required
	 * false = The hash isn't allowed
	 * @var type 
	 */
	public $requireHash = true; // For 'hex' type
	
	public function getDefaultOption ()
    {
		return 'types';
    }
}