-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2021 at 05:29 AM
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

DROP PROCEDURE IF EXISTS `delete_like`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_like` (IN `p_post_id` INT(11), IN `p_user_id` INT(11))  BEGIN
	DELETE FROM tbl_feed_likes 
    WHERE post_id = p_post_id
    AND user_id = p_user_id;
END$$

DELIMITER ;

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
-- Stand-in structure for view `view_posts`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_posts`;
CREATE TABLE `view_posts` (
`post_id` int(11)
,`user_id` int(11)
,`post_title` varchar(255)
,`post_content` text
,`post_img` varchar(255)
,`post_time` timestamp
,`username` varchar(255)
,`profile_pic` varchar(255)
,`cover_photo` varchar(255)
,`bio` text
,`account_type` varchar(255)
,`register_time` timestamp
,`date_time` varchar(87)
,`count_comments` bigint(21)
,`count_likes` bigint(21)
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
-- Structure for view `view_posts`
--
DROP TABLE IF EXISTS `view_posts`;

DROP VIEW IF EXISTS `view_posts`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_posts`  AS  select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_img` AS `post_img`,`f`.`post_time` AS `post_time`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`u`.`cover_photo` AS `cover_photo`,`u`.`bio` AS `bio`,`u`.`account_type` AS `account_type`,`u`.`register_time` AS `register_time`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,count(`c`.`comment_id`) AS `count_comments`,count(`fl`.`like_id`) AS `count_likes` from (((`tbl_feed` `f` left join `tbl_users` `u` on(`f`.`user_id` = `u`.`user_id`)) left join `tbl_feed_likes` `fl` on(`f`.`post_id` = `fl`.`post_id`)) left join `tbl_comments` `c` on(`f`.`post_id` = `c`.`post_id`)) group by `f`.`post_id` order by `f`.`post_time` ;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
