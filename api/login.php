<?php
global $pdo;

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

/* Sprawdzanie CSRF */
if (!is_csrf_valid()) {
    die("no u");
}

$username = $_POST['username'];
$password = $_POST['password'];
$redirectTo = $_POST['redirect'] ?? null;

/* Wyszukiwanie użytkownika w dazie banych */
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* Sprawdzanie prawdziwości danych */
if ($user && password_verify($password, $user["password"])) {
    $_SESSION['user_id'] = $user['id'];

    if ($redirectTo) {
        $redirectTo = htmlspecialchars($redirectTo, ENT_QUOTES, 'UTF-8');
    } else {
        $redirectTo = '/';
    }

    Utils::redirect($redirectTo);
    exit();
} else {
    Utils::redirect('/login?error=invalid_credentials');
}
