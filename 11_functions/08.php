<?php
require_once('./vendor/autoload.php');

use function Funct\Collection\firstN;

$users = [
    ['name' => 'Tirion', 'birthday' => '1988-11-19'],
    ['name' => 'Sam', 'birthday' => '1999-11-22'],
    ['name' => 'Rob', 'birthday' => '1975-01-11'],
    ['name' => 'Sansa', 'birthday' => '2001-03-20'],
    ['name' => 'Tisha', 'birthday' => '1992-02-27']
];

function takeOldest(array $users, $countUsers = 1): array
{
    $compareUsersByAge = function ($user1, $user2) {
        return strtotime($user1['birthday']) <=> strtotime($user2['birthday']);
    };

    usort($users, $compareUsersByAge);
    return firstN($users, $countUsers);
}

print_r(takeOldest($users, 4));
