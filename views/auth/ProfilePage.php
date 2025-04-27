<?php
global $pdo;

if (!Utils::isLoggedIn()) {
    Utils::redirect("/login?redirect=/profile");
    exit();
}

if (!$_SESSION["user_id"]) {
    Utils::redirect("/");
    exit();
}

$stmt = $pdo->prepare('SELECT u.display_name, u.username, r.role_name as role FROM users u INNER JOIN roles r ON u.role_id = r.id WHERE u.id = ?');
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    Utils::redirect("/");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/HtmlLib.php' ?>
</head>

<body class="flex flex-col min-h-[100dvh]">
    <?php require 'views/base/Header.php' ?>

    <section class="flex flex-col grow items-center justify-center gap-3">
        <h1 class="text-3xl font-bold md:text-4xl">Profil</h1>

        <div class="flex flex-col gap-1">
            <p class="text-lg"><span class="font-bold">Wyświetlana nazwa:</span> <?= htmlspecialchars($user["display_name"], ENT_QUOTES, 'UTF-8'); ?></p>
            <p class="text-lg"><span class="font-bold">Nazwa użytkownika:</span> <?= htmlspecialchars($user["username"], ENT_QUOTES, 'UTF-8'); ?></p>
            <p class="text-lg"><span class="font-bold">Rola:</span> <?= htmlspecialchars($user["role"], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <a href="/logout" class="btn">Wyloguj się</a>

    </section>

    <?php require 'views/base/Footer.php' ?>
</body>

</html>