<?php

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

$error = $_GET['error'] ?? null;

$showInvalidCredentialsError = false;

if ($error === "invalid_credentials") {
    $showInvalidCredentialsError = true;
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/HtmlLib.php' ?>
</head>

<body>
    <div class="absolute top-0 left-0 w-full"><?php require 'views/base/Header.php' ?></div>

    <section class="absolute left-0 min-w-screen top-0 flex flex-col min-h-[100dvh] items-center justify-center">
        <h1 class="text-3xl font-bold md:text-4xl">Logowanie</h1>
        <form action="/login" method="post" class="flex w-full max-w-xs flex-col gap-2 md:max-w-md">
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

    <div class="absolute bottom-0 left-0 w-full">
        <?php require 'views/base/Footer.php' ?>
    </div>
</body>

</html>