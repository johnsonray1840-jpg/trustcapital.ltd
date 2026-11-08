<?php
header('Content-Type: text/plain');
try {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $db   = getenv('DB_DATABASE') ?: 'defaultdb';
    $user = getenv('DB_USERNAME') ?: 'root';
    $pass = getenv('DB_PASSWORD') ?: '';

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $stmt = $pdo->query("SELECT site_name FROM general_settings LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "DB_CONNECTED_OK: " . json_encode($row);
} catch (\Throwable $e) {
    echo "DB_ERROR: " . $e->getMessage();
}
