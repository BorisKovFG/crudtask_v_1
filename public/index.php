<?php

use Slim\Factory\AppFactory;
use DI\Container;
use App\Generator;
use App\PostRepository;


require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$repo = new PostRepository();
$app->get('/', function ($request, $response) use ($repo) {
    $params = [
        'data' => $repo
    ];
    return $this->get('renderer')->render($response, 'index.phtml', $params);
});


$app->run();