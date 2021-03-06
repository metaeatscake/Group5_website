<?php
  //Get database and session.
  include_once("inc/database.php");

  //For preventing bugs, redirect if user is not logged in.
  if (!isset($_SESSION["account_id"])) {
    header("location: ../");
    exit();
  }

  //Get user's ID.
  $s_id = $_SESSION["account_id"];

  //Get User's details.
  $userData = $pdo->prepare("SELECT *
    FROM view_user_stats
    WHERE user_id = :user_id");
  $userData->execute(["user_id" => $s_id]);
  $userData = $userData->fetch(PDO::FETCH_ASSOC);

  //Enable/disable the sponsor box
  $div_showSponsoredContainer = false;

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userData['username']; ?> | Profile</title>

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

    <!-- Magic Custom Javascript FOR LIKE BUTTON -->
    <script src="ajax/xmlhttp.js" charset="utf-8"></script>

    <!-- Edit profile preview image. -->
    <script type="text/javascript">
      let loadFile = function(event,targetElement) {
        let image = document.getElementById(targetElement);
        image.src = URL.createObjectURL(event.target.files[0]);
      };
    </script>
  </head>
  <body>
    <?php include_once("inc/_js_mdl_formAlert.php") ?>

    <?php
      //Dialog for deleting posts.
      include_once("inc/_js_mdl_deletePostDialog.php");
    ?>

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

       <div class="page-content mdl-grid">
        <!-- ADD THE PROFILE CARD HERE. -->
          <div class="start_of_profile_card_css">

            <div class="profile_card">

              <img src="<?php echo $userData['cover_photo']; ?>" class="cover">

              <img src="<?php echo $userData['profile_pic'] ?>" id="profile_pic">

              <!--CHANGE THIS WITH THE TEMPORARY IMG THAT I PUT <img id="profile_p
              ic" src="images/users/$db_profile_pic"> --> <br>

              <!--BELOW AREA OF PROFILE PICTURE-->
              <div id="profile-page-menu-top">
                <!--Name of the User-->
                <div id="profile-menu-username">
                  <?php echo $userData['username']; ?>
                </div>
              </div>
              <br>

              <!--PROFILE MENU BUTTONS, BELOW THE AREA OF PROFILE PAGE MENU TOP-->
                <div class="w3-bar">

                  <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'myPosts')" style="margin:10px;">My Posts</button>
                  <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'about')" style="margin:10px auto;">About</button>
                  <div class="dropdown">
                    <button class="w3-bar-item w3-button tablink" onclick="opentabs(event,'customizeProfile')" style="margin:10px;">Customize Profile</button>
                      <i class="fa fa-caret-down downtip"></i>
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
              <!--SPONSORED, ONLY SHOWN IF SERVER VAR IS TRUE-->
              <?php if ($div_showSponsoredContainer): ?>
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
                    <a href="#">Privacy</a> ??
                    <a href="#">Terms</a> ??
                    <a href="#">Advertising</a> ??
                    <a href="#">Ad Choices</a> ??
                    <a href="#">Cookies</a> ??
                    <a href="#">More</a> ??
                    <a href="#">Sociality</a> &copy 2021
                  </div>

                </div>
              <?php endif; ?>

               <!--POSTS AREA/ABOUT AREA/CUSTOMIZE PROFILE-->
              <div id="post-area-menu">
                <!--CONTENT OF MY POSTS -->
                <div id="myPosts" class="tabmenu">
                  <?php

                      //Prepare the user's like data so the posts can be marked.
                      $pdoq_getUserLikedPosts = $pdo->prepare("SELECT post_id FROM tbl_feed_likes WHERE user_id = :user_id");
                      $pdoq_getUserLikedPosts->execute(['user_id' => $s_id]);
                      $user_liked_post_id = $pdoq_getUserLikedPosts->fetchAll(PDO::FETCH_COLUMN);

                      //Prepare the user's posts.
                      $post_dataArray = $pdo->prepare("
                        SELECT *
                        FROM view_posts_full
                        WHERE user_id = :user_id
                        ORDER BY post_time DESC
                      ");
                      $post_dataArray->execute(["user_id" => $s_id]);
                      $post_dataArray = $post_dataArray->fetchAll(PDO::FETCH_ASSOC);

                  ?>

                  <?php if(empty($post_dataArray)): //IF NO POSTS ?>
                    <div style="text-align:center;color:white;">
                      <h1>You don't have any posts yet.</h1>
                      <h3>Why not <a href="createPost.php" style="text-decoration:underline;color:white;">create one?</a> </h3>
                    </div>

                  <?php else: ?>
                    <?php foreach ($post_dataArray as $row):?>

                     <?php
                        // Like Data setup.
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


                        $profileIDHolder = $hashId->encode($row["user_id"]);
                        $profileLink = "viewProfile.php?id=$profileIDHolder";

                        //For JavaScript like button
                        $js_likePostLink = "ajax/xmlhttp_likePost.php?id=".$post_fancyID;

                        //Post control (edit,delete, etc)
                        $postControlButtonId = "post_control_$post_fancyID";

                        //Toggle to show the post control links.
                        $postControlToggleMenu = ($row["user_id"] === $_SESSION["account_id"]);
                        //Post control links
                        $postControl_editPost = "createPost.php?e=$post_fancyID";
                        $postControl_deletePost = "ajax/xmlhttp_deletePost.php?id=$post_fancyID";
                      ?>

                        <div class="feed_post" id="<?php echo 'p_'.$post_fancyID; ?>">
                          <!-- This is the post control menu button -->

                          <!-- For frontend: fix the size of the button, it's hard to activate it. -->
                          <?php if ($postControlToggleMenu): ?>

                            <div class="more-horiz">
                              <button id="<?php echo $postControlButtonId; ?>"
                                class="mdl-button mdl-js-button mdl-button--icon"
                              >
                                <i class="material-icons">more_vert</i>
                              </button>

                              <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                  for="<?php echo $postControlButtonId; ?>">
                                  <!-- Edit Post -->
                                <a href="<?php echo $postControl_editPost; ?>">
                                  <li class="mdl-menu__item">Edit Post</li>
                                </a>
                                <!-- Delete Post -->
                                <a href="Javascript:void(0)" onClick="xml_deletePost('dialog_deletePost',
                                  '<?php echo $postControl_deletePost; ?>')">
                                  <li class="mdl-menu__item">Delete Post</li>
                                </a>
                              </ul>
                            </div>

                          <?php endif; ?>

                          <div class="feed_userpic">
                            <a href="<?php echo $profileLink; ?>">
                              <img src="<?php echo $row['profile_pic']; ?>">
                            </a>
                          </div>

                          <div class="feed_post_author">
                            <a href="<?php echo $profileLink; ?>">
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
                        </div><br><br><br>

                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>

                <!--CONTENT OF ABOUT -->
                <div id="about" class="tabmenu" style="display:none;">
                  <h2><b>About</b></h2>

                  <h4> <b>Bio</b> </h4>
                  <h7> <?php echo $userData["bio"]; ?></h7>

                  <h4><b>Joined</b></h4>
                  <h7><?php echo $userData["register_time"]; ?></h7>

                  <?php
                    //Table data can be null, so these just set them to 0 if null.
                    $u_totalComments = (isset($userData["count_comments"]))
                      ? $userData["count_comments"]
                      : 0; //Can also be set to say "No comments"

                    $u_totalPostLikes = (isset($userData["count_post_likes"]))
                      ? $userData["count_post_likes"]
                      : 0;

                    $u_totalPosts = (isset($userData["count_posts"]))
                      ? $userData["count_posts"]
                      : 0;
                   ?>

                  <h4> <b> Total Number of Comments </b> </h4>
                  <h7> <?php echo $u_totalComments; ?></h7>

                  <h4> <b> Total Post Count </b> </h4>
                  <h7> <?php echo $u_totalPosts; ?></h7>

                  <h4> <b> Total Post Likes </b> </h4>
                  <h7> <?php echo $u_totalPostLikes; ?></h7>
                </div>

                 <!--CONTENT OF CUSTOMIZE PROFILE -->
                <div id="customizeProfile" class="tabmenu" style="display:none;">
                  <!-- EDIT PROFILE CARD -->
                  <form class="edit-profile-card" action="handleEditProfile.php" method="POST">
                    <div class="formItem">
                      <h5>Edit Username</h5>
                    </div>
                      <div class="formItem">
                      <i  class="fa fa-user"></i>
                      </div>
                    <div>
                      <input type="text" name="username" class="input" id="username" value="<?php echo $userData['username'];?>">
                    </div>

                    <div class="formItem">
                      <h5 style="position: relative;">Change Password</h5>
                      <p style="bottom: -8px; left: -200px; color: #ff0000;"> *Leave blank to not change password </p>
                    </div>
                    <div class="formItem">
                      <i  class="fa">&#xf084;</i>
                    </div>
                      <div class="formItem">
                      <input class="input" type="password" name="password" placeholder="Type your old password" min="8">
                    </div>

                    <div class="formItem">
                      <i  class="fa">&#xf084;</i>
                      <input class="input "type="password" name="new_password" placeholder="Type your new password" min="8">
                    </div>

                    <div class="formItem">
                      <i class="fa">&#xf084;</i>
                      <input class="input "type="password" name="confirm_new_password" placeholder="Confirm your new password" min="8">
                    </div>

                    <div class="formItem">
                      <h5 style=>Email</h5>
                      <p style="right: 330px; color: #ff0000;"> *Leave blank to not change email </p>
                    </div>
                    <div class="formItem">
                      <i class="fa fa-envelope"></i>
                    </div>
                    <div class="formItem">
                      <input class="input" type="email" id="email" name="email" required placeholder="Type your new E-mail" value="<?php echo $userData['email']; ?>">
                    </div><br>

                    <div class="formItem">
                      <div class="formItem" id="gender">
                        <input class="gender" type="radio" name="sex" id="male" value="male" checked>
                        <label for="male">
                          <i class="fa fa-male"></i>
                          <span>Male</span>
                        </label>

                        <input class="gender" type="radio" name="sex" id="female" value="female">
                        <label for="female">
                          <i class="fa fa-female"></i>
                          <span>Female</span>
                        </label>
                      </div>
                    </div>
                    <div class="formItem">
                        <input class="button" type="submit" name="registerSubmit" id="formSubmitButton" class="button" value="Save">
                        <!-- DO NOT REMOVE THIS FIELD. THESE THREE FORMS ONLY SUBMIT TO ONE HANDLER. -->
                        <!-- Possible Values: "Edit Account", "Edit Profile Picture and Banner", "Edit Bio" -->
                        <input type="hidden" name="editProfileTarget" value="Edit Account">
                    </div><br>
                  </form><br><br>
                </div>
                <!--CONTENT OF CUSTOMIZE BIO -->
                <div id="customizeBio" class="tabmenu" style="display:none;">
                  <form class="edit-bio-form" action="handleEditProfile.php" method="POST">
                    <div class="formItem">
                      <h3>Bio</h3>
                    </div>
                    <div>
                      <textarea name="bio" rows="10" cols="50" placeholder="<?php echo $userData['bio']; ?>" required></textarea>
                    </div><br>
                    <div class="formItem">
                      <br><br><br>
                    <input class="button"  type="submit" name="registerSubmit" id="formSubmitButton" value="Save">
                    <!-- DO NOT REMOVE THIS FIELD. THESE THREE FORMS ONLY SUBMIT TO ONE HANDLER. -->
                    <!-- Possible Values: "Edit Account", "Edit Profile Picture and Banner", "Edit Bio" -->
                    <input type="hidden" name="editProfileTarget" value="Edit Bio">
                    </div><br>
                  </form>
                </div>
                <!--CONTENT OF CUSTOMIZE PROFILE PICTURE BANNER -->
                <div id="customizeProfileBanner" class="tabmenu" style="display:none;">
                  <form class="editPictureForm" action="handleEditProfile.php" method="POST" enctype="multipart/form-data" align="center">
                    <img id="js_previewBanner" src="<?php echo $userData['cover_photo']; ?>" width="480" height="250">
                    <div class="formItem">
                      <h3>Profile Banner</h3>
                      <input type="file" name="banner_pic" accept="image/*"
                        onChange="loadFile(event,'js_previewBanner')">
                    </div> <br>

                    <img id="js_previewProfilePic" src="<?php echo $userData['profile_pic']; ?> "width="215" height="200">
                    <div class="formItem">
                      <h3>Profile Picture</h3>
                        <input type="file" name="profile_pic" accept="image/*"
                          onChange="loadFile(event, 'js_previewProfilePic')">
                    </div> <br><br>

                    <div class="formItem">
                      <input class="button" type="submit" name="registerSubmit" id="formSubmitButton" value="Save">
                      <!-- DO NOT REMOVE THIS FIELD. THESE THREE FORMS ONLY SUBMIT TO ONE HANDLER. -->
                      <!-- Possible Values: "Edit Account", "Edit Profile Picture and Banner", "Edit Bio" -->
                      <input type="hidden" name="editProfileTarget" value="Edit Profile Picture and Banner">
                    </div><br>

                  </form>
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
      tablinks[i].className = tablinks[i].className.replace(" btn-primary", "");
    }
    document.getElementById(tabname).style.display = "block";
    tab.currentTarget.className += " btn-primary";
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
