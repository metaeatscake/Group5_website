<?php

  include("php/inc/database.php");

  // Redirect Admins
  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: adm_viewUsers.php");
    exit();
  }

  // Clients can/should still see posts even if they are not logged in, so index.php will contain the feed.

  if (isset($_SESSION["account_id"])) {

    // Prefetch liked posts data.
    $q_getLikes = "SELECT * FROM tbl_feed_likes WHERE user_id = '{$_SESSION["account_id"]}'";
    $qe_getLikes = $sql->query($q_getLikes);

    //Only initialize the array if there are actual results.
    if ($qe_getLikes->num_rows !== 0) {
      while ($row0 = $qe_getLikes->fetch_assoc()) {
        $user_liked_post_id[] = $row0['post_id'];
      }
    }

    // Prefetch TOTAL liked posts
    $q_getAllLikes = "SELECT post_id, COUNT(*) AS likeCount FROM tbl_feed_likes GROUP BY post_id";
    $qe_getAllLikes = $sql->query($q_getAllLikes);
    if ($qe_getAllLikes->num_rows !== 0) {
      while ($row0 = $qe_getAllLikes->fetch_assoc()) {
        $user_total_likes[$row0["post_id"]] = $row0["likeCount"];
        $user_total_likes_keysOnly[] = $row0["post_id"];
      }
    }

  }


  // Debugging.
  //echo (isset($user_liked_post_id))? "The user has liked stuff":"The user has liked nothing";
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
            <?php if(!isset($_SESSION["account_type"])): ?>
              <?php include_once("php/inc/welcomeCard.php"); ?>

              <!-- USER FEED -->
            <?php else:?>

              <?php
                $feed_dateFormat = "%M %d %Y, %H:%i:%s";
                // Read this before editing the format: http://www.sqlines.com/oracle-to-mysql/to_char_datetime
                // Otherwise, DO NOT TOUCH.

                //Fetch all posts from tbl_feed, also do the date formatting from MySQL instead of PHP
                $queryString = "SELECT post_id, user_id, post_title, post_content, post_img, DATE_FORMAT(post_time, '$feed_dateFormat') AS post_date FROM tbl_feed ORDER BY post_time DESC";
                $feed_data = $sql->query($queryString);
              ?>
              <!-- Connect tbl_feed ID to tbl_user user_id -->
              <?php while($row1 = $feed_data->fetch_assoc()): ?>

                <?php $user_data = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$row1["user_id"]}'"); ?>

                <?php while($row2 = $user_data->fetch_assoc()): ?>

                  <?php
                    //Setup for the Likes system.
                    //Only true if the user has liked this specific post.
                      $post_isLiked = (isset($user_liked_post_id) && in_array($row1['post_id'], $user_liked_post_id));

                      // NOTE: First string is the color/text when the post IS LIKED, the other is when it is NOT liked.
                      $post_likeButton_color = ($post_isLiked) ? "#000099" : "#262626";
                      $post_likeButton_text = ($post_isLiked) ? "Unlike" : "Like";

                    //String for building the link to handleLikePost.php.
                      $post_likeButton_href = "php/handleLikePost.php?post_id={$row1['post_id']}";
                      //Debug
                      //echo $post_likeButton_href;

                    //Vars for counting the likes.
                      $post_likeCount = (isset($user_total_likes) && in_array($row1['post_id'], $user_total_likes_keysOnly)) ? $user_total_likes[$row1['post_id']] : 0 ;
                   ?>
                  <!-- Feed Card design starts here. -->
                  <!-- Note: $row1 = tbl_feed, $row2 = tbl_users -->
                  <!-- No need for echo html, treat this like a normal html area. -->
                  <div class="feed_post" id="<?php echo 'post'.$row1['post_id']; ?>">

                    <div class="feed_title">
                      <?php echo $row1["post_title"]; ?>
                    </div>

                    <div class="feed_post_time">
                      <?php echo $row1["post_date"]; ?>
                    </div>

                    <div class="feed_post_author">
                      <a href="profile.php">
                        <?php echo 'Posted by '. $row2["username"]; ?>
                      </a>
                    </div>

                    <div class="feed_content">
                      <?php echo nl2br($row1["post_content"]); ?>
                    </div>
                    <br>
                    <!-- Only display image div if there is image. -->
                    <?php if (isset($row1["post_img"])): ?>
                      <div class="feed_image">
                          <img src="<?php echo 'php/'.$row1['post_img']; ?>" alt="<?php echo $row1['post_img']; ?>">
                      </div>
                    <?php endif; ?>

                    <div class="feed_actions">
                      <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>"> <i class="material-icons">thumb_up</i><?php echo $post_likeCount; ?></a>
                      <a href="#"><span class="material-icons" style="color: #262626;">mode_comment</span> </a>
                      <a href="#"><span class="material-icons" style="color: #262626;">share</span></a>
                    </div>

                  </div>
                  <br>
                <?php endwhile; ?>

              <?php endwhile; ?>

            <?php endif; ?>
         </div>
       </main>
       <?php include_once("php/inc/footer.php"); ?>
      </div>
   </body>
 </html>
