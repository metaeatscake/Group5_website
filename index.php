<?php

  include("php/inc/database.php");

  // Redirect to login if not logged in.
  if(!isset($_SESSION["account_id"])){
    header("location: php/login.php");
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
     <link rel="stylesheet" href="css/scrollbar.css">

     <!-- Magic Custom Javascript -->
     <script src="php/ajax/xmlhttp.js" charset="utf-8"></script>
   </head>
   <body>

     <?php
      //Dialog for deleting posts.
      include_once("php/inc/_js_mdl_deletePostDialog.php");
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
        <?php include_once("php/inc/navbar.php"); ?>

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

              //PDO Style, get all data from tbl_feed.
              $feed_queryString = "SELECT * FROM view_posts_full ORDER BY post_time DESC";

              $post_dataArray = $pdo->query($feed_queryString)->fetchAll(PDO::FETCH_ASSOC);
              // echo "<pre style='color:white;'>"; var_dump($post_dataArray); echo "</pre>";

            ?>

           <?php if (empty($post_dataArray)): ?>
            <!-- INSERT HOW TO HANDLE SITE WITHOUT POSTS -->
            <br><br>
            <center><h2 style="color:white">Share what's on your mind. It matter to us.</h2></center>

           <?php else: ?>
              <div style="width: 80em; margin:auto; background: -webkit-linear-gradient(to right, #3c1053, #ad5389); align-content: center;">
                <div style="display: flex;">
                  <div>
                    <?php foreach ($post_dataArray as $row): ?>

                     <?php
                        // Like Data setup.
                        $isLiked = (isset($user_liked_post_id) && in_array($row["post_id"], $user_liked_post_id));

                        // NOTE: First string is the color/text when the post IS LIKED, the other is when it is NOT liked.
                        $post_likeButton_color = ($isLiked) ? "#000099" : "#262626";
                        $post_likeButton_text = ($isLiked) ? "Unlike" : "Like";

                        //"Encrypted" POST ID because style.
                        $post_fancyID = $hashId->encode($row['post_id']);

                        //Prepare link for ViewPost.
                        $post_viewPost_href = "php/viewPost.php?id=$post_fancyID";

                        //Prepare like and comment count for each post.
                        $post_likeCount = (isset($row['count_likes'])) ? $row['count_likes'] : 0;
                        $post_commentCount = (isset($row['count_comments'])) ? $row['count_comments'] : 0;

                        //Encode user ID.
                        $profileIDHolder = $hashId->encode($row["user_id"]);

                        //Has two versions:
                          //v1: If you are the creator of the post, clicking your name will redirect to profile.php
                          //v2: Regardless of if you are the post creator, you will be redirected to viewprofile.php
                        //v1
                        //$profileLink = ($row["user_id"] === $_SESSION["account_id"]) ? "php/profile.php" : "php/viewProfile.php?id=$profileIDHolder";
                        //v2 - default.
                        $profileLink = "php/viewProfile.php?id=$profileIDHolder";

                        //Likebutton
                        $js_likePostLink = "php/ajax/xmlhttp_likePost.php?id=".$post_fancyID;

                        //Post control (edit,delete, etc)
                        $postControlButtonId = "post_control_$post_fancyID";

                        //Toggle to show the post control links.
                        $postControlToggleMenu = ($row["user_id"] === $_SESSION["account_id"]);
                        //Post control links
                        $postControl_editPost = "php/createPost.php?e=$post_fancyID";
                        $postControl_deletePost = "php/ajax/xmlhttp_deletePost.php?id=$post_fancyID";
                      ?>
                      <div style="flex: 2.5; padding: 39px 43px 0; padding-right: 0px;">
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
                            <a href="<?php echo $profileLink?>">
                              <img src="<?php echo 'php/'.$row['profile_pic']; ?>">
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
                          <?php if (isset($row["post_img"]) && file_exists("php/".$row["post_img"])): ?>
                            <div class="feed_image">
                                <img src="<?php echo 'php/'.$row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                            </div>
                          <?php endif; ?>
                          <hr>
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
                          </div>
                          <hr>
                        </div>
                        <br>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <div class="side-content">
                    <div id = "covid-sidebar">
                      <div class="feed_userpic">
                        <a href="#">
                          <img src="php/images/assets/coronavirus.png">
                        </a>
                      </div> <br>

                      <div class="covid-updates">
                        <a href="#">COVID-19 Information Center</a><br><br>
                        <p><strong>Latest Updates</strong> (June 24, 2021)</p>
                        <img src="php/images/assets/global1.png"><p>Global confirmed cases: 181,436,184; total deaths: 3,929,829; people fully vaccinated: 818,886,154</p>
                        <img src="php/images/assets/abudhabi.png"><p>Abu Dhabi to ban unvaccinated people from most public places from Aug. 20</p>
                        <img src="php/images/assets/turkey.jpg"><p>Turkey halts flights from six countries, including Brazil and India, over Delta variant</p>
                        <img src="php/images/assets/uk.png"><p>UK records on Monday the highest number of daily cases since January</p>
                        <img src="php/images/assets/microscope.png"><p>Mixing Oxford-AstraZeneca and Pfizer-BioNTech first and second doses generates strong immune response, study shows</p>
                      </div>
                      <div class="covid-websites">
                        <p>To know more, visit these websites:</p>
                        <?php
                          echo '<a href="https://doh.gov.ph/2019-nCoV?fbclid=IwAR0QGeHmsHvDSF5erj1mLvW-bM6wYb2kOuAazhDbHcNE16N55uzEPOnKJQE">Department of Health (Philippines)</a><br><br>';

                          echo '<a href="https://www.who.int/westernpacific?fbclid=IwAR0OsMVcS3XIPV-gLedOkQRUbNdMmqjxvDdv_VfGs1xN3SpbTmszDOu8FwM">World Health Organization Western Pacific Region</a><br><br>';

                          echo '<a href="https://www.who.int/westernpacific?fbclid=IwAR0OsMVcS3XIPV-gLedOkQRUbNdMmqjxvDdv_VfGs1xN3SpbTmszDOu8FwM">World Health Organization Western Pacific Region</a><br><br>';

                          echo '<a href="https://www.unicef.org/philippines/">UNICEF Philippines</a><br><br>';

                          echo '<a href="https://www.unicef.org/coronavirus/covid-19?fbclid=IwAR3-f2q7v2dpcFISXNBULZ5KPP033Cvu4nvJzbxk_7r8X9q3o-47I0HpBHc">UNICEF</a><br><br>';

                          echo '<a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019">World Health Organization (WHO) </a><br><br>';
                       ?>
                      </div>
                    </div>
                    <div class="covid-bar-footer">
                      <a href="#">Privacy</a> ??
                      <a href="#">Terms</a> ??
                      <a href="#">Advertising</a> ??
                      <a href="#">Ad Choices</a> ??
                      <a href="#">Cookies</a> ??
                      <a href="#">More</a> ??
                      <a href="#">Sociality</a> &copy 2021
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
         </div>
       </main>

       <footer>
         <?php include_once("php/inc/footer.php"); ?>
       </footer>

      </div>

   </body>
 </html>
