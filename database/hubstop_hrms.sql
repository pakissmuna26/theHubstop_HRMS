-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 12:22 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hubstop_hrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applicant_application`
--

CREATE TABLE `tbl_applicant_application` (
  `applicant_application_id` int(11) NOT NULL,
  `applicant_application_code` varchar(255) DEFAULT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `application_category` varchar(255) DEFAULT NULL,
  `application_remarks` mediumtext,
  `application_contract_status` varchar(255) DEFAULT NULL,
  `application_contract_start_date` date DEFAULT NULL,
  `application_contract_end_date` date DEFAULT NULL,
  `application_created_at` varchar(255) DEFAULT NULL,
  `application_status` varchar(45) DEFAULT NULL,
  `application_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_applicant_application`
--

INSERT INTO `tbl_applicant_application` (`applicant_application_id`, `applicant_application_code`, `applicant_id`, `contract_id`, `application_category`, `application_remarks`, `application_contract_status`, `application_contract_start_date`, `application_contract_end_date`, `application_created_at`, `application_status`, `application_added_by`) VALUES
(1, 'JOB-APPLICATION-000001', 4, 1, 'Application Submitted', '', 'Activated', '2023-06-05', '0000-00-00', '2023-07-24 @ 11:25:47 PM', 'Accepted', 4),
(2, 'JOB-APPLICATION-000002', 5, 1, 'Application Submitted', '', 'Activated', '2023-06-05', '0000-00-00', '2023-07-30 @ 02:15:16 AM', 'Accepted', 5),
(3, 'JOB-APPLICATION-000003', 6, 1, 'Application Submitted', '', 'Pending', '0000-00-00', '0000-00-00', '2023-07-30 @ 11:16:23 PM', 'Pending', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_application_history`
--

