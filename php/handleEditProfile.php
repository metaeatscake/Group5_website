<?php
  //Get database and session.
  include_once("inc/database.php");

  //Redirect Admins
  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: adm_viewUsers.php");
    exit();
  }
  //if (!isset($_SESSION["account_type"]))
 ?>
<?php 
  $id = $_SESSION["account_id"];
  
  $username = $_POST["username"];
  $bio = $_POST["bio"];
  $sex = $_POST["sex"];
  $email = $_POST["email"];

  $row = $sql->query("SELECT * FROM tbl_users WHERE email = '".$email."' AND user_id != '".$id."'")->fetch_assoc();     

  //to check if there's a duplicate
  //i'll leave the classes empty
  if($row != NULL) {
    echo "<h3 style='text-align: center;'><br>Duplicate Record! This user already exist. </h3>";
    echo "<br><br>";
    echo "<center><a href='profile.php' class='' style='text-align: center;'>Go back</a></center>"; exit;
  } else {
    $data = $sql->query("UPDATE tbl_users SET username = '$username', bio = '$bio', sex = '$sex', email = '$email' WHERE user_id = '$id'");
    header("location: profile.php");
  exit();
  }
  ?>