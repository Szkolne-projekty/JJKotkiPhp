<?php
global $pdo;

$uploadDirectory = Utils::getEnv('UPLOAD_DIR', 'uploads/');

if (!Utils::isLoggedIn()) {
    Utils::redirect('/login');
    exit();
}

if (!Utils::hasPermission('create_post')) {
    Utils::redirect('/');
    exit();
}

/* Dane z forma */
$title = $_POST['title'] ?? null;
$content = $_POST['content'] ?? null;

$author = $_SESSION['user_id'] ?? null;

$image = $_FILES["image"];

if (!isset($image) || $image['error'] !== UPLOAD_ERR_OK) {
    Utils::redirect('/post/create?error=file_upload_error');
    exit();
}

/* Utworzenie folderu "uploads", jeśli nie istnieje */
if (!is_dir($uploadDirectory)) {
    if (!mkdir($uploadDirectory, 0755, true)) {
        Utils::redirect('/post/create?error=directory_creation_failed');
        exit();
    }
}

/* Przygotowanie docelowej ścieżki zdjęcia */
$imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));
$targetFile = $uploadDirectory . Utils::generateUuid() . '.' . $imageFileType;

/* Sprawdzonko, czy przesłany plik jest obrazem */
$check = getimagesize($image["tmp_name"]);
if (!$check) {
    Utils::redirect('/post/create?error=file_not_image');
    exit();
}

/* Sprawdzenie rozmiaru pliku */
if ($image["size"] > 5000000) {
    Utils::redirect('/post/create?error=file_too_large');
    exit();
}

/* Sprawdzenie rozszerzenia zdjęcia */
$allowedExtensions = ['jpg', 'jpeg', 'png', 'avif', 'webp'];
if (!in_array($imageFileType, $allowedExtensions)) {
    Utils::redirect('/post/create?error=file_extension_not_allowed');
    exit();
}

/* Przeniesienie pliku do folderu uploadów */
if (!move_uploaded_file($image["tmp_name"], $targetFile)) {
    Utils::redirect('/post/create?error=file_upload_error');
    echo "upload_error";
    exit();
}

/* Sprawdzenie poprawności pozostałych danych */
if (!$title || !$content) {
    Utils::redirect('/post/create?error=missing_fields');
    exit();
}

if (strlen($title) < 4) {
    Utils::redirect('/post/create?error=title_too_short');
    exit();
}

if (strlen($title) > 255) {
    Utils::redirect('/post/create?error=title_too_long');
    exit();
}

if (strlen($content) < 4) {
    Utils::redirect('/post/create?error=content_too_short');
    exit();
}

if (strlen($content) > 10000) {
    Utils::redirect('/post/create?error=content_too_long');
    exit();
}

/* Dodanie posta do bazy danych */
$stmt = $pdo->prepare('
    INSERT INTO posts (title, content, author, image)
    VALUES (:title, :content, :author_id, :image_path)
');
$stmt->execute([
    'title' => $title,
    'content' => $content,
    'author_id' => $author,
    'image_path' => $targetFile
]);

Utils::redirect('/posts?success=post_created');
