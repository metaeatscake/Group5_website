<?php
  $dumper_host = "localhost";
  $dumper_targetDB = "socialitydb";
  $dumper_user = "root";
  $dumper_password = '';
  $dumper_filepath = "../../database/socialitydb_phpDump.sql";

  try {

    $result=exec("mysqldump $dumper_targetDB --password=$dumper_password --user=$dumper_user --single-transaction >$dumper_filepath",$output);


  } catch (\Exception $e) {
      echo 'mysqldump-php error: ' . $e->getMessage();
  }

  header("location: ../../index_dev.html");
  exit();

 ?>
