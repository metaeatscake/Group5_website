<?php
//Connection to database
  include_once("inc/database.php");

// Prevent Illegal Access
  if(isset($_SESSION["account_type"]) || empty($_POST)){
    header("location: ../");
  }

// Data Cleaning

  foreach ($_POST as $key => $value) {
    $_POST[$key] = trim($value);
    $emptyVars[$key] = empty($_POST[$key]);
  }

// Data Cleaning, now with redirects.

  //When debugging, set $redirect to false
  $redirect = true;

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
  else{

  }

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

  </body>
</html>
