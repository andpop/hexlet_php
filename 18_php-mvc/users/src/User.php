<?php
function loadUsers(): array
{
    $encodedUsers = explode("\n", file_get_contents(DATA_FILE));
    return array_map(fn($user) => json_decode($user, true), $encodedUsers);
}

function userExists(int $id): bool
{
    $users = collect(loadUsers());

    return (bool)$users->firstWhere('id', $id);
}

function loadUser(int $id): array
{
    return collect(loadUsers()) ->firstWhere('id', $id);
}