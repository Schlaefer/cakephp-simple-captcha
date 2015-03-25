<?php

namespace Siezi\SimpleCaptcha\Lib;

use Cake\Core\InstanceConfigTrait;
use Cake\Utility\Security;

trait SimpleCaptchaTrait {

    protected $defaults = [
        'type' => 'active',
        'dummyField' => 'homepage',
        /**
         * Minimum time in seconds which is considered necessary for a human to fill the form
         *
         * We assume that only a bot is able to fill and answer the form faster.
         */
        'minTime' => 6,
        /**
         * Maximum time in seconds the form is valid.
         *
         * Prevents harvesting hashs for later use.
         */
        'maxTime' => 1200,
        'salt' => ''
    ];

    public function buildHash($params) {
        $hashValue = date('c', $params['timestamp']) . '_';
        $hashValue .= $params['result'] . '_' . $this->config('salt');
        $hashValue = Security::hash($hashValue);
        return $hashValue;
    }

}
