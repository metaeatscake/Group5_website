<?php

  include_once("_newPDO.php");

  //This file is for updating stored procedures in the databases of
  //the development team.

  // Remove any existing implementations of these procedures.
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_comment`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_like`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_post_img`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_post_text`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `add_user`");
  $pdo->exec("DROP PROCEDURE IF EXISTS `delete_like`");


  // Write their definitions here.
  $pdo->exec("CREATE DEFINER=`root`@`localhost` PROCEDURE `add_comment`(
    IN p_user_id INT(11),
      IN p_post_id INT(11),
      IN p_comment TEXT
    )
    BEGIN
    INSERT INTO tbl_comments(user_id, post_id, comment_content)
      VALUES(p_user_id, p_post_id, p_comment);
    END");

  $pdo->exec("CREATE DEFINER=`root`@`localhost` PROCEDURE `add_like`(
    	IN prm_post_id INT(11),
      IN prm_user_id INT(11)
    )
    BEGIN
    	INSERT INTO tbl_feed_likes(post_id, user_id)
    		VALUES(prm_post_id, prm_user_id);
    END");

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
    END
  ");

  $pdo->exec("
    CREATE DEFINER=`root`@`localhost` PROCEDURE `add_post_text`(
      IN p_user_id INT(11),
      IN p_title VARCHAR(255),
      IN p_content TEXT
    )
    BEGIN
    INSERT INTO tbl_feed(user_id, post_title, post_content)
      VALUES(p_user_id, p_title, p_content);
    END
  ");

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
  END
  ");

  $pdo->exec("
  CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_like`(
    IN p_post_id INT(11),
    IN p_user_id INT(11)
  )
  BEGIN
  DELETE FROM tbl_feed_likes
    WHERE post_id = p_post_id
    AND user_id = p_user_id;
  END
  ");

  header("location: ../../");
  exit();

 ?>
