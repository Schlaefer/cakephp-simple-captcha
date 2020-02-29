SimpleCaptcha for CakePHP
=========================

Simple captcha plugin for CakePHP. Presents a text field with a simple math problem (plus some invisible checks).

See: <https://github.com/Schlaefer/cakephp-simple-captcha>

Install
-------

```php
composer require siezi/cakephp-simple-captcha
```

Include plugin Cake 4 style:

```php
$this->addPlugin(\Siezi\SimpleCaptcha\Plugin::class);
```

Usage Example
-------------

### Insert Captcha-Field in Template ###

Load the helper CakePHP 4 style:

```php
$this->loadHelper('Siezi/SimpleCaptcha.SimpleCaptcha');
```

In template form:

```php
echo $this->SimpleCaptcha->control();
```

### Validate Captcha in Controller ###

```php
$validator = new \Siezi\SimpleCaptcha\Model\Validation\SimpleCaptchaValidator();
$errors = $validator->validate($this->request->getData());
```

Depending on the form you may want to merge the captcha-errors so they are displayed automatically with other form validation errors. For example if the form is backed by a user-entity:

```php
$yourUserEntity->setErrors($errors);
```
