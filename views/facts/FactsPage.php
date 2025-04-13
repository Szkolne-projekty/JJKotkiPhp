<?php

$catFacts = file('catfacts.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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

    <section class="mx-8 md:mx-20 my-8 flex flex-col gap-4">
        <h1 class="square-header text-3xl md:text-4xl font-bold">Ciekawostki o kotach</h1>
        <p class="md:text-xl">Tutaj znajdziesz wszystkie ciekawostki o kotach, które udało nam się zebrać.</p>
        <ol class="list-decimal list-inside list">
            <?php foreach ($catFacts as $fact): ?>
                <li><?php echo $fact ?></li>
            <?php endforeach; ?>
        </ol>
    </section>
</body>

</html>