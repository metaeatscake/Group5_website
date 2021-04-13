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
              <div style="width: 900px; margin:auto; background: -webkit-linear-gradient(to right, #3c1053, #ad5389); min-height: 400px; align-content: center;">

                <div style="background-color: white; text-align: center; color: #405d9b">

                  <!--TEMPORARY ONLY, ONCE I KNOW HOW TO WORK ON PUTTING UPLOAD IMAGE ICON BESIDE THE PROFILE PICTURE-->
                  <img src="images/users_cover/_default.png" style="width: 100%;">

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
                  <!--Name of the User-->
                  <div style="font-size: 20px">
                      <?php echo $db_username; ?>
                      <!--Bio of the user-->
                      <div style="font-size: 12px;">
                        <?php echo $db_bio; ?>
                      </div>
                  </div>
                  <br>
                  <div id=profile-menu-buttons>Timeline</div>
                  <div id=profile-menu-buttons>About</div>
                  <div id=profile-menu-buttons>Friends</div>
                  <div id=profile-menu-buttons>Photos</div>
                  <div id=profile-menu-buttons>Settings</div>
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
                  <div style="min-height: 400px;flex:2.5; padding: 20px; padding-right: 0px;">
                    
                    <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                      <?php
                        // Direct/One-line fetch of column data. Extreme shortcut.
                         $username = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$_SESSION["account_id"]}'")->fetch_assoc()["username"];
                        ?>

                        <form action="handleCreatePost.php" method="POST" enctype="multipart/form-data">
                          <center>
                           <input type="text" name="inputTitle" id="title-bar" placeholder="Title" required> 
                          </center>
                           <br>

                           <textarea name="inputText" rows="8" cols="80" placeholder="What's on your mind, <?php echo $db_username; ?>?"></textarea>
                           <br>

                          <input type="file" id="actual-btn" hidden/>
                          <label for="actual-btn"><span class="material-icons">
                          drive_folder_upload
                          </span> </label>
                          <br>

                          <input type="submit" name="btnSubmit" class="btn-primary" value="Post">
                          <br><br>
                        </form>
                    
                    </div>

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
                              <h1><?php echo $row1["post_title"]; ?></h1>
                            </div>

                            <!-- Only display image div if there is image. -->
                            <?php if (isset($row1["post_img"])): ?>
                              <div class="feed_image">
                                <img src="<?php echo 'php/'.$row1['post_img']; ?>" alt="<?php echo $row1['post_img']; ?>">
                              </div>
                            <?php endif; ?>

                            <div class="feed_content">
                              <h4><?php echo $row1["post_content"]; ?></h4>
                            </div>
                            <div class="feed_post_time">
                              <h6><?php echo $row1["post_date"]; ?></h6>
                            </div>
                            <div class="feed_post_author">
                              <h3><?php echo 'posted by '. $row2["username"]; ?></h3>
                            </div>
                            <div class="feed_actions">
                              <a href="#"> <h5>View Comments</h5> </a>
                              <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>"> <i class="material-icons">thumb_up</i> <?php echo $post_likeButton_text; ?> </a>
                            </div>

                          </div>

                        <?php endwhile; ?>

                      <?php endwhile; ?>
                      
                  </div>

                </div>

              </div>

          </div>
  
       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
