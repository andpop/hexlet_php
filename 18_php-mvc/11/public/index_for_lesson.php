<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container;
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response, $args) {
    return $response->write('open something like (you can change id): /companies/5');
});

// BEGIN (write your solution here)
    $app->get('/users/{id}', function ($request, $response, $args) {
        $params = ['id' => $args['id'], 'nickname' => 'user-' . $args['id']]; 
        
        return $this->get('renderer')->render($response, 'users/show.phtml', $params);
});

$app->run();
// END
