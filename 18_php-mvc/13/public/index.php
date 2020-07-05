<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

use function Stringy\create as s;

$users = App\Generator::generate(100);

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
    $userPattern = $request->getQueryParam('term');
    if (isset($userPattern)) {
        $matchedUsers = array_filter($users, function ($user) use ($userPattern) {
            return (s($user['firstName'])->startsWith($userPattern, false));
        });
        $params = ['users' => $matchedUsers, 'term' => $userPattern];
    } else {
        $params = ['users' => $users, 'term' => $userPattern];
    }

    return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});

// END

$app->run();
