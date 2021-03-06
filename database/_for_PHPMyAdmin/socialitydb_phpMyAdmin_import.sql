-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2021 at 12:56 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialitydb`
--
CREATE DATABASE IF NOT EXISTS `socialitydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `socialitydb`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `add_comment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_comment` (IN `p_user_id` INT(11), IN `p_post_id` INT(11), IN `p_comment` TEXT)  BEGIN
      INSERT INTO tbl_comments(user_id, post_id, comment_content)
        VALUES(p_user_id, p_post_id, p_comment);
    END$$

DROP PROCEDURE IF EXISTS `add_like`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_like` (IN `prm_post_id` INT(11), IN `prm_user_id` INT(11))  BEGIN
    	INSERT INTO tbl_feed_likes(post_id, user_id)
    		VALUES(prm_post_id, prm_user_id);
    END$$

DROP PROCEDURE IF EXISTS `add_post_img`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_post_img` (IN `prm_user_id` INT(11), IN `prm_title` VARCHAR(255), IN `prm_content` TEXT, IN `prm_img` VARCHAR(255))  BEGIN
      INSERT INTO tbl_feed(user_id, post_title, post_content, post_img)
        VALUES(prm_user_id, prm_title, prm_content, prm_img);
    END$$

DROP PROCEDURE IF EXISTS `add_post_text`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_post_text` (IN `p_user_id` INT(11), IN `p_title` VARCHAR(255), IN `p_content` TEXT)  BEGIN
      INSERT INTO tbl_feed(user_id, post_title, post_content)
        VALUES(p_user_id, p_title, p_content);
    END$$

DROP PROCEDURE IF EXISTS `add_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user` (IN `prm_username` VARCHAR(255), IN `prm_password_enc` VARCHAR(255), IN `prm_email` VARCHAR(255), IN `prm_sex` VARCHAR(255), IN `prm_bio` TEXT)  BEGIN
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
    END$$

DROP PROCEDURE IF EXISTS `delete_comment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_comment` (IN `prm_comment_id` INT(11))  BEGIN
    	DELETE FROM tbl_comments
    		WHERE comment_id = prm_comment_id;
    END$$

DROP PROCEDURE IF EXISTS `delete_like`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_like` (IN `p_post_id` INT(11), IN `p_user_id` INT(11))  BEGIN
      DELETE FROM tbl_feed_likes
        WHERE post_id = p_post_id
        AND user_id = p_user_id;
    END$$

DROP PROCEDURE IF EXISTS `delete_post`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_post` (IN `p_post_id` INT(11), IN `p_user_id` INT(11))  BEGIN

	IF p_post_id <> '' AND p_user_id <> '' THEN
		DELETE FROM tbl_feed 
			WHERE post_id = p_post_id
            AND user_id = p_user_id;
    END IF;

END$$

DROP PROCEDURE IF EXISTS `edit_comment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_comment` (IN `prm_comment_id` INT(11), IN `prm_new_comment` TEXT)  BEGIN
    	IF prm_new_comment <> NULL AND prm_new_comment <> '' THEN
    		UPDATE tbl_comments
    			SET comment_content = prm_new_comment
                WHERE comment_id = prm_comment_id;
        END IF;
    END$$

DROP PROCEDURE IF EXISTS `edit_post`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_post` (IN `p_post_id` INT(11), IN `p_new_title` VARCHAR(255), IN `p_new_content` TEXT, IN `p_new_img` VARCHAR(255))  BEGIN

	IF p_new_title <> '' THEN
		UPDATE tbl_feed 
			SET post_title = p_new_title
            WHERE post_id = p_post_id;
	END IF;
    
    IF p_new_content <> '' THEN
		UPDATE tbl_feed
			SET post_content = p_new_content
            WHERE post_id = p_post_id;
	END IF;
    
    IF p_new_img = '' THEN
		UPDATE tbl_feed 
			SET post_img = null
            WHERE post_id = p_post_id;
	ELSE 
		UPDATE tbl_feed
			SET post_img = p_new_img
            WHERE post_id = p_post_id;
	END IF;
END$$

DROP PROCEDURE IF EXISTS `edit_user_account`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user_account` (IN `prm_user_id` INT(11), IN `prm_username` VARCHAR(255), IN `prm_password` VARCHAR(255), IN `prm_email` VARCHAR(255), IN `prm_sex` VARCHAR(255))  BEGIN

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
    END$$

DROP PROCEDURE IF EXISTS `edit_user_bio`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user_bio` (IN `prm_user_id` INT(11), IN `prm_bio` TEXT)  BEGIN

    	 DECLARE plc_bio TEXT;
       SELECT bio INTO plc_bio FROM tbl_users WHERE user_id = prm_user_id;

       IF prm_bio <> plc_bio AND prm_bio <> '' THEN
    	   UPDATE tbl_users
    			  SET bio = prm_bio
    			  WHERE user_id = prm_user_id;
    	 END IF;
    END$$

