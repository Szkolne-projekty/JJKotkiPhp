<?php

/* Config bazy danych */
$host = getenv("DB_HOST") ?: '127.0.0.1';
$db = getenv('DB_NAME') ?: 'kotki';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '1234';

try {
    /* Ustawienia połączenia z db */
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    /* Taktyczna obsługa błędów */
    die("Błąd przy połączeniu: " . $e->getMessage());
}
