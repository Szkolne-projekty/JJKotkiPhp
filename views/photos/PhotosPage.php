<?php

$images = glob("public/images/cats/*.*");

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/HtmlLib.php' ?>
</head>

<body>
    <?php require 'views/base/Header.php'; ?>

    <section class="mx-8 md:mx-20 my-8 flex flex-col gap-4">
        <h1 class="square-header text-3xl md:text-4xl font-bold">Galeria zdjęć</h1>

        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-2">
            <?php foreach ($images as $image) : ?>
                <div class="break-inside-avoid mb-2 rounded-lg shadow-lg overflow-hidden">
                    <img src="/<?= $image ?>" alt="Kotek" class="w-full h-auto">
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php require 'views/base/Footer.php' ?>
</body>

</html>