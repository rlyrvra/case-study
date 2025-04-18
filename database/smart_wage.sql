-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 07:04 PM
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
-- Database: `smart_wage`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `frequency` enum('Weekly','Bi-weekly','Semi-monthly','Monthly') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(10) UNSIGNED NOT NULL,
  `work_schedule_snapshot_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `check_in_time` datetime DEFAULT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `total_break_duration_in_minutes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_hours_worked` decimal(5,2) NOT NULL DEFAULT 0.00,
  `late_check_in` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `early_check_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `overtime_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_overtime_approved` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `attendance_status` varchar(25) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `is_processed_for_next_payroll` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `break_schedules`
--

CREATE TABLE `break_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `work_schedule_id` int(10) UNSIGNED NOT NULL,
  `break_type_id` int(10) UNSIGNED NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `break_schedule_snapshots`
--

CREATE TABLE `break_schedule_snapshots` (
  `id` int(10) UNSIGNED NOT NULL,
  `break_schedule_id` int(10) UNSIGNED NOT NULL,
  `work_schedule_snapshot_id` int(10) UNSIGNED NOT NULL,
  `break_type_snapshot_id` int(10) UNSIGNED NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `active_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `break_types`
--

CREATE TABLE `break_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `duration_in_minutes` int(10) UNSIGNED NOT NULL,
  `is_paid` tinyint(1) UNSIGNED NOT NULL,
  `is_require_break_in_and_break_out` tinyint(1) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `break_type_snapshots`
--

CREATE TABLE `break_type_snapshots` (
  `id` int(10) UNSIGNED NOT NULL,
  `break_type_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `duration_in_minutes` int(10) UNSIGNED NOT NULL,
  `is_paid` tinyint(1) UNSIGNED NOT NULL,
  `is_require_break_in_and_break_out` tinyint(1) UNSIGNED NOT NULL,
  `active_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_established` varchar(100) NOT NULL,
  `img_location` varchar(100) NOT NULL,
  `history` varchar(600) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `business_type` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `employee_count` int(11) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `mission` varchar(200) NOT NULL,
  `vision` varchar(200) NOT NULL,
  `company_values` varchar(200) NOT NULL,
  `policies` varchar(200) NOT NULL,
  `compliance` varchar(200) NOT NULL,
  `notes` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `frequency` enum('Weekly','Bi-weekly','Semi-monthly','Monthly','One-time') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `department_head_id`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Department A', NULL, 'Description of Department A', 'Active', '2025-04-17 16:54:52', '2025-04-17 16:54:52', NULL);

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
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci GENERATED ALWAYS AS (concat_ws(' ',`first_name`,`middle_name`,`last_name`)) STORED,
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
  `employment_type` enum('Regular','Regular Permanent','Casual','Contractual','Project-Based','Seasonal','Fixed-Term','Probationary','Part-Time','Regular Part-Time','Part-Time Permanent','Self-Employment','Freelance','Internship','Consultancy','Apprenticeship','Traineeship','Gig') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_hire` date NOT NULL,
  `supervisor_id` int(10) UNSIGNED DEFAULT NULL,
  `access_role` enum('Staff','Supervisor','Manager','Admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payroll_group_id` int(10) UNSIGNED DEFAULT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `tin_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sss_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `philhealth_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pagibig_fund_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_branch_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_account_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank_account_type` enum('Payroll Account','Current Account','Checking Account','Savings Account') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `rfid_uid`, `first_name`, `middle_name`, `last_name`, `date_of_birth`, `gender`, `marital_status`, `nationality`, `religion`, `phone_number`, `email_address`, `address`, `profile_picture`, `emergency_contact_name`, `emergency_contact_relationship`, `emergency_contact_phone_number`, `emergency_contact_email_address`, `emergency_contact_address`, `employee_code`, `job_title_id`, `department_id`, `employment_type`, `date_of_hire`, `supervisor_id`, `access_role`, `payroll_group_id`, `basic_salary`, `tin_number`, `sss_number`, `philhealth_number`, `pagibig_fund_number`, `bank_name`, `bank_branch_name`, `bank_account_number`, `bank_account_type`, `username`, `password`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1234567890123', 'John', 'Doe', 'Smith', '1999-01-01', 'Male', 'Single', 'Local', NULL, '+123456789', 'john.doe@example.com', '123 Elm St, Springfield, IL', NULL, 'Jane Smith', 'Spouse', '+1234567891', 'jane.smith@example.com', '456 Oak St, Springfield, IL', 'EMP-0001', 1, 1, 'Regular', '1999-01-01', NULL, 'Admin', NULL, 645.00, '123-456-789-123', '1234-5555333-3', '12-333333331-2', '1234-4444-5555', 'ABC Bank', 'Main Branch, Springfield', '1234567890123456', 'Payroll Account', 'admin', 'admin', NULL, '2025-04-17 17:04:21', '2025-04-17 17:04:21', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `employee_breaks`
--

CREATE TABLE `employee_breaks` (
  `id` int(10) UNSIGNED NOT NULL,
  `break_schedule_snapshot_id` int(10) UNSIGNED NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `break_duration_in_minutes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_deductions`
--

CREATE TABLE `employee_deductions` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `deduction_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employment_type_benefits`
--

CREATE TABLE `employment_type_benefits` (
  `id` int(10) UNSIGNED NOT NULL,
  `employment_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `leave_type_id` int(10) UNSIGNED DEFAULT NULL,
  `allowance_id` int(10) UNSIGNED DEFAULT NULL,
  `deduction_id` int(10) UNSIGNED DEFAULT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `title`, `department_id`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Job Title A', 1, 'Description of Job Title A', 'Active', '2025-04-17 16:56:17', '2025-04-17 16:56:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_entitlements`
--

CREATE TABLE `leave_entitlements` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `number_of_entitled_days` decimal(10,2) NOT NULL,
  `number_of_days_taken` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining_days` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_half_day` tinyint(1) NOT NULL,
  `half_day_part` enum('first_half','second_half') DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected','Canceled','Expired','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_request_attachments`
