<?php

  include_once("_newPDOEmulateOn.php");

  $sqlDump = file_get_contents("../../database/socialitydb.sql");

  $qr = $pdo->exec($sqlDump);

  // After setting up database, add the procedures
  header("location: addProcedures.php");
  exit();

 ?>
