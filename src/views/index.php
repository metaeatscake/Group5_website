<?php

  include("php/inc/database.php");

  // Redirect Admins
  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: adm_viewUsers.php");
    exit();
  }

  // Clients can/should still see posts even if they are not logged in, so index.php will contain the feed.

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sociality</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="mdl/material.min.css">
     <!-- Import Material Design Lite Javascript -->
     <script src="mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="php/images/assets/sample2.png">

     <!-- Custom CSS File -->
     <?php include_once("css/customStyles.php"); ?>
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
          background: -webkit-linear-gradient(to right, #3c1053, #ad5389);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(to right, #3c1053, #ad5389); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .demo-layout-transparent .mdl-layout__header,
        .demo-layout-transparent .mdl-layout__drawer-button {
          /* This background is dark, so we set text to white. Use 87% black instead if
             your background is light. */
          color: #cca8e6;
        }
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">
        <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
        <?php include_once("php/inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content">

           <!-- Default Card when user is not logged in. -->
           <!-- This could be changed. -->
            <?php if(!isset($_SESSION["account_type"])): ?>
              <?php include_once("php/inc/welcomeCard.php"); ?>

              <!-- USER FEED -->
            <?php else:?>

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

                //PDO Style, get all data from tbl_feed.
                $feed_queryString = "SELECT * FROM view_posts ORDER BY post_time DESC";

                $post_dataArray = $pdo->query($feed_queryString)->fetchAll(PDO::FETCH_ASSOC);
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
                    $post_likeButton_href = "php/handleLikePost.php?id=$post_fancyID&returnTo=index_clean";

                    //Prepare link for ViewPost.
                    $post_viewPost_href = "php/viewPost.php?id=$post_fancyID";
                  ?>

                  <div class="feed_post" id="<?php echo 'p_'.$post_fancyID; ?>">

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
                    <?php if (isset($row["post_img"])): ?>
                      <div class="feed_image">
                          <img src="<?php echo 'php/'.$row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                      </div>
                    <?php endif; ?>

                    <div class="feed_actions">
                      <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>"> <i class="material-icons">thumb_up</i><?php echo $row["count_likes"]; ?></a>
                      <a href="<?php echo $post_viewPost_href; ?>"><span class="material-icons" style="color: #262626;">mode_comment</span> <span style="color:black;"><?php echo $row["count_comments"]; ?></span>  </a>
                      <a href="#"><span class="material-icons" style="color: #262626;">share</span></a>
                    </div>

                  </div>
                  <br>

               <?php endforeach; ?>

             <?php endif; ?>
         </div>
       </main>

       <footer>
         <?php include_once("php/inc/footer.php"); ?>
       </footer>

      </div>

   </body>
 </html>
