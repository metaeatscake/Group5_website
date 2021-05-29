<!-- Wide card with share menu button -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
.demo-card-wide.mdl-card {
  width: 45%;
  /* border:1px solid red; */
  margin:auto;
  margin-top: 40px;
  box-shadow: 5px 6px 10px black;

}
.demo-card-wide > .mdl-card__title {
  color: white;
  font-weight: bold;
  height: 60vh;
  /* So scuffed, please help. */
  /*background: url('php/images/assets/welcome-card.jpg');
  background-position: center center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;*/
}
.demo-card-wide > .mdl-card__menu {
  color: #cca8e6;
}
#wel{
  /* font-weight: bold; */
  font-size: 3rem;
  font-style: normal;
}
@font-face {
	font-family: 'proxima_nova_rgbold';
	src: url('https://litmus.com/fonts/Emails/proximanova-bold-webfont.eot');
	src: url('https://litmus.com/fonts/Emails/proximanova-bold-webfont.eot?#iefix') format('embedded-opentype'),
		 url('https://litmus.com/fonts/Emails/proximanova-bold-webfont.woff') format('woff'),url('https://litmus.com/fonts/Emails/adelle_reg-webfont.ttf') format('truetype'),
		 url('https://litmus.com/fonts/Emails/adelle_reg-webfont.svg#adelle_rgregular') format('svg');
	font-weight: normal;
	font-style: normal;

}

a{
  text-decoration: none;
  color: black;
}

a:hover{
  text-decoration: underline;
}
</style>

<div class="demo-card-wide mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <!-- <h2 id="wel" class="mdl-card__title-text" style="text-shadow: 2px 2px 5px black; text-align: center;"></h2> -->
      <img src="php/images/assets/welcome-card.jpg" style="width: 100%; height: 100%;">
    
  </div>
  <!-- <div class="mdl-card__supporting-text">
    <a href="php/register.php">Join Us</a>
  </div>
  
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"
      href="php/login.php">
      Log In
    </a>
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"
      href="php/register.php">
      Register
    </a>
  </div> -->

</div>
