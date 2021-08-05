-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2021 at 04:52 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goodjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` varchar(60) NOT NULL,
  `phonenumber` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `lastname`, `username`, `password`, `address`, `phonenumber`, `email`) VALUES
(1, 'suck', 'jueck', 'admin', '123456', 'vangvieng', '02056565656', '02056565656');

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `postJobDetail_id` int(11) NOT NULL,
  `applyDate` datetime NOT NULL,
  `applyDescription` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `acceptBy` int(11) NOT NULL,
  `acceptDate` datetime NOT NULL,
  `acceptDescription` text NOT NULL,
  `interviewDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `apply`
--

INSERT INTO `apply` (`id`, `member_id`, `degree_id`, `major_id`, `postJobDetail_id`, `applyDate`, `applyDescription`, `status`, `acceptBy`, `acceptDate`, `acceptDescription`, `interviewDate`) VALUES
(2, 1, 1, 1, 5, '2021-08-05 20:45:55', '0', 'acepted', 1, '2021-08-05 20:56:16', 'good job', '2021-10-10 20:20:00'),
(3, 1, 1, 1, 5, '2021-08-05 20:46:46', 'my apply', 'acepted', 1, '2021-08-05 20:56:25', 'good job', '2021-10-10 20:20:00'),
(4, 1, 1, 1, 5, '2021-08-05 20:47:19', 'my apply', 'apply', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `companyName` varchar(70) NOT NULL,
  `address` varchar(50) NOT NULL,
  `district_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `companyPhonenumber` varchar(50) NOT NULL,
  `companyEmail` varchar(50) NOT NULL,
  `companyContactInfo` varchar(100) NOT NULL,
  `coordinatorPhonenumber` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `image` varchar(60) NOT NULL,
  `status` varchar(50) NOT NULL,
  `isActive` tinyint(4) NOT NULL,
  `upproveBy` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `companyName`, `address`, `district_id`, `province_id`, `companyPhonenumber`, `companyEmail`, `companyContactInfo`, `coordinatorPhonenumber`, `password`, `image`, `status`, `isActive`, `upproveBy`, `created_at`) VALUES
(1, 'dorkbouakham1', 'pakthang', 1, 1, '02056595857222', 'suck@gmail.com', 'no', '02025262524', '123456789', 'company-dorkbouakham1-address-pakthang.png', 'upproved', 1, 1, NULL),
(3, 'dorkbouakham2', 'pakthang', 1, 1, '020565958572', 'suck@gmail.com', 'no', '02025262524', '123456789', '', 'upproved', 0, 1, NULL),
(4, 'dorkbouakham3', 'pakthang', 1, 1, '0205659585722', 'suck@gmail.com', 'no', '02025262524', '123456789', '', '0', 0, 0, NULL),
(5, 'dorkbouakham32', 'pakthang', 1, 1, '0205659585s722', 'suck@gmail.com', 'no', '02025262524', '123456789', '', 'register', 0, 0, NULL),
(7, 'dorkbouakham322', 'pakthang', 1, 1, '0205659585s7222', 'suck@gmail.com', 'no', '02025262524', '123456789', 'company-dorkbouakham322-address-pakthang.png', 'register', 0, 0, NULL),
(8, 'dorkbouakham2322', 'pakthang', 1, 1, '02056529585s722', 'suck@gmail.com', 'no', '02025262524', '123456789', '', 'register', 1, 0, NULL),
(9, 'dorkbouakham232s2', 'pakthang', 1, 1, ' 02056565656', 'suck@gmail.com', 'no', '02025262524', '123456789', '', 'register', 1, 0, NULL),
(10, 'dorkbouakham232s21', 'pakthang', 1, 1, '02056529585ss7212', 'suck@gmail.com', 'no', '02025262524', '123456789', '', 'register', 1, 0, NULL),
(11, 'dorkbouakham232s21', 'pakthang', 1, 1, '02056529585ss7212', 'suck@gmail.com', 'no', '02025262524', '123456789', '', 'register', 1, 0, NULL),
(12, 'dorkbouakham2322s21', 'pakthang', 1, 1, '02056529585s2s7212', 'suck@gmail.com', 'no', '02025262524', '123456789', 'company-dorkbouakham2322s21-address-pakthang.jpeg', 'register', 1, 0, '2021-08-05 19:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `id` int(11) NOT NULL,
  `degree` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`id`, `degree`) VALUES
(1, 'sucdddk'),
(3, 'suck');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `province_id`, `district`) VALUES
(1, 1, 'thone'),
(3, 1, 'thone'),
(4, 1, 'thone');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `id` int(11) NOT NULL,
  `major` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id`, `major`) VALUES