DROP PROCEDURE IF EXISTS `edit_user_pictures`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user_pictures` (IN `prm_user_id` INT(11), IN `prm_prof_pic` VARCHAR(255), IN `prm_cover_photo` VARCHAR(255))  BEGIN

      IF prm_prof_pic <> '' THEN
        UPDATE tbl_users SET profile_pic = prm_prof_pic WHERE user_id = prm_user_id;
      END IF;

      IF prm_cover_photo <> '' THEN
        UPDATE tbl_users SET cover_photo = prm_cover_photo WHERE user_id = prm_user_id;
      END IF;
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `verify_user_id_exists`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `verify_user_id_exists` (`prm_id` INTEGER) RETURNS INT(11) BEGIN

  	DECLARE intbool INTEGER DEFAULT 0;
    DECLARE queryoutput INTEGER;

    SELECT count(user_id) INTO queryoutput
  		FROM tbl_users
      WHERE user_id = prm_id;

  	IF	(queryoutput = 1) THEN
  		SET intbool = 1;
  	END IF;

  RETURN intbool;
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

DROP TABLE IF EXISTS `tbl_comments`;
CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed`
--

DROP TABLE IF EXISTS `tbl_feed`;
CREATE TABLE `tbl_feed` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_img` varchar(255) DEFAULT NULL,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed_likes`
--

