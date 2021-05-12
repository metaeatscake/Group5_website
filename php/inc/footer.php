<?php
  // Annoying filepath resolver for these referenced icons.
  $file_location = $_SERVER["PHP_SELF"];
  $file_inPHPFolder = (strpos($file_location, 'php/') !== false);

  $file_sclLogoLocation = "images/assets/sample2white.png";
  $file_sclLogoSrc = ($file_inPHPFolder) ? $file_sclLogoLocation: 'php/'.$file_sclLogoLocation;

 ?>

<div class="footer">
  <div id="button"></div>
  <div id="container">
    <div id="cont">
      <div class="left">
        <ul class="link-list">
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
  height: 20em;
}
.footer #container{
  margin-top:5px;
  width:100%;
  height:100%;
  position:relative;
  top:0;
  left: 0;
  background: grey;
}
.footer #cont{
  position:relative;
  top:-45px;
  right:190px;
  width:150px;
  height:auto;
  margin:0 auto;
}

.left{
  width:500px;
  float: left;
}
.footer .left{
  margin-top:70px;
}

.link-list{
  list-style-type: none;
}

</style>
