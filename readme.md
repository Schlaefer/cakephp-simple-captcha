SimpleCaptcha for CakePHP
=========================

Simple captcha plugin for CakePHP.

See: <https://github.com/Schlaefer/cakephp-simple-captcha>

Install
-------

Checkout as `simple_captcha` into your plugin directory.

Usage Example
-------------

### Include Helper ###

Include helper in the Controller:

```php
public $helpers = [
	'SimpleCaptcha.SimpleCaptcha',
];
```

### Use Helper in Template ###

```php
// in the form:
echo $this->SimpleCaptcha->input();
```

### Validate Captcha in Controller ###

```php
$validator = new \SimpleCaptcha\Model\Validation\SimpleCaptchaValidator();
$errors = $validator->errors($this->request->data);
```
