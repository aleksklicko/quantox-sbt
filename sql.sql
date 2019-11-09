-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: s683.loopia.se
-- Generation Time: Nov 09, 2019 at 06:37 PM
-- Server version: 10.2.26-MariaDB-log
-- PHP Version: 7.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daedalus_co_rs_db_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` int(10) NOT NULL,
  `board_name` varchar(80) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `board_name`) VALUES
(1, 'CSM'),
(2, 'CSMB');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(10) NOT NULL,
  `grade_name` varchar(40) COLLATE utf8_bin NOT NULL,
  `grade_board` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade_name`, `grade_board`) VALUES
(1, 'Programming', 1),
(2, 'Advance Intelligence', 1),
(3, 'Wireless Engineering', 1),
(4, 'Ground Combat Training', 1),
(5, 'Advance Profiling ', 2),
(6, 'Social Camouflage', 2),
(7, 'DIY Weaponry', 2),
(8, 'Tactical Diving', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sg_values`
--

CREATE TABLE `sg_values` (
  `id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `grade_id` int(10) NOT NULL,
  `grade_value` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sg_values`
--

INSERT INTO `sg_values` (`id`, `student_id`, `grade_id`, `grade_value`) VALUES
(1, 1, 1, 9),
(2, 1, 2, 8),
(3, 1, 3, 10),
(4, 1, 4, 6),
(5, 2, 1, 6),
(6, 2, 2, 7),
(7, 2, 3, 5),
(8, 2, 4, 7),
(9, 4, 7, 7),
(10, 5, 5, 10),
(11, 5, 6, 9),
(12, 5, 7, 9),
(13, 5, 8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) NOT NULL,
  `student_fname` varchar(20) COLLATE utf8_bin NOT NULL,
  `student_lname` varchar(20) COLLATE utf8_bin NOT NULL,
  `student_bio` text COLLATE utf8_bin NOT NULL,
  `student_img` text COLLATE utf8_bin NOT NULL,
  `student_board` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_fname`, `student_lname`, `student_bio`, `student_img`, `student_board`) VALUES
(1, 'Alex', 'Klicko', 'Look, just because I don\'t be givin\' no man a foot massage don\'t make it right for Marsellus to throw Antwone into a glass motherfuckin\' house, fuckin\' up the way the nigger talks. Motherfucker do that shit to me, he better paralyze my ass, \'cause I\'ll kill the motherfucker, know what I\'m sayin\'?', 'default.gif', 1),
(2, 'Tom', 'Sojer', 'Thomas Sawyer (/ˈsɔːjər/) is the title character of the Mark Twain novel The Adventures of Tom Sawyer (1876). He appears in three other novels by Twain: Adventures of Huckleberry Finn (1884), Tom Sawyer Abroad (1894), and Tom Sawyer, Detective (1896). Sawyer also appears in at least three unfinished Twain works, Huck and Tom Among the Indians, Schoolhouse Hill and Tom Sawyer\'s Conspiracy. While all three uncompleted works were posthumously published, only Tom Sawyer\'s Conspiracy has a complete plot, as Twain abandoned the other two works after finishing only a few chapters.', 'default.gif', 1),
(3, 'Elon', 'Musk', 'Elon Reeve Musk is a South African-born American entrepreneur and businessman who founded X.com in 1999 (which later became PayPal), SpaceX in 2002 and Tesla Motors in 2003. Musk became a multimillionaire in his late 20s when he sold his start-up company, Zip2, to a division of Compaq Computers', 'default.img', 2),
(4, 'Natasha', 'Romanova', 'Natasha was born in Stalingrad (now Volgograd), Russia. The first and best-known Black Widow is a Russian agent trained as a spy, martial artist, and sniper, and outfitted with an arsenal of high-tech weaponry, including a pair of wrist-mounted energy weapons dubbed her \"Widow\'s Bite\". She wears no costume during her first few appearances but simply evening wear and a veil. Romanova eventually defects to the U.S. for reasons that include her love for the reluctant-criminal turned superhero archer, Hawkeye.', 'default.gif', 2),
(5, 'Nikola', 'Tesla', 'Born and raised in the Austrian Empire, Tesla studied engineering and physics in the 1870s without receiving a degree, and gained practical experience in the early 1880s working in telephony and at Continental Edison in the new electric power industry. He emigrated in 1884 to the United States, where he would become a naturalized citizen. He worked for a short time at the Edison Machine Works in New York City before he struck out on his own. With the help of partners to finance and market his ideas, Tesla set up laboratories and companies in New York to develop a range of electrical and mechanical devices. His alternating current (AC) induction motor and related polyphase AC patents, licensed by Westinghouse Electric in 1888, earned him a considerable amount of money and became the cornerstone of the polyphase system which that company would eventually market.', 'default.gif', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(40) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `status` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'student'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sg_values`
--
ALTER TABLE `sg_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sg_values`
--
ALTER TABLE `sg_values`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