--

CREATE TABLE `leave_request_attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `leave_request_id` int(10) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `maximum_number_of_days` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) UNSIGNED NOT NULL,
  `is_encashable` tinyint(1) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtime_rates`
--

CREATE TABLE `overtime_rates` (
  `id` int(10) UNSIGNED NOT NULL,
  `overtime_rate_assignment_id` int(10) UNSIGNED NOT NULL,
  `day_type` enum('Regular Day','Rest Day') NOT NULL,
  `holiday_type` enum('Non-holiday','Special Holiday','Regular Holiday','Double Special Holiday','Double Holiday') NOT NULL,
  `regular_time_rate` decimal(10,5) NOT NULL,
  `overtime_rate` decimal(10,5) NOT NULL,
  `night_differential_rate` decimal(10,5) NOT NULL,
  `night_differential_and_overtime_rate` decimal(10,5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `overtime_rates`
--

INSERT INTO `overtime_rates` (`id`, `overtime_rate_assignment_id`, `day_type`, `holiday_type`, `regular_time_rate`, `overtime_rate`, `night_differential_rate`, `night_differential_and_overtime_rate`, `created_at`, `updated_at`) VALUES
(9, 1, 'Regular Day', 'Non-holiday', 1.00000, 1.25000, 1.10000, 1.37500, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(10, 1, 'Regular Day', 'Special Holiday', 1.30000, 1.69000, 1.43000, 1.85900, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(11, 1, 'Regular Day', 'Regular Holiday', 2.00000, 2.60000, 2.20000, 2.86000, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(12, 1, 'Regular Day', 'Double Holiday', 2.60000, 3.90000, 3.30000, 4.29000, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(13, 1, 'Rest Day', 'Non-holiday', 1.30000, 1.69000, 1.43000, 1.85900, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(14, 1, 'Rest Day', 'Special Holiday', 1.50000, 1.95000, 1.65000, 2.14500, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(15, 1, 'Rest Day', 'Regular Holiday', 2.60000, 3.38000, 2.86000, 3.71800, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(16, 1, 'Rest Day', 'Double Holiday', 3.90000, 5.07000, 4.29000, 5.51700, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(17, 1, 'Regular Day', 'Double Special Holiday', 1.50000, 1.95000, 1.65000, 2.14500, '2024-12-04 02:05:38', '2024-12-04 02:05:38'),
(18, 1, 'Rest Day', 'Double Special Holiday', 1.95000, 2.53500, 2.14500, 2.78850, '2024-12-04 02:05:38', '2024-12-04 02:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `overtime_rate_assignments`
--

CREATE TABLE `overtime_rate_assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `job_title_id` int(10) UNSIGNED DEFAULT NULL,
  `employee_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_groups`
--

CREATE TABLE `payroll_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `payroll_frequency` enum('Weekly','Bi-weekly','Semi-monthly','Monthly') NOT NULL,
  `day_of_weekly_cutoff` tinyint(1) UNSIGNED DEFAULT NULL,
  `day_of_biweekly_cutoff` tinyint(1) UNSIGNED DEFAULT NULL,
  `semi_monthly_first_cutoff` tinyint(1) UNSIGNED DEFAULT NULL,
  `semi_monthly_second_cutoff` tinyint(1) UNSIGNED DEFAULT NULL,
  `payday_offset` tinyint(1) UNSIGNED NOT NULL,
  `payday_adjustment` enum('On the Saturday before','Payday remains on the same day','On the Monday after') NOT NULL,
  `status` enum('Active','Inactive','Archived') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `payroll_group_id` int(10) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `pay_period_start_date` date NOT NULL,
  `pay_period_end_date` date NOT NULL,
  `basic_salary` decimal(10,4) NOT NULL,
  `basic_pay` decimal(10,4) NOT NULL,
  `gross_pay` decimal(10,4) NOT NULL,
  `net_pay` decimal(10,4) NOT NULL,
  `sss_deduction` decimal(10,4) NOT NULL,
  `philhealth_deduction` decimal(10,4) NOT NULL,
  `pagibig_fund_deduction` decimal(10,4) NOT NULL,
  `withholding_tax` decimal(10,4) NOT NULL,
  `thirteen_month_pay` decimal(10,4) DEFAULT NULL,
  `leave_salary` decimal(10,4) DEFAULT NULL,
  `work_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `overtime_rates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(50) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_schedules`
--

CREATE TABLE `work_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_flextime` tinyint(1) UNSIGNED NOT NULL,
  `total_hours_per_week` decimal(10,2) DEFAULT NULL,
  `total_work_hours` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `recurrence_rule` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_schedule_snapshots`
--

CREATE TABLE `work_schedule_snapshots` (
  `id` int(10) UNSIGNED NOT NULL,
  `work_schedule_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_flextime` tinyint(1) UNSIGNED NOT NULL,
  `total_hours_per_week` decimal(10,2) DEFAULT NULL,
  `total_work_hours` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `recurrence_rule` text NOT NULL,
  `grace_period` int(10) UNSIGNED NOT NULL,
  `minutes_can_check_in_before_shift` int(10) UNSIGNED NOT NULL,
  `active_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_allowances_frequency` (`frequency`),
  ADD KEY `idx_allowances_status` (`status`),
  ADD KEY `idx_allowances_deleted_at` (`deleted_at`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_attendance_date` (`date`),
  ADD KEY `idx_attendance_check_in_time` (`check_in_time`),
  ADD KEY `idx_attendance_check_out_time` (`check_out_time`),
  ADD KEY `idx_attendance_attendance_status` (`attendance_status`),
  ADD KEY `fk_work_schedule_snapshots_attendance_work_schedule_snapshot_id` (`work_schedule_snapshot_id`) USING BTREE,
  ADD KEY `idx_attendance_deleted_at` (`deleted_at`);

--
-- Indexes for table `break_schedules`
--
ALTER TABLE `break_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_break_schedules_deleted_at` (`deleted_at`) USING BTREE,
  ADD KEY `idx_break_schedules_start_time` (`start_time`) USING BTREE,
  ADD KEY `fk_work_schedules_break_schedules_work_schedule_id` (`work_schedule_id`) USING BTREE,
  ADD KEY `fk_break_types_break_schedules_break_type_id` (`break_type_id`) USING BTREE;

--
-- Indexes for table `break_schedule_snapshots`
--
ALTER TABLE `break_schedule_snapshots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_break_schedules_break_schedule_id` (`break_schedule_id`),
  ADD KEY `idx_break_schedule_snapshots_active_at` (`active_at`) USING BTREE,
  ADD KEY `idx_break_schedule_snapshots_start_time` (`start_time`) USING BTREE,
  ADD KEY `fk_work_schedule_snapshots_work_schedule_snapshot_id` (`work_schedule_snapshot_id`) USING BTREE,
  ADD KEY `fk_break_type_snapshots_break_type_snapshot_id` (`break_type_snapshot_id`) USING BTREE;

--
-- Indexes for table `break_types`
--
ALTER TABLE `break_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_break_types_deleted_at` (`deleted_at`);

--
-- Indexes for table `break_type_snapshots`
--
ALTER TABLE `break_type_snapshots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_break_types_break_type_snapshots_break_type_id` (`break_type_id`) USING BTREE,
  ADD KEY `idx_break_type_snapshots_active_at` (`active_at`) USING BTREE;

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_deductions_frequency` (`frequency`),
  ADD KEY `idx_deductions_status` (`status`),
  ADD KEY `idx_deductions_deleted_at` (`deleted_at`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_departments_status` (`status`),
  ADD KEY `idx_departments_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_departments_department_head_id` (`department_head_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
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
  ADD KEY `fk_payroll_groups_staff_payroll_group_id` (`payroll_group_id`);

--
-- Indexes for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_employee_allowances_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_employee_allowances_employee_id` (`employee_id`),
  ADD KEY `fk_allowances_employee_allowances_allowance_id` (`allowance_id`) USING BTREE;

--
-- Indexes for table `employee_breaks`
--
ALTER TABLE `employee_breaks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_break_schedule_snapshots_break_schedule_snapshot_id` (`break_schedule_snapshot_id`) USING BTREE,
  ADD KEY `idx_employee_breaks_deleted_at` (`deleted_at`),
  ADD KEY `idx_employee_breaks_start_time` (`start_time`) USING BTREE,
  ADD KEY `idx_employee_breaks_created_at` (`created_at`);

--
-- Indexes for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_employee_deductions_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_employee_deductions_employee_id` (`employee_id`),
  ADD KEY `fk_deductions_employee_deductions_deduction_id` (`deduction_id`) USING BTREE;

--
-- Indexes for table `employment_type_benefits`
--
ALTER TABLE `employment_type_benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employment_type_benefits_deleted_at` (`deleted_at`),
  ADD KEY `fk_leave_types_employment_type_benefiits_leave_type_id` (`leave_type_id`),
  ADD KEY `fk_allowances_employment_type_allowance_id` (`allowance_id`),
  ADD KEY `fk_deductions_employment_type_deduction_id` (`deduction_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_holidays_deleted_at` (`deleted_at`),
  ADD KEY `idx_holidays_status` (`status`),
  ADD KEY `idx_holidays_start_date` (`start_date`),
  ADD KEY `idx_holidays_end_date` (`end_date`);

--
-- Indexes for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_job_titles_status` (`status`),
  ADD KEY `idx_job_titles_deleted_at` (`deleted_at`),
  ADD KEY `fk_departments_job_titles_department_id` (`department_id`);

--
-- Indexes for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leave_entitlements_remaining_days` (`remaining_days`),
  ADD KEY `idx_leave_entitlements_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_leave_entitlements_employee_id` (`employee_id`),
  ADD KEY `fk_leave_entitlements_leave_type_id` (`leave_type_id`) USING BTREE;

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leave_requests_status` (`status`),
  ADD KEY `idx_leave_requests_deleted_at` (`deleted_at`),
  ADD KEY `fk_employees_leave_requests_approved_by` (`approved_by`),
  ADD KEY `idx_leave_requests_is_half_day` (`is_half_day`),
  ADD KEY `fk_employees_leave_requests_employee_id` (`employee_id`),
  ADD KEY `fk_leave_types_leave_requests_leave_type_id` (`leave_type_id`),
  ADD KEY `idx_leave_requests_start_date` (`start_date`),
  ADD KEY `idx_leave_requests_end_date` (`end_date`);

--
-- Indexes for table `leave_request_attachments`
--
ALTER TABLE `leave_request_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_request_attachments_deleted_at` (`deleted_at`),
  ADD KEY `fk_leave_requests_leave_request_attachments_leave_request_id` (`leave_request_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leave_types_status` (`status`),
  ADD KEY `idx_leave_types_deleted_at` (`deleted_at`),
  ADD KEY `idx_leave_types_is_encashable` (`is_encashable`);

--
-- Indexes for table `overtime_rates`
--
ALTER TABLE `overtime_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_overtime_rates_overtime_rate_assignment_id` (`overtime_rate_assignment_id`);

--
-- Indexes for table `overtime_rate_assignments`
--
ALTER TABLE `overtime_rate_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_job_titles_overtime_rate_assignments_job_title_id` (`job_title_id`),
  ADD KEY `fk_employees_overtime_rate_assignments_employee_id` (`employee_id`),
  ADD KEY `fk_departments_overtime_rate_assignments_department_id` (`department_id`);

--
-- Indexes for table `payroll_groups`
--
ALTER TABLE `payroll_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payroll_groups_status` (`status`),
  ADD KEY `idx_payroll_groups_deleted_at` (`deleted_at`),
  ADD KEY `idx_payroll_groups_payroll_frequency` (`payroll_frequency`),
  ADD KEY `idx_payroll_groups_day_of_weekly_cutoff` (`day_of_weekly_cutoff`),
  ADD KEY `idx_payroll_groups_day_of_biweekly_cutoff` (`day_of_biweekly_cutoff`),
  ADD KEY `idx_payroll_groups_semi_monthly_first_cutoff` (`semi_monthly_first_cutoff`),
  ADD KEY `idx_payroll_groups_semi_monthly_second_cutoff` (`semi_monthly_second_cutoff`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payslips_deleted_at` (`deleted_at`),
  ADD KEY `idx_payslips_pay_date` (`pay_date`),
  ADD KEY `idx_payslips_pay_period_start_date` (`pay_period_start_date`),
  ADD KEY `idx_payslips_pay_period_end_date` (`pay_period_end_date`),
  ADD KEY `fk_employees_payslips_employee_id` (`employee_id`),
  ADD KEY `fk_payroll_groups_payslips_payroll_group_id` (`payroll_group_id`);

--
-- Indexes for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_settings_setting_key` (`setting_key`),
  ADD KEY `idx_settings_setting_value` (`setting_value`) USING BTREE,
  ADD KEY `idx_settings_group_name` (`group_name`) USING BTREE;

--
-- Indexes for table `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_work_schedules_deleted_at` (`deleted_at`),
  ADD KEY `idx_work_schedules_start_date` (`start_date`),
  ADD KEY `fk_employees_work_schedules_employee_id` (`employee_id`);

--
-- Indexes for table `work_schedule_snapshots`
--
ALTER TABLE `work_schedule_snapshots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_work_schedules_work_schedule_snapshots_work_schedule_id` (`work_schedule_id`) USING BTREE,
  ADD KEY `fk_employees_work_schedule_snaphots_employee_id` (`employee_id`) USING BTREE,
  ADD KEY `idx_work_schedule_snapshots_active_at` (`active_at`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `break_schedules`
--
ALTER TABLE `break_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `break_schedule_snapshots`
--
ALTER TABLE `break_schedule_snapshots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `break_types`
--
ALTER TABLE `break_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `break_type_snapshots`
--
ALTER TABLE `break_type_snapshots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_breaks`
--
ALTER TABLE `employee_breaks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employment_type_benefits`
--
ALTER TABLE `employment_type_benefits`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_request_attachments`
--
ALTER TABLE `leave_request_attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtime_rates`
--
ALTER TABLE `overtime_rates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtime_rate_assignments`
--
ALTER TABLE `overtime_rate_assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_groups`
--
ALTER TABLE `payroll_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_schedules`
--
ALTER TABLE `work_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_schedule_snapshots`
--
ALTER TABLE `work_schedule_snapshots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_work_schedule_snapshots_attendance_work_schedule_snapshot_id` FOREIGN KEY (`work_schedule_snapshot_id`) REFERENCES `work_schedule_snapshots` (`id`);

--
-- Constraints for table `break_schedules`
--
ALTER TABLE `break_schedules`
  ADD CONSTRAINT `fk_break_types_break_schedules_break_type_id` FOREIGN KEY (`break_type_id`) REFERENCES `break_types` (`id`),
  ADD CONSTRAINT `fk_work_schedules_break_schedules_work_schedule_id` FOREIGN KEY (`work_schedule_id`) REFERENCES `work_schedules` (`id`);

--
-- Constraints for table `break_schedule_snapshots`
--
ALTER TABLE `break_schedule_snapshots`
  ADD CONSTRAINT `fk_break_schedules_break_schedule_id` FOREIGN KEY (`break_schedule_id`) REFERENCES `break_schedules` (`id`),
  ADD CONSTRAINT `fk_break_type_shapshots_break_type_snapshot_id` FOREIGN KEY (`break_type_snapshot_id`) REFERENCES `break_type_snapshots` (`id`),
  ADD CONSTRAINT `fk_work_schedule_snapshots_work_schedule_snapshot_id` FOREIGN KEY (`work_schedule_snapshot_id`) REFERENCES `work_schedule_snapshots` (`id`);

--
-- Constraints for table `break_type_snapshots`
--
ALTER TABLE `break_type_snapshots`
  ADD CONSTRAINT `fk_break_types_break_type_snapshots_break_type_id` FOREIGN KEY (`break_type_id`) REFERENCES `break_types` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `fk_employees_departments_department_head_id` FOREIGN KEY (`department_head_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_departments_staff_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_job_titles_staff_job_title_id` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_payroll_groups_staff_payroll_group_id` FOREIGN KEY (`payroll_group_id`) REFERENCES `payroll_groups` (`id`),
  ADD CONSTRAINT `fk_staff_supervisor_id` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD CONSTRAINT `fk_allowances_employee_allowances_allowance_id` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`),
  ADD CONSTRAINT `fk_employees_employee_allowances_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employee_breaks`
--
ALTER TABLE `employee_breaks`
  ADD CONSTRAINT `fk_break_schedule_snapshots_break_schedule_snapshot_id` FOREIGN KEY (`break_schedule_snapshot_id`) REFERENCES `break_schedule_snapshots` (`id`);

--
-- Constraints for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  ADD CONSTRAINT `fk_deductions_employee_deductions_deduction_id` FOREIGN KEY (`deduction_id`) REFERENCES `deductions` (`id`),
  ADD CONSTRAINT `fk_employees_employee_deductions_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employment_type_benefits`
--
ALTER TABLE `employment_type_benefits`
  ADD CONSTRAINT `fk_allowances_employment_type_allowance_id` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`),
  ADD CONSTRAINT `fk_deductions_employment_type_deduction_id` FOREIGN KEY (`deduction_id`) REFERENCES `deductions` (`id`),
  ADD CONSTRAINT `fk_leave_types_employment_type_benefiits_leave_type_id` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`);

--
-- Constraints for table `job_titles`
--
ALTER TABLE `job_titles`
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
  ADD CONSTRAINT `fk_employees_leave_requests_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_employees_leave_requests_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_leave_types_leave_requests_leave_type_id` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`);

--
-- Constraints for table `leave_request_attachments`
--
ALTER TABLE `leave_request_attachments`
  ADD CONSTRAINT `fk_leave_requests_leave_request_attachments_leave_request_id` FOREIGN KEY (`leave_request_id`) REFERENCES `leave_requests` (`id`);

--
-- Constraints for table `overtime_rates`
--
ALTER TABLE `overtime_rates`
  ADD CONSTRAINT `fk_overtime_rates_overtime_rate_assignment_id` FOREIGN KEY (`overtime_rate_assignment_id`) REFERENCES `overtime_rate_assignments` (`id`);

--
-- Constraints for table `overtime_rate_assignments`
--
ALTER TABLE `overtime_rate_assignments`
  ADD CONSTRAINT `fk_departments_overtime_rate_assignments_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_employees_overtime_rate_assignments_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_job_titles_overtime_rate_assignments_job_title_id` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`);

--
-- Constraints for table `payslips`
--
ALTER TABLE `payslips`
  ADD CONSTRAINT `fk_employees_payslips_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_payroll_groups_payslips_payroll_group_id` FOREIGN KEY (`payroll_group_id`) REFERENCES `payroll_groups` (`id`);

--
-- Constraints for table `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD CONSTRAINT `fk_employees_work_schedules_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `work_schedule_snapshots`
--
ALTER TABLE `work_schedule_snapshots`
  ADD CONSTRAINT `fk_employees_work_schedule_snapshots_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `fk_work_schedules_work_schedule_snapshots_work_schedule_id` FOREIGN KEY (`work_schedule_id`) REFERENCES `work_schedules` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
