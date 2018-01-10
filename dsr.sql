-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2018 at 03:55 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dsr`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `eqp_id` int(50) NOT NULL,
  `name_of_equip` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `warranty` float NOT NULL,
  `rate` float NOT NULL,
  `amount` float NOT NULL,
  `central_dsr_no` varchar(100) NOT NULL,
  `cdr` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `del_flag` int(11) NOT NULL,
  `bill_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equip_lab`
--

CREATE TABLE `equip_lab` (
  `eqp_id` int(50) NOT NULL,
  `lab_id` int(50) NOT NULL,
  `transferred` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `lab_id` int(50) NOT NULL,
  `lab_name` varchar(100) NOT NULL,
  `lab_full_name` varchar(100) NOT NULL,
  `lab_incharge` varchar(100) NOT NULL,
  `lab_cost` float NOT NULL,
  `lab_investment` float NOT NULL,
  `room_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab`
--

INSERT INTO `lab` (`lab_id`, `lab_name`, `lab_full_name`, `lab_incharge`, `lab_cost`, `lab_investment`, `room_no`) VALUES
(1, 'DCA', 'Devices And Communication Laboratory', 'Ms. P. Sai Deepti', 0, 0, 'B107'),
(2, 'OOAD', 'Object Oriented Analysis & Design Laboratory', 'Ms. Rajani Pamnani', 0, 0, 'B109'),
(3, 'CP', 'Computer Programming Laboratory', 'Ms. Sheetal Pereira', 0, 0, 'B110'),
(4, 'WT', 'Web Technology Laboratory', 'Ms. Mansi Kambli (Prasadini)', 0, 0, 'B115'),
(5, 'DBMS', 'Database Management System Laboratory', 'Ms. Pradnya Gotmare', 0, 0, 'B116'),
(6, 'MMS', 'Multimedia Systems Laboratory', 'Ms. Rohini Nair ', 0, 0, 'B117'),
(7, 'MP', 'Microprocessor Laboratory', 'Mr. Gajanan Bherde', 0, 0, 'B207'),
(8, 'SS', 'System Security Laboratory', 'Ms. Poonam Bhogle', 0, 0, 'B209'),
(9, 'PRJ', 'Project Laboratory', 'Ms. Raul Bhakti (Palkar)', 0, 0, 'B210-A'),
(10, 'PGCF', 'Post Graduate Computing Facility Laboratory', 'Ms. Raul Bhakti (Palkar)', 0, 0, 'B210-B'),
(11, 'AOA', 'Algorithms Laboratory', 'Ms.Swati Mali', 0, 0, 'B215'),
(12, 'ROB', 'Artificial Intelligence and Robotics Laboratory', 'Ms. Suchita Patil', 0, 0, 'B216'),
(13, 'CCN', 'Computer Communications and Networking Laboratory', 'Ms. Smita Sankhe', 0, 0, 'B217'),
(14, 'CCF', 'Common Computing Facility Laboratory', 'Mr. Prasanna Shete', 0, 0, 'A024'),
(15, 'ADM', 'ADMIN', 'ADMIN', 0, 0, 'B218'),
(16, 'DCR', 'Data Centre', '', 0, 0, 'B219');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `lab_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `phone`, `username`, `password`, `email`, `role`, `lab_id`) VALUES
(1, 'raj', '9167992689', 'raj', '$2y$10$NOOhM8b34pSJ6UNwPNMX7u7.IfUJTXIX2slo27jVPce46WbFVyVKG', 'rajnandu2711@gmail.com', 'lab', 1),
(2, 'gagan', '1234567890', 'gg', '$2y$10$KfILVmaQc8Tl31iSjTGHuur79QlSwDRzV5Cm/B4tYyT6vAXk.qsbO', 'gagandeep.u@somaiya.edu', 'lab', 2),
(3, 'Nilay', '1234567890', 'nilay.rane', '$2y$10$4oMK15qoVTOWn2Z.Ah0zCeNPYzUkPB5GBra2p8PRHUDd1pi0bVZha', 'nilay.rane@somaiya.edu', 'lab', 3),
(4, '', '', '', '', '', 'lab', 4),
(5, '', '', '', '', '', 'lab', 5),
(6, '', '', '', '', '', 'lab', 6),
(7, '', '', '', '', '', 'lab', 7),
(8, '', '', '', '', '', 'lab', 8),
(9, '', '', '', '', '', 'lab', 9),
(10, '', '', '', '', '', 'lab', 10),
(11, '', '', '', '', '', 'lab', 11),
(12, '', '', '', '', '', 'lab', 12),
(13, '', '', '', '', '', 'lab', 13),
(14, '', '', '', '', '', 'lab', 14),
(15, 'hod', '1234569807', 'hod', '$2y$10$ozeLfeqnQyr8uoa40XuFp.jETPIEkl97GTByrbMkzi863pRcUcA.6', 'hod@somaiya.edu', 'lab', 15),
(16, '', '', '', '', '', 'lab', 16),
(17, 'nishit', '9167992689', 'nis', '$2y$10$eLDcajIn7ZQZ8XtviF9wqOCGo6pYxuKpybARK.JU/PKkvOmpiEB.6', 'nishit.maru@somaiya.edu', 'incharge', 1),
(18, '', '', '', '', '', 'incharge', 2),
(19, '', '', '', '', '', 'incharge', 3),
(20, '', '', '', '', '', 'incharge', 4),
(21, '', '', '', '', '', 'incharge', 5),
(22, '', '', '', '', '', 'incharge', 6),
(23, '', '', '', '', '', 'incharge', 7),
(24, '', '', '', '', '', 'incharge', 8),
(25, '', '', '', '', '', 'incharge', 9),
(26, '', '', '', '', '', 'incharge', 10),
(27, '', '', '', '', '', 'incharge', 11),
(28, '', '', '', '', '', 'incharge', 12),
(29, '', '', '', '', '', 'incharge', 13),
(30, '', '', '', '', '', 'incharge', 14),
(31, '', '', '', '', '', 'incharge', 15),
(32, '', '', '', '', '', 'incharge', 16),
(59, 'admin', '1234567890', 'Admin', '$2y$10$CI1V6/DA/Rs5R4y6zkTAg.9K2Re7E4pOAtDO31JS7LA1LjO1kZ62G', 'admin@somaiya.edu', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `euip_id` int(50) NOT NULL,
  `vendor_id` int(50) NOT NULL,
  `purchase_date` date NOT NULL,
  `supply_date` date NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `purchase_order_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `from_lab_id` int(50) NOT NULL,
  `from_lab_name` varchar(50) NOT NULL,
  `to_lab_id` int(50) NOT NULL,
  `to_lab_name` varchar(50) NOT NULL,
  `equip_id` int(50) NOT NULL,
  `transfer_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `name_of_vendor` varchar(100) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`eqp_id`);

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`lab_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `eqp_id` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lab`
--
ALTER TABLE `lab`
  MODIFY `lab_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
