<?php
global $pdo;

require 'lib/Markdown.php';

$stmt = $pdo->prepare("SELECT p.title, p.image, p.content, UNIX_TIMESTAMP(p.created_at) as created_at, u.display_name as author, p.author as author_id FROM posts p INNER JOIN users u ON p.author = u.id WHERE p.id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post) {
    Utils::redirect('/');
    exit;
}

$date = new DateTime();
$date->setTimestamp($post["created_at"]);

$day = $date->format('j');
$month = $date->format('n');
$year = $date->format('Y');

$monthName = Utils::$monthNames[$month];

$dateString = "$day $monthName $year";

$markdown = new Markdown();

$contentHtml = $markdown->text($post['content']);

$hasEditPerms = Utils::hasPermission("edit_post");
$hasEditAllPerms = Utils::hasPermission("edit_all_posts");
$hasDeletePerms = Utils::hasPermission("delete_post");

$showEditButton = ($post['author_id'] == $_SESSION['user_id'] && $hasEditPerms) || $hasEditAllPerms;
$showDeleteButton = ($post['author_id'] == $_SESSION['user_id'] && $hasDeletePerms) || $hasEditAllPerms;

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

    <!-- Tytuł i takie tam -->
    <section class="md:mx-20 max-h-80 md:max-h-[500px] relative">
        <img src="/<?php echo $post['image'] ?>" class="max-h-80 md:max-h-[500px] w-full object-cover" alt="Zdjęcie postu">

        <div class="absolute bottom-0 left-[50%] transform -translate-x-[50%] bg-base-100 text-center w-[90%] md:w-[80%] p-4">
            <h1 class="text-xl md:text-4xl font-bold"><?php echo $post['title']; ?></h1>

            <div class="pt-4 opacity-70 text-xs ">
                <span><?php echo $post['author']; ?></span>
                <span class="px-1">·</span>
                <span><?php echo $dateString; ?></span>
            </div>
        </div>
    </section>

    <!-- Zawartość postu -->
    <section class="md:mx-[calc(10%+64px)] mx-[5%] w-[90%] md:w-[calc(80%-160px+2rem)] p-4 markdown flex-grow">
        <?php echo $contentHtml; ?>

        <!-- Edytowanie i usuwanie -->
        <?php if ($showDeleteButton || $showEditButton): ?>
            <div class="flex gap-2 pt-2">
                <?php if ($showEditButton): ?>
                    <a href="/post/edit/<?php echo $id; ?>" class="link link-info link-hover text-sm">Edytuj</a>
                <?php endif; ?>
                <?php if ($showEditButton && $showDeleteButton): ?>
                    <span class="text-sm opacity-50">·</span>
                <?php endif; ?>
                <?php if ($showDeleteButton): ?>
                    <a href="/post/delete/<?php echo $id; ?>" class="link link-error link-hover text-sm">Usuń</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <div class="bottom-0 left-0 w-full"><?php require 'views/base/Footer.php'; ?></div>
</body>

</html>