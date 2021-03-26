<?php
//Connection to database
  include_once("inc/database.php");
  //This is a prevention of thingy
  if (isset($_SESSION["account_type"]) || !isset($_POST["loginForm"])) 
  {
    header("location: ../");
    exit();
  }
  $processMake = false;

  //Cleaning the data
  $listEmptyVars = [];
  foreach ($_POST as $key => $value) 
  {
    $_POST[$key] = trim($value);
    $listEmptyVars[$key] = empty($_POST[$key]);
  }

  if (in_array(true, $listEmptyVars, true)) 
  {
    $errorString = "ERROR: EMPTY VALUES FOUND\\nThe following fields were found empty:\\n";
    foreach ($listEmptyVars as $key => $value) 
    {
      if($value)
      {
        $errorString .= "\\n".ucfirst($key);
      }
    }
    $errorString .= "\\n\\nLogin Failed";

    if($processMake)
    {
      echo "<br><br>Error String:<br>".$errorString;
    }
    else
    {
      $_SESSION["alert_err"] = $errorString;
      header("location: login.php");
      exit();
    }
  }

  else
  {
    $existingUsernames = [];
    if($result = $sql->query("SELECT * FROM tbl_users"))
    {
      while($row = $result->fetch_assoc())
      {
        $existingUsernames[] = $row["username"];
      }
    }

    if(!in_array($_POST["username"], $existingUsernames))
    {
      $errorString = "ERROR: This username is not registered or wrong password.\\n\\nLogin Failed.";
      if($processMake)
      {
        echo "<br>Phase 2 Error Notice:<br>".$errorString;
      }
      else
      {
        $_SESSION["alert_err"] = $errorString;
        header("location: login.php");
        exit();
      }
    }
    else
    {
      extract($_POST, EXTR_PREFIX_ALL, "form");
      if($result = $sql->query("SELECT * FROM tbl_users WHERE username = '$form_username'"))
      {
        while($row = $result->fetch_assoc())
        {
          if(password_verify($form_password, $row["password"]))
          {
            $userType = ($row["account_type"] == 1) ? "admin":"user";
            $_SESSION["account_type"] = $userType;
            $_SESSION["user_name"] = $form_username;
            $_SESSION["user_id"] = $row["id"];

            if($processMake){
              echo "<br>Phase 3: Password Check, process results<br>";
              echo "Passwords match, should be redirecting to index.php<br>";
              echo "<br>SESSION var 'account_type':".$_SESSION["account_type"];
              echo "<br>SESSION var 'user_name':".$_SESSION["user_name"];
              echo "<br>SESSION var 'user_id':".$_SESSION["user_id"];
          }
            else
            {
              header("location: index.php");
              exit();
            }

          }

          else
          {
            $errorString = "ERROR: Passwords do not match.\\n\\nLogin Failed.";

            if($processMake)
            {
              echo "<br>Phase 3: Password Check, process results<br>";
              echo "<br>".$errorString;
            }
            else
            {
              $_SESSION["alert_err"] = $errorString;
              header("location: login.php");
              exit();
            }
          }
        }
      }
    }
  }
?>


//This is based on finals .w.