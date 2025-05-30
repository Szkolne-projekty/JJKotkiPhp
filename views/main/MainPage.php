<?php
global $pdo;

/* Ciekawostka dnia */
$catFacts = file('catfacts.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$totalFacts = count($catFacts);

$dayOfYear = date('z');

$year = date('Y');
$index = ($dayOfYear + $year) % $totalFacts;

$factOfTheDay = $catFacts[$index];

$images = file('imagesForLanding.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

/* Tworzenie tablicy losowych 4 zdjęć */
$randomImages = [];
if (count($images) >= 4) {
    $randomKeys = array_rand($images, 4);
    $randomImages = array_map(function ($key) use ($images) {
        return $images[$key];
    }, $randomKeys);
} else {
    $randomImages = $images;
}

$stmt = $pdo->prepare('
    SELECT id, title, image, UNIX_TIMESTAMP(created_at) as created_at FROM posts
    ORDER BY created_at DESC
    LIMIT 3
');
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<body>
    <?php require 'views/base/Header.php' ?>

    <!-- Sekcja początkowa -->
    <section class="relative bg-base-300 bg-[url(/public/images/cat.avif)] bg-cover bg-center h-[80vh] flex items-center justify-center">
        <div class="absolute w-[100vw] h-[80vh] bg-[#000] opacity-30"></div>
        <div class="form-control flex flex-col items-center justify-center gap-2 md:gap-4 z-10 text-base-100">
            <h1 class="text-4xl md:text-6xl font-bold z-10">Kotki</h1>
            <p class="text-xl md:text-2xl text-center font-medium">Znajdziesz u nas wszystko, co ważne<br>o naszych ulubionych milutkich kotkach!</p>
            <div class="flex items-center justify-center""><a class=" btn" href="#fact-of-the-day">Ciekawostka dnia</a></div>
        </div>
    </section>

    <!-- Sekcja ciekawostki dnia -->
    <section class="mx-8 md:mx-20 my-8 flex flex-col gap-4" id="fact-of-the-day">
        <h2 class="square-header text-3xl md:text-4xl font-bold">Ciekawostka dnia</h2>
        <ul class="list-disc list-inside ml-5 md:ml-7">
            <li class="md:text-xl list-style"><?php echo $factOfTheDay; ?></li>
        </ul>
        <a href="/facts" class="btn btn-block sm:max-w-fit">Więcej ciekawostek</a>
    </section>

    <!-- Sekcja blogu -->
    <section class="mx-8 md:mx-20 my-8 flex flex-col gap-4">
        <h2 class="square-header text-3xl md:text-4xl font-bold">Najnowsze posty</h2>

        <div class="flex flex-col sm:flex-row gap-4 md:px-16">
            <?php foreach ($posts as $post): ?>
                <a href="/post/<?php echo $post["id"]; ?>" class="card bg-base-200 shadow-sm h-96 grow shrink basis-0">
                    <figure>
                        <img
                            src="/<?php echo $post['image']; ?>"
                            alt="Zdjęcie postu" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $post['title']; ?></h2>
                        <p class="text-sm opacity-70"><?php echo $post['dateString']; ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <a href="/blog" class="btn btn-block sm:max-w-fit">Więcej postów</a>
    </section>

    <!-- Sekcja galerii zdjęć -->
    <section class="mx-8 md:mx-20 my-8 flex flex-col gap-4">
        <h2 class="square-header text-3xl md:text-4xl font-bold">Galeria zdjęć</h2>
        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-2">
            <?php foreach ($randomImages as $image) : ?>
                <div class="image-container break-inside-avoid mb-2 rounded-lg shadow-sm overflow-hidden">
                    <img src="/<?= $image ?>" alt="Kotek" class="w-full h-auto">
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/photos" class="btn btn-block sm:max-w-fit">Więcej zdjęć</a>
    </section>

    <?php require 'views/base/Footer.php' ?>
</body>

</html>