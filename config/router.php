<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router = $router ?? null;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});

$router->addGroup("/form", function (RouteCollector $router) {
    $router->addRoute("GET", "/view", ["\Mos\Controller\Form", "view"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Form", "process"]);
});

$router->addGroup("/dicegame", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Jess19\Controller\Game21", "init"]);
    $router->addRoute("POST", "/play", ["\Jess19\Controller\Game21", "play"]);
    $router->addRoute("POST", "/end", ["\Jess19\Controller\Game21", "end"]);
});

$router->addGroup("/yatzygame", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Jess19\Controller\Yatzy", "init"]);
    $router->addRoute("POST", "/start", ["\Jess19\Controller\Yatzy", "start"]);
    $router->addRoute("POST", "/play", ["\Jess19\Controller\Yatzy", "play"]);
});
