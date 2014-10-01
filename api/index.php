<?php
session_start();
include "config.php";
include "DB.php";

require 'vendor/autoload.php';
$app = new \Slim\Slim(array(
    'debug' => true
     ));

$app->contentType("application/json");

$app->error(function ( Exception $e = null) use ($app) {
         echo '{"error":{"text":"'. $e->getMessage() .'"}}';
        });

//GET pode possuir um parametro na URL
$app->get('/:controller/:action(/:parameter)', function ($controller, $action, $parameter = null) use($app) {

            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "get_" . $action), array($parameter));
            echo '{"result":' . json_encode($retorno) . '}';
        });

//POST não possui parâmetros na URL, e sim na requisição
$app->post('/:controller/:action', function ($controller, $action) use ($app) {

            $request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "post_" . $action), array($request));
             echo '{"result":' . json_encode($retorno) . '}';
        });

//PUT não possui parâmetros na URL, e sim na requisição
$app->put('/:controller/:action', function ($controller, $action) use ($app) {

            $request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "put_" . $action), array($request));
             echo '{"result":' . json_encode($retorno) . '}';
        });

//PUT não possui parâmetros na URL, e sim na requisição
$app->delete('/:controller/:action', function ($controller, $action) use ($app) {

            $request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "delete_" . $action), array($request));
             echo '{"result":' . json_encode($retorno) . '}';
        });

$app->run();