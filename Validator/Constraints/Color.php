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
	
	public $requireHash; // For 'hex' type
	
	public function getDefaultOption ()
    {
		return 'types';
    }
}