<?php

namespace Zz\ValidationExtraBundle\Tests\Validator\Constraints;

use Zz\ValidationExtraBundle\Validator\Constraints as Extras,
	Symfony\Component\Validator\Constraints as Assert;

class TestAnnotations
{
	/**
	 * @Assert\Blank 
	 */
	private $a;
	
	/**
	 * @Extras\Color 
	 */
	private $b = '222a6e';
	
	/**
	 * @Extras\Color("hex")
	 */
	private $c = '222a6e';
	
	/**
	 * @Extras\Color({"hex", "cssname"}, requireHash=false)
	 */
	private $d = '222a6e';
	
	/**
	 * @Extras\Color(types="hex", message="error")
	 */
	private $e = '222a6e';
}