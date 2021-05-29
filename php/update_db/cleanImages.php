<?php

  foreach (glob("../images/post_img/*.{jpg,png}", GLOB_BRACE) as $file) {
    unlink($file);
  }

  header("location: ../../index_dev.html");
  exit();
 ?>
