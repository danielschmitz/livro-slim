<?php
session_start(); //iniciando a sessão do php

//incuindo os arquivos de configuração e acesso a banco
include "config.php";
include "DB.php";

// incluindo as bibliotecas do composer
require 'vendor/autoload.php';

//Instanciando $app como uma classe Slim
$app = new \Slim\Slim(array(
    'debug' => false //debug é false para renderizar  erros corretamente
));

//Todas as nossas respostas serão JSON
$app->contentType("application/json");

//Caso ocorra algum erro na aplicação (Excepyion), 
//  essa função será executada e um erro padrão em JSON
//     será retornado ao cliente
$app->error(function ( Exception $e = null) use ($app) {
         echo '{"error":{"text":"'. $e->getMessage() .'"}}';
        });

// REQUISICAO
// GET pode possuir um parametro na URL
$app->get('/:controller/:action(/:parameter)', function ($controller, $action, $parameter = null) use($app) {

            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "get_" . $action), array($parameter));
            echo '{"result":' . json_encode($retorno) . '}';
        });

// REQUISICAO
// POST não possui parâmetros na URL, e sim na requisição
$app->post('/:controller/:action', function ($controller, $action) use ($app) {

            $request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "post_" . $action), array($request));
             echo '{"result":' . json_encode($retorno) . '}';
        });

// REQUISICAO
// PUT não possui parâmetros na URL, e sim na requisição
$app->put('/:controller/:action', function ($controller, $action) use ($app) {

            $request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "put_" . $action), array($request));
             echo '{"result":' . json_encode($retorno) . '}';
        });

// REQUISICAO
// DELETE não possui parâmetros na URL, e sim na requisição
$app->delete('/:controller/:action', function ($controller, $action) use ($app) {

            $request = json_decode(\Slim\Slim::getInstance()->request()->getBody());
            include_once "classes/{$controller}.php";
            $classe = new $controller();
            $retorno = call_user_func_array(array($classe, "delete_" . $action), array($request));
             echo '{"result":' . json_encode($retorno) . '}';
        });

$app->run();