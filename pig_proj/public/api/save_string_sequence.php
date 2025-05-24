<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['length'], $data['charset'], $data['value'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO generation_sessions (user_id, name)
        VALUES (:uid, NULL)
    ");
    $stmt->execute(['uid' => $userId]);
    $sessionId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO string_sequences
          (session_id, length, charset, value)
        VALUES
          (:sid, :len, :cs, :val)
    ");
    $stmt->execute([
        'sid' => $sessionId,
        'len' => (int)$data['length'],
        'cs'  => $data['charset'],
        'val' => $data['value'],
    ]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'DB error', 'msg' => $e->getMessage()]);
}
