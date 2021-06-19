<?php

  //The usual.
  include_once("inc/database.php");
  include_once("oop/_main.php");

  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: ../");
    exit();
  }

  $vld = new Validate($_POST);
  $vld->cleanData();

  // PDO direct dump data into an array.
  $db_existingPosts = $pdo->query("SELECT post_id FROM tbl_feed")->fetchAll(PDO::FETCH_COLUMN);

  $decodedIDArr = $hashId->decode($vld->getFormVar("post_id"));
  $decodedID = $decodedIDArr[0];

  //Redirect if there is no data, or if there is and it is not valid.
  if (empty($decodedID) || !in_array($decodedID, $db_existingPosts)) {
    header("location: ../");
    exit();
  }

  // Redirect if empty data.
  $postIdHolder = $vld->getFormVar("post_id");
  $emptyDataErrorMsg = $vld->getValidationMessage();
  if (!empty($emptyDataErrorMsg)) {
    $_SESSION["handler-alert"] = $emptyDataErrorMsg;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: viewPost.php?id=$postIdHolder");
    exit();
  }

  // Perform the comment insert.
  $pdo->prepare(
    "INSERT INTO tbl_comments(user_id, post_id, comment_content)
    VALUES(:user_id, :post_id, :comment)"
    )->execute([
      'user_id' => $_SESSION["account_id"],
      'post_id' => $decodedID,
      'comment' => $vld->getFormVar("post_comment")
    ]);

    //$_SESSION["handler-alert"] = "Comment successfully posted!";
    //$_SESSION["handler-alert-type"] = "Success";
    header("location: viewPost.php?id=$postIdHolder");
    exit();



 ?>
