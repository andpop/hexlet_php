<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Middleware\MethodOverrideMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->add(MethodOverrideMiddleware::class);
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    $cart = json_decode($request->getCookieParam('cart', json_encode([])), true);
    $params = [
        'cart' => $cart
    ];
    return $this->get('renderer')->render($response, 'index.phtml', $params);
});

// BEGIN (write your solution here)
$app->post('/cart-items', function ($request, $response) {
    $formItem = $request->getParsedBodyParam('item');
    $cart = json_decode($request->getCookieParam('cart', json_encode([])), true);

    $itemExists = false;
    for ($i = 0; $i < count($cart); $i++) {
        if ($cart[$i]['id'] === $formItem['id']) {
            $cart[$i]['count']++;
            $itemExists = true;
        }
    }

    if (!$itemExists) {
        $cart[] = [
            'id' => $formItem['id'],
            'name' => $formItem['name'],
            'count' => 1
        ];
    }

    // Кодирование корзины
    $encodedCart = json_encode($cart);

    // Установка новой корзины в куку
    return $response->withHeader('Set-Cookie', "cart={$encodedCart}")->withRedirect('/');
});

$app->delete('/cart-items', function ($request, $response) {
    $cart = json_decode([]);
    return $response->withHeader('Set-Cookie', "cart={$cart}")->withRedirect('/');
});
// END

$app->run();
