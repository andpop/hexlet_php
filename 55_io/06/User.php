<?php

namespace App;
// use App\Comparable;

// BEGIN (write your solution here)
class User implements Comparable
{
    public $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function compareTo($user)
    {
        return ($this->id === $user->id);
    }
}
// END
