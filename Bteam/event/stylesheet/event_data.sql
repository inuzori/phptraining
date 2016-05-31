-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 5 月 19 日 16:51
-- サーバのバージョン： 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `event_data`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `attends`
--

CREATE TABLE IF NOT EXISTS `attends` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- テーブルのデータのダンプ `attends`
--

INSERT INTO `attends` (`id`, `user_id`, `event_id`) VALUES
(1, 1, 1),
(3, 2, 1),
(4, 3, 1),
(5, 1, 2),
(6, 2, 2),
(7, 7, 3),
(8, 8, 3),
(9, 7, 4),
(10, 8, 4),
(11, 9, 5),
(12, 11, 5);

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE IF NOT EXISTS `events` (
`id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `place` varchar(255) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `detail` text,
  `registered_by` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `place`, `group_id`, `detail`, `registered_by`, `created`) VALUES
(1, 'HTML5勉強会', '2016-06-15 19:00:00', '2016-06-15 20:00:00', '第1会議室', 2, 'HTML5の勉強会を行います。\r\n対象はHTML4.01あるいはXHTML1.0を知っていて、JavaScriptの基本的なコーディングができる方です。', 1, '2016-05-19 16:17:22'),
(2, '技術部懇親会', '2016-06-09 18:30:00', '2016-06-09 20:30:00', '新宿魚源', 2, 'おさかなおいしい', 7, '2016-05-19 16:17:22'),
(3, '営業部懇親会', '2016-06-07 18:30:00', '2016-06-07 20:30:00', '新宿鳥処', 1, 'とりおいしい', 1, '2016-05-19 16:20:06'),
(4, '営業部勉強会', '2016-06-07 17:00:00', '2016-06-07 18:00:00', '第3会議室', 1, '会議つらい', 8, '2016-05-19 16:20:06'),
(5, 'サッカー部練習', '2016-06-04 09:00:00', '2016-06-04 12:00:00', '森林公園サッカー場', NULL, NULL, 11, '2016-05-19 16:21:33');

-- --------------------------------------------------------

--
-- テーブルの構造 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- テーブルのデータのダンプ `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, '営業部'),
(2, '技術部'),
(3, '人事部'),
(4, '総務部');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login_id` varchar(50) NOT NULL,
  `login_pass` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `login_id`, `login_pass`, `name`, `type_id`, `group_id`, `created`) VALUES
(1, 'satousa', '1234', '佐藤三郎', 2, 2, '2016-05-19 16:24:42'),
(2, 'yamadata', '1234', '山田太郎', 1, 2, '2016-05-19 16:35:54'),
(3, 'suzukizi', '1234', '鈴木次郎', 1, 2, '2016-05-19 16:35:54'),
(7, 'sugiyamata', '1234', '杉山太一', 2, 1, '2016-05-19 16:31:51'),
(8, 'umedashi', '1234', '梅田伸二', 1, 1, '2016-05-19 16:28:35'),
(9, 'satougo', '1234', '佐藤五郎', 1, 4, '2016-05-19 16:25:48'),
(10, 'tanakaha', '1234', '田中花子', 1, 4, '2016-05-19 16:25:48'),
(11, 'mikamita', '1234', '三上辰夫', 1, 3, '2016-05-19 16:24:42');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
`id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- テーブルのデータのダンプ `user_types`
--

INSERT INTO `user_types` (`id`, `name`) VALUES
(1, '一般ユーザー'),
(2, '管理ユーザー');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attends`
--
ALTER TABLE `attends`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login_id` (`login_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attends`
--
ALTER TABLE `attends`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
