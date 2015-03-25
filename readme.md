SimpleCaptcha for CakePHP
=========================

Simple captcha plugin for CakePHP. Presents a text field with a simple math problem (plus some other background measures).

See: <https://github.com/Schlaefer/cakephp-simple-captcha>

Install
-------

```php
composer require siezi/cakephp-simple-captcha
```

Include plugin manually if necessary:

```php
Plugin::load('Siezi/SimpleCaptcha');
```

Usage Example
-------------

### Include Helper ###

Include helper in the Controller:

```php
public $helpers = [
	'Siezi/SimpleCaptcha.SimpleCaptcha',
];
```

### Use Helper in Template ###

```php
// in the form:
echo $this->SimpleCaptcha->input();
```

### Validate Captcha in Controller ###

```php
$validator = new \Siezi\SimpleCaptcha\Model\Validation\SimpleCaptchaValidator();
$errors = $validator->errors($this->request->data);
```
