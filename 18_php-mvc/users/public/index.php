<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Validator;
use Slim\Factory\AppFactory;
use DI\Container;

session_start();

const DATA_FILE = __DIR__ . '/../data/users.dat';

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
$container->set('flash', function() {
    return new \Slim\Flash\Messages();
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$router = $app->getRouteCollector()->getRouteParser();

// ======================================================================
$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

$app->get('/users/{id:[0-9]+}', function ($request, $response, $args) {
    if (userExists((int)$args['id'])) {
        $params = [ 'user' => loadUser($args['id']) ];
        return $this->get('renderer')->render($response, 'users/user.phtml', $params);
    }
    
    $message = "Ресурс не найден";
    $params = ['message' => $message];

    return $this->get('renderer')->render($response, '402.phtml', $params)->withStatus(402);
});

$app->get('/users', function ($request, $response) {
    $flashMessages = $this->get('flash')->getMessages();
    $successMessages = empty($flashMessages) ? [] : $flashMessages['success'];
    $params = [ 
        'users' => loadUsers(),
        'flashMessages' => $successMessages
    ];
    
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
    $user['id'] = abs(crc32(uniqid()));


    $validator = new \App\Validator();
    $errors = $validator->validate($user);

    if (empty($errors)) {
        file_put_contents(DATA_FILE, json_encode($user)."\n", FILE_APPEND);
        $this->get('flash')->addMessage('success', "Пользователь {$user['nickname']} добавлен");

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
