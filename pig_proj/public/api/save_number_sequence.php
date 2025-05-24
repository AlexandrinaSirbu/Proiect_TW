<?php
require 'config.php';
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['length'], $data['min'], $data['max'], $data['values'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}
$pdo->beginTransaction();

$stmt = $pdo->prepare("
    INSERT INTO generation_sessions (user_id, name)
    VALUES (:uid, NULL)
");
$stmt->execute(['uid' => $userId]);
$sessionId = $pdo->lastInsertId();

$stmt = $pdo->prepare("
    INSERT INTO number_sequences
      (session_id, length, min_value, max_value, is_sorted, values_json)
    VALUES
      (:sid, :len, :min, :max, :sort, :vals)
");
$stmt->execute([
    'sid'  => $sessionId,
    'len'  => (int)$data['length'],
    'min'  => (int)$data['min'],
    'max'  => (int)$data['max'],
    'sort' => $data['is_sorted'] ?? 'none',
    'vals' => json_encode($data['values'], JSON_UNESCAPED_UNICODE)
]);

$pdo->commit();
echo json_encode(['success' => true]);
