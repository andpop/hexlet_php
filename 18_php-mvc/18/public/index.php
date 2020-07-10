<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Validator;
use Slim\Factory\AppFactory;
use DI\Container;

session_start();

$repo = new App\CourseRepository();

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
$container->set('flash', function () {
    return new \Slim\Flash\Messages();
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$router = $app->getRouteCollector()->getRouteParser();

// BEGIN (write your solution here)
$app->get('/', function ($request, $response) {
    $flashMessages = $this->get('flash')->getMessages();
    $successMessages = empty($flashMessages) ? [] : $flashMessages['success'];
    $params = [ 
        'flashMessages' => $successMessages
    ];

    return $this->get('renderer')->render($response, 'index.phtml', $params);
});

$app->post('/courses', function ($request, $response) {
    $this->get('flash')->addMessage('success', 'Course Added');

    return $response->withRedirect('/');
})->setName('save');

// END

$app->run();
