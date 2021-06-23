<?php

  //PDO instance is already in `addProcedures.php`

  //Drop Functions if they exist.
  $pdo->exec("DROP FUNCTION IF EXISTS `verify_user_id_exists`");

  //Add functions.
  /*
    FUNC: VERIFY IF USER EXISTS
      IN: user id to be tested
      OUT: 0 (false) OR 1 (true) 
  */
  $pdo->exec("
  CREATE DEFINER=`root`@`localhost` FUNCTION `verify_user_id_exists`(prm_id INTEGER
  ) RETURNS int(11)
  BEGIN

  	DECLARE intbool INTEGER DEFAULT 0;
    DECLARE queryoutput INTEGER;

    SELECT count(user_id) INTO queryoutput
  		FROM tbl_users
      WHERE user_id = prm_id;

  	IF	(queryoutput = 1) THEN
  		SET intbool = 1;
  	END IF;

  RETURN intbool;
  END");

 ?>
