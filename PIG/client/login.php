<?php
session_start();
header('Content-Type: application/json');
require 'config.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT username, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode(["success" => false, "message" => "Email sau parolă greșită."]);
        exit;
    }

    $_SESSION['email'] = $email;
    $_SESSION['username'] = $user['username'];

    echo json_encode(["success" => true]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Eroare: " . $e->getMessage()]);
}
