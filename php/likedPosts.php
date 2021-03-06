<?php

  //Get database and session.
  include_once("inc/database.php");

  $func_redirGuests();

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sociality | Activity Log</title>

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
     <link rel="stylesheet" type="text/css" href="../css/likedPostStyles.css">
     <link rel="stylesheet" href="../css/scrollbar.css">
   </head>
   <body>
       <!-- Uses a header that contracts as the page scrolls down. -->
       <!-- Pasted CSS/HTML from MDL Documentation -->

      <!-- Uses a transparent header that draws on top of the layout's background -->
      <style>
      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
        .demo-layout-transparent {
          /* REPLACE THIS IMAGE WITH A BETTER BACKGROUND */
          /*background: url('php/images/assets/test (1).jpg') center / cover;*/
          background: #ad5389;  /* fallback for old browsers */
          background: -webkit-linear-gradient(#21094e, #6148bf);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(#21094e, #6148bf); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .demo-layout-transparent .mdl-layout__header,
        .demo-layout-transparent .mdl-layout__drawer-button {
          /* This background is dark, so we set text to white. Use 87% black instead if
             your background is light. */
          color: #fff;
        }
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">
        <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
        <?php include_once("inc/navbar.php"); ?>
        
       <main class="mdl-layout__content">

         <div class="page-content">

           <?php

             // Handling Like data.
             if (isset($_SESSION["account_id"])):

               // PDO: Prepare the user's like data so the posts can be marked.
               $pdoq_getUserLikedPosts = $pdo->prepare("SELECT post_id FROM tbl_feed_likes WHERE user_id = :user_id");
               $pdoq_getUserLikedPosts->execute(['user_id' => $_SESSION["account_id"]]);
               $user_liked_post_id = $pdoq_getUserLikedPosts->fetchAll(PDO::FETCH_COLUMN);

             endif;

            ?>

           <?php

              //Extremely redundant but a cool concept.
             $feed_queryString = function($column, $direction){
                 return ("SELECT * FROM view_posts_full ORDER BY ".$column." ".$direction);
               };

              //For future implementations of $_GET-based post sorting code.
              $feed_sort_col = "post_time";
              $feed_sort_direction = "DESC";

              //Don't touch.
             $post_dataArray = $pdo->query($feed_queryString($feed_sort_col, $feed_sort_direction))->fetchAll(PDO::FETCH_ASSOC);
             //echo "<pre style='color:white;'>"; var_dump($post_dataArray); echo "</pre>";

            ?>

            <?php foreach ($post_dataArray as $row): ?>

              <?php
                 // Like Data setup.
                 $isLiked = (isset($user_liked_post_id) && in_array($row["post_id"], $user_liked_post_id));

                 // NOTE: First string is the color/text when the post IS LIKED, the other is when it is NOT liked.
                 $post_likeButton_color = ($isLiked) ? "#000099" : "#262626";
                 $post_likeButton_text = ($isLiked) ? "Unlike" : "Like";

                 //"Encrypted" POST ID because style.
                 $post_fancyID = $hashId->encode($row['post_id']);

                 //String for building the link to handleLikePost.php
                 $post_likeButton_href = "handleLikePost.php?id=$post_fancyID&returnTo=likedPosts_clean";

                 //Prepare link for ViewPost.
                 $post_viewPost_href = "viewPost.php?id=$post_fancyID";

                 $profileIDHolder = $hashId->encode($row["user_id"]);
                 $profileLink = "viewProfile.php?id=$profileIDHolder";
               ?>

               <?php if (in_array($row['post_id'], $user_liked_post_id)): ?>

                 <div class="feed_post" id="<?php echo 'p_'.$post_fancyID; ?>">

                    <div class="feed_userpic">
                      <a href="<?php echo $profileLink?>">
                        <img src="<?php echo $row['profile_pic']; ?>">
                      </a>
                    </div>

                    <div class="feed_post_author">
                      <a href="<?php echo $profileLink?>">
                        <?php echo $row["username"]; ?>
                      </a>
                    </div>

                    <div class="feed_post_time">
                      <a href="<?php echo $post_viewPost_href; ?>">
                        <?php echo $row["date_time"]; ?>
                      </a>
                      <span class="material-icons icon">public</span>
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
                   <?php endif; ?>
                    <hr>
                   <div class="feed_actions">

                     <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>">
                      <i class="material-icons">thumb_up</i><?php echo $row["count_likes"]; ?>
                    </a>
                     <a href="<?php echo $post_viewPost_href; ?>">
                      <span class="material-icons" style="color: #262626;">mode_comment</span>
                      <span style="color:black;"><?php echo $row["count_comments"]; ?></span>
                    </a>
                     <a href="#">
                      <span class="material-icons" style="color: #262626;">share</span>
                    </a>
                   </div>
                    <hr>
                 </div>
                 <br>

                <?php endif; ?>

            <?php endforeach; ?>

         </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
