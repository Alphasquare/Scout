-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2014 alle 22:22
-- Versione del server: 5.5.40-0ubuntu0.12.04.1
-- PHP Version: 5.6.2-1+deb.sury.org~precise+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scout`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `s_logs`
--

CREATE TABLE IF NOT EXISTS `s_logs` (
`id` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `s_logs`
--

INSERT INTO `s_logs` (`id`, `description`, `date`) VALUES
(1, 'User signed in with email ''spatyx@gmail.com''', '2014-11-17 22:15:28'),
(2, 'Settings updated by ''spatyx@gmail.com''', '2014-11-17 22:30:53'),
(3, 'Settings updated by ''spatyx@gmail.com''', '2014-11-17 22:30:55'),
(4, 'User signed out with email ''spatyx@gmail.com''', '2014-11-17 22:31:00'),
(5, 'User signed in with email ''spatyx@gmail.com''', '2014-11-17 22:31:05'),
(6, 'User signed out with email ''spatyx@gmail.com''', '2014-11-17 22:44:11'),
(7, 'User signed in with email ''spatyx@gmail.com''', '2014-11-17 22:44:18'),
(8, 'User signed in with email ''spatyx@gmail.com''', '2014-11-17 23:14:32'),
(9, 'User signed in with email ''spatyx@gmail.com''', '2014-11-18 14:27:09'),
(10, 'User signed in with email ''spatyx@gmail.com''', '2014-11-18 17:11:24'),
(11, 'User signed in with email ''spatyx@gmail.com''', '2014-11-18 17:40:45'),
(12, 'User signed in with email ''spatyx@gmail.com''', '2014-11-18 18:13:47'),
(13, 'User signed in with email ''spatyx@gmail.com''', '2014-11-18 18:43:36'),
(14, 'User signed in with email ''spatyx@gmail.com''', '2014-11-18 20:39:05');

-- --------------------------------------------------------

--
-- Struttura della tabella `s_users`
--

CREATE TABLE IF NOT EXISTS `s_users` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `rank` int(11) NOT NULL,
  `lastToken` text NOT NULL,
  `lastSignin` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `s_users`
--

INSERT INTO `s_users` (`id`, `name`, `email`, `password`, `rank`, `lastToken`, `lastSignin`) VALUES
(1, 'Giuseppe Spataro', 'spatyx@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 0, 'bd2438f3ab8700b5e5f06274c596bdd3fc3eddbbd14b8b495c56e404082ead60', '2014-11-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `s_logs`
--
ALTER TABLE `s_logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s_users`
--
ALTER TABLE `s_users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `s_logs`
--
ALTER TABLE `s_logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `s_users`
--
ALTER TABLE `s_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
