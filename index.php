<?php

error_reporting(0);
ini_set('display_errors', 0);
setlocale(LC_TIME, 'pl_PL.UTF-8');

session_start();

require_once __DIR__ . '/lib/Database.php';
require_once __DIR__ . '/lib/Utils.php';

require_once __DIR__ . '/router.php';

// ##################################################
// ##################################################
// ##################################################
// Routy z GET

/* Index */
get('/', 'views/main/MainPage.php');

/* Strona z ciekawostkami */
get('/facts', 'views/facts/FactsPage.php');

/* Strona z blogiem */
get('/blog', 'views/blog/BlogPage.php');

/* Strona z galerią zdjęć */
get('/photos', 'views/photos/PhotosPage.php');

/* Strona logowania */
get('/login', 'views/auth/LoginPage.php');

/* Strona rejestracji */
get('/register', 'views/auth/RegisterPage.php');

/* Wylogowanie */
get('/logout', function () {

    unset($_SESSION);
    session_destroy();

    header('Location: /');
    exit();
});

/* Posty */
get('/post/create', 'views/post/CreatePostPage.php');
get('/post/edit/$id', 'views/post/EditPostPage.php');
get('/post/delete/$id', 'views/post/DeletePostPage.php');

get('/post/$id', 'views/post/PostPage.php');

// ##################################################
// ##################################################
// ##################################################
// Routy z POST

/* Logowanie */
post('/login', '/api/login.php');
post('/register', '/api/register.php');

/* Posty */
post('/post/create', '/api/createPost.php');
post('/post/edit', '/api/editPost.php');
post('/post/delete', '/api/deletePost.php');


// ##################################################
// ##################################################
// ##################################################
// Routy any

any('/404', 'views/errors/NotFoundPage.php');
