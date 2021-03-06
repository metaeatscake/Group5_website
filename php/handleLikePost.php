<?php

  // Access Session vars and DB connection
  include_once("inc/database.php");

  // PDO direct dump data into an array.
  $db_existingPosts = $pdo->query("SELECT post_id FROM tbl_feed")->fetchAll(PDO::FETCH_COLUMN);

  $decodedIDArr = (isset($_GET["id"])) ? $hashId->decode($_GET["id"]) : "" ;
  $decodedID = $decodedIDArr[0];

  // Debugging
  var_dump($decodedIDArr);
  echo "Decoded ID: ". $decodedID;
  var_dump($db_existingPosts);

  //Redirect if there is no data, or if there is and it is not valid.
  if (empty($decodedID) || !in_array($decodedID, $db_existingPosts)) {
    header("location: ../");
    exit();
  }

  // Check if the passed postId is already liked through PDO
  $pdoq_checkLiked = $pdo->prepare("SELECT * FROM tbl_feed_likes WHERE post_id = :post_id AND user_id = :user_id");
  $pdoq_checkLiked->execute([
    'post_id' => $decodedID,
    'user_id' => $_SESSION["account_id"]
  ]);

  $isLiked = ($pdoq_checkLiked->rowCount() !== 0);

  // Redirect Link Setup.
  if (isset($_GET["returnTo"])) {
    $postTag = "#p_{$_GET['id']}";
    $postRaw = $_GET['id'];
    $targetPage = $_GET["returnTo"];

    switch ($targetPage) {
      case 'profile.php':
        $redirLink = "profile.php$postTag";
        break;

      case 'viewProfile.php':
        $profileID = $_GET["profileID"];
        $redirLink = "viewProfile.php?postID=$postTag&userID=$profileID";
        break;

      case 'index_clean':
        $redirLink = "../";
        break;

      case 'likedPosts_clean':
        $redirLink = "likedPosts.php";
        break;

      case 'viewPost':
        $redirLink = "viewPost.php?id=$postRaw";
        break;

      default:
        $redirLink = "../$postTag";
        break;
    }
  }
  else{
    $redirLink = "../#p_{$_GET['id']}";
  }

  // Normal Redirect
  //$redirLink = "../";

  // If the user already liked it, delete that record.
  if ($isLiked) {

    //PDO procedure to delete data
    $pdo->prepare("CALL delete_like(:post_id, :user_id)")->execute([
      'post_id' => $decodedID,
      'user_id' => $_SESSION["account_id"]
    ]);

    header("location: $redirLink");
    exit();
  }

  // If the user didn't like it yet, insert it.
  else {

    // PDO Insert data through procedure
    $pdo->prepare("CALL add_like(:post_id, :user_id)")->execute([
      'post_id' => $decodedID,
      'user_id' => $_SESSION["account_id"]
    ]);

    header("location: $redirLink");
    exit();

  }



 ?>
