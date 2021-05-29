<?php

  //Resolve location of files.
  $loc_vendorFolder = "vendor/";
  $loc_currentLocation = $_SERVER["PHP_SELF"];
  $loc_isInPHPFolder = (strpos($loc_currentLocation, "php/") !== false);
  $locVar_venderFolder = ($loc_isInPHPFolder) ? "../$loc_vendorFolder": $loc_vendorFolder;

  //Works as a one-line solution, but may run into issues when used by other contributors.
  //$locConst_vendor = $_SERVER["DOCUMENT_ROOT"]."/Group5_website/vendor/";

  // Create instance of HashIDs.
  require($locVar_venderFolder."autoload.php");
  use Hashids\Hashids;
  $hashId = new Hashids('socialitySalt44331122', 7);

  //$hid_encodedVar = $hashId->encode(69420);
  //Decoded var is always array wut.
  //$hid_decodedVar = $hashId->decode($hid_encodedVar);
  //echo $hid_decodedVar[0];
  //echo $hashId->decode(3444);

  // OOP MySQLi Object.
  $sql = new mysqli("localhost", "root", "", "socialitydb");

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

  // Debug SESSION
  //echo "<h2> SESSION data </h2>";
  //echo "<pre>"; var_dump($_SESSION); echo "</pre>";

  $func_redirGuests = function(){
    if (!isset($_SESSION["account_id"])) {
      $func_redirGuests_link = "login.php";
      header("location: $func_redirGuests_link");
      exit();
    }
  }

 ?>
