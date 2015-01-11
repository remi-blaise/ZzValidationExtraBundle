<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NameColor extends Color
{
	public $types = [ 'CssName', 'HtmlName' ];
	
	public function validatedBy () {
		return '\Zz\ValidationExtraBundle\Validator\Constraints\ColorValidator';
	}
}