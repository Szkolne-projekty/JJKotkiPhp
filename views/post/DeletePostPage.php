<?php
global $pdo;

if (!$id) {
    header("Location: /");
    exit();
}

if (!Utils::isLoggedIn()) {
    header("Location: /login?redirect=/post/delete/$id");
    exit();
}

if (!Utils::hasPermission("delete_post")) {
    header("Location: /");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post) {
    header("Location: /");
    exit();
}

if ($post['author'] != $_SESSION['user_id'] && !Utils::hasPermission("delete_all_posts")) {
    header("Location: /");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/HtmlLib.php'; ?>
</head>

<body class="min-h-[100dvh] flex flex-col">
    <?php require 'views/base/Header.php'; ?>

    <section class="flex flex-col grow justify-center items-center gap-2">
        <h2 class="md:text-3xl text-2xl font-bold">Czy napewno chcesz usunąć post</h2>
        <p class="font-medium text-lg"><?= $post["title"]; ?></p>
        <p class="text-sm opacity-70">Nie można tego cofnąć!</p>

        <div class="flex gap-2">
            <a href="/post/<?= $post["id"]; ?>" class="btn">Nie</a>
            <form action="/post/delete/<?= $post["id"]; ?>" method="POST">
                <input type="hidden" name="id" value="<?= $post["id"]; ?>">
                <button type="submit" class="btn btn-error">Tak</button>
            </form>
    </section>

    <?php require 'views/base/Footer.php'; ?>
</body>

</html>