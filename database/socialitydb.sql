-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2021 at 10:26 AM
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
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed`
--

CREATE TABLE `tbl_feed` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_img` varchar(255) DEFAULT NULL,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_feed`
--

INSERT INTO `tbl_feed` (`post_id`, `user_id`, `post_title`, `post_content`, `post_img`, `post_time`) VALUES
(3, 5, 'Post', 'someting neat', NULL, '2021-03-30 09:11:22'),
(4, 5, 'Nice', 'Jimmy is Nice', NULL, '2021-04-13 06:30:24'),
(8, 5, 'image', 'for real this time', 'images/post_img/5_2021-04-13_14-37-55.png', '2021-04-13 06:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed_likes`
--

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

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'images/users/_default.jpg',
  `cover_photo` varchar(255) NOT NULL DEFAULT 'images/users_cover/_default.png',
  `bio` text NOT NULL DEFAULT 'New user',
  `account_type` varchar(255) NOT NULL DEFAULT 'user',
  `register_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `email`, `sex`, `profile_pic`, `cover_photo`, `bio`, `account_type`, `register_time`) VALUES
(2, 'Amber', '$2y$10$ShhsrgYi6w6TSg5O1yUTMugc2Znop1ucNjF7PsIVcaRfZkRSes4Qa', 'pass@gmail.com', 'male', 'images/users/_default.jpg', 'images/users_cover/_default.png', 'New user', 'user', '2021-04-13 07:49:43'),
(3, 'Amber2', '$2y$10$JWCTGjdYTSTQDgZIHJ2eCOLN3C3QmXUvQ49/yO0jwXIgb2hjDl.n2', 'newEmail@gmail.com', 'male', 'images/users/_default.jpg', 'images/users_cover/_default.png', 'New user', 'user', '2021-04-13 07:49:43'),
(4, 'Peemail', '$2y$10$GsuKm8cN2PKP2mJIYgt1QeiIUq5SpPH/vCNaLxTsP5G0VXSY.DSmm', 'registerrr@gmail.com', 'Prefer not to say', 'images/users/_default.jpg', 'images/users_cover/_default.png', 'New user', 'user', '2021-04-13 07:49:43'),
(5, 'user', '$2y$10$2uWU/wR1ODM5fp1o195RwesqhE836daezDLKNs6xHN1KYrP/4v1Zi', 'user@user.com', 'Prefer not to say', 'images/users/_default.jpg', 'images/users_cover/_default.png', 'New user', 'user', '2021-04-13 07:49:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `remove_on_delete` (`user_id`);

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
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_feed_likes`
--
ALTER TABLE `tbl_feed_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  ADD CONSTRAINT `remove_on_delete` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
