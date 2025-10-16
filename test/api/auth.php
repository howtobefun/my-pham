<?php
require_once __DIR__ . '/../config.php';
start_session_once();
$pdo = Db::pdo();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

function body_json(){
  $raw = file_get_contents('php://input');
  $j = json_decode($raw, true);
  return is_array($j) ? $j : [];
}

if ($method === 'POST') {
  $action = $_GET['action'] ?? '';
  $data = body_json();

  if ($action === 'register') {
    $email = trim($data['email'] ?? '');
    $pass = trim($data['password'] ?? '');
    if (!$email || !$pass) { json_response(['error'=>'missing_fields'], 400); exit; }
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    try {
      $stmt = $pdo->prepare('INSERT INTO users (email, password_hash) VALUES (:e, :h)');
      $stmt->execute([':e'=>$email, ':h'=>$hash]);
      json_response(['ok'=>true]);
    } catch (Throwable $e) {
      json_response(['error'=>'email_taken'], 409);
    }
    exit;
  }

  if ($action === 'login') {
    $email = trim($data['email'] ?? '');
    $pass = trim($data['password'] ?? '');
    if (!$email || !$pass) { json_response(['error'=>'missing_fields'], 400); exit; }
    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = :e');
    $stmt->execute([':e'=>$email]);
    $u = $stmt->fetch();
    if (!$u || !password_verify($pass, $u['password_hash'])) { json_response(['error'=>'invalid_credentials'], 401); exit; }
    $_SESSION['uid'] = (int)$u['id'];
    json_response(['ok'=>true]);
    exit;
  }

  if ($action === 'logout') {
    session_destroy();
    json_response(['ok'=>true]);
    exit;
  }
}

if ($method === 'GET') {
  if (($_GET['action'] ?? '') === 'me') {
    $uid = current_user_id();
    if (!$uid) { json_response(['user'=>null]); exit; }
    $stmt = $pdo->prepare('SELECT id, email, created_at FROM users WHERE id = :id');
    $stmt->execute([':id'=>$uid]);
    $u = $stmt->fetch();
    json_response(['user'=>$u]);
    exit;
  }
}

json_response(['error'=>'not_found'], 404);

