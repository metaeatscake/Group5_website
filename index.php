<?php

  include("php/inc/database.php");

  // Redirect Admins
  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
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
   </head>
   <body>

       <!-- Uses a header that contracts as the page scrolls down. -->
       <!-- Pasted CSS/HTML from MDL Documentation -->
      <style>
        .demo-layout-waterfall .mdl-layout__header-row .mdl-navigation__link:last-of-type  {
         padding-right: 0;
        }
      </style>

      <div class="demo-layout-waterfall mdl-layout mdl-js-layout">
        <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
        <?php include_once("php/inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content">
           <!-- Content stuff go here. -->
           <!-- Link to top of the page. -->
           <div id="pageTop"></div>

           <!-- Default Card when user is not logged in. -->
            <?php if(!isset($_SESSION["account_type"])): ?>
              <?php include_once("php/inc/welcomeCard.php"); ?>
            <?php endif; ?>
         </div>

       </main>
      </div>

   </body>

 </html>
