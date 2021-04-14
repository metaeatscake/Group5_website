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
  //Changing Profile Picture
  $tmp_id = $_SESSION["account_id"];
  if($result = $sql->query("SELECT * FROM tbl_users WHERE id = '$tmp_id'"))
  {
    while($row = $result->fetch_assoc())
    {
      extract($row, EXTR_PREFIX_ALL, "data");
    }
  }
  $requireInput = false;
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
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">
        <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
        <?php include_once("inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content" align="center">

           <!-- Edit Profile Card. -->
           <!--Form Proper-->
          <br><br>
           <form class="" action="handleEditProfile.php" method="POST">
             <div class="formCard mdl-card mdl-shadow--4dp">

            <!-- Title Area (including the background pic) -->
            <!--i just copied some css on register, you can still change it-->
            
            <center><br><br><img src="images/assets/socialitylogoblack.png" width="300" height="70"><center>
            <br>
            <img src="<?php echo $db_profile_pic; ?> "width="215" height="200">
               <div class="formItem">
                <h3 class="text-align: center" >--- <?php echo $db_username; ?> ---</h3>
               </div>
               <div class="formItem">
              <label>Profile Picture</label>
               <div>
               <input type="file" name="profile_pic" accept="image/*" <?php echo ($requireInput) ? "required":''; ?>>
               </div>
        
               <div class="formItem">
                 <label>Username</label>
                 <div class="">
                   <input type="text" name="username" class="input" id="username" value="<?php echo $db_username;?>">
                 </div>
               </div>
               <br>
               <div class="formItem">
                 <label>Bio</label>
                 <div>
                   <input type="text" name="bio" class="input" id="bio" value="<?php echo $db_bio; ?>">
                 </div>
               </div>
               <br>
              <div class="formItem">
                <div class="labelform">
                  <div class="formItem">Sex</div>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                    <input type="radio" id="option-1" class="mdl-radio__button" name="sex" value="male" checked>
                    <span class="mdl-radio__label">Male</span>
                  </label>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                    <input type="radio" id="option-2" class="mdl-radio__button" name="sex" value="female">
                    <span class="mdl-radio__label">Female</span>
                  </label>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
                    <input type="radio" id="option-3" class="mdl-radio__button" name="sex" value="Prefer not to say">
                    <span class="mdl-radio__label">Prefer not to say</span>
                  </label>
                </div>
                <br>
              <div class="formItem">
                <div class="labelform">
                  <label class="label" for="email">Email</label>
                </div>
                  <div class="formItem">
                    <input class="input" type="email" id="email" name="email" value="<?php echo $db_email; ?>">
                  </div>
              </div>
               <br>
                  <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
                    <i class="material-icons">done</i>
                    <input type="submit" name="registerSubmit" id="formSubmitButton" value="submit">
                  </button>
              </div>
             </form>
             <br><br>
          </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
