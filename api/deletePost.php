<?php
global $pdo;

if (!Utils::isLoggedIn()) {
    Utils::redirect('/login');
    exit();
}

if (!Utils::hasPermission('delete_post')) {
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

$stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
$stmt->execute([$id]);

if ($post["image"] && file_exists($post["image"])) {
    unlink($post["image"]);
}

Utils::redirect('/blog?success=post_deleted');
