<?php

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

$error = $_GET['error'] ?? null;

$showInvalidCredentialsError = false;

if ($error === "invalid_credentials") {
    $showInvalidCredentialsError = true;
}

$redirectTo = $_GET['redirect'] ?? null;
if ($redirectTo) {
    $redirectTo = htmlspecialchars($redirectTo, ENT_QUOTES, 'UTF-8');
} else {
    $redirectTo = '/';
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

    <section class="flex flex-col grow items-center justify-center">
        <h1 class="text-3xl font-bold md:text-4xl">Logowanie</h1>
        <form action="/login" method="post" class="flex w-full max-w-xs flex-col gap-2 md:max-w-md">
            <?php set_csrf() ?>
            <input type="hidden" name="redirect" value="<?= $redirectTo; ?>" />

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Login</span>
                </div>
                <input type="text" placeholder="jkowalski" name="username" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Hasło</span>
                </div>
                <input
                    type="password"
                    placeholder="********"
                    name="password"
                    class="input input-bordered w-full" />
            </label>

            <?php if ($showInvalidCredentialsError): ?>
                <p class="text-error text-sm">Niepoprawne dane logowania!</p>
            <?php endif; ?>
            <a href="/register" class="link link-hover">Nie masz jeszcze konta? Zarejestruj się</a>
            <button type="submit" class="btn mt-1">Zaloguj się</button>
        </form>
    </section>

    <?php require 'views/base/Footer.php' ?>
</body>

</html>