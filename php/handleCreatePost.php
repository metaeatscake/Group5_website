<?php
	include_once("inc/database.php");

	//Prevent illegal access
	if (!isset($_SESSION["account_type"]) || $_SESSION["account_type"] === "admin") {
		header("location: ../");
		exit();
	}

	//Sanitize/Clean data.
	//Check for EMPTY data first
	foreach ($_POST as $key => $value) {

		// Add an additional function (filter_var()) to handle data cleaning.
		$_POST[$key] = filter_var(trim($value), FILTER_SANITIZE_STRING);
		$emptyVars[$key] = empty($_POST[$key]);
	}

	// FALSE if the data is not empty.
	$validForm = !in_array(true, $emptyVars);

	/*
		There are two ways that the form can be considered valid:
			- Data is not empty, AND there IS an attached IMAGE
			- Data is not empty, AND there IS NO attached IMAGE
		We will first check if there is a file uploaded before
		the next verification starts.
	*/

	// Condition if there is NO FILE.
	if ($_FILES["inputPic"]["error"] === 4) {

		// No empty data.
		if ($validForm) {

			$queryString = "INSERT INTO tbl_feed(
				user_id, post_title, post_content
			) VALUES (
				'{$_SESSION["account_id"]}', '{$_POST["inputTitle"]}', '{$_POST["inputText"]}'
			)";

			$sql->query($queryString);
			header("location: ../");
			exit();
		}

		// Empty data.
		else{

			$errorMessage = "ERROR: The following fields were empty: ";
			foreach ($emptyVars as $key => $value) {
				if ($value) {

				}
			}
		}

	}

	// Condition if there IS a file.
	else{

	}



 ?>
