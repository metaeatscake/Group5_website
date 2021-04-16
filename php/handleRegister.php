<?php

  //Get SESSION and DB, and the OOP classes
  include_once("inc/database.php");
  include_once("oop/_main.php");

  //Redirect unwanted access.
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: ../");
    exit();
  }

  //Prepare DB query for fetching existing usernames and emails.
  $queryString = "SELECT * FROM tbl_users";
  $execQuery = $sql->query($queryString);

  $emptyDB = ($execQuery->num_rows === 0);

  // Declare validation object
  $vld = new Validate($_POST);

  // Do the magic data cleaning.
  $vld->cleanData();

  // Handle the empty data.
  $errMsg = $vld->getValidationMessage();
  echo $errMsg;
  if (!empty($errMsg)) {
    $_SESSION["handler-alert"] = $errMsg;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: register.php");
    exit();
  }

  // Do the extra validations - OOP style;

  $vld->verify_set_checkLength([
    "errorKey" => "password_less_than_8_characters",
    "fieldKey" => "password",
    "minLength" => 8
  ]);

  // Do this extra unique entry check if there is data in db.
  if (!$emptyDB) {

    while ($row = $execQuery->fetch_assoc()) {
      $arr_Usernames[] = $row["username"];
      $arr_Emails[] = $row["email"];
    }

    $vld->verify_set_checkUnique([
        "errorKey" => "username_is_already_registered",
        "fieldKey" => "username"
      ],
      $arr_Usernames
    );

    $vld->verify_set_checkUnique([
        "errorKey" => "email_is_already_registered",
        "fieldKey" => "email"
      ],
      $arr_Emails
    );

  }

  $vld->verify_set_checkMatch_String([
      "errorKey" => "password_and_confirm_password_do_not_match",
      "match1" => $vld->getFormVar("password"),
      "match2" => $vld->getFormVar("confirm_password")
  ]);

  // Redirect back to form if the data fails the last tests.
  $errMsg1 = $vld->verify_get_validationMessage();
    //Debug
    //echo $errMsg1;
  if (!empty($errMsg1)) {
    $_SESSION["handler-alert"] = $errMsg1;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: register.php");
    exit();
  }

  extract($vld->getCleanedData(), EXTR_PREFIX_ALL, "data");
  //echo "<pre>"; print_r($vld->getCleanedData()); echo "</pre>";
  //echo "<pre>"; var_dump(get_defined_vars()); echo "</pre>";

  $data_password = password_hash($data_password, PASSWORD_DEFAULT);

  $data_defaultBio = "New user";
  $insertUser = "INSERT INTO tbl_users(
    username, password, email, sex, bio
  ) VALUES (
    '$data_username', '$data_password', '$data_email', '$data_sex', '$data_defaultBio'
  )";

  //echo $insertUser;

  $sql->query($insertUser);
  $_SESSION["handler-alert"] = "Registration Success!\nYou may now log in.";
  $_SESSION["handler-alert-type"] = "Success";
  header("location: login.php");
  exit();

 ?>
