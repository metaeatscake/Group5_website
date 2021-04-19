<?php
  // Annoying filepath resolver for these referenced icons.
  $file_location = $_SERVER["PHP_SELF"];
  $file_inPHPFolder = (strpos($file_location, 'php/') !== false);

  $file_sclLogoLocation = "images/assets/sample2white.png";
  $file_sclLogoSrc = ($file_inPHPFolder) ? $file_sclLogoLocation: 'php/'.$file_sclLogoLocation;

 ?>

<footer class="mdl-mini-footer">
  <div class="mdl-mini-footer__left-section">
    <div class="mdl-logo">
      <img src="<?php echo $file_sclLogoSrc; ?>" alt="socialityLogo.png" style="height:30px;">
      Sociality
    </div>
    <ul class="mdl-mini-footer__link-list">
      <li><a href="https://github.com/metaeatscake/Group5_website">Github</a></li>

    </ul>
  </div>
  <div class="mdl-mini-footer__right-section">
    <ul class="mdl-mini-footer__link-list">
      <li>Dependencies: </li>
      <li><a href="https://getmdl.io/index.html">[Material Design Lite]</a></li>
      <li><a href="https://material.io/resources/icons/?style=baseline">[Material Icons]</a></li>
    </ul>
  </div>
</footer>
