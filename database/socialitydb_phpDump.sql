-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: socialitydb
-- ------------------------------------------------------
-- Server version 	5.5.5-10.4.14-MariaDB
-- Date: Thu, 13 May 2021 06:41:05 +0200

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_comments`
--

DROP TABLE IF EXISTS `tbl_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comment_id`),
  KEY `delete_comments_on_user_delete` (`user_id`),
  KEY `delete_comments_on_post_delete` (`post_id`),
  CONSTRAINT `delete_comments_on_post_delete` FOREIGN KEY (`post_id`) REFERENCES `tbl_feed` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `delete_comments_on_user_delete` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_feed`
--

DROP TABLE IF EXISTS `tbl_feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_feed` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_img` varchar(255) DEFAULT NULL,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `delete_posts_on_user_delete` (`user_id`),
  CONSTRAINT `delete_posts_on_user_delete` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_feed_likes`
--

DROP TABLE IF EXISTS `tbl_feed_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_feed_likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `react_type` varchar(255) NOT NULL DEFAULT 'like',
  `like_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'images/users/_default.jpg',
  `cover_photo` varchar(255) NOT NULL DEFAULT 'images/users_cover/_default.png',
  `bio` text NOT NULL,
  `account_type` varchar(255) NOT NULL DEFAULT 'user',
  `register_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Stand-In structure for view `view_comments`
--

DROP TABLE IF EXISTS `view_comments`;
/*!50001 DROP VIEW IF EXISTS `view_comments`*/;
CREATE TABLE IF NOT EXISTS `view_comments` (
`comment_id` int(11)
,`user_id` int(11)
,`username` varchar(255)
,`profile_pic` varchar(255)
,`post_id` int(11)
,`comment_content` text
,`comment_time` timestamp
);
--
-- Stand-In structure for view `view_posts`
--

DROP TABLE IF EXISTS `view_posts`;
/*!50001 DROP VIEW IF EXISTS `view_posts`*/;
CREATE TABLE IF NOT EXISTS `view_posts` (
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
--
-- Stand-In structure for view `view_posts_full`
--

DROP TABLE IF EXISTS `view_posts_full`;
/*!50001 DROP VIEW IF EXISTS `view_posts_full`*/;
CREATE TABLE IF NOT EXISTS `view_posts_full` (
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
--
-- Stand-In structure for view `view_user_stats`
--

DROP TABLE IF EXISTS `view_user_stats`;
/*!50001 DROP VIEW IF EXISTS `view_user_stats`*/;
CREATE TABLE IF NOT EXISTS `view_user_stats` (
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
--
-- Stand-In structure for view `v_count_comments`
--

DROP TABLE IF EXISTS `v_count_comments`;
/*!50001 DROP VIEW IF EXISTS `v_count_comments`*/;
CREATE TABLE IF NOT EXISTS `v_count_comments` (
`post_id` int(11)
,`count_comments` bigint(21)
);
--
-- Stand-In structure for view `v_count_likes`
--

DROP TABLE IF EXISTS `v_count_likes`;
/*!50001 DROP VIEW IF EXISTS `v_count_likes`*/;
CREATE TABLE IF NOT EXISTS `v_count_likes` (
`post_id` int(11)
,`count_likes` bigint(21)
);
--
-- Stand-In structure for view `v_count_user_comments`
--

DROP TABLE IF EXISTS `v_count_user_comments`;
/*!50001 DROP VIEW IF EXISTS `v_count_user_comments`*/;
CREATE TABLE IF NOT EXISTS `v_count_user_comments` (
`user_id` int(11)
,`count_comments` bigint(21)
);
--
-- Stand-In structure for view `v_count_user_postlikes`
--

DROP TABLE IF EXISTS `v_count_user_postlikes`;
/*!50001 DROP VIEW IF EXISTS `v_count_user_postlikes`*/;
CREATE TABLE IF NOT EXISTS `v_count_user_postlikes` (
`poster_id` int(11)
,`count_post_likes` bigint(21)
);
--
-- Stand-In structure for view `v_count_user_posts`
--

DROP TABLE IF EXISTS `v_count_user_posts`;
/*!50001 DROP VIEW IF EXISTS `v_count_user_posts`*/;
CREATE TABLE IF NOT EXISTS `v_count_user_posts` (
`user_id` int(11)
,`count_posts` bigint(21)
);
--
-- View structure for view `view_comments`
--

DROP TABLE IF EXISTS `view_comments`;
/*!50001 DROP VIEW IF EXISTS `view_comments`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_comments` AS select `c`.`comment_id` AS `comment_id`,`c`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`c`.`post_id` AS `post_id`,`c`.`comment_content` AS `comment_content`,`c`.`comment_time` AS `comment_time` from (`tbl_comments` `c` join `tbl_users` `u` on(`u`.`user_id` = `c`.`user_id`)) */;

--
-- View structure for view `view_posts`
--

DROP TABLE IF EXISTS `view_posts`;
/*!50001 DROP VIEW IF EXISTS `view_posts`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_posts` AS select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_img` AS `post_img`,`f`.`post_time` AS `post_time`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`u`.`cover_photo` AS `cover_photo`,`u`.`bio` AS `bio`,`u`.`account_type` AS `account_type`,`u`.`register_time` AS `register_time`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,count(`c`.`comment_id`) AS `count_comments`,count(`fl`.`like_id`) AS `count_likes` from (((`tbl_feed` `f` left join `tbl_users` `u` on(`f`.`user_id` = `u`.`user_id`)) left join `tbl_feed_likes` `fl` on(`f`.`post_id` = `fl`.`post_id`)) left join `tbl_comments` `c` on(`f`.`post_id` = `c`.`post_id`)) group by `f`.`post_id` order by `f`.`post_time` */;

