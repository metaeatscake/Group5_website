<!-- Wide card with share menu button -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
.demo-card-wide.mdl-card {
  width: 70%;
  /* border:1px solid red; */
  margin:auto;
  margin-top: 40px;
  box-shadow: 5px 6px 10px black;

}
.demo-card-wide > .mdl-card__title {
  color: #cca8e6;
  font-weight: bold;
  height: 50vh;
  /* So scuffed, please help. */
  background: url('php/images/assets/open.jpg');
  background-position: center center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
.demo-card-wide > .mdl-card__menu {
  color: #cca8e6;
}
#wel{
  /* font-weight: bold; */
  font-size: 3rem;
  font-family: 'Staatliches', cursive;
  text-shadow: 2px 2px 5px black;
}
</style>

<div class="demo-card-wide mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 id="wel" class="mdl-card__title-text">We are Connecting you with the Digital life</h2>
  </div>
  <div class="mdl-card__supporting-text">
    There's no posts rn
  </div>
  <!--
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"
      href="php/login.php">
      Log In
    </a>
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"
      href="php/register.php">
      Register
    </a>
  </div>-->
  <div class="mdl-card__menu">
    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
      <i class="material-icons">share</i>
    </button>
  </div>
</div>
