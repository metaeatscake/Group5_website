<?php

  /*
    Site Title
  */
  $nav_siteTitle = "Sociality";

  /*
    Links are not edited in the HTML but prepared here.
  */
  /* Icon format:
      <i class='material-icons'></i>
      Where the ICON NAME goes inside the <i></i>
      https://material.io/resources/icons/?style=sharp
  */

  $nav_folderName = "php/";
  $nav_guestLinks = [
    "Log In" => "login.php",
    "Register" => "register.php",
  ];
  $nav_guestLinks_icons = [
    "Log In" => "<i class='material-icons'>login</i>'",
    "Register" => "<i class='material-icons'>face</i>"
  ];

  $nav_userLinks = [
    "Create A Post" => "createPost.php",
    "Profile" => "profile.php",
    "Liked Posts" => "likedPosts.php",
    "Log Out" => "logout.php"
  ];
  $nav_userLinks_icons = [
    "Create A Post" => "<i class='material-icons'>add</i>",
    "Profile" => "<i class='material-icons'>account_circle</i>",
    "Liked Posts" => "<i class='material-icons'>thumb_up</i>",
    "Log Out" => "<i class='material-icons'>logout</i>"
  ];

  $nav_adminLinks = [
    "Add Admin User" => "adm_addAdmins.php",
    "User List" => "adm_viewUsers.php",
    "Posts List" => "adm_viewPosts.php",
    "Log Out" => "logout.php"
  ];
  $nav_adminLinks_icons = [
    "Add Admin User" => "<i class='material-icons'>person_add_alt</i>",
    "User List" => "<i class='material-icons'>ballot</i>",
    "Posts List" => "<i class='material-icons'>view_list</i>",
    "Log Out" => "<i class='material-icons'>logout</i>"
  ];

  /*  Reduce code redundancy in the html area
      Ternary operators magic
  */
  $nav_chosenArray = (isset($_SESSION["account_type"])) ?
    ($_SESSION["account_type"] === "user") ? $nav_userLinks : $nav_adminLinks
    : $nav_guestLinks;
  $nav_chosenArray_icons = (isset($_SESSION["account_type"])) ?
    ($_SESSION["account_type"] === "user") ? $nav_userLinks_icons : $nav_adminLinks_icons
    : $nav_guestLinks_icons;

  $nav_greetings = (isset($_SESSION["username"])) ? "Hello, {$_SESSION["username"]}!" : "Hello, Guest!";

  // Resolve Filepath of Logo.
  $nav_logoLocation = (strpos($_SERVER["PHP_SELF"], $nav_folderName) !== false)?
    "images/assets/sample2white.png" : "php/images/assets/sample2white.png";
  $nav_logoLink = (strpos($_SERVER["PHP_SELF"], $nav_folderName) !== false)?
    "../" : "";
 ?>

<header class="mdl-layout__header mdl-layout__header--transparent">
  <!-- Top row, always visible -->
  <div class="mdl-layout__header-row">
    <!-- Title -->
    <br><br>
    <p><a href="<?php echo $nav_logoLink; ?>">
    <img src="<?php echo $nav_logoLocation; ?>" alt="index.php" width="50" height="38" class="logo">
    </a></p>
    <!-- Navigation -->
    <nav class="mdl-navigation">

      <!--
        Display different links depending on $_SESSION["account_type"]
      -->

      <?php foreach ($nav_chosenArray as $key => $value):?>

        <!--
          Change navbar display
            Possible $nav_display values:
              icons_only -> icons only
              text_only -> use the text options only
              both -> use both. (default)
          -->
        <?php
          $nav_display = "both";

          switch($nav_display):
          case 'icons_only': $nav_itemOutput = $nav_chosenArray_icons[$key]; break;
          case 'text_only': $nav_itemOutput = $key; break;
          default: $nav_itemOutput = $nav_chosenArray_icons[$key]." ".$key;
          endswitch
         ?>


        <?php if (strpos($_SERVER["PHP_SELF"], $nav_folderName) !== false): ?>
          <a class="mdl-navigation__link" href="<?php echo $value; ?>"> <?php echo $nav_itemOutput; ?></a>
        <?php else: ?>
          <a class="mdl-navigation__link" href="<?php echo "$nav_folderName$value"; ?>"> <?php echo $nav_itemOutput; ?></a>
        <?php endif; ?>
      <?php endforeach; ?>

    </nav>
  </div>
</header>
<style>
  .mdl-navigation, .mdl-navigation__link{
    color: black;
  }
</style>
<div class="mdl-layout__drawer">
  <span class="mdl-layout-title"><?php echo $nav_siteTitle; ?></span>
  <nav class="mdl-navigation">

    <!--
      Display different links depending on $_SESSION["account_type"]
    -->

    <?php foreach ($nav_chosenArray as $key => $value):?>

      <!--
        Change navbar display
          Possible $nav_display values:
            icons_only -> icons only
            text_only -> use the text options only
            both -> use both. (default)
        -->
      <?php
        $nav_display = "both";

        switch($nav_display):
        case 'icons_only': $nav_itemOutput = $nav_chosenArray_icons[$key]; break;
        case 'text_only': $nav_itemOutput = $key; break;
        default: $nav_itemOutput = $nav_chosenArray_icons[$key]." ".$key;
        endswitch
       ?>


      <?php if (strpos($_SERVER["PHP_SELF"], $nav_folderName) !== false): ?>
        <a class="mdl-navigation__link" href="<?php echo $value; ?>"> <?php echo $nav_itemOutput; ?></a>
      <?php else: ?>
        <a class="mdl-navigation__link" href="<?php echo "$nav_folderName$value"; ?>"> <?php echo $nav_itemOutput; ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
  </nav>
</div>

<style media="screen">
    .logo{
      margin-top: 18px;
    }
</style>
