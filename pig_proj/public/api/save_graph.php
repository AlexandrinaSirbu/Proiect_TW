<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['node_count'], $data['edges'])) {
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

    $edgeCount = count($data['edges']);

    $stmt = $pdo->prepare("
        INSERT INTO graphs
          (
            session_id,
            node_count,
            edge_count,
            is_directed,
            is_weighted,
            is_connected,
            is_bipartite,
            is_tree,
            representation,
            data_json,
            svg_representation
          )
        VALUES
          (
            :sid,
            :ncount,
            :ecount,
            :directed,
            :weighted,
            :connected,
            :bipartite,
            :tree,
            :repr,
            :data,
            :svg
          )
    ");
    $stmt->execute([
        'sid'        => $sessionId,
        'ncount'     => (int)$data['node_count'],
        'ecount'     => $edgeCount,
        'directed'   => !empty($data['is_directed']) ? 1 : 0,
        'weighted'   => !empty($data['is_weighted'])  ? 1 : 0,
        'connected'  => !empty($data['is_connected']) ? 1 : 0,
        'bipartite'  => !empty($data['is_bipartite']) ? 1 : 0,
        'tree'       => !empty($data['is_tree'])      ? 1 : 0,
        'repr'       => $data['representation'] ?? 'edge_list',
        'data'       => json_encode($data['edges'], JSON_UNESCAPED_UNICODE),
        'svg'        => $data['svg'] ?? null,
    ]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'DB error', 'msg' => $e->getMessage()]);
}
