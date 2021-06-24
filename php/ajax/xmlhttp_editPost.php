<?php

  //Debugging. CONFIRMED WORKING.
  //echo json_encode([$_POST, $_FILES]);

  include_once("_db.php");
  include_once("../oop/_main.php");

  //Validator classes
  $v = new Validate($_POST);
  $vi_allowedImages = ["image/png","image/gif","image/jpeg"];
  $vi = new Validate_Image($_FILES, "inputPic", $vi_allowedImages);



  $v->cleanData();

  //Get post id
  $p_id = $v->getFormVar("encodedPostID");
  $p_id = $hashId->decode($p_id);
  $p_id = $p_id[0];

  //Prepare other vars to pass to database.
  $form_newTitle = "";
  $form_newContent = "";
  $form_newImage = "";

  //Validating the two text fields.
  $v_error = $v->getValidationMessage();
  if (!empty($v_error)) {
    echo json_encode(["message" => $v_error]);
    exit();
  }

  $form_newTitle = $v->getFormVar("inputTitle");
  $form_newContent = $v->getFormVar("inputText");

  /*
    Keep the old image, if and ONLY IF:
      The post had an image from the start (will be passed through $_POST) AND
      (There was no uploaded file OR
      The uploaded file was not a valid image.)
    If the post had no image from the start, then the var stays empty.
    Proceed to the next if block to check if there is an image uploaded.
  */
  if (isset($_POST["oldImage"]) &&
    ( !$vi->hasFile() || !empty($vi->getValidationMessage()) )
  ) {
    $form_newImage = $_POST["oldImage"];
  }

  /*
    If there is a file detected, check if it is valid.
  */
  if ($vi->hasFile()) {

    //Cancel the transaction if you upload file that is not image.
    $vi_error = $vi->getValidationMessage();
    if (!empty($vi_error)) {
      echo json_encode(["message" => $vi_error]);
      exit();
    }

    // Continue if it is valid image.
    /*
      Image Filename Documentation.
        To make sure that the filename is unique, the image name
        will be determined by the poster's user id and the post time.
        The time will be taken from the SQL server and formatted.

        Filename: $id_$postingTime.$ext
        Directory: images/post_img/
    */
    $timeFormat = "%Y-%m-%d_%H-%i-%s";
    $time = $pdo->query("SELECT DATE_FORMAT(SYSDATE(), '$timeFormat') AS time_now")->fetch(PDO::FETCH_COLUMN);

    // Filename of uploaded image.
    $ext = $vi->getFileExtension();
    $newFileName = $_SESSION["account_id"] . "_" . $time . "." . $ext;
    $saveFolder = "../images/post_img/";

    // Don't touch.
    $savePath = $saveFolder.$newFileName;
    $form_newImage = "images/post_img/".$newFileName;
    move_uploaded_file($_FILES["inputPic"]["tmp_name"], $savePath);
  }

  //Do query.
  $pdo->prepare("CALL edit_post(
    :post_id, :newTitle, :newContent, :newImage
    )")->execute([
      "post_id" => $p_id,
      "newTitle" => $form_newTitle,
      "newContent" => $form_newContent,
      "newImage" => $form_newImage
  ]);
  // var_dump($_POST);
  // var_dump($_FILES);
  // echo "<br>Passed ID:".$p_id;
  // echo "<br>Passed Title:".$form_newTitle;
  // echo "<br>Passed Content:".$form_newContent;
  // echo "<br>Passed Image:".$form_newImage;
  echo json_encode(["message" => "successful insert"]);
 ?>
