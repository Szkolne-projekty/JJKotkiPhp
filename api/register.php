<?php
global $pdo;

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

/* Sprawdzanie CSRF */
if (!is_csrf_valid()) {
    die("no u");
}

$username = $_POST['username'] ?: null;
$password = $_POST['password'] ?: null;
$displayName = $_POST['display_name'] ?: null;

if (!$username || !$password) {
    Utils::redirect('/register?error=missing_fields');
    exit();
}

if (strlen($username) < 4) {
    Utils::redirect('/register?error=username_too_short');
    exit();
}

if (strlen($username) > 50) {
    Utils::redirect('/register?error=username_too_long');
    exit();
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    Utils::redirect('/register?error=invalid_username');
    exit();
}

if (strlen($displayName) < 4) {
    Utils::redirect('/register?error=display_name_too_short');
    exit();
}

if (strlen($displayName) > 50) {
    Utils::redirect('/register?error=display_name_too_long');
    exit();
}

if (!preg_match('/^[a-zA-Z0-9_ ]+$/', $displayName)) {
    Utils::redirect('/register?error=invalid_display_name');
    exit();
}

if (strlen($password) < 4) {
    Utils::redirect('/register?error=password_too_short');
    exit();
}

if (strlen($password) > 200) {
    Utils::redirect('/register?error=password_too_long');
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
    INSERT INTO users (username, display_name, password)
    VALUES (:username, :display_name, :password)
');
$stmt->execute([
    'username' => $username,
    'display_name' => $displayName,
    'password' => $hashedPassword
]);

/* Pobranie ID nowego użytkownika */
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $_SESSION['user_id'] = $user["id"];
    Utils::redirect('/');
    exit();
} else {
    // Handle the case where the user was not found (e.g., show an error or handle as needed)
    Utils::redirect('/register?error=unexpected_error');
    exit();
}


Utils::redirect('/');
exit();