(1, 'sucdddk'),
(3, 'suck'),
(4, 'suck'),
(5, 'suck');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `memberName` varchar(50) NOT NULL,
  `memberLastname` varchar(50) NOT NULL,
  `memberAddress` varchar(80) NOT NULL,
  `district_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `phonenumber` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `isActive` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `memberName`, `memberLastname`, `memberAddress`, `district_id`, `province_id`, `gender`, `dob`, `phonenumber`, `email`, `password`, `status`, `image`, `isActive`, `created_at`) VALUES
(1, 'thoneqq', 'thilad', 'pakthang', 1, 1, 'male', '1999-10-12', '02056565859332s', 'suck@gmail.com', 'phone22', '0', 'member-thoneqq-address-pakthang-dob-1999-10-12.jpe', 1, NULL),
(3, 'thone', 'thilad', 'pakthang', 1, 1, 'male', '1999-10-12', '02056565859', 'suck@gmail.com', '123456789', '0', '', 1, NULL),
(4, 'thone2', 'thilad', 'pakthang', 1, 1, 'male', '1999-10-12', '020565658593', 'suck@gmail.com', '123456789', '0', '', 0, NULL),
(5, 'thone3', 'thilad', 'pakthang', 1, 1, 'male', '1999-10-12', '02056565859332', 'suck@gmail.com', '123456789', '0', 'member-thone3-address-pakthang-dob-1999-10-12.jpeg', 1, NULL),
(6, 'thone333', 'thilad', 'pakthang', 1, 1, 'male', '1999-10-12', '0205656585933332', 'suck@gmail.com', '123456789', '0', 'member-thone333-address-pakthang-dob-1999-10-12.jp', 1, NULL),
(7, 'thone3s33', 'thilad', 'pakthang', 1, 1, 'male', '1999-10-12', '02056565s85933332', 'suck@gmail.com', '123456789', '0', 'member-thone3s33-address-pakthang-dob-1999-10-12.j', 1, '2021-08-05 19:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position`) VALUES
(1, 'sucdddk'),
(3, '0'),
(4, '0'),
(5, '0'),
(6, 'suck'),
(7, 'suck');

-- --------------------------------------------------------

--
-- Table structure for table `post_job`
--

CREATE TABLE `post_job` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `fileForm` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_job`
--

INSERT INTO `post_job` (`id`, `company_id`, `fileForm`, `description`) VALUES
(3, 1, '', 'okokok'),
(4, 1, 'member--address--dob-.pdf', 'okokok'),
(5, 1, 'company-id-1-number-1681772810.pdf', 'okokok');

-- --------------------------------------------------------

--
-- Table structure for table `post_job_detail`
--

CREATE TABLE `post_job_detail` (
  `id` int(11) NOT NULL,
  `postJob_id` int(11) NOT NULL,
  `jobName` varchar(70) NOT NULL,
  `description` text NOT NULL,
  `posistion_id` int(11) NOT NULL,
  `salary_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_job_detail`
--

INSERT INTO `post_job_detail` (`id`, `postJob_id`, `jobName`, `description`, `posistion_id`, `salary_id`, `degree_id`, `major_id`, `status`, `date`) VALUES
(5, 3, 'Programer', 'hellow world', 1, 1, 1, 1, '', '2021-08-05 16:26:58'),
(6, 3, 'Programer', 'hellow world', 1, 1, 1, 1, '', '2021-08-05 16:26:58'),
(7, 4, 'Programer', 'hellow world', 1, 1, 1, 1, '', '2021-08-05 16:31:18'),
(8, 4, 'Programer', 'hellow world', 1, 1, 1, 1, '', '2021-08-05 16:31:18'),
(9, 5, 'Programer', 'hellow world', 1, 1, 1, 1, '', '2021-08-05 16:33:58'),
(10, 5, 'Programer', 'hellow world', 1, 1, 1, 1, '', '2021-08-05 16:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `province` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `province`) VALUES
(1, 'sucdddk'),
(3, '0'),
(4, '0'),
(5, '0'),
(6, '0'),
(7, 'suck'),
(8, 'suck'),
(9, 'suck');

-- --------------------------------------------------------

--
-- Table structure for table `salary_rate`
--

CREATE TABLE `salary_rate` (
  `id` int(11) NOT NULL,
  `salaryRate` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary_rate`
--

INSERT INTO `salary_rate` (`id`, `salaryRate`) VALUES
(1, 'sucdddk'),
(3, 'suck'),
(4, 'suck'),
(5, 'suck'),
(6, 'suck');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_job`
--
ALTER TABLE `post_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_job_detail`
--
ALTER TABLE `post_job_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_rate`
--
ALTER TABLE `salary_rate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `apply`
--
ALTER TABLE `apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post_job`
--
ALTER TABLE `post_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_job_detail`
--
ALTER TABLE `post_job_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salary_rate`
--
ALTER TABLE `salary_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
