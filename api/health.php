<?php
require_once __DIR__ . '/../config.php';

try {
  $pdo = Db::pdo();
  $stmt = $pdo->query('SELECT 1 as ok');
  $ok = $stmt->fetchColumn();
  json_response(['status' => 'ok', 'db' => (int)$ok === 1]);
} catch (Throwable $e) {
  json_response(['status' => 'error', 'message' => $e->getMessage()], 500);
}

