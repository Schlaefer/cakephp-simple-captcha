<?php

namespace Siezi\SimpleCaptcha\Test\Model\Validation;

use Cake\TestSuite\TestCase;
use Siezi\SimpleCaptcha\Model\Validation\SimpleCaptchaValidator;

class SimpleCaptchaValidatorTest extends TestCase {

    public function testDummyField() {
        $validator = new SimpleCaptchaValidator();
        $dummyField = $validator->getConfig('dummyField');

        $result = $validator->errors([$dummyField => 'foo']);
        $this->assertArrayHasKey($dummyField, $result);

        $result = $validator->errors([$dummyField => '']);
        $this->assertEmpty($result);
    }

    public function testMinTime() {
        $validator = new SimpleCaptchaValidator();
        $minTime = $validator->getConfig('minTime');

        $expected = [
            'captcha_time' => ['captchaMinTime' => 'Captcha result too fast']
        ];
        $result = $validator->errors(['captcha_time' => time() - $minTime + 1]);
        $this->assertEquals($expected, $result);

        $result = $validator->errors(['captcha_time' => time() - $minTime - 1]);
        $this->assertEmpty($result);

        $validator->setConfig('minTime', 0);
        $result = $validator->errors(['captcha_time' => time()]);
        $this->assertEmpty($result);
    }

    public function testMaxTime() {
        $validator = new SimpleCaptchaValidator();
        $maxTime = $validator->getConfig('maxTime');

        $expected = [
            'captcha_time' => ['captchaMaxTime' => 'Captcha result too late']
        ];
        $result = $validator->errors(['captcha_time' => time() - $maxTime - 1]);
        $this->assertEquals($expected, $result);

        $result = $validator->errors(['captcha_time' => time() - $maxTime + 1]);
        $this->assertEmpty($result);

        $validator->setConfig('maxTime', 0);
        $result = $validator->errors(['captcha_time' => time() - $maxTime]);
        $this->assertEmpty($result);
    }

    public function testCaptcha() {
        $validator = new SimpleCaptchaValidator();
        $validator->setConfig('minTime', 0);
        $validator->setConfig('maxTime', 0);

        $time = time();

        $data = [
            'captcha' => 'foo',
            'captcha_time' => $time,
            'captcha_hash' => $validator->buildHash(['timestamp' => $time, 'result' => 'bar'])
        ];
        $expected = [
            'captcha' => ['captcha' => 'Captcha result incorrect']
        ];
        $result = $validator->errors($data);
        $this->assertEquals($expected, $result);

        $data['captcha_hash'] = $validator->buildHash(['timestamp' => $time, 'result' => 'foo']);
        $result = $validator->errors($data);
        $this->assertEmpty($result);
    }

}
