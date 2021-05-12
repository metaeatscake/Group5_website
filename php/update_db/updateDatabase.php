<?php

  include_once("_newPDOEmulateOn.php");

  $sqlDump = file_get_contents("../../database/socialitydb.sql");

  $qr = $pdo->exec($sqlDump);

  header("location: ../logout.php");
  exit();

 ?>
