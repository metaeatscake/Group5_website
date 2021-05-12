<?php

  include_once("_newPDOEmulateOn.php");

  $sqlDump = file_get_contents("../../database/sociality_viewsOnly.sql");

  $qr = $pdo->exec($sqlDump);

  header("location: ../../");
  exit();

 ?>
