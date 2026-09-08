<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/config/database.php';

$container = require dirname(__DIR__) . '/config/container.php';

$dispatcher = FastRoute\simpleDispatcher(
    function (RouteCollector $router): void {

        $routes = require dirname(__DIR__) . '/routes/web.php';

        $routes($router);
    }
);



$httpMethod = $_SERVER['REQUEST_METHOD'];


$uri = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);


$routeInfo = $dispatcher->dispatch(
    $httpMethod,
    $uri
);


switch ($routeInfo[0]) {

    case Dispatcher::NOT_FOUND:

        http_response_code(404);

        require dirname(__DIR__) . '/templates/error/404.php';

        break;

    case Dispatcher::METHOD_NOT_ALLOWED:

        http_response_code(405);

        $allowedMethods = $routeInfo[1];

        header(
            'Allow: ' . implode(', ', $allowedMethods)
        );

        require dirname(__DIR__) . '/templates/error/405.php';

        break;

    case Dispatcher::FOUND:

        $handler = $routeInfo[1];

        $vars = $routeInfo[2];

        $controller = $container->get($handler[0]);


        $action = $handler[1];

        $controller->$action(...array_values($vars));

        break;
}
