<?php
global $pdo;

if (!Utils::hasPermission('edit_post')) {
    Utils::redirect('/');
    exit();
}

if (!$id) {
    Utils::redirect('/');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post) {
    Utils::redirect('/');
    exit();
}

if ($post["author"] !== $_SESSION["user_id"] && !Utils::hasPermission('edit_all_posts')) {
    Utils::redirect('/');
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

<body>
    <?php require 'views/base/Header.php'; ?>

    <section class="mx-8 md:mx-20 my-8 pb-8 flex flex-col gap-4 items-center">
        <h1 class="text-3xl md:text-4xl font-bold">Edytuj post</h1>

        <form action="/post/edit/<?php echo $id; ?>" method="post" class="fieldset max-w-xs md:max-w-md w-full" enctype="multipart/form-data">
            <?php set_csrf() ?>

            <legend class="fieldset-legend w-full">Tytuł postu</legend>
            <input type="text" class="input w-full" name="title" placeholder="Czym karmić kota?" value="<?php echo $post["title"] ?>" />

            <legend class="fieldset-legend w-full">Zdjęcie</legend>
            <input type="file" name="image" class="file-input w-full">

            <legend class="fieldset-legend w-full">Treść</legend>
            <textarea name="content" class="textarea h-24 w-full" placeholder="# 1. Warto posiadać kota, ponieważ..."><?php echo $post["content"] ?></textarea>

            <button type="submit" class="btn mt-2">Zapisz</button>
        </form>
    </section>

    <div class="fixed bottom-0 left-0 w-full"><?php require 'views/base/Footer.php'; ?></div>
</body>

</html>