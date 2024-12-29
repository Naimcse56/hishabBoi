-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2024 at 07:56 AM
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
-- Database: `dummy`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_configurations`
--

CREATE TABLE `account_configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_configurations`
--

INSERT INTO `account_configurations` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'inc_st_first_section', '24', NULL, NULL),
(2, 'inc_st_second_section', '16', NULL, NULL),
(3, 'inc_st_third_section', '19', NULL, NULL),
(4, 'inc_st_fourth_section', '26', NULL, NULL),
(5, 'inc_st_fifth_section', '28', NULL, NULL),
(6, 'inc_st_six_section', '25', NULL, NULL),
(7, 'inc_st_seven_section', '25', NULL, NULL),
(8, 'inc_st_tax_expenses_section', '20', NULL, NULL),
(9, 'balance_sht_first_section', '2', NULL, NULL),
(10, 'balance_sht_second_section', '3', NULL, NULL),
(11, 'balance_sht_third_section', '10', NULL, NULL),
(12, 'balance_sht_fourth_section', '31', NULL, NULL),
(13, 'balance_sht_fifth_section', '12', NULL, NULL),
(14, 'balance_sht_six_section', '0', NULL, NULL),
(15, 'balance_sht_seven_section', '0', NULL, NULL),
(16, 'retail_earning_account', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `created_at`, `updated_at`) VALUES
(1, 'Leke', 'ALL', 'Lek', NULL, NULL),
(2, 'Dollars', 'USD', '$', NULL, NULL),
(3, 'Afghanis', 'AFN', '؋', NULL, NULL),
(4, 'Pesos', 'ARS', '$', NULL, NULL),
(5, 'Guilders', 'AWG', 'ƒ', NULL, NULL),
(6, 'Dollars', 'AUD', '$', NULL, NULL),
(7, 'New Manats', 'AZN', 'ман', NULL, NULL),
(8, 'Dollars', 'BSD', '$', NULL, NULL),
(9, 'Dollars', 'BBD', '$', NULL, NULL),
(10, 'Rubles', 'BYR', 'p.', NULL, NULL),
(11, 'Euro', 'EUR', '€', NULL, NULL),
(12, 'Dollars', 'BZD', 'BZ$', NULL, NULL),
(13, 'Dollars', 'BMD', '$', NULL, NULL),
(14, 'Bolivianos', 'BOB', '$b', NULL, NULL),
(15, 'Convertible Marka', 'BAM', 'KM', NULL, NULL),
(16, 'Pula', 'BWP', 'P', NULL, NULL),
(17, 'Leva', 'BGN', 'лв', NULL, NULL),
(18, 'Reais', 'BRL', 'R$', NULL, NULL),
(19, 'Pounds', 'GBP', '£', NULL, NULL),
(20, 'Dollars', 'BND', '$', NULL, NULL),
(21, 'Riels', 'KHR', '៛', NULL, NULL),
(22, 'Dollars', 'CAD', '$', NULL, NULL),
(23, 'Dollars', 'KYD', '$', NULL, NULL),
(24, 'Pesos', 'CLP', '$', NULL, NULL),
(25, 'Yuan Renminbi', 'CNY', '¥', NULL, NULL),
(26, 'Pesos', 'COP', '$', NULL, NULL),
(27, 'Colón', 'CRC', '₡', NULL, NULL),
(28, 'Kuna', 'HRK', 'kn', NULL, NULL),
(29, 'Pesos', 'CUP', '₱', NULL, NULL),
(30, 'Koruny', 'CZK', 'Kč', NULL, NULL),
(31, 'Kroner', 'DKK', 'kr', NULL, NULL),
(32, 'Pesos', 'DOP ', 'RD$', NULL, NULL),
(33, 'Dollars', 'XCD', '$', NULL, NULL),
(34, 'Pounds', 'EGP', '£', NULL, NULL),
(35, 'Colones', 'SVC', '$', NULL, NULL),
(36, 'Pounds', 'FKP', '£', NULL, NULL),
(37, 'Dollars', 'FJD', '$', NULL, NULL),
(38, 'Cedis', 'GHC', '¢', NULL, NULL),
(39, 'Pounds', 'GIP', '£', NULL, NULL),
(40, 'Quetzales', 'GTQ', 'Q', NULL, NULL),
(41, 'Pounds', 'GGP', '£', NULL, NULL),
(42, 'Dollars', 'GYD', '$', NULL, NULL),
(43, 'Lempiras', 'HNL', 'L', NULL, NULL),
(44, 'Dollars', 'HKD', '$', NULL, NULL),
(45, 'Forint', 'HUF', 'Ft', NULL, NULL),
(46, 'Kronur', 'ISK', 'kr', NULL, NULL),
(47, 'Rupees', 'INR', '₹', NULL, NULL),
(48, 'Rupiahs', 'IDR', 'Rp', NULL, NULL),
(49, 'Rials', 'IRR', '﷼', NULL, NULL),
(50, 'Pounds', 'IMP', '£', NULL, NULL),
(51, 'New Shekels', 'ILS', '₪', NULL, NULL),
(52, 'Dollars', 'JMD', 'J$', NULL, NULL),
(53, 'Yen', 'JPY', '¥', NULL, NULL),
(54, 'Pounds', 'JEP', '£', NULL, NULL),
(55, 'Tenge', 'KZT', 'лв', NULL, NULL),
(56, 'Won', 'KPW', '₩', NULL, NULL),
(57, 'Won', 'KRW', '₩', NULL, NULL),
(58, 'Soms', 'KGS', 'лв', NULL, NULL),
(59, 'Kips', 'LAK', '₭', NULL, NULL),
(60, 'Lati', 'LVL', 'Ls', NULL, NULL),
(61, 'Pounds', 'LBP', '£', NULL, NULL),
(62, 'Dollars', 'LRD', '$', NULL, NULL),
(63, 'Switzerland Francs', 'CHF', 'CHF', NULL, NULL),
(64, 'Litai', 'LTL', 'Lt', NULL, NULL),
(65, 'Denars', 'MKD', 'ден', NULL, NULL),
(66, 'Ringgits', 'MYR', 'RM', NULL, NULL),
(67, 'Rupees', 'MUR', '₨', NULL, NULL),
(68, 'Pesos', 'MXN', '$', NULL, NULL),
(69, 'Tugriks', 'MNT', '₮', NULL, NULL),
(70, 'Meticais', 'MZN', 'MT', NULL, NULL),
(71, 'Dollars', 'NAD', '$', NULL, NULL),
(72, 'Rupees', 'NPR', '₨', NULL, NULL),
(73, 'Guilders', 'ANG', 'ƒ', NULL, NULL),
(74, 'Dollars', 'NZD', '$', NULL, NULL),
(75, 'Cordobas', 'NIO', 'C$', NULL, NULL),
(76, 'Nairas', 'NGN', '₦', NULL, NULL),
(77, 'Krone', 'NOK', 'kr', NULL, NULL),
(78, 'Rials', 'OMR', '﷼', NULL, NULL),
(79, 'Rupees', 'PKR', '₨', NULL, NULL),
(80, 'Balboa', 'PAB', 'B/.', NULL, NULL),
(81, 'Guarani', 'PYG', 'Gs', NULL, NULL),
(82, 'Nuevos Soles', 'PEN', 'S/.', NULL, NULL),
(83, 'Pesos', 'PHP', 'Php', NULL, NULL),
(84, 'Zlotych', 'PLN', 'zł', NULL, NULL),
(85, 'Rials', 'QAR', '﷼', NULL, NULL),
(86, 'New Lei', 'RON', 'lei', NULL, NULL),
(87, 'Rubles', 'RUB', 'руб', NULL, NULL),
(88, 'Pounds', 'SHP', '£', NULL, NULL),
(89, 'Riyals', 'SAR', '﷼', NULL, NULL),
(90, 'Dinars', 'RSD', 'Дин.', NULL, NULL),
(91, 'Rupees', 'SCR', '₨', NULL, NULL),
(92, 'Dollars', 'SGD', '$', NULL, NULL),
(93, 'Dollars', 'SBD', '$', NULL, NULL),
(94, 'Shillings', 'SOS', 'S', NULL, NULL),
(95, 'Rand', 'ZAR', 'R', NULL, NULL),
(96, 'Rupees', 'LKR', '₨', NULL, NULL),
(97, 'Kronor', 'SEK', 'kr', NULL, NULL),
(98, 'Dollars', 'SRD', '$', NULL, NULL),
(99, 'Pounds', 'SYP', '£', NULL, NULL),
(100, 'New Dollars', 'TWD', 'NT$', NULL, NULL),
(101, 'Baht', 'THB', '฿', NULL, NULL),
(102, 'Dollars', 'TTD', 'TT$', NULL, NULL),
(103, 'Lira', 'TRY', 'TL', NULL, NULL),
(104, 'Liras', 'TRL', '£', NULL, NULL),
(105, 'Dollars', 'TVD', '$', NULL, NULL),
(106, 'Hryvnia', 'UAH', '₴', NULL, NULL),
(107, 'Pesos', 'UYU', '$U', NULL, NULL),
(108, 'Sums', 'UZS', 'лв', NULL, NULL),
(109, 'Bolivares Fuertes', 'VEF', 'Bs', NULL, NULL),
(110, 'Dong', 'VND', '₫', NULL, NULL),
(111, 'Rials', 'YER', '﷼', NULL, NULL),
(112, 'Taka', 'BDT', '৳', NULL, NULL),
(113, 'Zimbabwe Dollars', 'ZWD', 'Z$', NULL, NULL),
(114, 'Kenya', 'KES', 'KSh', NULL, NULL),
(115, 'Nigeria', 'naira', '₦', NULL, NULL),
(116, 'Ghana', 'GHS', 'GH₵', NULL, NULL),
(117, 'Ethiopian', 'ETB', 'Br', NULL, NULL),
(118, 'Tanzania', 'TZS', 'TSh', NULL, NULL),
(119, 'Uganda', 'UGX', 'USh', NULL, NULL),
(120, 'Rwandan', 'FRW', 'FRw', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `day_close_fiscal_years`
--

CREATE TABLE `day_close_fiscal_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fiscal_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_date` date NOT NULL DEFAULT '2024-12-29',
  `to_date` date DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `day_close_fiscal_years`
--

INSERT INTO `day_close_fiscal_years` (`id`, `fiscal_year_id`, `from_date`, `to_date`, `is_closed`, `closed_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-12-29', NULL, 0, NULL, '2024-12-28 21:58:05', '2024-12-28 21:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fiscal_years`
--

CREATE TABLE `fiscal_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_date` date NOT NULL DEFAULT '2024-12-29',
  `to_date` date DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL COMMENT 'ex: 23-24',
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fiscal_years`
--

