SimpleCaptcha for CakePHP
=========================

Simple captcha plugin for CakePHP.

See: <https://github.com/Schlaefer/cakephp-simple-captcha>

Install
-------

Require in composer: `siezi/cakephp-simple-captcha`

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
$validator = new \Siezi\SimpleCaptcha\Model\Validation\SimpleCaptchaValidator();
$errors = $validator->errors($this->request->data);
```
