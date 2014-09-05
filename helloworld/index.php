<?php
include "vendor/autoload.php";

$app = new \Slim\Slim();

$app->get('/', function () {
    echo "Hello world!!";
});
	
$app->get('/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/produtos/:id/vendas/:ano(/:mes)', function ($id,$ano,$mes=null) {
		    var_dump($mes);
		});

/*
$app->post('/cliente', function () {
            $request = \Slim\Slim::getInstance()->request()->getBody();
            var_dump($request);
});
*/
$app->post('/cliente', function () use ($app) {
            $request = $app->request()->getBody();
            var_dump($request);
});


	
$app->run();