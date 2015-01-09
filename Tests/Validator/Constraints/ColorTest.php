<?php

namespace Zz\ValidationExtraBundle\Tests\Validator\Constraints;

use Symfony\Component\Validator\Validation,
	Zz\ValidationExtraBundle\Validator\Constraints;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    public function testColor ()
    {
		$constraint = new Constraints\Color ();
		$this->validateValue('#eee', $constraint);
		
		$constraint->types = 'hex';
		$this->validateValue('#eee', $constraint);
		$this->validateValue('#e5ee', $constraint, true);
		
		$constraint->types = 'HtmlName';
		$this->validateValue('aqua', $constraint);
		$this->validateValue('#e5ee', $constraint, true);
		
		$constraint->types = ['csSnaME', 'HtmlName'];
		$this->validateValue('aqua', $constraint);
		$this->validateValue('gold', $constraint);
		$this->validateValue('#e5ee', $constraint, true);
		$this->validateValue(5, $constraint, true);
    }
	
    public function testHexColor ()
    {
		$constraint = new Constraints\HexColor ();
		$this->validateValue('eee000', $constraint, true);
		$this->validateValue('#eee', $constraint);
		
		$constraint->requireHash = false;
		$this->validateValue('eee000', $constraint);
		$this->validateValue('#000', $constraint, true);
		
		$constraint->requireHash = null;
		$this->validateValue('eee000', $constraint);
		$this->validateValue('#000', $constraint);
    }
	
    public function testHtmlNameColor ()
    {
		$constraint = new Constraints\HtmlNameColor ();
		$this->validateValue('aqua', $constraint);
		$this->validateValue('gold', $constraint, true);
    }
	
    public function testCssNameColor ()
    {
		$constraint = new Constraints\CssNameColor ();
		$this->validateValue('gold', $constraint);
		$this->validateValue('aqua', $constraint, true);
    }
	
	public function testAnnotations ()
	{
		$this->validate( new TestAnnotations );
	}
	
	protected function validate ( $object, $not = false ) {
        $validator = Validation::createValidatorBuilder()
						->enableAnnotationMapping()
						->getValidator();
		$errors = $validator->validate($object);
        $message = 'The object supplied should be ' . ($not ? 'invalid' : 'valid') . '.' . ($not ? '' : " Errors :\n");
		foreach ( $errors as $error ) {
			$message .= $error;
		}
		
		if ( !$not ) {
			$this->assertEmpty( $errors, $message );
		} else {
			$this->assertNotEmpty( $errors, $message );
		}
	}
	
	protected function validateValue ( $value, Constraints\Color $constraint, $not = false ) {
        $validator = Validation::createValidator();
		$errors = $validator->validateValue($value, $constraint);
		$message = 'The color supplied (' . $value . ') should be ' . ($not ? 'invalid' : 'valid') . '.';
		
		if ( !$not ) {
			$this->assertEmpty( $errors, $message );
		} else {
			$this->assertNotEmpty( $errors, $message );
		}
	}
}
