<?php
require 'config.php';
$stmt = $pdo->prepare("
  SELECT gs.id AS session_id, gs.created_at AS session_at,
         ns.id AS seq_id, ns.values_json, 'numbers' AS type
    FROM generation_sessions gs
    LEFT JOIN number_sequences ns ON ns.session_id = gs.id
   WHERE gs.user_id = :uid
  UNION ALL
  SELECT gs.id, gs.created_at,
         m.id, m.values_json, 'matrix'
    FROM generation_sessions gs
    LEFT JOIN matrices m ON m.session_id = gs.id
   WHERE gs.user_id = :uid
  UNION ALL
  SELECT gs.id, gs.created_at,
         ss.id, ss.value, 'string'
    FROM generation_sessions gs
    LEFT JOIN string_sequences ss ON ss.session_id = gs.id
   WHERE gs.user_id = :uid
  UNION ALL
  SELECT gs.id, gs.created_at,
         g.id, g.data_json, 'graph'
    FROM generation_sessions gs
    LEFT JOIN graphs g ON g.session_id = gs.id
   WHERE gs.user_id = :uid
  ORDER BY session_at DESC
");
$stmt->execute(['uid' => $userId]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows, JSON_UNESCAPED_UNICODE);
