<?php
global $pdo;

$stmt = $pdo->prepare('
    SELECT id, title, image, UNIX_TIMESTAMP(created_at) as created_at FROM posts
    ORDER BY created_at DESC
');
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$posts) {
    Utils::redirect('/');
    exit;
}

foreach ($posts as &$post) {
    $date = new DateTime();
    $date->setTimestamp($post["created_at"]);

    $day = $date->format('j');
    $month = $date->format('n');
    $year = $date->format('Y');

    $monthName = Utils::$monthNames[$month];
    $post["dateString"] = "$day $monthName $year";
}
unset($post);

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/HtmlLib.php'; ?>
</head>

<body class="flex flex-col min-h-screen">
    <?php require 'views/base/Header.php'; ?>

    <section class="mx-8 md:mx-20 my-8 flex flex-col gap-4 grow">
        <h2 class="square-header text-3xl md:text-4xl font-bold">Blog</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:px-16">
            <?php foreach ($posts as $post): ?>
                <a href="/post/<?php echo $post["id"]; ?>" class="card bg-base-200 shadow-sm h-96 w-full flex flex-col">
                    <figure class="h-2/3 overflow-hidden">
                        <img
                            src="/<?php echo $post['image']; ?>"
                            alt="Zdjęcie postu"
                            class="w-full h-full object-cover" />
                    </figure>
                    <div class="card-body flex flex-col justify-between h-1/3">
                        <h2 class="card-title"><?php echo $post['title']; ?></h2>
                        <p class="text-sm opacity-70 grow-0"><?php echo $post['dateString']; ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>


    <?php require 'views/base/Footer.php'; ?>
</body>

</html>