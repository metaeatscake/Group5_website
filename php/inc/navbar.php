<?php

  /*
    Site Title
  */
  $nav_siteTitle = "Sociality";

  /*
    Links are not edited in the HTML but prepared here.
  */
  $nav_folderName = "php/";
  $nav_guestLinks = [
    "Log In" => "login.php",
    "Register" => "register.php",
  ];

  $nav_userLinks = [
    "Profile" => "profile.php",
    "Liked Posts" => "likedPosts.php",
    "Log Out" => "logout.php"
  ];

  $nav_adminLinks = [
    "User List" => "adm_viewUsers.php",
    "Posts List" => "adm_viewPosts.php"
  ];

  /*  Reduce code redundancy in the html area
      Ternary operators magic
  */
  $nav_chosenArray = (isset($_SESSION["account_type"])) ?
    ($_SESSION["account_type"] === "user") ? $nav_userLinks : $nav_adminLinks
    : $nav_guestLinks;
 ?>

<header class="mdl-layout__header mdl-layout__header--waterfall">
  <!-- Top row, always visible -->
  <div class="mdl-layout__header-row">
    <!-- Title -->
    <span class="mdl-layout-title"><?php echo $nav_siteTitle; ?></span>
    <div class="mdl-layout-spacer"></div>

  </div>
  <!-- Bottom row, not visible on scroll -->
  <div class="mdl-layout__header-row">
    <div class="mdl-layout-spacer"></div>
    <!-- Navigation -->
    <nav class="mdl-navigation">

      <!--
        Display different links depending on $_SESSION["account_type"]
      -->

      <?php foreach ($nav_chosenArray as $key => $value):?>
        <!--
          These links will be accessed from different locations,
          So to cover for cases where the file clicking is not in
          the same folder, this condition check exists.
        -->
        <?php if (strpos($_SERVER["PHP_SELF"], $nav_folderName) !== false): ?>
          <a class="mdl-navigation__link" href="<?php echo $value; ?>"> <?php echo $key; ?></a>
        <?php else: ?>
          <a class="mdl-navigation__link" href="<?php echo "$nav_folderName$value"; ?>"> <?php echo $key; ?></a>
        <?php endif; ?>
      <?php endforeach; ?>

    </nav>
  </div>
</header>
<div class="mdl-layout__drawer">
  <span class="mdl-layout-title"><?php echo $nav_siteTitle; ?></span>
  <nav class="mdl-navigation">

    <!--
      Display different links depending on $_SESSION["account_type"]
    -->

    <?php foreach ($nav_chosenArray as $key => $value):?>
      <!--
        These links will be accessed from different locations,
        So to cover for cases where the file clicking is not in
        the same folder, this condition check exists.
      -->
      <?php if (strpos($_SERVER["PHP_SELF"], $nav_folderName) !== false): ?>
        <a class="mdl-navigation__link" href="<?php echo $value; ?>"> <?php echo $key; ?></a>
      <?php else: ?>
        <a class="mdl-navigation__link" href="<?php echo "$nav_folderName$value"; ?>"> <?php echo $key; ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
  </nav>
</div>
