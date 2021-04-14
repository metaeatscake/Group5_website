<?php

  // Access Session vars and DB connection
  include_once("inc/database.php");

  //Fetch the existing post IDs to compare.
  $q_fetchPostIDs = $sql->query("SELECT post_id FROM tbl_feed");
  while ($row = $q_fetchPostIDs->fetch_assoc()) {
    $db_existingPosts[] = $row["post_id"];
  }

  //Redirect if there is no data, or if there is and it is not valid.
  if (!isset($_GET["post_id"]) || !in_array($_GET["post_id"], $db_existingPosts)) {
    header("location: ../");
    exit();
  }

  //Query for if this post is already liked.
  $q_checkDB = "SELECT * FROM tbl_feed_likes
  WHERE post_id = '{$_GET["post_id"]}'
  AND user_id = '{$_SESSION["account_id"]}'";

  $q_returnedRows = $sql->query($q_checkDB)->num_rows;

  $liked = ($q_returnedRows !== 0);

  // Redirect Link Setup.
  if (isset($_GET["returnTo"])) {
    $postTag = "#post{$_GET['post_id']}";
    $targetPage = $_GET["returnTo"];

    switch ($targetPage) {
      case 'profile.php':
        $redirLink = "profile.php$postTag";
        break;

      default:
        $redirLink = "../$postTag";
        break;
    }
  }
  else{
    $redirLink = "../#post{$_GET['post_id']}";
  }


  // Normal Redirect
  //$redirLink = "../";

  // If the user already liked it, delete that record.
  if ($liked) {

    // Target only the specific post, as liked by the specific user.
    $q_deleteLike = "DELETE FROM tbl_feed_likes
      WHERE post_id = '{$_GET["post_id"]}'
      AND user_id = '{$_SESSION["account_id"]}'";

    // Exec query.
    $sql->query($q_deleteLike);

    header("location: $redirLink");
    exit();
  }

  // If the user didn't like it yet, insert it.
  else {

    // Prepare statement
    $q_insertLike = "INSERT INTO tbl_feed_likes(post_id, user_id)
    VALUES('{$_GET["post_id"]}', '{$_SESSION["account_id"]}')";

    // execute statement
    $sql->query($q_insertLike);

    header("location: $redirLink");
    exit();

  }



 ?>
