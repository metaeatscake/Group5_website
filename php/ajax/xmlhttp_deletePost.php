<?php

  include_once("_db.php");

  //Get post ID
  $g_id = $_GET["id"];
  $g_id = $hashId->decode($g_id);
  $g_id = $g_id[0];

  //Get user id from session
  $s_id = $_SESSION["account_id"];

  //Check if this post exists.
  $checkPostID = $pdo->prepare("SELECT count(user_id) as verifycount
    FROM view_posts_full
    WHERE post_id = :post_id
    AND user_id = :user_id");
  $checkPostID->execute([
    "post_id" => $g_id,
    "user_id" => $s_id
  ]);
  $checkPostID = $checkPostID->fetch(PDO::FETCH_COLUMN);

  //Return error if post is not found.
  if ($checkPostID !== 1) {
    echo json_encode([
      "message" => "Post ID not found"
    ]);
    exit();
  }

  //Proceed with delete if it exists.

  //If post has an image, delete it.
  $imgLoc = $pdo->prepare("SELECT post_img
    FROM view_posts_full
    WHERE post_id = :post_id
    AND user_id = :user_id");
  $imgLoc->execute([
    "post_id" = $g_id,
    "user_id" = $s_id
  ]);
  $imgLoc = $imgLoc->fetch(PDO::FETCH_COLUMN);
  if (isset($imgLoc)) {
    //This file is in the /ajax folder, and /images is outside.
    unlink("../$imgLoc");
  }

  //Delete query proper.
  $pdo->prepare("CALL delete_post(:post_id, :user_id)")->execute([
    "post_id" => $g_id,
    "user_id" => $s_id
  ]);

  //Return success message.
  echo json_encode([
    "message" => "Delete success"
  ]);
  exit();
 ?>
