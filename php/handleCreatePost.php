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

      header("location: ../");
      exit();
	} else {
		header("Location: createPost.php");
      	exit();
	}

 ?>