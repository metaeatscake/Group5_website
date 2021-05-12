<?php
  // Annoying filepath resolver for these referenced icons.
  $file_location = $_SERVER["PHP_SELF"];
  $file_inPHPFolder = (strpos($file_location, 'php/') !== false);

  $file_sclLogoLocation = "images/assets/sample2white.png";
  $file_sclLogoSrc = ($file_inPHPFolder) ? $file_sclLogoLocation: 'php/'.$file_sclLogoLocation;

 ?>
 <script src="https://kit.fontawesome.com/7f2eccabe0.js" crossorigin="anonymous"></script>
 <div class="footer">
   <div id="button"></div>
   <div id="container">
     <div class="logo">
       <img src="<?php echo $file_sclLogoSrc; ?>" alt="socialityLogo.png" style="height:30px;">
       <a href="index.php">Sociality</a>
       <i class="fab fa-github"></i>
       <a href="https://github.com/metaeatscake/Group5_website" id="git">Github</a>

       <ul class="list">
           <li>Dependencies: </li>
           <li><a href="https://getmdl.io/index.html">[Material Design Lite]</a></li>
           <li><a href="https://material.io/resources/icons/?style=baseline">[Material Icons]</a></li>
       </ul>
     </div>
   </div>
 </div>
