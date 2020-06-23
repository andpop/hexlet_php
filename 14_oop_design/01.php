<?php

namespace App;

class PasswordValidator
{
    // BEGIN (write your solution here)
    private $checkOptions = [
        'containNumbers' => [
            'methodName' => 'checkNumbers',
            'failMessage' => 'should contain at least one number',
            'value' => false
        ],
        'minLength' => [
            'methodName' => 'checkMinLength',
            'failMessage' => 'too small',
            'value' => 8
        ]
    ];

    private function checkNumbers($password, $value)
    {
        return ($value === true) ? $this->hasNumber($password) : true;
    }

    private function checkMinLength($password, $value)
    {
        return mb_strlen($password) >= $value;
    }

    public function __construct(array $options = [])
    {
        foreach ($options as $option => $value) {
            if (array_key_exists($option, $this->checkOptions)) {
                $this->checkOptions[$option]['value'] = $value;
            }
        }
    }

    public function validate($password)
    {
        $errors = [];

        foreach ($this->checkOptions as $optionName => $option) {
            $method = $option['methodName'];
            $value = $option['value'];

            if (!$this->$method($password, $value)) {
                $errors[$optionName] = $option['failMessage'];
            }
        }
        
        return $errors;
    }
    // END

    private function hasNumber($subject)
    {
        return strpbrk($subject, '1234567890') !== false;
    }
}

$validator = new PasswordValidator(['containNumbers' => true]);
print_r($validator->validate('qwerty'));
