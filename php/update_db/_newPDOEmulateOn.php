<?php

//New PDO Instance. Migrate all SQL transaction code here.
$pdo_user = 'root';
$pdo_pass = '';
$pdo_host = 'localhost';
$pdo_db = 'socialitydb';
$pdo_charset = 'utf8mb4';
$pdo_conn = "mysql:host=$pdo_host";
$pdo_config = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => true
];

try {
  $pdo = new PDO($pdo_conn, $pdo_user, $pdo_pass, $pdo_config);
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

  $pdo->exec("CREATE DATABASE IF NOT EXISTS `socialitydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
 ?>
