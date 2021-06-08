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
        "user_id" => $_SESSION["account_id"],
        "bio" => $bio
      ]);
      header("location: profile.php");
      exit();

      break;

    case "Edit Profile Picture and Banner":

      $validImages = [
    		"image/png",
    		"image/gif",
    		"image/jpeg"
    	];

      $profPic = new Validate_Image($_FILES, "profile_pic", $validImages);
      $bannerPic = new Validate_Image($_FILES, "banner_pic", $validImages);

      // Validation.
      $errString = "";

      // Filepath vars
      $loc_profPic = "";
      $loc_banner = "";

      //Profile Pic Setup
      if ($profPic->hasFile()) {
        $errProfPic = $profPic->getValidationMessage();
        if (!empty($errProfPic)) {
          $errString .= "\n".$errProfPic;
        } else{

          //Clean old profile pic, don't remove it if it's the default.
          $pdoq_getOldProfilePic = $pdo->prepare("SELECT profile_pic FROM view_user_stats WHERE user_id = :user_id");
          $pdoq_getOldProfilePic->execute(["user_id" => $_SESSION["account_id"]]);
          $oldPic = $pdoq_getOldProfilePic->fetch(PDO::FETCH_COLUMN);
          $defaultPic = "images/users/_default.jpg";
          if ($oldPic !== $defaultPic) {
            unlink($oldPic);
          }

          //Prepare upload filename
          $profPic_fileExt = $profPic->getFileExtension();
          $profPic_fileName = $_SESSION["account_id"] . "_profilePic" . "." . $profPic_fileExt;
          $saveFolder = "images/users/";

          //Save pic to server then mark the filepath to pass to db
          $loc_profPic = $saveFolder.$profPic_fileName;
          move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $loc_profPic);

        }
      }

      //Banner Pic setup.
      if ($bannerPic->hasFile()) {
        $errBanner = $bannerPic->getValidationMessage();
        if (!empty($errBanner)) {
          $errString .= "\n".$errBanner;
        } else{

          //Clean old banner pic
          $pdoq_getOldBanner = $pdo->prepare("SELECT cover_photo FROM view_user_stats WHERE user_id = :user_id");
          $pdoq_getOldBanner->execute(["user_id" => $_SESSION["account_id"]]);
          $oldBanner = $pdoq_getOldBanner->fetch(PDO::FETCH_COLUMN);
          $defaultBanner = "images/users_cover/_default.png";
          if ($oldBanner !== $defaultBanner) {
            unlink($oldBanner);
          }

          //Prepare upload filename
          $bannerPic_fileExt = $bannerPic->getFileExtension();
          $bannerPic_fileName = $_SESSION["account_id"] . "_cover_photo" . "." . $bannerPic_fileExt;
          $saveFolder = "images/users_cover/";

          //Save pic to server then pass filepath to var
          $loc_banner = $saveFolder.$bannerPic_fileName;
          move_uploaded_file($_FILES["banner_pic"]["tmp_name"], $loc_banner);

        }
      }

      //If either the banner or profile pic had errors, redirect.
      if (!empty($errString)) {
        $_SESSION["handler-alert"] = $errString;
        $_SESSION["handler-alert-type"] = "Error";
        header("location: profile.php");
        exit();
      }

      //Add file locations to database.
      $pdoq_updatePics = $pdo->prepare("CALL edit_user_pictures(:user_id, :prof_pic, :cover)");
      $pdoq_updatePics->execute([
        "user_id" => $_SESSION["account_id"],
        "prof_pic" => $loc_profPic,
        "cover" => $loc_banner
      ]);
      header("location: profile.php");
      exit();
      break;

    default:
      echo "unknown Submit Button value.";
      break;
  }
 ?>
