-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2022 at 12:22 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'PC', 'description', 0, 3, 1, 0, 1),
(2, 'Toys', 'games for kids', 0, 2, 0, 0, 1),
(3, 'Dresses', 'clothes for women', 0, 4, 1, 1, 1),
(7, 'Layla', 'nice girl toy ', 3, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ComID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 0,
  `Comment_Date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ComID`, `Comment`, `Status`, `Comment_Date`, `item_id`, `user_id`) VALUES
(1, 'This Is Very Nice Item . Wow', 1, '2022-10-05', 2, 1),
(5, 'I love You', 1, '2022-10-11', 4, 2),
(6, 'This is very nice toy.', 0, '2022-12-04', 1, 1),
(7, 'This is very nice toy.', 0, '2022-12-04', 1, 1),
(8, 'barby is wonderful toy for girls.', 0, '2022-12-04', 1, 1),
(9, 'What Happent to ms kim.', 0, '2022-12-04', 1, 1),
(10, 'This is my ld Iphone . It Was Red', 0, '2022-12-04', 6, 17),
(11, 'I need this Toy.', 0, '2022-12-04', 1, 1),
(12, 'The Bink One Is VERY Cute.', 0, '2022-12-04', 1, 1),
(13, 'The Bink One Is VERY Cute.', 0, '2022-12-04', 1, 1),
(14, 'The Bink One Is VERY Cute.', 0, '2022-12-04', 1, 1),
(15, 'The Bink One Is VERY Cute.', 0, '2022-12-04', 1, 1),
(16, 'The Bink One Is VERY Cute.', 0, '2022-12-04', 1, 17),
(17, 'I love This Toy.', 0, '2022-12-04', 1, 17),
(18, 'This Color is wonderfull.', 0, '2022-12-04', 1, 17),
(19, 'This Color is wonderfull.', 0, '2022-12-04', 1, 17),
(20, 'This Color is wonderfull.', 0, '2022-12-04', 1, 17),
(21, 'This Color is wonderfull.', 0, '2022-12-04', 1, 17),
(22, 'This Color is wonderfull.', 0, '2022-12-04', 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(1, 'Barby', 'games for kids', '33', '2022-10-23', 'Egypt', '', '1', 0, 1, 2, 1),
(2, 'dress', 'girl dress', '$44', '2022-10-23', 'Egypt', '', '3', 0, 1, 3, 1),
(4, 'candy crash', 'games for kids and olders', '$88', '2022-10-23', 'US', '', '2', 0, 1, 2, 16),
(5, 'scirt', 'new dolly nice scirt', '$55', '2022-11-23', 'Egypt', '', '4', 0, 0, 3, 1),
(6, 'Iphone pro 6x', 'Personal Telephone', '$33', '2022-12-04', 'Syria', '', '2', 0, 0, 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identify User',
  `Username` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Password to login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identifyn User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` date DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'Fareeda', '8cb2237d0679ca88db6464eac60da96345513964', 'fareedarafat12@gmail.com', 'Fareeda Raafat Mohammed', 1, 0, 1, NULL, ''),
(2, 'Amr Gamal', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'amr@gmail.com', 'Amr Abbas', 0, 0, 1, NULL, ''),
(14, 'Mohammed', '8cb2237d0679ca88db6464eac60da96345513964', 'mohammedfesho@gmail.com', 'Mohammed Raafat ', 0, 0, 1, '2022-10-13', ''),
(15, 'Eman', '8cb2237d0679ca88db6464eac60da96345513964', 'eman@gmail.com', 'Eman Raafat', 0, 0, 1, '2022-10-13', ''),
(16, 'Mona', '9f537aeb751ec72605f57f94a2f6dc3e3958e1dd', 'monasaad@gmail.com', 'Mona Saad Fishar', 0, 0, 1, '2022-10-18', ''),
(17, 'DonDon', '8cb2237d0679ca88db6464eac60da96345513964', 'dondon@gmail.com', 'DonDona Dona Dona ', 0, 0, 0, '2022-11-23', '22112022230344_7العاب-صح-او-غلط.png'),
(18, 'Emyco', '8cb2237d0679ca88db6464eac60da96345513964', 'fofafeshooo123@gmail.com', 'Enan Raafat Mohammed', 0, 0, 1, '2022-11-23', '22112022230855_Elementary-students-having-fun-playing-online-games-on-tablets-Feature-Image.jpg'),
(19, 'Lotfy', '8cb2237d0679ca88db6464eac60da96345513964', 'lotfy@gmail.com', '', 0, 0, 0, '2022-11-23', ''),
(20, 'Lotfy', '8cb2237d0679ca88db6464eac60da96345513964', 'lotfy@gmail.com', '', 0, 0, 0, '2022-11-23', ''),
(21, 'Lotfy', '8cb2237d0679ca88db6464eac60da96345513964', 'lotfy@gmail.com', '', 0, 0, 0, '2022-11-23', ''),
(22, 'Lotfy', '8cb2237d0679ca88db6464eac60da96345513964', 'lotfy@gmail.com', '', 0, 0, 0, '2022-11-23', ''),
(23, 'lotfy', '8cb2237d0679ca88db6464eac60da96345513964', 'lotfy@gmail.com', '', 0, 0, 0, '2022-11-23', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ComID`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Member_ID` (`Member_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ComID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify User', AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
