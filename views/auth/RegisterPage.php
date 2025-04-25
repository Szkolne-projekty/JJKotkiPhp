<?php

if (Utils::isLoggedIn()) {
    Utils::redirect('/');
}

$error = $_GET['error'] ?? null;

$errors = [
    "missing_fields" => "Braku wymaganych pól",
    "invalid_username" => "Niepoprawna nazwa użytkownika",
    "invalid_password" => "Niepoprawne hasło",
    "user_exists" => "Nazwa użytkownika jest zajęta",
    "username_too_short" => "Nazwa użytkownika musi mieć minimum 4 znaki",
    "username_too_long" => "Nazwa użytkownika może mieć maksymalnie 50 znaków",
    "password_too_short" => "Hasło musi mieć minimum 4 znaki",
    "password_too_long" => "Hasło może mieć maksymalnie 200 znaków",
    "invalid_display_name" => "Niepoprawna nazwa wyświetlana",
    "display_name_too_short" => "Nazwa wyświetlana musi mieć minimum 4 znaki",
    "display_name_too_long" => "Nazwa wyświetlana może mieć maksymalnie 50 znaków",
];

$errorMessage = $errors[$error] ?? null;

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

    <section class="flex flex-col items-center justify-center grow">
        <h1 class="text-3xl font-bold md:text-4xl">Rejestracja</h1>
        <form action="/register" method="post" class="flex w-full max-w-xs flex-col gap-2 md:max-w-md">
            <?php set_csrf() ?>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Login</span>
                </div>
                <input type="text" placeholder="jkowalski" name="username" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Wyświetlana nazwa</span>
                </div>
                <input type="text" placeholder="Jan Kowalski" name="display_name" class="input input-bordered w-full" />
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
            <?php if ($errorMessage): ?>
                <p class="text-error text-sm"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <a href="/login" class="link link-hover">Masz już konto? Zaloguj się</a>
            <button type="submit" class="btn mt-1">Zarejestruj się</button>
        </form>
    </section>

    <?php require 'views/base/Footer.php' ?>
</body>

</html>