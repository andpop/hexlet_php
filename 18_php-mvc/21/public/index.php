<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Middleware\MethodOverrideMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$container->set('renderer', function () {
    return new Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
$container->set('flash', function () {
    return new Slim\Flash\Messages();
});

$app = AppFactory::createFromContainer($container);
$app->add(MethodOverrideMiddleware::class);
$app->addErrorMiddleware(true, true, true);

$repo = new App\PostRepository();
$router = $app->getRouteCollector()->getRouteParser();

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

$app->get('/posts', function ($request, $response) use ($repo) {
    $flash = $this->get('flash')->getMessages();

    $params = [
        'flash' => $flash,
        'posts' => $repo->all()
    ];
    return $this->get('renderer')->render($response, 'posts/index.phtml', $params);
})->setName('posts');

$app->get('/posts/new', function ($request, $response) use ($repo) {
    $params = [
        'postData' => [],
        'errors' => []
    ];
    return $this->get('renderer')->render($response, 'posts/new.phtml', $params);
});

$app->post('/posts', function ($request, $response) use ($repo, $router) {
    $postData = $request->getParsedBodyParam('post');

    $validator = new App\Validator();
    $errors = $validator->validate($postData);

    if (count($errors) === 0) {
        $id = $repo->save($postData);
        $this->get('flash')->addMessage('success', 'Post has been created');
        return $response->withHeader('X-ID', $id)
                        ->withRedirect($router->urlFor('posts'));
    }

    $params = [
        'postData' => $postData,
        'errors' => $errors
    ];

    return $this->get('renderer')->render($response->withStatus(422), 'posts/new.phtml', $params);
});

// BEGIN (write your solution here)
$app->get('/posts/{id}/edit', function ($request, $response, array $args) use ($repo) {
    $id = $args['id'];
    $post = $repo->find($id);
    $params = [
        'postData' => $post,
        'errors' => []
    ];
    return $this->get('renderer')->render($response, 'posts/edit.phtml', $params);
})->setName('editPost');

$app->patch('/posts/{id}', function ($request, $response, array $args) use ($repo, $router) {
    $id = $args['id'];
    $post = $repo->find($id);
    $formData = $request->getParsedBodyParam('post');

    $validator = new App\Validator();
    $errors = $validator->validate($formData);

    if (count($errors) === 0) {
        // Ручное копирование данных из формы в нашу сущность
        $post['name'] = $formData['name'];
        $post['body'] = $formData['body'];

        $this->get('flash')->addMessage('success', 'Post has been updated');
        $repo->save($post);
        $url = $router->urlFor('editPost', ['id' => $post['id']]);
        return $response->withRedirect($url);
    }

    $formData['id'] = $id;
    $params = [
        'postData' => $formData,
        'errors' => $errors
    ];

    $response = $response->withStatus(422);
    return $this->get('renderer')->render($response, 'posts/edit.phtml', $params);
});
// END

$app->run();
