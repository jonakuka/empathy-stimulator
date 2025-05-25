-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 11:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbjona`
--

-- --------------------------------------------------------

--
-- Table structure for table `advice_wall`
--

CREATE TABLE `advice_wall` (
  `id` int(11) NOT NULL,
  `advice` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advice_wall`
--

INSERT INTO `advice_wall` (`id`, `advice`, `created_at`) VALUES
(1, 'i saw somone strugling', '2025-05-25 08:31:28'),
(2, 'Niher jom ni shume keq kur e kom pa dikon tu strugle', '2025-05-25 09:49:08'),
(3, 'jam olti nje djal 14 vjeqar e kam moter suelen qe eshte nje vajze shume e mire ma e mire se une', '2025-05-25 11:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `anonymous_advice_wall`
--

CREATE TABLE `anonymous_advice_wall` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feeling` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `advice_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `advice_id`, `comment`, `created_at`) VALUES
(1, 2, 'kuku edhe une bre ', '2025-05-25 09:49:19'),
(2, 2, 'podepo edhe unnee\r\n', '2025-05-25 09:49:37'),
(3, 3, 'pernime a ', '2025-05-25 11:27:41'),
(4, 3, 'rtrtr', '2025-05-25 12:24:43'),
(5, 3, 'er', '2025-05-25 13:18:11'),
(6, 3, 'sass', '2025-05-25 13:20:26');

-- --------------------------------------------------------

--
-- Table structure for table `empathy_art_submissions`
--

CREATE TABLE `empathy_art_submissions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('photo','painting','quote') NOT NULL,
  `description` text NOT NULL,
  `image_url` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empathy_quiz_options`
--

CREATE TABLE `empathy_quiz_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empathy_quiz_options`
--

INSERT INTO `empathy_quiz_options` (`id`, `question_id`, `option_text`, `score`) VALUES
(1, 1, 'I listen carefully and offer support', 5),
(2, 1, 'I try to give advice but don’t always listen', 3),
(3, 1, 'I change the subject', 0),
(4, 2, 'Always consider others’ feelings', 5),
(5, 2, 'Sometimes consider others’ feelings', 3),
(6, 2, 'Rarely think about others’ feelings', 0),
(7, 3, 'I try to comfort them and listen', 5),
(8, 3, 'I give advice to fix their problem', 3),
(9, 3, 'I avoid getting involved', 0),
(10, 4, 'I try to calmly discuss and understand their point of view', 5),
(11, 4, 'I argue to prove my point', 1),
(12, 4, 'I avoid the conflict altogether', 2),
(13, 5, 'Yes, I often imagine how others feel', 5),
(14, 5, 'Sometimes, but it depends on the situation', 3),
(15, 5, 'No, it’s hard for me to imagine others’ feelings', 0),
(16, 6, 'Yes, I empathize deeply with characters', 5),
(17, 6, 'Sometimes, but mostly I focus on the story', 3),
(18, 6, 'Not really, I don’t connect with characters emotionally', 0),
(19, 7, 'I offer help and check in on them', 5),
(20, 7, 'I tell them to manage their stress better', 2),
(21, 7, 'I don’t usually notice if they’re stressed', 0),
(22, 8, 'I feel genuinely happy and celebrate with them', 5),
(23, 8, 'I feel a bit jealous but happy overall', 2),
(24, 8, 'I feel indifferent or annoyed', 0),
(25, 9, 'Yes, I try to understand before forming opinions', 5),
(26, 9, 'Sometimes, but I judge quickly', 2),
(27, 9, 'No, I judge people easily', 0),
(28, 10, 'Very often—I make an effort to understand other perspectives', 5),
(29, 10, 'Sometimes, if I have time', 3),
(30, 10, 'Rarely or never', 0);

-- --------------------------------------------------------

--
-- Table structure for table `empathy_quiz_questions`
--

CREATE TABLE `empathy_quiz_questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empathy_quiz_questions`
--

INSERT INTO `empathy_quiz_questions` (`id`, `question`) VALUES
(1, 'How do you respond when a friend shares a personal problem?'),
(2, 'How often do you consider others’ feelings before making decisions?'),
(3, 'When someone is upset, how do you usually react?'),
(4, 'How do you handle disagreements with friends or family?'),
(5, 'Do you find it easy to imagine how others feel in difficult situations?'),
(6, 'When watching movies or reading books, do you connect with the characters’ emotions?'),
(7, 'How do you support coworkers who seem stressed or overwhelmed?'),
(8, 'When someone tells you about their success, how do you feel?'),
(9, 'Do you try to understand the reasons behind someone’s behavior before judging them?'),
(10, 'How often do you put yourself in someone else’s shoes to understand their perspective?');

-- --------------------------------------------------------

--
-- Table structure for table `empathy_quiz_submissions`
--

CREATE TABLE `empathy_quiz_submissions` (
  `id` int(11) NOT NULL,
  `q1` int(11) DEFAULT NULL CHECK (`q1` between 1 and 5),
  `q2` int(11) DEFAULT NULL CHECK (`q2` between 1 and 5),
  `q3` int(11) DEFAULT NULL CHECK (`q3` between 1 and 5),
  `q4` int(11) DEFAULT NULL CHECK (`q4` between 1 and 5),
  `q5` int(11) DEFAULT NULL CHECK (`q5` between 1 and 5),
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `feeling` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'jona', 'jonakuka123@gmail.com', '$2y$10$jp88fH5URzf.QVLLdd/VVOW9bQGSTAbm56n5b03UvS8SUmRsbS9Ca'),
(2, 'olti', 'oltikajtazi@gmail.com', '$2y$10$qSjuxRn83yjJdsjXp1yIAu8SepkSi0a/vdSO9DE0mzzJgEXo0ACBu'),
(3, 'eliona', 'eliona@gmail.com', '$2y$10$Rl6JJUbeRZfV/A0jMBlHi.WCoTptZC5HqNgSj39r/7zZ.vrSR8m9i');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advice_wall`
--
ALTER TABLE `advice_wall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anonymous_advice_wall`
--
ALTER TABLE `anonymous_advice_wall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advice_id` (`advice_id`);

--
-- Indexes for table `empathy_art_submissions`
--
ALTER TABLE `empathy_art_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empathy_quiz_options`
--
ALTER TABLE `empathy_quiz_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `empathy_quiz_questions`
--
ALTER TABLE `empathy_quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empathy_quiz_submissions`
--
ALTER TABLE `empathy_quiz_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advice_wall`
--
ALTER TABLE `advice_wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `anonymous_advice_wall`
--
ALTER TABLE `anonymous_advice_wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `empathy_art_submissions`
--
ALTER TABLE `empathy_art_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empathy_quiz_options`
--
ALTER TABLE `empathy_quiz_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `empathy_quiz_questions`
--
ALTER TABLE `empathy_quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `empathy_quiz_submissions`
--
ALTER TABLE `empathy_quiz_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`advice_id`) REFERENCES `advice_wall` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `empathy_quiz_options`
--
ALTER TABLE `empathy_quiz_options`
  ADD CONSTRAINT `empathy_quiz_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `empathy_quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
