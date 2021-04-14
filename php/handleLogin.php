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

  // Prepare existing users
  $query_getUsers = "SELECT * FROM tbl_users";
  $execQuery_getUsers = $sql->query($query_getUsers);
  $query_returnedRows = $execQuery_getUsers->num_rows;
  $db_hasData = ($query_returnedRows !== 0);

  // Trying to do in_array() if the array is empty causes some errors.
  // Also makes sure that the following while loop doesn't fail.
  if (!$db_hasData) {
    $_SESSION["handler-alert"] = "The database has no registered users.";
    $_SESSION["handler-alert-type"] = "Error";
    header("location: login.php");
    exit();
  }

  while ($row = $execQuery_getUsers->fetch_assoc()) {
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

  // Get User password.
  $username = $vld->getFormVar("username");
  $userDataArray = $sql->query("SELECT * FROM tbl_users WHERE username = '$username'")->fetch_assoc();
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
