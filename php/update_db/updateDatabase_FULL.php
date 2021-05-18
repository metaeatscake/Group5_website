<?php

  include_once("_newPDOEmulateOn.php");

  $sqlDump = file_get_contents("../../database/socialitydb_FULLPDO.sql");

  $qr = $pdo->exec($sqlDump);

  header("location: ../../index_dev.html");
  exit();

 ?>
