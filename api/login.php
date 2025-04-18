<?php
global $pdo;

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

$username = $_POST['username'];
$password = $_POST['password'];

/* Wyszukiwanie użytkownika w dazie banych */
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* Prymitywne sprawdzanie prawdziwości danych */
if ($user && password_verify($password, $user["password"])) {
    $_SESSION['user_id'] = $user['id'];
    Utils::redirect('/');
    exit();
} else {
    Utils::redirect('/login?error=invalid_credentials');
}
