<?php

namespace Zz\ValidationExtraBundle\Validator\Constraints;

/**
 * @Annotation
 */
abstract class AbstractChildColor extends Color
{
	public function getDefaultOption ()
    {
		return 'message';
    }
}