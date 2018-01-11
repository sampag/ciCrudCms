-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2018 at 02:01 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_crud_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_description` text NOT NULL,
  `category_slug` varchar(50) NOT NULL,
  `category_created` timestamp NULL DEFAULT NULL,
  `category_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`, `category_slug`, `category_created`, `category_updated`) VALUES
(11, 'Ruby on Rails', 'Ruby on Rails', 'ruby-on-rails', '2017-12-26 23:46:21', NULL),
(12, 'PHP', 'PHP', 'php', '2017-12-26 23:46:33', NULL),
(13, 'Node Js', 'Node Js', 'node-js', '2017-12-26 23:46:39', NULL),
(14, 'Python', 'Python', 'python', '2017-12-26 23:47:22', NULL),
(15, 'Django', 'Django', 'django', '2017-12-26 23:47:30', '2018-01-10 10:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_post_id` int(11) DEFAULT NULL,
  `comment_approved` tinyint(1) NOT NULL DEFAULT '0',
  `comment_content` text,
  `comment_name` varchar(50) NOT NULL,
  `comment_email` varchar(50) NOT NULL,
  `comment_created` int(11) DEFAULT NULL,
  `comment_updated` int(11) DEFAULT NULL,
  `comment_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_random_id` varchar(35) DEFAULT NULL,
  `post_title` varchar(100) NOT NULL,
  `post_content` text NOT NULL,
  `post_slug` varchar(100) NOT NULL,
  `post_category_id` int(11) DEFAULT NULL,
  `post_uncategorized_slug` varchar(50) DEFAULT NULL,
  `post_published` tinyint(1) DEFAULT NULL,
  `post_featured_img` varchar(100) DEFAULT NULL,
  `post_created` int(11) DEFAULT NULL,
  `post_created_gmt` int(11) DEFAULT NULL,
  `post_updated` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_random_id`, `post_title`, `post_content`, `post_slug`, `post_category_id`, `post_uncategorized_slug`, `post_published`, `post_featured_img`, `post_created`, `post_created_gmt`, `post_updated`, `user_id`) VALUES
(173, 'onyY9mQJljZqIbSDPiCd2KHFs5LTE4', 'First post by admin', 'First post by admin', 'first-post-by-admin', NULL, 'uncategorized', 1, '307d572dd7d0fd9f19badfc81d19bd5f.jpg', 1515664534, 1515664534, '2018-01-11 10:49:05', 1),
(174, 'Mm9vR60G3hNZlfBDrPVcbEigjqJedI', 'Second post by admins', 'Second post by admins', 'second-post-by-admins', 15, NULL, 1, '', 1515667914, 1515667914, '2018-01-11 10:53:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_term`
--

CREATE TABLE `post_term` (
  `term_order` int(11) NOT NULL,
  `term_tag_id` int(11) NOT NULL,
  `term_post_id` int(11) NOT NULL,
  `term_user_id` int(11) DEFAULT NULL,
  `term_created` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_term`
--

INSERT INTO `post_term` (`term_order`, `term_tag_id`, `term_post_id`, `term_user_id`, `term_created`) VALUES
(59, 51, 173, 1, 1515667746),
(60, 50, 173, 1, 1515667746),
(64, 50, 174, 1, 1515668029);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `pagination` int(11) NOT NULL DEFAULT '5',
  `title` varchar(50) DEFAULT NULL,
  `tagline` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `pagination`, `title`, `tagline`, `logo`, `favicon`) VALUES
(1, 10, 'Atomic Code', 'Design and Technology', '04b7ee70263ddb0009267327f234c0dc.png', '6c658506e3078c8ca8917917188627a8.png');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  `tag_description` text NOT NULL,
  `tag_slug` varchar(59) NOT NULL,
  `tag_created` timestamp NULL DEFAULT NULL,
  `tag_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`, `tag_description`, `tag_slug`, `tag_created`, `tag_updated`) VALUES
(50, 'Backend', 'Backend', 'backend', '2017-12-26 23:39:20', NULL),
(51, 'Framework', 'Framework', 'framework', '2017-12-26 23:39:30', NULL),
(52, 'Client Sides', 'Client Sides', 'client-sides', '2017-12-26 23:47:00', '2018-01-11 09:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'O6Bq9AxeYQ0JUrSBIbCwoO', 1268889823, 1515663956, 1, 'John', 'Cena', 'ADMIN', '0'),
(10, '::1', 'nobitanobi@gmail.com', '$2y$08$TYDKd28TkyhKl0unfA7I6u9DyoPFyx43CrC7wqRllqEbStx09rh6.', NULL, 'nobitanobi@gmail.com', NULL, NULL, NULL, NULL, 1514429082, 1515582346, 1, 'Nobita', 'Nobi', 'Doraemon', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(27, 1, 1),
(34, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `profile_user_id` int(11) NOT NULL,
  `profile_user_nickname` varchar(50) DEFAULT NULL,
  `profile_user_avatar` varchar(50) DEFAULT NULL,
  `profile_user_website` varchar(250) NOT NULL,
  `profile_user_bio_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `profile_user_id`, `profile_user_nickname`, `profile_user_avatar`, `profile_user_website`, `profile_user_bio_info`) VALUES
(8, 10, 'Nobi', 'f7ebf9a28dd6b4e70b4c1a4df1b0b97f.png', '', 'Hi Im Nobita Nobi from doraemon im a bullied by takeshi everyday');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_term`
--
ALTER TABLE `post_term`
  ADD PRIMARY KEY (`term_order`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `post_term`
--
ALTER TABLE `post_term`
  MODIFY `term_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
