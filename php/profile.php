<?php
  //Get database and session.
  include_once("inc/database.php");

  //Prefetch User data.
  $pdoq_getUserData = $pdo->prepare("SELECT * FROM tbl_users WHERE user_id = :user_id");
  $pdoq_getUserData->execute(['user_id' => $_SESSION["account_id"]]);
  $user_dataArray = $pdoq_getUserData->fetch(PDO::FETCH_ASSOC);

  //var_dump($user_dataArray);

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $user_dataArray['username']; ?> | View Profile</title>

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
     <link rel="stylesheet" href="../css/w3.css">
   </head>

   <body>
      <?php include_once("inc/_js_mdl_formAlert.php") ?>

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

                <!---CHANGE THIS WITH THE TEMPORARY IMG THAT I PUT <img src="images/users_cover/bglight.jpg" style="width: 100%;"> -->

                <!--TEMPORARY ONLY, ONCE I KNOW HOW TO WORK ON PUTTING UPLOAD IMAGE ICON BESIDE THE PROFILE PICTURE-->

                <img src="images/users/_default.jpg" id="profile_pic">

                <!--CHANGE THIS WITH THE TEMPORARY IMG THAT I PUT <img id="profile_pic" src="images/users/$db_profile_pic"> --> <br>

                <!--BELOW AREA OF PROFILE PICTURE-->
                <div id="profile-page-menu-top">
                  <!--Name of the User-->
                  <div id="profile-menu-username">
                    <a href="editProfile.php"><?php echo $user_dataArray['username']; ?></a>
                  </div>
                </div>
                <br>

                <!--PROFILE MENU BUTTONS, BELOW THE AREA OF PROFILE PAGE MENU TOP-->
                <div class="w3-bar" style="background-color: white;">
                  <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'myPosts')">My Posts</button>
                  <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'about')">About</button>
                  <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'customizeProfile')">Customize Profile</button>
                </div>
              </div>

              <!--BELOW THE PROFILE CARD AREA-->
              <div style="display: flex;">

                 <!--FOLLOWING AREA-->
                <div style="min-height: 440px; flex:1;">
                  <div id="following-bar">
                    Following· <br>

                    <div id="following">
                      <img id="following-img" src="images/assets/Jesse-Renz.jpg">
                      <br>
                      Jesse Renz Faculin Bernese
                    </div>

                    <div id="following">
                      <img id="following-img" src="images/assets/Kyla-Nadine.jpg">
                      <br>
                      Kyla Nadine Raquedan
                    </div>

                    <div id="following">
                      <img id="following-img" src="images/assets/Lunar-Angelo.jpg">
                      <br>
                      Lunar Angelo Pajaroja
                    </div>

                    <div id="following">
                      <img id="following-img" src="images/assets/Ronnel-Tang.jpg">
                      <br>
                      Ronnel Tang
                    </div>
                  </div>
                </div>

                 <!--POSTS AREA/ABOUT AREA/CUSTOMIZE PROFILE-->
                <div id="post-area-menu" style="flex:2.5; padding: 20px; padding-right: 0px;">
                  <!--CONTENT OF MY POSTS -->
                  <div id="myPosts" class="tabmenu">
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
                      //Also implement variable sort process.

                      $feed_dateFormat = "%M %d %Y, %H:%i:%s";

                      //Don't touch.

                      $feed_queryString = "SELECT f.*, u.*,
                          DATE_FORMAT(f.post_time, '$feed_dateFormat') AS date_time,
                          COUNT(c.comment_id) AS count_comments,
                          COUNT(fl.like_id) AS count_likes
                        FROM tbl_feed f

                        JOIN tbl_users u ON (f.user_id = u.user_id)
                        LEFT OUTER JOIN tbl_feed_likes fl ON (f.post_id = fl.post_id)
                        LEFT OUTER JOIN tbl_comments c ON (f.post_id = c.post_id)

                        GROUP BY f.post_id
                        ORDER BY f.post_time DESC";

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
                          $post_likeButton_href = "handleLikePost.php?id=$post_fancyID&returnTo=profile.php";

                          //Prepare link for ViewPost.
                          $post_viewPost_href = "viewPost.php?id=$post_fancyID";
                        ?>

                        <?php if ($row['user_id'] === $_SESSION["account_id"]): ?>

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
                                  <img src="<?php echo $row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                              </div>
                            <?php endif; ?>

                            <div class="feed_actions">
                              <a href="<?php echo $post_likeButton_href; ?>" style="color:<?php echo $post_likeButton_color; ?>"> <i class="material-icons">thumb_up</i><?php echo $row["count_likes"]; ?></a>
                              <a href="<?php echo $post_viewPost_href; ?>"><span class="material-icons" style="color: #262626;">mode_comment</span> <span style="color:black;"><?php echo $row["count_comments"]; ?></span>  </a>
                              <a href="#"><span class="material-icons" style="color: #262626;">share</span></a>
                            </div>

                          </div>
                          <br>

                        <?php endif; ?>

                     <?php endforeach; ?>
                  </div>

                  <!--CONTENT OF ABOUT -->
                  <div id="about" class="tabmenu" style="display:none;">
                    <h2>About</h2>

                    <?php
                      if($user_dataArray['bio'] != NULL){
                        echo "
                          <h4>Bio</h4>
                          <h7>{$user_dataArray['bio']}</h7>
                        ";
                      }
                    ?>

                    <h4>Joined</h4>
                    <h7><?php echo $user_dataArray['register_time']; ?></h7>
                  </div>

                  <!--CONTENT OF CUSTOMIZE PROFILE -->
                  <!--HI JOM, IF YOU DECIDED TO REMOVE THE FOLLOWING BAR ON CUSTOMIZE PROFILE, YOU CAN MOVE THIS PART SOMEWHERE U WANT -->
                  <div id="customizeProfile" class="tabmenu" style="display:none;">
                    <h2>Customize Profile</h2>
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
<script>
  function opentabs(tab, tabname) {
    var i, x, tablinks;
    x = document.getElementsByClassName("tabmenu");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-purple", "");
    }
    document.getElementById(tabname).style.display = "block";
    tab.currentTarget.className += " w3-purple";
  }
</script>
