<?php
  //Get database and session.
  include_once("inc/database.php");

  $id = $_SESSION["account_id"];

  // If the query only returns one row, the array can be fetched in one line.
  $row = $sql->query("SELECT * FROM tbl_users WHERE user_id = '$id'")->fetch_assoc();

  extract($row, EXTR_PREFIX_ALL, "db");
    /*
      Declares the following:
        $db_user_id
        $db_username
        $db_password
        $db_email
        $db_sex
        $db_profile_pic
        $db_bio
        $db_account_type
    */

  //DEBUGGING
  // echo "<pre>";
  // var_dump(get_defined_vars());
  // echo "</pre>";

  //Redirect Admins
  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: adm_viewUsers.php");
    exit();
  }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $db_username; ?> | View Profile</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="../mdl/material.min.css">
     <!-- Import Material Design Lite Javascript -->
     <script src="../mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="images/assets/sample2.png">

     <!-- Custom CSS File -->
     <link rel="stylesheet" href="../css/socialityOverrides.css">
     <link rel="stylesheet" type="text/css" href="../css/profileStyles.css">
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
        <?php include_once("inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content mdl-grid">
            <!-- ADD THE PROFILE CARD HERE. -->
              <div style="width: 900px; margin:auto; background: -webkit-linear-gradient(to right, #3c1053, #ad5389); align-content: center;">

                <div style="background-color: white; text-align: center; color: #405d9b">

                  <!--TEMPORARY ONLY, ONCE I KNOW HOW TO WORK ON PUTTING UPLOAD IMAGE ICON BESIDE THE PROFILE PICTURE-->
                  <img src="images/users_cover/_default.png" style="width: 100%; height: 380px;">

                  <!---CHANGE THIS WITH THE TEMPORARY IMG THAT I PUT
                    <img src="images/users_cover/bglight.jpg" style="width: 100%;">
                  -->

                  <!--TEMPORARY ONLY, ONCE I KNOW HOW TO WORK ON PUTTING UPLOAD IMAGE ICON BESIDE THE PROFILE PICTURE-->

                  <img src="images/users/_default.jpg" id="profile_pic">
                  
                  <!--
                    CHANGE THIS WITH THE TEMPORARY IMG THAT I PUT
                    <img id="profile_pic" src="images/users/$db_profile_pic">
                  -->

                  <br>
                  <!--BELOW AREA OF PROFILE PICTURE-->
                  <div id="profile-page-menu-top">
                    <!--Name of the User-->
                    <div id="profile-menu-username">
                      <a href="editProfile.php"><?php echo $db_username; ?></a>
                    </div>
                    <!--Bio of the user-->
                    <div id="profile-menu-bio">
                      <?php echo $db_bio; ?>
                    </div>
                    <!--Edit Profile Button-->
                    <div id="edit-button" align="centered">
                      <a href="editProfile.php">Edit</a>
                    </div>
                  </div>

                  <hr>
                  <!--PROFILE MENU BUTTONS, BELOW THE AREA OF PROFILE PAGE MENU TOP-->
                  <a href="#" id=profile-menu-buttons>Timeline</a>
                  <a href="#" id=profile-menu-buttons>About</a>
                  <a href="#" id=profile-menu-buttons>Friends</a>
                  <a href="#" id=profile-menu-buttons>Photos</a>
                  <a href="#" id=profile-menu-buttons>Settings</a>
                  <br><br>
                </div>

                <!--BELOW THE PROFILE CARD AREA-->
                <div style="display: flex;">
                   
                   <!--FOLLOWING AREA-->
                  <div style="min-height: 400px; flex:1;">
                    <div id="following-bar">
                      Following· <br>

                      <div id="following">
                        <img id="following-img" src="images/users/Jesse-Renz.jpg">
                        <br>
                        Jesse Renz Faculin Bernese
                      </div>

                      <div id="following">
                        <img id="following-img" src="images/users/Kyla-Nadine.jpg">
                        <br>
                        Kyla Nadine Raquedan
                      </div>

                      <div id="following">
                        <img id="following-img" src="images/users/Lunar-Angelo.jpg">
                        <br>
                        Lunar Angelo Pajaroja
                      </div>

                      <div id="following">
                        <img id="following-img" src="images/users/Ronnel-Tang.jpg">
                        <br>
                        Ronnel Tang
                      </div>
                    </div>
                  </div>

                   <!--POSTS AREA-->
                  <div id="post-area-menu" style="min-height: 400px;flex:2.5; padding: 20px; padding-right: 0px;">
                    
                    <div id="post-area-menu" style="border: solid thin #aaa; padding: 10px; background-color: white;">

                      <?php
                        $feed_dateFormat = "%M %d %Y, %H:%i:%s";
                        // Read this before editing the format: http://www.sqlines.com/oracle-to-mysql/to_char_datetime
                        // Otherwise, DO NOT TOUCH.

                        //Fetch all posts from tbl_feed, also do the date formatting from MySQL instead of PHP
                        $queryString = "SELECT post_id, user_id, post_title, post_content, post_img, DATE_FORMAT(post_time, '$feed_dateFormat') AS post_date FROM tbl_feed";
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
                              $post_likeButton_color = ($post_isLiked) ? "#c5d1e3" : "#2c6bd1";
                              $post_likeButton_text = ($post_isLiked) ? "Unlike" : "Like";

                            //String for building the link to handleLikePost.php.
                              $post_likeButton_href = "php/handleLikePost.php?post_id={$row1['post_id']}";
                              //Debug
                              //echo $post_likeButton_href;
                           ?>
                          <!-- Feed Card design starts here. -->
                          <!-- Note: $row1 = tbl_feed, $row2 = tbl_users -->
                          <!-- No need for echo html, treat this like a normal html area. -->
                          <div class="feed_post" id="<?php echo 'post'.$row1['post_id']; ?>">

                            <div class="feed_title">
                              <h4><b><?php echo $row1["post_title"]; ?></b></h4>
                            </div>

                            <!-- Only display image div if there is image. -->
                            <?php if (isset($row1["post_img"])): ?>
                              <div class="feed_image">
                                <img src="<?php echo 'php/'.$row1['post_img']; ?>" alt="<?php echo $row1['post_img']; ?>">
                              </div>
                            <?php endif; ?>

                            <div class="feed_content">
                              <h5><?php echo $row1["post_content"]; ?></h5>
                            </div>
                            <div class="feed_post_time">
                              <h9><?php echo $row1["post_date"]; ?></h9>
                            </div>
                            <div class="feed_post_author">
                              <h9><?php echo 'Posted by '. $row2["username"]; ?></h9>
                            </div>
                            <div class="feed_actions">
                              <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>"> <i class="material-icons">thumb_up</i> </a>
                              <a href="#"><span class="material-icons">mode_comment</span> </a>
                              <a href="#"><span class="material-icons">share</span></a>
                            </div>

                          </div>

                        <?php endwhile; ?>

                      <?php endwhile; ?>
                    
                    </div>

                  </div>

                </div>

              </div>

          </div>
  
       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
