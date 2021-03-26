<?php

  // Connect to Database
    include_once("inc/database.php");

  // Prevent Illegal Access
    if(isset($_SESSION["account_type"]) || empty($_POST)){
      header("location: ../");
      exit();
    }

  // Clean Data
    foreach ($_POST as $key => $value) {
      $_POST[$key] = trim($value);
      $emptyVar[] = empty($_POST[$key]);
    }

  // Get all available usernames
    $data = $sql->query("SELECT * FROM tbl_users");
    while($row = $data->fetch_assoc()){
      $usernames[] = $row["username"];
    }

  // Control handler behavior
  // if Debugging, set this to FALSE;
    $redirect = true;

  // Redirect when Empty variables are detected.
    if(in_array(true, $emptyVar)){
      $errorMessage = "ERROR: The following fields were found empty: \\n";
      foreach ($emptyVar as $key => $value) {
        if ($value) {
          $errorMessage .= "\\n".ucfirst($key);
        }
      }
      $errorMessage = "\\n\\nLogin Failed.";

      $_SESSION["handler-alert"] = $errorMessage;
      if ($redirect) {
        header("location: login.php");
        exit();
      }else{
        echo $errorMessage;
      }

    }

  // Vars are not empty, proceed.
    else{
      /*
        Validations:
          User exists
          The password match.
      */

      // USER EXISTS
      if(in_array($_POST["username"], $usernames)){

        // Get the password
        $data = $sql->query("SELECT * FROM tbl_users WHERE username = '{$_POST["username"]}'");
        $row = $data->fetch_assoc();

        // CHECK IF PASSWORD MATCH.
        if(password_verify($_POST["password"], $row["password"])){
          $_SESSION["account_id"] = $row["id"];
          $_SESSION["account_type"] = $row["account_type"];
          $_SESSION["username"] = $row["username"];

          header("location: ../");
          exit();
        }

        // Password does not match.
        else{
          $errorMessage = "ERROR: Wrong password";
          $_SESSION["handler-alert"] = $errorMessage;

          if($redirect){
            header("location: login.php");
            exit();
          }
          else{
            echo $errorMessage;
          }

        }

      }

      // USER DOES NOT EXIST
      else{
        $errorMessage = "ERROR: This user is not registered.";
        $_SESSION["handler-alert"] = $errorMessage;

        if ($redirect) {
          header("location: login.php");
          exit();
        }else{
          echo $errorMessage;
        }

      }

    }

?>
