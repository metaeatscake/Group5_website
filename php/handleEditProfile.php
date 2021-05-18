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
  $upload_template = $tmp_id."_profile_pic";
  $upload_folder = "images/users/";
  $upload_fileType = pathinfo($_FILES["profile_picture"]["name"])["extension"];
  $upload_fileName = $upload_template.".".$upload_fileType;
  $upload_destination = $upload_folder.$upload_fileName;

  $row = $sql->query("SELECT * FROM tbl_users WHERE (email = '".$email."' OR username = '".$username."') AND user_id != '".$id."'")->fetch_assoc();     
  //to check if there's a duplicate
  //i'll leave the classes empty
  if($row != NULL) {
    echo "<h3 style='text-align: center;'><br>Duplicate Record! This user already exist. </h3>";
    echo "<br><br>";
    echo "<center><a href='profile.php' class='' style='text-align: center;'>Go back</a></center>"; exit;
  } else {
    $data = $sql->query("UPDATE tbl_users SET username = '$username', sex = '$sex', email = '$email' WHERE user_id = '$id'");
    header("location: profile.php");
  exit();
  }

  if($row != NULL) {
    echo "<h3 style='text-align: center;'><br>Duplicate Record! This user already exist. </h3>";
    echo "<br><br>";
    echo "<center><a href='profile.php' class='' style='text-align: center;'>Go back</a></center>"; exit;
  } else {
    $data = $sql->query("UPDATE tbl_users SET bio = '$bio' WHERE user_id = '$id'");
    header("location: profile.php");
  exit();
  }

  //----------------------
  

  ?>