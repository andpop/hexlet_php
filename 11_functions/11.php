<?php

function getMenCountByYear(array $users): array
{
    $men = array_filter($users, fn($user) => $user['gender'] === 'male');

    return array_reduce($men, function ($acc, $user) {
        $year = date('Y', strtotime($user['birthday']));
        if (!isset($acc[$year])) {
            $acc[$year] = 1;
        } else {
            $acc[$year]++;
        }
        return $acc;
    }, []);
}


$users = [
    ['name' => 'Bronn', 'gender' => 'male', 'birthday' => '1973-03-23'],
    ['name' => 'Reigar', 'gender' => 'male', 'birthday' => '1973-11-03'],
    ['name' => 'Eiegon',  'gender' => 'male', 'birthday' => '1963-11-03'],
    ['name' => 'Sansa', 'gender' => 'female', 'birthday' => '2010-11-03'],
    ['name' => 'Jon', 'gender' => 'male', 'birthday' => '1980-11-03'],
    ['name' => 'Robb','gender' => 'male', 'birthday' => '1980-05-14'],
    ['name' => 'Tisha', 'gender' => 'female', 'birthday' => '2005-11-03'],
    ['name' => 'Rick', 'gender' => 'male', 'birthday' => '2012-11-03'],
    ['name' => 'Joffrey', 'gender' => 'male', 'birthday' => '1999-11-03'],
    ['name' => 'Edd', 'gender' => 'male', 'birthday' => '1973-11-03']
];

var_dump(getMenCountByYear($users));
