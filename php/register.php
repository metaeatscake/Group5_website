<?php

  include_once("inc/database.php");

 ?>

 <!-- HTML Area. -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sociality | Register</title>

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

    <!-- Alert message from handler. The user will NOT access handler. -->
    <?php if(isset($_SESSION["handler-alert"])): ?>
      <script type="text/javascript">
         alert('<?php echo "{$_SESSION["handler-alert"]}"; ?>');

      </script>
      <?php unset($_SESSION["handler-alert"]); ?>
    <?php endif; ?>


    <!-- Uses a header that contracts as the page scrolls down. -->
    <!-- Pasted CSS/HTML from MDL Documentation -->

   <!-- Uses a transparent header that draws on top of the layout's background -->
   <style>
     .demo-layout-transparent {
       /* REPLACE THIS IMAGE WITH A BETTER BACKGROUND */
       background: #ad5389;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to right, #3c1053, #ad5389);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to right, #3c1053, #ad5389); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
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

        <!-- CSS Control of the main form card. -->


        <!-- Form Proper -->
        <form class="" action="handleRegister.php" method="post">

          <div class="formCard mdl-card mdl-shadow--4dp">

            <!-- Title Area (including the background pic) -->
            <div class="mdl-card__title">
              <h2 class="mdl-card__title-text">Register</h2>
            </div>

            <!-- Subtext underneath title -->
            <!-- <div class="mdl-card__supporting-text">
              Register an account.
            </div> -->

            <!-- Form Input Fields. -->
            <!-- So Scuffed omg. -->
            <!-- <div class="mdl-card__actions mdl-card--border"> -->

              <div class="formItem">
                  <label>Username</label>
                  <div class="inputform">
                    <input class="input" type="text" id="username" name="username" required>
                  </div>
              </div>

              <div class="formItem">
                  <label>Password</label>
                  <input class="input" type="password" id="password" name="password" required>
              </div>

              <div class="formItem">
                  <label>Confirm Password</label>
                    <input class="input" type="password" id="password-confirm" name="password-confirm" required>
                  </div>
              </div>

              <div class="formItem">
                <div class="labelform">
                  <label class="label" for="email">Email</label>
                </div>
                  <div class="formItem">
                    <input class="input" type="email" id="email" name="email" required>

                  </div>

              </div>

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

                  <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
                    <i class="material-icons">done</i>
                    Submit
                    <input type="submit" name="registerSubmit" id="formSubmitButton" value="submit">
                  </button>
                </div>
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

<style>
/* This part controls the whole card container */
.formCard.mdl-card {
  width: 30%;
  margin:auto;
  margin-top: 20px;
}

/* This part controls the title area and it's background */
/* .formCard > .mdl-card__title {
  color: black;
  height: 130px;
  text-align: center;
  background: url('images/assets/bglight.jpg') center / cover;
} */

#formSubmitButton{
  visibility:hidden;
}

#formSubmitButton-container{
  margin:auto;
  width:100%;
}

.formCard-inputFields{
  margin:auto;
  padding:10px;
  align-items: center;
  align-content: center;
}

.form_itemPadding{
  visibility:hidden;
  width:100%;
}

</style>
