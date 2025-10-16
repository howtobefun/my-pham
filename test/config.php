<?php
// Simple PDO MySQL connection using env vars from docker-compose
class Db {
  public static function pdo(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $db   = getenv('DB_NAME') ?: 'yessstyle';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Ensure table exists on app start (in addition to DB init)
    $pdo->exec(
      'CREATE TABLE IF NOT EXISTS products (
         id VARCHAR(64) PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         brand VARCHAR(255) NOT NULL,
         price DECIMAL(10,2) NOT NULL,
         image VARCHAR(512) NOT NULL,
         sub VARCHAR(64) NOT NULL,
         category VARCHAR(64) NOT NULL,
         stock INT NOT NULL DEFAULT 0
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
    // Ensure stock column exists (for existing DBs)
    try { $pdo->exec('ALTER TABLE products ADD COLUMN IF NOT EXISTS stock INT NOT NULL DEFAULT 0'); } catch (Throwable $e) {}
    // Minimal auth & order tables
    $pdo->exec(
      'CREATE TABLE IF NOT EXISTS users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         email VARCHAR(255) NOT NULL UNIQUE,
         password_hash VARCHAR(255) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
    $pdo->exec(
      'CREATE TABLE IF NOT EXISTS orders (
         id BIGINT AUTO_INCREMENT PRIMARY KEY,
         user_id INT NOT NULL,
         total DECIMAL(10,2) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (user_id) REFERENCES users(id)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
    $pdo->exec(
      'CREATE TABLE IF NOT EXISTS order_items (
         id BIGINT AUTO_INCREMENT PRIMARY KEY,
         order_id BIGINT NOT NULL,
         product_id VARCHAR(64) NOT NULL,
         quantity INT NOT NULL,
         price DECIMAL(10,2) NOT NULL,
         FOREIGN KEY (order_id) REFERENCES orders(id),
         FOREIGN KEY (product_id) REFERENCES products(id)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
    return $pdo;
  }
}

function json_response($data, int $code = 200): void {
  http_response_code($code);
  header('Content-Type: application/json');
  echo json_encode($data);
}

function start_session_once(): void {
  if (session_status() === PHP_SESSION_NONE) { session_start(); }
}

function current_user_id(): ?int {
  start_session_once();
  return isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : null;
}

function require_user(): int {
  $uid = current_user_id();
  if (!$uid) { json_response(['error' => 'unauthorized'], 401); exit; }
  return $uid;
}

