-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2024 at 05:59 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eva`
--

-- --------------------------------------------------------

--
-- Table structure for table `acadmaicc`
--

DROP TABLE IF EXISTS `acadmaicc`;
CREATE TABLE IF NOT EXISTS `acadmaicc` (
  `Id_AcadmicC` int NOT NULL AUTO_INCREMENT,
  `Date_of_year` date NOT NULL,
  `status_year` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_AcadmicC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `avg`
--

DROP TABLE IF EXISTS `avg`;
CREATE TABLE IF NOT EXISTS `avg` (
  `Id_Avg` int NOT NULL AUTO_INCREMENT,
  `Avg_lecturer` float NOT NULL,
  `Avg_course` float NOT NULL,
  `Id_evaluation` int NOT NULL,
  PRIMARY KEY (`Id_Avg`),
  UNIQUE KEY `Avg_lecturer` (`Avg_lecturer`,`Avg_course`,`Id_evaluation`),
  KEY `Id_evaluation` (`Id_evaluation`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `avg`
--

INSERT INTO `avg` (`Id_Avg`, `Avg_lecturer`, `Avg_course`, `Id_evaluation`) VALUES
(1, 3.2, 4.5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `Id_course` int NOT NULL AUTO_INCREMENT,
  `name_course` varchar(50) NOT NULL,
  `type_course` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_course`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Id_course`, `name_course`, `type_course`) VALUES
(1, 'AI', 'Theory'),
(2, 'AI', 'Lab'),
(16, 'program 1', 'Theory'),
(17, 'program 1', 'lab');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `Id_evaluation` int NOT NULL AUTO_INCREMENT,
  `Id_question_lecturer` int NOT NULL,
  `Id_question_course` int NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`Id_evaluation`),
  UNIQUE KEY `Id_question_lecturer` (`Id_question_lecturer`,`Id_question_course`),
  KEY `Id_question_course` (`Id_question_course`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`Id_evaluation`, `Id_question_lecturer`, `Id_question_course`, `date_time`) VALUES
(1, 1, 1, '2024-03-01 20:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `Id_faculty` int NOT NULL AUTO_INCREMENT,
  `name_faculty` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`Id_faculty`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Id_faculty`, `name_faculty`) VALUES
