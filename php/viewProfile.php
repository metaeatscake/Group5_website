<?php
  //Get database and session.
  include_once("inc/database.php");

  //Decode hashed user ID, g_id as in $_*G*ET["*id*"]
  $g_id = $_GET["id"];
  $g_id = $hashId->decode($g_id);
  $g_id = $g_id[0];
  //echo $g_id;

  //User ID of the user currently logged in.
  $s_id = $_SESSION["account_id"];

  //Security: verify if this user ID exists
  $pdoq_checkIfIdExists = $pdo->prepare("SELECT count(user_id) as verifyExists
      FROM view_user_stats
      WHERE user_id = :user_id");
  $pdoq_checkIfIdExists->execute(["user_id" => $g_id]);
  $verifyID = $pdoq_checkIfIdExists->fetch(PDO::FETCH_COLUMN);
  //echo $verifyID;

  //Return to index page if the user ID doesn't exist.
  if ($verifyID !== 1) {
    header("location: ../");
  }

  //Prepare user data now that it is verified to exist.
  $pdoq_getUserData = $pdo->prepare("SELECT * FROM view_user_stats WHERE user_id = :user_id");
  $pdoq_getUserData->execute(["user_id" => $g_id]);
  $profileData = $pdoq_getUserData->fetch(PDO::FETCH_ASSOC);
  //print_r( $profileData);

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profileData['username']; ?> | Profile</title>

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
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/scrollbar.css">

    <!-- JS Likebutton -->
    <script src="ajax/xmlhttp.js" charset="utf-8"></script>
  </head>
  <body>
    <?php include_once("inc/_js_mdl_formAlert.php") ?>

     <!-- Uses a header that contracts as the page scrolls down. -->
     <!-- Pasted CSS/HTML from MDL Documentation -->

    <!-- Uses a transparent header that draws on top of the layout's background -->
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
      .demo-layout-transparent {
        /*background: url('php/images/assets/test (1).jpg') center / cover;*/
        background: #ad5389;  /* fallback for old browsers */
        background: -webkit-linear-gradient(#21094e, #6148bf);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(#21094e, #6148bf); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

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

          <div style="width: 900px; margin:auto; background: -webkit-linear-gradient(to right, #3c1053, #ad5389); align-content: center;">

            <div style="background-color: white; text-align: center; color: #405d9b">

              <?php //This is the cover photo ?>
              <p><img src="<?php echo $profileData['cover_photo']; ?>" style="width: 100%; height: 380px;" class="cover"></p>

              <?php //Profile picture ?>
              <img src="<?php echo $profileData['profile_pic']; ?>" id="profile_pic">

               <br>

              <!--BELOW AREA OF PROFILE PICTURE-->
              <div id="profile-page-menu-top">
                <!--Name of the User-->
                <div id="profile-menu-username">
                  <?php echo $profileData['username']; ?>
                </div>
              </div>
              <br>

              <!--PROFILE MENU BUTTONS, BELOW THE AREA OF PROFILE PAGE MENU TOP-->
              <div class="w3-bar">
                <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'myPosts')" style="margin:10px;">My Posts</button>
                <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'about')" style="margin:10px auto;">About</button>
              </div>
            </div>

            <style media="screen">
              .w3-bar{
                align-items: left;
                justify-content: center;
              }
            </style>

            <!--BELOW THE PROFILE CARD AREA-->
            <div style="display: flex;">

               <!--POSTS AREA/ABOUT AREA/CUSTOMIZE PROFILE-->
              <div id="post-area-menu" style="flex:2.5; padding: 20px; padding-right: 0px;">
                <!--CONTENT OF MY POSTS -->
                <div id="myPosts" class="tabmenu">

                  <?php

                      // Check which posts by this user is liked by the account logged in.
                      $pdoq_getUserLikedPosts = $pdo->prepare("SELECT post_id
                        FROM tbl_feed_likes
                        WHERE user_id = :user_id");
                      $pdoq_getUserLikedPosts->execute(['user_id' => $s_id]);
                      $user_liked_post_id = $pdoq_getUserLikedPosts->fetchAll(PDO::FETCH_COLUMN);

                      // Fetch this user's posts
                      // ORDER BY clause can be changed.
                      $pdoq_getUserPosts = $pdo->prepare("SELECT *
                        FROM view_posts_full
                        WHERE user_id = :user_id
                        ORDER BY post_time DESC");
                      $pdoq_getUserPosts->execute(['user_id' => $g_id]);
                      $postData = $pdoq_getUserPosts->fetchAll(PDO::FETCH_ASSOC);
                  ?>

                  <?php if (empty($postData)): ?>
                    <h1 style="color:white;text-align:center;">This user currently has no posts.</h1>
                  <?php else: ?>
                    <?php
                      //Loop through all of the user's posts
                      foreach ($postData as $row):
                    ?>

                     <?php
                        // Like Data setup. Check if this specific posts is in the array of post IDs that the user likes.
                        $isLiked = (isset($user_liked_post_id) && in_array($row["post_id"], $user_liked_post_id));

                        // NOTE: First string is the color/text when the post IS LIKED, the other is when it is NOT liked.
                        $post_likeButton_color = ($isLiked) ? "#000099" : "#262626";
                        $post_likeButton_text = ($isLiked) ? "Unlike" : "Like";

                        //"Encrypted" POST ID because style.
                        $post_fancyID = $hashId->encode($row['post_id']);

                        //Prepare link for ViewPost.
                        $post_viewPost_href = "viewPost.php?id=$post_fancyID";

                        //Prepare like and comment count for each post.
                        $post_likeCount = (isset($row['count_likes'])) ? $row['count_likes'] : 0;
                        $post_commentCount = (isset($row['count_comments'])) ? $row['count_comments'] : 0;

                        //Likebutton
                        $js_likePostLink = "ajax/xmlhttp_likePost.php?id=".$post_fancyID;
                      ?>

                      <!-- USER POSTS -->
                        <div class="feed_post" id="<?php echo 'p_'.$post_fancyID; ?>">

                          <div class="more-horiz">
                            <span class="material-icons">more_horiz</span>
                          </div>

                          <div class="feed_userpic">
                            <a href="<?php echo $profileLink?>">
                              <img src="<?php echo $row['profile_pic']; ?>">
                            </a>
                          </div>

                          <div class="feed_post_author">
                            <a href="Javascript:void(0)">
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
                          </div><br>


                          <!-- Only display image div if there is image. -->
                          <?php if (isset($row["post_img"]) && file_exists($row["post_img"])): ?>
                            <div class="feed_image">
                                <img src="<?php echo $row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                            </div>
                          <?php endif; ?><hr>

                          <div class="feed_actions">

                            <a href="Javascript:void(0)" style="color:<?php echo $post_likeButton_color; ?>"
                              onClick="xml_likePost('<?php echo $post_fancyID ?>', '<?php echo $js_likePostLink ?>')">
                              <i class="material-icons">thumb_up</i>
                              <span><?php echo $post_likeCount; ?></span>
                            </a>

                            <a href="<?php echo $post_viewPost_href; ?>">
                              <span class="material-icons" style="color: #262626;">mode_comment</span>
                              <span style="color:black;"><?php echo $post_commentCount; ?></span>
                            </a>

                            <a href="#">
                              <span class="material-icons" style="color: #262626;">share</span>
                            </a>

                          </div><hr>
                        </div><br>

                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>

                <!--CONTENT OF ABOUT -->
                <!-- Had to be completely rewritten, lmao -Ian -->
                <div id="about" class="tabmenu" style="display:none;">
                  <h2><b>About</b></h2>

                  <h4> <b>Bio</b> </h4>
                  <h7> <?php echo $profileData["bio"]; ?></h7>

                  <h4><b>Joined</b></h4>
                  <h7><?php echo $profileData["register_time"]; ?></h7>

                  <?php
                    //Table data can be null, so these just set them to 0 if null.
                    $u_totalComments = (isset($profileData["count_comments"]))
                      ? $profileData["count_comments"]
                      : 0; //Can also be set to say "No comments"

                    $u_totalPostLikes = (isset($profileData["count_post_likes"]))
                      ? $profileData["count_post_likes"]
                      : 0;

                    $u_totalPosts = (isset($profileData["count_posts"]))
                      ? $profileData["count_posts"]
                      : 0;
                   ?>

                  <h4> <b> Total Number of Comments </b> </h4>
                  <h7> <?php echo $u_totalComments; ?></h7>

                  <h4> <b> Total Post Count </b> </h4>
                  <h7> <?php echo $u_totalPosts; ?></h7>

                  <h4> <b> Total Post Likes </b> </h4>
                  <h7> <?php echo $u_totalPostLikes; ?></h7>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
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
