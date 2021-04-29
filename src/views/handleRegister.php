<?php

  //Get SESSION and DB, and the OOP classes
  include_once("inc/database.php");
  include_once("oop/_main.php");

  //Toggle Debug mode on/off for testing.
  //Debug mode disables redirects and any database transaction.
  $dev_debugMode = false;

  //Redirect unwanted access.
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: ../");
    exit();
  }

  // PDO-based Querying
  $pdoq_getUserData = $pdo->query("SELECT * FROM tbl_users")->fetchAll();
  echo "<h2> PDO User Data </h2>";
  echo "<pre>"; var_dump($pdoq_getUserData); echo "</pre>";

  // Declare validation object
  $vld = new Validate($_POST);

  // Do the magic data cleaning.
  $vld->cleanData();

  // Handle the empty data.
  $errMsg = $vld->getValidationMessage();
  echo $errMsg;
  if (!empty($errMsg) && !$dev_debugMode) {
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
  if ($pdoq_getUserData) {

    foreach ($pdoq_getUserData as $row) {
      $arr_Usernames[] = $row["username"];
      $arr_Emails[] = $row["email"];
    }
    echo "<h2> Usernames Array </h2>";
    echo "<pre>";var_dump($arr_Usernames); echo "</pre>";
    echo "<h2> Emails Array </h2>";
    echo "<pre>";var_dump($arr_Emails);echo "</pre>";

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
  if (!empty($errMsg1) && !$dev_debugMode) {
    $_SESSION["handler-alert"] = $errMsg1;
    $_SESSION["handler-alert-type"] = "Error";
    header("location: register.php");
    exit();
  }

  extract($vld->getCleanedData(), EXTR_PREFIX_ALL, "data");
  echo "<h2> Validation Class Data </h2>";
  echo "<pre>"; print_r($vld->getCleanedData()); echo "</pre>";
  //echo "<pre>"; var_dump(get_defined_vars()); echo "</pre>";

  $data_password = password_hash($data_password, PASSWORD_DEFAULT);

  $data_defaultBio = "New user";

  if (!$dev_debugMode) {

    $pdoq_insertData = $pdo->prepare("
      INSERT INTO tbl_users(username, password, email, sex, bio)
      VALUES (:username, :password, :email, :sex, :bio)
    ")->execute([
      'username' => $data_username,
      'password' => $data_password,
      'email' => $data_email,
      'sex' => $data_sex,
      'bio' => $data_defaultBio
    ]);
    $_SESSION["handler-alert"] = "Registration Success!\nYou may now log in.";
    $_SESSION["handler-alert-type"] = "Success";
    header("location: login.php");
    exit();
  }


 ?>
