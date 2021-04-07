<?php

	// Get database and classes.
	include_once("inc/database.php");
	include_once("oop/_main.php");

	// Should handle cases where this file is accessed unintentionally.
	if ($_SERVER["REQUEST_METHOD"] !== "POST") {
		header("location: ../");
		exit();
	}

	$validImages = [
		"image/png",
		"image/gif",
		"image/jpeg"
	];

	// Declare objects.
	$vld = new Validate($_POST);
	$vld_i = new Validate_Image($_FILES,"inputPic",$validImages);

	// Variable to hold account ID
	$q_id = $_SESSION["account_id"];

	// Run validation and sanitize the form data.
	$vld->cleanData();

	// Check if title/content is empty
	$alertMessage = $vld->getValidationMessage();
	if (!empty($alertMessage)) {
		$_SESSION["handler-alert"] = $alertMessage;
		header("location: createPost.php");
		exit();
	}

	// Assign title/content data to variables.
	$q_title = $vld->getFormVar("inputTitle");
	$q_content = $vld->getFormVar("inputText");

	// Validate image, if it is there.
	if ($vld->hasFile()) {

		// Redirect if there is error.
		$alertMessage = $vld_i->getValidationMessage();
		if (!empty($alertMessage)) {
			$_SESSION["handler-alert"] = $alertMessage;
			header("location: createPost.php");
			exit();
		}

		// Continue if it is valid image.
		/*
			Image Filename Documentation.
				To make sure that the filename is unique, the image name
				will be determined by the poster's user id and the post time.
				The time will be taken from the SQL server and formatted.

				Filename: $id_$postingTime.$ext
				Directory: images/post_img/
		*/
		$timeFormat = "%Y-%m-%d_%H-%i-%s";
		$time = $sql->query("SELECT DATE_FORMAT(SYSDATE(), '$timeFormat') AS time_now;")->fetch_assoc()["time_now"];

		$newfileName = $_SESSION["account_id"] . "_" . $time . {$vld_i->getFileExtension()};
		$saveFolder = "images/post_img/";

		$savePath = $saveFolder.$newFileName;

		move_uploaded_file($_FILES["inputPic"]["tmp_name"], $savePath);

		$queryString = "INSERT INTO tbl_feed(
			user_id, post_title, post_content, post_img
		)VALUES( '$q_id', '$q_title', '$q_content', '$savePath')";

		$sql->query($queryString);
		header("location: ../");
		exit();
	}

	// Handle text-only posts.
	else{
		$queryString = "INSERT INTO tbl_feed(user_id, post_title, post_content)
		VALUES('$q_id', '$q_title', '$q_content')";
		
		$sql->query($queryString);
		header("location: ../");
		exit();
	}

	//

	// Testing. Seems to work.
	$vld->debugData();
	$vld_i->debugData();

 ?>
