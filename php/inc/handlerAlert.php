<!-- Alert message from handler. The user will NOT access handler. -->
<?php if(isset($_SESSION["handler-alert"])): ?>
  <script type="text/javascript">
     alert('<?php echo "{$_SESSION["handler-alert"]}"; ?>');

  </script>
  <?php unset($_SESSION["handler-alert"]); ?>
<?php endif; ?>
