<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$repo = new App\PostRepository();

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

// BEGIN (write your solution here)

$app->get('/posts', function ($request, $response) use ($repo) {
    $page = (int)$request->getQueryParam('page', 1);
    $posts = collect($repo->all())->chunk(5)[$page - 1]->values()->all();
    $params = [
        'posts' => $posts,
        'currentPage' => $page
    ]
    var_dump($posts);

    return $this->get('renderer')->render($response, 'index.phtml');
});
// END

$app->run();
