<?php

namespace Siezi\SimpleCaptcha\View\Helper;

use Cake\Utility\Text;
use Cake\View\Helper;
use Siezi\SimpleCaptcha\Lib\SimpleCaptchaTrait;

class SimpleCaptchaHelper extends Helper {

    use SimpleCaptchaTrait;

    public $helpers = ['Form'];

    protected $captcha = [];

    /**
     * Alias for control()
     *
     * @param array $options
     * @return void
     * @deprecated use control();
     */
    public function input(array $options = []) {
        deprecationWarning(
            'SimpleCaptchaHelper::input() is deprecated. ' .
            'Use SimpleCaptchaHelper::control() instead.'
        );
        return $this->control($options);
    }

    public function control(array $options = []) {
        $html = $this->passive($options);
        if ($this->getConfig('type') === 'active') {
            $html = $this->active($options) . $html;
        }
		return $html;
	}

	public function passive() {
		$this->generate();
		$out[] = '<div style="display:none">';
        $out[] = $this->Form->control('captcha_hash', ['value' => $this->captcha['hash']]);
        $out[] = $this->Form->control('captcha_time', ['value' => time()]);
        $out[] = $this->Form->control($this->getConfig('dummyField'), ['value' => '']);
        $out[] = '</div>';
        if ($this->Form->isFieldError('captcha_time')) {
            $out[] = $this->Form->error('captcha_time');
        };
		return implode('', $out);
	}

	public function active($options = array()) {
		$this->generate();
        $defaults = [
            'type' => 'text',
            'class' => 'captcha',
            'value' => '',
            'maxlength' => 3,
            'label' => __d('simple_captcha', 'Captcha: :question =', true),
            'autocomplete' => 'off'
        ];
        $options += $defaults;

        // obvuscate operation for bots by reversing the code in source but reverse effect with CSS
        $obf = '<span id="captchaCode" style="unicode-bidi: bidi-override; direction: rtl;">' . strrev( $this->captcha['text']);
        // let's go nuts here
        $obf .= '<span style="display: none;"> - ' . mt_rand(10, 20) . '</span>';
        $obf .= '</span>';

        $label = Text::insert(h($options['label']), ['question' => $obf]);
        $options['label'] = ['text' => $label, 'escape' => false];

		$html = $this->Form->control('captcha', $options);
        return $html;
	}

    protected function generate() {
        if (!empty($this->captcha)) {
            return;
        }
        $this->setConfig($this->defaults);

        // the answer shall not be negative
        $numberOne = mt_rand(6, 9);
        $numberTwo = mt_rand(1, 5);
        $captchaOperator = '-';

        $this->captcha['text'] = $numberOne . ' ' . $captchaOperator . ' ' . $numberTwo;
        $result = $numberOne - $numberTwo;
        $this->captcha['hash'] = $this->buildHash(['timestamp' => time(), 'result' => $result]);
    }

}

