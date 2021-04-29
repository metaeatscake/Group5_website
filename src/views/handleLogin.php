<?php

  // Get DB and Classes.
  include_once("inc/database.php");
  include_once("oop/_main.php");

  //Prevent unwanted access.
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: ../");
    exit();
  }

  // Declare object
  $vld = new Validate($_POST);

  // Magic.
  $vld->cleanData();

  // Redirect if empty data.
  $emptyDataErrorMsg = $vld->getValidationMessage();
  if (!empty($emptyDataErrorMsg)) {
    $_SESSION["handler-alert"] = $emptyDataErrorMsg;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: login.php");
    exit();
  }

  //PDO Stuff.
  $pdoq_getUsers = $pdo->query("SELECT * FROM tbl_users")->fetchAll();

  // Trying to do in_array() if the array is empty causes some errors.
  // Also makes sure that the following while loop doesn't fail.
  if (!$pdoq_getUsers) {
    $_SESSION["handler-alert"] = "The database has no registered users.";
    $_SESSION["handler-alert-type"] = "Error";
    header("location: login.php");
    exit();
  }

  foreach ($pdoq_getUsers as $row) {
    $arr_userList[] = $row["username"];
  }
  $vld->verify_set_checkExisting([
    "errorKey" => "this_user_does_not_exist",
    "fieldKey" => "username"
  ], $arr_userList);

  //Next Error Check: given user does not exist.
  $errMsg = $vld->verify_get_validationMessage();
  if (!empty($errMsg)) {
    $_SESSION["handler-alert"] = $errMsg;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: login.php");
    exit();
  }

  // PDO style of preparing password.
  $pdoq_getData = $pdo->prepare("SELECT * FROM tbl_users WHERE username = :username");
  $pdoq_getData->execute(['username' => $vld->getFormVar("username")]);
  $userDataArray = $pdoq_getData->fetch(PDO::FETCH_ASSOC);
  $passHash = $userDataArray["password"];

  $vld->verify_set_checkMatch_Password([
    "errorKey" => "wrong_password",
    "fieldKey" => "password",
    "passwordHash" => $passHash
  ]);

  //Last Error Check: Password doesn't match.
  $errMsg = $vld->verify_get_validationMessage();
  if (!empty($errMsg)) {
    $_SESSION["handler-alert"] = $errMsg;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: login.php");
    exit();
  }

  // Successful Login.
  $_SESSION["account_id"] = $userDataArray["user_id"];
  $_SESSION["account_type"] = $userDataArray["account_type"];
  $_SESSION["username"] = $userDataArray["username"];

  header("location: ../");
  exit();
 ?>
