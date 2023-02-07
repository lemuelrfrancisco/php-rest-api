<?php
declare(strict_types=1);
require __DIR__ . "/vendor/autoload.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");
$parts = explode("/", $_SERVER["REQUEST_URI"]);

switch ($parts[2]) {
    case 'products':
        $id = $parts[3] ?? null;

        $database = new Database("localhost", "ecommercedb", "root", "");
        $database->getConnection();
        $gateway = new ProductGateway($database);

        $controller = new ProductController($gateway);
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;

    default:
        http_response_code(404);
        exit;
}