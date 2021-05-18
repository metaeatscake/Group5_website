<?php

  include_once("_newPDOEmulateOn.php");

  $sqlDump = file_get_contents("../../database/socialitydb_FULL.sql");

  $qr = $pdo->exec($sqlDump);

  header("location: ../../index_dev.html");
  exit();

 ?>
