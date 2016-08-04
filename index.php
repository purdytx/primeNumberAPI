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

/**
*  for quick and dirty api, enabling COORS
*  for a secure api swap this out with a proper secure call such as oauth token exhange.
*/
$response = $app->response;                      
$response->setHeader('Access-Control-Allow-Origin', '*');
$response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');      
$response->sendHeaders();

$app->get('/preflight', function() use ($app) {
        $content_type = 'application/json';
        $status = 200;
        $description = 'OK';
        $response = $app->response;

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $description;
        $response->setRawHeader($status_header);
        $response->setStatusCode($status, $description);
        $response->setContentType($content_type, 'UTF-8');
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
        $response->setHeader("Access-Control-Allow-Headers: Authorization");
        $response->setHeader('Content-type: ' . $content_type);
        $response->sendHeaders();
    });

//routing here
$app->get('/api/prime/{start:[0-9]+}/{end:[0-9]+}', function($start, $end) use ($app) {

    $clPrime = new Prime();

    $response = new Response();

    try {
        $primes = $clPrime->atkins($start,$end);
    } catch (exception $e) {
         $response->setJsonContent(
	     array(
                 'status' => $e->getCode(),
                 'data' => $e->getMessage()
             )
         );
	 
         return $response;
    }

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

