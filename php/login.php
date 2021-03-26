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

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="images/assets/socialityLogo_transparent.png">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="../css/socialityOverrides.css">
  </head>
  <body>
    <!-- Uses a header that contracts as the page scrolls down. -->
    <!-- Pasted CSS/HTML from MDL Documentation -->

   <!-- Uses a transparent header that draws on top of the layout's background -->
   <style>
     .demo-layout-transparent {
       /* REPLACE THIS IMAGE WITH A BETTER BACKGROUND */
       background: url('images/assets/bgdark.jpg') center / cover;
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
        <!-- Form Proper -->
        <form class="" action="handleLogin.php" method="post">

          <div class="formCard mdl-card mdl-shadow--4dp">

            <!-- Title Area (including the background pic) -->
            <div class="mdl-card__title">
              <h2 class="mdl-card__title-text">Login</h2>
            </div>

            <!-- Form Input Fields. -->
            <!-- So Scuffed omg. -->
            <div class="mdl-card__actions mdl-card--border">

              <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col">
                  Username
                  <div class="mdl-textfield mdl-js-textfield mdl-cell--30-col">
                    <input class="mdl-textfield__input" type="text" id="username" name="username">
                    <label class="mdl-textfield__label" for="username">Username</label>
                  </div>
                </div>
              </div>

              <div class="mdl-grid">
                <div class="mdl-cell">
                  Password
                  <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="password" id="password" name="password">
                    <label class="mdl-textfield__label" for="password">Password</label>
                  </div>
                </div>
              </div>

              <!-- Submit Button Area -->
              <div class="mdl-card__actions mdl-card--border">

                <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
                  <i class="material-icons">done</i>
                  Submit
                  <input type="submit" name="registerSubmit" id="formSubmitButton" value="submit">
                </button>
              </div>
              
            </div>

          </div>

        </form>

      </div>

    </main>

    <!-- Footer -->
    <?php include_once("inc/footer.php"); ?>

   </div>
  </body>
</html>
