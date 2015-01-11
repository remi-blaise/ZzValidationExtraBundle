Notice
------

:exclamation: This notice is not a legal text.

The classes `Zz\ValidationExtraBundle\HexColor` and `Zz\ValidationExtraBundle\HexColorValidator` are from the [ollieLtd/OhColorPickerTypeBundle](https://github.com/ollieLtd/OhColorPickerTypeBundle).
The original classes are in the following form:

``` php
<?php

namespace Oh\ColorPickerTypeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HexColor extends Constraint
{
    public $message = 'The color supplied (%color%) is invalid.';
    /**
     * Takes one of these values:
     * null = The hash isn't checked
     * true = The hash is required
     * false = The hash isn't allowed
     * @var type 
     */
    public $requireHash = null;
}
```

``` php
<?php

namespace Oh\ColorPickerTypeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HexColorValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        /**
         * Valid:
         *  
         * #ffffff
         * #ddd
         * ffffff
         * 444
         * 
         * Invalid:  
         *       
         * #wsfsga
         * #9999
         * ggg
         * gggggg
         */
        
        if(is_null($constraint->requireHash))
        {
            $hashReg = '#{0,1}';
        }else if ($constraint->requireHash === true)
        {
            $hashReg = '#';
        }else if ($constraint->requireHash === false)
        {
            $hashReg = '';
        }else {
            throw new \Exception('The requireHash option value is invalid');
        }
        
        if (!preg_match("/^$hashReg([0-9a-fA-F]{6}|[0-9a-fA-F]{3})$/", $value)) {
            $this->setMessage($constraint->message, array('%color%' => $value));
            return false;
        }

        return true;
    }
}
```

The original classes are under the MIT license, thus every line in common between the classes of this bundle and the ollieLtd's one is under the following license:

> Copyright (c) 2012 Ollie Harridge
> 
> Permission is hereby granted, free of charge, to any person obtaining a copy
> of this software and associated documentation files (the "Software"), to deal
> in the Software without restriction, including without limitation the rights
> to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
> copies of the Software, and to permit persons to whom the Software is furnished
> to do so, subject to the following conditions:
> 
> The above copyright notice and this permission notice shall be included in all
> copies or substantial portions of the Software.
> 
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
> IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
> FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
> AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
> LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
> OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
> THE SOFTWARE.