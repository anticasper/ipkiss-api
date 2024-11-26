<?php

use App\Domain\AccountManager;
use App\Application\AccountService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

session_start();

$manager = new AccountManager();
$service = new AccountService($manager);


$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->post('/reset', function (Request $request, Response $response) use ($service) {
    $service->resetState();
    $response->getBody()->write("OK");
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200);
});




$app->run();