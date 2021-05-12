<?php
  // Annoying filepath resolver for these referenced icons.
  $file_location = $_SERVER["PHP_SELF"];
  $file_inPHPFolder = (strpos($file_location, 'php/') !== false);

  $file_sclLogoLocation = "images/assets/sample2.png";
  $file_sclLogoSrc = ($file_inPHPFolder) ? $file_sclLogoLocation: 'php/'.$file_sclLogoLocation;

 ?>
 <script src="https://kit.fontawesome.com/7f2eccabe0.js" crossorigin="anonymous"></script>
 <div class="footerSCL">
   <div id="footer_button"></div>
   <div id="footer_container">
     <div class="footer_logo">
       <img src="<?php echo $file_sclLogoSrc; ?>" alt="socialityLogo.png" style="height:30px;">
       <a href="index.php">Sociality</a>
       <i class="fab fa-github"></i>
       <a href="https://github.com/metaeatscake/Group5_website" id="git">Github</a>
           <li><a href="https://getmdl.io/index.html">[Material Design Lite]</a></li>
           <li><a href="https://material.io/resources/icons/?style=baseline">[Material Icons]</a></li>
           <li>Dependencies: </li>
     </div>
   </div>
 </div>
