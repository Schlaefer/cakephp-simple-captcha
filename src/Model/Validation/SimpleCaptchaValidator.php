<?php

namespace Siezi\SimpleCaptcha\Model\Validation;

use Cake\Core\InstanceConfigTrait;
use Cake\Validation\Validator;
use Siezi\SimpleCaptcha\Lib\SimpleCaptchaTrait;

class SimpleCaptchaValidator extends Validator {

    use InstanceConfigTrait;
    use SimpleCaptchaTrait;

    protected $_defaultConfig = [];

    public function __construct() {
        parent::__construct();

        $this->config($this->defaults);

        $this
            ->allowEmpty($this->config('dummyField'))
            ->add(
            $this->config('dummyField'),
            'dummyField',
            [
                'rule' => [$this, 'validateDummyField']
            ]
        );
        $this->add(
            'captcha_time',
            'captchaMinTime',
            [
                'rule' => [$this, 'validateCaptchaMinTime'],
                'message' => __d('simple_captcha', 'Captcha result too fast')
            ]
        );
        $this->add(
            'captcha_time',
            'captchaMaxTime',
            [
                'rule' => [$this, 'validateCaptchaMaxTime'],
                'message' => __d('simple_captcha', 'Captcha result too late')
            ]
        );
        if ($this->config('type') === 'active') {
            $this->add('captcha_hash', 'captchaHash', ['rule' => 'notBlank']);
            $this->add(
                'captcha',
                'captcha',
                [
                    'rule' => [$this, 'validateCaptcha'],
                    'message' => __d('simple_captcha', 'Captcha result incorrect')
                ]
            );
        }
    }

    public function validateDummyField($value, $context) {
        return empty($value);
    }

    public function validateCaptchaMinTime($value, $context) {
        $minTime = $this->config('minTime');
        if ($minTime <= 0) {
            return true;
        }
        return time() > ((int)$value + $minTime);
    }

    public function validateCaptchaMaxTime($value, $context) {
        $maxTime = $this->config('maxTime');
        if ($maxTime <= 0) {
            return true;
        }
        return time() < ((int)$value + $maxTime);
    }

    public function validateCaptcha($value, $context) {
        $data = $context['data'];
        $params = [
            'timestamp' => (int)$data['captcha_time'],
            'result' => $value,
        ];
        $hash = $this->buildHash($params);

        return $data['captcha_hash'] === $hash;
    }

}
