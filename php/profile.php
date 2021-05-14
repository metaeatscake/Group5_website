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
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
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
              <p><img src="images/users_cover/_default.png" style="width: 100%; height: 380px;" class="cover"></p>

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
                <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'myPosts')" style="margin:10px;">My Posts</button>
                <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'about')" style="margin:10px auto;">About</button>
                <div class="dropdown">
                  <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'customizeProfile')" style="margin:10px;">Customize Profile</button>
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'customizeProfile')">Edit Profile</button><br><br>
                    <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'customizeBio')">Edit Bio</button><br>
                    <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'customizeProfileBanner')">Edit Profile Picture Banner</button>
                  </div>
                </div>
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

               <!--SPONSORED-->
              <div style="min-height: 440px; flex:1;">
                <div id="sponsored-bar">
                  <b>Sponsored</b> <br>

                  <div id="sponsored">
                    <img id="sponsored-img" src="images/assets/mfi-dts.jpg">
                    <br>
                    <a href="#">MFI Dual Training System Program</a>
                  </div>

                  <div id="sponsored">
                    <img id="sponsored-img" src="images/assets/mfi-shs.jpg">
                    <br><br>
                    <a href="#">MFI Senior High School Program</a>
                  </div>

                  <div id="sponsored">
                    <img id="sponsored-img" src="images/assets/mfi-womencourse.png">
                    <br>
                    <a href="#">MFI Women in STEM</a>
                  </div>

                </div>
                <div class="sponsored-bar-footer">
                  <a href="#">Privacy</a> · 
                  <a href="#">Terms</a> · 
                  <a href="#">Advertising</a> · 
                  <a href="#">Ad Choices</a> · 
                  <a href="#">Cookies</a> · 
                  <a href="#">More</a> · 
                  <a href="#">Sociality</a> &copy 2021
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
                        
                        <div class="feed_userpic">
                          <img src="<?php echo $row['profile_pic']; ?>" style=" float: left; width: 50px; height: 50px; border-radius: 50px;">
                        </div>

                        <div class="feed_post_author" style="text-indent: 4px;">
                          <a href="profile.php">
                            <?php echo $row["username"]; ?>
                          </a>
                        </div> 

                        <div class="feed_post_time" style="text-indent: 4px;">
                          <a href="<?php echo $post_viewPost_href; ?>">
                            <?php echo $row["date_time"]; ?>
                          </a>
                        </div><br>

                        <div class="feed_title">
                          <?php echo $row["post_title"]; ?>
                        </div><br>
                      
                        <div class="feed_content">
                          <?php echo nl2br($row["post_content"]); ?>
                        </div><br>
                        

                        <!-- Only display image div if there is image. -->
                        <?php if (isset($row["post_img"])): ?>
                          <div class="feed_image">
                              <img src="<?php echo $row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                          </div>
                        <?php endif; ?><hr>

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

                        </div><hr>
                      </div><br>
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
                <div id="customizeProfile" class="tabmenu" style="display:none;">
                  <?php

                    $id = $_SESSION["account_id"];

                    // If the query only returns one row, the array can be fetched in one line.
                    $row = $sql->query("SELECT * FROM tbl_users WHERE user_id = '$id'")->fetch_assoc();

                    extract($row, EXTR_PREFIX_ALL, "db");

                    //Redirect Admins
                    if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
                      header("location: adm_viewUsers.php");
                      exit();
                    }

                      $requireInput = false;

                  ?>

                  <div class="page-content" align="center"><br><br>

                    <!-- Edit Profile Card. -->
                    <!--Form Proper-->
                    <form class="" action="handleEditProfile.php" method="POST">
                      <div class="formCard mdl-card mdl-shadow--4dp">

                        <div class="formItem">
                          <h3>New Username</h3>
                          <input type="text" name="username" class="input" id="username" value="<?php echo $db_username;?>">
                        </div>

                        <div class="formItem">
                          <h3>New Password</h3>
                          <input class="input" type="password" name="password" required placeholder="Type your new password" min="8">
                          <i class="fas fa-key" aria-hidden="true"></i>
                        </div><br>
                        
                        <div class="formItem">
                          <input class="input "type="password" name="confirm_password" required placeholder="Re-type your password" min="8">
                          <i class="fas fa-key" aria-hidden="true"></i>
                        </div><br>

                        <div class="formItem">
                          <div class="labelform">

                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1" style="padding: 14px 26px 29px;">
                              <input type="radio" id="option-1" class="mdl-radio__button" name="sex" value="male" checked>
                             <span class="mdl-radio__label">Male</span>
                            </label>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2" style="padding: 14px 26px 29px;">
                              <input type="radio" id="option-2" class="mdl-radio__button" name="sex" value="female">
                              <span class="mdl-radio__label">Female</span>
                            </label><br>

                            <!-- <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
                              <input type="radio" id="option-3" class="mdl-radio__button" name="sex" value="Prefer not to say">
                              <span class="mdl-radio__label">Prefer not to say</span>
                            </label> -->

                            <div class="formItem">
                              <h3>Email</h3>
                              <input class="input" type="email" id="email" name="email" value="<?php echo $db_email; ?>">
                            </div><br>
                          </div>
                        </div>

                        <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
                          <i class="material-icons">done</i>
                          <input type="submit" name="registerSubmit" id="formSubmitButton" value="submit">
                        </button>

                      </div>
                    </form>
                  </div><br><br>
                </div> 
                <!--CONTENT OF CUSTOMIZE BIO -->
                <div id="customizeBio" class="tabmenu" style="display:none;">
                  <?php

                    $id = $_SESSION["account_id"];

                    // If the query only returns one row, the array can be fetched in one line.
                    $row = $sql->query("SELECT * FROM tbl_users WHERE user_id = '$id'")->fetch_assoc();

                    extract($row, EXTR_PREFIX_ALL, "db");

                      //Redirect Admins
                      if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
                        header("location: adm_viewUsers.php");
                        exit();
                      }

                  ?>

                  <div class="page-content" align="center"><br><br>
   
                    <form class="" action="handleEditProfile.php" method="POST">
                      <div class="formCard mdl-card mdl-shadow--4dp">

                        <div class="formItem">
                          <h3>Bio</h3>
                        </div>
                        <div>
                          <textarea name="bio" rows="10" cols="50" placeholder="Edit your Bio. <?php echo $db_bio; ?>" required></textarea>
                        </div><br><br><br>
                    
                        <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
                          <i class="material-icons">done</i>
                          <input type="submit" name="registerSubmit" id="formSubmitButton" value="submit">
                        </button>

                      </div>
                    </form>
                  </div>
                </div> 
                <!--CONTENT OF CUSTOMIZE PROFILE PICTURE BANNER -->
                <div id="customizeProfileBanner" class="tabmenu" style="display:none;">
                  <?php

                    $id = $_SESSION["account_id"];

                    // If the query only returns one row, the array can be fetched in one line.
                    $row = $sql->query("SELECT * FROM tbl_users WHERE user_id = '$id'")->fetch_assoc();

                    extract($row, EXTR_PREFIX_ALL, "db");   
                    //Redirect Admins
                    if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
                      header("location: adm_viewUsers.php");
                      exit();
                    }

                    //Changing Profile Picture
                    $tmp_id = $_SESSION["account_id"];
                    if($result = $sql->query("SELECT * FROM tbl_users WHERE id = '$tmp_id'")){
                      while($row = $result->fetch_assoc())
                      {
                        extract($row, EXTR_PREFIX_ALL, "data");
                      }
                    }
                      $requireInput = false;

                  ?>
                  <div class="page-content" align="center"><br><br>

                    <form class="" action="handleEditProfile.php" method="POST">
                      <div class="formCard mdl-card mdl-shadow--4dp">

                        <center><br><img src="images/assets/socialitylogoblack.png" width="300" height="70"><center> <br>
                       
                        <img src="<?php echo $db_profile_pic; ?> "width="215" height="200">
                        <div class="formItem">
                          <h3 class="text-align: center;" <?php echo $db_username; ?> </h3>
                        </div>

                        <div class="formItem">
                          <h3>Profile Picture</h3>
                          <div>
                            <input type="file" name="profile_pic" accept="image/*" <?php echo ($requireInput) ? "required":''; ?>>
                          </div>
                        </div>
                        <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
                          <i class="material-icons">done</i>
                          <input type="submit" name="registerSubmit" id="formSubmitButton" value="submit">
                        </button>
                      </div>
                    </form>
                  </div>
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
  
  function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
       x.className = "topnav";
    }
  }
</script>