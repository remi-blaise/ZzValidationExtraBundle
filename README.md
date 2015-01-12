ZzValidationExtraBundle
=======================

Get more validation constraints !

Installation
------------

**Step 1: Download the bundle using composer**

Add the bundle by running:

``` bash
$ composer require zzortell/zz-validation-extra-bundle
```

**Step 2: Enable the bundle**

``` php
<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
	public function registerBundles()
	{
		$bundles = array(
			// ...
            new Zz\ValidationExtraBundle\ZzValidationExtraBundle(),
			// ...
		);
	}
}
```

**Step 3: Enjoy !**

Usage
-----

### The `Color` constraint

Use the `Color` constraint like any validation constraint of the [symfony/Validator](https://github.com/symfony/Validator) component.
For example, with annotations:
``` php
<?php

use Zz\ValidationExtraBundle\Validator\Constraints as Extras;

class MyClass
{
	/**
	 * Simple usage:
	 * @Extras\Color
	 */
	protected $color = '#222a6e';
	
	/**
	 * All options with theirs default values:
	 * @Extras\Color(formats="All", message="The color supplied (%color%) is invalid (for formats: %formats%).", requireHash=true)
	 */
	protected $color = '#222a6e';
	
	/**
	 * Complex usage:
	 * @Extras\Color(formats={"hex", "cssname"}, requireHash=false)
	 */
	protected $color = '#222a6e';
}
```

Properties:
- `formats`: can be a string or an array of strings. Values: `"All"` (string only), `"Hex"`, `"Name"` (`"HtmlName"`+`CssName""`), `"HtmlName"`, `CssName""`.
- `message`: Available variables: `%color%`, `%formats%`.
- `requireHash`: for `hex` colors. Values: `null` (doesn't worry) or boolean. 

You can also use the following constraints, heriting of `Color`:
- `HexColor`
- `NameColor`
- `CssNameColor`
- `HtmlNameColor`

Don't hesitate to have a look on [`Validator/Constraints`](https://github.com/Zzortell/ZzValidationExtraBundle/tree/master/Validator/Constraints).

Notice
------

If you don't want to get future features and just use colors constraints, require only `1.0.*` versions.
Every future features will increment the minor number.

Todo
----

In the `1.0` branch:
- Add the support of rgb, rgba, hsl, hsla formats
- Add a webSafe property.

In the `1.1` branch:
- Add a color format convertor ?

Contributing
------------

If you have any idea for improving the bundle or if you find a bug, please post [an issue](https://github.com/Zzortell/ZzValidationExtraBundle/issues/new).
If you want to help me, especially for correcting my english, please don't hesitate.

Credits
-------

This bundle his inspired by the ollietb's [`HexColor` constraint](https://github.com/ollieLtd/OhColorPickerTypeBundle/blob/master/Validator/Constraints/HexColor.php) and [his validator](https://github.com/ollieLtd/OhColorPickerTypeBundle/blob/master/Validator/Constraints/HexColorValidator.php).
* Rémi Blaise (Zzortell)[https://github.com/Zzortell] as the author.
* Ollie Harridge (ollietb)[https://github.com/ollietb] for original `HexColor` constraint.

License
-------

This bundle is under the MIT license. See [the complete license](https://github.com/Zzortell/ZzValidationExtraBundle/tree/master/Resources/meta/LICENSE) in the bundle:

    Resources/meta/LICENSE

A part of this bundle comes from [ollieLtd/OhColorPickerTypeBundle](https://github.com/ollieLtd/OhColorPickerTypeBundle). Please see [this notice](https://github.com/Zzortell/ZzValidationExtraBundle/tree/master/Resources/meta/NOTICE.md):

    Resources/meta/NOTICE.md