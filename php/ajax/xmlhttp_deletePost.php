<?php

  include_once("_db.php");

  //Get post ID
  $g_id = $_GET["id"];
  $g_id = $hashId->decode($g_id);
  $g_id = $g_id[0];

  //Check if this id exists.
  $checkPostID = $pdo->prepare("SELECT count(user_id) as verifycount FROM ")
 ?>
