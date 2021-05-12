<?php
  // Annoying filepath resolver for these referenced icons.
  $file_location = $_SERVER["PHP_SELF"];
  $file_inPHPFolder = (strpos($file_location, 'php/') !== false);

  $file_sclLogoLocation = "images/assets/sample2.png";
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
<style media="screen">
*{
  margin: 0;
  padding: 0;
}

.footer #button{
  width:35px;
  height:35px;
  border: #727172 12px solid;
  border-radius:35px;
  margin-left: 100%;
  position: relative;
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;


}
.footer #button:hover{
  width:35px;
  height:35px;
  border: #3A3A3A 12px solid;
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
  position:relative;
}
.footer{
  bottom:0;
  left:0;
  position:fixed;
    width: 100%;
    height: 2em;
    overflow:hidden;
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
  z-index:999;
}
.footer:hover {
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
    height: 11em;
}
.footer #container{
  margin-top:5px;
  width:100%;
  height:100%;
  position:relative;
  top:0;
  left: 0;
  background: #f2f2f2;
  margin-left: 0%;
}


.logo{
  margin-left: 20px;
  padding-top: 25px;
}

.logo a{
  text-decoration: none;
  color: #696969;
  font-weight: bold;
}

.logo a:hover{
  font-weight: bold;
  text-decoration: underline;
  text-underline-position: under;
  text-decoration-thickness: 2px;
  color: #3e1154;
}

.logo img{
  padding-bottom: 10px;
}

.logo i{
  font-size: 26px;
  height: 30px;
  margin-left: 20px;
}

.logo ul{
  float: right;
  display: inline;
}

.logo ul li{
  display: inline-block;
  margin-right: 20px;
  padding-top: 7px;
  font-weight: bold;
}
</style>
