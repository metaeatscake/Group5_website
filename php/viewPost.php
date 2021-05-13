<?php

  //Get database and session.
  include_once("inc/database.php");

  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
    exit();
  }

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sociality | View Post</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="../mdl/material.min.css">

     <!-- Import Material Design Lite Javascript -->
     <script src="../mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="images/assets/sample2.png">

     <!-- Custom CSS File -->
     <?php include_once("../css/customStyles.php"); ?>
     <link rel="stylesheet" type="text/css" href="../css/viewPostStyles.css">
     <link rel="stylesheet" href="../css/scrollbar.css">
   </head>
   <body>
     <?php include_once("inc/_js_mdl_formAlert.php"); ?>

      <style>
      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
        .demo-layout-transparent {

          background: #ad5389;  /* fallback for old browsers */
          background: -webkit-linear-gradient(to right, #3c1053, #ad5389);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(to right, #3c1053, #ad5389); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .demo-layout-transparent .mdl-layout__header,
        .demo-layout-transparent .mdl-layout__drawer-button {

          color: #cca8e6;
        }
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">

        <?php include_once("inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content">

           <?php

             // PDO direct dump data into an array.
             $db_existingPosts = $pdo->query("SELECT post_id FROM tbl_feed")->fetchAll(PDO::FETCH_COLUMN);

             $decodedIDArr = (isset($_GET["id"])) ? $hashId->decode($_GET["id"]) : "" ;
             $decodedID = $decodedIDArr[0];

             //Redirect if there is no data, or if there is and it is not valid.
             if (empty($decodedID) || !in_array($decodedID, $db_existingPosts)):
               header("location: ../");
               exit();
             endif;

             $pdoq_getPostData = $pdo->prepare("SELECT * FROM view_posts_full WHERE post_id = :post_id");
             $pdoq_getPostData->execute(['post_id' => $decodedID]);
             $row = $pdoq_getPostData->fetch(PDO::FETCH_ASSOC);

             // Handling Like data.
             // Copied from Index. very inefficient, to be rewritten.
             if (isset($_SESSION["account_id"])):

               // PDO: Prepare the user's like data so the posts can be marked.
               $pdoq_getUserLikedPosts = $pdo->prepare("SELECT post_id FROM tbl_feed_likes WHERE user_id = :user_id");
               $pdoq_getUserLikedPosts->execute(['user_id' => $_SESSION["account_id"]]);
               $user_liked_post_id = $pdoq_getUserLikedPosts->fetchAll(PDO::FETCH_COLUMN);

             endif;

             // Like Data setup.
             $isLiked = (isset($user_liked_post_id) && in_array($row["post_id"], $user_liked_post_id));

             // NOTE: First string is the color/text when the post IS LIKED, the other is when it is NOT liked.
             $post_likeButton_color = ($isLiked) ? "#000099" : "#262626";
             $post_likeButton_text = ($isLiked) ? "Unlike" : "Like";

             //"Encrypted" POST ID because style.
             $post_fancyID = $_GET["id"];

             //String for building the link to handleLikePost.php
             $post_likeButton_href = "handleLikePost.php?id=$post_fancyID&returnTo=viewPost";

             //Prepare link for ViewPost.
             $post_viewPost_href = "viewPost.php?id=$post_fancyID";

             //Prepare like and comment count for each post.
             $post_likeCount = (isset($row['count_likes'])) ? $row['count_likes'] : 0;
             $post_commentCount = (isset($row['count_comments'])) ? $row['count_comments'] : 0;

            ?>

            <?php // Post holder. ?>
            <div class="feed_post">

              <div class="feed_userpic">
                <img src="<?php echo $row['profile_pic']; ?>" style=" float: left; width: 50px; height: 50px; border-radius: 50px;">
              </div>

              <div class="feed_post_author" style="text-indent: 4px;">
                <a href="profile.php">
                  <?php echo $row["username"]; ?>
                </a>
              </div>

              <div class="feed_post_time" style="text-indent: 4px;">
                <a href="#">
                  <?php echo $row["date_time"]; ?>
                </a>
              </div><br>

              <div class="feed_title">
                <?php echo $row["post_title"]; ?>
              </div><br>

              <div class="feed_content">
                <?php echo nl2br($row["post_content"]); ?>
              </div>
              <br>
              <!-- Only display image div if there is image. -->
              <?php if (isset($row["post_img"]) && file_exists($row["post_img"])): ?>
                <div class="feed_image">
                    <img src="<?php echo $row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                </div>
              <?php endif; ?><hr>

              <div class="feed_actions"><br>
                  <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>">
                    <i class="material-icons">thumb_up</i><?php echo $post_likeCount; ?>
                  </a>
                  <a href="<?php echo $post_viewPost_href; ?>">
                    <span class="material-icons" style="color: #262626;">mode_comment</span>
                    <span style="color:black;"><?php echo $post_commentCount; ?></span>
                  </a>
                  <a href="#">
                    <span class="material-icons" style="color: #262626;">share</span>
                  </a>
              </div><br><br><br><hr>
                <!-- COMMENT BOX HOLDER -->
              <div class="create_comment_wrapper" style="margin:auto;text-align: center;">
                <form class="form_addComment" action="handleAddComment.php" method="POST">
                  <!-- <div class="addComment_title"> <h2>Add Comment</h2> </div> -->
                  <textarea name="post_comment" rows="5" cols="68" placeholder=" Write a comment..."></textarea><br>
                  <input type="submit" name="subm_addComment" class="btn-primary" value="Comment">
                  <input type="hidden" name="post_id" value="<?php echo $_GET["id"]; ?>">
                </form>
              </div>
              <br><br><hr>
              <!-- COMMENT HOLDER -->
              <?php
                $pdo_getComments = $pdo->prepare("SELECT * FROM view_comments WHERE post_id = :post_id");
                $pdo_getComments->execute(['post_id' => $decodedID]);
                $arr_comments = $pdo_getComments->fetchAll(PDO::FETCH_ASSOC);
              ?>
              <div class="comment-wrapper">

                <?php if (empty($arr_comments)):?>

                  <div class="comment-wrapper_noComments">
                    <h7>Be the first one to comment</h7>
                  </div>

                <?php else: ?>

                  <?php foreach ($arr_comments as $row): ?>

                    <div class="comment-dp">
                      <img  src="<?php echo $row['profile_pic']; ?>" alt="userPic">
                    </div>
                    <div class="dialogbox">
                      <div class="body-box">
                        <span class="tip tip-left"></span>
                        <div class="user-comment"><br style="content: ""; margin: 0em; display: block;">
                          <span><b><a href="#"><?php echo $row['username']; ?></a></b></span>
                        </div><br>
                        <div class="content-comment">
                          <span><?php echo $row['comment_content']; ?> </span>
                        </div>
                      </div>
                    </div>

                  <?php endforeach; ?>

                <?php endif; ?>

              </div>

            </div>

          </div>

        </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
