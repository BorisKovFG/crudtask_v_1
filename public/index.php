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
    return $this->get('renderer')->render($response, 'index.phtml');
})->setName("main");

$app->get('/posts', function ($request, $response) use ($repo) {
    $page = $request->getQueryParam('page', 1);
    $per = 5;
    $offset = ($page - 1) * $per;
    $posts = $repo->all();
    $sliceOfPosts = array_slice($posts, $offset, $per);

    $params = [
        'posts' => $sliceOfPosts,
        'page' => $page,
    ];
    return $this->get('renderer')->render($response, 'posts/index.phtml', $params);
})->setName("posts");

$app->get('/posts/{id}', function ($request, $response, $args) use ($repo) {
    $id = $args['id'];
    $post = $repo->find($id);
    $params = [
        'post' => $post
    ];
    if (!$post) {
        return $response->write('Page not found')
            ->withStatus(404);
    }
    return $this->get('renderer')->render($response, 'posts/show.phtml', $params);
})->setName("post");

$app->run();