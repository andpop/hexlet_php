<?php

namespace App;

class PasswordValidator
{
    // BEGIN (write your solution here)
    private $valueMustContainNumbers = false;
    private $valueMinLength = 8;

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

    private function checkNumbers($value)
    {
        echo "Check numbers with {$value}\n";
        return false;
    }

    private function checkMinLength($value)
    {
        echo "Check min length with {$value}\n";
        return false;
    }

    public function __construct(array $options = [])
    {
        foreach ($options as $option => $value) {
            if (array_key_exists('option', $this->checkOptions)) {
                $this->checkOptions[$option] = $value;
            }
        }
    }

    public function validate($password)
    {
        $result = [];

        foreach ($this->checkOptions as $optionName => $option) {
            $method = $option['methodName'];
            $value = $option['value'];
            if (!$this->$method($value)) {
                $result[$optionName] = $option['failMessage'];
            }
        }
        
        return $result;
    }
    // END

    private function hasNumber($subject)
    {
        return strpbrk($subject, '1234567890') !== false;
    }
}

$validator = new PasswordValidator();
print_r($validator->validate('qwerty'));
