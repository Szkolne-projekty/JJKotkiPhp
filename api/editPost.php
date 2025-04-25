<?php
global $pdo;

$uploadDirectory = Utils::getEnv('UPLOAD_DIR', 'uploads/');

if (!Utils::isLoggedIn()) {
    Utils::redirect('/login');
    exit();
}

/* Sprawdzanie CSRF */
if (!is_csrf_valid()) {
    die("no u");
}

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

/* Dane z forma */
$title = $_POST['title'] ?? null;
$content = $_POST['content'] ?? null;
$author = $_SESSION['user_id'] ?? null;
$image = $_FILES["image"] ?? null;

$targetFile = null;
$imageFileType = null;
$changeImage = false;
if ($image["size"] > 0) {
    if ($image['error'] !== UPLOAD_ERR_OK) {
        Utils::redirect('/post/edit/' . $id . '?error=file_upload_error');
        exit();
    }
    /* Przygotowanie docelowej ścieżki zdjęcia */
    $imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));
    $targetFile = $uploadDirectory . Utils::generateUuid() . '.' . $imageFileType;

    /* Utworzenie folderu "uploads", jeśli nie istnieje */
    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0755, true)) {
            Utils::redirect('/post/edit/' . $id . '?error=directory_creation_failed');
            exit();
        }
    }

    /* Sprawdzonko, czy przesłany plik jest obrazem */
    $check = getimagesize($image["tmp_name"]);
    if (!$check) {
        Utils::redirect('/post/edit/' . $id . '?error=file_not_image');
        exit();
    }

    /* Sprawdzenie rozmiaru pliku */
    if ($image["size"] > 5000000) {
        Utils::redirect('/post/edit/' . $id . '?error=file_too_large');
        exit();
    }

    /* Sprawdzenie rozszerzenia zdjęcia */
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'avif', 'webp'];
    if (!in_array($imageFileType, $allowedExtensions)) {
        Utils::redirect('/post/edit/' . $id . '?error=invalid_file_extension');
        exit();
    }

    /* Przeniesienie pliku do folderu uploadów */
    if (!move_uploaded_file($image["tmp_name"], $targetFile)) {
        Utils::redirect('/post/edit/' . $id . '?error=file_upload_error');
        echo "upload_error";
        exit();
    }

    $changeImage = true;
}

/* Sprawdzenie poprawności pozostałych danych */
if (!$title || !$content) {
    Utils::redirect('/post/edit/' . $id . '?error=missing_fields');
    exit();
}

if (strlen($title) < 4) {
    Utils::redirect('/post/edit/' . $id . '?error=title_too_short');
    exit();
}

if (strlen($title) > 255) {
    Utils::redirect('/post/edit/' . $id . '?error=title_too_long');
    exit();
}

if (strlen($content) < 4) {
    Utils::redirect('/post/edit/' . $id . '?error=content_too_short');
    exit();
}

if (strlen($content) > 10000) {
    Utils::redirect('/post/edit/' . $id . '?error=content_too_long');
    exit();
}

/* Przygotowanie zapytania SQL */
$sql = 'UPDATE posts SET title = ?, content = ?' . ($changeImage ? ', image = ?' : '') . ' WHERE id = ?';

$stmt = $pdo->prepare($sql);

$params = [$title, $content];

if ($changeImage) {
    $params[] = $targetFile;
}
$params[] = $id;

$stmt->execute($params);
if ($stmt->rowCount() > 0) {
    if ($changeImage && $post['image'] && file_exists($post['image'])) {
        try {
            if ($post['image'] && file_exists($post['image'])) {
                unlink($post['image']);
            }
        } catch (Exception $e) {
            /* Nie obchodzi nas błąd */
        }
    }

    Utils::redirect('/post/' . $id);
} else {
    Utils::redirect('/post/edit/' . $id . '?error=update_failed');
}
