<!-- Wide card with share menu button -->
<style>
.demo-card-wide.mdl-card {
  width: 70%;
  /* border:1px solid red; */
  margin:auto;
  margin-top: 40px;

}
.demo-card-wide > .mdl-card__title {
  color: #000;
  height: 50vh;
  /* So scuffed, please help. */
  background: url('php/images/assets/socialityLogo.png') 50px center;
}
.demo-card-wide > .mdl-card__menu {
  color: #fff;
}
</style>

<div class="demo-card-wide mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Welcome</h2>
  </div>
  <div class="mdl-card__supporting-text">
    There's no posts rn
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
  </div>
  <div class="mdl-card__menu">
    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
      <i class="material-icons">share</i>
    </button>
  </div>
</div>
