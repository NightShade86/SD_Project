-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 12:06 PM
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
-- Database: `dtcmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `FIRSTNAME` varchar(225) NOT NULL,
  `LASTNAME` varchar(225) NOT NULL,
  `NO_TEL` varchar(15) NOT NULL,
  `USER_ID` varchar(50) NOT NULL,
  `EMAIL` varchar(15) NOT NULL,
  `IC` varchar(15) NOT NULL,
  `PASSWORD` varchar(225) NOT NULL,
  `USERTYPE` int(10) NOT NULL,
  `IMAGE` varchar(100) NOT NULL,
  `reset_token_hash` varchar(64) NOT NULL,
  `reset_token_expires_at` datetime NOT NULL DEFAULT current_timestamp(),
  `TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verify_token_hash` varchar(64) NOT NULL,
  `verify_token_expires_at` datetime DEFAULT NULL,
  `verify_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`FIRSTNAME`, `LASTNAME`, `NO_TEL`, `USER_ID`, `EMAIL`, `IC`, `PASSWORD`, `USERTYPE`, `IMAGE`, `reset_token_hash`, `reset_token_expires_at`, `TIMESTAMP`, `verify_token_hash`, `verify_token_expires_at`, `verify_timestamp`) VALUES
('ADMIN', 'Admin', '063533300', 'admin', 'admin@gmail.com', '000000000000', '$2y$10$an8xp4f2AhojaSCvEJQlB.dYSh2Iil3.UeufvibLsHnxlNTNIlVZi', 0, 'hand-holding-rose-aesthetic-basqu8gkca1xw7ht.jpg', '', '2024-09-23 10:01:49', '2024-11-10 20:14:39', '', NULL, '2024-09-23 02:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_info`
--

CREATE TABLE `appointment_info` (
  `appointment_id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ic` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason_for_visit` text NOT NULL,
  `queue_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_info`
--

INSERT INTO `appointment_info` (`appointment_id`, `userid`, `fname`, `lname`, `number`, `email`, `ic`, `appointment_date`, `appointment_time`, `reason_for_visit`, `queue_number`) VALUES
(23, 'narres', 'Narres', 'Khumar', '01155587823', 'narreskhumar@gmail.com', '030807011163', '2024-11-13', '09:00:00', 'test4', 3),
(24, 'narres', 'Narres', 'Khumar', '01155587823', 'narreskhumar@gmail.com', '030807011163', '2024-11-15', '09:00:00', 'test', 4),
(25, 'narres', 'Narres', 'Khumar', '01155587823', 'narreskhumar@gmail.com', '030807011163', '2024-11-15', '09:30:00', 'consultation\r\n', 5),
(26, 'Faris', 'Faris Aisy ', 'Zaitol Adhar', '0134982289', 'yehacim852@gianes.com', '100619010457', '2024-11-15', '11:30:00', 'fever', 6),
(27, 'Faris', 'Faris Aisy ', 'Zaitol Adhar', '0134982289', 'yehacim852@gianes.com', '100619010457', '2024-11-15', '13:00:00', 'fever', 7);

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `bill_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`bill_id`, `item_name`, `price`, `quantity`, `total`) VALUES
(38, 'medicine', 20.00, 1, 20.00),
(39, 'consultant', 50.00, 1, 50.00),
(40, 'item', 2.00, 50, 100.00),
(41, 'bandaid', 50.00, 1, 50.00),
(42, 'medicine', 50.00, 2, 100.00),
(43, 'tongkat', 15.00, 2, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_bills`
--

CREATE TABLE `clinic_bills` (
  `bill_id` int(11) NOT NULL,
  `patient_ic` varchar(20) NOT NULL,
  `payment_status` enum('Paid','Pending','Unpaid') NOT NULL,
  `payment_method` enum('Cash','Online') NOT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `insurance_policy_number` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `total_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_bills`
--

INSERT INTO `clinic_bills` (`bill_id`, `patient_ic`, `payment_status`, `payment_method`, `insurance_company`, `insurance_policy_number`, `total_amount`, `total_paid`, `created_at`, `updated_at`, `payment_date`) VALUES
(38, '040404050101', 'Unpaid', 'Online', '-', '-', 20.00, 0.00, '2024-11-11 04:36:09', '2024-11-11 04:36:09', '2024-11-11 12:36:09'),
(39, '040404050101', 'Paid', 'Online', '-', '-', 50.00, 0.00, '2024-11-11 04:36:32', '2024-11-13 13:27:40', '2024-11-11 12:36:32'),
(40, '030807011163', 'Unpaid', 'Online', '', '', 100.00, 0.00, '2024-11-11 04:51:24', '2024-11-11 04:51:24', '2024-11-11 12:51:24'),
(41, '030807011163', 'Paid', 'Online', '', '', 50.00, 0.00, '2024-11-11 04:51:39', '2024-11-13 13:27:39', '2024-11-11 12:51:39'),
(42, '123456789', 'Paid', 'Online', '-', '-', 100.00, 0.00, '2024-11-13 14:35:44', '2024-11-13 14:36:42', '2024-11-13 22:35:44'),
(43, '040404050101', 'Unpaid', 'Online', '-', '-', 30.00, 0.00, '2024-11-13 16:10:05', '2024-11-13 16:10:05', '2024-11-14 00:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'fatihah04@graduate.utm.my', '792877fb550eea712c4deb184cad57a1de34630ccfc16678c668631081c7bc89a666a2cec288b741ddacb5653834551a05be', '2024-08-31 19:07:05'),
(2, 'fatihah04@graduate.utm.my', '056c9656d7c04e81555cbff83c4531b494e24a21698caf251d292dfa07d4a4f57d6c130d9c65a469d3efa1dd449759661314', '2024-08-31 19:07:11'),
(3, 'fatihah04@graduate.utm.my', '9add84278e6e0e14b66ee9a461abaafa58db466d95d403c1e733dd1262419001bb847076f07ad517f03080a826ee35510105', '2024-08-31 19:09:57'),
(4, 'fatihah04@graduate.utm.my', '1a44bd4ba64ee3c12ab3e69fd4550fe6ba3eeba0193714666ac5817715c93d0bb5cad7a55f7c95dc190bc8fc24ae03094351', '2024-08-31 19:12:22'),
(5, 'fatihah04@graduate.utm.my', '9a3da10c4e44f7f25cb3f4ef48110f8ec482ca04d3298beaae45e6895d98ad542e1ee7bf5a5857d8222e66ff3ccaa7e9b0e2', '2024-08-31 19:12:34'),
(6, 'fatihah04@graduate.utm.my', 'fd16cb83f18212a20f7492a3a050aca9791e841b66b6ebc14ba38ed6b92c4d9d04bd070a2055b5759377b517a7d675647dcf', '2024-08-31 19:23:44'),
(7, 'fatihah04@graduate.utm.my', 'e320105fd1b466fdf9d0619354993ec89f6a825fbaf2011f8fd34a54518da5c64aefa374056a95164f5a5b349fa63adee02c', '2024-08-31 19:23:47'),
(8, '', '524101564234627bbc3c73e8b4bbfd2de31dd825be6272eb5e5ed4a048bd5fdd', '2024-08-31 19:34:49'),
(9, '', '98afb6b2bbb271e446694fa904ab25e5f0ec97ef9cd900a0b5b9f8feedecdd56', '2024-08-31 19:35:03'),
(10, '', '6f26575cc28ec960e6772a60e7c621f9fe536a480ddfbe7eb034230cc158bc7c', '2024-08-31 19:37:15'),
(11, '', '21d822cf9c2247ae4113cf8bb9ea302d30f4ecda1bc9e020326fd6c7b11ee84f', '2024-08-31 19:37:22'),
(12, '', 'decdf8b6b19a3fc6b986796ddf02ad9a00f0e0f74e2923a13c79b115cb7cff86', '2024-08-31 19:38:49'),
(13, 'fatihah04@graduate.utm.my', '2bc0e67b19cff2075d966b0e54fc685aa8cb9c0b5d09e3d40e3f211f0ca4f02379c81e7a9451e37fa0c0ff1bdfc6eaca14f6', '2024-08-31 19:39:43'),
(14, 'fatihah04@graduate.utm.my', '2bc0e67b19cff2075d966b0e54fc685aa8cb9c0b5d09e3d40e3f211f0ca4f02379c81e7a9451e37fa0c0ff1bdfc6eaca14f6', '2024-08-31 19:39:43'),
(15, 'fatihah04@graduate.utm.my', '33434683945799f41a122958e2c6f8e4f51ccb3a3e6a1f798e8fc0086ce9ca08b27e19e237cf3c784a30260207ec0f38fd22', '2024-08-31 20:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `staff_info`
--

CREATE TABLE `staff_info` (
  `FIRSTNAME` varchar(225) NOT NULL,
  `LASTNAME` varchar(225) NOT NULL,
  `NO_TEL` varchar(15) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `IC` varchar(15) NOT NULL,
  `STAFF_ID` varchar(50) NOT NULL,
  `PASSWORD` varchar(225) NOT NULL,
  `USERTYPE` varchar(10) NOT NULL,
  `IMAGE` varchar(100) NOT NULL,
  `reset_token_hash` varchar(64) NOT NULL,
  `reset_token_expires_at` datetime NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verify_token_hash` varchar(64) NOT NULL,
  `verify_token_expires_at` datetime DEFAULT NULL,
  `verify_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_info`
--

INSERT INTO `staff_info` (`FIRSTNAME`, `LASTNAME`, `NO_TEL`, `EMAIL`, `IC`, `STAFF_ID`, `PASSWORD`, `USERTYPE`, `IMAGE`, `reset_token_hash`, `reset_token_expires_at`, `TIMESTAMP`, `verify_token_hash`, `verify_token_expires_at`, `verify_timestamp`) VALUES
('Nuralisya Azwa', 'Zaitol Adhar', '0169354889', 'naliszwa@gmail.com', '123456789', 'Azwa', '$2y$10$yutoUFfQFhxfIVoSYY8d0eFJsf7Yn6nR/2F/lJVTJEAgzZbOXvIYO', '1', '', '', '0000-00-00 00:00:00', '2024-11-10 19:43:41', '', NULL, '2024-11-10 19:43:41'),
('Fohoxe', 'Barakal', '018299911', 'fohoxe3747@barakal.com', '050929292212', 'foho1', '$2y$10$bi5oq48IVKt7k2z55x6eCOGtFEy.De1ReblNDldj4G.i7HkOTtkI6', '', '', '', '2024-09-10 17:49:46', '2024-09-10 16:05:04', '', NULL, '2024-09-22 17:20:51'),
('Ismail', 'Burnz', '252235235', 'ismail@gmail.com', '00000000', 'staff1', '$2y$10$3Pp.cMarKbPgmJ8bAJIsOOpYIuITZnOQO6khpQ.4Kod8SEIh3X4Ym', '1', '', '', '0000-00-00 00:00:00', '2024-11-10 21:22:53', '', NULL, '2024-11-10 21:22:53'),
('NUR FATIHAH', 'MOHAMAD', '0176044188', 'fatihah04@graduate.utm.my', '040615050116', 'teha1', '$2y$10$0Y5TP7Wo4e6F55KY5ryuEeEnEHxqI7nL.kXYoNjcGdzswXRRIoNmG', '1', 'jQV7WO_3f.jpg', '', '0000-00-00 00:00:00', '2024-11-10 06:07:50', '', NULL, '2024-10-09 01:32:49'),
('Uira ', 'Farhah', '0706317899', 'ui@gmail.com', '09764589097', 'ui1', '$2y$10$uD0aqhEqmc4If7zI3eQIU.Ez3t3gRxeYG/w1mWKEy2WVQuoVLpBBC', '1', 'hand-holding-rose-aesthetic-basqu8gkca1xw7ht.jpg', '', '0000-00-00 00:00:00', '2024-10-09 01:06:19', '', NULL, '2024-10-07 02:08:16'),
('Zarith Firdaus', 'Reza', '017339867', 'zarithFirdaus@gmail.com', '040306050911', 'Zarith', '$2y$10$7WZDu6T/5IU9bd/D.AO6OeiidIYAIsEr7BDHiGF/vs62Uu5JXlITC', '1', '', '', '0000-00-00 00:00:00', '2024-11-10 19:45:32', '', NULL, '2024-11-10 19:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_feedback`
--

CREATE TABLE `user_feedback` (
  `ID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `ROLE` varchar(255) DEFAULT NULL,
  `FNAME` varchar(255) NOT NULL,
  `LNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `OVERALL_RATING` tinyint(4) NOT NULL,
  `DESIGN_RATING` tinyint(4) NOT NULL,
  `USABILITY_RATING` tinyint(4) NOT NULL,
  `PERFORMANCE_RATING` tinyint(4) NOT NULL,
  `CONTENT_RATING` tinyint(4) NOT NULL,
  `RECOMMENDATION_RATE` tinyint(4) NOT NULL,
  `POSITIVE_FEEDBACK` text DEFAULT NULL,
  `IMPROVEMENTS` text DEFAULT NULL,
  `MISSING_INFO` text DEFAULT NULL,
  `NAV_DIFFICULTY` varchar(50) DEFAULT NULL,
  `VISIT_REASON` varchar(255) DEFAULT NULL,
  `WEB_DISCOVERY` varchar(50) DEFAULT NULL,
  `FUNCTIONALITY_ISSUE` text DEFAULT NULL,
  `LOADING_SPEED` varchar(10) DEFAULT NULL,
  `ADDITIONAL_COMMENTS` text DEFAULT NULL,
  `FOLLOW_UP` tinyint(1) DEFAULT 0,
  `SUBMISSION_DATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_feedback`
--

INSERT INTO `user_feedback` (`ID`, `USERID`, `ROLE`, `FNAME`, `LNAME`, `EMAIL`, `OVERALL_RATING`, `DESIGN_RATING`, `USABILITY_RATING`, `PERFORMANCE_RATING`, `CONTENT_RATING`, `RECOMMENDATION_RATE`, `POSITIVE_FEEDBACK`, `IMPROVEMENTS`, `MISSING_INFO`, `NAV_DIFFICULTY`, `VISIT_REASON`, `WEB_DISCOVERY`, `FUNCTIONALITY_ISSUE`, `LOADING_SPEED`, `ADDITIONAL_COMMENTS`, `FOLLOW_UP`, `SUBMISSION_DATE`) VALUES
(1, 0, 'patient', 'kirthana', 'lakshimy', 'shadesg4@gmail.com', 9, 4, 7, 2, 8, 10, 'buttons', 'nothing', 'found everything', 'Very Easy', 'Browsing', 'Search Engine', 'everyting worked', 'Yes', 'mew', 0, '2024-09-26 07:56:51'),
(2, 0, 'patient', 'kirthana', 'lakshimy', 'shadesg4@gmail.com', 9, 4, 7, 2, 8, 10, 'buttons', 'nothing', 'found everything', 'Very Easy', 'Browsing', 'Search Engine', 'everyting worked', 'Yes', 'mew', 0, '2024-09-26 07:57:25'),
(3, 0, 'patient', 'kirthana', 'lakshimy', 'shadesg4@gmail.com', 9, 4, 7, 2, 8, 10, 'buttons', 'nothing', 'found everything', 'Very Easy', 'Browsing', 'Search Engine', 'everyting worked', 'Yes', 'mew', 0, '2024-09-26 07:57:25'),
(4, 0, 'patient', 'NARRES', 'JAYAKUMARAN', 'narreskhumar@gmail.com', 8, 1, 9, 3, 7, 10, 'buttons', 'design', 'nothing', 'Very Easy', 'Browsing', 'Search Engine', 'everything worked', 'Yes', 'no comments', 0, '2024-09-26 07:59:03'),
(5, 0, 'patient', 'NARRES', 'JAYAKUMARAN', 'narreskhumar@gmail.com', 8, 1, 9, 3, 7, 10, 'buttons', 'design', 'nothing', 'Very Easy', 'Browsing', 'Search Engine', 'everything worked', 'Yes', 'no comments', 0, '2024-09-26 07:59:03'),
(6, 0, 'patient', 'ismal', 'abu', 'test@mail.com', 8, 2, 6, 2, 4, 10, 'buttons', 'non', 'nothin', 'Very Easy', 'Browsing', 'Search Engine', 'nothinggg', 'Yes', 'no comment', 0, '2024-09-26 08:00:14'),
(7, 0, 'patient', 'ismal', 'abu', 'test@mail.com', 8, 2, 6, 2, 4, 10, 'buttons', 'non', 'nothin', 'Very Easy', 'Browsing', 'Search Engine', 'nothinggg', 'Yes', 'no comment', 0, '2024-09-26 08:00:14'),
(8, 0, 'patient', 'ching', 'chong', 'vegigo8466@barakal.com', 9, 3, 8, 4, 1, 3, 'buttons', 'non', 'all', 'Very Easy', 'Browsing', 'Search Engine', 'none', 'Yes', 'mewmewmew', 0, '2024-09-26 08:06:36'),
(9, 0, 'patient', 'Sejayis', 'Exweme', 'sejayis871@exweme.com', 5, 5, 5, 5, 5, 5, 'e', 'e', 'e', 'Very Easy', 'Browsing', 'Search Engine', 'e', 'Yes', 'e', 0, '2024-10-07 17:15:40'),
(10, 0, 'patient', 'aa', 'a', 'teha@gmail.com', 5, 5, 5, 5, 5, 5, 'yes', 'yes', 'yes', 'Neutral', 'Browsing', 'Search Engine', 'yes', 'Yes', 'yes', 0, '2024-10-09 01:18:39'),
(11, 0, 'patient', 'Sejayis', 'exweme', 'sejayis872@exweme.com', 5, 5, 5, 5, 5, 5, 'EVERYTHING GOOD', 'NOTHING', '-', 'Very Easy', 'Browsing', 'Search Engine', '-', 'Yes', '-', 0, '2024-10-20 15:27:22'),
(13, 0, 'patient', 'Sejayis', 'exweme', 'sejayis872@exweme.com', 5, 5, 5, 5, 5, 5, 'yesy', 'nope', 'noti', 'Very Easy', 'Browsing', 'Search Engine', '-', 'Yes', '-', 0, '2024-11-04 02:49:12'),
(14, 0, 'guest', 'guest', 'guest', 'guest', 5, 5, 5, 5, 5, 5, 'fgfg', 'guest', 'guest', 'Very Easy', 'Browsing', 'Search Engine', 'guest', 'Yes', 'guest', 0, '2024-11-10 16:43:04'),
(15, 0, 'guest', 'guest', 'guest', 'guest', 5, 5, 5, 5, 5, 5, 'fgfg', 'guest', 'guest', 'Very Easy', 'Browsing', 'Search Engine', 'guest', 'Yes', 'guest', 0, '2024-11-10 16:44:40'),
(16, 0, 'patient', 'Zarith Firdaus', 'Reza', 'naliszwa@gmail.com', 8, 9, 6, 8, 5, 6, 'good', 'good', 'good', 'Very Easy', 'Looking for Information', 'Search Engine', 'good', 'Yes', '-', 0, '2024-11-10 21:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `FIRSTNAME` varchar(50) NOT NULL,
  `LASTNAME` varchar(50) NOT NULL,
  `NO_TEL` varchar(15) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `IC` varchar(15) NOT NULL,
  `USER_ID` varchar(50) NOT NULL,
  `PASSWORD` varchar(225) NOT NULL,
  `USERTYPE` varchar(10) NOT NULL,
  `IMAGE` varchar(100) NOT NULL,
  `reset_token_hash` varchar(64) NOT NULL,
  `reset_token_expires_at` datetime NOT NULL,
  `TIMESTAMP` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `verify_token_hash` varchar(64) NOT NULL,
  `verify_token_expires_at` datetime DEFAULT NULL,
  `verify_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`FIRSTNAME`, `LASTNAME`, `NO_TEL`, `EMAIL`, `IC`, `USER_ID`, `PASSWORD`, `USERTYPE`, `IMAGE`, `reset_token_hash`, `reset_token_expires_at`, `TIMESTAMP`, `verify_token_hash`, `verify_token_expires_at`, `verify_timestamp`) VALUES
('', '', '', 'nurrisae@gmail.com', '', '', '', '', '', '', '0000-00-00 00:00:00', '2024-11-14 07:27:25.434723', '1bbf172670dcd0ab108f6e81fc10734c470a1122377d9d598ef85b9df39fe469', '2024-11-14 08:57:25', '2024-11-13 12:52:33'),
('Faris Aisy ', 'Zaitol Adhar', '0134982289', 'yehacim852@gianes.com', '100619010457', 'Faris', '$2y$10$cUU9biy7sLHDO3Oc/fU78edxM8B1E53DT6IjUcK3HmIV2NYbmGh3O', '2', '', '69a1132382c36d0b5ce7d5c3593dd9ec984ff89cce7583133486d338fe5b2e1a', '2024-11-14 10:38:55', '2024-11-14 09:08:55.880875', '', NULL, '2024-11-13 14:58:50'),
('Sejayis', 'exweme', '01892929292', 'sejayis872@exweme.com', '040404050101', 'jayis1', '$2y$10$SqSFB5BktRFxotgrDLQleu/4RLY/IzMTEVglCmfJaNPA5ji3HKw4C', '2', 'hand-holding-rose-aesthetic-basqu8gkca1xw7ht.jpg', '', '0000-00-00 00:00:00', '2024-10-09 01:20:57.040371', 'b7362b3a9e79d14350e5b5d0375d4b68b54e5b9104d3db4afc8990acea70f5be', '2024-10-07 19:47:05', '2024-09-29 15:30:51'),
('Narres', 'Khumar', '01155587823', 'narreskhumar@gmail.com', '030807011163', 'narres', '$2y$10$kaoR/1H5hQZnfo7lGJWG/eGFGYaRRfCDE/OTaL2cFXJ2nYH49tOnK', '2', '', 'c948da6f38c62b94728b7d5aa512a73053071e51d8099da01031b6f24abfb5e4', '2024-09-10 15:52:24', '2024-09-11 00:48:14.526852', 'a2a86abc891b2ce544d0953a3d50a552975c8e2b86530eaabfb91b434d000219', '2024-09-11 08:48:14', '2024-09-10 13:35:39'),
('PEFAR', 'CIRONEX', '0189297372', 'pefar45704@cironex.com', '0909091092911', 'pefar1', '$2y$10$jTwDiO6mCtdBMOtAhvIYiOB9.zHrVLhKqeiFZA8OsD1P653LCro6C', '2', '', '', '0000-00-00 00:00:00', '2024-11-10 10:42:39.456847', '', NULL, '2024-11-10 10:41:32'),
('Nuralisya Waffa', 'Zaitol Adhar', '0183807371', 'mipex57638@gianes.com', '123456789', 'wawa', '$2y$10$cu80q2DTR6Cy3vHXNsqnzuadX6zPkynwqtoQ5S49LWI1.Z2BMEUee', '2', '', '', '0000-00-00 00:00:00', '2024-11-13 14:13:48.385726', '', NULL, '2024-11-10 21:04:49'),
('Zarith Firdaus', 'Reza', '01766543332', 'naliszwa@gmail.com', '04020212938472', 'zarith', '$2y$10$w3eP4eM4mk7fCPS/pGXwwuSL31AB7Q5mraHyxCOwuiGn1Ht0t0rYu', '2', '', '', '0000-00-00 00:00:00', '2024-11-10 21:14:32.228120', '', NULL, '2024-11-10 21:11:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `appointment_info`
--
ALTER TABLE `appointment_info`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `fk_appointment_ic` (`ic`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD KEY `bill_id` (`bill_id`) USING BTREE;

--
-- Indexes for table `clinic_bills`
--
ALTER TABLE `clinic_bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_ic` (`patient_ic`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_info`
--
ALTER TABLE `staff_info`
  ADD PRIMARY KEY (`STAFF_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `uq_IC` (`IC`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_info`
--
ALTER TABLE `appointment_info`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `clinic_bills`
--
ALTER TABLE `clinic_bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_feedback`
--
ALTER TABLE `user_feedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_info`
--
ALTER TABLE `appointment_info`
  ADD CONSTRAINT `fk_appointment_ic` FOREIGN KEY (`ic`) REFERENCES `user_info` (`IC`);

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `clinic_bills` (`bill_id`) ON DELETE CASCADE;

--
-- Constraints for table `clinic_bills`
--
ALTER TABLE `clinic_bills`
  ADD CONSTRAINT `fk_patient_ic` FOREIGN KEY (`patient_ic`) REFERENCES `user_info` (`IC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
