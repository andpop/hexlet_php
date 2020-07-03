<?php

use Slim\Factory\AppFactory;
// use Tightenco\Support\Collection;

require __DIR__ . '/../vendor/autoload.php';

$companies = App\Generator::generate(100);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response, $args) {
    return $response->write('open something like (you can change id): /companies/5');
});

// BEGIN (write your solution here)
$app->get('/companies/{id}', function ($request, $response, $args) use ($companies) {
    $id = $args['id'];
    $companiesCollection = collect($companies);
    
    $company = $companiesCollection->firstWhere('id', $id);
    if ($company) {
        $companyJSON = json_encode($company);
        return $response->write($companyJSON);
    } else {
        return $response->withStatus(404)->write('Page not found');
    }
});

$app->run();
// END