--
-- View structure for view `view_posts_full`
--

DROP TABLE IF EXISTS `view_posts_full`;
/*!50001 DROP VIEW IF EXISTS `view_posts_full`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_posts_full` AS select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_time` AS `post_time`,`f`.`post_img` AS `post_img`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,`v`.`count_comments` AS `count_comments`,`vl`.`count_likes` AS `count_likes` from (((`tbl_feed` `f` left join `v_count_comments` `v` on(`f`.`post_id` = `v`.`post_id`)) left join `v_count_likes` `vl` on(`vl`.`post_id` = `f`.`post_id`)) left join `tbl_users` `u` on(`f`.`user_id` = `u`.`user_id`)) where `f`.`post_id` is not null union select `f`.`post_id` AS `post_id`,`f`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`profile_pic` AS `profile_pic`,`f`.`post_title` AS `post_title`,`f`.`post_content` AS `post_content`,`f`.`post_time` AS `post_time`,`f`.`post_img` AS `post_img`,date_format(`f`.`post_time`,'%M %d %Y, %H:%i:%s') AS `date_time`,`v`.`count_comments` AS `count_comments`,`vl`.`count_likes` AS `count_likes` from (`tbl_users` `u` left join (`v_count_likes` `vl` left join (`v_count_comments` `v` left join `tbl_feed` `f` on(`f`.`post_id` = `v`.`post_id`)) on(`vl`.`post_id` = `f`.`post_id`)) on(`f`.`user_id` = `u`.`user_id`)) where `f`.`post_id` is not null */;

--
-- View structure for view `view_user_stats`
--

DROP TABLE IF EXISTS `view_user_stats`;
/*!50001 DROP VIEW IF EXISTS `view_user_stats`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_user_stats` AS select `u`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`profile_pic` AS `profile_pic`,`u`.`bio` AS `bio`,`u`.`cover_photo` AS `cover_photo`,`u`.`register_time` AS `register_time`,`vcuc`.`count_comments` AS `count_comments`,`vcupl`.`count_post_likes` AS `count_post_likes`,`vcup`.`count_posts` AS `count_posts` from (((`tbl_users` `u` left join `v_count_user_comments` `vcuc` on(`u`.`user_id` = `vcuc`.`user_id`)) left join `v_count_user_postlikes` `vcupl` on(`u`.`user_id` = `vcupl`.`poster_id`)) left join `v_count_user_posts` `vcup` on(`u`.`user_id` = `vcup`.`user_id`)) where `u`.`user_id` is not null union select `u`.`user_id` AS `user_id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`profile_pic` AS `profile_pic`,`u`.`bio` AS `bio`,`u`.`cover_photo` AS `cover_photo`,`u`.`register_time` AS `register_time`,`vcuc`.`count_comments` AS `count_comments`,`vcupl`.`count_post_likes` AS `count_post_likes`,`vcup`.`count_posts` AS `count_posts` from (`v_count_user_posts` `vcup` left join (`v_count_user_postlikes` `vcupl` left join (`v_count_user_comments` `vcuc` left join `tbl_users` `u` on(`u`.`user_id` = `vcuc`.`user_id`)) on(`u`.`user_id` = `vcupl`.`poster_id`)) on(`u`.`user_id` = `vcup`.`user_id`)) where `u`.`user_id` is not null */;

--
-- View structure for view `v_count_comments`
--

DROP TABLE IF EXISTS `v_count_comments`;
/*!50001 DROP VIEW IF EXISTS `v_count_comments`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_comments` AS select `tbl_comments`.`post_id` AS `post_id`,count(`tbl_comments`.`comment_id`) AS `count_comments` from `tbl_comments` group by `tbl_comments`.`post_id` */;

--
-- View structure for view `v_count_likes`
--

DROP TABLE IF EXISTS `v_count_likes`;
/*!50001 DROP VIEW IF EXISTS `v_count_likes`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_likes` AS select `tbl_feed_likes`.`post_id` AS `post_id`,count(`tbl_feed_likes`.`like_id`) AS `count_likes` from `tbl_feed_likes` group by `tbl_feed_likes`.`post_id` */;

--
-- View structure for view `v_count_user_comments`
--

DROP TABLE IF EXISTS `v_count_user_comments`;
/*!50001 DROP VIEW IF EXISTS `v_count_user_comments`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_user_comments` AS select `tbl_comments`.`user_id` AS `user_id`,count(0) AS `count_comments` from `tbl_comments` group by `tbl_comments`.`user_id` */;

--
-- View structure for view `v_count_user_postlikes`
--

DROP TABLE IF EXISTS `v_count_user_postlikes`;
/*!50001 DROP VIEW IF EXISTS `v_count_user_postlikes`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_user_postlikes` AS select `f`.`user_id` AS `poster_id`,count(`fl`.`user_id`) AS `count_post_likes` from (`tbl_feed` `f` left join `tbl_feed_likes` `fl` on(`fl`.`post_id` = `f`.`post_id`)) where `f`.`post_id` is not null group by `f`.`user_id` union select `f`.`user_id` AS `poster_id`,count(`fl`.`user_id`) AS `count_post_likes` from (`tbl_feed_likes` `fl` left join `tbl_feed` `f` on(`fl`.`post_id` = `f`.`post_id`)) where `f`.`post_id` is not null group by `f`.`user_id` */;

--
-- View structure for view `v_count_user_posts`
--

DROP TABLE IF EXISTS `v_count_user_posts`;
/*!50001 DROP VIEW IF EXISTS `v_count_user_posts`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_user_posts` AS select `tbl_feed`.`user_id` AS `user_id`,count(0) AS `count_posts` from `tbl_feed` group by `tbl_feed`.`user_id` */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Thu, 13 May 2021 06:41:06 +0200
