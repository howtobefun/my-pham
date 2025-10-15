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
         category VARCHAR(64) NOT NULL
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