INSERT INTO `fiscal_years` (`id`, `from_date`, `to_date`, `year`, `is_closed`, `closed_by`, `created_at`, `updated_at`) VALUES
(1, '2024-12-29', NULL, '24-25', 0, NULL, '2024-12-28 21:58:05', '2024-12-28 21:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'company_name', 'Hishab Boi', NULL, NULL),
(2, 'company_logo', 'assets/images/invoice.png', NULL, NULL),
(3, 'company_address', NULL, NULL, NULL),
(4, 'company_phone', '01873844448', NULL, NULL),
(5, 'company_email', 'admin@example.com', NULL, NULL),
(6, 'favicon', NULL, NULL, NULL),
(7, 'system_currency_symbol', 'TK', NULL, NULL),
(8, 'system_currency_id', '0', NULL, NULL),
(9, 'date_format', 'd/m/Y', NULL, NULL),
(10, 'decimal_point', '2', NULL, NULL),
(11, 'currency_position', 'left', NULL, NULL),
(12, 'purchase_terms_condition', NULL, NULL, NULL),
(13, 'sale_terms_condition', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `acc_type` varchar(15) DEFAULT 'no' COMMENT 'cash / bank / others ',
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '1 => Asset, 2 => Liability, 3 => Expense, 4 => Income, 5 => Equity',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  `bank_ac_name` varchar(180) DEFAULT NULL COMMENT 'Bank Account Name',
  `ac_no` varchar(100) DEFAULT NULL COMMENT 'Bank Account No',
  `bank_address` varchar(300) DEFAULT NULL COMMENT 'Bank Address',
  `routing_no` varchar(150) DEFAULT NULL COMMENT 'Bank',
  `swift_code` varchar(150) DEFAULT NULL COMMENT 'Bank',
  `branch_code` varchar(30) DEFAULT NULL COMMENT 'Bank',
  `cash_flow` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `view_in_bs` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'for BalanceSheet',
  `view_in_is` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'for IncomeStatement',
  `view_in_trial` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'for Trial Balance',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`id`, `acc_type`, `name`, `code`, `type`, `parent_id`, `level`, `bank_ac_name`, `ac_no`, `bank_address`, `routing_no`, `swift_code`, `branch_code`, `cash_flow`, `is_active`, `view_in_bs`, `view_in_is`, `view_in_trial`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'others', 'Assets', 'A1001', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(2, 'others', 'Non-Current Assets', 'A1002', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(3, 'others', 'Current Asset', 'A1003', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(4, 'bank', 'Bank Balance', 'A1004', 1, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(5, 'cash', 'Cash Balance', 'A1005', 1, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(6, 'others', 'Accounts Receivable AC', 'A1006', 1, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(7, 'others', 'Inventory', 'A1007', 1, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(8, 'others', 'Inter-Company Current Account', 'A1008', 1, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(9, 'others', 'Liabilities', 'L2001', 2, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(10, 'others', 'Authorized Capital', 'E5004', 5, 30, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(11, 'others', 'Capital Account', 'L2002', 2, 10, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(12, 'others', 'Current Liabilities', 'L2003', 2, 9, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(13, 'others', 'Company Tax Liabilities', 'L2004', 2, 12, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(14, 'others', 'Tax Payable', 'L2005', 2, 13, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(15, 'others', 'Accounts Payable AC', 'L2006', 2, 12, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(16, 'others', 'Expenses', 'E3001', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(17, 'others', 'Cost of Sales & Services', 'E3002', 3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(18, 'others', 'Others Cost Expenses', 'E3003', 3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(19, 'others', 'Administrative & Operation Expenses', 'E3004', 3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(20, 'others', 'TAX Expenses', 'E3005', 3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(21, 'others', 'Company Income TAX', 'E3006', 3, 20, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(22, 'others', 'Purchase AC', 'E3007', 3, 17, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(23, 'others', 'Salary Expenses', 'E3008', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(24, 'others', 'Revenue', 'I4001', 4, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(25, 'others', 'Sales from Construction Contract', 'I4002', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(26, 'others', 'Non-Operating Income', 'I4003', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL),
(27, 'others', 'Sales Revenue', 'I4004', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL),
(28, 'others', 'Financial Expenses', 'E3046', 3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(29, 'others', 'Sales From Water Engineering Projects', 'I4005', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(30, 'others', 'Equities', 'E5001', 5, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(31, 'others', 'Shareholder\'s Equity', 'E5002', 5, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(32, 'others', 'Share Capital', 'E5003', 5, 31, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(33, 'others', 'Conveyance Bill', 'E3047', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(34, 'others', 'Printing and Stationary', 'E3048', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(35, 'others', 'Allowance', 'E3049', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(36, 'others', 'Office Rent', 'E3050', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL),
(37, 'others', 'VAT on Office Rent Payable', 'L2057', 3, 12, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(38, 'others', 'Entertainment bill', 'E3052', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(39, 'others', 'Medical and Treatment', 'E3053', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(40, 'others', 'Electricity Bill', 'E3054', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(41, 'others', 'Wasa Bill', 'E3055', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(42, 'others', 'Electrical and Computer Accessories', 'E3056', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(43, 'others', 'Office Maintenance', 'E3057', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(44, 'others', 'Repair and Maintenance', 'E3058', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(45, 'others', 'Car & Vehicles Maintenace', 'E3059', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(46, 'others', 'Postage & Courier', 'E3060', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(47, 'others', 'Telephone & Mobile Bill', 'E3061', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(48, 'others', 'Tours & Travel Expense', 'E3062', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(49, 'others', 'Internet Bill', 'E3063', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(50, 'others', 'Audit Fee', 'E3064', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(51, 'others', 'Business Promotion Expenses', 'E3065', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(52, 'cash', 'Petty Cash', 'A1009', NULL, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 1, NULL, '2024-12-28 23:39:37', '2024-12-28 23:39:37'),
(53, 'bank', 'Global Islami Bank PLC', 'A1010', NULL, 4, 0, 'Global Islami Bank PLC', '110024047', 'Uttara Branch', NULL, NULL, NULL, NULL, 1, 0, 0, 0, 1, NULL, '2024-12-28 23:41:23', '2024-12-28 23:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_05_123040_create_general_settings_table', 1),
(5, '2024_11_25_123040_create_account_configurations_table', 1),
(6, '2024_11_25_123047_create_ledgers_table', 1),
(7, '2024_11_25_123048_create_sub_ledger_types_table', 1),
(8, '2024_11_25_123059_create_sub_ledgers_table', 1),
(9, '2024_11_25_123111_create_vouchers_table', 1),
(10, '2024_11_25_123136_create_transactions_table', 1),
(11, '2024_11_25_123336_create_fiscal_years_table', 1),
(12, '2024_11_25_123400_create_day_close_fiscal_years_table', 1),
(13, '2024_11_25_125021_create_work_orders_table', 1),
(14, '2024_11_25_125027_create_work_order_sites_table', 1),
(15, '2024_11_25_125029_create_work_order_estimation_costs_table', 1),
(16, '2024_12_10_145718_create_product_units_table', 1),
(17, '2024_12_10_145735_create_products_table', 1),
(18, '2024_12_11_085348_create_purchases_table', 1),
(19, '2024_12_11_085355_create_purchase_details_table', 1),
(20, '2024_12_11_085414_create_sales_table', 1),
(21, '2024_12_11_085420_create_sale_details_table', 1),
(22, '2024_12_11_092404_create_stocks_table', 1),
(23, '2024_12_24_094521_create_currencies_table', 1),
(24, '2024_12_25_050943_create_payments_table', 1),
(25, '2024_12_27_150109_create_quotations_table', 1),
(26, '2024_12_27_150118_create_quotation_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `morphable_type` varchar(255) DEFAULT NULL,
  `morphable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `ledger_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `check_no` varchar(200) DEFAULT NULL,
  `check_mature_date` date DEFAULT NULL,
  `is_approve` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => pending, 1 => Approve, 2 => Cancelled',
  `mac_address` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `date`, `morphable_type`, `morphable_id`, `amount`, `ledger_id`, `bank_name`, `bank_account_name`, `check_no`, `check_mature_date`, `is_approve`, `mac_address`, `ip`, `created_at`, `updated_at`) VALUES
(1, '2024-12-29', 'Modules\\Accounts\\App\\Models\\Purchase', 2, 76000, 52, NULL, NULL, NULL, '2024-12-29', 0, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', '2024-12-29 00:31:15', '2024-12-29 00:31:15'),
(2, '2024-12-29', 'Modules\\Accounts\\App\\Models\\Purchase', 3, 83600, 52, NULL, NULL, NULL, '2024-12-29', 0, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', '2024-12-29 00:33:12', '2024-12-29 00:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_ledger_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `selling_ledger_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `product_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(25) NOT NULL COMMENT 'Service / Product',
  `is_active` enum('Yes','No') NOT NULL,
  `for_selling` enum('Yes','No') NOT NULL,
  `for_purchase` enum('Yes','No') NOT NULL,
  `stock_manage` enum('Yes','No') NOT NULL,
  `selling_price` double NOT NULL DEFAULT 0,
  `selling_price_tax` double NOT NULL DEFAULT 0 COMMENT 'percentage',
  `purchase_price` double NOT NULL DEFAULT 0,
  `purchase_price_tax` double NOT NULL DEFAULT 0 COMMENT 'percentage',
  `image` varchar(300) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `purchase_ledger_id`, `selling_ledger_id`, `product_unit_id`, `name`, `type`, `is_active`, `for_selling`, `for_purchase`, `stock_manage`, `selling_price`, `selling_price_tax`, `purchase_price`, `purchase_price_tax`, `image`, `details`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 22, 27, 1, 'Half Inch Tap', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 180, 1, 120, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(2, 22, 27, 1, 'Hot Cold Normal RO Machine', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 1500, 0, 2200, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(3, 22, 27, 1, 'Adapter', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 500, 0, 1200, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(4, 22, 27, 1, 'Card Reader', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 500, 0, 800, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(5, 22, 27, 1, 'SSD 120GB', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 1800, 0, 2500, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(6, 22, 27, 1, 'SSD 256GB', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 2200, 0, 2900, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(7, 22, 27, 1, 'RAM 4GB Gaming', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 2500, 0, 4000, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21'),
(8, 22, 27, 1, 'Car Wash', 'Service', 'Yes', 'Yes', 'Yes', 'Yes', 3500, 0, 4000, 0, NULL, NULL, 1, NULL, '2024-12-28 23:49:21', '2024-12-28 23:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', '2024-12-28 23:47:09', '2024-12-28 23:47:09'),
(2, 'Inch', '2024-12-28 23:47:15', '2024-12-28 23:47:15'),
(3, 'Foot', '2024-12-28 23:47:21', '2024-12-28 23:47:21'),
(4, 'Ltr', '2024-12-28 23:47:26', '2024-12-28 23:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `sub_ledger_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'supplier_id',
  `invoice_no` varchar(100) DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL COMMENT 'supplier phone',
  `total_amount` double NOT NULL DEFAULT 0,
  `payable_amount` double NOT NULL DEFAULT 0,
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_percentage` double NOT NULL DEFAULT 0,
  `payment_method` enum('Cash','Bank','Due','Online') NOT NULL,
  `payment_status` enum('Paid','Partial','Due') NOT NULL,
  `note` text DEFAULT NULL,
  `terms_condition` text DEFAULT NULL,
  `credit_period` bigint(20) UNSIGNED NOT NULL COMMENT 'in days',
  `is_approved` enum('Pending','Approved','Rejected') NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `work_order_site_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `sub_ledger_id`, `invoice_no`, `ref_no`, `phone`, `total_amount`, `payable_amount`, `discount_amount`, `discount_percentage`, `payment_method`, `payment_status`, `note`, `terms_condition`, `credit_period`, `is_approved`, `work_order_id`, `work_order_site_id`, `approved_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2024-12-29', 4, 'P-90001', NULL, '01745112220', 376000, 376000, 0, 0, 'Cash', 'Due', NULL, 'Terms and Condition Free&nbsp;', 60, 'Pending', 0, 0, NULL, 1, NULL, '2024-12-29 00:30:16', '2024-12-29 00:30:16'),
(2, '2024-12-29', 4, 'P-90002', NULL, '01745112220', 376000, 376000, 0, 0, 'Cash', 'Partial', NULL, 'Terms and Condition Free&nbsp;', 60, 'Pending', 1, 1, NULL, 1, NULL, '2024-12-29 00:31:14', '2024-12-29 00:31:14'),
(3, '2024-12-29', 6, 'P-90003', NULL, '01745112221', 88000, 83600, 4400, 5, 'Cash', 'Paid', NULL, NULL, 0, 'Pending', 1, 3, NULL, 1, NULL, '2024-12-29 00:33:11', '2024-12-29 00:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `tax` double NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `discount` double NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `per_price` double NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_id`, `quantity`, `tax`, `discount`, `per_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, 0, 0, 120, 12000, '2024-12-29 00:30:16', '2024-12-29 00:30:16'),
(2, 1, 2, 70, 0, 0, 2200, 154000, '2024-12-29 00:30:16', '2024-12-29 00:30:16'),
(3, 1, 3, 50, 0, 0, 1200, 60000, '2024-12-29 00:30:16', '2024-12-29 00:30:16'),
(4, 1, 5, 60, 0, 0, 2500, 150000, '2024-12-29 00:30:16', '2024-12-29 00:30:16'),
(5, 2, 1, 100, 0, 0, 120, 12000, '2024-12-29 00:31:14', '2024-12-29 00:31:14'),
(6, 2, 2, 70, 0, 0, 2200, 154000, '2024-12-29 00:31:14', '2024-12-29 00:31:14'),
(7, 2, 3, 50, 0, 0, 1200, 60000, '2024-12-29 00:31:14', '2024-12-29 00:31:14'),
(8, 2, 5, 60, 0, 0, 2500, 150000, '2024-12-29 00:31:14', '2024-12-29 00:31:14'),
(9, 3, 2, 40, 0, 0, 2200, 88000, '2024-12-29 00:33:11', '2024-12-29 00:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `sub_ledger_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'supplier_id',
  `invoice_no` varchar(100) DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL COMMENT 'supplier phone',
  `total_amount` double NOT NULL DEFAULT 0,
  `payable_amount` double NOT NULL DEFAULT 0,
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_percentage` double NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `terms_condition` text DEFAULT NULL,
  `is_approved` enum('Pending','Approved','Rejected') NOT NULL,
  `is_convert_to_sale` enum('Pending','Converted','Rejected') NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `date`, `sub_ledger_id`, `invoice_no`, `ref_no`, `phone`, `total_amount`, `payable_amount`, `discount_amount`, `discount_percentage`, `note`, `terms_condition`, `is_approved`, `is_convert_to_sale`, `approved_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2024-12-29', 3, 'QTN#202400001', NULL, '01545112220', 4481.8, 4392.16, 89.636, 2, 'Thank you For being with us!', '<p>No Return acceptable after 1 year.</p>', 'Pending', 'Pending', NULL, 1, NULL, '2024-12-29 00:48:34', '2024-12-29 00:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `tax` double NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `discount` double NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `per_price` double NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`id`, `quotation_id`, `product_id`, `quantity`, `tax`, `discount`, `per_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 0, 180, 181.8, '2024-12-29 00:48:34', '2024-12-29 00:48:34'),
(2, 1, 2, 1, 0, 0, 1500, 1500, '2024-12-29 00:48:34', '2024-12-29 00:48:34'),
(3, 1, 3, 1, 0, 0, 500, 500, '2024-12-29 00:48:34', '2024-12-29 00:48:34'),
(4, 1, 4, 1, 0, 0, 500, 500, '2024-12-29 00:48:34', '2024-12-29 00:48:34'),
(5, 1, 5, 1, 0, 0, 1800, 1800, '2024-12-29 00:48:34', '2024-12-29 00:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `sub_ledger_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'supplier_id',
  `invoice_no` varchar(100) DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL COMMENT 'supplier phone',
  `total_amount` double NOT NULL DEFAULT 0,
  `payable_amount` double NOT NULL DEFAULT 0,
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_percentage` double NOT NULL DEFAULT 0,
  `payment_method` enum('Cash','Bank','Due','Online') NOT NULL,
  `payment_status` enum('Paid','Partial','Due') NOT NULL,
  `note` text DEFAULT NULL,
  `terms_condition` text DEFAULT NULL,
  `credit_period` bigint(20) UNSIGNED NOT NULL COMMENT 'in days',
  `is_approved` enum('Pending','Approved','Rejected') NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `work_order_site_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `sub_ledger_id`, `invoice_no`, `ref_no`, `phone`, `total_amount`, `payable_amount`, `discount_amount`, `discount_percentage`, `payment_method`, `payment_status`, `note`, `terms_condition`, `credit_period`, `is_approved`, `work_order_id`, `work_order_site_id`, `approved_by`, `created_by`, `updated_by`, `quotation_id`, `created_at`, `updated_at`) VALUES
(1, '2024-12-29', 3, 'S#1005', NULL, '01745112220', 3500, 3500, 0, 0, 'Cash', 'Due', NULL, '<p>No Return Acceptable</p>', 10, 'Pending', 0, 0, NULL, 1, NULL, 0, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(2, '2024-12-29', 2, 'S#1006', NULL, '01885112227', 3500, 3500, 0, 0, 'Cash', 'Due', NULL, '<p>No Return Acceptable</p>', 10, 'Pending', 0, 0, NULL, 1, NULL, 0, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(3, '2024-12-29', 3, 'S#1007', NULL, '01745112220', 3500, 3500, 0, 0, 'Cash', 'Due', NULL, '<p>No Return Acceptable</p>', 10, 'Pending', 0, 0, NULL, 1, NULL, 0, '2024-12-29 00:35:28', '2024-12-29 00:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `tax` double NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `discount` double NOT NULL DEFAULT 0 COMMENT 'in percentage',
  `per_price` double NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `product_id`, `quantity`, `tax`, `discount`, `per_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 0, 0, 500, 1000, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(2, 1, 4, 5, 0, 0, 500, 2500, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(3, 2, 3, 2, 0, 0, 500, 1000, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(4, 2, 4, 5, 0, 0, 500, 2500, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(5, 3, 3, 2, 0, 0, 500, 1000, '2024-12-29 00:35:28', '2024-12-29 00:35:28'),
(6, 3, 4, 5, 0, 0, 500, 2500, '2024-12-29 00:35:28', '2024-12-29 00:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LWGQh9x0R0MhtZfDfnJHWYjISvew5GBi1W8tiJeU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQWRuSmxmM0RYbUpYNVh3UnNMZm9oQ0FnVGZJck5wZ1NCVHV2NTYwVSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vMTI3LjAuMC4xOjgwODAvYWNjb3VudGluZ3Mvc2FsZXMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzU0NTA0MzY7fX0=', 1735455288);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `in` int(11) NOT NULL DEFAULT 0,
  `out` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_ledgers`
--

CREATE TABLE `sub_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_ledger_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `morphable_type` varchar(255) DEFAULT NULL,
  `morphable_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ledger_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(80) DEFAULT NULL COMMENT 'vendor / client / staff',
  `code` varchar(80) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL COMMENT 'Bank Name',
  `bank_ac_name` varchar(255) DEFAULT NULL COMMENT 'Bank Account',
  `ac_no` varchar(100) DEFAULT NULL COMMENT 'Bank Account',
  `routing_no` varchar(150) DEFAULT NULL COMMENT 'Bank',
  `swift_code` varchar(150) DEFAULT NULL COMMENT 'Bank',
  `branch_code` varchar(30) DEFAULT NULL COMMENT 'Bank',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `tin` varchar(255) DEFAULT NULL,
  `bin` varchar(255) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `trade_licence` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_ledgers`
--

INSERT INTO `sub_ledgers` (`id`, `sub_ledger_type_id`, `morphable_type`, `morphable_id`, `ledger_id`, `type`, `code`, `name`, `email`, `bank_name`, `bank_ac_name`, `ac_no`, `routing_no`, `swift_code`, `branch_code`, `is_active`, `tin`, `bin`, `nid`, `trade_licence`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 0, 6, 'Client', 'C202421750', 'Mr Client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:42:40', '2024-12-28 23:42:40'),
(2, 5, NULL, 0, 6, 'Client', 'C202421751', 'Mr Grameen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:43:39', '2024-12-28 23:43:39'),
(3, 5, NULL, 0, 6, 'Client', 'C202421752', 'Ms Sharmin Client', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:44:02', '2024-12-28 23:44:02'),
(4, 3, NULL, 0, 15, 'Vendor', 'V202421750', 'Ryans Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:44:34', '2024-12-28 23:44:34'),
(5, 3, NULL, 0, 15, 'Vendor', 'V202421751', 'BD Stall', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:45:02', '2024-12-28 23:45:02'),
(6, 1, NULL, 0, 15, 'Vendor', 'V202421753', 'Trade X BD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:45:27', '2024-12-28 23:45:27'),
(7, 0, NULL, 0, 23, 'Staff', 'MR-101', 'Mijanur Rahman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:46:32', '2024-12-28 23:46:32'),
(8, 0, NULL, 0, 23, 'Staff', 'IH-102', 'Md Imran Hosen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2024-12-28 23:46:54', '2024-12-28 23:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `sub_ledger_types`
--

CREATE TABLE `sub_ledger_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_for` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>staff / 1=>vendor / 2=>client',
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_ledger_types`
--

INSERT INTO `sub_ledger_types` (`id`, `is_for`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Logistics & Supply-Payable', NULL, NULL),
(2, 1, 'Civil Vendors & Suppliers (Payable)', NULL, NULL),
(3, 1, 'Corporate Vendors (Payable)', NULL, NULL),
(4, 2, 'Premium Customer', NULL, NULL),
(5, 2, 'Golden Client', '2024-12-28 23:42:56', '2024-12-28 23:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `voucher_id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `work_order_site_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ledger_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sub_ledger_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(20) DEFAULT NULL COMMENT 'dr / cr',
  `credit_period` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'in days',
  `amount` double NOT NULL DEFAULT 0,
  `narration` text DEFAULT NULL,
  `is_opening` tinyint(1) NOT NULL DEFAULT 0,
  `is_approve` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => pending, 1 => Approve, 2 => Cancelled',
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `check_no` varchar(200) DEFAULT NULL,
  `check_mature_date` date DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mr Admin', 'admin', 'admin@example.com', NULL, '$2y$12$7pqGXAoRTm1/mPI15gTRwesD0ZAEwYwUa2JfxhSBSsUoP8M6L.T4G', NULL, '2024-12-28 21:58:04', '2024-12-28 21:58:04'),
(2, 'Mr Naim', 'naim56', 'naim@example.com', NULL, '$2y$12$Pu1gaYjL2MlTNOSYnx1Ci.X.6SZzhkzc8QtIPfGVbxnCrE4vb3ACC', NULL, '2024-12-28 21:58:04', '2024-12-28 21:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `panel` varchar(50) DEFAULT NULL,
  `f_year` int(11) DEFAULT NULL COMMENT 'get understand the financial year',
  `txn_id` int(11) DEFAULT NULL,
  `referable_type` varchar(255) DEFAULT NULL,
  `referable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'pay_cash / pay_bank / rcv_cash / rcv_bank / misc / contra / cash / bank / payable / receivable / purchase / sales',
  `amount` double NOT NULL DEFAULT 0,
  `ref_no` varchar(150) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `rejection_comment` text DEFAULT NULL,
  `is_approve` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => pending, 1 => Approve, 2 => Cancelled',
  `is_transfer` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'money transfer from here to there',
  `is_invoiced` tinyint(1) NOT NULL DEFAULT 0,
  `is_advanced` tinyint(1) NOT NULL DEFAULT 0,
  `is_opening` tinyint(1) NOT NULL DEFAULT 0,
  `is_manual_entry` tinyint(1) NOT NULL DEFAULT 0,
  `is_work_order_based` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'general journal / work order journal',
  `pay_or_rcv_type` varchar(100) DEFAULT NULL COMMENT 'online transaction / cash / check',
  `concern_person` varchar(255) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_orders`
--

CREATE TABLE `work_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-29',
  `final_date` date NOT NULL DEFAULT '2024-12-29',
  `sub_ledger_id` bigint(20) UNSIGNED NOT NULL COMMENT 'client id',
  `awarded_by` varchar(255) DEFAULT NULL COMMENT 'the man who brought the project',
  `order_name` varchar(255) DEFAULT NULL,
  `order_no` varchar(150) DEFAULT NULL,
  `order_value` double NOT NULL DEFAULT 0 COMMENT 'project value',
  `remarks` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_orders`
--

INSERT INTO `work_orders` (`id`, `date`, `final_date`, `sub_ledger_id`, `awarded_by`, `order_name`, `order_no`, `order_value`, `remarks`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2024-12-17', '2025-03-31', 2, 'Monir Jaman', 'LPD Dummy', 'LDP10001.320', 975000, 'Remarks Special', 1, 1, NULL, '2024-12-29 00:02:43', '2024-12-29 00:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_estimation_costs`
--

CREATE TABLE `work_order_estimation_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ledger_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `estimated_amount` double NOT NULL DEFAULT 0,
  `actual_cost` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_estimation_costs`
--

INSERT INTO `work_order_estimation_costs` (`id`, `work_order_id`, `ledger_id`, `estimated_amount`, `actual_cost`, `created_at`, `updated_at`) VALUES
(1, 1, 22, 300000, 0, '2024-12-29 00:02:43', '2024-12-29 00:02:43'),
(2, 1, 33, 50000, 0, '2024-12-29 00:02:43', '2024-12-29 00:02:43'),
(3, 1, 35, 75000, 0, '2024-12-29 00:02:43', '2024-12-29 00:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_sites`
--

CREATE TABLE `work_order_sites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `site_name` varchar(255) DEFAULT NULL,
  `site_location` varchar(255) DEFAULT NULL,
  `est_budget` double NOT NULL DEFAULT 0,
  `site_pm_name` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_sites`
--

INSERT INTO `work_order_sites` (`id`, `work_order_id`, `site_name`, `site_location`, `est_budget`, `site_pm_name`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'Uttara Site', 'Sector-7, Road-32A', 0, 'Kamal Hossen', NULL, '2024-12-29 00:07:42', '2024-12-29 00:07:42'),
(2, 1, 'Uttara Site', 'Sector-1, Road-7B', 0, 'Kamal Hossen', NULL, '2024-12-29 00:07:42', '2024-12-29 00:07:42'),
(3, 1, 'Nikunjo Site', 'Kazipara road, XYZ Building', 0, 'Monir Hosain', NULL, '2024-12-29 00:07:42', '2024-12-29 00:07:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_configurations`
--
ALTER TABLE `account_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `day_close_fiscal_years`
--
ALTER TABLE `day_close_fiscal_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_close_fiscal_years_fiscal_year_id_foreign` (`fiscal_year_id`),
  ADD KEY `day_close_fiscal_years_closed_by_foreign` (`closed_by`),
  ADD KEY `day_close_fiscal_years_from_date_index` (`from_date`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fiscal_years_closed_by_foreign` (`closed_by`),
  ADD KEY `fiscal_years_from_date_index` (`from_date`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ledgers_code_unique` (`code`),
  ADD KEY `ledgers_name_index` (`name`),
  ADD KEY `ledgers_bank_ac_name_index` (`bank_ac_name`),
  ADD KEY `ledgers_ac_no_index` (`ac_no`),
  ADD KEY `ledgers_bank_address_index` (`bank_address`),
  ADD KEY `ledgers_routing_no_index` (`routing_no`),
  ADD KEY `ledgers_swift_code_index` (`swift_code`),
  ADD KEY `ledgers_branch_code_index` (`branch_code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_date_index` (`date`),
  ADD KEY `payments_amount_index` (`amount`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_selling_price_index` (`selling_price`),
  ADD KEY `products_purchase_price_index` (`purchase_price`);

--
-- Indexes for table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_date_index` (`date`),
  ADD KEY `purchases_invoice_no_index` (`invoice_no`),
  ADD KEY `purchases_total_amount_index` (`total_amount`),
  ADD KEY `purchases_payable_amount_index` (`payable_amount`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_date_index` (`date`),
  ADD KEY `quotations_invoice_no_index` (`invoice_no`),
  ADD KEY `quotations_total_amount_index` (`total_amount`),
  ADD KEY `quotations_payable_amount_index` (`payable_amount`);

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_date_index` (`date`),
  ADD KEY `sales_invoice_no_index` (`invoice_no`),
  ADD KEY `sales_total_amount_index` (`total_amount`),
  ADD KEY `sales_payable_amount_index` (`payable_amount`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_date_index` (`date`);

--
-- Indexes for table `sub_ledgers`
--
ALTER TABLE `sub_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_ledgers_code_index` (`code`),
  ADD KEY `sub_ledgers_name_index` (`name`),
  ADD KEY `sub_ledgers_email_index` (`email`),
  ADD KEY `sub_ledgers_bank_name_index` (`bank_name`),
  ADD KEY `sub_ledgers_bank_ac_name_index` (`bank_ac_name`),
  ADD KEY `sub_ledgers_ac_no_index` (`ac_no`),
  ADD KEY `sub_ledgers_routing_no_index` (`routing_no`),
  ADD KEY `sub_ledgers_swift_code_index` (`swift_code`),
  ADD KEY `sub_ledgers_branch_code_index` (`branch_code`);

--
-- Indexes for table `sub_ledger_types`
--
ALTER TABLE `sub_ledger_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_ledger_types_name_index` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_date_index` (`date`),
  ADD KEY `transactions_amount_index` (`amount`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vouchers_date_index` (`date`),
  ADD KEY `vouchers_txn_id_index` (`txn_id`),
  ADD KEY `vouchers_amount_index` (`amount`);

--
-- Indexes for table `work_orders`
--
ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_orders_date_index` (`date`),
  ADD KEY `work_orders_final_date_index` (`final_date`),
  ADD KEY `work_orders_awarded_by_index` (`awarded_by`),
  ADD KEY `work_orders_order_name_index` (`order_name`),
  ADD KEY `work_orders_order_no_index` (`order_no`),
  ADD KEY `work_orders_order_value_index` (`order_value`);

--
-- Indexes for table `work_order_estimation_costs`
--
ALTER TABLE `work_order_estimation_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_order_sites`
--
ALTER TABLE `work_order_sites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_sites_site_name_index` (`site_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_configurations`
--
ALTER TABLE `account_configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `day_close_fiscal_years`
--
ALTER TABLE `day_close_fiscal_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_ledgers`
--
ALTER TABLE `sub_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_ledger_types`
--
ALTER TABLE `sub_ledger_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_order_estimation_costs`
--
ALTER TABLE `work_order_estimation_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_order_sites`
--
ALTER TABLE `work_order_sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `day_close_fiscal_years`
--
ALTER TABLE `day_close_fiscal_years`
  ADD CONSTRAINT `day_close_fiscal_years_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `day_close_fiscal_years_fiscal_year_id_foreign` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  ADD CONSTRAINT `fiscal_years_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
