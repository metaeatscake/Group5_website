<?php

  // ADD THIS TO BODY:
  // <?php if(isset($_SESSION["handler-alert"])){echo " onload='showDialog()'"}?<
 ?>

<?php if (isset($_SESSION["handler-alert"])): ?>
  <dialog class="mdl-dialog">
    <h4 class="mdl-dialog__title"><?php echo $_SESSION["handler-alert-type"]; ?></h4>
    <div class="mdl-dialog__content">
      <h6 style="color:black">
        <?php echo nl2br($_SESSION["handler-alert"]); ?>
      </h6>
    </div>
    <div class="mdl-dialog__actions">
      <button type="button" class="mdl-button close">Okay</button>
    </div>
  </dialog>
  <script>
    var dialog = document.querySelector('dialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    function showDialog(){
      dialog.showModal();
    }
    dialog.querySelector('.close').addEventListener('click', function() {
      dialog.close();
      location.reload();
    });
    dialog.querySelector('.agree').addEventListener('click', function(){
      dialog.close();
      location.reload(); 
    })
  </script>

  <?php
    unset($_SESSION["handler-alert"]);
    unset($_SESSION["handler-alert-type"]);
   ?>
<?php endif; ?>
