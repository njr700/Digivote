-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 12:09 PM
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
-- Database: `vote_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `enregistrement`
--

CREATE TABLE `enregistrement` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `postnom` varchar(255) NOT NULL,
  `Adress` varchar(255) NOT NULL,
  `uniqueCode` varchar(255) NOT NULL,
  `profilePicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enregistrement`
--

INSERT INTO `enregistrement` (`id`, `firstName`, `lastName`, `postnom`, `Adress`, `uniqueCode`, `profilePicture`) VALUES
(18, 'martine', 'mulongo', 'jane', 'limete 2ème', 'ID-KA1SNTC1E', '44cdc87c-1bf7-43d4-950f-30dd2762c393.jpeg'),
(19, 'paul', 'thompson', 'ricky', 'limete', 'ID-UYS6GBW8G', 'Business Portraits.jpeg'),
(20, 'julie', 'mukeba', 'thornicroft', 'limete', 'ID-VQUQIKJZO', 'Seamless Style_ Human Hair Extensions for Flawless Sew-In Transformations.jpeg'),
(21, 'MANASSE', 'Esther', 'KITUMAINI', '28 Av.Equateur', 'ID-1RMD1Z2BB', 'User Avatar.jpeg'),
(22, 'jasmine', 'blake', 'marieanne', 'montngafula', 'ID-KIRNIQNLS', 'Corporate Portraits - Tracy Wright Corvo Photography.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `enregistrement2`
--

CREATE TABLE `enregistrement2` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `postnom` varchar(255) NOT NULL,
  `poste` varchar(255) NOT NULL,
  `uniqueCode` varchar(255) NOT NULL,
  `profilePicture` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enregistrement2`
--

INSERT INTO `enregistrement2` (`id`, `firstName`, `lastName`, `postnom`, `poste`, `uniqueCode`, `profilePicture`) VALUES
(2, 'marie anne', 'lukusa', 'marthe', 'tresorier', 'ID-MA3PL1OYW', 0x30323566646639372d653036392d346563382d383334392d6135366462383335636532642e6a706567),
(3, 'maurice', 'parker', 'simon', 'vice-presidence', 'ID-QB97OYK25', 0x4c696e6b6564696e2050726f66696c65205469707320616e6420547269636b732e6a706567),
(4, 'jean', 'mutombo', 'mitchell', 'tresorier', 'ID-X33JBXLA6', 0x4d616e2773204865616473686f742e6a706567),
(5, 'jane', 'mart', 'mimi', 'presidence', 'ID-XRXCTKOQV', 0x436f72706f726174652050686f746f73686f6f74202d20436f72706f72617465204865616473686f74732053696e6761706f72652e6a706567),
(6, 'tim', 'thompson', 'lumiere', 'vice-presidence', 'ID-MOPYTX18E', 0x65353665346133352d323435652d346232312d623437642d3763643736303332313630662e6a706567);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enregistrement`
--
ALTER TABLE `enregistrement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enregistrement2`
--
ALTER TABLE `enregistrement2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqueCode` (`uniqueCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enregistrement`
--
ALTER TABLE `enregistrement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `enregistrement2`
--
ALTER TABLE `enregistrement2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
