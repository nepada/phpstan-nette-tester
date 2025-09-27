# PHPStan nette/tester extension

[![Build Status](https://github.com/nepada/phpstan-nette-tester/workflows/CI/badge.svg)](https://github.com/nepada/phpstan-nette-tester/actions?query=workflow%3ACI+branch%3Amaster)
[![Downloads this Month](https://img.shields.io/packagist/dm/nepada/phpstan-nette-tester.svg)](https://packagist.org/packages/nepada/phpstan-nette-tester)
[![Latest stable](https://img.shields.io/packagist/v/nepada/phpstan-nette-tester.svg)](https://packagist.org/packages/nepada/phpstan-nette-tester)


* [PHPStan](https://github.com/phpstan/phpstan)
* [nette/tester](https://github.com/nette/tester)

This extension was heavily inspired by [phpstan/phpstan/phpstan-webmozart-assert](https://github.com/phpstan/phpstan-webmozart-assert) developed by [Ondřej Mirtes](https://github.com/ondrejmirtes).

It was originally developed and published under [damejidlo organization](https://github.com/damejidlo).

## Description

The main scope of this extension is to help phpstan to detect the type of object after the `Tester\Assert` validation.

```php
<?php
declare(strict_types = 1);

use Tester\Assert;

function runTest(?int $a) {
	// ...
  
	Assert::notNull($a);
	// phpstan is now aware that $a can no longer be `null` at this point
  
	return ($a === 10);
}
```

This extension specifies types of values passed to:

* `Assert::null()`
* `Assert::notNull()`
* `Assert::true()`
* `Assert::false()`
* `Assert::truthy()`
* `Assert::falsey()`
* `Assert::nan()`
* `Assert::same()`
* `Assert::notSame()`
* `Assert::type()`
* `Assert::count()`


## Installation

To use this extension, require it in [Composer](https://getcomposer.org/):

```
composer require --dev nepada/phpstan-nette-tester
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

If you have enabled `checkAlwaysTrueCheckTypeFunctionCall: true`, you will need to add some ignored errors:
```
parameters:
	ignoreErrors:
		- '~Call to static method Tester\\Assert::(type|count|same|notSame)\(\) with .* and .* will always evaluate to true\.~'
		- '~Call to static method Tester\\Assert::(null|notNull|true|false|truthy|falsey|nan)\(\) with .* will always evaluate to true\.~'
```

### Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```
includes:
    - vendor/nepada/phpstan-nette-tester/extension.neon
```
