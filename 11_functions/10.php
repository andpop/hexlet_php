<?php
require_once('./vendor/autoload.php');

use function Funct\Collection\flatten;

function getGirlFriends(array $users): array
{
    $friends = flatten(array_map(fn($user) => $user['friends'], $users));

    return array_values(array_filter($friends, fn($friend) => $friend['gender'] === 'female'));
}


$users = [
    ['name' => 'Tirion', 'friends' => [
        ['name' => 'Mira', 'gender' => 'female'],
        ['name' => 'Ramsey', 'gender' => 'male']
    ]],
    ['name' => 'Bronn', 'friends' => []],
    ['name' => 'Sam', 'friends' => [
        ['name' => 'Aria', 'gender' => 'female'],
        ['name' => 'Keit', 'gender' => 'female']
    ]],
    ['name' => 'Rob', 'friends' => [
        ['name' => 'Taywin', 'gender' => 'male']
    ]],
];

var_dump(getGirlFriends($users));
