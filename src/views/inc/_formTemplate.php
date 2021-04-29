<!-- MAIN CONTENT -->

<!-- CSS Control of the main form card. -->
<style>
/* This part controls the whole card container */
.formCard.mdl-card {
  width: 60%;
  margin:auto;
  margin-top: 20px;
}

/* This part controls the title area and it's background */
.formCard > .mdl-card__title {
  color: black;
  height: 130px;
  text-align: center;
  background: url('images/assets/bglight.jpg') center / cover;
}

/* Hide the submit button */
#formSubmitButton{
  visibility:hidden;
}

/* Control the size of the submit button */
#formSubmitButton-container{
  margin:auto;
  width:100%;
}

</style>

<!-- Form Proper -->
<form class="" action="#" method="post">

  <div class="formCard mdl-card mdl-shadow--4dp">

    <!-- Title Area (including the background pic) -->
    <div class="mdl-card__title">
      <h2 class="mdl-card__title-text">FORM-TITLE</h2>
    </div>

    <!-- Subtext underneath title -->
    <div class="mdl-card__supporting-text">
      Poopoo
    </div>

    <!-- Form Input Fields. -->
    <div class="mdl-card__actions mdl-card--border">

      input fields.
    </div>

    <!-- Submit Button Area -->
    <div class="mdl-card__actions mdl-card--border">

      <button class="mdl-button mdl-js-button mdl-button--raised" id="formSubmitButton-container">
        <i class="material-icons">done</i>
        Submit
        <input type="submit" name="Submit" id="formSubmitButton" value="">
      </button>
    </div>

  </div>

</form>
