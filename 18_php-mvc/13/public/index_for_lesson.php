<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

// Список пользователей
// Каждый пользователь – ассоциативный массив
// следующей структуры: id, firstName, lastName, email
$users = ['mike', 'mishel', 'adel', 'keks', 'kamils'];

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

// BEGIN (write your solution here)
$app->get('/users', function ($request, $response) use ($users) {
    $userTemplate = $request->getQueryParam('user');
    if (isset($userTemplate)) {
        $matchedUsers = array_filter($users, function ($user) use ($userTemplate) {
            return (strpos($user, $userTemplate) !== false);
        });
        $params = ['users' => $matchedUsers, 'searchString' => $userTemplate];
    } else {
        $params = ['users' => $users, 'searchString' => ''];
    }

    return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});

// END

$app->run();
