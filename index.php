<?php

require_once 'lib/Router.php';

$router = new Router();

$router->addRoute('GET', '/', function () {
    require 'views/main/MainPage.php';
});

$router->handleRequest();
