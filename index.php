<?php

  include("php/inc/database.php");

  // Redirect Admins
  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
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
            <?php else: 
              $data = $sql->query("SELECT * FROM tbl_feed LEFT JOIN tbl_users ON  tbl_users.user_id = tbl_feed.user_id ORDER BY post_time DESC");

              while($row = $data->fetch_assoc()){
                $user_id = $row["user_id"];
                $post_title = $row["post_title"];
                $post_content = $row["post_content"];
                $profile_pic = $row["profile_pic"];
                $post_time = $row["post_time"];
                $username = $row["username"];
                if($_SESSION["account_id"]){
                  echo "<br>";
                  echo "<div class = ' ' >
                          <div class = ' '>
                            <img src='images/users/$profile_pic'>
                          </div>
                          <div class = ' '>
                            <a href='profile.php?id=$user_id' class=''> $username </a>
                            <br>
                            <p style='font-size: 10px;'> $post_time </p>
                          </div>
                          <div class = ' '>
                            <b>$post_title</b>
                            <br><br>
                            <p> ──────────────────── </p>
                            <br>
                            $post_content
                          </div>                                                 
                        </div>";

                }


              }
            ?>

            <?php endif; ?>
         </div>

       </main>

       <?php include_once("php/inc/footer.php"); ?>

      </div>
   </body>

 </html>
