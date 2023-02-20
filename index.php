<?php
declare(strict_types=1);
require __DIR__ . "/vendor/autoload.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

// $http_authorization = $_SERVER["HTTP_AUTHORIZATION"];

//other way of getting the autorization header
// $header = apache_request_headers();
// $http_authorization = $header["Authorization"];
$database = new Database("localhost", "ecommercedb", "root", "");
$database->getConnection();
$user_gateway = new UserGateway($database);

$codec = new JWTCodec;

header("Access-Control-Allow-Origin: *");

$auth = new Auth($user_gateway, $codec);
if ($parts[2] !== 'user' && $_SERVER["REQUEST_METHOD"] === "POST") {

    if (!$auth->authenticateAccessToken()) {
        exit;
    }
}
switch ($parts[2]) {
    case 'products':
        $id = $parts[3] ?? null;

        $gateway = new ProductGateway($database);

        $controller = new ProductController($gateway, $auth);
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;

    case 'reviews':
        $id = $parts[3] ?? null;
        $productid = $parts[5] ?? null;

        $gateway = new ReviewGateway($database);

        $controller = new ReviewController($gateway);
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id, $productid);
        break;

    case 'user':
        $action = $parts[3] ?? null;
        if ($action === null) {
            http_response_code(404);
        }

        $gateway = new UserGateway($database);

        $controller = new UserController($gateway);
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $action);
        break;

    default:
        http_response_code(404);
        exit;
}