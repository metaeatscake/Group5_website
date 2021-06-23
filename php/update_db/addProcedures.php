<?php

  include_once("_newPDO.php");

  //Functions.
  include_once("addFunctions.php");

  //This file is for updating stored procedures in the databases of
  //the development team.

  // Remove any existing implementations of these procedures.
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_comment`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_like`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_post_img`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_post_text`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_user`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `delete_comment`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `delete_like`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `edit_comment`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `edit_user_pictures`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `edit_user_bio`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `edit_user_account`");

  // Write their definitions here.

  /*
    ADD COMMENT
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `add_comment`(
      IN p_user_id INT(11),
      IN p_post_id INT(11),
      IN p_comment TEXT
    )
    BEGIN
      INSERT INTO tbl_comments(user_id, post_id, comment_content)
        VALUES(p_user_id, p_post_id, p_comment);
    END");

  /*
    ADD LIKE
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `add_like`(
    	IN prm_post_id INT(11),
      IN prm_user_id INT(11)
    )
    BEGIN
    	INSERT INTO tbl_feed_likes(post_id, user_id)
    		VALUES(prm_post_id, prm_user_id);
    END");

  /*
    ADD POST IMG
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `add_post_img`(
      IN prm_user_id INT(11),
      IN prm_title VARCHAR(255),
      IN prm_content TEXT,
      IN prm_img VARCHAR(255)
    )
    BEGIN
      INSERT INTO tbl_feed(user_id, post_title, post_content, post_img)
        VALUES(prm_user_id, prm_title, prm_content, prm_img);
    END");

  /*
    ADD POST TEXT
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `add_post_text`(
      IN p_user_id INT(11),
      IN p_title VARCHAR(255),
      IN p_content TEXT
    )
    BEGIN
      INSERT INTO tbl_feed(user_id, post_title, post_content)
        VALUES(p_user_id, p_title, p_content);
    END");

  /*
    ADD USER
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user`(
    	IN prm_username VARCHAR(255),
        IN prm_password_enc VARCHAR(255),
        IN prm_email VARCHAR(255),
        IN prm_sex VARCHAR(255),
        IN prm_bio TEXT
    )
    BEGIN
    	INSERT INTO tbl_users(
    		username,
            password,
            email,
            sex,
            bio
    	)	VALUES	(
    		prm_username,
            prm_password_enc,
            prm_email,
            prm_sex,
            prm_bio
    	);
    END");

  /*
    DELETE LIKE
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_like`(
      IN p_post_id INT(11),
      IN p_user_id INT(11)
    )
    BEGIN
      DELETE FROM tbl_feed_likes
        WHERE post_id = p_post_id
        AND user_id = p_user_id;
    END");

  /*
    EDIT USER PICTURES
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user_pictures`(
      IN prm_user_id INT(11),
      IN prm_prof_pic VARCHAR(255),
      IN prm_cover_photo VARCHAR(255)
    )
    BEGIN

      DECLARE plc_prof_pic VARCHAR(255);
      DECLARE plc_cover_photo VARCHAR(255);

      SELECT profile_pic, cover_photo
      INTO plc_prof_pic, plc_cover_photo
          FROM tbl_users
          WHERE user_id = prm_user_id;

      IF prm_prof_pic <> plc_prof_pic AND prm_prof_pic <> '' THEN
        UPDATE tbl_users SET profile_pic = prm_prof_pic WHERE user_id = prm_user_id;
      END IF;

      IF prm_cover_photo <> plc_cover_photo AND prm_cover_photo <> '' THEN
        UPDATE tbl_users SET cover_photo = prm_cover_photo WHERE user_id = prm_user_id;
      END IF;
    END");

  /*
    EDIT USER BIO
  */
  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user_bio`(
    	  IN prm_user_id INT(11),
        IN prm_bio TEXT
    )
    BEGIN

    	 DECLARE plc_bio TEXT;
       SELECT bio INTO plc_bio FROM tbl_users WHERE user_id = prm_user_id;

       IF prm_bio <> plc_bio AND prm_bio <> '' THEN
    	   UPDATE tbl_users
    			  SET bio = prm_bio
    			  WHERE user_id = prm_user_id;
    	 END IF;
    END");

  /*
    EDIT USER ACCOUNT
  */
  $pdo->exec("
  CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user_account`(
	   IN `prm_user_id` INT(11),
     IN `prm_username` VARCHAR(255),
     IN `prm_password` VARCHAR(255),
     IN `prm_email` VARCHAR(255),
     IN `prm_sex` VARCHAR(255)
    )
  BEGIN

        DECLARE vrf_username INT;
        DECLARE vrf_email INT;

		    SELECT count(username) INTO vrf_username FROM tbl_users WHERE username = prm_username;
		    SELECT count(email) INTO vrf_email FROM tbl_users WHERE email = prm_email;

      	IF prm_username <> '' AND vrf_username < 1 THEN
      		UPDATE tbl_users SET username = prm_username WHERE user_id = prm_user_id;
      	END IF;

        IF prm_password <> '' THEN
      		UPDATE tbl_users SET password = prm_password WHERE user_id = prm_user_id;
      	END IF;

      	IF prm_email <> '' AND vrf_email < 1 THEN
      		UPDATE tbl_users SET email = prm_email WHERE user_id = prm_user_id;
      	END IF;

        IF prm_sex <> '' THEN
      		UPDATE tbl_users SET sex = prm_sex WHERE user_id = prm_user_id;
      	END IF;
    END");

    /*
      EDIT POST COMMENT
    */
    $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_comment`(
    	IN `prm_comment_id` INT(11),
    	IN `prm_new_comment` text
    )
    BEGIN
    	IF prm_new_comment <> NULL AND prm_new_comment <> '' THEN
    		UPDATE tbl_comments
    			SET comment_content = prm_new_comment
                WHERE comment_id = prm_comment_id;
        END IF;
    END");

    /*
      DELETE POST COMMENT
    */
    $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_comment`(
  	   IN `prm_comment_id` INT(11)
    )
    BEGIN
    	DELETE FROM tbl_comments
    		WHERE comment_id = prm_comment_id;
    END");

  //When finished, go back to index.
  header("location: ../../index_dev.html");
  exit();

 ?>
