<?php
  //Get database and session.
  include_once("inc/database.php");
  //Include validator class.
  include_once("oop/_main.php");

  //Get value of Submit button.
  $editTarget = $_POST["registerSubmit"];

  switch ($editTarget) {
    case "Edit Account":

      $v = new Validate($_POST);
      $v->cleanData();
      $data = $v->getCleanedData();

      /*
        Process Documentation
          Edit Account has two behaviors:
          If the user only wants to change Username
      */

      break;

    default:
      // code...
      break;
  }
 ?>
