-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 11:39 PM
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
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '1', '2024-10-20 14:43:41', '2024-11-03 08:33:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `is_taxable` tinyint(1) UNSIGNED NOT NULL,
  `frequency` enum('Weekly','Bi-weekly','Semi-monthly','Monthly') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `effective_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `name`, `amount`, `is_taxable`, `frequency`, `description`, `status`, `effective_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Transportation Allowance', 100.00, 1, 'Semi-monthly', 'Allowance for transportation and such', 'Active', '2024-11-01', '2024-12-31', '2024-11-07 02:38:21', '2024-11-07 02:38:21', NULL),
(2, '111', 111.00, 1, 'Weekly', '123', 'Active', '1111-11-11', '1111-11-11', '2024-11-07 03:15:28', '2024-11-07 03:19:13', NULL),
(3, 'Marc Allowance', 500.00, 1, 'Weekly', 'Marc weekly allowance', 'Active', '2021-01-01', '2024-01-01', '2024-11-07 03:17:05', '2024-11-07 03:17:05', NULL),
(4, 'Marc Allowance 2', 5000.00, 1, 'Weekly', '12312', 'Active', '2023-02-20', '2024-01-01', '2024-11-07 03:20:28', '2024-11-07 03:20:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `location` varchar(100) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `business_type` varchar(100) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `history` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`location`, `industry`, `business_type`, `size`, `history`) VALUES
('99 Location, Sample Size, Sample Location, Sample City, Sample 3', 'Information and Technology', 'Private', 1000, 'The company\'s first major release, **\"ChronoQuest\"** (2011), marked a turning point in its growth. This game, a time-traveling role-playing adventure, pushed the boundaries of storytelling and AI-driven gameplay, earning critical acclaim and a dedicated fanbase. The success of ChronoQuest solidified Digital Realms’ reputation as a developer of high-quality, story-rich games. This success allowed them to expand their operations, hiring top talent across programming, art, and design, and launching a research and development wing to experiment with emerging tech like virtual reality and AI.');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount_type` enum('Fixed Amount','Percentage-based') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `is_pre_tax` tinyint(1) UNSIGNED NOT NULL,
  `frequency` enum('Weekly','Bi-weekly','Semi-monthly','Monthly','One-time') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `effective_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_head_id` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `department_head_id`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, 'The One', 2, '2', 'Active', '2024-10-20 14:47:26', 1, '2024-11-09 02:47:19', 1, '2024-11-03 01:49:42', 1),
(5, 'Okay 1', 2, 'Okay 2', 'Active', '2024-10-20 14:53:08', 1, '2024-11-09 02:35:56', 1, '2024-11-05 10:51:38', 1),
(9, 'Okay 25', 2, 'Okay 2', 'Active', '2024-10-20 14:53:46', 1, '2024-11-09 02:36:01', 1, '2024-11-07 15:16:14', 1),
(36, 'IT Department', 2, '2333', 'Active', '2024-11-03 01:31:07', 1, '2024-11-09 02:36:08', 1, '2024-11-08 02:01:35', 1),
(56, 'IT Departments', 2, 'Handles IT-related services', 'Archived', '2024-11-03 01:44:34', 1, '2024-11-09 02:44:59', 1, '2024-11-09 02:44:59', 1),
(57, 'IT Departmen 3', 2, '2', 'Inactive', '2024-11-04 17:45:53', 1, '2024-11-09 02:35:20', 1, NULL, NULL),
(58, 'B', 2, 'DDDD', '', '2024-11-04 17:46:18', 1, '2024-11-09 02:35:24', 1, NULL, NULL),
(59, 'C', 2, NULL, 'Active', '2024-11-05 04:22:24', 1, '2024-11-05 04:22:24', 1, NULL, NULL),
(60, 'Okay 3', 2, NULL, 'Active', '2024-11-06 13:37:59', 1, '2024-11-06 13:37:59', 1, NULL, NULL),
(61, '423232', 2, NULL, 'Active', '2024-11-07 15:16:26', 1, '2024-11-09 02:36:16', 1, '2024-11-07 15:16:30', 1),
(62, '12314', 2, NULL, 'Active', '2024-11-07 15:16:36', 1, '2024-11-09 02:36:21', 1, '2024-11-07 15:17:19', 1),
(63, 'ZZZZZZZZZZ', 2, NULL, 'Archived', '2024-11-07 16:23:37', 1, '2024-11-07 16:25:23', 1, '2024-11-07 16:25:23', 1),
(64, 'AAAAAAAAAAAA', 2, '2', 'Archived', '2024-11-07 17:24:05', 1, '2024-11-07 17:24:14', 1, '2024-11-07 17:24:14', 1),
(69, 'QWEWQ', 2, NULL, 'Active', '2024-11-08 01:58:11', 1, '2024-11-08 01:58:11', 1, NULL, NULL),
(70, '55', 2, NULL, 'Archived', '2024-11-08 01:58:54', 1, '2024-11-08 02:01:41', 1, '2024-11-08 02:01:41', 1),
(71, '55555555', 2, NULL, 'Active', '2024-11-08 02:01:44', 1, '2024-11-08 02:01:44', 1, NULL, NULL),
(72, 'A', 2, NULL, 'Archived', '2024-11-08 02:01:52', 1, '2024-11-08 13:22:35', 1, '2024-11-08 13:22:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `rfid_uid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `middle_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `marital_status` enum('Single','Married','Divorced','Legally Separated','Widowed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nationality` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `religion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `profile_picture` mediumblob DEFAULT NULL,
  `emergency_contact_name` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `emergency_contact_relationship` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `emergency_contact_phone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `emergency_contact_email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emergency_contact_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employee_code` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `job_title_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `employment_type` enum('Regular / Permanent','Casual','Contractual','Project-Based','Seasonal','Fixed-Term','Probationary','Part-Time','Self-Employment','Freelance','Internship','Consultancy','Apprenticeship','Traineeship','Gig') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_hire` date NOT NULL,
  `supervisor_id` int(10) UNSIGNED DEFAULT NULL,
  `manager_id` int(10) UNSIGNED DEFAULT NULL,
  `access_role` enum('Staff','Supervisor','Manager') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payroll_group_id` int(10) UNSIGNED NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `tin_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sss_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `philhealth_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pagibig_fund_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `withholding_tax_amount` decimal(10,2) NOT NULL,
  `sss_contribution_employee_share` decimal(7,2) NOT NULL,
  `sss_contribution_employer_share` decimal(7,2) NOT NULL,
  `philhealth_contribution_employee_share` decimal(6,2) NOT NULL,
  `philhealth_contribution_employer_share` decimal(6,2) NOT NULL,
  `pagibig_fund_contribution_employee_share` decimal(5,2) NOT NULL,
  `pagibig_fund_contribution_employer_share` decimal(5,2) NOT NULL,
  `bank_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_branch_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_account_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_account_type` enum('Payroll Account','Current Account','Checking Account','Savings Account') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `rfid_uid`, `first_name`, `middle_name`, `last_name`, `date_of_birth`, `gender`, `marital_status`, `nationality`, `religion`, `phone_number`, `email_address`, `address`, `profile_picture`, `emergency_contact_name`, `emergency_contact_relationship`, `emergency_contact_phone_number`, `emergency_contact_email_address`, `emergency_contact_address`, `employee_code`, `job_title_id`, `department_id`, `employment_type`, `date_of_hire`, `supervisor_id`, `manager_id`, `access_role`, `payroll_group_id`, `basic_salary`, `tin_number`, `sss_number`, `philhealth_number`, `pagibig_fund_number`, `withholding_tax_amount`, `sss_contribution_employee_share`, `sss_contribution_employer_share`, `philhealth_contribution_employee_share`, `philhealth_contribution_employer_share`, `pagibig_fund_contribution_employee_share`, `pagibig_fund_contribution_employer_share`, `bank_name`, `bank_branch_name`, `bank_account_number`, `bank_account_type`, `username`, `password`, `notes`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, '11', 'John', '', 'Doe', '2024-10-20', '6', 'Single', '7', '8', '99', '1010', '11', NULL, '12', '13', '14', '15', NULL, '1616', 1, 2, 'Regular / Permanent', '2024-10-20', NULL, NULL, 'Staff', 1, 17.00, '1818', '1919', '2020', '2121', 22.00, 23.00, 24.00, 25.00, 26.00, 27.00, 28.00, '29', '30', '3131', 'Payroll Account', '3232', '33', '34', '2024-10-20 14:50:03', 1, '2024-11-04 14:06:49', 1, NULL, NULL),
(5, '0123456789', 'John', 'Michael', 'Doe', '2014-07-02', 'Male', 'Married', 'American', 'Christianity', '+1-555-123-4567', 'john.doe@example.com', '123 Maple Street, Springfield, IL, USA', NULL, 'Jane Doe', 'Spouse', '+1-555-987-6543', 'jane.doe@example.com', '123 Maple Street, Springfield, IL, USA', 'EMP123456', 20, 36, 'Regular / Permanent', '2021-03-01', 2, NULL, 'Staff', 1, 50000.00, 'TIN-5678-1234', 'SSS-123456789', 'PH-987654321', 'HDMF-456789123', 7500.00, 400.00, 800.00, 150.00, 300.00, 100.00, 200.00, 'First National Bank', 'Downtown Springfield Branch', '123456789012', 'Savings Account', 'jdoe', '1', 'Key team member in marketing projects.', '2024-11-05 04:46:15', 1, '2024-11-05 04:46:15', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_allowances`
--

CREATE TABLE `employee_allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `allowance_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_allowances`
--

INSERT INTO `employee_allowances` (`id`, `employee_id`, `allowance_id`, `amount`, `created_at`, `deleted_at`) VALUES
(32, 2, 1, 100.00, '2024-11-07 12:24:06', NULL),
(33, 2, 2, 111.00, '2024-11-07 12:25:01', NULL),
(34, 2, 3, 500.00, '2024-11-07 12:25:01', NULL),
(35, 2, 1, 100.00, '2024-11-07 12:36:13', NULL),
(36, 2, 2, 111.00, '2024-11-07 12:36:13', NULL),
(37, 5, 1, 100.00, '2024-11-07 12:38:41', NULL),
(38, 5, 1, 100.00, '2024-11-07 12:38:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_deductions`
--

CREATE TABLE `employee_deductions` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `deduction_id` int(10) UNSIGNED NOT NULL,
  `amount_type` enum('Fixed Amount','Percentage-based') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_paid` tinyint(1) UNSIGNED NOT NULL,
  `is_recurring_annually` tinyint(1) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

CREATE TABLE `job_titles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `title`, `department_id`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Senior Developer', 2, 'Updated description for Senior Developer', 'Archived', '2024-10-20 14:47:48', 1, '2024-11-03 07:38:27', 1, '2024-11-03 07:38:27', 1),
(2, 'A', 2, 'The ADDDD1234', 'Active', '2024-10-23 09:40:26', 1, '2024-11-09 04:20:52', 1, NULL, NULL),
(5, 'B', 2, '1234', 'Archived', '2024-10-23 09:43:31', 1, '2024-11-09 03:50:51', 1, '2024-11-09 03:50:51', 1),
(6, 'C', 2, '123123', 'Active', '2024-10-23 09:43:45', 1, '2024-11-09 03:50:55', 1, NULL, NULL),
(7, 'D', 2, '', 'Active', '2024-10-23 09:44:04', 1, '2024-10-23 09:44:04', 1, NULL, NULL),
(8, 'E', 2, '', 'Active', '2024-10-23 09:44:30', 1, '2024-10-23 09:44:30', 1, NULL, NULL),
(10, 'F', 2, '', 'Active', '2024-10-23 09:45:24', 1, '2024-10-23 09:45:24', 1, NULL, NULL),
(11, 'H', 2, '', 'Active', '2024-10-23 09:46:44', 1, '2024-10-23 09:46:44', 1, NULL, NULL),
(12, 'G', 2, '', 'Active', '2024-10-23 09:47:09', 1, '2024-10-23 09:47:09', 1, NULL, NULL),
(13, 'I', 2, '', 'Active', '2024-10-23 09:57:35', 1, '2024-10-23 09:57:35', 1, NULL, NULL),
(14, 'J', 2, '', 'Active', '2024-10-23 11:45:42', 1, '2024-10-23 11:45:42', 1, NULL, NULL),
(16, 'K', 2, '', 'Active', '2024-10-23 15:03:26', 1, '2024-10-23 15:03:26', 1, NULL, NULL),
(17, 'L', 2, '', 'Active', '2024-10-23 15:05:03', 1, '2024-10-23 15:05:03', 1, NULL, NULL),
(18, 'M', 2, '', 'Active', '2024-10-23 15:06:45', 1, '2024-10-23 15:06:45', 1, NULL, NULL),
(19, 'testing lang toh kay reily tagal', 2, '', 'Inactive', '2024-10-26 04:45:44', 1, '2024-10-26 04:45:44', 1, NULL, NULL),
(20, 'Junior Developer', 2, 'Entry-level position for software development.', 'Active', '2024-11-03 02:32:34', 1, '2024-11-03 02:32:34', 1, NULL, NULL),
(40, 'Okay Job Title', 69, 'Okay 55 department', 'Active', '2024-11-08 09:21:00', 1, '2024-11-08 09:23:49', 1, NULL, NULL),
(41, '55', 9, '444455', 'Active', '2024-11-09 04:18:24', 1, '2024-11-09 04:23:57', 1, NULL, NULL),
(42, 'Reily', 36, '1234', 'Archived', '2024-11-09 04:21:22', 1, '2024-11-09 04:21:54', 1, '2024-11-09 04:21:54', 1),
(43, '1234', 2, '1234', 'Archived', '2024-11-09 04:22:03', 1, '2024-11-09 04:22:10', 1, '2024-11-09 04:22:10', 1),
(44, '', 2, '', 'Archived', '2024-11-09 04:28:36', 1, '2024-11-09 04:30:33', 1, '2024-11-09 04:30:33', 1),
(52, 'ddd', 59, 'ddd', 'Active', '2024-11-09 04:31:07', 1, '2024-11-09 04:31:37', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_entitlements`
--

CREATE TABLE `leave_entitlements` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `number_of_entitled_days` int(10) NOT NULL,
  `number_of_days_taken` int(10) NOT NULL DEFAULT 0,
  `remaining_days` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_entitlements`
--

INSERT INTO `leave_entitlements` (`id`, `employee_id`, `leave_type_id`, `number_of_entitled_days`, `number_of_days_taken`, `remaining_days`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2, 30, 0, 30, '2024-11-09 09:05:13', '2024-11-09 09:07:46', NULL),
(2, 2, 14, 50, 0, 50, '2024-11-09 09:05:13', '2024-11-09 09:07:46', NULL),
(3, 2, 15, 33, 0, 33, '2024-11-09 09:05:13', '2024-11-09 09:05:13', NULL),
(4, 2, 24, 22, 0, 22, '2024-11-09 09:05:13', '2024-11-09 09:05:13', NULL),
(5, 2, 28, 44, 0, 44, '2024-11-09 09:05:13', '2024-11-09 09:05:13', NULL),
(6, 2, 31, 55, 0, 55, '2024-11-09 09:05:13', '2024-11-09 09:05:13', NULL),
(7, 2, 32, 55, 0, 55, '2024-11-09 09:05:13', '2024-11-09 09:05:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected','Canceled','Expired','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by_admin` int(10) UNSIGNED DEFAULT NULL,
  `approved_by_employee` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by_employee` int(10) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by_admin` int(10) UNSIGNED DEFAULT NULL,
  `updated_by_employee` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by_admin` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by_employee` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type_id`, `start_date`, `end_date`, `reason`, `status`, `approved_at`, `approved_by_admin`, `approved_by_employee`, `created_at`, `created_by_employee`, `updated_at`, `updated_by_admin`, `updated_by_employee`, `deleted_at`, `deleted_by_admin`, `deleted_by_employee`) VALUES
(24, 2, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-04 14:08:46', 2, '2024-11-04 14:08:46', NULL, 2, NULL, NULL, NULL),
(25, 2, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-04 17:09:32', 2, '2024-11-04 17:09:32', NULL, 2, NULL, NULL, NULL),
(26, 2, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-05 04:21:49', 2, '2024-11-05 04:21:49', NULL, 2, NULL, NULL, NULL),
(27, 5, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-05 04:47:45', 5, '2024-11-05 04:47:45', NULL, 5, NULL, NULL, NULL),
(28, 5, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-05 04:49:10', 5, '2024-11-05 04:49:10', NULL, 5, NULL, NULL, NULL),
(29, 5, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-05 04:49:36', 5, '2024-11-05 04:49:36', NULL, 5, NULL, NULL, NULL),
(30, 5, 2, '2024-12-01 00:00:00', '2024-11-05 00:00:00', 'Vacation', 'Pending', NULL, NULL, NULL, '2024-11-05 04:50:56', 5, '2024-11-05 04:50:56', NULL, 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `maximum_number_of_days` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `maximum_number_of_days`, `is_paid`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Sick Leave', 14, 0, 'Updated description for Sick Leave', 'Archived', '2024-11-03 08:32:24', 1, '2024-11-04 11:23:25', 1, '2024-11-04 11:23:25', 1),
(2, 'Annual Leave', 30, 1, 'Leave taken for vacation or personal time off.', 'Active', '2024-11-03 08:33:19', 1, '2024-11-03 08:33:19', 1, NULL, NULL),
(14, 'Vacation Leave', 50, 1, 'Sick Leave', 'Active', '2024-11-04 11:23:25', 1, '2024-11-04 11:23:25', 1, NULL, NULL),
(15, 'The Forever Leave', 33, 1, 'Forever', 'Active', '2024-11-08 13:12:31', 1, '2024-11-08 13:12:31', 1, NULL, NULL),
(17, 'DDD', 44, 1, 'FF', 'Archived', '2024-11-08 13:14:29', 1, '2024-11-08 13:30:11', 1, '2024-11-08 13:30:11', 1),
(18, 'test', 333, 1, '333', 'Archived', '2024-11-08 13:26:18', 1, '2024-11-08 13:26:20', 1, '2024-11-08 13:26:20', 1),
(19, 'test3', 4, 1, '23', 'Archived', '2024-11-08 13:26:41', 1, '2024-11-08 13:26:43', 1, '2024-11-08 13:26:43', 1),
(20, '12312', 412412, 1, '3', 'Archived', '2024-11-08 13:27:26', 1, '2024-11-08 13:27:28', 1, '2024-11-08 13:27:28', 1),
(21, 'weqe', 32, 1, 'ee', 'Archived', '2024-11-08 13:28:57', 1, '2024-11-08 13:28:58', 1, '2024-11-08 13:28:58', 1),
(22, 'qwewq', 444, 1, '53535', 'Archived', '2024-11-08 13:31:42', 1, '2024-11-08 13:31:44', 1, '2024-11-08 13:31:44', 1),
(23, 'sddds', 23, 1, '434343', 'Archived', '2024-11-08 13:31:52', 1, '2024-11-08 13:40:47', 1, '2024-11-08 13:40:47', 1),
(24, 'The Modal', 22, 1, 'Modal test44', 'Active', '2024-11-08 14:06:34', 1, '2024-11-08 14:44:33', 1, NULL, NULL),
(25, 'CRUD Leave', 23, 1, 'Create Update Delete', 'Archived', '2024-11-08 14:45:44', 1, '2024-11-08 14:45:54', 1, '2024-11-08 14:45:54', 1),
(28, '44', 44, 1, '44', 'Active', '2024-11-08 14:51:39', 1, '2024-11-08 14:51:39', 1, NULL, NULL),
(31, '555', 55, 1, '44', 'Active', '2024-11-08 14:52:01', 1, '2024-11-08 14:52:01', 1, NULL, NULL),
(32, '666', 55, 1, '44ddd', 'Active', '2024-11-08 14:52:07', 1, '2024-11-09 04:46:51', 1, NULL, NULL),
(33, '123123', 34, 1, '455555', 'Archived', '2024-11-08 14:52:29', 1, '2024-11-09 01:29:21', 1, '2024-11-09 01:29:21', 1),
(35, '12312334', 34, 1, '4523244423232', 'Archived', '2024-11-08 14:52:37', 1, '2024-11-09 04:46:48', 1, '2024-11-09 04:46:48', 1),
(36, 'RRRRR', 34, 1, '45dd', 'Archived', '2024-11-08 14:52:41', 1, '2024-11-09 01:29:06', 1, '2024-11-09 01:29:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_groups`
--

CREATE TABLE `payroll_groups` (
  `id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_groups`
--

INSERT INTO `payroll_groups` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_tokens`
--

CREATE TABLE `remember_me_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selector` varchar(16) DEFAULT NULL,
  `hashed_token` varchar(64) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remember_me_tokens`
--

INSERT INTO `remember_me_tokens` (`id`, `user_id`, `selector`, `hashed_token`, `expires_at`) VALUES
(1, 5, 'df0f060d1f5317f3', '2c7b948928ad865897895926c9183526b3f8b09b1b8a825f13522b095774a6f0', '2024-12-12 08:58:01'),
(2, 5, 'b08a238fb8001bc7', '707110027ccabf86b442d275c669bab708cb71695e92cf356cff19b87ef14953', '2024-12-12 08:59:04'),
(3, 5, '99fd0c1a0e761555', 'a4c0062143e5fa63d8eda46cbc6ab0122c129d26cb36a0fec2c69a1618cf7674', '2024-11-10 09:01:13'),
(4, 5, '01ff55c527271a04', '90ff9769e14feee90ab3ed963bff154c069bb7e232f838935d0fb74c4e9d8859', '2024-12-12 09:05:08'),
(5, 5, '1555a41351e1c110', 'acc5e23aa1ece649338d1a8d4415f1f37023cdc67517c920ae14341c4afc062c', '2024-11-12 09:08:13'),
(6, 5, 'a2d4e163eb12ee45', 'cdcf2302f5806ec63f08538f5e03a726c698d98e368bc385d7a8cd0dfc0c3452', '2024-12-12 09:19:30'),
(7, 5, '073d5345fd573ee5', 'ecd3c630488d75ea0840e37b307254e5889b4e2915d7fa6364cc31b9332f8a78', '2024-12-12 09:19:41'),
(8, 5, '24aff430c05b4774', 'd69195c4e22c7e40204a670472a9569b4c05d327cdc6c82928c3d674c9f0cffe', '2024-12-12 14:32:09'),
(9, 2, '71285a55deead667', '957e215b031e4b28c92aa4584019ccab4519b6d8f0cd2d7aedcdc2f51ec15beb', '2024-12-12 14:43:10'),
(10, 5, '2e8903c7617679d9', 'f17d1f66ef68c7e248509de9b2baf40d12989279a08ae0f8e77b1cc3de607052', '2024-12-19 08:17:53'),
(11, 5, '08ba787a2909ec74', '8b548a8225c4e4215fac75d743611ad8a4822f7cf8dd4b604447b1f3cc5b4455', '2024-12-19 08:18:34'),
(12, 5, '5629931f4299f868', '498a542499b71239b24e6bf6ee0f9ec98bcab5fb1940f986a276cc5fc0dc977e', '2024-12-20 08:55:05'),
(13, 5, '843ff346037638ef', '79be240b26194772de80d38559f4e0f3a58d42f27ba74a5a5e4d2728a6699c42', '2024-12-20 08:55:16'),
(14, 5, 'e9adf25de6b471c5', '66eca016e06edd3797444b568e0ff4054e7faed1b53f4fb15d8d38b022a8cf4f', '2024-12-20 08:55:22'),
(15, 5, '4d456fa9afafc43b', 'b443740a1ff2852d2e05779824abf957b81c81ffe486e9b18af3ab28cccfda4c', '2024-12-20 08:55:28'),
(16, 5, '07be8feb7552e76d', 'a06433ba57f8eeb9effa1368df88ab6f600c67dd18278599bd844287279fbc04', '2024-12-20 09:03:35'),
(17, 5, '92946a78a2780c56', '5a01c13ce65bbfe18f2c54adc45d494a90e278422e4002a8ba11bdb70db0c7f2', '2024-12-29 14:45:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_admins_username` (`username`),
  ADD KEY `idx_admins_deleted_at` (`deleted_at`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_allowances_name` (`name`),
  ADD KEY `idx_allowances_frequency` (`frequency`),
  ADD KEY `idx_allowances_status` (`status`),
  ADD KEY `idx_allowances_deleted_at` (`deleted_at`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_deductions_name` (`name`),
  ADD KEY `idx_deductions_frequency` (`frequency`),
  ADD KEY `idx_deductions_status` (`status`),
  ADD KEY `idx_deductions_deleted_at` (`deleted_at`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_departments_name` (`name`),
  ADD KEY `idx_departments_status` (`status`),
  ADD KEY `idx_departments_deleted_at` (`deleted_at`),
  ADD KEY `fk_admins_departments_created_by` (`created_by`),
  ADD KEY `fk_admins_departments_updated_by` (`updated_by`),
  ADD KEY `fk_admins_departments_deleted_by` (`deleted_by`),
  ADD KEY `fk_employees_departments_department_head_id` (`department_head_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_staff_rfid_uid` (`rfid_uid`),
  ADD UNIQUE KEY `uq_staff_phone_number` (`phone_number`),
  ADD UNIQUE KEY `uq_staff_email_address` (`email_address`),
  ADD UNIQUE KEY `uq_staff_employee_code` (`employee_code`),
  ADD UNIQUE KEY `uq_staff_tin_number` (`tin_number`),
  ADD UNIQUE KEY `uq_staff_sss_number` (`sss_number`),
  ADD UNIQUE KEY `uq_staff_philhealth_number` (`philhealth_number`),
  ADD UNIQUE KEY `uq_staff_pagibig_fund_number` (`pagibig_fund_number`),
  ADD UNIQUE KEY `uq_staff_bank_account_number` (`bank_account_number`),
  ADD UNIQUE KEY `uq_staff_username` (`username`),
  ADD KEY `idx_staff_first_name_last_name` (`first_name`,`last_name`),
  ADD KEY `idx_staff_date_of_birth` (`date_of_birth`),
  ADD KEY `idx_staff_gender` (`gender`),
  ADD KEY `idx_staff_marital_status` (`marital_status`),
  ADD KEY `idx_staff_employment_type` (`employment_type`),
  ADD KEY `idx_staff_date_of_hire` (`date_of_hire`),
  ADD KEY `idx_staff_access_role` (`access_role`),
  ADD KEY `idx_staff_deleted_at` (`deleted_at`),
  ADD KEY `fk_job_titles_staff_job_title_id` (`job_title_id`),
  ADD KEY `fk_departments_staff_department_id` (`department_id`),
  ADD KEY `fk_staff_supervisor_id` (`supervisor_id`),
  ADD KEY `fk_staff_manager_id` (`manager_id`),
  ADD KEY `fk_payroll_groups_staff_payroll_group_id` (`payroll_group_id`),
  ADD KEY `fk_admins_staff_created_by` (`created_by`),
  ADD KEY `fk_admins_staff_updated_by` (`updated_by`),
  ADD KEY `fk_admins_staff_deleted_by` (`deleted_by`);

--
-- Indexes for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_employee_allowances_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_employee_allowances_employee_id` (`employee_id`),
  ADD KEY `fk_allowances_employee_allowances_allowance_id` (`allowance_id`);

--
-- Indexes for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_employee_deductions_deduction_id` (`deduction_id`),
  ADD KEY `idx_employee_deductions_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_employee_deductions_employee_id` (`employee_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_holidays_name` (`name`),
  ADD KEY `idx_holidays_deleted_at` (`deleted_at`),
  ADD KEY `idx_holidays_status` (`status`),
  ADD KEY `idx_holidays_start_date` (`start_date`),
  ADD KEY `idx_holidays_end_date` (`end_date`);

--
-- Indexes for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_job_titles_title` (`title`),
  ADD KEY `idx_job_titles_status` (`status`),
  ADD KEY `idx_job_titles_deleted_at` (`deleted_at`),
  ADD KEY `fk_departments_job_titles_department_id` (`department_id`),
  ADD KEY `fk_admins_job_titles_created_by` (`created_by`),
  ADD KEY `fk_admins_job_titles_updated_by` (`updated_by`),
  ADD KEY `fk_admins_job_titles_deleted_by` (`deleted_by`);

--
-- Indexes for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_leave_entitlements_leave_type_id` (`leave_type_id`),
  ADD KEY `idx_leave_entitlements_remaining_days` (`remaining_days`),
  ADD KEY `idx_leave_entitlements_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_leave_entitlements_employee_id` (`employee_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leave_requests_status` (`status`),
  ADD KEY `idx_leave_requests_deleted_at` (`deleted_at`),
  ADD KEY `fk_admins_leave_requests_approved_by_admin` (`approved_by_admin`),
  ADD KEY `fk_employees_leave_requests_approved_by_employee` (`approved_by_employee`),
  ADD KEY `fk_employees_leave_requests_created_by_employee` (`created_by_employee`),
  ADD KEY `fk_admins_leave_requests_updated_by_admin` (`updated_by_admin`),
  ADD KEY `fk_employees_leave_requests_updated_by_employee` (`updated_by_employee`),
  ADD KEY `fk_admins_leave_requests_deleted_by_admin` (`deleted_by_admin`),
  ADD KEY `fk_employees_leave_requests_deleted_by_employee` (`deleted_by_employee`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_leave_types_name` (`name`),
  ADD KEY `idx_leave_types_status` (`status`),
  ADD KEY `idx_leave_types_deleted_at` (`deleted_at`),
  ADD KEY `fk_admins_leave_types_created_by` (`created_by`),
  ADD KEY `fk_admins_leave_types_updated_by` (`updated_by`),
  ADD KEY `fk_admins_leave_types_deleted_by` (`deleted_by`);

--
-- Indexes for table `payroll_groups`
--
ALTER TABLE `payroll_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_titles`
--
ALTER TABLE `job_titles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `payroll_groups`
--
ALTER TABLE `payroll_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `fk_admins_departments_created_by` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_departments_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_departments_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_employees_departments_department_head_id` FOREIGN KEY (`department_head_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_admins_staff_created_by` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_staff_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_staff_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_departments_staff_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_job_titles_staff_job_title_id` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_payroll_groups_staff_payroll_group_id` FOREIGN KEY (`payroll_group_id`) REFERENCES `payroll_groups` (`id`),
  ADD CONSTRAINT `fk_staff_manager_id` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_staff_supervisor_id` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD CONSTRAINT `fk_allowances_employee_allowances_allowance_id` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`),
  ADD CONSTRAINT `fk_employees_employee_allowances_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD CONSTRAINT `fk_admins_job_titles_created_by` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_job_titles_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_job_titles_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_departments_job_titles_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  ADD CONSTRAINT `fk_employees_leave_entitlements_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_leave_types_leave_entitlements_leave_type_id` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `fk_admins_leave_requests_approved_by_admin` FOREIGN KEY (`approved_by_admin`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_leave_requests_deleted_by_admin` FOREIGN KEY (`deleted_by_admin`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_leave_requests_updated_by_admin` FOREIGN KEY (`updated_by_admin`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_employees_leave_requests_approved_by_employee` FOREIGN KEY (`approved_by_employee`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_employees_leave_requests_created_by_employee` FOREIGN KEY (`created_by_employee`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_employees_leave_requests_deleted_by_employee` FOREIGN KEY (`deleted_by_employee`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_employees_leave_requests_updated_by_employee` FOREIGN KEY (`updated_by_employee`) REFERENCES `employees` (`id`);

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `fk_admins_leave_types_created_by` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_leave_types_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fk_admins_leave_types_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