DROP TABLE IF EXISTS `tbl_feed_likes`;
CREATE TABLE `tbl_feed_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `react_type` varchar(255) NOT NULL DEFAULT 'like',
  `like_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'images/users/_default.jpg',
  `cover_photo` varchar(255) NOT NULL DEFAULT 'images/users_cover/_default.png',
  `bio` text NOT NULL,
  `account_type` varchar(255) NOT NULL DEFAULT 'user',
  `register_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_comments`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_comments`;
CREATE TABLE `view_comments` (
`comment_id` int(11)
,`user_id` int(11)
,`username` varchar(255)
,`profile_pic` varchar(255)
,`post_id` int(11)
,`comment_content` text
,`comment_time` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_posts_full`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_posts_full`;
CREATE TABLE `view_posts_full` (
`post_id` int(11)
,`user_id` int(11)
,`username` varchar(255)
,`profile_pic` varchar(255)
,`post_title` varchar(255)
,`post_content` mediumtext
,`post_time` timestamp
,`post_img` varchar(255)
,`date_time` varchar(87)
,`count_comments` bigint(21)
,`count_likes` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user_stats`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_user_stats`;
CREATE TABLE `view_user_stats` (
`user_id` int(11)
,`username` varchar(255)
,`email` varchar(255)
,`profile_pic` varchar(255)
,`bio` mediumtext
,`cover_photo` varchar(255)
,`register_time` timestamp
,`count_comments` bigint(21)
,`count_post_likes` bigint(21)
,`count_posts` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_count_comments`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_count_comments`;
CREATE TABLE `v_count_comments` (
`post_id` int(11)
,`count_comments` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_count_likes`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_count_likes`;
CREATE TABLE `v_count_likes` (
`post_id` int(11)
,`count_likes` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_count_user_comments`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_count_user_comments`;
CREATE TABLE `v_count_user_comments` (
`user_id` int(11)
,`count_comments` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_count_user_postlikes`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_count_user_postlikes`;
CREATE TABLE `v_count_user_postlikes` (
`poster_id` int(11)
,`count_post_likes` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_count_user_posts`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_count_user_posts`;
CREATE TABLE `v_count_user_posts` (
`user_id` int(11)
,`count_posts` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `view_comments`
--
DROP TABLE IF EXISTS `view_comments`;

DROP VIEW IF EXISTS `view_comments`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_comments`  AS  select `c`.`comment_id` AS `comment_id`,`c`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`c`.`post_id` AS `post_id`,`c`.`comment_content` AS `comment_content`,`c`.`comment_time` AS `comment_time` from (`tbl_comments` `c` join `tbl_users` `u` on(`u`.`user_id` = `c`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_posts_full`
--
DROP TABLE IF EXISTS `view_posts_full`;

DROP VIEW IF EXISTS `view_posts_full`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_posts_full`  AS  select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_time` AS `post_time`,`f`.`post_img` AS `post_img`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,`v`.`count_comments` AS `count_comments`,`vl`.`count_likes` AS `count_likes` from (((`tbl_feed` `f` left join `v_count_comments` `v` on(`f`.`post_id` = `v`.`post_id`)) left join `v_count_likes` `vl` on(`vl`.`post_id` = `f`.`post_id`)) left join `tbl_users` `u` on(`f`.`user_id` = `u`.`user_id`)) where `f`.`post_id` is not null union select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_time` AS `post_time`,`f`.`post_img` AS `post_img`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,`v`.`count_comments` AS `count_comments`,`vl`.`count_likes` AS `count_likes` from (`tbl_users` `u` left join (`v_count_likes` `vl` left join (`v_count_comments` `v` left join `tbl_feed` `f` on(`f`.`post_id` = `v`.`post_id`)) on(`vl`.`post_id` = `f`.`post_id`)) on(`f`.`user_id` = `u`.`user_id`)) where `f`.`post_id` is not null ;

-- --------------------------------------------------------

--
-- Structure for view `view_user_stats`
--
DROP TABLE IF EXISTS `view_user_stats`;

DROP VIEW IF EXISTS `view_user_stats`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_stats`  AS  select `u`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`profile_pic` AS `profile_pic`,`u`.`bio` AS `bio`,`u`.`cover_photo` AS `cover_photo`,`u`.`register_time` AS `register_time`,`vcuc`.`count_comments` AS `count_comments`,`vcupl`.`count_post_likes` AS `count_post_likes`,`vcup`.`count_posts` AS `count_posts` from (((`tbl_users` `u` left join `v_count_user_comments` `vcuc` on(`u`.`user_id` = `vcuc`.`user_id`)) left join `v_count_user_postlikes` `vcupl` on(`u`.`user_id` = `vcupl`.`poster_id`)) left join `v_count_user_posts` `vcup` on(`u`.`user_id` = `vcup`.`user_id`)) where `u`.`user_id` is not null union select `u`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`profile_pic` AS `profile_pic`,`u`.`bio` AS `bio`,`u`.`cover_photo` AS `cover_photo`,`u`.`register_time` AS `register_time`,`vcuc`.`count_comments` AS `count_comments`,`vcupl`.`count_post_likes` AS `count_post_likes`,`vcup`.`count_posts` AS `count_posts` from (`v_count_user_posts` `vcup` left join (`v_count_user_postlikes` `vcupl` left join (`v_count_user_comments` `vcuc` left join `tbl_users` `u` on(`u`.`user_id` = `vcuc`.`user_id`)) on(`u`.`user_id` = `vcupl`.`poster_id`)) on(`u`.`user_id` = `vcup`.`user_id`)) where `u`.`user_id` is not null ;

-- --------------------------------------------------------

--
-- Structure for view `v_count_comments`
--
DROP TABLE IF EXISTS `v_count_comments`;

DROP VIEW IF EXISTS `v_count_comments`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_count_comments`  AS  select `tbl_comments`.`post_id` AS `post_id`,count(`tbl_comments`.`comment_id`) AS `count_comments` from `tbl_comments` group by `tbl_comments`.`post_id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_count_likes`
--
DROP TABLE IF EXISTS `v_count_likes`;

DROP VIEW IF EXISTS `v_count_likes`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_count_likes`  AS  select `tbl_feed_likes`.`post_id` AS `post_id`,count(`tbl_feed_likes`.`like_id`) AS `count_likes` from `tbl_feed_likes` group by `tbl_feed_likes`.`post_id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_count_user_comments`
--
DROP TABLE IF EXISTS `v_count_user_comments`;

DROP VIEW IF EXISTS `v_count_user_comments`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_count_user_comments`  AS  select `tbl_comments`.`user_id` AS `user_id`,count(0) AS `count_comments` from `tbl_comments` group by `tbl_comments`.`user_id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_count_user_postlikes`
--
DROP TABLE IF EXISTS `v_count_user_postlikes`;

DROP VIEW IF EXISTS `v_count_user_postlikes`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_count_user_postlikes`  AS  select `f`.`user_id` AS `poster_id`,count(`fl`.`user_id`) AS `count_post_likes` from (`tbl_feed` `f` left join `tbl_feed_likes` `fl` on(`fl`.`post_id` = `f`.`post_id`)) where `f`.`post_id` is not null group by `f`.`user_id` union select `f`.`user_id` AS `poster_id`,count(`fl`.`user_id`) AS `count_post_likes` from (`tbl_feed_likes` `fl` left join `tbl_feed` `f` on(`fl`.`post_id` = `f`.`post_id`)) where `f`.`post_id` is not null group by `f`.`user_id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_count_user_posts`
--
DROP TABLE IF EXISTS `v_count_user_posts`;

DROP VIEW IF EXISTS `v_count_user_posts`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_count_user_posts`  AS  select `tbl_feed`.`user_id` AS `user_id`,count(0) AS `count_posts` from `tbl_feed` group by `tbl_feed`.`user_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `delete_comments_on_user_delete` (`user_id`),
  ADD KEY `delete_comments_on_post_delete` (`post_id`);

--
-- Indexes for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `delete_posts_on_user_delete` (`user_id`);

--
-- Indexes for table `tbl_feed_likes`
--
ALTER TABLE `tbl_feed_likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_feed_likes`
--
ALTER TABLE `tbl_feed_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `delete_comments_on_post_delete` FOREIGN KEY (`post_id`) REFERENCES `tbl_feed` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_comments_on_user_delete` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  ADD CONSTRAINT `delete_posts_on_user_delete` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
