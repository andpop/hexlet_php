<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Validator;
use Slim\Factory\AppFactory;
use DI\Container;

$repo = new App\CourseRepository();

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

$app->get('/courses', function ($request, $response) use ($repo) {
    $params = [
        'courses' => $repo->all()
    ];
    return $this->get('renderer')->render($response, 'courses/index.phtml', $params);
})->setName('courses');

// BEGIN (write your solution here)
$app->get('/courses/new', function ($request, $response) {
    $params = [
        'course' => [
            'title' => '',
            'paid' => ''
        ],
        'errors' => []
    ];
    return $this->get('renderer')->render($response, 'courses/new.phtml', $params);
})->setName('newCourseForm');

$app->post('/courses', function ($request, $response) use ($repo, $router) {
    $course = $request->getParsedBodyParam('course');

    $validator = new \App\Validator();
    $errors = $validator->validate($course);

    $coursesURL = $router->urlFor('courses');

    if (empty($errors)) {
        $repo->save($course);
        return $response->withRedirect($coursesURL);
    }

    $params = [
        'course' => $course,
        'coursesURL' => $coursesURL,
        'errors' => $errors
    ];

    $response = $response->withStatus(422);

    return $this->get('renderer')->render($response, 'courses/new.phtml', $params);
})->setName('saveForm');

// END

$app->run();
