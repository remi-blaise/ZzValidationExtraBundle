<?php

namespace Zz\ValidationExtraBundle\Tests\Validator\Constraints;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
	Zz\ValidationExtraBundle\Validator\Constraints;

class ColorTest extends WebTestCase
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
	
	protected function validateValue ( $value, Constraints\Color $constraint, $not = false ) {
        $client = static::createClient();
		$container = $client->getContainer();
		$errors = $container->get('validator')->validateValue($value, $constraint);
        $this->assertCount( ($not ? 1 : 0), $errors, 'The color supplied (' . $value . ') should be ' . ($not ? 'invalid' : 'valid') . '.' );
	}
}
