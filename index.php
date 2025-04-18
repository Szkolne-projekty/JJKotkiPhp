<?php

session_start();

require_once __DIR__ . '/lib/Database.php';
require_once __DIR__ . '/lib/Utils.php';

require_once __DIR__ . '/router.php';

// ##################################################
// ##################################################
// ##################################################
// Routy z GET

// Index
get('/', 'views/main/MainPage.php');

// Strona z ciekawostkami
get('/facts', 'views/facts/FactsPage.php');

// Strona z galerią zdjęć
get('/photos', 'views/photos/PhotosPage.php');

// Strona logowania
get('/login', 'views/auth/LoginPage.php');

// Strona rejestracji
get('/register', 'views/auth/RegisterPage.php');

// Wylogowanie
get('/logout', function () {

    unset($_SESSION);
    session_destroy();

    header('Location: /');
    exit();
});


// ##################################################
// ##################################################
// ##################################################
// Routy z POST
post('/login', '/api/login.php');

post('/register', '/api/register.php');


// ##################################################
// ##################################################
// ##################################################
// Routy any

any('/404', 'views/errors/NotFoundPage.php');
