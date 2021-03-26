<!DOCTYPE html>
<html>
<head>
	<title>Sociality | Create Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Sociality</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="mdl/material.min.css">
     <!-- Import Material Design Lite Javascript -->
     <script src="mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="php/images/assets/socialityLogo_transparent.png">

     <!-- Custom CSS File -->
     <link rel="stylesheet" href="css/socialityOverrides.css">

        <style>
	      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
	        .demo-layout-transparent {	         
	          background: #ad5389;  /* fallback for old browsers */
	          background: -webkit-linear-gradient(to right, #3c1053, #ad5389);  /* Chrome 10-25, Safari 5.1-6 */
	          background: linear-gradient(to right, #3c1053, #ad5389); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	        }
	        .demo-layout-transparent .mdl-layout__header,
	        .demo-layout-transparent .mdl-layout__drawer-button {
	          /* This background is dark, so we set text to white. Use 87% black instead if
	             your background is light. */
	          color: #cca8e6;
	        }
        </style>
</head>
<body>
	<?php 
		include_once("inc/database.php");
 		include_once("inc/navbar.php");
		$inputTitle = $_POST["inputTitle"];
 		$inputText = $_POST["inputText"];
 		$inputPic = $_POST["inputPic"];
 		$post = $_POST["btnSubmit"];

		$data = $sql->query("SELECT * FROM tbl_users WHERE user_id = '{$_SESSION["account_id"]}'");
		$row = $data->fetch_assoc();
		$user_id = $row["user_id"];

 		if($post){
 			$insertQuery = $sql->query("INSERT INTO tbl_feed(user_id, post_title, post_content) VALUES('".$user_id."', '".addslashes($inputTitle)."', '".$inputText."')");
 			
 			header("Location: ../");
 		} else {
 			header("Location: createPost.php");
 		}

	 ?>
</body>
</html>
