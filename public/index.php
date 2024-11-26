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


$app->get('/balance', function (Request $request, Response $response) use ($service) {
    $queryParams = $request->getQueryParams();
    $accountId = $queryParams['account_id'] ?? null;

    if (!$accountId || ($balance = $service->getBalance($accountId)) === null) {
        $response->getBody()->write('0');
        return $response->withStatus(404);
    }

    $response->getBody()->write((string) $balance);
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200);
});

$app->post('/event', function (Request $request, Response $response) use ($service) {
    $data = $request->getParsedBody();

    switch ($data['type']) {
        case 'deposit':
            if (!isset($data['destination'], $data['amount']) || !is_numeric($data['amount'])) {
                return $response->withStatus(400);
            }
            $result = $service->deposit($data['destination'], $data['amount']);
            $response->getBody()->write(json_encode(['destination' => $result]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        case 'withdraw':
            if (!isset($data['origin'], $data['amount']) || !is_numeric($data['amount'])) {
                return $response->withStatus(400);
            }
            $result = $service->withdraw($data['origin'], $data['amount']);
            if (!$result) {
                $response->getBody()->write('0');
                return $response->withStatus(404);
            }
            $response->getBody()->write(json_encode(['origin' => $result]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        case 'transfer':
            if (!isset($data['origin'], $data['destination'], $data['amount']) || !is_numeric($data['amount'])) {
                return $response->withStatus(400);
            }

            $result = $service->transfer($data['origin'], $data['destination'], $data['amount']);
            if (!$result) {
                $response->getBody()->write('0');
                return $response->withStatus(404);
            }
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        default:
            return $response->withStatus(400);
    }
});


$app->run();