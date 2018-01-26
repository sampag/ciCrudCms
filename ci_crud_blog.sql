-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2018 at 02:45 PM
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
  `post_published_created` timestamp NULL DEFAULT NULL,
  `post_featured_img` varchar(100) DEFAULT NULL,
  `post_created` int(11) DEFAULT NULL,
  `post_created_gmt` int(11) DEFAULT NULL,
  `post_updated` timestamp NULL DEFAULT NULL,
  `post_trash` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_random_id`, `post_title`, `post_content`, `post_slug`, `post_category_id`, `post_uncategorized_slug`, `post_published`, `post_published_created`, `post_featured_img`, `post_created`, `post_created_gmt`, `post_updated`, `post_trash`, `user_id`) VALUES
(4, 'K32YgGF5QlPe6ibBs01CJxkSvHZEXp', 'First post by admin', '<p>first post by admin<br></p>', 'first-post-by-admin', 15, NULL, 1, '2018-01-16 07:33:56', '', 1516088036, 1516088036, NULL, NULL, 1),
(5, 'ThnRSGcyPj47KWNeVOwlA5Z9pYmDLI', 'Second post by admin', '<p>second post by admin<br></p>', 'second-post-by-admin', 14, NULL, 1, '2018-01-16 07:34:07', '', 1516088047, 1516088047, NULL, NULL, 1),
(6, '6fmj4aGdQORoXg8pysBMN9nztbwDW0', 'Third post by admin', '<p>third post by admin<br></p>', 'third-post-by-admin', 14, NULL, 1, '2018-01-16 07:34:27', '', 1516088067, 1516088067, NULL, NULL, 1),
(7, 'f0Vm3igGJpoZO6TzjueM5Cwb7y4NdA', 'Fourth post by admin', '<p>fourth post by admin<br></p>', 'fourth-post-by-admin', 0, 'uncategorized', NULL, '2018-01-16 07:34:43', '', 1516088083, 1516088083, NULL, NULL, 1),
(8, '1AUpWXeyhCI0JQE9ldBiasxLr68Z42', 'Fifth post by admin', '<p>fifth post by admin<br></p>', 'fifth-post-by-admin', 13, NULL, 1, '2018-01-16 07:35:00', '', 1516088100, 1516088100, NULL, NULL, 1),
(9, '9UBG6ewvRh3Smyi5XVkMnrDKcLl1dO', 'Sixth post by admin', '<p>sixth post by admin<br></p>', 'sixth-post-by-admin', 12, NULL, 1, '2018-01-16 07:35:14', '', 1516088114, 1516088114, NULL, NULL, 1),
(10, 'IGjL3YMBUfXRq5WFzag6lwuv2o9sxJ', 'Seventh post by admin', '<p>seventh post by admin<br></p>', 'seventh-post-by-admin', 14, NULL, NULL, '2018-01-16 07:35:38', '', 1516088138, 1516088138, NULL, NULL, 1),
(11, 'fjVJvA0u1mLXosMYz5F7edEwg3QHli', 'Eighth post by admin', '<p>eighth post by admin<br></p>', 'eighth-post-by-admin', 13, NULL, 1, '2018-01-16 07:35:50', '', 1516088150, 1516088150, NULL, NULL, 1),
(12, 'nOtFxL0jdlyKiqEe7vTYcwzWHI52Gs', 'Ninth post by admin', '<p>ninth post by admin<br></p>', 'ninth-post-by-admin', 15, NULL, 1, '2018-01-16 07:36:07', '', 1516088167, 1516088167, NULL, NULL, 1),
(13, 'arKRZidB4kqW90CSmNAwyot7ljnF3z', 'Tenth post by admin', '<p>tenth post by admin<br></p>', 'tenth-post-by-admin', 12, NULL, 1, '2018-01-16 07:36:26', '', 1516088186, 1516088186, NULL, NULL, 1),
(14, 'DXn8MUjCZ0p9HqI7omlSi2TAu1Lx3E', 'Eleventh post by admin', '<p>eleventh post by admin<br></p>', 'eleventh-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 07:36:44', '', 1516088204, 1516088204, NULL, NULL, 1),
(15, 'n8fepmzdZr7ASRWOGKEFIDCqxkPaXL', 'Twelvth post by admin', '<p>twelvth post by admin<br></p>', 'twelvth-post-by-admin', 14, NULL, 1, '2018-01-16 07:37:23', '', 1516088243, 1516088243, NULL, NULL, 1),
(16, '3LwMzPHAK5lse0WuyZmO', 'First post by member', '<p>first post by member<br></p>', 'first-post-by-member', 13, '', NULL, '2018-01-16 07:38:18', '', 1516088298, NULL, NULL, NULL, 10),
(17, 'OCXypvkKLM0YWF3jxtAZ', 'Second post by member', '<p>second post by member<br></p>', 'second-post-by-member', 13, '', 1, '2018-01-16 07:38:50', '', 1516088330, NULL, NULL, NULL, 10),
(18, 'XhxgbnwDWzYEoRciN0d1', 'Third post by member', '<p>third post by member<br></p>', 'third-post-by-member', 0, 'uncategorized', 1, '2018-01-16 07:43:19', '', 1516088599, NULL, NULL, NULL, 10),
(19, 'E0CJNVPwjpetY5qWxBFmzhcX3LvDZ7', 'Thirtenth post by admin', '<p>thirtenth post by admin<br></p>', 'thirtenth-post-by-admin', 14, NULL, NULL, '2018-01-16 08:05:47', '', 1516089947, 1516089947, NULL, NULL, 1),
(20, 'bJx6v0Z5ks7NOLuRCKpjFilhU2g8Qw', 'Fourtenth post by admin', '<p>fourtenth post by admin<br></p>', 'fourtenth-post-by-admin', 13, NULL, 1, '2018-01-16 08:06:33', '', 1516089993, 1516089993, NULL, NULL, 1),
(21, 'uqGD67kF4NCh583gsv1abEwpQrVMPS', 'Fiftenth post by admin', '<p>fiftenth post by admin<br></p>', 'fiftenth-post-by-admin', 12, NULL, 1, '2018-01-16 08:06:57', '', 1516090017, 1516090017, NULL, NULL, 1),
(22, '2kZ1ioLns4h9YpfcCgvtV6POJ5S7TX', 'Sixthtenth post by admin', '<p>sixthtenth post by admin<br></p>', 'sixthtenth-post-by-admin', 14, NULL, 1, '2018-01-16 08:07:21', '', 1516090041, 1516090041, NULL, NULL, 1),
(23, 'slGyZOfxAItBcgv0WeDd7SRLJi89mj', 'Sevententh post by admin', '<p>sevententh post by admin<br></p>', 'sevententh-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:13:26', '', 1516090406, 1516090406, NULL, NULL, 1),
(24, 'htLukezVd6I1a7yQEGqF4XpsRJnPM9', 'Eightenth post by admin', '<p>eightenth post by admin<br></p>', 'eightenth-post-by-admin', 0, 'uncategorized', NULL, '2018-01-16 08:13:58', '', 1516090438, 1516090438, NULL, NULL, 1),
(25, 'NMz95gDrufUs7oWTCQBFXOqLISli06', 'Nintenth post by admin', '<p>nintenth post by admin<br></p>', 'nintenth-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:14:47', '', 1516090487, 1516090487, NULL, NULL, 1),
(26, 'd8vzk1H6utNnBr7mpis5haOPU9CFYT', 'Twentieth post by admin', '<p>twentieth post by admin<br></p>', 'twentieth-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:15:08', '', 1516090508, 1516090508, NULL, NULL, 1),
(27, 'OkdXpgHQb9MKeF8nZatLI36fyl5mzx', 'Twentefirst post by admin', '<p>twentefirst post by admin<br></p>', 'twentefirst-post-by-admin', 0, 'uncategorized', NULL, '2018-01-16 08:16:11', '', 1516090571, 1516090571, NULL, NULL, 1),
(28, '3umFfCRJY8awUMQN05GIKLVb7gxhPe', 'Twentesecond post by admin', '<p>twentesecond post by admin<br></p>', 'twentesecond-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:16:36', '', 1516090596, 1516090596, NULL, NULL, 1),
(29, 'N0ScyeHPhF3dqmRbO1gzY6s5Dopxl8', 'Twentythird post by admin', '<p>twentythird post by admin<br></p>', 'twentythird-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:16:56', '', 1516090616, 1516090616, NULL, NULL, 1),
(30, 'TjFd51NhwY4H2rSO3IfzgUDZyq9JL8', 'Twentyfourth post by admin', '<p>twentyfourth post by admin<br></p>', 'twentyfourth-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:17:31', '', 1516090651, 1516090651, NULL, NULL, 1),
(31, '1ikZj3YT9PhIQC5uVftSN8LBGxWmzp', 'Twentyfifth post by admin', '<p>twentyfifth post by admin<br></p>', 'twentyfifth-post-by-admin', 0, 'uncategorized', 1, '2018-01-16 08:17:51', '', 1516090671, 1516090671, NULL, NULL, 1),
(32, '3Koq7csxjgIBytlmHkLM', 'Fourth post by member', '<p>fourth post by member<br></p>', 'fourth-post-by-member', 0, 'uncategorized', 1, '2018-01-16 10:29:27', '', 1516098567, NULL, NULL, NULL, 10),
(33, 'xjYt0TVOR95Xo3eiFlwz8sGhaJfuLI', 'Python post 7', '<p>python post 7<br></p>', 'python-post-7', 14, NULL, 1, '2018-01-16 10:50:20', '', 1516099820, 1516099820, NULL, NULL, 1),
(34, 'SO8XWvcFb7261hMuUjxg9kAmryn4ZR', 'Python post 8', '<p>python post 8<br></p>', 'python-post-8', 14, NULL, 1, '2018-01-16 10:50:35', '', 1516099835, 1516099835, NULL, NULL, 1),
(35, 'pEXeayQlDjuO85TZfbi9g6WnYcPk0s', 'Python post 9', '<p>python post 9<br></p>', 'python-post-9', 14, NULL, 1, '2018-01-16 10:50:53', '', 1516099853, 1516099853, NULL, NULL, 1),
(36, 'Wam5N0SflEws1QuV7TrFUkpycDItLO', 'Python post 10', '<p>python post 10<br></p>', 'python-post-10', 14, NULL, 1, '2018-01-16 10:51:18', '', 1516099878, 1516099878, NULL, NULL, 1),
(37, 'WwHeh95xyGSv7cUTns10fCM6kbLIdj', 'Python post 11', '<p>python post 11<br></p>', 'python-post-11', 14, NULL, 1, '2018-01-16 10:51:28', '', 1516099888, 1516099888, NULL, NULL, 1),
(38, 'JXpithcPGLlkxo5b0THvC9jdsU6OS3', 'Python post 12', '<p>python post 12<br></p>', 'python-post-12', 14, NULL, NULL, '2018-01-16 10:51:48', '', 1516099908, 1516099908, NULL, NULL, 1),
(39, 'Le9F6YbXIkvcBKzDgNVlPr4CuEQnUG', 'Tag backend', '<p>tag backend<br></p>', 'tag-backend', 0, 'uncategorized', 1, '2018-01-17 09:21:23', '', 1516180883, 1516180883, NULL, NULL, 1),
(40, 'qb53mITtJDN7GzApgHFS9EkVLuoMca', 'Tagtag backend', '<p>tag backend<br></p>', 'tagtag-backend', 14, NULL, 1, '2018-01-17 09:21:35', '', 1516180895, 1516180895, NULL, NULL, 1),
(41, '1ztOBdskKNwepL3ma6Sn', 'Fifth post by member', '<p>fifth post by member<br></p>', 'fifth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 06:50:45', '', 1516258245, NULL, NULL, NULL, 10),
(42, 'exyovVn8glYANas10qkH', 'Sixth post by member', '<p>sixth post by member<br></p>', 'sixth-post-by-member', 13, '', 1, '2018-01-18 06:51:19', '', 1516258279, NULL, NULL, NULL, 10),
(43, 'WTOw4b21tamh3VlJEKkq', 'Seventh post by member', '<p>seventh post by member<br></p>', 'seventh-post-by-member', 13, '', 1, '2018-01-18 06:51:33', '', 1516258293, NULL, NULL, NULL, 10),
(44, '30Nm2LraByuX5cYVvQTM', 'Eighth post by member', '<p>eighth post by member<br></p>', 'eighth-post-by-member', 13, '', 1, '2018-01-18 06:51:52', '', 1516258312, NULL, NULL, NULL, 10),
(45, 'k7bJfNZ4pcndS3h8jOUQ', 'Ninth post by member', '<p>ninth post by member<br></p>', 'ninth-post-by-member', 13, '', 1, '2018-01-18 06:52:08', '', 1516258328, NULL, NULL, NULL, 10),
(46, '6HLnDkmr3VNoQ5bx2UCS', 'Tenth post by member', '<p>tenth post by member<br></p>', 'tenth-post-by-member', 13, '', 1, '2018-01-18 06:52:23', '', 1516258343, NULL, NULL, NULL, 10),
(47, 'wng1dqDfS2XLHv0VtrIp', 'Eleventh post by member', '<p>eleventh post by member<br></p>', 'eleventh-post-by-member', 13, '', 1, '2018-01-18 06:52:36', '', 1516258356, NULL, NULL, NULL, 10),
(48, '1o8kydTa5XPQMxhwAqvs', 'Twelvth post by member', '<p>twelvth post by member<br></p>', 'twelvth-post-by-member', 13, '', 1, '2018-01-18 07:12:07', '', 1516259527, NULL, NULL, NULL, 10),
(49, 'emR1Q7UfWwzSjbhopI38', 'Thirtenth post by member', '<p>thirtenth post by member<br></p>', 'thirtenth-post-by-member', 13, '', 1, '2018-01-18 07:12:23', '', 1516259543, NULL, NULL, NULL, 10),
(50, 'im5VYc9EPGMxSKgXpkzL', 'Fourtenth post by member', '<p>fourtenth post by member<br></p>', 'fourtenth-post-by-member', 13, '', 1, '2018-01-18 07:12:41', '', 1516259561, NULL, NULL, NULL, 10),
(51, 'GhUWIPEaxZ2Rp6OnodkB', 'Fifthtent post by member', '<p>fifthtent post by member<br></p>', 'fifthtent-post-by-member', 13, '', 1, '2018-01-18 07:12:57', '', 1516259577, NULL, NULL, NULL, 10),
(52, 'gGyVPpHvq39MWuhiJC80', 'Sixth post by member', '<p>sixth post by member<br></p>', 'sixth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:17:14', '', 1516263434, NULL, NULL, NULL, 10),
(53, '6rGASvtNmu4I7VpMse1Y', 'Seventh post by member', '<p>seventh post by member<br></p>', 'seventh-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:17:29', '', 1516263449, NULL, NULL, NULL, 10),
(54, 'srqOxC95flY4Gvta62c7', 'Eigth post by member', '<p>eigth post by member<br></p>', 'eigth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:17:43', '', 1516263463, NULL, NULL, NULL, 10),
(55, 'xN46wqFuLsVXPCnjmQbl', 'Ninth post by member', '<p>ninth post by member<br></p>', 'ninth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:18:21', '', 1516263501, NULL, NULL, NULL, 10),
(56, 'Z8htf6A7VQgFuOpEUxjw', 'Tenth post by member', '<p>tenth post by member<br></p>', 'tenth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:18:37', '', 1516263517, NULL, NULL, NULL, 10),
(57, 'Hjlf35ykxwvhu16e4ELI', 'Eleventh post by member', '<p>eleventh post by member<br></p>', 'eleventh-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:18:49', '', 1516263529, NULL, NULL, NULL, 10),
(58, 'QEV5zDgHPK9m8y2XbSke', 'Twelvth post by member', '<p>twelvth post by member<br></p>', 'twelvth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:19:43', '', 1516263583, NULL, NULL, NULL, 10),
(59, 'UemIiqhS6df1YsXkvozM', 'Thirtent post by member', '<p>thirtent post by member<br></p>', 'thirtent-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:20:04', '', 1516263604, NULL, NULL, NULL, 10),
(60, 'sa0j9TO65xeKC2IzqAvY', 'Fourtenth post by member', '<p>fourtenth post by member<br></p>', 'fourtenth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:20:27', '', 1516263627, NULL, NULL, NULL, 10),
(61, '2jZWAb8QfzHLgEKFw5Yn', 'Fifthtenth post by member', '<p>fifthtenth post by member<br></p>', 'fifthtenth-post-by-member', 0, 'uncategorized', 1, '2018-01-18 08:20:51', '', 1516263651, NULL, NULL, NULL, 10),
(62, 'IkxrloyTAuGivaLMjSh6w47mEtY9JU', 'Post by admin with feature img and protected asset', 'Post by admin with feature img and protected asset', 'post-by-admin-with-feature-img-and-protected-asset', 12, NULL, 1, '2018-01-24 06:33:01', '549a12206cee0118a9623bbd1d9c5bcb.jpg', 1516775581, 1516775581, '2018-01-24 07:08:42', NULL, 1),
(63, 'ynPqQjEIUKR1HN73OasV', 'Post with featured img and protected assets folder', 'Post with featured img and protected assets folder', 'post-with-featured-img-and-protected-assets-folder', 13, NULL, 1, '2018-01-24 07:10:39', '2131fd920bd31efa1b33629c32084542.jpg', 1516777839, NULL, '2018-01-24 07:10:50', NULL, 10),
(64, '10QsfJiujq9WBOGk3wcR', 'Post with php category by nobita', '<p>post with php category by nobita<br></p>', 'post-with-php-category-by-nobita', 12, '', 1, '2018-01-24 07:18:23', '4e7ff58fb8a95f3152586b9ddf0497bd.jpg', 1516778303, NULL, NULL, 1, 10),
(65, 'jchJm0rbBEgTRMAIk76PZzCDXfUS2Y', 'Trash post by admin', '<p>trash post by admin<br></p>', 'trash-post-by-admin', 13, NULL, NULL, '2018-01-25 10:28:27', '', 1516876107, 1516876107, NULL, 1, 1),
(66, 'XmTUZs9dGS1P8IQEWrwL4FaoMyHA07', 'Second post to trash', '<p>second post to trash<br></p>', 'second-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 12:52:59', '', 1516884779, 1516884779, NULL, 1, 1),
(67, '8nxEVrCzD5i1ZlbHy0LRsXvNk7AgTK', 'Third post to trash', '<p>third post to trash<br></p>', 'third-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 12:54:57', '', 1516884897, 1516884897, NULL, 1, 1),
(68, 'M4up3CN5S18at0IkUBDEyiTAwdYxrQ', 'Fourth post to trash', '<p>fourth post to trash<br></p>', 'fourth-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:21:40', '', 1516886500, 1516886500, NULL, 1, 1),
(69, 'xszpnVAvra4jbmcCyP9wBT2gRfl8Dq', 'Fifth post to trash', '<p>fifth post to trash<br></p>', 'fifth-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:22:15', '', 1516886535, 1516886535, NULL, 1, 1),
(70, 'xozvAQLqBWaVe9KbTdf4y2EDmZliwt', 'Sixth post to trash', '<p>sixth post to trash<br></p>', 'sixth-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:22:50', '', 1516886570, 1516886570, NULL, 1, 1),
(71, 'H09sN34fGAOKhZD2Tpyx6lbPeBumvz', 'Seventh post to trash', '<p>seventh post to trash<br></p>', 'seventh-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:22:59', '', 1516886579, 1516886579, NULL, 1, 1),
(72, 'iNAZTkjV9WhRDzevs1OfI7nBqGElmw', 'Eighth post to trash', '<p>eighth post to trash<br></p>', 'eighth-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:23:08', '', 1516886588, 1516886588, NULL, 1, 1),
(73, 'eV0QhDcYgLXK1z7MEBbn3Wd4Po6lFH', 'Ninth post to trash', '<p>ninth post to trash<br></p>', 'ninth-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:23:41', '', 1516886621, 1516886621, NULL, 1, 1),
(74, 'lHnUoEsbfa37KeVthkDw2xRB6mL8Nr', 'Tenth post to trash', '<p>tenth post to trash<br></p>', 'tenth-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:23:51', '', 1516886631, 1516886631, NULL, 1, 1),
(75, 'n23vomyx1PRfJ8YVMaTU65I7KG9Et4', 'Eleventh post to trash', '<p>eleventh post to trash<br></p>', 'eleventh-post-to-trash', 0, 'uncategorized', NULL, '2018-01-25 13:24:00', '', 1516886640, 1516886640, NULL, 1, 1);

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
(4, 51, 4, NULL, 1516088036),
(5, 50, 4, NULL, 1516088036),
(6, 52, 5, NULL, 1516088047),
(7, 51, 6, NULL, 1516088067),
(8, 51, 7, NULL, 1516088083),
(9, 50, 8, NULL, 1516088100),
(10, 52, 9, NULL, 1516088114),
(11, 50, 9, NULL, 1516088114),
(12, 51, 10, NULL, 1516088138),
(13, 50, 11, NULL, 1516088150),
(14, 52, 12, NULL, 1516088167),
(15, 51, 13, NULL, 1516088186),
(16, 51, 15, NULL, 1516088243),
(17, 50, 16, 10, 1516088299),
(18, 51, 17, 10, 1516088330),
(19, 51, 18, 10, 1516088599),
(20, 51, 19, NULL, 1516089947),
(21, 51, 20, NULL, 1516089993),
(22, 51, 21, NULL, 1516090017),
(23, 51, 22, NULL, 1516090041),
(24, 51, 23, NULL, 1516090407),
(25, 51, 24, NULL, 1516090438),
(26, 50, 24, NULL, 1516090438),
(27, 52, 25, NULL, 1516090487),
(28, 51, 26, NULL, 1516090508),
(29, 52, 27, NULL, 1516090572),
(30, 52, 28, NULL, 1516090596),
(31, 50, 28, NULL, 1516090596),
(32, 51, 29, NULL, 1516090616),
(33, 52, 30, NULL, 1516090651),
(34, 51, 31, NULL, 1516090671),
(35, 51, 32, 10, 1516098568),
(36, 50, 33, NULL, 1516099821),
(37, 52, 34, NULL, 1516099836),
(38, 51, 35, NULL, 1516099853),
(39, 50, 35, NULL, 1516099853),
(40, 50, 36, NULL, 1516099878),
(41, 52, 37, NULL, 1516099889),
(42, 52, 38, NULL, 1516099908),
(43, 50, 39, NULL, 1516180883),
(44, 50, 40, NULL, 1516180896),
(45, 51, 41, 10, 1516258245),
(46, 50, 42, 10, 1516258279),
(47, 51, 43, 10, 1516258293),
(48, 51, 44, 10, 1516258312),
(49, 51, 45, 10, 1516258328),
(50, 51, 46, 10, 1516258343),
(51, 51, 47, 10, 1516258356),
(52, 51, 48, 10, 1516259527),
(53, 51, 49, 10, 1516259544),
(54, 51, 50, 10, 1516259561),
(55, 51, 51, 10, 1516259577),
(56, 52, 52, 10, 1516263434),
(57, 52, 53, 10, 1516263449),
(58, 52, 54, 10, 1516263464),
(59, 52, 55, 10, 1516263501),
(60, 52, 56, 10, 1516263517),
(61, 52, 57, 10, 1516263529),
(62, 52, 58, 10, 1516263583),
(63, 52, 59, 10, 1516263604),
(64, 52, 60, 10, 1516263627),
(65, 52, 61, 10, 1516263651),
(68, 50, 62, 1, 1516777722),
(71, 50, 63, 10, 1516777850),
(72, 50, 64, 10, 1516778303),
(73, 52, 65, NULL, 1516876107);

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
(52, 'Client Sides', 'Client Sides', 'client-sides', '2017-12-26 23:47:00', '2018-01-11 09:12:53'),
(63, 'Vbn', 'Vvbn', 'vbn', '2018-01-22 10:47:21', NULL);

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
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'O6Bq9AxeYQ0JUrSBIbCwoO', 1268889823, 1516871558, 1, 'John', 'Cena', 'ADMIN', '0'),
(10, '::1', 'nobitanobi@gmail.com', '$2y$08$TYDKd28TkyhKl0unfA7I6u9DyoPFyx43CrC7wqRllqEbStx09rh6.', NULL, 'nobitanobi@gmail.com', NULL, NULL, NULL, NULL, 1514429082, 1516862283, 1, 'Nobita', 'Nobi', 'Doraemon', '');

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
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `post_term`
--
ALTER TABLE `post_term`
  MODIFY `term_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
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
