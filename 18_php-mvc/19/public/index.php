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
    $per = 5;
    $nextPage = $page + 1; // Здесь тоже нужно проверку на максимальный номер страницы ставить
    $prevPage = $page > 1 ? $page - 1 : 1;
    $posts = collect($repo->all())->chunk($per)[$page - 1]->values()->all();
    $params = [
        'posts' => $posts,
        'prevPage' => $prevPage,
        'nextPage' => $nextPage
    ];

    return $this->get('renderer')->render($response, 'posts/index.phtml', $params);
})->setName('posts');

$app->get('/posts/{id}', function ($request, $response, $args) use ($repo) {
    $id = $args['id'];

    $post = collect($repo->all())->firstWhere('id', $id);
    if (!$post) {
        return $response->withStatus(404)->write('Page not found');
    }

    $params = $post;
    return $this->get('renderer')->render($response, 'posts/show.phtml', $params);
})->setName('post');
// END

$app->run();
