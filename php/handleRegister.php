<?php
//Connection to database
  include_once("inc/database.php");

// Prevent Illegal Access
  if(isset($_SESSION["account_type"]) || empty($_POST)){
    header("location: ../");
  }

// Get all available usernames and emails
  $data = $sql->query("SELECT * FROM tbl_users");
  while($row = $data->fetch_assoc()){
    $usernames[] = $row["username"];
    $emails[] = $row["email"];
  }

// Data Cleaning

  foreach ($_POST as $key => $value) {
    $_POST[$key] = trim($value);
    $emptyVars[$key] = empty($_POST[$key]);
  }

// Data Cleaning, now with redirects.

  //When debugging, set $redirect to false
  $redirect = false;

  if (in_array(true, $emptyVars)) {
    $errorMessage = "ERROR: The following fields were empty: \\n";
    foreach ($emptyVars as $key => $value) {
      if ($value) {
        $errorMessage .= "\\n".ucfirst($key);
      }
    }
    $errorMessage .= "\\n\\nRegistration Failed.";

    // I can't believe ternary operations work by itself.
    $_SESSION["handler-alert"] = $errorMessage;
    ($redirect) ? header("location: register.php") : print_r(nl2br($errorMessage));
  }

  //Data is not empty, proceed.

    /*
      Verification

      Password and confirm password must match
      Password length >= 8 characters
      Unique username
      Unique password
    */

    // TRUE if passwords DO NOT match
    $validationChecks["passwords_given_do_not_match"] = (strcmp($_POST["password"], $_POST["password-confirm"]) !== 0);

    // TRUE if passwords
    $validationChecks["password_less_than_8_characters"] = (strlen($_POST["password"]) < 8);

    // TRUE if username IS already registered
    $validationChecks["username_already_registered"] = (in_array($_POST["username"], $usernames));

    // TRUE if email IS already registered
    $validationChecks["email_already_registered"] = (in_array($_POST["email"], $emails));

    // Final Redirects for errors
    if(in_array(true, $validationChecks)){
      $errorMessage = "ERROR: \\n";
      foreach ($validationChecks as $key => $value) {
        if($value){
          $errorMessage .= "\\n".str_replace("_", " ", ucfirst($key));
        }
      }
      $errorMessage .= "\\nRegistration Failed.";

      $_SESSION["handler-alert"] = $errorMessage;
      ($redirect) ? header("location: register.php") : print_r(nl2br($errorMessage));
    }

    // Data has passed validations.
    $password_encrypted = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $query = "INSERT INTO tbl_users(
      username,
      password,
      email,
      sex
    ) VALUES (
      '{$_POST["username"]}',
      '{$password_encrypted}',
      '{$_POST["email"]}',
      '{$_POST["sex"]}'
    )";



 ?>

<!-- This stuff is for debugging. -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>devthing</title>
  </head>
  <body>

    <h1> $_SERVER Request Method</h1>
    <h4><?php echo $_SERVER["REQUEST_METHOD"]; ?></h4>

    <h1> $_POST Data </h1>
    <h4><pre>
       <?php print_r($_POST); ?>
    </pre></h4>

    <h1> $emptyVars Data </h1>
    <h4><pre>
       <?php print_r($emptyVars); ?>
    </pre></h4>

    <h1> $usernames, $emails Data </h1>
    <h4><pre>
       <?php print_r($usernames); ?>
    </pre></h4>
    <h4><pre>
       <?php print_r($emails); ?>
    </pre></h4>

    <h1> $validationChecks Data </h1>
    <h4><pre>
       <?php @print_r($validationChecks); ?>
    </pre></h4>

    <h1> SQL Query </h1>
    <h4><pre>
       <?php print_r($query); ?>
    </pre></h4>

  </body>
</html>
