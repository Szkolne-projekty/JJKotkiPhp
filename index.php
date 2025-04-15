<?php

require_once 'lib/Router.php';

/* Inicjalizacja routera */
$router = new Router();

$router->addRoute('GET', '/', function () {
    require 'views/main/MainPage.php';
});

$router->addRoute('GET', '/facts', function () {
    require 'views/facts/FactsPage.php';
});

$router->addRoute('GET', '/photos', function () {
    require 'views/photos/PhotosPage.php';
});

$router->addRoute('GET', '/404', function () {
    require 'views/errors/NotFoundPage.php';
});

$router->handleRequest();
