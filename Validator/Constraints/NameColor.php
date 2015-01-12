<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

/**
 * @Annotation
 */
class NameColor extends AbstractChildColor
{
	public $formats = [ 'CssName', 'HtmlName' ];
	
	public function validatedBy () {
		return '\Zz\ValidationExtraBundle\Validator\Constraints\ColorValidator';
	}
}