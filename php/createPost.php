<?php

  //Get database and session.
  include_once("inc/database.php");

  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
    exit();
  }

  // Direct/One-line fetch of column data. Extreme shortcut.
  $username = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$_SESSION["account_id"]}'")->fetch_assoc()["username"];

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title> <?php echo $username; ?> | View Profile</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="../mdl/material.min.css">
     <!-- Import Material Design Lite Javascript -->
     <script src="../mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <!-- Backup for <dialog> not being supported by browser -->
     <script src="../vendor/dialog-polyfill/dist/dialog-polyfill.js" charset="utf-8"></script>

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="images/assets/sample2.png">

     <!-- Custom CSS File -->
     <link rel="stylesheet" href="../css/socialityOverrides.css">
     <link rel="stylesheet" type="text/css" href="../css/profileStyles.css">
   </head>

   <!-- MDL Error Dialog support. -->
   <body>

     <?php //Error Handler. ?>
     <?php include_once("inc/_js_mdl_formAlert.php"); ?>

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

         <div class="page-content">

            <div style="min-height: 400px; flex:-5; padding: 90px;">

              <div id="text-area">
                <?php
                  // Direct/One-line fetch of column data. Extreme shortcut.
                   $username = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$_SESSION["account_id"]}'")->fetch_assoc()["username"];
                  ?>
                  <form action="handleCreatePost.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="inputTitle" id="title-bar" placeholder="Title" required>
                      <br>
                    <textarea name="inputText" rows="8" cols="80" placeholder="What's on your mind, <?php echo $username; ?>?"></textarea>
                      <br>
                    <input type="file" id="actual-btn" name="inputPic" hidden/>
                    <label for="actual-btn"><span class="material-icons">
                    drive_folder_upload
                    </span> Photo  </label>
                      <br>
                    <input type="submit" name="btnSubmit" class="btn-primary" value="Post">
                    <br><br>
                  </form>
              </div>

            </div>

           </div>

         </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
