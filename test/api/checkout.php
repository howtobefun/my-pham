<?php
require_once __DIR__ . '/../config.php';
start_session_once();
$pdo = Db::pdo();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { json_response(['error'=>'method_not_allowed'], 405); exit; }

$uid = require_user();
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) { json_response(['error'=>'bad_json'], 400); exit; }
$items = $body['items'] ?? [];
if (!is_array($items) || !count($items)) { json_response(['error'=>'empty_cart'], 400); exit; }

try {
  $pdo->beginTransaction();
  $total = 0.0;
  // Lock rows and verify stock
  $lines = [];
  foreach ($items as $it) {
    $pid = (string)($it['id'] ?? '');
    $qty = (int)($it['quantity'] ?? 0);
    if ($qty <= 0 || $pid === '') { throw new Exception('invalid_item'); }
    $stmt = $pdo->prepare('SELECT id, price, stock FROM products WHERE id = :id FOR UPDATE');
    $stmt->execute([':id'=>$pid]);
    $p = $stmt->fetch();
    if (!$p) { throw new Exception('not_found:'.$pid); }
    if ((int)$p['stock'] < $qty) { throw new Exception('out_of_stock:'.$pid); }
    $lineTotal = (float)$p['price'] * $qty;
    $total += $lineTotal;
    $lines[] = ['id'=>$pid, 'qty'=>$qty, 'price'=>(float)$p['price']];
  }

  // Create order
  $stmt = $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (:uid, :total)');
  $stmt->execute([':uid'=>$uid, ':total'=>$total]);
  $orderId = (int)$pdo->lastInsertId();

  // Insert items and decrement stock
  $ins = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:oid, :pid, :qty, :price)');
  $dec = $pdo->prepare('UPDATE products SET stock = stock - :qty WHERE id = :pid');
  foreach ($lines as $ln) {
    $ins->execute([':oid'=>$orderId, ':pid'=>$ln['id'], ':qty'=>$ln['qty'], ':price'=>$ln['price']]);
    $dec->execute([':qty'=>$ln['qty'], ':pid'=>$ln['id']]);
  }

  $pdo->commit();
  json_response(['ok'=>true, 'order_id'=>$orderId, 'total'=>$total]);
} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  $msg = $e->getMessage();
  $code = 400;
  if (str_starts_with($msg, 'out_of_stock')) $code = 409;
  json_response(['error'=>$msg], $code);
}

