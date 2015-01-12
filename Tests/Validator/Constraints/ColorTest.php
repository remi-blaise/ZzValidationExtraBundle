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
		
		$constraint->formats = 'hex';
		$this->validateValue('#eee', $constraint);
		$this->validateValue('#e5ee', $constraint, true);
		
		$constraint->formats = 'HtmlName';
		$this->validateValue('aqua', $constraint);
		$this->validateValue('#e5ee', $constraint, true);
		
		$constraint->formats = ['csSnaME', 'HtmlName'];
		$this->validateValue('aqua', $constraint);
		$this->validateValue('gold', $constraint);
		$this->validateValue('#e5ee', $constraint, true);
		$this->validateValue(5, $constraint, true);
    }
	
	public function testViciousCases ()
	{
		$constraint = new Constraints\Color (true);
		$this->validateException($constraint);
		
		$constraint->formats = ['e'];
		$this->validateException($constraint);
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
	
    public function testNameColor ()
    {
		$constraint = new Constraints\NameColor ();
		$this->validateValue('gold', $constraint);
		$this->validateValue('aqua', $constraint);
		$this->validateValue('#000', $constraint, true);
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
	
	protected function validateException ( Constraints\Color $constraint, $class = '\InvalidArgumentException' ) {
		$excep = false;
		try {
			$this->validateValue('#eee', $constraint);
		} catch ( \Exception $e ) {
			$this->assertInstanceOf($class, $e);
			$excep = true;
		}
		if ( !$excep ) {
			$this->assertTrue(false, 'The validation of the constraint didn\'t throw any exception.');
		}
	}
}
