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
        <form action="handleLogin.php" method="POST">
          
        </form>

      </div>

    </main>

    <!-- Footer -->
    <?php include_once("inc/footer.php"); ?>

   </div>
  </body>
</html>
