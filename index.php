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
     <link rel="shortcut icon" href="php/images/assets/socialityLogo_transparent.png">

     <!-- Custom CSS File -->
     <link rel="stylesheet" href="css/socialityOverrides.css">
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
                $queryString = "SELECT user_id, post_title, post_content, post_img, DATE_FORMAT(post_time, '$feed_dateFormat') AS post_date FROM tbl_feed";
                $feed_data = $sql->query($queryString);
              ?>
              <!-- Connect tbl_feed ID to tbl_user user_id -->
              <?php while($row1 = $feed_data->fetch_assoc()): ?>

                <?php $user_data = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$row1["user_id"]}'"); ?>

                <?php while($row2 = $user_data->fetch_assoc()): ?>

                  <!-- Feed Card design starts here. -->
                  <!-- Note: $row1 = tbl_feed, $row2 = tbl_users -->
                  <!-- No need for echo html, treat this like a normal html area. -->
                  <div class="">
                    <h1>Title: <?php echo $row1["post_title"]; ?></h1>
                    <h4>Content: <?php echo $row1["post_content"]; ?></h4>
                    <h6>Time: <?php echo $row1["post_date"]; ?></h6>
                    <h3>Post Creator: <?php echo $row2["username"]; ?></h3>
                  </div>

                <?php endwhile; ?>

              <?php endwhile; ?>
            <?php endif; ?>
         </div>
       </main>
       <?php include_once("php/inc/footer.php"); ?>
      </div>
   </body>
 </html>
