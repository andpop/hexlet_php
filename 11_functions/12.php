<?php

const FREE_EMAIL_DOMAINS = [
    'gmail.com', 'yandex.ru', 'hotmail.com'
];

function getFreeDomainsCount($emails)
{
    $domains = array_map(fn($email) => substr($email, strpos($email, '@') + 1), $emails);
    $freeDomains = array_filter($domains, fn($domain) => in_array($domain, FREE_EMAIL_DOMAINS));
    $result = array_reduce($freeDomains, function ($acc, $domain) {
        if (isset($acc[$domain])) {
            $acc[$domain]++;
        } else {
            $acc[$domain] = 1;
        }
        return $acc;
    }, []);

    return $result;
}

$emails = [
    'info@gmail.com',
    'info@yandex.ru',
    'info@hotmail.com',
    'mk@host.com',
    'support@hexlet.io',
    'key@yandex.ru',
    'sergey@gmail.com',
    'vovan@gmail.com',
    'vovan@hotmail.com'
];

var_dump(getFreeDomainsCount($emails));

