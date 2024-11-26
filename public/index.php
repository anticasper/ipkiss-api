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


$app->run();