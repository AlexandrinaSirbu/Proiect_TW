<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
$dbHost = '127.0.0.1';
$dbName = 'pig_db';
$dbUser = 'root';
$dbPass = '';
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}
if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}
$userId = (int) $_SESSION['user_id'];
