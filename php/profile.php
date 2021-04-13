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
        .btnEdit{
          background-color: #d9d9d9; 
          padding: 5px;
          position: absolute;
          border-radius: 5px;
          top: 550px;
          right: 990px;
        }
        .btnEdit:hover{
          background-color: #bfbfbf;
        }
        .cover-about{
          background-color: white;
          width: 320px;
          padding: 19px;
          border: 5px;
          margin: 0;
          border-radius: 3px;
        }
        a{
          text-decoration: none;
          color: black;
        }
        #profile_pic{
          width: 150px;
          margin-top: -200px;
          border-radius: 50%;
          border: solid 2px white;
        }
        #profile-menu-buttons{
          width: 100px;
          display: inline-block;
          margin: 2px;
        }
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">
        <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
        <?php include_once("inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content mdl-grid">
            <!-- ADD THE PROFILE CARD HERE. -->
              <div style="width: 900px; height: 600px; margin:auto; background-color: #d9d9d9; min-height: 400px; align-content: center;">

                <div style="background-color: white; text-align: center; color: #405d9b">
                  <img src="images/assets/bglight.jpg" style="width: 100%;">
                  <!--TEMPORARY ONLY, ONCE I KNOW HOW TO WORK ON PUTTING UPLOAD IMAGE ICON BESIDE THE PROFILE PICTURE-->
                  <img src="images/users/_default.jpg" id="profile_pic">
                  <!--
                    CHANGE THIS WITH THE TEMPORARY IMG THAT I PUT
                    <img id="profile_pic" src="images/users/$db_profile_pic">
                  -->
                  <br>
                  <div style="font-size: 20px">
                      <?php echo $db_username; ?>
                  </div>;
                  <br>
                  <div id=profile-menu-buttons>Timeline</div>
                  <div id=profile-menu-buttons>About</div>
                  <div id=profile-menu-buttons>Friends</div>
                  <div id=profile-menu-buttons>Photos</div>
                  <div id=profile-menu-buttons>Settings</div>
                </div>
              </div>

          </div>
  
       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
