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

      //Validate password if it is filled in.
      if (!in_array(true,[
        empty($data["password"]),
        empty($data["new_password"]),
        empty($data["confirm_new_password"])
      ], true )) {
        //Get old password to verify stuff.
        $pdoq_getOldPass = $pdo->prepare("SELECT password FROM tbl_users WHERE user_id = :user_id");
        $pdoq_getOldPass->execute(["user_id" => $_SESSION["account_id"]]);
        $userOldPass = $pdoq_getOldPass->fetch(PDO::FETCH_COLUMN);

        $err["new_password_and_confirm_password_does_not_match"] = (strcmp(
          $data["new_password"], $data["confirm_new_password"]
        ) != 0);
        $err["new_password_is_the_same_as_old_password"] = (password_verify(
          $data["new_password"], $userOldPass
        ));
        $err["new_password_is_less_than_8_characters"] = (strlen($data["new_password"]) < 8);

        $errmsg = $v->getValidationMessageCustom($err);

        //Return error if there is error.
        if (!empty($errmsg)) {
          $_SESSION["handler-alert"] = $errmsg;
          $_SESSION["handler-alert-type"] = "Error";
          header("location: profile.php");
          exit();
        }

      }

      $pdoq_updateProfileAcc = $pdo->prepare("CALL edit_user_account(:user_id, :username, :password, :email, :sex)");
      $pdoq_updateProfileAcc->execute([
        "user_id" => $_SESSION["account_id"],
        "username" => $data["username"],
        "password" => $data["new_password"],
        "email" => $data["email"],
        "sex" => $data["sex"]
      ]);
      header("location: profile.php");
      exit();
      break;

    case "Edit Bio":

      $v = new Validate($_POST);
      $v->cleanData();
      $bio = $v->getCleanedData()["bio"];

      $pdoq_updateBio = $pdo->prepare("CALL edit_user_bio(:user_id, :bio)");
      $pdoq_updateBio->execute([
        "user_id" => $_SESSION["account_id"];
        "bio" => $bio
      ]);
      header("location: profile.php");
      exit();

      break;

    case "Edit Profile Picture and Banner":

      break;

    default:
      // code...
      break;
  }
 ?>
