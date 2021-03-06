<?php

  // Create instance of HashIDs.
  require("../../vendor/autoload.php");
  use Hashids\Hashids;
  $hashId = new Hashids('socialitySalt44331122', 7);

  //New PDO Instance. Migrate all SQL transaction code here.
  $pdo_user = 'root';
  $pdo_pass = '';
  $pdo_host = 'localhost';
  $pdo_db = 'socialitydb';
  $pdo_charset = 'utf8mb4';
  $pdo_conn = "mysql:host=$pdo_host;dbname=$pdo_db;charset=$pdo_charset";
  $pdo_config = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
  ];

  try {
    $pdo = new PDO($pdo_conn, $pdo_user, $pdo_pass, $pdo_config);
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }
  //echo (class_exists('PDO')) ? "PDO EXISTS": "PDO DOESN'T EXIST";
  // Create Session
  session_start();

 ?>
