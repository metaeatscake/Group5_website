<?php

  include("php/inc/database.php");

  // Redirect to login if not logged in.
  if(!isset($_SESSION["account_type"])){
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
             <h1>lmao no posts xdddd</h1>

           <?php else: ?>
              <div style="width: 85em; margin:auto; background: -webkit-linear-gradient(to right, #3c1053, #ad5389); align-content: center;">
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

                        $profileIDHolder = $row["user_id"];
                        $profileLink = ($row["user_id"] === $_SESSION["account_id"]) ? "php/profile.php" : "php/viewProfile.php?id=$profileIDHolder";

                        $js_likePostLink = "php/ajax/xmlhttp_likePost.php?id=".$post_fancyID;
                      ?>
                      <div style="flex: 2.5; padding: 20px; padding-right: 0px;">
                        <div class="feed_post" id="<?php echo 'p_'.$post_fancyID; ?>">
                          <div class="more-horiz">
                            <span class="material-icons">more_horiz</span>
                          </div>

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
                        <p><strong>Latest Updates</strong> (June 7, 2021)</p>
                        <img src="php/images/assets/global1.png"><p>Global confirmed cases: 172,997,361; total deaths: 3,721,867; people fully vaccinated: 450,454,935</p>
                        <img src="php/images/assets/india.png"><p>India to ease some restrictions in New Delhi from Monday as cases fall slightly</p>
                        <img src="php/images/assets/us.png"><p>US surpasses 300 million COVID-19 vaccine doses administered</p>
                        <img src="php/images/assets/uk.png"><p>UK prime minister urges G7 nations to commit to vaccinating world by end of 2022</p>
                        <img src="php/images/assets/malaysia.png"><p>Malaysia to invite 3,000 people for trials of new vaccine by Shenzhen Kangtai Biological Products</p>
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
                      <a href="#">Privacy</a> · 
                      <a href="#">Terms</a> · 
                      <a href="#">Advertising</a> · 
                      <a href="#">Ad Choices</a> · 
                      <a href="#">Cookies</a> · 
                      <a href="#">More</a> · 
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
