-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 29, 2024 at 06:30 AM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flashify`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `score` float NOT NULL DEFAULT 0,
  `deck_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

CREATE TABLE `decks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `owner` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_favorite` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `decks`
--

INSERT INTO `decks` (`id`, `name`, `description`, `is_public`, `owner`, `created_at`, `is_favorite`) VALUES
(31, 'JavaScript', 'I love JS!', 0, 1, '2024-08-28 22:23:47', 0),
(32, 'Python', 'A versatile interpreted language with easy syntax. Its quite slow though. ', 0, 1, '2024-08-28 22:39:52', 0),
(33, 'Java', 'Compiled and Interpreted, Class based.', 0, 1, '2024-08-28 23:33:38', 0),
(35, 'C++', 'Such a pain to work with!', 0, 1, '2024-08-28 23:34:01', 0),
(42, 'Kotlin', 'Jetbrains language made as an alternative for Java', 0, 1, '2024-08-29 09:39:40', 0),
(47, 'Golang', 'Cure gopher made by Google!', 0, 1, '2024-08-29 11:24:35', 0),
(50, 'TypeScript', 'TypeScript is a superset of JavaScript', 0, 1, '2024-08-29 11:53:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `deck_likes`
--

CREATE TABLE `deck_likes` (
  `id` int(11) NOT NULL,
  `deck_link_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `liked_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deck_links`
--

CREATE TABLE `deck_links` (
  `id` int(11) NOT NULL,
  `deck_id` int(11) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `link_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `cards_reviewed` int(11) NOT NULL DEFAULT 0,
  `cards_successful` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Shone Binu', 'shonebinualias@gmail.com', '$2y$10$7vRx4gdtwI7e/D2kIi3v8ODJkKRvTZp/QVh9CzUzLg/vQ5fSs9iDO', '2024-08-22 18:07:53'),
(10, 'Binu Alias', 'binualiaskm@gmail.com', '$2y$10$2LFd9y3SJXpibkIDtshrc.WYn45KmDrpYp2M5ZsNB0QdphDFRV1em', '2024-08-28 15:23:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `deck_likes`
--
ALTER TABLE `deck_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deck_links`
--
ALTER TABLE `deck_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link_code` (`link_code`),
  ADD KEY `deck_id` (`deck_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `decks`
--
ALTER TABLE `decks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `deck_likes`
--
ALTER TABLE `deck_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deck_links`
--
ALTER TABLE `deck_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`deck_id`) REFERENCES `decks` (`id`);

--
-- Constraints for table `decks`
--
ALTER TABLE `decks`
  ADD CONSTRAINT `decks_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`);

--
-- Constraints for table `deck_links`
--
ALTER TABLE `deck_links`
  ADD CONSTRAINT `deck_links_ibfk_1` FOREIGN KEY (`deck_id`) REFERENCES `decks` (`id`),
  ADD CONSTRAINT `deck_links_ibfk_2` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
