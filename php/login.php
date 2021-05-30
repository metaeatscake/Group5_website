<?php

  //Database and session start.
  include_once("inc/database.php");

  // Backend Code here.

 ?>

 <!-- HTML Area. -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sociality | Login</title>

    <!-- Import Material Design Lite CSS -->
    <link rel="stylesheet" href="../mdl/material.min.css">
    <!-- Import Material Design Lite Javascript -->
    <script src="../mdl/material.min.js" charset="utf-8"></script>
    <!-- Import Material Design Icons from Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Backup for <dialog> not being supported by browser -->
    <script src="../vendor/dialog-polyfill/dist/dialog-polyfill.js" charset="utf-8"></script>
    <!-- Css for Scrollbar -->
    <link rel="stylesheet" href="../css/scrollbar.css">
    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="images/assets/sample2.png">

    <!-- Custom CSS File -->
    <?php include_once("../css/customStyles.php"); ?>

    <script src="https://kit.fontawesome.com/7f2eccabe0.js" crossorigin="anonymous"></script>
  </head>

  <body>

    <!-- Alert message from handler. The user will NOT access handler. -->
    <?php include_once("inc/_js_mdl_formAlert.php"); ?>

    <!-- Uses a header that contracts as the page scrolls down. -->
    <!-- Pasted CSS/HTML from MDL Documentation -->

   <!-- Uses a transparent header that draws on top of the layout's background -->
   <style>
     .demo-layout-transparent {
       /* REPLACE THIS IMAGE WITH A BETTER BACKGROUND */
       background: #ad5389;  /* fallback for old browsers */
      /*background: -webkit-linear-gradient(to right, #3c1053, #ad5389);  /* Chrome 10-25, Safari 5.1-6 */
      /*background: linear-gradient(to right, #3c1053, #ad5389); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

      background-image: url("images/assets/bgbg.png");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center center;
      background-attachment: fixed;
     }
     .demo-layout-transparent .mdl-layout__header,
     .demo-layout-transparent .mdl-layout__drawer-button {
       /* This background is dark, so we set text to white. Use 87% black instead if
          your background is light. */
       color: white;
     }
   </style>

   <div class="demo-layout-transparent mdl-layout mdl-js-layout">
     <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
     <?php include_once("inc/navbar.php"); ?>

    <main class="mdl-layout__content">

      <div class="page-content">
        
        <!-- MAIN CONTENT -->
        <div class="form-wrapper">
          <form class="form-main" action="handleLogin.php" method="POST" >
            <div class="formItem">
            <br>
              <center><img src="images/assets/socialitylogoblack.png" width="300" height="75"><center>
            </div>
            <div class="formItem">
              <label for="username">Username</label>
            </div>
            <div class="formItem">
              <input class="input" type="text" name="username" placeholder="Type your username" required>
              <i class="fas fa-user" aria-hidden="true"></i>
            </div>
            <br><br>
            <div class="formItem">
              <label for="password">Password</label>
            </div>
            <div class="formItem">
              <input class="input "type="password" name="password" required placeholder="Type your password">
              <i class="fas fa-key" aria-hidden="true"></i>
            </div>
            
            <div class="formItem">
              <input class="button" type="submit" name="loginForm" value="Log In">
            </div><br>
            
          </form>
        </div>


      </div>

    </main>

   </div>
  </body>
</html>
