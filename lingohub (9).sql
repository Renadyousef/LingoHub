-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 10:59 PM
-- Server version: 11.3.2-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lingohub`
--

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `LanguageName` varchar(100) NOT NULL,
  `LanguageCode` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`LanguageName`, `LanguageCode`) VALUES
('Afrikaans', 'ZA'),
('Albanian', 'AL'),
('Arabic', 'SA'),
('Armenian', 'AM'),
('Basque', 'ES'),
('Bengali', 'BD'),
('Bulgarian', 'BG'),
('Cambodian', 'KH'),
('Catalan', 'ES'),
('Chinese (Mandarin)', 'CN'),
('Croatian', 'HR'),
('Czech', 'CZ'),
('Danish', 'DK'),
('Dutch', 'NL'),
('English', 'GB'),
('Estonian', 'EE'),
('Fiji', 'FJ'),
('Finnish', 'FI'),
('French', 'FR'),
('Georgian', 'GE'),
('German', 'DE'),
('Greek', 'GR'),
('Gujarati', 'IN'),
('Hebrew', 'IL'),
('Hindi', 'IN'),
('Hungarian', 'HU'),
('Icelandic', 'IS'),
('Indonesian', 'ID'),
('Irish', 'IE'),
('Italian', 'IT'),
('Japanese', 'JP'),
('Javanese', 'ID'),
('Korean', 'KR'),
('Latin', 'VA'),
('Latvian', 'LV'),
('Lithuanian', 'LT'),
('Macedonian', 'MK'),
('Malay', 'MY'),
('Malayalam', 'IN'),
('Maltese', 'MT'),
('Maori', 'NZ'),
('Marathi', 'IN'),
('Mongolian', 'MN'),
('Nepali', 'NP'),
('Norwegian', 'NO'),
('Persian', 'IR'),
('Polish', 'PL'),
('Portuguese', 'PT'),
('Punjabi', 'IN'),
('Quechua', 'PE'),
('Romanian', 'RO'),
('Russian', 'RU'),
('Samoan', 'WS'),
('Serbian', 'RS'),
('Slovak', 'SK'),
('Slovenian', 'SI'),
('Spanish', 'ES'),
('Swahili', 'TZ'),
('Swedish', 'SE'),
('Tamil', 'IN'),
('Tatar', 'RU'),
('Telugu', 'IN'),
('Thai', 'TH'),
('Tibetan', 'CN'),
('Tonga', 'TO'),
('Turkish', 'TR'),
('Ukrainian', 'UA'),
('Urdu', 'PK'),
('Uzbek', 'UZ'),
('Vietnamese', 'VN'),
('Welsh', 'GB'),
('Xhosa', 'ZA');

-- --------------------------------------------------------

--
-- Table structure for table `learner`
--

CREATE TABLE `learner` (
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `learnerID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(25) NOT NULL,
  `city` varchar(30) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'defultpic.jpg',
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `learner`
--

