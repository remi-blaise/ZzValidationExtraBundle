<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HexColor extends Color
{
	/**
	 * Takes one of these values:
	 * null = The hash isn't checked
	 * true = The hash is required
	 * false = The hash isn't allowed
	 * @var type 
	 */
	public $requireHash = true;
}