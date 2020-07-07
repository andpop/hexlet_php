<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Validator;
use Slim\Factory\AppFactory;
use DI\Container;

const DATA_FILE = __DIR__ . '/../data/users.dat';

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$router = $app->getRouteCollector()->getRouteParser();

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

$app->get('/users', function ($request, $response) {
    $encodedUsers = explode("\n", file_get_contents(DATA_FILE));
    $users = array_map(fn ($user) => json_decode($user, true), $encodedUsers);

    $params = [ 'users' => $users ];
    return $this->get('renderer')->render($response, 'users/index.phtml', $params);
})->setName('users');

$app->get('/users/new', function ($request, $response) {
    $params = [
        'user' => [
            'nickname' => '',
            'email' => ''
        ],
        'errors' => []
    ];
    return $this->get('renderer')->render($response, 'users/new.phtml', $params);
})->setName('newUserForm');

$app->post('/users', function ($request, $response) use ($router) {
    $user = $request->getParsedBodyParam('user');
    $user['id'] = uniqid();


    $validator = new \App\Validator();
    $errors = $validator->validate($user);

    if (empty($errors)) {
        file_put_contents(DATA_FILE, json_encode($user)."\n", FILE_APPEND);

        return $response->withRedirect($router->urlFor('users'));
    }

    $params = [
        'user' => $user,
        'errors' => $errors
    ];

    $response = $response->withStatus(422);

    return $this->get('renderer')->render($response, 'users/new.phtml', $params);
})->setName('saveUser');

$app->run();