INSERT INTO `learner` (`firstName`, `lastName`, `learnerID`, `email`, `password`, `city`, `photo`, `location`) VALUES
('afnan', 'alonazi', 1, 'afalonazi4@gmail.com', '12345678A!', 'Riyadh', 'femalelearner1.jpg', 'alsahafa , alwaten'),
('dana', 'alkhamis', 2, 'alkhamis2@gmail.com', '12345678A!', '', 'defultpic.jpg', ''),
('sara', 'ahmed', 3, 'sar@gmail.com', '1234567A!', 'Riyadh', '', 'khkjh');

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE `partner` (
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `partnerID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` char(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'defultpic.jpg',
  `bio` text NOT NULL,
  `gender` varchar(6) NOT NULL,
  `age` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`firstName`, `lastName`, `partnerID`, `email`, `phone`, `password`, `city`, `photo`, `bio`, `gender`, `age`) VALUES
('Amanda', 'Davis', 1, 'amandalingo@gmail.com', '0556199919', '12345678A!', 'riyadh', 'femalepartner1.jpg', 'has dedicated 15 years of teaching German. Fluent in the language with a wealth of experience, brings a unique blend of expertise and enthusiasm to her classroom.', 'female', '25'),
('Lamia', 'Saad', 2, 'LamiaSaad@gmail.com', '0532452870', '12345678A!', 'Jeddah', 'femalepartner2.jpg', 'With over 5 years of experience teaching Arabic to students from diverse backgrounds, I bring a deep love for my native language and a commitment to helping learners achieve their language goals. Born and raised in Riyadh, I have a profound understanding of Arabic linguistics, dialects, and cultural nuances, which I love to share with my students.', 'female', '29');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `RequestID` int(11) NOT NULL,
  `LanguageName` varchar(100) NOT NULL,
  `learnerID` int(100) NOT NULL,
  `partnerID` int(11) NOT NULL,
  `level` varchar(30) NOT NULL,
  `preferredSchedule` datetime NOT NULL,
  `sessionDuration` varchar(100) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'pending',
  `comment` text NOT NULL DEFAULT 'no comment added',
  `post_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`RequestID`, `LanguageName`, `learnerID`, `partnerID`, `level`, `preferredSchedule`, `sessionDuration`, `status`, `comment`, `post_time`) VALUES
(3, 'German', 1, 1, 'Beginner', '2024-05-01 15:00:00', '1 hour', 'accepted', 'no comment added', '2024-04-30 16:23:47'),
(18, 'Arabic', 2, 2, 'Advanced', '2024-05-15 08:00:00', '30 minutes', 'accepted', 'Advanced Arabic speaker eager to embark on a journey of language learning and cultural exploration in Arabic.', '2024-05-06 21:19:14'),
(19, 'Arabic', 1, 2, 'Advanced', '2024-05-14 09:30:00', '50 minutes', 'pending', 'Advanced Arabic speaker eager to embark on a journey of language learning and cultural exploration in Arabic.', '2024-05-06 21:21:47'),
(26, 'Arabic', 1, 2, 'Beginner', '2024-05-14 16:38:00', '30 minutes', 'pending', 'jbjbj', '2024-05-07 20:38:18'),
(27, 'Arabic', 2, 2, 'Advanced', '2024-05-15 08:24:00', '30 minutes', 'rejected', 'hi i want to learn arabic', '2024-05-07 20:43:53'),
(28, 'Arabic', 1, 2, 'Intermediate', '2024-05-15 08:24:00', '30 minutes', 'pending', '', '2024-05-07 20:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `sessionID` int(11) NOT NULL,
  `learnerfname` varchar(25) NOT NULL,
  `learnLname` varchar(25) NOT NULL,
  `partnerID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` double NOT NULL,
  `posted_rate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewID`, `sessionID`, `learnerfname`, `learnLname`, `partnerID`, `comment`, `rating`, `posted_rate`) VALUES
(1, 1, 'afnan', 'alonazi', 1, 'good', 3, '2024-05-04 18:58:01');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `partnerEmail` varchar(100) NOT NULL,
  `langugeName` varchar(100) NOT NULL,
  `level` varchar(30) NOT NULL,
  `price` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`partnerEmail`, `langugeName`, `level`, `price`) VALUES
('amandalingo@gmail.com', 'German', 'Advanced', 250),
('LamiaSaad@gmail.com', 'Arabic', 'Advanced', 150);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `sessionID` int(11) NOT NULL,
  `RequestID_s` int(11) NOT NULL,
  `partnerID` int(11) NOT NULL,
  `learnerID` int(11) NOT NULL,
  `startTime` time NOT NULL,
  `language` varchar(25) NOT NULL,
  `Date` date NOT NULL,
  `duration` time NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`sessionID`, `RequestID_s`, `partnerID`, `learnerID`, `startTime`, `language`, `Date`, `duration`, `status`) VALUES
(1, 3, 1, 1, '16:00:00', 'German', '2024-05-02', '03:00:00', 'previous');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`LanguageName`);

--
-- Indexes for table `learner`
--
ALTER TABLE `learner`
  ADD PRIMARY KEY (`learnerID`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`partnerID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `delete_learner` (`learnerID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD UNIQUE KEY `partnerEmail` (`partnerEmail`,`langugeName`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sessionID`),
  ADD KEY `delete_partner` (`partnerID`),
  ADD KEY `delete_leaner` (`learnerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learner`
--
ALTER TABLE `learner`
  MODIFY `learnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partner`
--
ALTER TABLE `partner`
  MODIFY `partnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `delete_learner` FOREIGN KEY (`learnerID`) REFERENCES `learner` (`learnerID`);

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `delete_leaner` FOREIGN KEY (`learnerID`) REFERENCES `learner` (`learnerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_partner` FOREIGN KEY (`partnerID`) REFERENCES `partner` (`partnerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
