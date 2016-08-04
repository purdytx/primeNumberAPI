<?php
/**
* index.php
* prime numbers api
* route handler for api
* purdy
* august 2016
*/
use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;
use Phalcon\DI\FactoryDefault;

// Use Loader() to autoloadmodel
$loader = new Loader();

$loader->registerDirs(
    array(
        __DIR__ . '/models/'
    )
)->register();

$di = new FactoryDefault();

$app = new Micro($di);

//routing here
$app->get('/api/prime', function() use ($app) {
    $clPrime = new Prime();
    $primes = $clPrime->atkins();

    $response = new Response();

    $response->setJsonContent(
        array(
            'status' => 200,
            'data' => $primes
	)
    ); 

    return $response;
});

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'This is crazy, but this page was not found!';
});

$app->handle();

