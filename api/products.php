<?php
require_once __DIR__ . '/../config.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

$pdo = Db::pdo();

$id = isset($_GET['id']) ? trim($_GET['id']) : null;
$category = isset($_GET['category']) ? trim($_GET['category']) : null;
$sub = isset($_GET['sub']) ? trim($_GET['sub']) : null;

$sql = 'SELECT id, name, brand, price, image, sub, category FROM products';
$params = [];
$conds = [];
if ($id) { $conds[] = 'id = :id'; $params[':id'] = $id; }
if ($category) { $conds[] = 'category = :category'; $params[':category'] = $category; }
if ($sub) { $conds[] = 'sub = :sub'; $params[':sub'] = $sub; }
if ($conds) { $sql .= ' WHERE ' . implode(' AND ', $conds); }
$sql .= ' ORDER BY name ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

if ($id) {
  json_response(['item' => $rows[0] ?? null]);
} else {
  json_response(['items' => $rows]);
}

