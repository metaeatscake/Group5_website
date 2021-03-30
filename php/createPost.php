<?php

  //Get database and session.
  include_once("inc/database.php");

  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
    exit();
  }

  //

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sociality | View Profile</title>

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

					 <?php
					   $data = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$_SESSION["account_id"]}'");
					   $row = $data->fetch_assoc();
					   $username = $row["username"];

					  ?>
					  <center>
					   <h2>Create Post</h2>
					   <form action="handleCreatePost.php" method="POST">
					     <input type="text" name="inputTitle" class="" placeholder="Title" required><br><br>
					     <textarea name="inputText" rows="3" cols="4" placeholder="What's on your mind? <?php echo $username; ?>" maxlength="200" style="width: 50%;">
					     </textarea>
					     <br><br>
					     <input type="file" name="inputPic" class="">
					     <br><br>
					     <input type="submit" name="btnSubmit" class="" value="Post">
					   </form>
					  </center>

         </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
