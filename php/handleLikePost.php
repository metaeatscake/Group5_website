<?php

  // Access Session vars and DB connection
  include_once("inc/database.php");

  // PDO direct dump data into an array.
  $db_existingPosts = $pdo->query("SELECT post_id FROM tbl_feed")->fetchAll(PDO::FETCH_COLUMN);

  //Redirect if there is no data, or if there is and it is not valid.
  if (!isset($_GET["post_id"]) || !in_array($_GET["post_id"], $db_existingPosts)) {
    header("location: ../");
    exit();
  }

  // Check if the passed postId is already liked through PDO
  $pdoq_checkLiked = $pdo->prepare("SELECT * FROM tbl_feed_likes WHERE post_id = :post_id AND user_id = :user_id");
  $pdoq_checkLiked->execute([
    'post_id' => $_GET["post_id"],
    'user_id' => $_SESSION["account_id"]
  ]);
  $isLiked = ($pdoq_checkLiked->rowCount() !== 0);

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
  if ($isLiked) {

    //PDO Style DELETE Query.
    $pdo->prepare("DELETE FROM tbl_feed_likes
      WHERE post_id = :post_id
      AND user_id = :user_id
    ")->execute([
      'post_id' => $_GET["post_id"],
      'user_id' => $_SESSION["account_id"]
    ]);

    header("location: $redirLink");
    exit();
  }

  // If the user didn't like it yet, insert it.
  else {

    // PDO Style INSERT query. Execution is also chained.
    $pdo->prepare(
    "INSERT INTO tbl_feed_likes(post_id, user_id) VALUES (:post_id, :user_id)"
    )->execute([
      'post_id' => $_GET["post_id"],
      'user_id' => $_SESSION["account_id"]
    ]);

    header("location: $redirLink");
    exit();

  }



 ?>
