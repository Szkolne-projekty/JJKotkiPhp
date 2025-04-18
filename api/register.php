<?php
session_start();

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

$username = $_POST['username'] ?: null;
$password = $_POST['password'] ?: null;

if (!$username || !$password) {
    Utils::redirect('/register?error=missing_fields');
    exit();
}
if (strlen($username) < 3 || strlen($username) > 50) {
    Utils::redirect('/register?error=invalid_username');
    exit();
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    Utils::redirect('/register?error=invalid_username');
    exit();
}

if (strlen($password) < 4 || strlen($password) > 50) {
    Utils::redirect('/register?error=invalid_password');
    exit();
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

/* Sprawdzenie, czy konto już nie istnieje */
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    Utils::redirect('/register?error=user_exists');
    exit();
}

/* Dodanie użytkownika do bazy danych */
$stmt = $pdo->prepare('
    INSERT INTO users (username, password)
    VALUES (:username, :password)
');
$stmt->execute([
    'username' => $username,
    'password' => $hashedPassword
]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user_id'] = $user["id"];

Utils::redirect('/');
exit();
