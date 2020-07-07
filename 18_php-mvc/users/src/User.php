<?php
function loadUsers(): array
{
    $encodedUsers = explode("\n", file_get_contents(DATA_FILE));
    return array_map(fn($user) => json_decode($user, true), $encodedUsers);
}

function userExists($nickname)
{
    $users = collect(loadUsers());
    var_dump($users);
}