CREATE TABLE `tbl_application_history` (
  `application_history_id` int(11) NOT NULL,
  `application_history_code` varchar(255) DEFAULT NULL,
  `applicant_application_id` int(11) DEFAULT NULL,
  `history_category` varchar(255) DEFAULT NULL,
  `history_title` mediumtext,
  `history_description` mediumtext,
  `history_date` date DEFAULT NULL,
  `history_time` varchar(45) DEFAULT NULL,
  `history_remarks` mediumtext,
  `application_history_created_at` varchar(255) DEFAULT NULL,
  `application_history_status` varchar(45) DEFAULT NULL,
  `application_history_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_application_history`
--

INSERT INTO `tbl_application_history` (`application_history_id`, `application_history_code`, `applicant_application_id`, `history_category`, `history_title`, `history_description`, `history_date`, `history_time`, `history_remarks`, `application_history_created_at`, `application_history_status`, `application_history_added_by`) VALUES
(1, 'JOB-APPLICATION-HISTORY-000001', 1, 'Application Submitted', 'For Confirmation', '', '0000-00-00', '', '', '2023-07-24 @ 11:25:47 PM', 'Accepted', 4),
(2, 'JOB-APPLICATION-HISTORY-000002', 1, 'Initial Interview', 'Interview', '', '2023-06-02', '10:00', '', '2023-07-24 @ 11:34:35 PM', 'Passed', 2),
(3, 'JOB-APPLICATION-HISTORY-000003', 1, 'Technical Exam', 'Exam', '', '2023-06-02', '13:00', '', '2023-07-24 @ 11:34:48 PM', 'Passed', 2),
(4, 'JOB-APPLICATION-HISTORY-000004', 1, 'For Contract Signing', 'Contract Signing', '', '2023-06-02', '16:00', '', '2023-07-24 @ 11:35:23 PM', 'Done', 2),
(5, 'JOB-APPLICATION-HISTORY-000005', 2, 'Application Submitted', 'For Confirmation', '', '0000-00-00', '', '', '2023-07-30 @ 02:15:16 AM', 'Accepted', 5),
(6, 'JOB-APPLICATION-HISTORY-000006', 2, 'Initial Interview', 'Interview', '', '2023-06-02', '09:00', '', '2023-07-30 @ 02:17:43 AM', 'Passed', 2),
(7, 'JOB-APPLICATION-HISTORY-000007', 2, 'Technical Exam', 'Exam', '', '2023-06-02', '10:30', '', '2023-07-30 @ 02:18:05 AM', 'Passed', 2),
(8, 'JOB-APPLICATION-HISTORY-000008', 2, 'For Contract Signing', 'Contract Signing', '', '2023-06-02', '15:30', '', '2023-07-30 @ 02:18:23 AM', 'Done', 2),
(9, 'JOB-APPLICATION-HISTORY-000009', 3, 'Application Submitted', 'For Confirmation', '', '0000-00-00', '', '', '2023-07-30 @ 11:16:23 PM', 'Pending', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(11) NOT NULL,
  `attendance_code` varchar(255) DEFAULT NULL,
  `attendance_category` varchar(45) DEFAULT NULL,
  `attendance_type` varchar(255) DEFAULT NULL,
  `attendance_date_in` date DEFAULT NULL,
  `attendance_time_in` varchar(45) DEFAULT NULL,
  `attendance_date_out` date DEFAULT NULL,
  `attendance_time_out` varchar(45) DEFAULT NULL,
  `attendance_requested_by` int(11) DEFAULT NULL,
  `attendance_approved_by` int(11) DEFAULT NULL,
  `attendance_created_at` varchar(255) DEFAULT NULL,
  `attendance_status` varchar(45) DEFAULT NULL,
  `attendance_added_by` int(11) DEFAULT NULL,
  `payroll_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendance_id`, `attendance_code`, `attendance_category`, `attendance_type`, `attendance_date_in`, `attendance_time_in`, `attendance_date_out`, `attendance_time_out`, `attendance_requested_by`, `attendance_approved_by`, `attendance_created_at`, `attendance_status`, `attendance_added_by`, `payroll_id`) VALUES
(1, 'ATTENDANCE-000001', 'Manual', 'Daily', '2023-06-05', '08:00', '2023-06-05', '17:00', 4, 2, '2023-07-24 @ 11:42:46 PM', 'Payroll', 2, 1),
(2, 'ATTENDANCE-000002', 'Manual', 'Daily', '2023-06-06', '07:50', '2023-06-06', '17:00', 4, 2, '2023-07-24 @ 11:43:04 PM', 'Payroll', 2, 1),
(3, 'ATTENDANCE-000003', 'Manual', 'Daily', '2023-06-07', '08:00', '2023-06-07', '17:00', 4, 2, '2023-07-24 @ 11:44:05 PM', 'Payroll', 2, 1),
(4, 'ATTENDANCE-000004', 'Manual', 'Daily', '2023-06-08', '08:00', '2023-06-08', '17:00', 4, 2, '2023-07-24 @ 11:44:59 PM', 'Payroll', 2, 1),
(5, 'ATTENDANCE-000005', 'Manual', 'Daily', '2023-06-09', '08:00', '2023-06-09', '17:00', 4, 2, '2023-07-24 @ 11:45:13 PM', 'Approved', 2, 0),
(6, 'ATTENDANCE-000006', 'Manual', 'Daily', '2023-06-12', '08:00', '2023-06-12', '17:00', 4, 2, '2023-07-24 @ 11:46:04 PM', 'Approved', 2, 0),
(7, 'ATTENDANCE-000007', 'Manual', 'Daily', '2023-06-13', '08:00', '2023-06-13', '17:00', 4, 2, '2023-07-24 @ 11:46:15 PM', 'Approved', 2, 0),
(8, 'ATTENDANCE-000008', 'Manual', 'Daily', '2023-06-14', '08:00', '2023-06-14', '17:00', 4, 2, '2023-07-24 @ 11:46:27 PM', 'Approved', 2, 0),
(9, 'ATTENDANCE-000009', 'Manual', 'Daily', '2023-06-15', '08:00', '2023-06-15', '17:00', 4, 2, '2023-07-24 @ 11:46:38 PM', 'Approved', 2, 0),
(10, 'ATTENDANCE-000010', 'Manual', 'Daily', '2023-06-16', '08:00', '2023-06-16', '17:00', 4, 2, '2023-07-24 @ 11:52:54 PM', 'Approved', 2, 0),
(11, 'ATTENDANCE-000011', 'Manual', 'Daily', '2023-06-17', '08:00', '2023-06-17', '17:00', 4, 2, '2023-07-24 @ 11:53:07 PM', 'Denied', 2, 0),
(12, 'ATTENDANCE-000012', 'Manual', 'Daily', '2023-06-18', '08:00', '2023-06-18', '17:00', 4, 2, '2023-07-24 @ 11:53:35 PM', 'Denied', 2, 0),
(13, 'ATTENDANCE-000013', 'Manual', 'Daily', '2023-06-19', '08:00', '2023-06-19', '17:00', 4, 2, '2023-07-24 @ 11:53:46 PM', 'Approved', 2, 0),
(14, 'ATTENDANCE-000014', 'Manual', 'Daily', '2023-06-20', '08:00', '2023-06-20', '17:00', 4, 2, '2023-07-24 @ 11:54:01 PM', 'Approved', 2, 0),
(15, 'ATTENDANCE-000015', 'Manual', 'Daily', '2023-06-21', '08:00', '2023-06-21', '17:00', 4, 2, '2023-07-24 @ 11:54:12 PM', 'Approved', 2, 0),
(16, 'ATTENDANCE-000016', 'Manual', 'Daily', '2023-06-22', '08:00', '2023-06-22', '17:00', 4, 2, '2023-07-24 @ 11:54:21 PM', 'Approved', 2, 0),
(17, 'ATTENDANCE-000017', 'Manual', 'Daily', '2023-06-23', '08:00', '2023-06-23', '17:00', 4, 2, '2023-07-24 @ 11:54:31 PM', 'Approved', 2, 0),
(18, 'ATTENDANCE-000018', 'Manual', 'Daily', '2023-06-26', '08:00', '2023-06-26', '17:00', 4, 2, '2023-07-24 @ 11:54:46 PM', 'Approved', 2, 0),
(19, 'ATTENDANCE-000019', 'Manual', 'Daily', '2023-06-27', '08:00', '2023-06-27', '17:00', 4, 2, '2023-07-24 @ 11:54:59 PM', 'Approved', 2, 0),
(20, 'ATTENDANCE-000020', 'Manual', 'Daily', '2023-06-28', '08:00', '2023-06-28', '17:00', 4, 2, '2023-07-24 @ 11:55:10 PM', 'Approved', 2, 0),
(21, 'ATTENDANCE-000021', 'Manual', 'Daily', '2023-06-29', '08:00', '2023-06-29', '17:00', 4, 2, '2023-07-25 @ 12:20:20 AM', 'Approved', 2, 0),
(22, 'ATTENDANCE-000022', 'Manual', 'Daily', '2023-06-30', '08:00', '2023-06-30', '17:00', 4, 2, '2023-07-25 @ 12:20:38 AM', 'Approved', 2, 0),
(23, 'ATTENDANCE-000023', 'Manual', 'Daily', '2023-07-03', '08:00', '2023-07-03', '17:00', 4, 2, '2023-07-25 @ 12:21:00 AM', 'Approved', 2, 0),
(24, 'ATTENDANCE-000024', 'Manual', 'Daily', '2023-07-04', '08:00', '2023-07-04', '17:00', 4, 2, '2023-07-25 @ 12:21:19 AM', 'Approved', 2, 0),
(25, 'ATTENDANCE-000025', 'Manual', 'Daily', '2023-07-05', '08:00', '2023-07-05', '17:00', 4, 2, '2023-07-25 @ 12:21:41 AM', 'Approved', 2, 0),
(26, 'ATTENDANCE-000026', 'Manual', 'Daily', '2023-07-06', '08:00', '2023-07-06', '17:00', 4, 2, '2023-07-25 @ 12:22:01 AM', 'Approved', 2, 0),
(27, 'ATTENDANCE-000027', 'Manual', 'Daily', '2023-07-07', '08:00', '2023-07-07', '17:00', 4, 2, '2023-07-25 @ 12:22:18 AM', 'Approved', 2, 0),
(28, 'ATTENDANCE-000028', 'Manual', 'Overtime', '2023-07-07', '17:00', '2023-07-07', '19:00', 4, 1, '2023-07-25 @ 04:53:58 PM', 'Approved', 1, 0),
(29, 'ATTENDANCE-000029', 'Manual', 'Daily', '2023-07-10', '08:00', '2023-07-10', '17:00', 4, 1, '2023-07-25 @ 10:20:15 PM', 'Approved', 1, 0),
(30, 'ATTENDANCE-000030', 'Manual', 'Daily', '2023-06-05', '08:00', '2023-06-05', '17:00', 5, 1, '2023-07-30 @ 02:40:20 AM', 'Approved', 2, 0),
(31, 'ATTENDANCE-000031', 'Manual', 'Daily', '2023-06-06', '08:00', '2023-06-06', '17:00', 5, 1, '2023-07-30 @ 02:42:13 AM', 'Approved', 2, 0),
(32, 'ATTENDANCE-000032', 'Manual', 'Daily', '2023-06-07', '08:00', '2023-06-07', '17:00', 5, 1, '2023-07-30 @ 02:42:29 AM', 'Approved', 2, 0),
(33, 'ATTENDANCE-000033', 'Manual', 'Daily', '2023-06-08', '08:00', '2023-06-08', '17:00', 5, 1, '2023-07-30 @ 02:42:50 AM', 'Approved', 2, 0),
(34, 'ATTENDANCE-000034', 'Manual', 'Daily', '2023-06-09', '08:00', '2023-06-09', '17:00', 5, 1, '2023-07-30 @ 02:43:04 AM', 'Approved', 2, 0),
(35, 'ATTENDANCE-000035', 'Manual', 'Daily', '2023-06-12', '08:00', '2023-06-12', '17:00', 5, 1, '2023-07-30 @ 02:47:50 AM', 'Approved', 2, 0),
(36, 'ATTENDANCE-000036', 'Manual', 'Daily', '2023-06-13', '08:00', '2023-06-13', '17:00', 5, 1, '2023-07-30 @ 02:48:03 AM', 'Approved', 2, 0),
(37, 'ATTENDANCE-000037', 'Manual', 'Daily', '2023-06-14', '08:00', '2023-06-14', '17:00', 5, 1, '2023-07-30 @ 02:48:16 AM', 'Approved', 2, 0),
(38, 'ATTENDANCE-000038', 'Manual', 'Daily', '2023-06-15', '08:00', '2023-06-15', '17:00', 5, 1, '2023-07-30 @ 02:48:28 AM', 'Approved', 2, 0),
(39, 'ATTENDANCE-000039', 'Manual', 'Daily', '2023-06-16', '08:00', '2023-06-16', '17:00', 5, 1, '2023-07-30 @ 02:48:44 AM', 'Approved', 2, 0),
(40, 'ATTENDANCE-000040', 'Manual', 'Daily', '2023-06-19', '08:00', '2023-06-19', '17:00', 5, 1, '2023-07-30 @ 02:53:30 AM', 'Approved', 2, 0),
(41, 'ATTENDANCE-000041', 'Manual', 'Daily', '2023-06-20', '08:00', '2023-06-20', '17:00', 5, 1, '2023-07-30 @ 02:53:44 AM', 'Approved', 2, 0),
(42, 'ATTENDANCE-000042', 'Manual', 'Daily', '2023-06-21', '08:00', '2023-06-21', '17:00', 5, 1, '2023-07-30 @ 02:53:59 AM', 'Approved', 2, 0),
(43, 'ATTENDANCE-000043', 'Manual', 'Daily', '2023-06-22', '08:00', '2023-06-22', '17:00', 5, 1, '2023-07-30 @ 02:54:09 AM', 'Approved', 2, 0),
(44, 'ATTENDANCE-000044', 'Manual', 'Daily', '2023-06-23', '08:00', '2023-06-23', '17:00', 5, 1, '2023-07-30 @ 02:54:21 AM', 'Approved', 2, 0),
(45, 'ATTENDANCE-000045', 'Manual', 'Daily', '2023-06-26', '08:00', '2023-06-26', '17:00', 5, 1, '2023-07-30 @ 02:55:35 AM', 'Approved', 2, 0),
(46, 'ATTENDANCE-000046', 'Manual', 'Daily', '2023-06-27', '08:00', '2023-06-27', '17:00', 5, 1, '2023-07-30 @ 02:55:49 AM', 'Approved', 2, 0),
(47, 'ATTENDANCE-000047', 'Manual', 'Daily', '2023-06-28', '08:00', '2023-06-28', '17:00', 5, 1, '2023-07-30 @ 02:56:05 AM', 'Approved', 2, 0),
(48, 'ATTENDANCE-000048', 'Manual', 'Daily', '2023-06-29', '08:00', '2023-06-29', '17:00', 5, 1, '2023-07-30 @ 02:56:21 AM', 'Approved', 2, 0),
(49, 'ATTENDANCE-000049', 'Manual', 'Daily', '2023-06-30', '08:00', '2023-06-30', '17:00', 5, 1, '2023-07-30 @ 02:56:33 AM', 'Approved', 2, 0),
(50, 'ATTENDANCE-000050', 'Manual', 'Daily', '2023-07-11', '08:00', '2023-07-11', '17:00', 4, 1, '2023-07-30 @ 03:15:59 AM', 'Approved', 2, 0),
(51, 'ATTENDANCE-000051', 'Manual', 'Daily', '2023-07-12', '08:00', '2023-07-12', '17:00', 4, 1, '2023-07-30 @ 03:16:13 AM', 'Approved', 2, 0),
(52, 'ATTENDANCE-000052', 'Manual', 'Daily', '2023-07-13', '08:00', '2023-07-13', '17:00', 4, 1, '2023-07-30 @ 03:17:01 AM', 'Approved', 2, 0),
(53, 'ATTENDANCE-000053', 'Manual', 'Daily', '2023-07-14', '08:00', '2023-07-14', '17:00', 4, 1, '2023-07-30 @ 03:17:15 AM', 'Approved', 2, 0),
(54, 'ATTENDANCE-000054', 'Manual', 'Daily', '2023-07-03', '08:00', '2023-07-03', '17:00', 5, 1, '2023-07-30 @ 03:26:33 AM', 'Approved', 2, 0),
(55, 'ATTENDANCE-000055', 'Manual', 'Daily', '2023-07-04', '08:00', '2023-07-04', '17:00', 5, 1, '2023-07-30 @ 03:27:49 AM', 'Approved', 2, 0),
(56, 'ATTENDANCE-000056', 'Manual', 'Daily', '2023-07-05', '08:00', '2023-07-05', '17:00', 5, 1, '2023-07-30 @ 03:28:04 AM', 'Approved', 2, 0),
(57, 'ATTENDANCE-000057', 'Manual', 'Daily', '2023-07-06', '08:00', '2023-07-06', '17:00', 5, 1, '2023-07-30 @ 03:28:22 AM', 'Approved', 2, 0),
(58, 'ATTENDANCE-000058', 'Manual', 'Daily', '2023-07-07', '08:00', '2023-07-07', '17:00', 5, 1, '2023-07-30 @ 03:28:35 AM', 'Approved', 2, 0),
(59, 'ATTENDANCE-000059', 'Manual', 'Daily', '2023-07-10', '08:00', '2023-07-10', '17:00', 5, 1, '2023-07-31 @ 02:35:46 AM', 'Approved', 2, 0),
(60, 'ATTENDANCE-000060', 'Manual', 'Daily', '2023-07-11', '07:00', '2023-07-11', '17:00', 4, 1, '2023-07-31 @ 10:05:30 PM', 'Approved', 1, 0),
(61, 'ATTENDANCE-000061', 'Manual', 'Daily', '2023-07-12', '08:00', '2023-07-12', '17:00', 4, 1, '2023-07-31 @ 10:24:18 PM', 'Approved', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_benefits_category`
--

CREATE TABLE `tbl_benefits_category` (
  `benefits_category_id` int(11) NOT NULL,
  `benefits_category_code` varchar(255) DEFAULT NULL,
  `benefits_category_title` mediumtext,
  `benefits_category_description` mediumtext,
  `benefits_category_amount` double DEFAULT NULL,
  `benefits_category_created_at` varchar(255) DEFAULT NULL,
  `benefits_category_status` varchar(45) DEFAULT NULL,
  `benefits_category_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_benefits_category`
--

INSERT INTO `tbl_benefits_category` (`benefits_category_id`, `benefits_category_code`, `benefits_category_title`, `benefits_category_description`, `benefits_category_amount`, `benefits_category_created_at`, `benefits_category_status`, `benefits_category_added_by`) VALUES
(1, 'BENEFITS-CATEGORY-000001', 'Transportation Allowance', '', 1500, '2023-07-24 @ 11:21:16 PM', 'Activated', 1),
(2, 'BENEFITS-CATEGORY-000002', 'Internet Allowance', '', 2000, '2023-07-24 @ 11:21:24 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `branch_id` int(11) NOT NULL,
  `branch_code` varchar(255) DEFAULT NULL,
  `branch_name` mediumtext,
  `branch_description` mediumtext,
  `branch_address` mediumtext,
  `branch_barangay` mediumtext,
  `branch_city` mediumtext,
  `branch_province` mediumtext,
  `branch_region` mediumtext,
  `branch_contact_number` varchar(45) DEFAULT NULL,
  `branch_created_at` varchar(255) DEFAULT NULL,
  `branch_status` varchar(45) DEFAULT NULL,
  `branch_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`branch_id`, `branch_code`, `branch_name`, `branch_description`, `branch_address`, `branch_barangay`, `branch_city`, `branch_province`, `branch_region`, `branch_contact_number`, `branch_created_at`, `branch_status`, `branch_added_by`) VALUES
(1, 'BRANCH-000001', 'Branch 1', 'Branch 1 description', '-', 'DITA', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', '9123456789', '2023-07-24 @ 11:15:58 PM', 'Activated', 1),
(2, 'BRANCH-000002', 'Branch 2', 'Branch 2 description', '-', 'DON JOSE', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', '9123456789', '2023-07-24 @ 11:16:14 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_person`
--

CREATE TABLE `tbl_branch_person` (
  `branch_person_id` int(11) NOT NULL,
  `branch_person_code` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `branch_person_remarks` mediumtext,
  `branch_person_created_at` varchar(255) DEFAULT NULL,
  `branch_person_status` varchar(45) DEFAULT NULL,
  `branch_person_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_branch_person`
--

INSERT INTO `tbl_branch_person` (`branch_person_id`, `branch_person_code`, `branch_id`, `person_id`, `branch_person_remarks`, `branch_person_created_at`, `branch_person_status`, `branch_person_added_by`) VALUES
(1, 'BRANCH-PERSON-000001', 1, 2, '', '2023-07-24 @ 11:16:25 PM', 'Added', 1),
(2, 'BRANCH-PERSON-000002', 2, 3, '', '2023-07-24 @ 11:16:40 PM', 'Added', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract`
--

CREATE TABLE `tbl_contract` (
  `contract_id` int(11) NOT NULL,
  `contract_code` varchar(255) DEFAULT NULL,
  `contract_title` mediumtext,
  `contract_description` mediumtext,
  `contract_application_date_from` date DEFAULT NULL,
  `contract_application_date_to` date DEFAULT NULL,
  `contract_starting_date` date DEFAULT NULL,
  `contract_job_position_id` int(11) DEFAULT NULL,
  `contract_rate` double DEFAULT NULL,
  `contract_shifting_schedule_id` int(11) DEFAULT NULL,
  `contract_created_at` varchar(255) DEFAULT NULL,
  `contract_status` varchar(45) DEFAULT NULL,
  `contract_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contract`
--

INSERT INTO `tbl_contract` (`contract_id`, `contract_code`, `contract_title`, `contract_description`, `contract_application_date_from`, `contract_application_date_to`, `contract_starting_date`, `contract_job_position_id`, `contract_rate`, `contract_shifting_schedule_id`, `contract_created_at`, `contract_status`, `contract_added_by`) VALUES
(1, 'JOB-CONTRACT-000001', 'June 2023 Contract', '', '2023-06-01', '2023-06-03', '2023-06-05', 1, 23000, 1, '2023-07-24 @ 11:23:23 PM', 'Activated', 1),
(2, 'JOB-CONTRACT-000002', 'June 2023 Contract', '', '2023-06-01', '2023-06-03', '2023-06-05', 2, 20000, 1, '2023-07-24 @ 11:38:31 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract_branch`
--

CREATE TABLE `tbl_contract_branch` (
  `contract_branch_id` int(11) NOT NULL,
  `contract_branch_code` varchar(255) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `contract_branch_created_at` varchar(255) DEFAULT NULL,
  `contract_branch_status` varchar(45) DEFAULT NULL,
  `contract_branch_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contract_branch`
--

INSERT INTO `tbl_contract_branch` (`contract_branch_id`, `contract_branch_code`, `contract_id`, `branch_id`, `contract_branch_created_at`, `contract_branch_status`, `contract_branch_added_by`) VALUES
(1, 'CONTRACT-BRANCH-000001', 1, 1, '2023-07-24 @ 11:24:18 PM', 'Activated', 1),
(2, 'CONTRACT-BRANCH-000002', 2, 2, '2023-07-24 @ 11:39:23 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract_leave_category`
--

CREATE TABLE `tbl_contract_leave_category` (
  `contract_category_credit_id` int(11) NOT NULL,
  `contract_category_credit_code` varchar(45) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `leave_category_id` int(11) DEFAULT NULL,
  `contract_category_credit_created_at` varchar(255) DEFAULT NULL,
  `contract_category_credit_status` varchar(45) DEFAULT NULL,
  `contract_category_credit_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contract_leave_category`
--

INSERT INTO `tbl_contract_leave_category` (`contract_category_credit_id`, `contract_category_credit_code`, `contract_id`, `leave_category_id`, `contract_category_credit_created_at`, `contract_category_credit_status`, `contract_category_credit_added_by`) VALUES
(1, 'CONTRACT-LEAVE-CREDIT-000001', 1, 1, '2023-07-24 @ 11:24:12 PM', 'Activated', 1),
(2, 'CONTRACT-LEAVE-CREDIT-000002', 2, 2, '2023-07-24 @ 11:39:16 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contract_payroll_period`
--

CREATE TABLE `tbl_contract_payroll_period` (
  `contract_payroll_period_id` int(11) NOT NULL,
  `contract_payroll_period_code` varchar(255) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `payroll_period_id` int(11) DEFAULT NULL,
  `contract_payroll_period_created_at` varchar(255) DEFAULT NULL,
  `contract_payroll_period_status` varchar(45) DEFAULT NULL,
  `contract_payroll_period_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contract_payroll_period`
--

INSERT INTO `tbl_contract_payroll_period` (`contract_payroll_period_id`, `contract_payroll_period_code`, `contract_id`, `payroll_period_id`, `contract_payroll_period_created_at`, `contract_payroll_period_status`, `contract_payroll_period_added_by`) VALUES
(1, 'CONTRACT-PAYROLL-000001', 1, 1, '2023-07-24 @ 11:23:39 PM', 'Activated', 1),
(2, 'CONTRACT-PAYROLL-000002', 1, 2, '2023-07-24 @ 11:23:57 PM', 'Activated', 1),
(3, 'CONTRACT-PAYROLL-000003', 2, 1, '2023-07-24 @ 11:38:49 PM', 'Activated', 1),
(4, 'CONTRACT-PAYROLL-000004', 2, 2, '2023-07-24 @ 11:39:02 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deduction_category`
--

CREATE TABLE `tbl_deduction_category` (
  `deduction_category_id` int(11) NOT NULL,
  `deduction_category_code` varchar(255) DEFAULT NULL,
  `deduction_category_title` mediumtext,
  `deduction_category_description` mediumtext,
  `deduction_category_is_percentage` varchar(45) DEFAULT NULL,
  `deduction_category_company_share` double DEFAULT NULL,
  `deduction_category_personnel_share` double DEFAULT NULL,
  `deduction_category_created_at` varchar(255) DEFAULT NULL,
  `deduction_category_status` varchar(45) DEFAULT NULL,
  `deduction_category_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_deduction_category`
--

INSERT INTO `tbl_deduction_category` (`deduction_category_id`, `deduction_category_code`, `deduction_category_title`, `deduction_category_description`, `deduction_category_is_percentage`, `deduction_category_company_share`, `deduction_category_personnel_share`, `deduction_category_created_at`, `deduction_category_status`, `deduction_category_added_by`) VALUES
(1, 'DEDUCTION-CATEGORY-000001', 'SSS', 'Social Security System', 'Yes', 9.5, 4.5, '2023-07-24 @ 11:21:57 PM', 'Activated', 1),
(2, 'DEDUCTION-CATEGORY-000002', 'PHILHEALTH', '', 'Yes', 2.25, 2.25, '2023-07-24 @ 11:22:15 PM', 'Activated', 1),
(3, 'DEDUCTION-CATEGORY-000003', 'HDMF', 'Home Development Mutual Fund', 'No', 100, 100, '2023-07-24 @ 11:22:26 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_holiday`
--

CREATE TABLE `tbl_holiday` (
  `holiday_id` int(11) NOT NULL,
  `holiday_code` varchar(255) DEFAULT NULL,
  `holiday_title` mediumtext,
  `holiday_description` mediumtext,
  `holiday_date_from` date DEFAULT NULL,
  `holiday_date_to` date DEFAULT NULL,
  `holiday_is_paid` varchar(45) DEFAULT NULL,
  `holiday_created_at` varchar(255) DEFAULT NULL,
  `holiday_status` varchar(45) DEFAULT NULL,
  `holiday_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_holiday`
--

INSERT INTO `tbl_holiday` (`holiday_id`, `holiday_code`, `holiday_title`, `holiday_description`, `holiday_date_from`, `holiday_date_to`, `holiday_is_paid`, `holiday_created_at`, `holiday_status`, `holiday_added_by`) VALUES
(1, 'HOLIDAY-000001', 'Philippines Independence Day', '', '2023-06-12', '2023-06-12', 'Yes', '2023-07-25 @ 01:15:46 AM', 'Activated', 1),
(2, 'HOLIDAY-000002', 'EID AL-ADHA', '', '2023-06-28', '2023-06-28', 'Yes', '2023-07-25 @ 01:16:24 AM', 'Activated', 1),
(3, 'HOLIDAY-000003', 'Labour Day', '', '2023-05-01', '2023-05-01', 'Yes', '2023-07-25 @ 05:54:25 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_position`
--

CREATE TABLE `tbl_job_position` (
  `job_position_id` int(11) NOT NULL,
  `job_position_code` varchar(255) DEFAULT NULL,
  `job_position_title` mediumtext,
  `job_position_description` mediumtext,
  `job_position_created_at` varchar(255) DEFAULT NULL,
  `job_position_status` varchar(45) DEFAULT NULL,
  `job_position_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_position`
--

INSERT INTO `tbl_job_position` (`job_position_id`, `job_position_code`, `job_position_title`, `job_position_description`, `job_position_created_at`, `job_position_status`, `job_position_added_by`) VALUES
(1, 'JOB-POSITION-000001', 'Job Position 1', 'Job Position 1 description', '2023-07-24 @ 11:17:59 PM', 'Activated', 1),
(2, 'JOB-POSITION-000002', 'Job Position 2', 'Job Position 2 description', '2023-07-24 @ 11:18:06 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_category`
--

CREATE TABLE `tbl_leave_category` (
  `leave_category_id` int(11) NOT NULL,
  `leave_category_code` varchar(255) DEFAULT NULL,
  `leave_category_title` mediumtext,
  `leave_category_description` mediumtext,
  `leave_category_quantity` double DEFAULT NULL,
  `leave_category_paid_quantity` double DEFAULT NULL,
  `leave_category_created_at` varchar(255) DEFAULT NULL,
  `leave_category_status` varchar(45) DEFAULT NULL,
  `leave_category_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_leave_category`
--

INSERT INTO `tbl_leave_category` (`leave_category_id`, `leave_category_code`, `leave_category_title`, `leave_category_description`, `leave_category_quantity`, `leave_category_paid_quantity`, `leave_category_created_at`, `leave_category_status`, `leave_category_added_by`) VALUES
(1, 'LEAVE-CATEGORY-000001', 'Leave 1', 'Leave 1 description', 10, 4, '2023-07-24 @ 11:20:47 PM', 'Activated', 1),
(2, 'LEAVE-CATEGORY-000002', 'Leave 2', 'Leave 2 description', 10, 5, '2023-07-24 @ 11:20:56 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_request`
--

CREATE TABLE `tbl_leave_request` (
  `leave_request_id` int(11) NOT NULL,
  `leave_request_code` varchar(255) DEFAULT NULL,
  `leave_request_by` int(11) DEFAULT NULL,
  `leave_request_category_id` int(11) DEFAULT NULL,
  `leave_request_date_from` date DEFAULT NULL,
  `leave_request_date_to` date DEFAULT NULL,
  `leave_request_remarks` mediumtext,
  `leave_request_approved_by` int(11) DEFAULT NULL,
  `leave_request_approved_by_date_time` varchar(255) DEFAULT NULL,
  `leave_request_created_at` varchar(255) DEFAULT NULL,
  `leave_request_status` varchar(45) DEFAULT NULL,
  `leave_request_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll`
--

CREATE TABLE `tbl_payroll` (
  `payroll_id` int(11) NOT NULL,
  `payroll_code` varchar(255) DEFAULT NULL,
  `payroll_person_id` int(11) DEFAULT NULL,
  `payroll_month` int(11) DEFAULT NULL,
  `payroll_year` int(11) DEFAULT NULL,
  `payroll_period_id` int(11) DEFAULT NULL,
  `payroll_salary` double DEFAULT NULL,
  `payroll_absent_adjustment` double DEFAULT NULL,
  `payroll_overtime` double DEFAULT NULL,
  `payroll_non_taxable_earnings` double DEFAULT NULL,
  `payroll_deductions` double DEFAULT NULL,
  `payroll_withholding_tax` double DEFAULT NULL,
  `payroll_net_pay` double DEFAULT NULL,
  `payroll_created_at` varchar(255) DEFAULT NULL,
  `payroll_status` varchar(45) DEFAULT NULL,
  `payroll_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payroll`
--

INSERT INTO `tbl_payroll` (`payroll_id`, `payroll_code`, `payroll_person_id`, `payroll_month`, `payroll_year`, `payroll_period_id`, `payroll_salary`, `payroll_absent_adjustment`, `payroll_overtime`, `payroll_non_taxable_earnings`, `payroll_deductions`, `payroll_withholding_tax`, `payroll_net_pay`, `payroll_created_at`, `payroll_status`, `payroll_added_by`) VALUES
(1, 'PAYROLL-000001', 4, 6, 2023, 1, 4600, 0, 0, 2000, 310.5, 216.67, 6072.83, '2023-07-31 @ 04:11:53 AM', 'Saved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll_benefits_deduction`
--

CREATE TABLE `tbl_payroll_benefits_deduction` (
  `payroll_benefits_deduction_id` int(11) NOT NULL,
  `payroll_benefits_deduction_code` varchar(255) DEFAULT NULL,
  `payroll_id` int(11) DEFAULT NULL,
  `benefits_deduction_id` int(11) DEFAULT NULL,
  `benefits_deduction_amount` double DEFAULT NULL,
  `benefits_deduction_amount_company_share` double DEFAULT NULL,
  `benefits_deduction_category` varchar(45) DEFAULT NULL,
  `payroll_benefits_deduction_created_at` varchar(255) DEFAULT NULL,
  `payroll_benefits_deduction_status` varchar(45) DEFAULT NULL,
  `payroll_benefits_deduction_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payroll_benefits_deduction`
--

INSERT INTO `tbl_payroll_benefits_deduction` (`payroll_benefits_deduction_id`, `payroll_benefits_deduction_code`, `payroll_id`, `benefits_deduction_id`, `benefits_deduction_amount`, `benefits_deduction_amount_company_share`, `benefits_deduction_category`, `payroll_benefits_deduction_created_at`, `payroll_benefits_deduction_status`, `payroll_benefits_deduction_added_by`) VALUES
(1, 'PAYROLL-BENEFITS-000001', 1, 2, 2000, 0, 'Benefits', '2023-07-31 @ 04:11:54 AM', 'Saved', 1),
(2, 'PAYROLL-DEDUCTION-000002', 1, 2, 103.5, 103.5, 'Deduction', '2023-07-31 @ 04:11:54 AM', 'Saved', 1),
(3, 'PAYROLL-DEDUCTION-000003', 1, 1, 207, 437, 'Deduction', '2023-07-31 @ 04:11:54 AM', 'Saved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll_period`
--

CREATE TABLE `tbl_payroll_period` (
  `payroll_period_id` int(11) NOT NULL,
  `payroll_period_code` varchar(255) DEFAULT NULL,
  `payroll_period_title` mediumtext,
  `payroll_period_from` int(11) DEFAULT NULL,
  `payroll_period_to` int(11) DEFAULT NULL,
  `payroll_period_cutoff_from` varchar(45) DEFAULT NULL,
  `payroll_period_cutoff_to` varchar(45) DEFAULT NULL,
  `payroll_period_created_at` varchar(255) DEFAULT NULL,
  `payroll_period_status` varchar(45) DEFAULT NULL,
  `payroll_period_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payroll_period`
--

INSERT INTO `tbl_payroll_period` (`payroll_period_id`, `payroll_period_code`, `payroll_period_title`, `payroll_period_from`, `payroll_period_to`, `payroll_period_cutoff_from`, `payroll_period_cutoff_to`, `payroll_period_created_at`, `payroll_period_status`, `payroll_period_added_by`) VALUES
(1, 'PAYROLL-PERIOD-000001', '1st Cutoff', 1, 15, '23', '8', '2023-07-24 @ 11:20:15 PM', 'Activated', 1),
(2, 'PAYROLL-PERIOD-000002', '2nd Cutoff', 16, 31, '9', '22', '2023-07-24 @ 11:20:29 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll_period_benefits_deduction`
--

CREATE TABLE `tbl_payroll_period_benefits_deduction` (
  `payroll_period_benefits_deduction_id` int(11) NOT NULL,
  `payroll_period_benefits_deduction_code` varchar(45) DEFAULT NULL,
  `contract_payroll_period_id` int(11) DEFAULT NULL,
  `benefits_deduction_id` int(11) DEFAULT NULL,
  `benefits_deduction_category` varchar(45) DEFAULT NULL,
  `payroll_period_benefits_deduction_created_at` varchar(255) DEFAULT NULL,
  `payroll_period_benefits_deduction_status` varchar(45) DEFAULT NULL,
  `payroll_period_benefits_deduction_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payroll_period_benefits_deduction`
--

INSERT INTO `tbl_payroll_period_benefits_deduction` (`payroll_period_benefits_deduction_id`, `payroll_period_benefits_deduction_code`, `contract_payroll_period_id`, `benefits_deduction_id`, `benefits_deduction_category`, `payroll_period_benefits_deduction_created_at`, `payroll_period_benefits_deduction_status`, `payroll_period_benefits_deduction_added_by`) VALUES
(1, 'CONTRACT-BENEFITS-000001', 1, 2, 'Benefits', '2023-07-24 @ 11:23:51 PM', 'Activated', 1),
(2, 'CONTRACT-DEDUCTION-000002', 1, 2, 'Deduction', '2023-07-24 @ 11:23:51 PM', 'Activated', 1),
(3, 'CONTRACT-DEDUCTION-000003', 1, 1, 'Deduction', '2023-07-24 @ 11:23:51 PM', 'Activated', 1),
(4, 'CONTRACT-BENEFITS-000004', 2, 1, 'Benefits', '2023-07-24 @ 11:24:04 PM', 'Activated', 1),
(5, 'CONTRACT-DEDUCTION-000005', 2, 3, 'Deduction', '2023-07-24 @ 11:24:05 PM', 'Activated', 1),
(6, 'CONTRACT-BENEFITS-000006', 3, 2, 'Benefits', '2023-07-24 @ 11:38:58 PM', 'Activated', 1),
(7, 'CONTRACT-DEDUCTION-000007', 3, 2, 'Deduction', '2023-07-24 @ 11:38:58 PM', 'Activated', 1),
(8, 'CONTRACT-DEDUCTION-000008', 3, 1, 'Deduction', '2023-07-24 @ 11:38:59 PM', 'Activated', 1),
(9, 'CONTRACT-BENEFITS-000009', 4, 1, 'Benefits', '2023-07-24 @ 11:39:10 PM', 'Activated', 1),
(10, 'CONTRACT-DEDUCTION-000010', 4, 3, 'Deduction', '2023-07-24 @ 11:39:10 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person`
--

CREATE TABLE `tbl_person` (
  `person_id` int(11) NOT NULL,
  `person_code` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `affiliation_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `civil_status` varchar(45) DEFAULT NULL,
  `house_number` mediumtext,
  `barangay` mediumtext,
  `city` mediumtext,
  `province` mediumtext,
  `region` mediumtext,
  `email_address` mediumtext,
  `contact_number` varchar(12) DEFAULT NULL,
  `telephone_number` varchar(45) DEFAULT NULL,
  `password` mediumtext,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `spouse_name` mediumtext,
  `spouse_occupation` mediumtext,
  `father_name` mediumtext,
  `father_occupation` mediumtext,
  `mother_name` mediumtext,
  `mother_occupation` mediumtext,
  `person_emergency_contact` mediumtext,
  `relations_to_person_emergency_contact` mediumtext,
  `person_emergency_contact_number` varchar(45) DEFAULT NULL,
  `person_created_at` varchar(255) DEFAULT NULL,
  `person_status` varchar(45) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `person_rfid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_person`
--

INSERT INTO `tbl_person` (`person_id`, `person_code`, `first_name`, `middle_name`, `last_name`, `affiliation_name`, `date_of_birth`, `sex`, `civil_status`, `house_number`, `barangay`, `city`, `province`, `region`, `email_address`, `contact_number`, `telephone_number`, `password`, `height`, `weight`, `religion`, `nationality`, `spouse_name`, `spouse_occupation`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `person_emergency_contact`, `relations_to_person_emergency_contact`, `person_emergency_contact_number`, `person_created_at`, `person_status`, `user_type`, `added_by`, `person_rfid`) VALUES
(1, 'PERSON-000001', 'Christian', 'Alvarez', 'Jaramillo', '', '0000-00-00', 'Male', 'Single', '', '', '', '', '', 'christian@gmail.com', '', '', '$2y$10$WdPivpajfSh6zGkokOB3FOgFE6ozVX3B/yzzGCIhWrNmIaquMrBru', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '2023-07-24 @ 11:09:53pm', 'Activated', '1', 1, ''),
(2, 'PERSON-000002', 'staff 1', '', '-', '', '1995-01-01', 'Male', 'Single', '-', 'DITA', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', 'staff1@gmail.com', '9123456789', '', '$2y$10$/dvMfLhlwT37bRz2bT4dxO1q5lYr4uorfK3fRZUjuVhgu8YotT52O', 0, 0, '-', '-', '', '', '', '', '', '', '', '', '', '2023-07-24 @ 11:12:33 PM', 'Activated', '2', 1, ''),
(3, 'PERSON-000003', 'staff 2', '', '-', '', '1998-01-01', 'Male', 'Single', '-', 'DON JOSE', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', 'staff2@gmail.com', '9123456789', '', '$2y$10$G4hI5BCnut0//T25BQgwTeYpMugHZUc451LVrGQ0iJX7MhJsA.ZpG', 0, 0, '-', '-', '', '', '', '', '', '', '', '', '', '2023-07-24 @ 11:13:06 PM', 'Activated', '2', 1, ''),
(4, 'PERSON-000004', 'employee 1', '', '-', '', '1999-01-01', 'Male', 'Single', '-', 'DITA', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', 'employee1@gmail.com', '9123456789', '', '$2y$10$dC39Uy1A0pfP4xPzsxwcD.qp.kCCLBf4bcP89PLx3xcMX9Ns6YETu', 0, 0, '-', '-', '', '', '', '', '', '', '', '', '', '2023-07-24 @ 11:13:55 PM', 'Activated', '3', 4, '1795397678'),
(5, 'PERSON-000005', 'employee 2', '', '-', '', '2000-01-01', 'Male', 'Single', '-', 'CAINGIN', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', 'employee2@gmail.com', '9123456789', '', '$2y$10$5lOOwT1uq18axMghofsCPeEwcYg5sWmhnCfcNZnnq7R6GSI.h4Hii', 0, 0, '-', '-', '', '', '', '', '', '', '', '', '', '2023-07-24 @ 11:14:25 PM', 'Activated', '3', 5, ''),
(6, 'PERSON-000006', 'employee 3', '', '-', '', '2000-01-01', 'Male', 'Single', '-', 'KANLURAN (POB.)', 'SANTA ROSA CITY', 'LAGUNA', 'REGION IV-A', 'employee3@gmail.com', '9123456789', '', '$2y$10$TFGFSgKn7kIIasBI.b9tj.C/K2fsZ0XFqvRXXTB3ambCvXBiM/3US', 0, 0, '-', '-', '', '', '', '', '', '', '', '', '', '2023-07-30 @ 11:15:19 PM', 'Activated', '3', 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person_shifting_schedule`
--

CREATE TABLE `tbl_person_shifting_schedule` (
  `person_shifting_schedule_id` int(11) NOT NULL,
  `person_shifting_schedule_code` varchar(255) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `shifting_schedule_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `end_effective_date` date DEFAULT NULL,
  `person_shifting_schedule_created_at` varchar(255) DEFAULT NULL,
  `person_shifting_schedule_status` varchar(45) DEFAULT NULL,
  `person_shifting_schedule_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_person_shifting_schedule`
--

INSERT INTO `tbl_person_shifting_schedule` (`person_shifting_schedule_id`, `person_shifting_schedule_code`, `person_id`, `shifting_schedule_id`, `branch_id`, `effective_date`, `end_effective_date`, `person_shifting_schedule_created_at`, `person_shifting_schedule_status`, `person_shifting_schedule_added_by`) VALUES
(1, 'SHIFT-SCHEDULE-000001', 4, 1, 1, '2023-06-05', '2023-08-15', '2023-07-24 @ 11:40:20 PM', 'Activated', 2),
(2, 'SHIFT-SCHEDULE-000002', 5, 1, 1, '2023-06-05', '2023-07-31', '2023-07-30 @ 02:20:01 AM', 'Activated', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shifting_schedule`
--

CREATE TABLE `tbl_shifting_schedule` (
  `shifting_schedule_id` int(11) NOT NULL,
  `shifting_schedule_code` varchar(255) DEFAULT NULL,
  `shifting_schedule_time_from` varchar(45) DEFAULT NULL,
  `shifting_schedule_time_to` varchar(45) DEFAULT NULL,
  `shifting_schedule_break_time_from` varchar(255) DEFAULT NULL,
  `shifting_schedule_break_time_to` varchar(255) DEFAULT NULL,
  `shifting_schedule_monday` varchar(45) DEFAULT NULL,
  `shifting_schedule_tuesday` varchar(45) DEFAULT NULL,
  `shifting_schedule_wednesday` varchar(45) DEFAULT NULL,
  `shifting_schedule_thursday` varchar(45) DEFAULT NULL,
  `shifting_schedule_friday` varchar(45) DEFAULT NULL,
  `shifting_schedule_saturday` varchar(45) DEFAULT NULL,
  `shifting_schedule_sunday` varchar(45) DEFAULT NULL,
  `shifting_schedule_created_at` varchar(255) DEFAULT NULL,
  `shifting_schedule_status` varchar(45) DEFAULT NULL,
  `shifting_schedule_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shifting_schedule`
--

INSERT INTO `tbl_shifting_schedule` (`shifting_schedule_id`, `shifting_schedule_code`, `shifting_schedule_time_from`, `shifting_schedule_time_to`, `shifting_schedule_break_time_from`, `shifting_schedule_break_time_to`, `shifting_schedule_monday`, `shifting_schedule_tuesday`, `shifting_schedule_wednesday`, `shifting_schedule_thursday`, `shifting_schedule_friday`, `shifting_schedule_saturday`, `shifting_schedule_sunday`, `shifting_schedule_created_at`, `shifting_schedule_status`, `shifting_schedule_added_by`) VALUES
(1, 'SHIFTING-SCHEDULE-000001', '08:00', '17:00', '12:00', '13:00', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', '2023-07-24 @ 11:18:45 PM', 'Activated', 1),
(2, 'SHIFTING-SCHEDULE-000002', '20:00', '05:00', '00:00', '01:00', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', '2023-07-24 @ 11:19:02 PM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tax`
--

CREATE TABLE `tbl_tax` (
  `tax_id` int(11) NOT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `tax_title` mediumtext,
  `tax_description` mediumtext,
  `tax_date_from` date DEFAULT NULL,
  `tax_date_to` date DEFAULT NULL,
  `tax_amount_from` double DEFAULT NULL,
  `tax_amount_to` double DEFAULT NULL,
  `tax_additional` double DEFAULT NULL,
  `tax_percentage` double DEFAULT NULL,
  `tax_created_at` varchar(255) DEFAULT NULL,
  `tax_status` varchar(45) DEFAULT NULL,
  `tax_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tax`
--

INSERT INTO `tbl_tax` (`tax_id`, `tax_code`, `tax_title`, `tax_description`, `tax_date_from`, `tax_date_to`, `tax_amount_from`, `tax_amount_to`, `tax_additional`, `tax_percentage`, `tax_created_at`, `tax_status`, `tax_added_by`) VALUES
(1, 'TAX-000001', '2023 Tax', '', '2023-01-01', '2023-12-31', 0, 250000, 0, 0, '2023-07-25 @ 02:43:14 AM', 'Activated', 1),
(2, 'TAX-000002', '2023 Tax', '', '2023-01-01', '2023-12-31', 250000, 400000, 0, 20, '2023-07-25 @ 02:43:30 AM', 'Activated', 1),
(3, 'TAX-000003', '2023 Tax', '', '2023-01-01', '2023-12-31', 400000, 800000, 30000, 25, '2023-07-25 @ 02:44:09 AM', 'Activated', 1),
(4, 'TAX-000004', '2023 Tax', '', '2023-01-01', '2023-12-31', 800000, 2000000, 130000, 30, '2023-07-25 @ 02:46:52 AM', 'Activated', 1),
(5, 'TAX-000005', '2023 Tax', '', '2023-01-01', '2023-12-31', 2000000, 8000000, 490000, 32, '2023-07-25 @ 02:47:53 AM', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction_logs`
--

CREATE TABLE `tbl_transaction_logs` (
  `transaction_logs_id` int(11) NOT NULL,
  `transaction_logs_code` varchar(255) DEFAULT NULL,
  `transaction_logs_category` mediumtext,
  `transaction_logs_unique_id` int(11) DEFAULT NULL,
  `transaction_logs_status` mediumtext,
  `transaction_logs_description` mediumtext,
  `transaction_logs_created_at` varchar(255) DEFAULT NULL,
  `transaction_logs_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaction_logs`
--

INSERT INTO `tbl_transaction_logs` (`transaction_logs_id`, `transaction_logs_code`, `transaction_logs_category`, `transaction_logs_unique_id`, `transaction_logs_status`, `transaction_logs_description`, `transaction_logs_created_at`, `transaction_logs_added_by`) VALUES
(1, '242023071126111', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-07-24 @ 11:11:26 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-24 @ 11:11:26 PM', 1),
(2, '242023071234112', 'NEW PERSON', 2, 'CREATE', 'New HR Staff successfully saved<br>New Information<br>Name: - , staff 1 <br>Date of Birth: 1995-01-01<br>Sex: Male<br>Civil Status: Single <br>Address: -, DITA, SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Username: staff1@gmail.com<br>Contact Number: 9123456789<br>Telephone Number: <br><br>Height: 0<br> Weight: 0<br> Religion: -<br> Nationality: -<br><br> Spouse Name: <br>Spouse Occupation: <br> <br><br>Father Name: <br>Father Occupation: <br><br><br>Mother Name: <br>Mother Occupation: <br><br><br>Emergency Contact:<br>Name: <br>Relationship: <br> Contact Number: <br>RFID: <br>Status: Activated', '2023-07-24 @ 11:12:34 PM', 1),
(3, '242023071306113', 'NEW PERSON', 3, 'CREATE', 'New HR Staff successfully saved<br>New Information<br>Name: - , staff 2 <br>Date of Birth: 1998-01-01<br>Sex: Male<br>Civil Status: Single <br>Address: -, DON JOSE, SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Username: staff2@gmail.com<br>Contact Number: 9123456789<br>Telephone Number: <br><br>Height: 0<br> Weight: 0<br> Religion: -<br> Nationality: -<br><br> Spouse Name: <br>Spouse Occupation: <br> <br><br>Father Name: <br>Father Occupation: <br><br><br>Mother Name: <br>Mother Occupation: <br><br><br>Emergency Contact:<br>Name: <br>Relationship: <br> Contact Number: <br>RFID: <br>Status: Activated', '2023-07-24 @ 11:13:06 PM', 1),
(4, '242023071355114', 'NEW PERSON', 4, 'CREATE', 'New Employee successfully saved<br>New Information<br>Name: - , employee 1 <br>Date of Birth: 1999-01-01<br>Sex: Male<br>Civil Status: Single <br>Address: -, DITA, SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Username: employee1@gmail.com<br>Contact Number: 9123456789<br>Telephone Number: <br><br>Height: 0<br> Weight: 0<br> Religion: -<br> Nationality: -<br><br> Spouse Name: <br>Spouse Occupation: <br> <br><br>Father Name: <br>Father Occupation: <br><br><br>Mother Name: <br>Mother Occupation: <br><br><br>Emergency Contact:<br>Name: <br>Relationship: <br> Contact Number: <br>RFID: <br>Status: Registration', '2023-07-24 @ 11:13:55 PM', 4),
(5, '242023071425115', 'NEW PERSON', 5, 'CREATE', 'New Employee successfully saved<br>New Information<br>Name: - , employee 2 <br>Date of Birth: 2000-01-01<br>Sex: Male<br>Civil Status: Single <br>Address: -, CAINGIN, SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Username: employee2@gmail.com<br>Contact Number: 9123456789<br>Telephone Number: <br><br>Height: 0<br> Weight: 0<br> Religion: -<br> Nationality: -<br><br> Spouse Name: <br>Spouse Occupation: <br> <br><br>Father Name: <br>Father Occupation: <br><br><br>Mother Name: <br>Mother Occupation: <br><br><br>Emergency Contact:<br>Name: <br>Relationship: <br> Contact Number: <br>RFID: <br>Status: Registration', '2023-07-24 @ 11:14:25 PM', 5),
(6, '242023071503116', 'UPDATE PERSON STATUS', 4, 'UPDATE', 'Updating of person status successfully saved<br>Name: - , employee 1 <br>Status: Activated', '2023-07-24 @ 11:15:03 PM', 1),
(7, '242023071507117', 'UPDATE PERSON STATUS', 5, 'UPDATE', 'Updating of person status successfully saved<br>Name: - , employee 2 <br>Status: Activated', '2023-07-24 @ 11:15:07 PM', 1),
(8, '242023071510118', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-24 @ 11:15:09 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-24 @ 11:15:10 PM', 4),
(9, '242023071559119', 'NEW BRANCH', 1, 'CREATE', 'New branch successfully saved<br>New Information<bBranch Name: Branch 1<br>Branch Description: branch_description<br>Branch Address: -, DITA, SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Contact Number: 9123456789<br>Status: Activated', '2023-07-24 @ 11:15:59 PM', 1),
(10, '2420230716141110', 'NEW BRANCH', 2, 'CREATE', 'New branch successfully saved<br>New Information<bBranch Name: Branch 2<br>Branch Description: branch_description<br>Branch Address: -, DON JOSE, SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Contact Number: 9123456789<br>Status: Activated', '2023-07-24 @ 11:16:14 PM', 1),
(11, '2420230716261111', 'NEW BRANCH PERSONNEL', 1, 'CREATE', 'New branch personnel successfully saved<br>New Information<br>Branch Name: Branch 1<br>Personnel: - , staff 1 <br>Status: Added', '2023-07-24 @ 11:16:25 PM', 1),
(12, '2420230716401112', 'NEW BRANCH PERSONNEL', 2, 'CREATE', 'New branch personnel successfully saved<br>New Information<br>Branch Name: Branch 2<br>Personnel: - , staff 2 <br>Status: Added', '2023-07-24 @ 11:16:40 PM', 1),
(13, '2420230717591113', 'NEW JOB POSITION', 1, 'CREATE', 'New job position successfully saved<br>New Information<br>Job Position Title: Job Position 1<br>Job Position Description: job_position_description<br>Status: Activated', '2023-07-24 @ 11:17:59 PM', 1),
(14, '2420230718061114', 'NEW JOB POSITION', 2, 'CREATE', 'New job position successfully saved<br>New Information<br>Job Position Title: Job Position 2<br>Job Position Description: job_position_description<br>Status: Activated', '2023-07-24 @ 11:18:06 PM', 1),
(15, '2420230718451115', 'NEW SHIFTING SCHEDULE', 1, 'CREATE', 'New shifting schedule successfully saved<br>New Information<br>Shifting Time: 08:00 TO 17:00<br>Shift Break: 12:00 TO 13:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No <br>Status: Activated', '2023-07-24 @ 11:18:45 PM', 1),
(16, '2420230719021116', 'NEW SHIFTING SCHEDULE', 2, 'CREATE', 'New shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 00:00 TO 01:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No <br>Status: Activated', '2023-07-24 @ 11:19:02 PM', 1),
(17, '2420230720151117', 'NEW PAYROLL PERIOD', 1, 'CREATE', 'New payroll period successfully saved<br>New Information<br>Payroll Period Title: 1st Cutoff<br>Payroll Day: 1 TO 15<br>Payrol Period: 23 TO 8<br>Status: Activated', '2023-07-24 @ 11:20:15 PM', 1),
(18, '2420230720291118', 'NEW PAYROLL PERIOD', 2, 'CREATE', 'New payroll period successfully saved<br>New Information<br>Payroll Period Title: 2nd Cutoff<br>Payroll Day: 16 TO 31<br>Payrol Period: 9 TO 22<br>Status: Activated', '2023-07-24 @ 11:20:29 PM', 1),
(19, '2420230720471119', 'NEW LEAVE CATEGORY', 1, 'CREATE', 'New leave category successfully saved<br>New Information<br>:Leave Title: Leave 1<br>:Leave Description: leave_category_description<br>Quantity: 10<br>Paid Leave Quantity: 4<br>Status: Activated', '2023-07-24 @ 11:20:47 PM', 1),
(20, '2420230720561120', 'NEW LEAVE CATEGORY', 2, 'CREATE', 'New leave category successfully saved<br>New Information<br>:Leave Title: Leave 2<br>:Leave Description: leave_category_description<br>Quantity: 10<br>Paid Leave Quantity: 5<br>Status: Activated', '2023-07-24 @ 11:20:56 PM', 1),
(21, '2420230721161121', 'NEW BENEFITS CATEGORY', 1, 'CREATE', 'New benefits category successfully saved<br>New Information<br>Benefits Title: Transportation Allowance<br>Benefits Description: benefits_category_description<br>Amount: 1500<br>Status: Activated', '2023-07-24 @ 11:21:16 PM', 1),
(22, '2420230721241122', 'NEW BENEFITS CATEGORY', 2, 'CREATE', 'New benefits category successfully saved<br>New Information<br>Benefits Title: Internet Allowance<br>Benefits Description: benefits_category_description<br>Amount: 2000<br>Status: Activated', '2023-07-24 @ 11:21:24 PM', 1),
(23, '2420230721571123', 'NEW DEDUCTION CATEGORY', 1, 'CREATE', 'New deduction category successfully saved<br>New Information<br>Deduction Title: SSS<br>Deduction Description: deduction_category_description<br>Is Percentage: Yes<br>Company Share: 9.5<br>Personnel Share: 4.5<br>Status: Activated', '2023-07-24 @ 11:21:57 PM', 1),
(24, '2420230722151124', 'NEW DEDUCTION CATEGORY', 2, 'CREATE', 'New deduction category successfully saved<br>New Information<br>Deduction Title: PHILHEALTH<br>Deduction Description: deduction_category_description<br>Is Percentage: Yes<br>Company Share: 2.25<br>Personnel Share: 2.25<br>Status: Activated', '2023-07-24 @ 11:22:15 PM', 1),
(25, '2420230722261125', 'NEW DEDUCTION CATEGORY', 3, 'CREATE', 'New deduction category successfully saved<br>New Information<br>Deduction Title: Pag-ibig<br>Deduction Description: deduction_category_description<br>Is Percentage: No<br>Company Share: 100<br>Personnel Share: 100<br>Status: Activated', '2023-07-24 @ 11:22:26 PM', 1),
(26, '2420230723231126', 'NEW JOB CONTRACT', 1, 'CREATE', 'New job contract successfully saved<br>New Information<br>Contract Title: June 2023 Contract<br>Contract Description: contract_description<br>Application Date: 2023-06-01 TO 2023-06-03,2023-06-05<br>Starting Date: 2023-06-05<br>Status: Activated', '2023-07-24 @ 11:23:23 PM', 1),
(27, '2420230723391127', 'NEW CONTRACT PAYROLL', 1, 'CREATE', 'New contract payroll successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:23:39 PM', 1),
(28, '2420230723511128', 'NEW CONTRACT BENEFITS', 1, 'CREATE', 'New contract benefits successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:23:51 PM', 1),
(29, '2420230723511129', 'NEW CONTRACT DEDUCTION', 2, 'CREATE', 'New contract deduction successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:23:51 PM', 1),
(30, '2420230723511130', 'NEW CONTRACT DEDUCTION', 3, 'CREATE', 'New contract deduction successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:23:51 PM', 1),
(31, '2420230723571131', 'NEW CONTRACT PAYROLL', 2, 'CREATE', 'New contract payroll successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:23:57 PM', 1),
(32, '2420230724051132', 'NEW CONTRACT BENEFITS', 4, 'CREATE', 'New contract benefits successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:24:05 PM', 1),
(33, '2420230724051133', 'NEW CONTRACT DEDUCTION', 5, 'CREATE', 'New contract deduction successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:24:05 PM', 1),
(34, '2420230724121134', 'NEW CONTRACT LEAVE CREDIT', 1, 'CREATE', 'New contract leave credit successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:24:12 PM', 1),
(35, '2420230724191135', 'NEW CONTRACT BRANCH', 1, 'CREATE', 'New contract branch successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:24:18 PM', 1),
(36, '2420230724401136', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-24 @ 11:24:40 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-24 @ 11:24:40 PM', 2),
(37, '2420230725071137', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-24 @ 11:25:06 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-24 @ 11:25:07 PM', 4),
(38, '2420230725481138', 'NEW JOB APPLICATION', 1, 'CREATE', 'New job application successfully saved<br>New Information<br>Applicant Name: - , employee 1 <br>Category: Application Submitted<br>Status: Pending', '2023-07-24 @ 11:25:48 PM', 4),
(39, '2420230725481139', 'NEW JOB APPLICATION HISTORY', 1, 'CREATE', 'New job history application successfully saved<br>New Information<br>Applicant Name: - , employee 1 <br>Category: Application Submitted<br>Status: Pending', '2023-07-24 @ 11:25:48 PM', 4),
(40, '2420230726071140', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-24 @ 11:26:06 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-24 @ 11:26:07 PM', 3),
(41, '2420230726331141', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-24 @ 11:26:33 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-24 @ 11:26:33 PM', 2),
(42, '2420230726451142', 'UPDATE JOB APPLICATION STATUS', 1, 'UPDATE', 'Updating of job application status successfully saved<br>Status: Accepted', '2023-07-24 @ 11:26:45 PM', 2),
(43, '2420230734351143', 'NEW JOB APPLICATION HISTORY', 2, 'CREATE', 'New job history application successfully saved<br>New Information<br>Category: Initial Interview<br>Title: Interview<br>Description: <br>Date: 2023-06-02<br>Time: 10:00<br>Remarks: <br>Status: Scheduled', '2023-07-24 @ 11:34:35 PM', 2),
(44, '2420230734481144', 'NEW JOB APPLICATION HISTORY', 3, 'CREATE', 'New job history application successfully saved<br>New Information<br>Category: Technical Exam<br>Title: Exam<br>Description: <br>Date: 2023-06-02<br>Time: 13:00<br>Remarks: <br>Status: Scheduled', '2023-07-24 @ 11:34:48 PM', 2),
(45, '2420230735021145', 'UPDATE JOB APPLICATION HISTORY', 2, 'UPDATE', 'Updating of job application history status successfully saved<br>Status: Passed', '2023-07-24 @ 11:35:02 PM', 2),
(46, '2420230735061146', 'UPDATE JOB APPLICATION HISTORY', 3, 'UPDATE', 'Updating of job application history status successfully saved<br>Status: Passed', '2023-07-24 @ 11:35:06 PM', 2),
(47, '2420230735231147', 'NEW JOB APPLICATION HISTORY', 4, 'CREATE', 'New job history application successfully saved<br>New Information<br>Category: For Contract Signing<br>Title: Contract Signing<br>Description: <br>Date: 2023-06-02<br>Time: 16:00<br>Remarks: <br>Status: Scheduled', '2023-07-24 @ 11:35:23 PM', 2),
(48, '2420230735291148', 'UPDATE JOB APPLICATION HISTORY', 4, 'UPDATE', 'Updating of job application history status successfully saved<br>Status: Done', '2023-07-24 @ 11:35:29 PM', 2),
(49, '2420230738311149', 'NEW JOB CONTRACT', 2, 'CREATE', 'New job contract successfully saved<br>New Information<br>Contract Title: June 2023 Contract<br>Contract Description: contract_description<br>Application Date: 2023-06-01 TO 2023-06-03,2023-06-05<br>Starting Date: 2023-06-05<br>Status: Activated', '2023-07-24 @ 11:38:31 PM', 1),
(50, '2420230738501150', 'NEW CONTRACT PAYROLL', 3, 'CREATE', 'New contract payroll successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:38:50 PM', 1),
(51, '2420230738581151', 'NEW CONTRACT BENEFITS', 6, 'CREATE', 'New contract benefits successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:38:58 PM', 1),
(52, '2420230738581152', 'NEW CONTRACT DEDUCTION', 7, 'CREATE', 'New contract deduction successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:38:58 PM', 1),
(53, '2420230738591153', 'NEW CONTRACT DEDUCTION', 8, 'CREATE', 'New contract deduction successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:38:59 PM', 1),
(54, '2420230739021154', 'NEW CONTRACT PAYROLL', 4, 'CREATE', 'New contract payroll successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:39:02 PM', 1),
(55, '2420230739101155', 'NEW CONTRACT BENEFITS', 9, 'CREATE', 'New contract benefits successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:39:10 PM', 1),
(56, '2420230739101156', 'NEW CONTRACT DEDUCTION', 10, 'CREATE', 'New contract deduction successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:39:10 PM', 1),
(57, '2420230739161157', 'NEW CONTRACT LEAVE CREDIT', 2, 'CREATE', 'New contract leave credit successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:39:16 PM', 1),
(58, '2420230739231158', 'NEW CONTRACT BRANCH', 2, 'CREATE', 'New contract branch successfully saved<br>New Information<br>Status: Activated', '2023-07-24 @ 11:39:23 PM', 1),
(59, '2420230740201159', 'NEW SHIFT SCHEDULE', 1, 'CREATE', 'New shift schedule successfully saved<br>New Information<br>Name: - , employee 1 <br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-24 @ 11:40:20 PM', 2),
(60, '2420230742461160', 'NEW ATTENDANCE', 1, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-05 @ 08:00<br>Time-Out: 2023-06-05 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:42:46 PM', 2),
(61, '2420230743041161', 'NEW ATTENDANCE', 2, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-06 @ 07:50<br>Time-Out: 2023-06-06 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:43:04 PM', 2),
(62, '2420230744051162', 'NEW ATTENDANCE', 3, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-07 @ 08:10<br>Time-Out: 2023-06-07 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:44:05 PM', 2),
(63, '2420230744591163', 'NEW ATTENDANCE', 4, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-08 @ 08:00<br>Time-Out: 2023-06-08 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:44:59 PM', 2),
(64, '2420230745131164', 'NEW ATTENDANCE', 5, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-09 @ 08:00<br>Time-Out: 2023-06-09 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:45:13 PM', 2),
(65, '2420230746051165', 'NEW ATTENDANCE', 6, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-12 @ 08:00<br>Time-Out: 2023-06-12 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:46:05 PM', 2),
(66, '2420230746161166', 'NEW ATTENDANCE', 7, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-13 @ 08:00<br>Time-Out: 2023-06-13 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:46:16 PM', 2),
(67, '2420230746271167', 'NEW ATTENDANCE', 8, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-14 @ 08:00<br>Time-Out: 2023-06-14 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:46:27 PM', 2),
(68, '2420230746381168', 'NEW ATTENDANCE', 9, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-15 @ 08:00<br>Time-Out: 2023-06-15 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:46:38 PM', 2),
(69, '2420230752311169', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-24 @ 11:52:31 PM', 2),
(70, '2420230752541170', 'NEW ATTENDANCE', 10, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-16 @ 08:00<br>Time-Out: 2023-06-16 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:52:54 PM', 2),
(71, '2420230753071171', 'NEW ATTENDANCE', 11, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-17 @ 08:00<br>Time-Out: 2023-06-17 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:53:07 PM', 2),
(72, '2420230753171172', 'UPDATE ATTENDANCE', 3, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Time-In: 2023-06-07 @ 08:00<br>Time-Out: 2023-06-07 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-24 @ 11:53:17 PM', 2),
(73, '2420230753351173', 'NEW ATTENDANCE', 12, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-18 @ 08:00<br>Time-Out: 2023-06-18 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:53:35 PM', 2),
(74, '2420230753461174', 'NEW ATTENDANCE', 13, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-19 @ 08:00<br>Time-Out: 2023-06-19 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:53:46 PM', 2),
(75, '2420230754011175', 'NEW ATTENDANCE', 14, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-20 @ 08:00<br>Time-Out: 2023-06-20 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:54:01 PM', 2),
(76, '2420230754121176', 'NEW ATTENDANCE', 15, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-21 @ 08:00<br>Time-Out: 2023-06-21 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:54:12 PM', 2),
(77, '2420230754211177', 'NEW ATTENDANCE', 16, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-22 @ 08:00<br>Time-Out: 2023-06-22 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:54:21 PM', 2),
(78, '2420230754311178', 'NEW ATTENDANCE', 17, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-23 @ 08:00<br>Time-Out: 2023-06-23 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:54:31 PM', 2),
(79, '2420230754461179', 'NEW ATTENDANCE', 18, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-24 @ 08:00<br>Time-Out: 2023-06-24 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:54:46 PM', 2),
(80, '2420230754591180', 'NEW ATTENDANCE', 19, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-25 @ 08:00<br>Time-Out: 2023-06-25 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:54:59 PM', 2),
(81, '2420230755101181', 'NEW ATTENDANCE', 20, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-26 @ 08:00<br>Time-Out: 2023-06-26 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-24 @ 11:55:10 PM', 2),
(82, '2420230756391182', 'UPDATE ATTENDANCE', 20, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Time-In: 2023-06-28 @ 08:00<br>Time-Out: 2023-06-28 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-24 @ 11:56:39 PM', 2),
(83, '2420230756491183', 'UPDATE ATTENDANCE', 18, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Time-In: 2023-06-26 @ 08:00<br>Time-Out: 2023-06-26 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-24 @ 11:56:49 PM', 2),
(84, '2420230756571184', 'UPDATE ATTENDANCE', 19, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Time-In: 2023-06-27 @ 08:00<br>Time-Out: 2023-06-27 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-24 @ 11:56:57 PM', 2),
(85, '2420230758441185', 'UPDATE ATTENDANCE STATUS', 9, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Denied', '2023-07-24 @ 11:58:44 PM', 2),
(86, '2420230759021186', 'UPDATE ATTENDANCE STATUS', 10, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Denied', '2023-07-24 @ 11:59:02 PM', 2),
(87, '2520230700031287', 'UPDATE ATTENDANCE STATUS', 1, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:00:03 AM', 2),
(88, '2520230700091288', 'UPDATE ATTENDANCE STATUS', 2, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:00:09 AM', 2),
(89, '2520230700151289', 'UPDATE ATTENDANCE STATUS', 3, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:00:15 AM', 2),
(90, '2520230700211290', 'UPDATE ATTENDANCE STATUS', 4, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:00:21 AM', 2),
(91, '2520230700291291', 'UPDATE ATTENDANCE STATUS', 5, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:00:29 AM', 2),
(92, '2520230702261292', 'UPDATE ATTENDANCE STATUS', 6, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:02:26 AM', 2),
(93, '2520230702361293', 'UPDATE ATTENDANCE STATUS', 7, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:02:36 AM', 2),
(94, '2520230702431294', 'UPDATE ATTENDANCE STATUS', 8, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:02:43 AM', 2),
(95, '2520230702491295', 'UPDATE ATTENDANCE STATUS', 11, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:02:49 AM', 2),
(96, '2520230702531296', 'UPDATE ATTENDANCE STATUS', 12, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:02:53 AM', 2),
(97, '2520230702581297', 'UPDATE ATTENDANCE STATUS', 13, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:02:58 AM', 2),
(98, '2520230703021298', 'UPDATE ATTENDANCE STATUS', 14, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:02 AM', 2),
(99, '2520230703061299', 'UPDATE ATTENDANCE STATUS', 15, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:06 AM', 2),
(100, '25202307031212100', 'UPDATE ATTENDANCE STATUS', 16, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:12 AM', 2),
(101, '25202307031712101', 'UPDATE ATTENDANCE STATUS', 17, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:17 AM', 2),
(102, '25202307032212102', 'UPDATE ATTENDANCE STATUS', 18, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:22 AM', 2),
(103, '25202307032612103', 'UPDATE ATTENDANCE STATUS', 19, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:26 AM', 2),
(104, '25202307033012104', 'UPDATE ATTENDANCE STATUS', 20, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:03:30 AM', 2),
(105, '25202307082012105', 'UPDATE ATTENDANCE STATUS', 11, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Denied', '2023-07-25 @ 12:08:20 AM', 2),
(106, '25202307082312106', 'UPDATE ATTENDANCE STATUS', 12, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Denied', '2023-07-25 @ 12:08:23 AM', 2),
(107, '25202307092712107', 'UPDATE ATTENDANCE STATUS', 10, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:09:27 AM', 2),
(108, '25202307164412108', 'UPDATE ATTENDANCE STATUS', 9, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:16:44 AM', 2),
(109, '25202307192312109', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-25 @ 12:19:23 AM', 2),
(110, '25202307202012110', 'NEW ATTENDANCE', 21, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-29 @ 08:00<br>Time-Out: 2023-06-29 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:20:20 AM', 2),
(111, '25202307202612111', 'UPDATE ATTENDANCE STATUS', 21, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:20:26 AM', 2),
(112, '25202307203812112', 'NEW ATTENDANCE', 22, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-30 @ 08:00<br>Time-Out: 2023-06-30 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:20:38 AM', 2),
(113, '25202307204412113', 'UPDATE ATTENDANCE STATUS', 22, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:20:44 AM', 2),
(114, '25202307210112114', 'NEW ATTENDANCE', 23, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-07-03 @ 08:00<br>Time-Out: 2023-07-03 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:21:01 AM', 2),
(115, '25202307210512115', 'UPDATE ATTENDANCE STATUS', 23, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:21:05 AM', 2),
(116, '25202307211912116', 'NEW ATTENDANCE', 24, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-07-04 @ 08:00<br>Time-Out: 2023-07-04 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:21:19 AM', 2),
(117, '25202307212712117', 'UPDATE ATTENDANCE STATUS', 24, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:21:27 AM', 2),
(118, '25202307214112118', 'NEW ATTENDANCE', 25, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-07-05 @ 08:00<br>Time-Out: 2023-07-05 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:21:41 AM', 2),
(119, '25202307214812119', 'UPDATE ATTENDANCE STATUS', 25, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:21:48 AM', 2),
(120, '25202307220112120', 'NEW ATTENDANCE', 26, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-07-06 @ 08:00<br>Time-Out: 2023-07-06 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:22:01 AM', 2),
(121, '25202307220512121', 'UPDATE ATTENDANCE STATUS', 26, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:22:05 AM', 2),
(122, '25202307221912122', 'NEW ATTENDANCE', 27, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Time-In: 2023-06-07 @ 08:00<br>Time-Out: 2023-06-07 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 12:22:19 AM', 2),
(123, '25202307222612123', 'UPDATE ATTENDANCE STATUS', 27, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 12:22:26 AM', 2),
(124, '25202307343112124', 'UPDATE DEDUCTIONS CATEGORY', 3, 'UPDATE', 'Updating deduction category successfully saved<br>Deduction Title: HDMF<br>Deduction Description: deduction_category_description<br>Is Percentage: No<br>Company Share: 100<br>Personnel Share: 100', '2023-07-25 @ 12:34:31 AM', 1),
(125, '25202307494012125', 'UPDATE ATTENDANCE', 27, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Time-In: 2023-07-07 @ 08:00<br>Time-Out: 2023-07-07 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-25 @ 12:49:40 AM', 2),
(126, '25202307154601126', 'NEW HOLIDAY', 1, 'CREATE', 'New holiday successfully saved<br>New Information<br>Title: Philippines Independence Day<br>Description: <br>Date: 2023-06-12 TO 2023-06-12<br>Paid?: Yes<br>Status: Activated', '2023-07-25 @ 01:15:46 AM', 1),
(127, '25202307162501127', 'NEW HOLIDAY', 2, 'CREATE', 'New holiday successfully saved<br>New Information<br>Title: EID AL-ADHA<br>Description: <br>Date: 2023-06-28 TO 2023-06-28<br>Paid?: Yes<br>Status: Activated', '2023-07-25 @ 01:16:24 AM', 1),
(128, '25202307255802128', 'NEW TAX', 1, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 0 TO 250000<br>Additioanl: 0<br>Percentage: 0<br>Status: Activated', '2023-07-25 @ 02:25:58 AM', 1),
(129, '25202307373102129', 'NEW TAX', 1, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 0 TO 250000<br>Is Percentage: <br>Additioanl: 0<br>Percentage: 0<br>Status: Activated', '2023-07-25 @ 02:37:31 AM', 1),
(130, '25202307393802130', 'NEW TAX', 1, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 0 TO 250000<br>Is Percentage: <br>Additioanl: 0<br>Percentage: 0<br>Status: Activated', '2023-07-25 @ 02:39:38 AM', 1),
(131, '25202307431502131', 'NEW TAX', 1, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 0 TO 250000<br>Additioanl: 0<br>Percentage: 0<br>Status: Activated', '2023-07-25 @ 02:43:15 AM', 1),
(132, '25202307433102132', 'NEW TAX', 2, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 250000 TO 400000<br>Additioanl: 0<br>Percentage: 20<br>Status: Activated', '2023-07-25 @ 02:43:31 AM', 1),
(133, '25202307440902133', 'NEW TAX', 3, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 800000 TO 2000000<br>Additioanl: 30000<br>Percentage: 25<br>Status: Activated', '2023-07-25 @ 02:44:09 AM', 1),
(134, '25202307444502134', 'UPDATE TAX', 3, 'UPDATE', 'Updating tax successfully saved<br>New Information<br>Tax Title: 2023 Tax updated<br>Tax Description: tax_description<br>Tax Date Range: 2023-02-02 TO 2023-11-30<br>Tax Amount Range: 800001 TO 2000001<br>Additioanl: 30001<br>Percentage: 21', '2023-07-25 @ 02:44:45 AM', 1),
(135, '25202307445702135', 'UPDATE TAX STATUS', 3, 'UPDATE', 'Updating of tax status successfully saved<br>Status: Deactivated', '2023-07-25 @ 02:44:57 AM', 1),
(136, '25202307450102136', 'UPDATE TAX STATUS', 3, 'UPDATE', 'Updating of tax status successfully saved<br>Status: Activated', '2023-07-25 @ 02:45:01 AM', 1),
(137, '25202307451802137', 'UPDATE TAX', 3, 'UPDATE', 'Updating tax successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 800000 TO 2000000<br>Additioanl: 30000<br>Percentage: 25', '2023-07-25 @ 02:45:18 AM', 1),
(138, '25202307462002138', 'UPDATE TAX', 3, 'UPDATE', 'Updating tax successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 400000 TO 800000<br>Additioanl: 30000<br>Percentage: 25', '2023-07-25 @ 02:46:20 AM', 1),
(139, '25202307465202139', 'NEW TAX', 4, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 800000 TO 2000000<br>Additioanl: 130000<br>Percentage: 30<br>Status: Activated', '2023-07-25 @ 02:46:52 AM', 1),
(140, '25202307475302140', 'NEW TAX', 5, 'CREATE', 'New branch successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 2000000 TO 8000000<br>Additioanl: 490000<br>Percentage: 31<br>Status: Activated', '2023-07-25 @ 02:47:53 AM', 1),
(141, '25202307480402141', 'UPDATE TAX', 5, 'UPDATE', 'Updating tax successfully saved<br>New Information<br>Tax Title: 2023 Tax<br>Tax Description: tax_description<br>Tax Date Range: 2023-01-01 TO 2023-12-31<br>Tax Amount Range: 2000000 TO 8000000<br>Additioanl: 490000<br>Percentage: 32', '2023-07-25 @ 02:48:04 AM', 1),
(142, '25202307535804142', 'NEW ATTENDANCE', 28, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-10 @ 08:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 04:53:58 PM', 1),
(143, '25202307541304143', 'UPDATE ATTENDANCE', 28, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Overtime<br>Time-In: 2023-07-10 @ 08:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-25 @ 04:54:13 PM', 1),
(144, '25202307375805144', 'UPDATE ATTENDANCE', 28, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Overtime<br>Time-In: 2023-07-07 @ 17:00<br>Time-Out: 2023-07-07 @ 19:00<br>Requested By: - , employee 1 ', '2023-07-25 @ 05:37:58 PM', 1),
(145, '25202307440405145', 'UPDATE ATTENDANCE', 28, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Overtime<br>Time-In: 2023-07-07 @ 16:59<br>Time-Out: 2023-07-07 @ 19:00<br>Requested By: - , employee 1 ', '2023-07-25 @ 05:44:04 PM', 1),
(146, '25202307455205146', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 05:45:51 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 05:45:52 PM', 4),
(147, '25202307480205147', 'UPDATE ATTENDANCE', 28, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Overtime<br>Time-In: 2023-07-07 @ 17:00<br>Time-Out: 2023-07-07 @ 19:00<br>Requested By: - , employee 1 ', '2023-07-25 @ 05:48:02 PM', 1),
(148, '25202307492405148', 'UPDATE ATTENDANCE STATUS', 28, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-25 @ 05:49:24 PM', 1),
(149, '25202307542605149', 'NEW HOLIDAY', 3, 'CREATE', 'New holiday successfully saved<br>New Information<br>Title: Labour Day<br>Description: <br>Date: 2023-06-12 TO 2023-06-12<br>Paid?: Yes<br>Status: Activated', '2023-07-25 @ 05:54:26 PM', 1),
(150, '25202307004006150', 'UPDATE HOLIDAY', 3, 'UPDATE', 'Updating holiday successfully saved<br>New Information<br>Title: Labour Day<br>Description: <br>Date: 2023-05-01 TO 2023-05-01<br>Paid?: Yes', '2023-07-25 @ 06:00:40 PM', 1),
(151, '25202307125509151', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-25 @ 09:12:55 PM', 1),
(152, '25202307150909152', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-25 @ 09:15:09 PM', 1),
(153, '25202307172609153', 'NEW PAYROLL', 2, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 12650<br>Non-Taxable Earnings: 1500<br>Deductions: 100<br>Withholding Tax: 216.67<br>Net Pay: 13833.33<br>Status: Saved', '2023-07-25 @ 09:17:26 PM', 1),
(154, '25202307201610154', 'NEW ATTENDANCE', 29, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Leave Request<br>Time-In: 2023-07-10 @ 08:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-25 @ 10:20:15 PM', 1),
(155, '25202307124811155', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 11:12:48 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 11:12:48 PM', 1),
(156, '25202307324211156', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 11:32:42 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 11:32:42 PM', 2),
(157, '25202307371511157', 'ACCOUNT LOGIN', 5, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 11:37:14 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 11:37:15 PM', 5),
(158, '25202307374011158', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 11:37:40 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 11:37:40 PM', 3),
(159, '25202307395611159', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 11:39:55 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 11:39:56 PM', 2),
(160, '25202307402411160', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-25 @ 11:40:23 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-25 @ 11:40:24 PM', 3),
(161, '25202307414911161', 'UPDATE RFID', 4, 'UPDATE', 'Updating of RFID successfully saved<br>Name: - , employee 1 <br>RFID: 1795397678', '2023-07-25 @ 11:41:49 PM', 1),
(162, '25202307415411162', 'NEW ATTENDANCE (TIME-IN RFID)', 30, 'CREATE', 'New attendance successfully saved<br>Time-In: 2023-07-25 @ 23:41<br>Status: Pending', '2023-07-25 @ 11:41:54 PM', 4),
(163, '26202307275912163', 'NEW PAYROLL', 3, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 14087.5<br>Non-Taxable Earnings: 2000<br>Deductions: 950.91<br>Withholding Tax: 216.67<br>Net Pay: 14919.92<br>Status: Saved', '2023-07-26 @ 12:27:59 AM', 1),
(164, '26202307333012164', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 12:33:30 AM', 1),
(165, '26202307353312165', 'NEW PAYROLL', 2, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 12650<br>Non-Taxable Earnings: 1500<br>Deductions: 100<br>Withholding Tax: 216.67<br>Net Pay: 13833.33<br>Status: Saved', '2023-07-26 @ 12:35:33 AM', 1),
(166, '26202307363512166', 'NEW PAYROLL', 3, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 14087.5<br>Non-Taxable Earnings: 2000<br>Deductions: 950.91<br>Withholding Tax: 216.67<br>Net Pay: 14919.92<br>Status: Saved', '2023-07-26 @ 12:36:35 AM', 1),
(167, '26202307515812167', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 12:51:58 AM', 1),
(168, '26202307381101168', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 01:38:11 AM', 1),
(169, '26202307420801169', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 01:42:08 AM', 1),
(170, '26202307444801170', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 4600<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 01:44:48 AM', 1),
(171, '26202307453701171', 'NEW PAYROLL', 2, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Taxable Earnings: 12650<br>Non-Taxable Earnings: 1500<br>Deductions: 100<br>Withholding Tax: 216.67<br>Net Pay: 13833.33<br>Status: Saved', '2023-07-26 @ 01:45:37 AM', 1),
(172, '26202307110402172', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 4600<br>Absent Adjustment: 0<br>Overtime: 0<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 02:11:04 AM', 1),
(173, '26202307140802173', 'NEW PAYROLL', 2, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 12650<br>Absent Adjustment: 0<br>Overtime: 0<br>Non-Taxable Earnings: 1500<br>Deductions: 100<br>Withholding Tax: 216.67<br>Net Pay: 13833.33<br>Status: Saved', '2023-07-26 @ 02:14:08 AM', 1),
(174, '26202307145502174', 'NEW PAYROLL', 3, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 13800<br>Absent Adjustment: 0<br>Overtime: 287.5<br>Non-Taxable Earnings: 2000<br>Deductions: 931.5<br>Withholding Tax: 216.67<br>Net Pay: 14939.33<br>Status: Saved', '2023-07-26 @ 02:14:54 AM', 1),
(175, '26202307355902175', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-26 @ 02:35:58 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-26 @ 02:35:58 AM', 3),
(176, '26202307411502176', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 4600<br>Absent Adjustment: 0<br>Overtime: 0<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-26 @ 02:41:15 AM', 1),
(177, '26202307433202177', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-26 @ 02:43:32 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-26 @ 02:43:32 AM', 2),
(178, '26202307593002178', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-26 @ 02:59:29 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-26 @ 02:59:29 AM', 4),
(179, '26202307042103179', 'ACCOUNT LOGIN', 5, 'LOGIN', 'Date and Time of Login: 2023-07-26 @ 03:04:20 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-26 @ 03:04:21 AM', 5),
(180, '28202307292808180', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-07-28 @ 08:29:27 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-28 @ 08:29:27 PM', 1),
(181, '28202307560109181', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 4600<br>Absent Adjustment: 0<br>Overtime: 0<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-28 @ 09:56:01 PM', 1),
(182, '28202307562309182', 'NEW PAYROLL', 2, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 12650<br>Absent Adjustment: 0<br>Overtime: 0<br>Non-Taxable Earnings: 1500<br>Deductions: 100<br>Withholding Tax: 216.67<br>Net Pay: 13833.33<br>Status: Saved', '2023-07-28 @ 09:56:23 PM', 1),
(183, '28202307503210183', 'NEW PAYROLL', 3, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 13800<br>Absent Adjustment: 0<br>Overtime: 287.5<br>Non-Taxable Earnings: 2000<br>Deductions: 931.5<br>Withholding Tax: 216.67<br>Net Pay: 14939.33<br>Status: Saved', '2023-07-28 @ 10:50:32 PM', 1),
(184, '28202307585810184', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-28 @ 10:58:57 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-28 @ 10:58:58 PM', 4),
(185, '29202307221712185', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 12:22:16 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 12:22:17 AM', 2),
(186, '29202307054401186', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 01:05:43 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 01:05:44 AM', 4),
(187, '29202307133401187', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 01:13:34 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 01:13:34 AM', 4),
(188, '29202307500302188', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-29 @ 02:50:02 AM', 1),
(189, '29202307562602189', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-29 @ 02:56:26 AM', 1),
(190, '29202307564702190', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-29 @ 02:56:47 AM', 1),
(191, '29202307010803191', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 03:01:08 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 03:01:08 AM', 2),
(192, '29202307012903192', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 03:01:28 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 03:01:29 AM', 3),
(193, '29202307301408193', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 08:30:14 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 08:30:14 PM', 1),
(194, '29202307271810194', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-29 @ 10:27:17 PM', 1),
(195, '29202307533610195', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 10:53:35 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 10:53:36 PM', 2),
(196, '29202307543810196', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 10:54:38 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 10:54:38 PM', 3),
(197, '29202307082911197', 'UPDATE SHIFT SCHEDULE', 1, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-29 @ 11:08:29 PM', 1),
(198, '29202307441911198', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-29 @ 11:44:18 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-29 @ 11:44:19 PM', 4),
(199, '30202307533512199', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 12:53:34 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 12:53:34 AM', 2),
(200, '30202307552012200', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 12:55:17 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 12:55:19 AM', 4);
INSERT INTO `tbl_transaction_logs` (`transaction_logs_id`, `transaction_logs_code`, `transaction_logs_category`, `transaction_logs_unique_id`, `transaction_logs_status`, `transaction_logs_description`, `transaction_logs_created_at`, `transaction_logs_added_by`) VALUES
(201, '30202307325301201', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 01:32:52 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 01:32:53 AM', 2),
(202, '30202307145202202', 'ACCOUNT LOGIN', 5, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 02:14:51 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 02:14:52 AM', 5),
(203, '30202307151602203', 'NEW JOB APPLICATION', 2, 'CREATE', 'New job application successfully saved<br>New Information<br>Applicant Name: - , employee 2 <br>Category: Application Submitted<br>Status: Pending', '2023-07-30 @ 02:15:16 AM', 5),
(204, '30202307151602204', 'NEW JOB APPLICATION HISTORY', 2, 'CREATE', 'New job history application successfully saved<br>New Information<br>Applicant Name: - , employee 2 <br>Category: Application Submitted<br>Status: Pending', '2023-07-30 @ 02:15:16 AM', 5),
(205, '30202307160402205', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 02:16:04 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 02:16:04 AM', 3),
(206, '30202307162802206', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 02:16:27 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 02:16:28 AM', 2),
(207, '30202307165802207', 'UPDATE JOB APPLICATION STATUS', 2, 'UPDATE', 'Updating of job application status successfully saved<br>Status: Accepted', '2023-07-30 @ 02:16:58 AM', 2),
(208, '30202307174302208', 'NEW JOB APPLICATION HISTORY', 6, 'CREATE', 'New job history application successfully saved<br>New Information<br>Category: Initial Interview<br>Title: Interview<br>Description: <br>Date: 2023-06-02<br>Time: 09:00<br>Remarks: <br>Status: Scheduled', '2023-07-30 @ 02:17:43 AM', 2),
(209, '30202307180502209', 'NEW JOB APPLICATION HISTORY', 7, 'CREATE', 'New job history application successfully saved<br>New Information<br>Category: Technical Exam<br>Title: Exam<br>Description: <br>Date: 2023-06-02<br>Time: 10:30<br>Remarks: <br>Status: Scheduled', '2023-07-30 @ 02:18:05 AM', 2),
(210, '30202307182302210', 'NEW JOB APPLICATION HISTORY', 8, 'CREATE', 'New job history application successfully saved<br>New Information<br>Category: For Contract Signing<br>Title: Contract Signing<br>Description: <br>Date: 2023-06-02<br>Time: 15:30<br>Remarks: <br>Status: Scheduled', '2023-07-30 @ 02:18:23 AM', 2),
(211, '30202307183202211', 'UPDATE JOB APPLICATION HISTORY', 6, 'UPDATE', 'Updating of job application history status successfully saved<br>Status: Passed', '2023-07-30 @ 02:18:32 AM', 2),
(212, '30202307183702212', 'UPDATE JOB APPLICATION HISTORY', 7, 'UPDATE', 'Updating of job application history status successfully saved<br>Status: Passed', '2023-07-30 @ 02:18:37 AM', 2),
(213, '30202307184502213', 'UPDATE JOB APPLICATION HISTORY', 8, 'UPDATE', 'Updating of job application history status successfully saved<br>Status: Done', '2023-07-30 @ 02:18:45 AM', 2),
(214, '30202307200102214', 'NEW SHIFT SCHEDULE', 2, 'CREATE', 'New shift schedule successfully saved<br>New Information<br>Name: - , employee 2 <br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-30 @ 02:20:01 AM', 2),
(215, '30202307250702215', 'UPDATE ATTENDANCE', 29, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-10 @ 08:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-30 @ 02:25:07 AM', 1),
(216, '30202307324102216', 'UPDATE ATTENDANCE STATUS', 29, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:32:41 AM', 1),
(217, '30202307402002217', 'NEW ATTENDANCE', 30, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-05 @ 08:00<br>Time-Out: 2023-06-05 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:40:20 AM', 2),
(218, '30202307421302218', 'NEW ATTENDANCE', 31, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-06 @ 08:00<br>Time-Out: 2023-06-06 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:42:13 AM', 2),
(219, '30202307422902219', 'NEW ATTENDANCE', 32, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-07 @ 08:00<br>Time-Out: 2023-06-07 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:42:29 AM', 2),
(220, '30202307425002220', 'NEW ATTENDANCE', 33, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-08 @ 08:00<br>Time-Out: 2023-06-08 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:42:50 AM', 2),
(221, '30202307430402221', 'NEW ATTENDANCE', 34, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-09 @ 08:00<br>Time-Out: 2023-06-09 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:43:04 AM', 2),
(222, '30202307475002222', 'NEW ATTENDANCE', 35, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-12 @ 08:00<br>Time-Out: 2023-06-12 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:47:50 AM', 2),
(223, '30202307480302223', 'NEW ATTENDANCE', 36, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-13 @ 08:00<br>Time-Out: 2023-06-13 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:48:03 AM', 2),
(224, '30202307481602224', 'NEW ATTENDANCE', 37, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-14 @ 08:00<br>Time-Out: 2023-06-14 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:48:16 AM', 2),
(225, '30202307482802225', 'NEW ATTENDANCE', 38, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-15 @ 08:00<br>Time-Out: 2023-06-15 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:48:28 AM', 2),
(226, '30202307484402226', 'NEW ATTENDANCE', 39, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-16 @ 08:00<br>Time-Out: 2023-06-16 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:48:44 AM', 2),
(227, '30202307490302227', 'UPDATE ATTENDANCE STATUS', 30, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:03 AM', 1),
(228, '30202307490802228', 'UPDATE ATTENDANCE STATUS', 31, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:08 AM', 1),
(229, '30202307491402229', 'UPDATE ATTENDANCE STATUS', 32, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:14 AM', 1),
(230, '30202307492002230', 'UPDATE ATTENDANCE STATUS', 33, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:20 AM', 1),
(231, '30202307492502231', 'UPDATE ATTENDANCE STATUS', 34, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:25 AM', 1),
(232, '30202307493102232', 'UPDATE ATTENDANCE STATUS', 35, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:31 AM', 1),
(233, '30202307493602233', 'UPDATE ATTENDANCE STATUS', 36, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:36 AM', 1),
(234, '30202307494202234', 'UPDATE ATTENDANCE STATUS', 37, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:42 AM', 1),
(235, '30202307495102235', 'UPDATE ATTENDANCE STATUS', 38, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:51 AM', 1),
(236, '30202307495502236', 'UPDATE ATTENDANCE STATUS', 39, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:49:55 AM', 1),
(237, '30202307533002237', 'NEW ATTENDANCE', 40, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-19 @ 08:00<br>Time-Out: 2023-06-19 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:53:30 AM', 2),
(238, '30202307534402238', 'NEW ATTENDANCE', 41, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-20 @ 08:00<br>Time-Out: 2023-06-20 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:53:44 AM', 2),
(239, '30202307535902239', 'NEW ATTENDANCE', 42, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-21 @ 08:00<br>Time-Out: 2023-06-21 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:53:59 AM', 2),
(240, '30202307540902240', 'NEW ATTENDANCE', 43, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-22 @ 08:00<br>Time-Out: 2023-06-22 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:54:09 AM', 2),
(241, '30202307542102241', 'NEW ATTENDANCE', 44, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-23 @ 08:00<br>Time-Out: 2023-06-23 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:54:21 AM', 2),
(242, '30202307543602242', 'UPDATE ATTENDANCE STATUS', 40, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:54:36 AM', 1),
(243, '30202307544102243', 'UPDATE ATTENDANCE STATUS', 41, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:54:40 AM', 1),
(244, '30202307544602244', 'UPDATE ATTENDANCE STATUS', 42, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:54:45 AM', 1),
(245, '30202307545002245', 'UPDATE ATTENDANCE STATUS', 43, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:54:50 AM', 1),
(246, '30202307545502246', 'UPDATE ATTENDANCE STATUS', 44, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:54:55 AM', 1),
(247, '30202307553502247', 'NEW ATTENDANCE', 45, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-26 @ 08:00<br>Time-Out: 2023-06-26 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:55:35 AM', 2),
(248, '30202307555002248', 'NEW ATTENDANCE', 46, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-27 @ 08:00<br>Time-Out: 2023-06-27 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:55:49 AM', 2),
(249, '30202307560502249', 'NEW ATTENDANCE', 47, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-28 @ 08:00<br>Time-Out: 2023-06-28 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:56:05 AM', 2),
(250, '30202307562102250', 'NEW ATTENDANCE', 48, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-29 @ 08:00<br>Time-Out: 2023-06-29 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:56:21 AM', 2),
(251, '30202307563302251', 'NEW ATTENDANCE', 49, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-06-30 @ 08:00<br>Time-Out: 2023-06-30 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 02:56:33 AM', 2),
(252, '30202307564602252', 'UPDATE ATTENDANCE STATUS', 45, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:56:46 AM', 1),
(253, '30202307565102253', 'UPDATE ATTENDANCE STATUS', 46, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:56:51 AM', 1),
(254, '30202307565802254', 'UPDATE ATTENDANCE STATUS', 47, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:56:58 AM', 1),
(255, '30202307570302255', 'UPDATE ATTENDANCE STATUS', 48, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:57:03 AM', 1),
(256, '30202307570802256', 'UPDATE ATTENDANCE STATUS', 49, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 02:57:08 AM', 1),
(257, '30202307121103257', 'UPDATE SHIFT SCHEDULE', 2, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-30 @ 03:12:11 AM', 2),
(258, '30202307155903258', 'NEW ATTENDANCE', 50, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-11 @ 08:00<br>Time-Out: 2023-07-11 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:15:59 AM', 2),
(259, '30202307161303259', 'NEW ATTENDANCE', 51, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-12 @ 08:00<br>Time-Out: 2023-07-12 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:16:13 AM', 2),
(260, '30202307163203260', 'UPDATE ATTENDANCE', 51, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-12 @ 08:00<br>Time-Out: 2023-07-12 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-30 @ 03:16:32 AM', 2),
(261, '30202307170103261', 'NEW ATTENDANCE', 52, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-13 @ 08:00<br>Time-Out: 2023-07-13 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:17:01 AM', 2),
(262, '30202307171503262', 'NEW ATTENDANCE', 53, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-14 @ 08:00<br>Time-Out: 2023-07-14 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:17:15 AM', 2),
(263, '30202307174703263', 'UPDATE ATTENDANCE STATUS', 50, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:17:47 AM', 1),
(264, '30202307175103264', 'UPDATE ATTENDANCE STATUS', 51, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:17:51 AM', 1),
(265, '30202307175703265', 'UPDATE ATTENDANCE STATUS', 52, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:17:57 AM', 1),
(266, '30202307180103266', 'UPDATE ATTENDANCE STATUS', 53, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:18:01 AM', 1),
(267, '30202307263303267', 'NEW ATTENDANCE', 54, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-03 @ 08:00<br>Time-Out: 2023-07-03 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:26:33 AM', 2),
(268, '30202307274903268', 'NEW ATTENDANCE', 55, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-04 @ 08:00<br>Time-Out: 2023-07-04 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:27:49 AM', 2),
(269, '30202307280403269', 'NEW ATTENDANCE', 56, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-05 @ 08:00<br>Time-Out: 2023-07-05 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:28:04 AM', 2),
(270, '30202307282203270', 'NEW ATTENDANCE', 57, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-06 @ 08:00<br>Time-Out: 2023-07-06 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:28:22 AM', 2),
(271, '30202307283503271', 'NEW ATTENDANCE', 58, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-07 @ 08:00<br>Time-Out: 2023-07-07 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-30 @ 03:28:35 AM', 2),
(272, '30202307291403272', 'UPDATE ATTENDANCE STATUS', 54, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:29:14 AM', 1),
(273, '30202307291903273', 'UPDATE ATTENDANCE STATUS', 55, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:29:19 AM', 1),
(274, '30202307292603274', 'UPDATE ATTENDANCE STATUS', 56, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:29:26 AM', 1),
(275, '30202307293303275', 'UPDATE ATTENDANCE STATUS', 57, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:29:33 AM', 1),
(276, '30202307293803276', 'UPDATE ATTENDANCE STATUS', 58, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-30 @ 03:29:38 AM', 1),
(277, '30202307493410277', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 10:49:33 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 10:49:34 PM', 1),
(278, '30202307101611278', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 11:10:16 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 11:10:16 PM', 2),
(279, '30202307113211279', 'UPDATE SHIFT SCHEDULE', 2, 'UPDATE', 'Updating shift schedule successfully saved<br>New Information<br>Effective Date: 2023-06-05<br>End of Effective Date: end_effective_date', '2023-07-30 @ 11:11:32 PM', 2),
(280, '30202307152011280', 'NEW PERSON', 6, 'CREATE', 'New Employee successfully saved<br>New Information<br>Name: - , employee 3 <br>Date of Birth: 2000-01-01<br>Sex: Male<br>Civil Status: Single <br>Address: -, KANLURAN (POB.), SANTA ROSA CITY, LAGUNA, REGION IV-A<br>Username: employee3@gmail.com<br>Contact Number: 9123456789<br>Telephone Number: <br><br>Height: 0<br> Weight: 0<br> Religion: -<br> Nationality: -<br><br> Spouse Name: <br>Spouse Occupation: <br> <br><br>Father Name: <br>Father Occupation: <br><br><br>Mother Name: <br>Mother Occupation: <br><br><br>Emergency Contact:<br>Name: <br>Relationship: <br> Contact Number: <br>RFID: <br>Status: Registration', '2023-07-30 @ 11:15:20 PM', 6),
(281, '30202307154711281', 'UPDATE PERSON STATUS', 6, 'UPDATE', 'Updating of person status successfully saved<br>Name: - , employee 3 <br>Status: Activated', '2023-07-30 @ 11:15:47 PM', 1),
(282, '30202307155211282', 'ACCOUNT LOGIN', 6, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 11:15:51 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 11:15:52 PM', 6),
(283, '30202307162311283', 'NEW JOB APPLICATION', 3, 'CREATE', 'New job application successfully saved<br>New Information<br>Applicant Name: - , employee 3 <br>Category: Application Submitted<br>Status: Pending', '2023-07-30 @ 11:16:23 PM', 6),
(284, '30202307162311284', 'NEW JOB APPLICATION HISTORY', 3, 'CREATE', 'New job history application successfully saved<br>New Information<br>Applicant Name: - , employee 3 <br>Category: Application Submitted<br>Status: Pending', '2023-07-30 @ 11:16:23 PM', 6),
(285, '30202307164311285', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 11:16:42 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 11:16:43 PM', 2),
(286, '30202307170111286', 'ACCOUNT LOGIN', 3, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 11:17:01 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 11:17:01 PM', 3),
(287, '30202307180511287', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-30 @ 11:18:05 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-30 @ 11:18:05 PM', 2),
(288, '31202307214401288', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-07-31 @ 01:21:43 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-31 @ 01:21:43 AM', 1),
(289, '31202307351602289', 'ACCOUNT LOGIN', 2, 'LOGIN', 'Date and Time of Login: 2023-07-31 @ 02:35:16 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-31 @ 02:35:16 AM', 2),
(290, '31202307354602290', 'NEW ATTENDANCE', 59, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-10 @ 06:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 2 <br>Approved By: <br>Status: Pending', '2023-07-31 @ 02:35:46 AM', 2),
(291, '31202307360102291', 'UPDATE ATTENDANCE', 59, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-10 @ 05:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 2 ', '2023-07-31 @ 02:36:01 AM', 2),
(292, '31202307391102292', 'UPDATE ATTENDANCE', 59, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-10 @ 08:00<br>Time-Out: 2023-07-10 @ 16:00<br>Requested By: - , employee 2 ', '2023-07-31 @ 02:39:10 AM', 2),
(293, '31202307391802293', 'UPDATE ATTENDANCE', 59, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-10 @ 08:00<br>Time-Out: 2023-07-10 @ 17:00<br>Requested By: - , employee 2 ', '2023-07-31 @ 02:39:18 AM', 2),
(294, '31202307393102294', 'UPDATE ATTENDANCE STATUS', 59, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-31 @ 02:39:31 AM', 1),
(295, '31202307115304295', 'NEW PAYROLL', 1, 'CREATE', 'New payroll successfully saved<br>New Information<br>Name: - , employee 1 <br>Salary: 4600<br>Absent Adjustment: 0<br>Overtime: 0<br>Non-Taxable Earnings: 2000<br>Deductions: 310.5<br>Withholding Tax: 216.67<br>Net Pay: 6072.83<br>Status: Saved', '2023-07-31 @ 04:11:53 AM', 1),
(296, '31202307053010296', 'NEW ATTENDANCE', 60, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-11 @ 07:00<br>Time-Out: 2023-07-11 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-31 @ 10:05:30 PM', 1),
(297, '31202307054210297', 'UPDATE ATTENDANCE', 60, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-11 @ 06:59<br>Time-Out: 2023-07-11 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-31 @ 10:05:42 PM', 1),
(298, '31202307065510298', 'UPDATE ATTENDANCE', 60, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-11 @ 07:00<br>Time-Out: 2023-07-11 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-31 @ 10:06:55 PM', 1),
(299, '31202307072910299', 'UPDATE ATTENDANCE STATUS', 60, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-07-31 @ 10:07:29 PM', 1),
(300, '31202307241810300', 'NEW ATTENDANCE', 61, 'CREATE', 'New attendance successfully saved<br>New Information<br>Category: Manual<br>Type: Daily<br>Time-In: 2023-07-12 @ 06:59<br>Time-Out: 2023-07-12 @ 17:00<br>Requested By: - , employee 1 <br>Approved By: <br>Status: Pending', '2023-07-31 @ 10:24:18 PM', 1),
(301, '31202307362510301', 'ACCOUNT LOGIN', 4, 'LOGIN', 'Date and Time of Login: 2023-07-31 @ 10:36:24 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-07-31 @ 10:36:25 PM', 4),
(302, '31202307070911302', 'UPDATE ATTENDANCE', 61, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-12 @ 07:00<br>Time-Out: 2023-07-12 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-31 @ 11:07:09 PM', 1),
(303, '31202307245911303', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 23:00 TO 01:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:24:59 PM', 1),
(304, '31202307251011304', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 23:59 TO 01:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:25:10 PM', 1),
(305, '31202307252611305', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 00:00 TO 01:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:25:26 PM', 1),
(306, '31202307321411306', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 00:00 TO 01:30<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:32:14 PM', 1),
(307, '31202307392011307', 'UPDATE SHIFTING SCHEDULE', 1, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 08:00 TO 17:00<br>Shift Break: 12:00 TO 13:30<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:39:20 PM', 1),
(308, '31202307393311308', 'UPDATE SHIFTING SCHEDULE', 1, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 08:00 TO 17:00<br>Shift Break: 12:00 TO 13:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:39:33 PM', 1),
(309, '31202307452711309', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:30<br>Shift Break: 00:00 TO 01:30<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:45:27 PM', 1),
(310, '31202307453711310', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 00:00 TO 01:30<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-07-31 @ 11:45:37 PM', 1),
(311, '31202307533611311', 'UPDATE ATTENDANCE', 61, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-12 @ 08:30<br>Time-Out: 2023-07-12 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-31 @ 11:53:36 PM', 1),
(312, '31202307535211312', 'UPDATE ATTENDANCE', 61, 'UPDATE', 'Updating attendance successfully saved<br>New Information<br>Type: Daily<br>Time-In: 2023-07-12 @ 08:00<br>Time-Out: 2023-07-12 @ 17:00<br>Requested By: - , employee 1 ', '2023-07-31 @ 11:53:52 PM', 1),
(313, '01202308070912313', 'UPDATE SHIFTING SCHEDULE', 2, 'UPDATE', 'Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: 20:00 TO 05:00<br>Shift Break: 00:00 TO 01:00<br>Monday: Yes <br>Tuesday: Yes <br>Wednesday: Yes <br>Thursday: Yes <br>Friday: Yes <br>Saturday: No <br>Sunday No', '2023-08-01 @ 12:07:09 AM', 1),
(314, '01202308085712314', 'UPDATE ATTENDANCE STATUS', 61, 'UPDATE', 'Updating of attendance status successfully saved<br>Status: Approved', '2023-08-01 @ 12:08:57 AM', 1),
(315, '01202308241501315', 'ACCOUNT LOGIN', 1, 'LOGIN', 'Date and Time of Login: 2023-08-01 @ 01:24:14 AM<br>IP ADDRESS: ::1<br>Sign in through Email', '2023-08-01 @ 01:24:15 AM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_history`
--

CREATE TABLE `tbl_work_history` (
  `work_history_id` int(11) NOT NULL,
  `work_history_code` varchar(255) DEFAULT NULL,
  `work_history_applicant_id` int(11) DEFAULT NULL,
  `work_history_job_title` mediumtext,
  `work_history_job_responsibilities` mediumtext,
  `work_history_date_from` date DEFAULT NULL,
  `work_history_date_to` date DEFAULT NULL,
  `work_history_company` mediumtext,
  `work_history_created_at` varchar(255) DEFAULT NULL,
  `work_history_status` varchar(45) DEFAULT NULL,
  `work_history_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_applicant_application`
--
ALTER TABLE `tbl_applicant_application`
  ADD PRIMARY KEY (`applicant_application_id`),
  ADD KEY `fk_tbl_applicant_application_tbl_person1` (`applicant_id`),
  ADD KEY `fk_tbl_applicant_application_tbl_contract1` (`contract_id`);

--
-- Indexes for table `tbl_application_history`
--
ALTER TABLE `tbl_application_history`
  ADD PRIMARY KEY (`application_history_id`),
  ADD KEY `fk_tbl_application_history_tbl_applicant_application1` (`applicant_application_id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `tbl_benefits_category`
--
ALTER TABLE `tbl_benefits_category`
  ADD PRIMARY KEY (`benefits_category_id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `tbl_branch_person`
--
ALTER TABLE `tbl_branch_person`
  ADD PRIMARY KEY (`branch_person_id`),
  ADD KEY `fk_tbl_branch_person_tbl_person1` (`person_id`),
  ADD KEY `fk_tbl_branch_person_tbl_branch1` (`branch_id`);

--
-- Indexes for table `tbl_contract`
--
ALTER TABLE `tbl_contract`
  ADD PRIMARY KEY (`contract_id`),
  ADD KEY `fk_tbl_contract_tbl_job_position1` (`contract_job_position_id`),
  ADD KEY `fk_tbl_contract_tbl_shifting_schedule1` (`contract_shifting_schedule_id`);

--
-- Indexes for table `tbl_contract_branch`
--
ALTER TABLE `tbl_contract_branch`
  ADD PRIMARY KEY (`contract_branch_id`),
  ADD KEY `fk_tbl_contract_branch_tbl_branch1` (`branch_id`),
  ADD KEY `fk_tbl_contract_branch_tbl_contract1` (`contract_id`);

--
-- Indexes for table `tbl_contract_leave_category`
--
ALTER TABLE `tbl_contract_leave_category`
  ADD PRIMARY KEY (`contract_category_credit_id`),
  ADD KEY `fk_tbl_contract_leave_category_tbl_leave_category1` (`leave_category_id`),
  ADD KEY `fk_tbl_contract_leave_credit_tbl_contract1` (`contract_id`);

--
-- Indexes for table `tbl_contract_payroll_period`
--
ALTER TABLE `tbl_contract_payroll_period`
  ADD PRIMARY KEY (`contract_payroll_period_id`),
  ADD KEY `fk_tbl_contract_payroll_period_tbl_contract1` (`contract_id`),
  ADD KEY `fk_tbl_contract_payroll_period_tbl_payroll_period1` (`payroll_period_id`);

--
-- Indexes for table `tbl_deduction_category`
--
ALTER TABLE `tbl_deduction_category`
  ADD PRIMARY KEY (`deduction_category_id`);

--
-- Indexes for table `tbl_holiday`
--
ALTER TABLE `tbl_holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `tbl_job_position`
--
ALTER TABLE `tbl_job_position`
  ADD PRIMARY KEY (`job_position_id`);

--
-- Indexes for table `tbl_leave_category`
--
ALTER TABLE `tbl_leave_category`
  ADD PRIMARY KEY (`leave_category_id`);

--
-- Indexes for table `tbl_leave_request`
--
ALTER TABLE `tbl_leave_request`
  ADD PRIMARY KEY (`leave_request_id`),
  ADD KEY `fk_tbl_leave_request_tbl_leave_category` (`leave_request_category_id`),
  ADD KEY `fk_tbl_leave_request_tbl_person1` (`leave_request_by`);

--
-- Indexes for table `tbl_payroll`
--
ALTER TABLE `tbl_payroll`
  ADD PRIMARY KEY (`payroll_id`);

--
-- Indexes for table `tbl_payroll_benefits_deduction`
--
ALTER TABLE `tbl_payroll_benefits_deduction`
  ADD PRIMARY KEY (`payroll_benefits_deduction_id`),
  ADD KEY `fk_tbl_payroll_benefits_deduction_tbl_payroll1` (`payroll_id`);

--
-- Indexes for table `tbl_payroll_period`
--
ALTER TABLE `tbl_payroll_period`
  ADD PRIMARY KEY (`payroll_period_id`);

--
-- Indexes for table `tbl_payroll_period_benefits_deduction`
--
ALTER TABLE `tbl_payroll_period_benefits_deduction`
  ADD PRIMARY KEY (`payroll_period_benefits_deduction_id`),
  ADD KEY `fk_tbl_payroll_period_benefits_deduction_tbl_contract_payroll1` (`contract_payroll_period_id`);

--
-- Indexes for table `tbl_person`
--
ALTER TABLE `tbl_person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `tbl_person_shifting_schedule`
--
ALTER TABLE `tbl_person_shifting_schedule`
  ADD PRIMARY KEY (`person_shifting_schedule_id`),
  ADD KEY `fk_tbl_person_shifting_schedule_tbl_branch1` (`branch_id`),
  ADD KEY `fk_tbl_person_shifting_schedule_tbl_shifting_schedule1` (`shifting_schedule_id`),
  ADD KEY `fk_tbl_person_shifting_schedule_tbl_person1` (`person_id`);

--
-- Indexes for table `tbl_shifting_schedule`
--
ALTER TABLE `tbl_shifting_schedule`
  ADD PRIMARY KEY (`shifting_schedule_id`);

--
-- Indexes for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `tbl_transaction_logs`
--
ALTER TABLE `tbl_transaction_logs`
  ADD PRIMARY KEY (`transaction_logs_id`);

--
-- Indexes for table `tbl_work_history`
--
ALTER TABLE `tbl_work_history`
  ADD PRIMARY KEY (`work_history_id`),
  ADD KEY `fk_tbl_work_history_tbl_person1` (`work_history_applicant_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_applicant_application`
--
ALTER TABLE `tbl_applicant_application`
  ADD CONSTRAINT `fk_tbl_applicant_application_tbl_contract1` FOREIGN KEY (`contract_id`) REFERENCES `tbl_contract` (`contract_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_applicant_application_tbl_person1` FOREIGN KEY (`applicant_id`) REFERENCES `tbl_person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_application_history`
--
ALTER TABLE `tbl_application_history`
  ADD CONSTRAINT `fk_tbl_application_history_tbl_applicant_application1` FOREIGN KEY (`applicant_application_id`) REFERENCES `tbl_applicant_application` (`applicant_application_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_branch_person`
--
ALTER TABLE `tbl_branch_person`
  ADD CONSTRAINT `fk_tbl_branch_person_tbl_branch1` FOREIGN KEY (`branch_id`) REFERENCES `tbl_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_branch_person_tbl_person1` FOREIGN KEY (`person_id`) REFERENCES `tbl_person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_contract`
--
ALTER TABLE `tbl_contract`
  ADD CONSTRAINT `fk_tbl_contract_tbl_job_position1` FOREIGN KEY (`contract_job_position_id`) REFERENCES `tbl_job_position` (`job_position_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_contract_tbl_shifting_schedule1` FOREIGN KEY (`contract_shifting_schedule_id`) REFERENCES `tbl_shifting_schedule` (`shifting_schedule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_contract_branch`
--
ALTER TABLE `tbl_contract_branch`
  ADD CONSTRAINT `fk_tbl_contract_branch_tbl_branch1` FOREIGN KEY (`branch_id`) REFERENCES `tbl_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_contract_branch_tbl_contract1` FOREIGN KEY (`contract_id`) REFERENCES `tbl_contract` (`contract_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_contract_leave_category`
--
ALTER TABLE `tbl_contract_leave_category`
  ADD CONSTRAINT `fk_tbl_contract_leave_category_tbl_leave_category1` FOREIGN KEY (`leave_category_id`) REFERENCES `tbl_leave_category` (`leave_category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_contract_leave_credit_tbl_contract1` FOREIGN KEY (`contract_id`) REFERENCES `tbl_contract` (`contract_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_contract_payroll_period`
--
ALTER TABLE `tbl_contract_payroll_period`
  ADD CONSTRAINT `fk_tbl_contract_payroll_period_tbl_contract1` FOREIGN KEY (`contract_id`) REFERENCES `tbl_contract` (`contract_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_contract_payroll_period_tbl_payroll_period1` FOREIGN KEY (`payroll_period_id`) REFERENCES `tbl_payroll_period` (`payroll_period_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_leave_request`
--
ALTER TABLE `tbl_leave_request`
  ADD CONSTRAINT `fk_tbl_leave_request_tbl_leave_category` FOREIGN KEY (`leave_request_category_id`) REFERENCES `tbl_leave_category` (`leave_category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_leave_request_tbl_person1` FOREIGN KEY (`leave_request_by`) REFERENCES `tbl_person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_payroll_benefits_deduction`
--
ALTER TABLE `tbl_payroll_benefits_deduction`
  ADD CONSTRAINT `fk_tbl_payroll_benefits_deduction_tbl_payroll1` FOREIGN KEY (`payroll_id`) REFERENCES `tbl_payroll` (`payroll_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_payroll_period_benefits_deduction`
--
ALTER TABLE `tbl_payroll_period_benefits_deduction`
  ADD CONSTRAINT `fk_tbl_payroll_period_benefits_deduction_tbl_contract_payroll1` FOREIGN KEY (`contract_payroll_period_id`) REFERENCES `tbl_contract_payroll_period` (`contract_payroll_period_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_person_shifting_schedule`
--
ALTER TABLE `tbl_person_shifting_schedule`
  ADD CONSTRAINT `fk_tbl_person_shifting_schedule_tbl_branch1` FOREIGN KEY (`branch_id`) REFERENCES `tbl_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_person_shifting_schedule_tbl_person1` FOREIGN KEY (`person_id`) REFERENCES `tbl_person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_person_shifting_schedule_tbl_shifting_schedule1` FOREIGN KEY (`shifting_schedule_id`) REFERENCES `tbl_shifting_schedule` (`shifting_schedule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_work_history`
--
ALTER TABLE `tbl_work_history`
  ADD CONSTRAINT `fk_tbl_work_history_tbl_person1` FOREIGN KEY (`work_history_applicant_id`) REFERENCES `tbl_person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
