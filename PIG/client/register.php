<?php
session_start();
header('Content-Type: application/json');
require 'config.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$username = $data['username'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 4 || strlen($username) < 3) {
    echo json_encode(["success" => false, "message" => "Date invalide."]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Email deja înregistrat."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password, username) VALUES (?, ?, ?)");
    $stmt->execute([$email, $hashedPassword, $username]);

    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;

    echo json_encode(["success" => true]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Eroare: " . $e->getMessage()]);
}
