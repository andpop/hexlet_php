<?php

namespace App;

class Validator implements ValidatorInterface
{
    public function validate(array $user)
    {
        // BEGIN (write your solution here)
        $errors = [];

        if (empty($user['nickname'])) {
            $errors['nickname'] = "Can't be blank";
        }
        
        if (empty($user['email'])) {
            $errors['email'] = "Can't be blank";
        }

        return $errors;
        // END
    }
}
