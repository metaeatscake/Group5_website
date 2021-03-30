<?php
  //Get database and session.
  include_once("inc/database.php");

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
     <title><?php echo $db_username; ?> | Edit Profile</title>

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

         <div class="page-content" align="center">

           <!-- Edit Profile Card. -->
           <?php 
              $id = $_SESSION["account_id"];

              $username = $_POST["username"];
              $bio = $_POST["bio"];
              $sex = $_POST["sex"];
              $email = $_POST["email"];
              $profile_picture = $_POST["profilePicture"];

              $row = $sql->query("SELECT * FROM tbl_users WHERE email = '$email'")->fetch_assoc();
  
              extract($row, EXTR_PREFIX_ALL, "db");            

              $numOfRows = mysqli_num_rows($row);
              //to check if there's a duplicate
              //i'll leave the classes empty
              if($numOfRows > 0) {
                if($email != $db_email){
                  echo "<h3 style='text-align: center;'><br>Duplicate Record! This user already exist. </h3>";
                  echo "<br><br>";
                  echo "<center><a href='profile.php' class='' style='text-align: center;'>Go back</a></center>"; exit;
                }
              }

              
              ?>
          </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