(1, 'Business and Finance'),
(2, 'Multimedia and Creative Technology'),
(3, 'Computer Science and Information Technology'),
(4, 'Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
CREATE TABLE IF NOT EXISTS `lecturer` (
  `Id_lecturer` int NOT NULL AUTO_INCREMENT,
  `name_lecturer` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_lecturer`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`Id_lecturer`, `name_lecturer`) VALUES
(1, 'Dr. Amin'),
(2, 'Mr. Hani'),
(4, 'Dr. Abdulrahman'),
(5, 'Dr. Hesham'),
(6, 'Dr. Malk Al-Gabri');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
CREATE TABLE IF NOT EXISTS `major` (
  `Id_major` int NOT NULL AUTO_INCREMENT,
  `name_major` varchar(50) NOT NULL,
  `Id_faculty` int NOT NULL,
  PRIMARY KEY (`Id_major`),
  KEY `Id_faculty` (`Id_faculty`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`Id_major`, `name_major`, `Id_faculty`) VALUES
(1, 'INTERNATIONAL BUSINESS', 1),
(2, 'OIL AND GAS MANAGEMENT', 1),
(3, 'ACCOUNTING', 1),
(4, 'BANKING AND FINANCIAL SCIENCES', 1),
(5, 'MARKETING', 1),
(6, 'MULTIMEDIA', 2),
(7, 'BUSINESS INFORMATION TECHNOLOGY', 3),
(8, 'COMPUTER SCIENCE', 3),
(9, 'CYBER SECURITY', 3),
(10, 'ARTIFICIAL INTELLIGENCE AND DATA SCIENCE', 3),
(11, 'OIL & GAS ENGINEERING', 4),
(12, 'ARCHITECTURAL ENGINEERING', 4),
(13, 'CIVIL ENGINEERING', 4),
(14, 'INTERIOR DESIGN', 4);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
CREATE TABLE IF NOT EXISTS `plan` (
  `Id_plan` int NOT NULL AUTO_INCREMENT,
  `Id_semester` int NOT NULL,
  `Id_planDetail` int NOT NULL,
  PRIMARY KEY (`Id_plan`),
  UNIQUE KEY `Id_planDetail` (`Id_planDetail`) USING BTREE,
  UNIQUE KEY `Id_semester` (`Id_semester`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `plandetail`
--

DROP TABLE IF EXISTS `plandetail`;
CREATE TABLE IF NOT EXISTS `plandetail` (
  `Id_planDetail` int NOT NULL AUTO_INCREMENT,
  `Id_faculty` int NOT NULL,
  `Id_major` int NOT NULL,
  `Id_course` int NOT NULL,
  `Id_student` int NOT NULL,
  `Id_semeter` int NOT NULL,
  PRIMARY KEY (`Id_planDetail`),
  UNIQUE KEY `Id_faculty` (`Id_faculty`,`Id_major`,`Id_course`,`Id_student`,`Id_semeter`),
  KEY `Id_semeter` (`Id_semeter`),
  KEY `Id_major` (`Id_major`),
  KEY `Id_course` (`Id_course`),
  KEY `Id_student` (`Id_student`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `question_course`
--

DROP TABLE IF EXISTS `question_course`;
CREATE TABLE IF NOT EXISTS `question_course` (
  `Id_question_course` int NOT NULL AUTO_INCREMENT,
  `text_question_course` varchar(150) NOT NULL,
  PRIMARY KEY (`Id_question_course`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `question_course`
--

INSERT INTO `question_course` (`Id_question_course`, `text_question_course`) VALUES
(1, 'Course lectures are well planned and structured.'),
(2, 'Course content provides an up to date information.'),
(3, 'Course content provides a comprehensive insight.'),
(4, 'Assignments/projects assigned contributes to enhancing practical skills.'),
(5, 'Course marks are fairly set.'),
(6, 'Examinations/ assignments/projects provided highly reflect the course content.'),
(7, 'The course is highly relative to the field of specialization.');

-- --------------------------------------------------------

--
-- Table structure for table `question_lecturer`
--

DROP TABLE IF EXISTS `question_lecturer`;
CREATE TABLE IF NOT EXISTS `question_lecturer` (
  `Id_question_lecturer` int NOT NULL AUTO_INCREMENT,
  `text_qestion_lecturer` varchar(150) NOT NULL,
  PRIMARY KEY (`Id_question_lecturer`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `question_lecturer`
--

INSERT INTO `question_lecturer` (`Id_question_lecturer`, `text_qestion_lecturer`) VALUES
(1, 'Lecturer gives clear explanation on course objectives, syllabus and evaluation.'),
(2, '----------------------------'),
(3, '-------------------'),
(4, '-----------------'),
(5, 'Lecturer teaches at right speed, clear and understandable voice.'),
(6, 'Lecturer is approachable & encourages student to seek help.'),
(7, '------------------'),
(8, 'Lecturer conducts quizzes & test at good timing.'),
(9, 'Lecturer encourages class participation & discussion.'),
(10, 'Lecturer has the confidence to deliver the lectures/ tutorials.'),
(11, 'Lecturer is punctual for class and the time is well used.'),
(12, 'Lecturer conducts the lessons in English.'),
(13, 'Lecturer uses examples/ illustrations when explaining difficult topics.'),
(14, 'Lecturer distributes knowledge & skills to students rather than preparing them for exams only.');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `Id_result` int NOT NULL AUTO_INCREMENT,
  `Id_evaluation` int NOT NULL,
  `Id_Avg` int NOT NULL,
  `Id_plan` int NOT NULL,
  `Id_lecturer` int NOT NULL,
  `Id_user` int NOT NULL,
  `Id_AcadmicC` int NOT NULL,
  `Id_course` int NOT NULL,
  PRIMARY KEY (`Id_result`),
  UNIQUE KEY `Id_evaluation` (`Id_evaluation`,`Id_Avg`,`Id_plan`,`Id_lecturer`,`Id_user`,`Id_AcadmicC`,`Id_course`),
  KEY `Id_plan` (`Id_plan`),
  KEY `Id_course` (`Id_course`),
  KEY `Id_Avg` (`Id_Avg`),
  KEY `Id_AcadmicC` (`Id_AcadmicC`),
  KEY `Id_lecturer` (`Id_lecturer`),
  KEY `Id_user` (`Id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `Id_semester` int NOT NULL AUTO_INCREMENT,
  `name_semester` varchar(50) NOT NULL,
  `Id_course` int NOT NULL,
  PRIMARY KEY (`Id_semester`),
  UNIQUE KEY `Id_course` (`Id_course`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`Id_semester`, `name_semester`, `Id_course`) VALUES
(51, 'One', 1),
(52, 'Two', 2);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `Id_student` int NOT NULL AUTO_INCREMENT,
  `name_student` varchar(50) NOT NULL,
  `Id_semester` int NOT NULL,
  `phone_no` int NOT NULL,
  PRIMARY KEY (`Id_student`),
  KEY `Id_semester` (`Id_semester`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Id_student`, `name_student`, `Id_semester`, `phone_no`) VALUES
(1, 'Alaa', 7, 775772198),
(2, 'omar', 6, 776303552),
(3, 'abdo', 0, 774714492),
(4, 'Al-hassan', 0, 9785420);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id_users` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_users`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id_users`, `user_name`, `password`) VALUES
(1, 'alaa', '123'),
(3, 'omar', '123'),
(4, 'abdo', '123');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avg`
--
ALTER TABLE `avg`
  ADD CONSTRAINT `avg_ibfk_1` FOREIGN KEY (`Id_evaluation`) REFERENCES `evaluation` (`Id_evaluation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`Id_question_course`) REFERENCES `question_course` (`Id_question_course`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`Id_question_lecturer`) REFERENCES `question_lecturer` (`Id_question_lecturer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `major`
--
ALTER TABLE `major`
  ADD CONSTRAINT `fk_major` FOREIGN KEY (`Id_faculty`) REFERENCES `faculty` (`Id_faculty`),
  ADD CONSTRAINT `major_ibfk_1` FOREIGN KEY (`Id_faculty`) REFERENCES `faculty` (`Id_faculty`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `plan_ibfk_1` FOREIGN KEY (`Id_planDetail`) REFERENCES `plandetail` (`Id_planDetail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plan_ibfk_2` FOREIGN KEY (`Id_semester`) REFERENCES `semester` (`Id_semester`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `plandetail`
--
ALTER TABLE `plandetail`
  ADD CONSTRAINT `plandetail_ibfk_1` FOREIGN KEY (`Id_semeter`) REFERENCES `semester` (`Id_semester`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plandetail_ibfk_3` FOREIGN KEY (`Id_major`) REFERENCES `major` (`Id_major`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plandetail_ibfk_5` FOREIGN KEY (`Id_student`) REFERENCES `student` (`Id_student`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plandetail_ibfk_6` FOREIGN KEY (`Id_faculty`) REFERENCES `faculty` (`Id_faculty`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plandetail_ibfk_7` FOREIGN KEY (`Id_course`) REFERENCES `course` (`Id_course`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`Id_plan`) REFERENCES `plan` (`Id_plan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_3` FOREIGN KEY (`Id_Avg`) REFERENCES `avg` (`Id_Avg`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_4` FOREIGN KEY (`Id_AcadmicC`) REFERENCES `acadmaicc` (`Id_AcadmicC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_5` FOREIGN KEY (`Id_lecturer`) REFERENCES `lecturer` (`Id_lecturer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_6` FOREIGN KEY (`Id_evaluation`) REFERENCES `evaluation` (`Id_evaluation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_7` FOREIGN KEY (`Id_user`) REFERENCES `users` (`Id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_8` FOREIGN KEY (`Id_course`) REFERENCES `course` (`Id_course`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`Id_course`) REFERENCES `course` (`Id_course`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
