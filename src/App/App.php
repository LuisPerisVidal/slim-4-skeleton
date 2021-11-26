<?php
use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$app = AppFactory::create();
//$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware = $app->addErrorMiddleware(false, false, false);
$app->addBodyParsingMiddleware();

require_once __DIR__ ."/Routes.php";


$app->run();
