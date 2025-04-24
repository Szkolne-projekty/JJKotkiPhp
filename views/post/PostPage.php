<?php
global $pdo;

require 'lib/Markdown.php';

$stmt = $pdo->prepare("SELECT p.title, p.image, p.content, UNIX_TIMESTAMP(p.created_at) as created_at, u.display_name as author FROM posts p INNER JOIN users u ON p.author = u.id WHERE p.id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post) {
    Utils::redirect('/');
    exit;
}

$date = new DateTime();
$date->setTimestamp($post["created_at"]);

$polskieMiesiace = [
    1 => 'stycznia',
    2 => 'lutego',
    3 => 'marca',
    4 => 'kwietnia',
    5 => 'maja',
    6 => 'czerwca',
    7 => 'lipca',
    8 => 'sierpnia',
    9 => 'września',
    10 => 'października',
    11 => 'listopada',
    12 => 'grudnia'
];

$day = $date->format('j');
$month = $date->format('n');
$year = $date->format('Y');

$dateString = "$day {$polskieMiesiace[$month]} $year";

$markdown = new Markdown();

$contentHtml = $markdown->text($post['content']);

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/HtmlLib.php'; ?>
</head>

<body class="min-h-screen flex flex-col">
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
    </section>

    <div class="bottom-0 left-0 w-full"><?php require 'views/base/Footer.php'; ?></div>
</body>

</html>