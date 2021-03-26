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

        <!-- CSS Control of the main form card. -->
        <style>
        /* This part controls the whole card container */
        .formCard.mdl-card {
          width: 30%;
          margin:auto;
          margin-top: 20px;
        }

        /* This part controls the title area and it's background */
        .formCard > .mdl-card__title {
          color: black;
          height: 130px;
          text-align: center;
          background: url('images/assets/bglight.jpg') center / cover;
        }

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

              <div class="mdl-grid">

                  <div class="mdl-cell mdl-cell--6-col">Confirm Password</div>

                  <div class="mdl-textfield mdl-js-textfield">
                    <input class=" mdl-textfield__input" type="password" id="password-confirm" name="password-confirm">
                    <label class="mdl-textfield__label" for="password-confirm">Password Confirm</label>
                  </div>

              </div>

              <div class="mdl-grid">
                <div class="mdl-cell">Email</div>

                  <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="email" id="email" name="email">
                    <label class="mdl-textfield__label" for="email">Email</label>
                    <span class="mdl-textfield__error">This is not a valid email address</span>
                  </div>

              </div>

              <div class="mdl-grid">
                <div class="mdl-cell">
                  <div class="mdl-grid">Sex</div>
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

        </form>

      </div>

    </main>

    <!-- Footer -->
    <?php include_once("inc/footer.php"); ?>

   </div>
  </body>
</html>
