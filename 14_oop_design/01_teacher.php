<?php

namespace App;

class PasswordValidator
{
    // BEGIN
    private const OPTIONS = [
        'minLength' => 8,
        'containNumbers' => false
    ];

    private $options = [];

    public function __construct(array $options = [])
    {
        $this->options = array_merge(self::OPTIONS, $options);
    }

    public function validate(string $password): array
    {
        $errors = [];
        if (mb_strlen($password) < $this->options['minLength']) {
            $errors['minLength'] = 'too small';
        }

        if ($this->options['containNumbers']) {
            if (!$this->hasNumber($password)) {
                $errors['containNumbers'] = 'should contain at least one number';
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
