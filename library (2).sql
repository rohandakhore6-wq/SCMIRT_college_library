-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 10:08 AM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'rohan dakhore', '782305'),
(2, 'Rohan Losare', '3575');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(150) NOT NULL,
  `author` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `author`, `quantity`) VALUES
(1, 'Programming in C', 'E. Balagurusamy', 7),
(2, 'Data Structures Using C', 'Reema Thareja', 11),
(3, 'Database Management System', 'Raghu Ramakrishnan', 6),
(4, 'Operating System Concepts', 'Silberschatz', 5),
(5, 'Computer Networks', 'Andrew S. Tanenbaum', 9),
(6, 'Software Engineering', 'Ian Sommerville', 8),
(7, 'Object Oriented Programming with C++', 'E. Balagurusamy', 9),
(9, 'Python Programming', 'Mark Lutz', 10),
(10, 'web technology', 'kogent learning solution Inc', 19);

-- --------------------------------------------------------

--
-- Table structure for table `book_requests`
--

CREATE TABLE `book_requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_requests`
--

INSERT INTO `book_requests` (`id`, `student_id`, `book_id`, `status`) VALUES
(1, 3, 1, 'Approved'),
(2, 3, 5, 'Approved'),
(3, 3, 7, 'Approved'),
(4, 3, 4, 'Rejected'),
(5, 3, 5, 'Approved'),
(6, 5, 1, 'Approved'),
(7, 6, 8, 'Approved'),
(8, 6, 5, 'Rejected'),
(9, 6, 1, 'Approved'),
(10, 7, 3, 'Approved'),
(11, 7, 4, 'Approved'),
(12, 3, 1, 'Approved'),
(13, 3, 5, 'Approved'),
(14, 3, 1, 'Approved'),
(15, 6, 2, 'Approved'),
(16, 6, 2, 'Approved'),
(17, 8, 1, 'Approved'),
(18, 9, 1, 'Approved'),
(19, 9, 1, 'Rejected'),
(20, 9, 1, 'Rejected'),
(21, 9, 10, 'Approved'),
(22, 9, 10, 'Pending'),
(23, 9, 10, 'Pending'),
(24, 9, 10, 'Pending'),
(25, 9, 10, 'Pending'),
(26, 6, 1, 'Approved'),
(27, 6, 1, 'Approved'),
(28, 6, 1, 'Approved'),
(29, 3, 2, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

CREATE TABLE `issued_books` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_books`
--

INSERT INTO `issued_books` (`id`, `student_id`, `book_id`, `issue_date`, `return_date`, `status`, `due_date`) VALUES
(1, 3, 5, '2026-02-27', '2026-02-27', 'Returned', '2026-03-04'),
(2, 3, 7, '2026-02-27', '2026-02-27', 'Returned', '2026-03-04'),
(3, 3, 5, '2026-02-27', '2026-03-21', 'Returned', '2026-03-04'),
(4, 5, 1, '2026-02-28', '2026-02-28', 'Returned', '2026-03-05'),
(5, 6, 8, '2026-03-04', NULL, 'Issued', '2026-03-09'),
(6, 6, 1, '2026-03-04', '2026-03-19', 'Returned', '2026-03-09'),
(7, 7, 3, '2026-03-19', NULL, 'Issued', '2026-03-24'),
(8, 7, 4, '2026-03-21', NULL, 'Issued', '2026-03-26'),
(9, 7, 4, '2026-03-21', NULL, 'Issued', '2026-03-26'),
(10, 7, 4, '2026-03-21', NULL, 'Issued', '2026-03-26'),
(11, 3, 1, '2026-03-21', '2026-03-21', 'Returned', '2026-03-26'),
(12, 3, 1, '2026-03-21', '2026-03-21', 'Returned', '2026-03-26'),
(13, 3, 1, '2026-03-21', '2026-03-21', 'Returned', '2026-03-26'),
(14, 3, 1, '2026-03-21', '2026-03-21', 'Returned', '2026-03-26'),
(15, 3, 5, '2026-03-21', '2026-03-21', 'Returned', '2026-03-26'),
(16, 3, 5, '2026-03-21', '2026-03-21', 'Returned', '2026-03-26'),
(17, 3, 5, '2026-03-21', NULL, 'Issued', '2026-03-26'),
(18, 3, 5, '2026-03-21', NULL, 'Issued', '2026-03-26'),
(19, 3, 1, '2026-03-21', NULL, 'Issued', '2026-03-26'),
(20, 6, 2, '2026-03-22', '2026-03-29', 'Returned', '2026-03-27'),
(21, 6, 2, '2026-03-22', NULL, 'Issued', '2026-03-27'),
(22, 8, 1, '2026-03-25', NULL, 'Issued', '2026-03-30'),
(23, 9, 1, '2026-03-28', NULL, 'Issued', '2026-04-02'),
(24, 9, 10, '2026-03-28', NULL, 'Issued', '2026-04-02'),
(25, 6, 1, '2026-03-28', NULL, 'Issued', '2026-04-02'),
(26, 6, 1, '2026-03-28', NULL, 'Issued', '2026-04-02'),
(27, 6, 1, '2026-03-28', NULL, 'Return Pending', '2026-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `message`, `created_at`) VALUES
(1, 'today library close \r\n', '2026-03-28 04:57:54'),
(2, 'today library close \r\n', '2026-03-28 04:59:01'),
(3, 'hi\r\n', '2026-03-28 18:47:00'),
(4, 'ji', '2026-03-28 18:58:28'),
(5, '1', '2026-03-28 19:04:26'),
(6, '1', '2026-03-28 19:04:26'),
(7, '1', '2026-03-28 19:04:52'),
(8, '1', '2026-03-28 19:04:52'),
(9, '1', '2026-03-28 19:05:32'),
(10, '1', '2026-03-28 19:06:06'),
(11, 'today library close', '2026-03-30 10:36:48'),
(12, 'today library open', '2026-03-30 10:37:06'),
(13, 'today library close', '2026-03-30 10:37:17'),
(14, 'today library close', '2026-03-30 10:37:24'),
(15, 'today library close', '2026-03-30 10:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `student_id`, `message`, `created_at`, `is_read`) VALUES
(1, 3, '✅ Book Approved: Computer Networks', '2026-03-21 06:01:00', 0),
(2, 3, '📖 Book Issued: Computer Networks on 21-03-2026 07:01 AM', '2026-03-21 06:01:00', 0),
(3, 3, '📅 Return Computer Networks before 2026-03-26', '2026-03-21 06:01:00', 0),
(4, 3, '✅ Book Approved: Computer Networks', '2026-03-21 06:26:16', 0),
(5, 3, '📖 Book Issued: Computer Networks on 21-03-2026 07:26 AM', '2026-03-21 06:26:16', 0),
(6, 3, '📅 Return Computer Networks before 2026-03-26', '2026-03-21 06:26:16', 0),
(7, 3, '💸 Fine ₹85 for Computer Networks (Late by 17 days)', '2026-03-21 06:38:51', 0),
(8, 3, '🔁 Return request sent for Computer Networks', '2026-03-21 06:50:46', 0),
(9, 3, '🔁 Return request sent for Programming in C', '2026-03-21 06:51:15', 0),
(10, 3, '📚 Book Returned Successfully', '2026-03-21 07:20:12', 0),
(11, 3, '✅ Book Approved: Programming in C', '2026-03-21 08:20:25', 0),
(12, 3, '📖 Book Issued: Programming in C on 21-03-2026 09:20 AM', '2026-03-21 08:20:25', 0),
(13, 3, '📅 Return Programming in C before 2026-03-26', '2026-03-21 08:20:25', 0),
(14, 3, '📚 Book Returned Successfully', '2026-03-21 08:21:25', 0),
(15, 3, '📚 Book Returned Successfully', '2026-03-21 08:22:58', 0),
(16, 6, '💸 Fine ₹60 for Discrete Mathematics (Late by 12 days)', '2026-03-21 08:26:54', 0),
(17, 3, '📚 Book Returned Successfully', '2026-03-21 10:02:55', 0),
(18, 3, '📚 Book Returned Successfully', '2026-03-21 10:02:59', 0),
(19, 6, '✅ Book Approved: Data Structures Using C', '2026-03-22 04:47:06', 0),
(20, 6, '📖 Book Issued: Data Structures Using C on 22-03-2026 05:47 AM', '2026-03-22 04:47:06', 0),
(21, 6, '📅 Return Data Structures Using C before 2026-03-27', '2026-03-22 04:47:06', 0),
(22, 6, '✅ Book Approved: Data Structures Using C', '2026-03-22 04:48:17', 0),
(23, 6, '📖 Book Issued: Data Structures Using C on 22-03-2026 05:48 AM', '2026-03-22 04:48:17', 0),
(24, 6, '📅 Return Data Structures Using C before 2026-03-27', '2026-03-22 04:48:17', 0),
(25, 8, '✅ Book Approved: Programming in C', '2026-03-25 14:15:28', 0),
(26, 8, '📖 Book Issued: Programming in C on 25-03-2026 03:15 PM', '2026-03-25 14:15:28', 0),
(27, 8, '📅 Return Programming in C before 2026-03-30', '2026-03-25 14:15:28', 0),
(28, 9, '✅ Book Approved: Programming in C', '2026-03-28 04:55:08', 0),
(29, 9, '📖 Book Issued: Programming in C on 28-03-2026 05:55 AM', '2026-03-28 04:55:08', 0),
(30, 9, '📅 Return Programming in C before 2026-04-02', '2026-03-28 04:55:08', 0),
(31, 9, '❌ Book Request Rejected: Programming in C', '2026-03-28 04:55:29', 0),
(32, 9, '❌ Book Request Rejected: Programming in C', '2026-03-28 04:55:38', 0),
(33, 1, 'ji', '2026-03-28 18:58:28', 0),
(34, 2, 'ji', '2026-03-28 18:58:28', 0),
(35, 3, 'ji', '2026-03-28 18:58:28', 0),
(36, 4, 'ji', '2026-03-28 18:58:28', 0),
(37, 5, 'ji', '2026-03-28 18:58:28', 0),
(38, 6, 'ji', '2026-03-28 18:58:28', 0),
(39, 7, 'ji', '2026-03-28 18:58:28', 0),
(40, 8, 'ji', '2026-03-28 18:58:28', 0),
(41, 9, 'ji', '2026-03-28 18:58:28', 0),
(42, 1, '1', '2026-03-28 19:04:26', 0),
(43, 2, '1', '2026-03-28 19:04:26', 0),
(44, 3, '1', '2026-03-28 19:04:26', 0),
(45, 4, '1', '2026-03-28 19:04:26', 0),
(46, 5, '1', '2026-03-28 19:04:26', 0),
(47, 6, '1', '2026-03-28 19:04:26', 0),
(48, 7, '1', '2026-03-28 19:04:26', 0),
(49, 8, '1', '2026-03-28 19:04:26', 0),
(50, 9, '1', '2026-03-28 19:04:26', 0),
(51, 1, '1', '2026-03-28 19:04:26', 0),
(52, 2, '1', '2026-03-28 19:04:26', 0),
(53, 3, '1', '2026-03-28 19:04:26', 0),
(54, 4, '1', '2026-03-28 19:04:26', 0),
(55, 5, '1', '2026-03-28 19:04:26', 0),
(56, 6, '1', '2026-03-28 19:04:26', 0),
(57, 7, '1', '2026-03-28 19:04:26', 0),
(58, 8, '1', '2026-03-28 19:04:26', 0),
(59, 9, '1', '2026-03-28 19:04:26', 0),
(60, 1, '1', '2026-03-28 19:04:52', 0),
(61, 2, '1', '2026-03-28 19:04:52', 0),
(62, 3, '1', '2026-03-28 19:04:52', 0),
(63, 4, '1', '2026-03-28 19:04:52', 0),
(64, 5, '1', '2026-03-28 19:04:52', 0),
(65, 6, '1', '2026-03-28 19:04:52', 0),
(66, 7, '1', '2026-03-28 19:04:52', 0),
(67, 8, '1', '2026-03-28 19:04:52', 0),
(68, 9, '1', '2026-03-28 19:04:52', 0),
(69, 1, '1', '2026-03-28 19:04:52', 0),
(70, 2, '1', '2026-03-28 19:04:52', 0),
(71, 3, '1', '2026-03-28 19:04:52', 0),
(72, 4, '1', '2026-03-28 19:04:52', 0),
(73, 5, '1', '2026-03-28 19:04:52', 0),
(74, 6, '1', '2026-03-28 19:04:52', 0),
(75, 7, '1', '2026-03-28 19:04:52', 0),
(76, 8, '1', '2026-03-28 19:04:52', 0),
(77, 9, '1', '2026-03-28 19:04:52', 0),
(78, 1, '1', '2026-03-28 19:05:32', 0),
(79, 2, '1', '2026-03-28 19:05:32', 0),
(80, 3, '1', '2026-03-28 19:05:32', 0),
(81, 4, '1', '2026-03-28 19:05:32', 0),
(82, 5, '1', '2026-03-28 19:05:32', 0),
(83, 6, '1', '2026-03-28 19:05:32', 0),
(84, 7, '1', '2026-03-28 19:05:32', 0),
(85, 8, '1', '2026-03-28 19:05:32', 0),
(86, 9, '1', '2026-03-28 19:05:32', 0),
(87, 1, '1', '2026-03-28 19:06:06', 0),
(88, 2, '1', '2026-03-28 19:06:06', 0),
(89, 3, '1', '2026-03-28 19:06:06', 0),
(90, 4, '1', '2026-03-28 19:06:06', 0),
(91, 5, '1', '2026-03-28 19:06:06', 0),
(92, 6, '1', '2026-03-28 19:06:06', 0),
(93, 7, '1', '2026-03-28 19:06:06', 0),
(94, 8, '1', '2026-03-28 19:06:06', 0),
(95, 9, '1', '2026-03-28 19:06:06', 0),
(96, 6, '💸 Fine ₹5 for Data Structures Using C (Late by 1 days)', '2026-03-28 19:20:27', 0),
(97, 6, '🔁 Return request sent for Data Structures Using C', '2026-03-28 19:20:31', 0),
(98, 6, '📚 Book Returned Successfully', '2026-03-28 19:21:04', 0),
(99, 9, '✅ Book Approved: web technology', '2026-03-28 20:05:28', 0),
(100, 9, '📖 Book Issued: web technology on 28-03-2026 09:05 PM', '2026-03-28 20:05:28', 0),
(101, 9, '📅 Return web technology before 2026-04-02', '2026-03-28 20:05:28', 0),
(102, 6, '✅ Book Approved: Programming in C', '2026-03-28 20:06:07', 0),
(103, 6, '📖 Book Issued: Programming in C on 28-03-2026 09:06 PM', '2026-03-28 20:06:07', 0),
(104, 6, '📅 Return Programming in C before 2026-04-02', '2026-03-28 20:06:07', 0),
(105, 6, '✅ Book Approved: Programming in C', '2026-03-28 20:06:59', 0),
(106, 6, '📖 Book Issued: Programming in C on 28-03-2026 09:06 PM', '2026-03-28 20:06:59', 0),
(107, 6, '📅 Return Programming in C before 2026-04-02', '2026-03-28 20:06:59', 0),
(108, 6, '✅ Book Approved: Programming in C', '2026-03-28 20:07:50', 0),
(109, 6, '📖 Book Issued: Programming in C on 28-03-2026 09:07 PM', '2026-03-28 20:07:50', 0),
(110, 6, '📅 Return Programming in C before 2026-04-02', '2026-03-28 20:07:50', 0),
(111, 6, '🔁 Return request sent for Programming in C', '2026-03-28 20:10:03', 0),
(112, 6, '💸 Fine ₹14.791666666667 for Data Structures Using C (Late by 2.9583333333333 days)', '2026-03-30 10:04:19', 0),
(113, 3, '💸 Fine ₹19.791666666667 for Computer Networks (Late by 3.9583333333333 days)', '2026-03-30 10:12:26', 0),
(114, 3, '💸 Fine ₹19.791666666667 for Programming in C (Late by 3.9583333333333 days)', '2026-03-30 10:12:26', 0),
(115, 3, '💸 Fine ₹15 for Computer Networks (Late by 3 days)', '2026-03-30 10:24:13', 0),
(116, 3, '💸 Fine ₹15 for Programming in C (Late by 3 days)', '2026-03-30 10:24:13', 0),
(117, 2, 'today library close', '2026-03-30 10:36:48', 0),
(118, 3, 'today library close', '2026-03-30 10:36:48', 0),
(119, 4, 'today library close', '2026-03-30 10:36:48', 0),
(120, 5, 'today library close', '2026-03-30 10:36:48', 0),
(121, 6, 'today library close', '2026-03-30 10:36:48', 0),
(122, 7, 'today library close', '2026-03-30 10:36:48', 0),
(123, 8, 'today library close', '2026-03-30 10:36:48', 0),
(124, 9, 'today library close', '2026-03-30 10:36:48', 0),
(125, 2, 'today library open', '2026-03-30 10:37:06', 0),
(126, 3, 'today library open', '2026-03-30 10:37:06', 0),
(127, 4, 'today library open', '2026-03-30 10:37:06', 0),
(128, 5, 'today library open', '2026-03-30 10:37:06', 0),
(129, 6, 'today library open', '2026-03-30 10:37:06', 0),
(130, 7, 'today library open', '2026-03-30 10:37:06', 0),
(131, 8, 'today library open', '2026-03-30 10:37:06', 0),
(132, 9, 'today library open', '2026-03-30 10:37:06', 0),
(133, 2, 'today library close', '2026-03-30 10:37:17', 0),
(134, 3, 'today library close', '2026-03-30 10:37:17', 0),
(135, 4, 'today library close', '2026-03-30 10:37:17', 0),
(136, 5, 'today library close', '2026-03-30 10:37:17', 0),
(137, 6, 'today library close', '2026-03-30 10:37:17', 0),
(138, 7, 'today library close', '2026-03-30 10:37:17', 0),
(139, 8, 'today library close', '2026-03-30 10:37:17', 0),
(140, 9, 'today library close', '2026-03-30 10:37:17', 0),
(141, 2, 'today library close', '2026-03-30 10:37:24', 0),
(142, 3, 'today library close', '2026-03-30 10:37:24', 0),
(143, 4, 'today library close', '2026-03-30 10:37:24', 0),
(144, 5, 'today library close', '2026-03-30 10:37:24', 0),
(145, 6, 'today library close', '2026-03-30 10:37:24', 0),
(146, 7, 'today library close', '2026-03-30 10:37:24', 0),
(147, 8, 'today library close', '2026-03-30 10:37:24', 0),
(148, 9, 'today library close', '2026-03-30 10:37:24', 0),
(149, 2, 'today library close', '2026-03-30 10:50:11', 0),
(150, 3, 'today library close', '2026-03-30 10:50:11', 0),
(151, 4, 'today library close', '2026-03-30 10:50:11', 0),
(152, 5, 'today library close', '2026-03-30 10:50:11', 0),
(153, 6, 'today library close', '2026-03-30 10:50:11', 0),
(154, 7, 'today library close', '2026-03-30 10:50:11', 0),
(155, 8, 'today library close', '2026-03-30 10:50:11', 0),
(156, 9, 'today library close', '2026-03-30 10:50:11', 0),
(157, 6, '💸 Fine ₹45 for Data Structures Using C (Late by 9 days)', '2026-04-06 11:44:07', 0),
(158, 6, '💸 Fine ₹20 for Programming in C (Late by 4 days)', '2026-04-06 11:44:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `payment_method` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `issue_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `student_id`, `amount`, `payment_method`, `status`, `payment_date`, `issue_id`) VALUES
(1, 6, 5, 'CASH', 'approved', '2026-04-03 11:45:49', NULL),
(2, 6, 120, 'UPI', 'paid', '2026-04-03 11:46:02', NULL),
(3, 6, 30, 'UPI', 'paid', '2026-04-03 11:52:59', NULL),
(4, 6, 30, 'UPI', 'paid', '2026-04-03 12:11:07', NULL),
(5, 6, 30, 'UPI', 'paid', '2026-04-03 12:14:33', NULL),
(6, 6, 45, 'UPI', 'paid', '2026-04-06 10:51:42', NULL),
(7, 6, 45, 'CASH', 'approved', '2026-04-06 10:59:46', NULL),
(8, 6, 20, 'UPI', 'paid', '2026-04-06 11:05:42', NULL),
(9, 6, 45, 'CASH', 'approved', '2026-04-06 11:49:05', NULL),
(10, 6, 45, 'CASH', 'approved', '2026-04-06 11:57:25', 21),
(11, 6, 30, 'UPI', 'paid', '2026-04-08 16:20:52', 25);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `email`, `password`, `course`, `mobile`) VALUES
(2, 'ram patil', 'shampatil@gmail.com', '8007036896', 'MBA', '9284919241'),
(3, 'santosh k patil', 'santosh@gmail.com', '782305', 'BBA', '8626002978'),
(4, 'dinesh patil', 'dinesh@gmail.com', '782305', 'MBA', '8007093896'),
(5, 'malleshbhandari', 'mallesh@gmail.com', 'mallu@123', 'MCA', '1234567890'),
(6, 'vitthal korade', 'vitthal@gmail.com', '782305', 'BCA', '9284919241'),
(7, 'vishal korade', 'vishal@gmail.com', '7875', 'MBA', '9689337875'),
(8, 'soham chaudhari', 'soham@gmailcom', 'soham', 'BSC CS', '8381095886'),
(9, 'mangesh ', 'mangesh12@gmail.com', 'mangu123', 'BCS', '123123123');

-- --------------------------------------------------------

--
-- Table structure for table `students_login`
--

CREATE TABLE `students_login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_login`
--

INSERT INTO `students_login` (`id`, `username`, `email`, `password`, `course`, `mobile`) VALUES
(1, 'Rohan', 'rohan@gmail.com', '123', 'BSc CS', '9876543210');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `book_requests`
--
ALTER TABLE `book_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `students_login`
--
ALTER TABLE `students_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `book_requests`
--
ALTER TABLE `book_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `issued_books`
--
ALTER TABLE `issued_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students_login`
--
ALTER TABLE `students_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
