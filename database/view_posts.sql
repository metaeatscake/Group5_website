-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2021 at 04:39 AM
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

-- --------------------------------------------------------

--
-- Structure for view `view_posts`
--

DROP VIEW IF EXISTS `view_posts`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_posts`  AS  select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_img` AS `post_img`,`f`.`post_time` AS `post_time`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`u`.`cover_photo` AS `cover_photo`,`u`.`bio` AS `bio`,`u`.`account_type` AS `account_type`,`u`.`register_time` AS `register_time`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,count(`c`.`comment_id`) AS `count_comments`,count(`fl`.`like_id`) AS `count_likes` from (((`tbl_feed` `f` left join `tbl_users` `u` on(`f`.`user_id` = `u`.`user_id`)) left join `tbl_feed_likes` `fl` on(`f`.`post_id` = `fl`.`post_id`)) left join `tbl_comments` `c` on(`f`.`post_id` = `c`.`post_id`)) group by `f`.`post_id` order by `f`.`post_time` ;

--
-- VIEW `view_posts`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
