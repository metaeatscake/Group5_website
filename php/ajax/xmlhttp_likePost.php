<?php

  include_once("_db.php");

  $encodedId = $_GET["id"];

  //IT WORKS LET'S GOOOOO
  // echo json_encode([
  //   "id" => $encodedId
  // ]);

  $postIdRawArr = $hashId->decode($encodedId);
  $postIdRaw = $postIdRawArr[0];

  // Check if the passed postId is already liked through PDO
  $pdoq_checkLiked = $pdo->prepare("SELECT * FROM tbl_feed_likes WHERE post_id = :post_id AND user_id = :user_id");
  $pdoq_checkLiked->execute([
    'post_id' => $postIdRaw,
    'user_id' => $_SESSION["account_id"]
  ]);

  $isLiked = ($pdoq_checkLiked->rowCount() !== 0);
  $post_likeButton_color = (!$isLiked) ? "#000099" : "#262626";
  // If the user already liked it, delete that record.
  if ($isLiked) {

    //PDO procedure to delete data
    $pdo->prepare("CALL delete_like(:post_id, :user_id)")->execute([
      'post_id' => $postIdRaw,
      'user_id' => $_SESSION["account_id"]
    ]);

    //PDO get current like count.
    $pdoq_getLikeCount = $pdo->prepare("SELECT count_likes FROM view_posts_full WHERE post_id = :post_id");
    $pdoq_getLikeCount->execute([
      "post_id" => $postIdRaw
    ]);
    $pdoq_getLikeCountValue = $pdoq_getLikeCount->fetch(PDO::FETCH_COLUMN);
    $likeCount = (isset($pdoq_getLikeCountValue)) ? $pdoq_getLikeCountValue : 0;

    //Return values to javascript code.
    $returnVars = json_encode([
      "color" => $post_likeButton_color,
      "likeCount" => $likeCount
    ]);
    echo $returnVars;
  }

  // If the user didn't like it yet, insert it.
  else {

    // PDO Insert data through procedure
    $pdo->prepare("CALL add_like(:post_id, :user_id)")->execute([
      'post_id' => $postIdRaw,
      'user_id' => $_SESSION["account_id"]
    ]);

    //PDO get current like count.
    $pdoq_getLikeCount = $pdo->prepare("SELECT count_likes FROM view_posts_full WHERE post_id = :post_id");
    $pdoq_getLikeCount->execute([
      "post_id" => $postIdRaw
    ]);
    $pdoq_getLikeCountValue = $pdoq_getLikeCount->fetch(PDO::FETCH_COLUMN);
    $likeCount = (isset($pdoq_getLikeCountValue)) ? $pdoq_getLikeCountValue : 0;

    //Return values to javascript code.
    $returnVars = json_encode([
      "color" => $post_likeButton_color,
      "likeCount" => $likeCount
    ]);
    echo $returnVars;
  }
 ?>
