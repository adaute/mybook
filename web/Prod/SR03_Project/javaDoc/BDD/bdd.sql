-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 21, 2019 at 09:00 AM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `projet_sr03`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `label` text NOT NULL,
  `idquestion` int(11) NOT NULL,
  `answer_order` int(11) NOT NULL,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `label`, `idquestion`, `answer_order`, `isactive`) VALUES
(1, 'réponse 1', 1, 1, 1),
(2, 'réponse 2', 1, 2, 1),
(3, 'réponse 3', 1, 3, 1),
(4, 'réponse 4', 1, 4, 1),
(5, 'réponse 12', 2, 1, 1),
(6, 'réponse 22', 2, 2, 1),
(25, 'reponse1', 10, 1, 1),
(26, 'reponse2', 10, 2, 1),
(27, 'reponse12', 11, 1, 1),
(28, 'reponse22', 11, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `question_order` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  `answerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `question_order`, `surveyid`, `isactive`, `answerid`) VALUES
(1, 'Ma question n°1', 1, 1, 1, 4),
(2, 'Question 2', 2, 1, 1, 5),
(10, 'Ma question n°1', 1, 5, 1, 26),
(11, 'Ma question n°2', 2, 5, 1, 28);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject`) VALUES
(1, 'Nouveau'),
(2, 'new2');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`id`, `title`, `subject_id`, `isactive`) VALUES
(1, 'Questionnaire', 1, 1),
(5, 'Mon questionnaire 2', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `trackrecord`
--

CREATE TABLE `trackrecord` (
  `id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `delay` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `surveyid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trackrecord`
--

INSERT INTO `trackrecord` (`id`, `score`, `delay`, `userid`, `surveyid`) VALUES
(2, 0, 2, 2, 1),
(8, 2, 8, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `firstname` varchar(256) NOT NULL,
  `lastname` varchar(256) NOT NULL,
  `compagny` varchar(256) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `createdat` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `statutuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `firstname`, `lastname`, `compagny`, `phone`, `createdat`, `status`, `statutuser`) VALUES
(1, 'admin@etu.utc.fr', 'SNd2bRyJ2Npyfct0PT7Jyl00NLRQVbkzYZwFmJbuqlDx0lZLEafOyg==', 'Admin', 'Agnel', 'UTC', '0000000000', '2019-05-09', 1, 1),
(2, 'trainee@etu.utc.fr', '8EZz35cbTBojX7BGDZ3oDQej+MUVG0Iv5b2L7Ue0+EW1zaVOf+QGlg==', 'trainee', 'trainee', 'UTC', '0000000000', '2019-05-09', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userchoice`
--

CREATE TABLE `userchoice` (
  `id` int(11) NOT NULL,
  `answerid` int(11) NOT NULL,
  `recordid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userchoice`
--

INSERT INTO `userchoice` (`id`, `answerid`, `recordid`, `questionid`) VALUES
(1, 3, 2, 1),
(2, 6, 2, 2),
(14, 26, 8, 10),
(15, 28, 8, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question` (`idquestion`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_survey` (`surveyid`),
  ADD KEY `fk_answer` (`answerid`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subject` (`subject_id`);

--
-- Indexes for table `trackrecord`
--
ALTER TABLE `trackrecord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`userid`),
  ADD KEY `fk_surveyTrack` (`surveyid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userchoice`
--
ALTER TABLE `userchoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answerid_fk` (`answerid`),
  ADD KEY `question_k` (`questionid`),
  ADD KEY `record_id` (`recordid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trackrecord`
--
ALTER TABLE `trackrecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `userchoice`
--
ALTER TABLE `userchoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`idquestion`) REFERENCES `question` (`id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_survey` FOREIGN KEY (`surveyid`) REFERENCES `survey` (`id`);

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`);

--
-- Constraints for table `trackrecord`
--
ALTER TABLE `trackrecord`
  ADD CONSTRAINT `fk_surveyTrack` FOREIGN KEY (`surveyid`) REFERENCES `survey` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`);

--
-- Constraints for table `userchoice`
--
ALTER TABLE `userchoice`
  ADD CONSTRAINT `answerid_fk` FOREIGN KEY (`answerid`) REFERENCES `answer` (`id`),
  ADD CONSTRAINT `question_k` FOREIGN KEY (`questionid`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `record_id` FOREIGN KEY (`recordid`) REFERENCES `trackrecord` (`id`);
