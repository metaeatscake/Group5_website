<?php

  //Get database and session.
  include_once("inc/database.php");

  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
    exit();
  }

  //

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sociality | View Profile</title>

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

             $pdoq_getPostData = $pdo->prepare("SELECT * FROM view_posts WHERE post_id = :post_id");
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

            ?>

            <?php // Post holder. ?>
            <div class="feed_post">

              <div class="feed_title">
                <?php echo $row["post_title"]; ?>
              </div>

              <div class="feed_post_time">
                <?php echo $row["date_time"]; ?>
              </div>

              <div class="feed_post_author">
                <a href="profile.php">
                  <?php echo 'Posted by '. $row["username"]; ?>
                </a>
              </div>

              <div class="feed_content">
                <?php echo nl2br($row["post_content"]); ?>
              </div>
              <br>
              <!-- Only display image div if there is image. -->
              <?php if (isset($row["post_img"]) && file_exists($row["post_img"])): ?>
                <div class="feed_image">
                    <img src="<?php echo $row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                </div>
              <?php endif; ?>

              <div class="feed_actions">
                <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>"> <i class="material-icons">thumb_up</i><?php echo $row["count_likes"]; ?></a>
                <a href="<?php echo $post_viewPost_href; ?>"><span class="material-icons" style="color: #262626;">mode_comment</span> <span style="color:black;"><?php echo $row["count_comments"]; ?></span>  </a>
                <a href="#"><span class="material-icons" style="color: #262626;">share</span></a>
              </div>

            </div>

            <?php // Comment box holder
              // Front end can make this cleaner, not my problem -Ian
            ?>
            <div class="create_comment_wrapper" style="margin:auto;text-align:center;">

              <form class="form_addComment" action="handleAddComment.php" method="POST">

                <div class="addComment_title"> <h2>Add Comment</h2> </div>
                <textarea name="post_comment" rows="8" cols="80" placeholder="Say something neato"></textarea>
                <input type="submit" name="subm_addComment" value="Add Comment">
                <input type="hidden" name="post_id" value="<?php echo $_GET["id"]; ?>">

              </form>

            </div>

            <?php // Comments holder ?>
            <?php
              $pdo_getComments = $pdo->prepare("SELECT * FROM tbl_comments WHERE post_id = :post_id");
              $pdo_getComments->execute(['post_id' => $decodedID]);
              $arr_comments = $pdo_getComments->fetchAll(PDO::FETCH_ASSOC);
             ?>
            <div class="comment-wrapper">

               <?php if (empty($arr_comments)):?>

                 <div class="comment-wrapper_noComments">
                   <h1>There's no comments smh</h1>
                 </div>

               <?php else: ?>

                 <?php foreach ($arr_comments as $row): ?>

                   <?php
                    $pdo_getCommenterData = $pdo->prepare("SELECT username,profile_pic FROM tbl_users WHERE user_id = :user_id");
                    $pdo_getCommenterData->execute(['user_id' => $row['user_id']]);
                    $arr_CommenterData = $pdo_getCommenterData->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (file_exists($arr_CommenterData['profile_pic'])): ?>
                      <div class="cw_profilePic">
                        <img src="<?php echo $arr_CommenterData['profile_pic']; ?>" alt="userPic">
                      </div>
                    <?php endif; ?>
                    <div class="cw_username" style="color:white; font-size:30px;">
                      <?php echo $arr_CommenterData['username']; ?>
                    </div>
                   <div class="cw_comment" style="color:white; font-size:30px;">
                     <?php echo $row['comment_content']; ?>
                   </div>

                 <?php endforeach; ?>

               <?php endif; ?>

            </div>


         </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
