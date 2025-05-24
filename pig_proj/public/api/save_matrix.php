<?php
// /pig_proj/public/api/save_matrix.php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
if (
    !isset($data['rows'], $data['cols'], $data['min'], $data['max'], $data['values'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 1) nouă sesiune
    $stmt = $pdo->prepare("
        INSERT INTO generation_sessions (user_id, name)
        VALUES (:uid, NULL)
    ");
    $stmt->execute(['uid' => $userId]);
    $sessionId = $pdo->lastInsertId();

    // 2) inserare matrice
    $stmt = $pdo->prepare("
        INSERT INTO matrices
          (session_id, row_count, col_count, min_value, max_value, `type`, values_json)
        VALUES
          (:sid, :r, :c, :min, :max, :type, :vals)
    ");
    $stmt->execute([
        'sid'   => $sessionId,
        'r'     => (int)$data['rows'],
        'c'     => (int)$data['cols'],
        'min'   => (int)$data['min'],
        'max'   => (int)$data['max'],
        'type'  => $data['type'] ?? 'generic',
        'vals'  => json_encode($data['values'], JSON_UNESCAPED_UNICODE),
    ]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'DB error', 'msg' => $e->getMessage()]);
}
