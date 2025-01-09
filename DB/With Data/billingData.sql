-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 11:56 AM
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
-- Database: `billing`
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('ebe2241aad627c8eab70ac5ce4c063b8', 's:2898:\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAIH0lEQVR4nO2d22sUVxzHvzOzk91s9pZkN5fiDVpbSqiF0mpRkVZFRCQNRUII/gN96VOl4L/gS6HQp763lBAkSJCgJUgJVqG1F2mxai9Ka5LNZe/rJrvTh2TXzew5cz1ndpKcz1OSmcyc/X3P73IuMytpmgaBfwi0uwF2kW7et92DtFNDEo+28EDys4c4Mb5V/CqSrwThKYAZfhHIF4K0Uwg97RambYL4SQQa7RDHc0G2gxB6vBRG9upGwPYUA/C23Z54yHYVggRvb+EqyE4SQg8vYbgIspOF0MNaGE9ziMAcph6ymzxDDytPYeYhu1kMgN3nZyLIbhejDgs7uBZEiLEVt/ZwJYgQg4wbuzgWRIhhjFP7OBJEiGENJ3ayLYgQwx527SUGhj7D8sBQeIZ7rAwehYf4DEuCCO9ggxU7Cg/xGaaCCO9gi5k9hYf4DENBhHfwwciuVEGEGHyh2VeELJ9BFER4hzeQ7Cw8xGcIQXxGy1yW1XD1xWuD+GhPj+l5Xz3LYPz+U2et2+STfb24cnDA9Ly72RIO333s6l6/HnkZQ5GQ4TmfP1nCxw+eubpPM81zXNw95GxvBAGX+zEu9MXYNMaEQ5GgqRgAMNYf52a4Ldflkcy7VQXvJboc//+eYABH4mGGLaIz3p+wdF6qI4AzPRFm9222uyc5ZDgVdfy/XnkHAIwNWL/XxcE4lzZ4IshIyrlRL/Tx+eB6TiTC2B/qsHz+cDKKsMx+e68nguwNqXgrah6b9bzUEcC78U4OLWplfIAs/GJlHVXCIl40oLjyfBoNQXgPBoeT9hv/YV8MisT/WZmARA+NU+kc7uXKxGMXB6zlHCvU7c/cQ/4sVYh/dxK2SEZaq2n47/ma7WsZcbY3gl6V/IT4tXQO00t54rEzPRH0BBSmbWEuyK3VItFgb0ZDOBBSLV+nT1VwPNFaXc2uFvD0+bqrNuqhVVelag0zS3lMLmSJx1VZwmg/26KDuSARRca1NLlH2Ym5tHA1MZ9lmkzDskRt17crBRRrGu7ly1TPZxm2AE6CXF0k9yg7YYsWriYXs4gE2DV7JBVDl0K+3tRirvEzzUuOJcK2PN8MGWCb0GMBGTeWCyhUay3HjsfDSFgwZlJVcIIwmLy1WkB6rYqwzE4Q2niiqmmYSjcJQulkAL1Cs4t0877GxUMqmoYZQiJUZQnnLVRbI6koVEJYmtjspWFKj7ZLUlVwups84r6dKeFZ5UWumsuUqMXEeD+7sRJzQerGau5dzVgpf0mDwaqmNcIGLcTYZbQvRhQeADHsTi6SP9NQJIRDkSCTNnHxEGCjXCQNqM72RtBhMLZIBGSc7G4NV9+tFrGwVkWIYUIfN0jIVwnGp+URgF1yZ+8hmwZLr1Uxlym2HI8GFJzuoU82jqTIvfab+QwAMBNkX1DFMUJZDQC/5Mt4SKiqZlcKWKyQS+4xRmGLuSChpoQ7RXFxo/KXVF1VNa0RLoy8yw5GiZjmCTXQQ/HekIoTFIHtwFwQVZYaFyW5PUDPIzFFJnrPXKbYSLCyF4IYVFS8wxaXycXAptEelir4rfC85fhgUMXhWOuk4XAqiiChpJ1oMgKLBh+KBPEGZSHqUamCn/Otba4zs5xHZr1KPHahL+bag7nP9tLC1gghbNHC1cQ8vVc6wWghysgDAGBd2yhYSHSrCs4l3S1ccX/n4lQ6i08PJFv+PpKK4fKjhcbvEUUmrsLdyZbwLyWROsVoIerS/iQu7W9tr1XG++PUUG0F7h4ylylhnmDQ17uCeKXzxYLQ+WQEnYTxRb26YsXxuL2FKLucT0Ybpb8TPFmgorl4c9iirQxOLjjvbSRYTXPQ6FRkV8vOnghiVv6GZQlne1vD1feZIv5huPZhtBDFEjeiywD/l3LNLOeJk41H42EkVQXnklHidMiESYK1y5meCFId/F9VfLK7CwMO7qOdGpI88ZByTcON5dbJRkWSMJyMUnsta0FYr13QUCQJYw4Xrjx7s/XUYg4fENZDLg4m8DZhA8TdbAl/ldmFK6OFKAC48nfadge4fCBJ/EzAxjzZZ0+WbV0P8FCQ+mSjfhXwfcJEIgBMLLCtrowWogDgy39X8KBIXhWk8fV8hirIO7FOvBrusH1NzzZbL6xVcSdbsnw+88GgQaJ9VKrYNhwAXF/KE2e0G/d0MOHYEMSLd9PSlnb1/Jgr4THDcNUTUAy3fk5TynIzVtdruJ2hdzI71Vbd/p4+jkArf/WwTuaj/fSFKACYpmzKsML0Ev0zHQwHiXN2RngqyO/FCv4o0ifu6rAWxKinFqo1zK4WHF/7OmXPVuPeNsOW5w/smHnJT7myo3hOY19QxVGD3fOzKwWUa873ePyQKxtu3Bvtj9ky8pZzvckjxoKwrq7GB+KG21Gd5o9mjLxkMKgarpACHj+wo2cuU6QugwLehisA1G2idjC7htHavR7i65nEU7jeoY9K4qFPnyEE8RlEQdr9tT+7BZKdhYf4DKogwkv4QrOvoYcIUfhgZFcRsnyGqSDCS9hiZk/hIT7DkiDCS9ggXqS8DbH9HVRinss+diKM8BCfYVsQkU/sYddejjxEiGINJ3ZyHLKEKMY4tY+rHCJEIePGLq6TuhBlK27twaTKEqJswMIOzMre3S4Kq88vvr7bJeLru3c4XDykcfEd7Cm8QjRXQRo32UHC8M6VngjSuNk2FsarosXTHLJdKzEv2+2ph2y58TbwlnZ0oLYJsqURPhKn3V7sC0HqtFOYdgtRx1eC6OEpkF8E0ONrQUg4EcmvxifxPyMXDiGga38BAAAAAElFTkSuQmCC\";', 2051764330),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:10:\"sub_module\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:5:\"label\";s:1:\"e\";s:10:\"guard_name\";}s:11:\"permissions\";a:115:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:7:\"product\";s:1:\"c\";s:12:\"view_product\";s:1:\"d\";s:12:\"view product\";s:1:\"e\";s:3:\"web\";}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"product\";s:1:\"c\";s:12:\"edit_product\";s:1:\"d\";s:12:\"edit product\";s:1:\"e\";s:3:\"web\";}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"product\";s:1:\"c\";s:14:\"delete_product\";s:1:\"d\";s:14:\"delete product\";s:1:\"e\";s:3:\"web\";}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"product\";s:1:\"c\";s:14:\"create_product\";s:1:\"d\";s:14:\"create product\";s:1:\"e\";s:3:\"web\";}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"product unit\";s:1:\"c\";s:17:\"view_product_unit\";s:1:\"d\";s:17:\"view product unit\";s:1:\"e\";s:3:\"web\";}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"product unit\";s:1:\"c\";s:17:\"edit_product_unit\";s:1:\"d\";s:17:\"edit product unit\";s:1:\"e\";s:3:\"web\";}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"product unit\";s:1:\"c\";s:19:\"delete_product_unit\";s:1:\"d\";s:19:\"delete product unit\";s:1:\"e\";s:3:\"web\";}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"product unit\";s:1:\"c\";s:19:\"create_product_unit\";s:1:\"d\";s:19:\"create product unit\";s:1:\"e\";s:3:\"web\";}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:9:\"quotation\";s:1:\"c\";s:14:\"view_quotation\";s:1:\"d\";s:14:\"view quotation\";s:1:\"e\";s:3:\"web\";}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:9:\"quotation\";s:1:\"c\";s:14:\"edit_quotation\";s:1:\"d\";s:14:\"edit quotation\";s:1:\"e\";s:3:\"web\";}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"quotation\";s:1:\"c\";s:16:\"delete_quotation\";s:1:\"d\";s:16:\"delete quotation\";s:1:\"e\";s:3:\"web\";}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:9:\"quotation\";s:1:\"c\";s:16:\"create_quotation\";s:1:\"d\";s:16:\"create quotation\";s:1:\"e\";s:3:\"web\";}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:9:\"quotation\";s:1:\"c\";s:17:\"approve_quotation\";s:1:\"d\";s:17:\"approve quotation\";s:1:\"e\";s:3:\"web\";}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:5:\"sales\";s:1:\"c\";s:10:\"view_sales\";s:1:\"d\";s:10:\"view sales\";s:1:\"e\";s:3:\"web\";}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:5:\"sales\";s:1:\"c\";s:10:\"edit_sales\";s:1:\"d\";s:10:\"edit sales\";s:1:\"e\";s:3:\"web\";}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:5:\"sales\";s:1:\"c\";s:12:\"delete_sales\";s:1:\"d\";s:12:\"delete sales\";s:1:\"e\";s:3:\"web\";}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:5:\"sales\";s:1:\"c\";s:12:\"create_sales\";s:1:\"d\";s:12:\"create sales\";s:1:\"e\";s:3:\"web\";}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:5:\"sales\";s:1:\"c\";s:13:\"approve_sales\";s:1:\"d\";s:13:\"approve sales\";s:1:\"e\";s:3:\"web\";}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:8:\"purcahse\";s:1:\"c\";s:13:\"view_purcahse\";s:1:\"d\";s:13:\"view purcahse\";s:1:\"e\";s:3:\"web\";}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:8:\"purcahse\";s:1:\"c\";s:13:\"edit_purcahse\";s:1:\"d\";s:13:\"edit purcahse\";s:1:\"e\";s:3:\"web\";}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:8:\"purcahse\";s:1:\"c\";s:15:\"delete_purcahse\";s:1:\"d\";s:15:\"delete purcahse\";s:1:\"e\";s:3:\"web\";}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:8:\"purcahse\";s:1:\"c\";s:15:\"create_purcahse\";s:1:\"d\";s:15:\"create purcahse\";s:1:\"e\";s:3:\"web\";}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:8:\"purcahse\";s:1:\"c\";s:16:\"approve_purcahse\";s:1:\"d\";s:16:\"approve purcahse\";s:1:\"e\";s:3:\"web\";}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:6:\"ledger\";s:1:\"c\";s:11:\"view_ledger\";s:1:\"d\";s:11:\"view ledger\";s:1:\"e\";s:3:\"web\";}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:6:\"ledger\";s:1:\"c\";s:11:\"edit_ledger\";s:1:\"d\";s:11:\"edit ledger\";s:1:\"e\";s:3:\"web\";}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:6:\"ledger\";s:1:\"c\";s:13:\"delete_ledger\";s:1:\"d\";s:13:\"delete ledger\";s:1:\"e\";s:3:\"web\";}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:6:\"ledger\";s:1:\"c\";s:13:\"create_ledger\";s:1:\"d\";s:13:\"create ledger\";s:1:\"e\";s:3:\"web\";}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:10:\"party type\";s:1:\"c\";s:15:\"view_party_type\";s:1:\"d\";s:15:\"view party type\";s:1:\"e\";s:3:\"web\";}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:10:\"party type\";s:1:\"c\";s:15:\"edit_party_type\";s:1:\"d\";s:15:\"edit party type\";s:1:\"e\";s:3:\"web\";}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"party type\";s:1:\"c\";s:17:\"delete_party_type\";s:1:\"d\";s:17:\"delete party type\";s:1:\"e\";s:3:\"web\";}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:10:\"party type\";s:1:\"c\";s:17:\"create_party_type\";s:1:\"d\";s:17:\"create party type\";s:1:\"e\";s:3:\"web\";}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:5:\"party\";s:1:\"c\";s:10:\"view_party\";s:1:\"d\";s:10:\"view party\";s:1:\"e\";s:3:\"web\";}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:5:\"party\";s:1:\"c\";s:10:\"edit_party\";s:1:\"d\";s:10:\"edit party\";s:1:\"e\";s:3:\"web\";}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:5:\"party\";s:1:\"c\";s:12:\"delete_party\";s:1:\"d\";s:12:\"delete party\";s:1:\"e\";s:3:\"web\";}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:5:\"party\";s:1:\"c\";s:12:\"create_party\";s:1:\"d\";s:12:\"create party\";s:1:\"e\";s:3:\"web\";}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:10:\"work order\";s:1:\"c\";s:15:\"view_work_order\";s:1:\"d\";s:15:\"view work order\";s:1:\"e\";s:3:\"web\";}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:10:\"work order\";s:1:\"c\";s:15:\"edit_work_order\";s:1:\"d\";s:15:\"edit work order\";s:1:\"e\";s:3:\"web\";}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:10:\"work order\";s:1:\"c\";s:17:\"delete_work_order\";s:1:\"d\";s:17:\"delete work order\";s:1:\"e\";s:3:\"web\";}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:10:\"work order\";s:1:\"c\";s:17:\"create_work_order\";s:1:\"d\";s:17:\"create work order\";s:1:\"e\";s:3:\"web\";}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"work order sites\";s:1:\"c\";s:20:\"view_work_order_site\";s:1:\"d\";s:21:\"view work order sites\";s:1:\"e\";s:3:\"web\";}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:16:\"work order sites\";s:1:\"c\";s:20:\"edit_work_order_site\";s:1:\"d\";s:21:\"edit work order sites\";s:1:\"e\";s:3:\"web\";}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:16:\"work order sites\";s:1:\"c\";s:22:\"delete_work_order_site\";s:1:\"d\";s:23:\"delete work order sites\";s:1:\"e\";s:3:\"web\";}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:16:\"work order sites\";s:1:\"c\";s:22:\"create_work_order_site\";s:1:\"d\";s:23:\"create work order sites\";s:1:\"e\";s:3:\"web\";}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:12:\"cash payment\";s:1:\"c\";s:17:\"view_cash_payment\";s:1:\"d\";s:17:\"view cash payment\";s:1:\"e\";s:3:\"web\";}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:12:\"cash payment\";s:1:\"c\";s:17:\"edit_cash_payment\";s:1:\"d\";s:17:\"edit cash payment\";s:1:\"e\";s:3:\"web\";}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:12:\"cash payment\";s:1:\"c\";s:19:\"delete_cash_payment\";s:1:\"d\";s:19:\"delete cash payment\";s:1:\"e\";s:3:\"web\";}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"cash payment\";s:1:\"c\";s:19:\"create_cash_payment\";s:1:\"d\";s:19:\"create cash payment\";s:1:\"e\";s:3:\"web\";}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"bank payment\";s:1:\"c\";s:17:\"view_bank_payment\";s:1:\"d\";s:17:\"view bank payment\";s:1:\"e\";s:3:\"web\";}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:12:\"bank payment\";s:1:\"c\";s:17:\"edit_bank_payment\";s:1:\"d\";s:17:\"edit bank payment\";s:1:\"e\";s:3:\"web\";}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:12:\"bank payment\";s:1:\"c\";s:19:\"delete_bank_payment\";s:1:\"d\";s:19:\"delete bank payment\";s:1:\"e\";s:3:\"web\";}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:12:\"bank payment\";s:1:\"c\";s:19:\"create_bank_payment\";s:1:\"d\";s:19:\"create bank payment\";s:1:\"e\";s:3:\"web\";}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:12:\"cash recieve\";s:1:\"c\";s:17:\"view_cash_recieve\";s:1:\"d\";s:17:\"view cash recieve\";s:1:\"e\";s:3:\"web\";}i:52;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:12:\"cash recieve\";s:1:\"c\";s:17:\"edit_cash_recieve\";s:1:\"d\";s:17:\"edit cash recieve\";s:1:\"e\";s:3:\"web\";}i:53;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:12:\"cash recieve\";s:1:\"c\";s:19:\"delete_cash_recieve\";s:1:\"d\";s:19:\"delete cash recieve\";s:1:\"e\";s:3:\"web\";}i:54;a:5:{s:1:\"a\";i:55;s:1:\"b\";s:12:\"cash recieve\";s:1:\"c\";s:19:\"create_cash_recieve\";s:1:\"d\";s:19:\"create cash recieve\";s:1:\"e\";s:3:\"web\";}i:55;a:5:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"bank recieve\";s:1:\"c\";s:17:\"view_bank_recieve\";s:1:\"d\";s:17:\"view bank recieve\";s:1:\"e\";s:3:\"web\";}i:56;a:5:{s:1:\"a\";i:57;s:1:\"b\";s:12:\"bank recieve\";s:1:\"c\";s:17:\"edit_bank_recieve\";s:1:\"d\";s:17:\"edit bank recieve\";s:1:\"e\";s:3:\"web\";}i:57;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:12:\"bank recieve\";s:1:\"c\";s:19:\"delete_bank_recieve\";s:1:\"d\";s:19:\"delete bank recieve\";s:1:\"e\";s:3:\"web\";}i:58;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:12:\"bank recieve\";s:1:\"c\";s:19:\"create_bank_recieve\";s:1:\"d\";s:19:\"create bank recieve\";s:1:\"e\";s:3:\"web\";}i:59;a:5:{s:1:\"a\";i:60;s:1:\"b\";s:7:\"journal\";s:1:\"c\";s:12:\"view_journal\";s:1:\"d\";s:12:\"view journal\";s:1:\"e\";s:3:\"web\";}i:60;a:5:{s:1:\"a\";i:61;s:1:\"b\";s:7:\"journal\";s:1:\"c\";s:12:\"edit_journal\";s:1:\"d\";s:12:\"edit journal\";s:1:\"e\";s:3:\"web\";}i:61;a:5:{s:1:\"a\";i:62;s:1:\"b\";s:7:\"journal\";s:1:\"c\";s:14:\"delete_journal\";s:1:\"d\";s:14:\"delete journal\";s:1:\"e\";s:3:\"web\";}i:62;a:5:{s:1:\"a\";i:63;s:1:\"b\";s:7:\"journal\";s:1:\"c\";s:14:\"create_journal\";s:1:\"d\";s:14:\"create journal\";s:1:\"e\";s:3:\"web\";}i:63;a:5:{s:1:\"a\";i:64;s:1:\"b\";s:18:\"work order journal\";s:1:\"c\";s:23:\"view_work_order_journal\";s:1:\"d\";s:23:\"view work order journal\";s:1:\"e\";s:3:\"web\";}i:64;a:5:{s:1:\"a\";i:65;s:1:\"b\";s:18:\"work order journal\";s:1:\"c\";s:23:\"edit_work_order_journal\";s:1:\"d\";s:23:\"edit work order journal\";s:1:\"e\";s:3:\"web\";}i:65;a:5:{s:1:\"a\";i:66;s:1:\"b\";s:18:\"work order journal\";s:1:\"c\";s:25:\"delete_work_order_journal\";s:1:\"d\";s:25:\"delete work order journal\";s:1:\"e\";s:3:\"web\";}i:66;a:5:{s:1:\"a\";i:67;s:1:\"b\";s:18:\"work order journal\";s:1:\"c\";s:25:\"create_work_order_journal\";s:1:\"d\";s:25:\"create work order journal\";s:1:\"e\";s:3:\"web\";}i:67;a:5:{s:1:\"a\";i:68;s:1:\"b\";s:15:\"opening balance\";s:1:\"c\";s:20:\"view_opening_balance\";s:1:\"d\";s:20:\"view opening balance\";s:1:\"e\";s:3:\"web\";}i:68;a:5:{s:1:\"a\";i:69;s:1:\"b\";s:15:\"opening balance\";s:1:\"c\";s:20:\"edit_opening_balance\";s:1:\"d\";s:20:\"edit opening balance\";s:1:\"e\";s:3:\"web\";}i:69;a:5:{s:1:\"a\";i:70;s:1:\"b\";s:15:\"opening balance\";s:1:\"c\";s:22:\"delete_opening_balance\";s:1:\"d\";s:22:\"delete opening balance\";s:1:\"e\";s:3:\"web\";}i:70;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:15:\"opening balance\";s:1:\"c\";s:22:\"create_opening_balance\";s:1:\"d\";s:22:\"create opening balance\";s:1:\"e\";s:3:\"web\";}i:71;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:16:\"voucher approval\";s:1:\"c\";s:20:\"view_pending_vocuher\";s:1:\"d\";s:20:\"view pending voucher\";s:1:\"e\";s:3:\"web\";}i:72;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:16:\"voucher approval\";s:1:\"c\";s:21:\"view_rejected_vocuher\";s:1:\"d\";s:22:\"view rejected voucher \";s:1:\"e\";s:3:\"web\";}i:73;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:16:\"voucher approval\";s:1:\"c\";s:16:\"approval_vocuher\";s:1:\"d\";s:16:\"approve voucher \";s:1:\"e\";s:3:\"web\";}i:74;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:15:\"cashbook_report\";s:1:\"d\";s:15:\"cashbook report\";s:1:\"e\";s:3:\"web\";}i:75;a:5:{s:1:\"a\";i:76;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:15:\"bankbook_report\";s:1:\"d\";s:15:\"bankbook report\";s:1:\"e\";s:3:\"web\";}i:76;a:5:{s:1:\"a\";i:77;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:13:\"ledger_report\";s:1:\"d\";s:13:\"ledger report\";s:1:\"e\";s:3:\"web\";}i:77;a:5:{s:1:\"a\";i:78;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:12:\"party_report\";s:1:\"d\";s:12:\"party report\";s:1:\"e\";s:3:\"web\";}i:78;a:5:{s:1:\"a\";i:79;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:20:\"party_summary_report\";s:1:\"d\";s:20:\"party summary report\";s:1:\"e\";s:3:\"web\";}i:79;a:5:{s:1:\"a\";i:80;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:17:\"work_order_report\";s:1:\"d\";s:17:\"work order report\";s:1:\"e\";s:3:\"web\";}i:80;a:5:{s:1:\"a\";i:81;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:25:\"work_order_summary_report\";s:1:\"d\";s:25:\"work order summary report\";s:1:\"e\";s:3:\"web\";}i:81;a:5:{s:1:\"a\";i:82;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:20:\"work_order_pl_report\";s:1:\"d\";s:29:\"work order Profit Loss report\";s:1:\"e\";s:3:\"web\";}i:82;a:5:{s:1:\"a\";i:83;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:33:\"work_order_asset_liability_report\";s:1:\"d\";s:33:\"work order Asset Liability report\";s:1:\"e\";s:3:\"web\";}i:83;a:5:{s:1:\"a\";i:84;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:33:\"work_order_reciept_payemnt_report\";s:1:\"d\";s:33:\"work order reciept payment report\";s:1:\"e\";s:3:\"web\";}i:84;a:5:{s:1:\"a\";i:85;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:22:\"reciept_payemnt_report\";s:1:\"d\";s:22:\"reciept payment report\";s:1:\"e\";s:3:\"web\";}i:85;a:5:{s:1:\"a\";i:86;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:19:\"balancesheet_report\";s:1:\"d\";s:19:\"balancesheet report\";s:1:\"e\";s:3:\"web\";}i:86;a:5:{s:1:\"a\";i:87;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:23:\"income_statement_report\";s:1:\"d\";s:23:\"income statement report\";s:1:\"e\";s:3:\"web\";}i:87;a:5:{s:1:\"a\";i:88;s:1:\"b\";s:17:\"Accounting Report\";s:1:\"c\";s:12:\"trial_report\";s:1:\"d\";s:12:\"trial report\";s:1:\"e\";s:3:\"web\";}i:88;a:5:{s:1:\"a\";i:89;s:1:\"b\";s:24:\"accounting configuration\";s:1:\"c\";s:24:\"accounting_report_config\";s:1:\"d\";s:24:\"accounting report config\";s:1:\"e\";s:3:\"web\";}i:89;a:5:{s:1:\"a\";i:90;s:1:\"b\";s:24:\"accounting configuration\";s:1:\"c\";s:11:\"day_closing\";s:1:\"d\";s:11:\"day closing\";s:1:\"e\";s:3:\"web\";}i:90;a:5:{s:1:\"a\";i:91;s:1:\"b\";s:5:\"Staff\";s:1:\"c\";s:10:\"view_users\";s:1:\"d\";s:10:\"view staff\";s:1:\"e\";s:3:\"web\";}i:91;a:5:{s:1:\"a\";i:92;s:1:\"b\";s:5:\"Staff\";s:1:\"c\";s:10:\"edit_users\";s:1:\"d\";s:10:\"edit staff\";s:1:\"e\";s:3:\"web\";}i:92;a:5:{s:1:\"a\";i:93;s:1:\"b\";s:5:\"Staff\";s:1:\"c\";s:12:\"delete_users\";s:1:\"d\";s:12:\"delete staff\";s:1:\"e\";s:3:\"web\";}i:93;a:5:{s:1:\"a\";i:94;s:1:\"b\";s:5:\"Staff\";s:1:\"c\";s:12:\"create_users\";s:1:\"d\";s:12:\"create staff\";s:1:\"e\";s:3:\"web\";}i:94;a:5:{s:1:\"a\";i:95;s:1:\"b\";s:11:\"designation\";s:1:\"c\";s:16:\"view_designation\";s:1:\"d\";s:16:\"view designation\";s:1:\"e\";s:3:\"web\";}i:95;a:5:{s:1:\"a\";i:96;s:1:\"b\";s:11:\"designation\";s:1:\"c\";s:16:\"edit_designation\";s:1:\"d\";s:16:\"edit designation\";s:1:\"e\";s:3:\"web\";}i:96;a:5:{s:1:\"a\";i:97;s:1:\"b\";s:11:\"designation\";s:1:\"c\";s:18:\"delete_designation\";s:1:\"d\";s:18:\"delete designation\";s:1:\"e\";s:3:\"web\";}i:97;a:5:{s:1:\"a\";i:98;s:1:\"b\";s:11:\"designation\";s:1:\"c\";s:18:\"create_designation\";s:1:\"d\";s:18:\"create designation\";s:1:\"e\";s:3:\"web\";}i:98;a:5:{s:1:\"a\";i:99;s:1:\"b\";s:10:\"department\";s:1:\"c\";s:15:\"view_department\";s:1:\"d\";s:15:\"view department\";s:1:\"e\";s:3:\"web\";}i:99;a:5:{s:1:\"a\";i:100;s:1:\"b\";s:10:\"department\";s:1:\"c\";s:15:\"edit_department\";s:1:\"d\";s:15:\"edit department\";s:1:\"e\";s:3:\"web\";}i:100;a:5:{s:1:\"a\";i:101;s:1:\"b\";s:10:\"department\";s:1:\"c\";s:17:\"delete_department\";s:1:\"d\";s:17:\"delete department\";s:1:\"e\";s:3:\"web\";}i:101;a:5:{s:1:\"a\";i:102;s:1:\"b\";s:10:\"department\";s:1:\"c\";s:17:\"create_department\";s:1:\"d\";s:17:\"create department\";s:1:\"e\";s:3:\"web\";}i:102;a:5:{s:1:\"a\";i:103;s:1:\"b\";s:10:\"permission\";s:1:\"c\";s:16:\"staff_permission\";s:1:\"d\";s:16:\"staff permission\";s:1:\"e\";s:3:\"web\";}i:103;a:5:{s:1:\"a\";i:104;s:1:\"b\";s:16:\"company settings\";s:1:\"c\";s:16:\"company_settings\";s:1:\"d\";s:16:\"company settings\";s:1:\"e\";s:3:\"web\";}i:104;a:5:{s:1:\"a\";i:105;s:1:\"b\";s:16:\"general settings\";s:1:\"c\";s:16:\"general_settings\";s:1:\"d\";s:16:\"general settings\";s:1:\"e\";s:3:\"web\";}i:105;a:5:{s:1:\"a\";i:106;s:1:\"b\";s:14:\"email settings\";s:1:\"c\";s:14:\"email_settings\";s:1:\"d\";s:14:\"email settings\";s:1:\"e\";s:3:\"web\";}i:106;a:5:{s:1:\"a\";i:107;s:1:\"b\";s:23:\"sales purchase settings\";s:1:\"c\";s:23:\"sales_purchase_settings\";s:1:\"d\";s:23:\"sales purchase settings\";s:1:\"e\";s:3:\"web\";}i:107;a:5:{s:1:\"a\";i:108;s:1:\"b\";s:8:\"language\";s:1:\"c\";s:13:\"view_language\";s:1:\"d\";s:13:\"view language\";s:1:\"e\";s:3:\"web\";}i:108;a:5:{s:1:\"a\";i:109;s:1:\"b\";s:8:\"language\";s:1:\"c\";s:13:\"edit_language\";s:1:\"d\";s:13:\"edit language\";s:1:\"e\";s:3:\"web\";}i:109;a:5:{s:1:\"a\";i:110;s:1:\"b\";s:8:\"language\";s:1:\"c\";s:15:\"delete_language\";s:1:\"d\";s:15:\"delete language\";s:1:\"e\";s:3:\"web\";}i:110;a:5:{s:1:\"a\";i:111;s:1:\"b\";s:8:\"language\";s:1:\"c\";s:15:\"create_language\";s:1:\"d\";s:15:\"create language\";s:1:\"e\";s:3:\"web\";}i:111;a:5:{s:1:\"a\";i:112;s:1:\"b\";s:8:\"Currency\";s:1:\"c\";s:13:\"view_currency\";s:1:\"d\";s:13:\"view currency\";s:1:\"e\";s:3:\"web\";}i:112;a:5:{s:1:\"a\";i:113;s:1:\"b\";s:8:\"Currency\";s:1:\"c\";s:13:\"edit_currency\";s:1:\"d\";s:13:\"edit currency\";s:1:\"e\";s:3:\"web\";}i:113;a:5:{s:1:\"a\";i:114;s:1:\"b\";s:8:\"Currency\";s:1:\"c\";s:15:\"delete_currency\";s:1:\"d\";s:15:\"delete currency\";s:1:\"e\";s:3:\"web\";}i:114;a:5:{s:1:\"a\";i:115;s:1:\"b\";s:8:\"Currency\";s:1:\"c\";s:15:\"create_currency\";s:1:\"d\";s:15:\"create currency\";s:1:\"e\";s:3:\"web\";}}s:5:\"roles\";a:0:{}}', 1736490730);

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
  `from_date` date NOT NULL DEFAULT '2025-01-09',
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
(1, 1, '2025-01-09', '2025-01-09', 1, 1, '2025-01-09 00:31:58', '2025-01-09 04:54:28'),
(2, 1, '2025-01-10', NULL, 0, NULL, '2025-01-09 04:54:28', '2025-01-09 04:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Sales', '2025-01-09 00:33:04', '2025-01-09 00:33:04'),
(2, 'Marketing', '2025-01-09 00:33:09', '2025-01-09 00:33:09'),
(3, 'Accounts', '2025-01-09 00:33:18', '2025-01-09 00:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Jr Accountant', '2025-01-09 00:35:03', '2025-01-09 00:35:03'),
(2, 'Sales Officer', '2025-01-09 00:35:10', '2025-01-09 00:35:10'),
(3, 'Security Guard', '2025-01-09 00:35:24', '2025-01-09 00:35:24'),
(4, 'Cashier', '2025-01-09 00:35:30', '2025-01-09 00:35:30');

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
  `from_date` date NOT NULL DEFAULT '2025-01-09',
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
(1, '2025-01-09', NULL, '24-25', 0, NULL, '2025-01-09 00:31:58', '2025-01-09 00:31:58');

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
(1, 'company_name', 'E-Billing', NULL, '2025-01-09 03:26:02'),
(2, 'company_logo', 'assets/images/invoice.png', NULL, NULL),
(3, 'company_address', 'Apt. 765 4090 Zackary Mills, Port Danieletown, NV 49328', NULL, '2025-01-09 03:26:02'),
(4, 'company_phone', '01873844448', NULL, NULL),
(5, 'company_email', 'admin@example.com', NULL, NULL),
(6, 'favicon', NULL, NULL, NULL),
(7, 'system_currency_symbol', '$', NULL, '2025-01-09 03:26:11'),
(8, 'system_currency_id', '2', NULL, '2025-01-09 03:26:11'),
(9, 'date_format', 'd/m/Y', NULL, NULL),
(10, 'decimal_point', '2', NULL, NULL),
(11, 'currency_position', 'left', NULL, NULL),
(12, 'purchase_terms_condition', '<p>No Term and Condition Applied</p>', NULL, NULL),
(13, 'sale_terms_condition', '<p>No Term and Condition Applied After 10 Days</p>', NULL, NULL),
(14, 'purchase_discount_ledger', '52', NULL, NULL),
(15, 'sales_discount_ledger', '25', NULL, NULL),
(16, 'system_language', 'en', NULL, NULL);

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
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rtl` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `rtl`, `status`, `created_at`, `updated_at`) VALUES
(1, 'bn', 'Bengali', 0, 0, NULL, NULL),
(2, 'en', 'English', 0, 1, NULL, NULL),
(3, 'hi', 'Hindi', 0, 0, NULL, NULL);

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
(25, 'others', 'Discount on Sales', 'I4002', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(26, 'others', 'Non-Operating Income', 'I4003', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL),
(27, 'others', 'Sales Revenue', 'I4004', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL),
(28, 'others', 'Financial Expenses', 'E3009', 3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(29, 'others', 'Sales From Water Engineering Projects', 'I4005', 4, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(30, 'others', 'Equities', 'E5001', 5, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(31, 'others', 'Shareholder\'s Equity', 'E5002', 5, 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(32, 'others', 'Share Capital', 'E5003', 5, 31, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL),
(33, 'others', 'Conveyance Bill', 'E3010', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(34, 'others', 'Printing and Stationary', 'E3011', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(35, 'others', 'Allowance', 'E3012', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(36, 'others', 'Office Rent', 'E3013', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL),
(37, 'others', 'VAT on Office Rent Payable', 'L2057', 3, 12, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(38, 'others', 'Entertainment bill', 'E3014', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(39, 'others', 'Medical and Treatment', 'E3015', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(40, 'others', 'Electricity Bill', 'E3016', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(41, 'others', 'Wasa Bill', 'E3017', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(42, 'others', 'Electrical and Computer Accessories', 'E3018', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(43, 'others', 'Office Maintenance', 'E3019', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(44, 'others', 'Repair and Maintenance', 'E3020', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(45, 'others', 'Car & Vehicles Maintenace', 'E3021', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(46, 'others', 'Postage & Courier', 'E3022', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(47, 'others', 'Telephone & Mobile Bill', 'E3023', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(48, 'others', 'Tours & Travel Expense', 'E3024', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(49, 'others', 'Internet Bill', 'E3025', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(50, 'others', 'Audit Fee', 'E3026', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(51, 'others', 'Business Promotion Expenses', 'E3027', 3, 19, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(52, 'others', 'Purchase Discount', 'E3028', 3, 17, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL),
(53, 'cash', 'Cash In Hand', 'A1009', 1, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 1, NULL, '2025-01-09 03:28:25', '2025-01-09 03:28:25'),
(54, 'bank', 'Trust Bank Ltd', 'A1010', 1, 4, 4, 'E-Billing Account', 'TBL-20038645', NULL, '65', NULL, '12', NULL, 1, 0, 0, 0, 1, NULL, '2025-01-09 03:29:19', '2025-01-09 03:29:19'),
(55, 'bank', 'Jamuna Bank Ltd', 'A1011', 1, 4, 4, 'E-Billing Account', 'JBL-20038645', NULL, '75', NULL, '32', NULL, 1, 0, 0, 0, 1, NULL, '2025-01-09 03:29:19', '2025-01-09 03:29:19');

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
(26, '2024_12_27_150118_create_quotation_details_table', 1),
(27, '2024_12_30_093620_create_languages_table', 1),
(28, '2024_12_30_144903_create_permission_tables', 1),
(29, '2024_12_30_144904_add_extra_col_for_permission_table', 1),
(30, '2025_01_06_170714_create_designations_table', 1),
(31, '2025_01_06_170758_create_departments_table', 1),
(32, '2025_01_06_172512_create_staffs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 1),
(41, 'App\\Models\\User', 1),
(42, 'App\\Models\\User', 1),
(43, 'App\\Models\\User', 1),
(44, 'App\\Models\\User', 1),
(45, 'App\\Models\\User', 1),
(46, 'App\\Models\\User', 1),
(47, 'App\\Models\\User', 1),
(48, 'App\\Models\\User', 1),
(49, 'App\\Models\\User', 1),
(50, 'App\\Models\\User', 1),
(51, 'App\\Models\\User', 1),
(52, 'App\\Models\\User', 1),
(53, 'App\\Models\\User', 1),
(54, 'App\\Models\\User', 1),
(55, 'App\\Models\\User', 1),
(56, 'App\\Models\\User', 1),
(57, 'App\\Models\\User', 1),
(58, 'App\\Models\\User', 1),
(59, 'App\\Models\\User', 1),
(60, 'App\\Models\\User', 1),
(61, 'App\\Models\\User', 1),
(62, 'App\\Models\\User', 1),
(63, 'App\\Models\\User', 1),
(64, 'App\\Models\\User', 1),
(65, 'App\\Models\\User', 1),
(66, 'App\\Models\\User', 1),
(67, 'App\\Models\\User', 1),
(68, 'App\\Models\\User', 1),
(69, 'App\\Models\\User', 1),
(70, 'App\\Models\\User', 1),
(71, 'App\\Models\\User', 1),
(72, 'App\\Models\\User', 1),
(73, 'App\\Models\\User', 1),
(74, 'App\\Models\\User', 1),
(75, 'App\\Models\\User', 1),
(76, 'App\\Models\\User', 1),
(77, 'App\\Models\\User', 1),
(78, 'App\\Models\\User', 1),
(79, 'App\\Models\\User', 1),
(80, 'App\\Models\\User', 1),
(81, 'App\\Models\\User', 1),
(82, 'App\\Models\\User', 1),
(83, 'App\\Models\\User', 1),
(84, 'App\\Models\\User', 1),
(85, 'App\\Models\\User', 1),
(86, 'App\\Models\\User', 1),
(87, 'App\\Models\\User', 1),
(88, 'App\\Models\\User', 1),
(89, 'App\\Models\\User', 1),
(90, 'App\\Models\\User', 1),
(91, 'App\\Models\\User', 1),
(92, 'App\\Models\\User', 1),
(93, 'App\\Models\\User', 1),
(94, 'App\\Models\\User', 1),
(95, 'App\\Models\\User', 1),
(96, 'App\\Models\\User', 1),
(97, 'App\\Models\\User', 1),
(98, 'App\\Models\\User', 1),
(99, 'App\\Models\\User', 1),
(100, 'App\\Models\\User', 1),
(101, 'App\\Models\\User', 1),
(102, 'App\\Models\\User', 1),
(103, 'App\\Models\\User', 1),
(104, 'App\\Models\\User', 1),
(105, 'App\\Models\\User', 1),
(106, 'App\\Models\\User', 1),
(107, 'App\\Models\\User', 1),
(108, 'App\\Models\\User', 1),
(109, 'App\\Models\\User', 1),
(110, 'App\\Models\\User', 1),
(111, 'App\\Models\\User', 1),
(112, 'App\\Models\\User', 1),
(113, 'App\\Models\\User', 1),
(114, 'App\\Models\\User', 1),
(115, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `date` date NOT NULL DEFAULT '2025-01-09',
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
(1, '2025-01-09', 'Modules\\Accounts\\App\\Models\\Sale', 1, 1550, 53, NULL, NULL, NULL, '2025-01-09', 1, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', '2025-01-09 04:06:23', '2025-01-09 04:38:58'),
(2, '2025-01-09', 'Modules\\Accounts\\App\\Models\\Purchase', 1, 13250, 54, 'Trust Bank', '56355458', '1215655941', '2025-01-24', 1, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', '2025-01-09 04:08:18', '2025-01-09 04:37:13'),
(3, '2025-01-10', 'Modules\\Accounts\\App\\Models\\Sale', 3, 9.7, 53, NULL, NULL, NULL, '2025-01-09', 1, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', '2025-01-09 04:55:32', '2025-01-09 04:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_module` varchar(200) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `sub_module`, `name`, `label`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'product', 'view_product', 'view product', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(2, 'product', 'edit_product', 'edit product', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(3, 'product', 'delete_product', 'delete product', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(4, 'product', 'create_product', 'create product', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(5, 'product unit', 'view_product_unit', 'view product unit', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(6, 'product unit', 'edit_product_unit', 'edit product unit', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(7, 'product unit', 'delete_product_unit', 'delete product unit', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(8, 'product unit', 'create_product_unit', 'create product unit', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(9, 'quotation', 'view_quotation', 'view quotation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(10, 'quotation', 'edit_quotation', 'edit quotation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(11, 'quotation', 'delete_quotation', 'delete quotation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(12, 'quotation', 'create_quotation', 'create quotation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(13, 'quotation', 'approve_quotation', 'approve quotation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(14, 'sales', 'view_sales', 'view sales', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(15, 'sales', 'edit_sales', 'edit sales', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(16, 'sales', 'delete_sales', 'delete sales', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(17, 'sales', 'create_sales', 'create sales', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(18, 'sales', 'approve_sales', 'approve sales', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(19, 'purcahse', 'view_purcahse', 'view purcahse', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(20, 'purcahse', 'edit_purcahse', 'edit purcahse', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(21, 'purcahse', 'delete_purcahse', 'delete purcahse', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(22, 'purcahse', 'create_purcahse', 'create purcahse', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(23, 'purcahse', 'approve_purcahse', 'approve purcahse', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(24, 'ledger', 'view_ledger', 'view ledger', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(25, 'ledger', 'edit_ledger', 'edit ledger', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(26, 'ledger', 'delete_ledger', 'delete ledger', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(27, 'ledger', 'create_ledger', 'create ledger', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(28, 'party type', 'view_party_type', 'view party type', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(29, 'party type', 'edit_party_type', 'edit party type', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(30, 'party type', 'delete_party_type', 'delete party type', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(31, 'party type', 'create_party_type', 'create party type', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(32, 'party', 'view_party', 'view party', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(33, 'party', 'edit_party', 'edit party', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(34, 'party', 'delete_party', 'delete party', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(35, 'party', 'create_party', 'create party', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(36, 'work order', 'view_work_order', 'view work order', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(37, 'work order', 'edit_work_order', 'edit work order', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(38, 'work order', 'delete_work_order', 'delete work order', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(39, 'work order', 'create_work_order', 'create work order', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(40, 'work order sites', 'view_work_order_site', 'view work order sites', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(41, 'work order sites', 'edit_work_order_site', 'edit work order sites', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(42, 'work order sites', 'delete_work_order_site', 'delete work order sites', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(43, 'work order sites', 'create_work_order_site', 'create work order sites', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(44, 'cash payment', 'view_cash_payment', 'view cash payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(45, 'cash payment', 'edit_cash_payment', 'edit cash payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(46, 'cash payment', 'delete_cash_payment', 'delete cash payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(47, 'cash payment', 'create_cash_payment', 'create cash payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(48, 'bank payment', 'view_bank_payment', 'view bank payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(49, 'bank payment', 'edit_bank_payment', 'edit bank payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(50, 'bank payment', 'delete_bank_payment', 'delete bank payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(51, 'bank payment', 'create_bank_payment', 'create bank payment', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(52, 'cash recieve', 'view_cash_recieve', 'view cash recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(53, 'cash recieve', 'edit_cash_recieve', 'edit cash recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(54, 'cash recieve', 'delete_cash_recieve', 'delete cash recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(55, 'cash recieve', 'create_cash_recieve', 'create cash recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(56, 'bank recieve', 'view_bank_recieve', 'view bank recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(57, 'bank recieve', 'edit_bank_recieve', 'edit bank recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(58, 'bank recieve', 'delete_bank_recieve', 'delete bank recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(59, 'bank recieve', 'create_bank_recieve', 'create bank recieve', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(60, 'journal', 'view_journal', 'view journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(61, 'journal', 'edit_journal', 'edit journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(62, 'journal', 'delete_journal', 'delete journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(63, 'journal', 'create_journal', 'create journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(64, 'work order journal', 'view_work_order_journal', 'view work order journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(65, 'work order journal', 'edit_work_order_journal', 'edit work order journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(66, 'work order journal', 'delete_work_order_journal', 'delete work order journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(67, 'work order journal', 'create_work_order_journal', 'create work order journal', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(68, 'opening balance', 'view_opening_balance', 'view opening balance', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(69, 'opening balance', 'edit_opening_balance', 'edit opening balance', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(70, 'opening balance', 'delete_opening_balance', 'delete opening balance', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(71, 'opening balance', 'create_opening_balance', 'create opening balance', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(72, 'voucher approval', 'view_pending_vocuher', 'view pending voucher', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(73, 'voucher approval', 'view_rejected_vocuher', 'view rejected voucher ', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(74, 'voucher approval', 'approval_vocuher', 'approve voucher ', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(75, 'Accounting Report', 'cashbook_report', 'cashbook report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(76, 'Accounting Report', 'bankbook_report', 'bankbook report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(77, 'Accounting Report', 'ledger_report', 'ledger report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(78, 'Accounting Report', 'party_report', 'party report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(79, 'Accounting Report', 'party_summary_report', 'party summary report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(80, 'Accounting Report', 'work_order_report', 'work order report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(81, 'Accounting Report', 'work_order_summary_report', 'work order summary report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(82, 'Accounting Report', 'work_order_pl_report', 'work order Profit Loss report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(83, 'Accounting Report', 'work_order_asset_liability_report', 'work order Asset Liability report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(84, 'Accounting Report', 'work_order_reciept_payemnt_report', 'work order reciept payment report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(85, 'Accounting Report', 'reciept_payemnt_report', 'reciept payment report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(86, 'Accounting Report', 'balancesheet_report', 'balancesheet report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(87, 'Accounting Report', 'income_statement_report', 'income statement report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(88, 'Accounting Report', 'trial_report', 'trial report', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(89, 'accounting configuration', 'accounting_report_config', 'accounting report config', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(90, 'accounting configuration', 'day_closing', 'day closing', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(91, 'Staff', 'view_users', 'view staff', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(92, 'Staff', 'edit_users', 'edit staff', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(93, 'Staff', 'delete_users', 'delete staff', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(94, 'Staff', 'create_users', 'create staff', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(95, 'designation', 'view_designation', 'view designation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(96, 'designation', 'edit_designation', 'edit designation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(97, 'designation', 'delete_designation', 'delete designation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(98, 'designation', 'create_designation', 'create designation', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(99, 'department', 'view_department', 'view department', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(100, 'department', 'edit_department', 'edit department', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(101, 'department', 'delete_department', 'delete department', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(102, 'department', 'create_department', 'create department', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(103, 'permission', 'staff_permission', 'staff permission', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(104, 'company settings', 'company_settings', 'company settings', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(105, 'general settings', 'general_settings', 'general settings', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(106, 'email settings', 'email_settings', 'email settings', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(107, 'sales purchase settings', 'sales_purchase_settings', 'sales purchase settings', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(108, 'language', 'view_language', 'view language', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(109, 'language', 'edit_language', 'edit language', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(110, 'language', 'delete_language', 'delete language', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(111, 'language', 'create_language', 'create language', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(112, 'Currency', 'view_currency', 'view currency', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(113, 'Currency', 'edit_currency', 'edit currency', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(114, 'Currency', 'delete_currency', 'delete currency', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58'),
(115, 'Currency', 'create_currency', 'create currency', 'web', '2025-01-09 00:31:58', '2025-01-09 00:31:58');

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
(1, 22, 27, 1, 'Half Inch Tap', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 15, 0, 5, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(2, 22, 27, 1, 'Motor seal', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 35, 0, 20, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(3, 22, 27, 1, 'Joint Elbow (6mm push)', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 30, 0, 15, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(4, 22, 27, 1, 'Water Connector', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 300, 0, 180, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(5, 22, 27, 1, 'Pipe Cutter', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 320, 0, 120, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(6, 22, 27, 1, 'Single Wardrof', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 4200, 0, 2800, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(7, 22, 27, 1, 'Medium Wardrof', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 8000, 0, 5500, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(8, 22, 27, 1, 'SS locker', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 800, 0, 500, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(9, 22, 27, 1, 'Water Hiter', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 1200, 0, 800, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(10, 22, 27, 1, 'Sofa (3 Seat)', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 3800, 1, 2900, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48'),
(11, 22, 27, 1, 'Sofa (2 Seat)', 'Product', 'Yes', 'Yes', 'Yes', 'Yes', 3200, 1, 2700, 0, NULL, 'Leroem ipsome dummy text input as details.', 1, NULL, '2025-01-09 00:54:48', '2025-01-09 00:54:48');

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
(1, 'Pcs', '2025-01-09 00:52:20', '2025-01-09 00:52:20'),
(2, 'Inches', '2025-01-09 00:52:20', '2025-01-09 00:52:20'),
(3, 'Ltr', '2025-01-09 00:52:20', '2025-01-09 00:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
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
(1, '2025-01-09', 4, 'PO#202500001', NULL, '01545112220', 13250, 13250, 0, 0, 'Cash', 'Paid', NULL, '<p>No Term and Condition Applied</p>', 0, 'Approved', 1, 1, NULL, 1, 1, '2025-01-09 04:08:18', '2025-01-09 04:37:13');

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
(1, 1, 1, 100, 0, 0, 5, 500, '2025-01-09 04:08:18', '2025-01-09 04:08:18'),
(2, 1, 2, 120, 0, 0, 20, 2400, '2025-01-09 04:08:18', '2025-01-09 04:08:18'),
(3, 1, 3, 50, 0, 0, 15, 750, '2025-01-09 04:08:18', '2025-01-09 04:08:18'),
(4, 1, 5, 80, 0, 0, 120, 9600, '2025-01-09 04:08:18', '2025-01-09 04:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
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
(1, '2025-01-09', 2, 'QTN#202500001', NULL, '01745112221', 3705, 3519.75, 185.25, 5, 'Thank you for being with us!', '<p>No Term and Condition Applied After 10 Days</p>', 'Pending', 'Pending', NULL, 1, NULL, '2025-01-09 04:04:46', '2025-01-09 04:04:46');

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
(1, 1, 1, 12, 0, 0, 15, 180, '2025-01-09 04:04:46', '2025-01-09 04:04:46'),
(2, 1, 2, 15, 0, 0, 35, 525, '2025-01-09 04:04:46', '2025-01-09 04:04:46'),
(3, 1, 3, 100, 0, 0, 30, 3000, '2025-01-09 04:04:46', '2025-01-09 04:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
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
(1, '2025-01-09', 2, 'S#202500001', NULL, '01745112227', 1550, 1550, 0, 0, 'Cash', 'Paid', 'Thank You for being with us!', '<p>No Term and Condition Applied After 10 Days</p>', 0, 'Approved', 0, 0, NULL, 1, 1, 0, '2025-01-09 04:06:22', '2025-01-09 04:38:58'),
(2, '2025-01-10', 2, 'S#202500002', NULL, '01745112227', 15, 15, 0, 0, 'Cash', 'Due', NULL, '<p>No Term and Condition Applied After 10 Days</p>', 0, 'Pending', 0, 0, NULL, 1, NULL, 0, '2025-01-09 04:55:01', '2025-01-09 04:55:01'),
(3, '2025-01-10', 2, 'S#202500003', NULL, '01745112227', 30, 29.7, 0.3, 1, 'Cash', 'Due', NULL, '<p>No Term and Condition Applied After 10 Days</p>', 0, 'Approved', 0, 0, NULL, 1, 1, 0, '2025-01-09 04:55:31', '2025-01-09 04:55:48');

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
(1, 1, 3, 1, 0, 0, 30, 30, '2025-01-09 04:06:22', '2025-01-09 04:06:22'),
(2, 1, 5, 1, 0, 0, 320, 320, '2025-01-09 04:06:22', '2025-01-09 04:06:22'),
(3, 1, 9, 1, 0, 0, 1200, 1200, '2025-01-09 04:06:22', '2025-01-09 04:06:22'),
(4, 2, 1, 1, 0, 0, 15, 15, '2025-01-09 04:55:01', '2025-01-09 04:55:01'),
(5, 3, 3, 1, 0, 0, 30, 30, '2025-01-09 04:55:31', '2025-01-09 04:55:31');

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

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `department_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `designation_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `staff_id` varchar(20) NOT NULL COMMENT 'Official ID',
  `phone` varchar(20) DEFAULT NULL,
  `alternate_phone` varchar(20) DEFAULT NULL,
  `present_address` varchar(300) DEFAULT NULL,
  `permanant_address` varchar(300) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL DEFAULT '2025-01-09',
  `joining_date` date NOT NULL DEFAULT '2025-01-09',
  `employement_status` enum('Provision','Permanant','Contractual') NOT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `user_id`, `department_id`, `designation_id`, `staff_id`, `phone`, `alternate_phone`, `present_address`, `permanant_address`, `nid`, `cv`, `date_of_birth`, `joining_date`, `employement_status`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 2, 'EB-101', '01745112220', NULL, 'Jamuna Street, Leoan Park', 'Jamuna Street, Leoan Park', NULL, NULL, '2001-01-19', '2025-01-01', 'Provision', 'Joining as a provision', 1, NULL, '2025-01-09 00:37:51', '2025-01-09 00:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
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
(1, 5, 'Modules\\Base\\App\\Models\\Staff', 1, 23, 'Staff', 'EB-101', 'Jahid Hasan', 'jahid@example.com', 'AB Bank', 'Jahid Hasan', '365012542', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2025-01-09 00:37:51', '2025-01-09 00:37:51'),
(2, 0, NULL, 0, 6, 'Client', '3260', 'Mr Client A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2025-01-09 01:01:34', '2025-01-09 01:01:34'),
(3, 4, NULL, 0, 6, 'Client', '3622', 'Ms Sathi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2025-01-09 01:01:59', '2025-01-09 01:01:59'),
(4, 2, NULL, 0, 15, 'Vendor', '4001', 'Mr Vendor TRD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '326222302', NULL, NULL, NULL, 1, NULL, '2025-01-09 01:02:32', '2025-01-09 01:02:32'),
(5, 3, NULL, 0, 15, 'Vendor', '40012', 'Z Traders', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, '2025-01-09 01:03:11', '2025-01-09 01:03:11');

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
(5, 0, 'In-House Staff', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
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

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `voucher_id`, `work_order_id`, `work_order_site_id`, `ledger_id`, `sub_ledger_id`, `type`, `credit_period`, `amount`, `narration`, `is_opening`, `is_approve`, `bank_name`, `bank_account_name`, `check_no`, `check_mature_date`, `payment_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2025-01-09', 1, 0, 0, 53, 0, 'Dr', 0, 250000, 'Opening Balance add to Start Business', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 03:49:44', '2025-01-09 04:54:06', NULL),
(2, '2025-01-09', 1, 0, 0, 54, 0, 'Dr', 0, 3400000, 'Opening Balance add to Start Business', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 03:49:44', '2025-01-09 04:54:06', NULL),
(3, '2025-01-09', 1, 0, 0, 55, 0, 'Dr', 0, 700000, 'Opening Balance add to Start Business', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 03:49:44', '2025-01-09 04:54:06', NULL),
(4, '2025-01-09', 2, 1, 1, 22, 0, 'Dr', 0, 500, 'Half Inch Tap Purchased in PO#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(5, '2025-01-09', 2, 1, 1, 22, 0, 'Dr', 0, 2400, 'Motor seal Purchased in PO#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(6, '2025-01-09', 2, 1, 1, 22, 0, 'Dr', 0, 750, 'Joint Elbow (6mm push) Purchased in PO#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(7, '2025-01-09', 2, 1, 1, 22, 0, 'Dr', 0, 9600, 'Pipe Cutter Purchased in PO#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(8, '2025-01-09', 2, 1, 1, 15, 4, 'Cr', 0, 13250, 'Voucher for invoicePO#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(9, '2025-01-09', 3, 1, 1, 15, 4, 'Dr', 0, 13250, 'Payment for PO#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(10, '2025-01-09', 3, 1, 1, 54, 0, 'Cr', 0, 13250, 'PO#202500001', 0, 1, 'Trust Bank', '56355458', '1215655941', '2025-01-24', 0, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(11, '2025-01-09', 4, 0, 0, 6, 2, 'Dr', 0, 1550, 'Voucher for invoiceS#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(12, '2025-01-09', 4, 0, 0, 27, 0, 'Cr', 0, 30, 'Joint Elbow (6mm push) sold in S#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(13, '2025-01-09', 4, 0, 0, 27, 0, 'Cr', 0, 320, 'Pipe Cutter sold in S#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(14, '2025-01-09', 4, 0, 0, 27, 0, 'Cr', 0, 1200, 'Water Hiter sold in S#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(15, '2025-01-09', 5, 0, 0, 53, 0, 'Dr', 0, 1550, 'S#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(16, '2025-01-09', 5, 0, 0, 6, 2, 'Cr', 0, 1550, 'Payment Received for S#202500001', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(17, '2025-01-09', 6, 0, 0, 45, 0, 'Dr', 0, 15000, 'Monthly Vehicle maintenance cost', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:50:31', '2025-01-09 04:54:06', NULL),
(18, '2025-01-09', 6, 0, 0, 54, 0, 'Cr', 0, 15000, 'Monthly Vehicle maintenance cost', 0, 1, NULL, NULL, NULL, '2025-01-09', 0, '2025-01-09 04:50:31', '2025-01-09 04:54:06', NULL),
(19, '2025-01-10', 7, 0, 0, 25, 0, 'Dr', 0, 0.3, 'Got Discount on invoice S#202500003', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL),
(20, '2025-01-10', 7, 0, 0, 6, 2, 'Dr', 0, 29.7, 'Voucher for invoiceS#202500003', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL),
(21, '2025-01-10', 7, 0, 0, 27, 0, 'Cr', 0, 30, 'Joint Elbow (6mm push) sold in S#202500003', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL),
(22, '2025-01-10', 8, 0, 0, 53, 0, 'Dr', 0, 9.7, 'S#202500003', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL),
(23, '2025-01-10', 8, 0, 0, 6, 2, 'Cr', 0, 9.7, 'Payment Received for S#202500003', 0, 1, NULL, NULL, NULL, NULL, 0, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL);

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
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `is_active`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mr Admin', 'admin', 'admin@example.com', NULL, '$2y$12$.5Rs5nLcy6UjjykykDgWjunN5GCKuwzwVmi3K11LIGVXDn.ROIJ/e', 1, NULL, NULL, '2025-01-09 00:31:57', '2025-01-09 00:31:57'),
(2, 'Mr Naim', 'naim56', 'naim@example.com', NULL, '$2y$12$X/q0rZlSbcVLap45lyTUmukXVT6c2VK/jUs6Sp.tjFyHZCCVg2ffC', 1, NULL, NULL, '2025-01-09 00:31:57', '2025-01-09 00:31:57'),
(3, 'Jahid Hasan', 'jahid-hasan09063751', 'jahid@example.com', NULL, '$2y$12$Ucudyp5owh6ZLdIK5eMyUeMwFfQkRdhd7Z4JRWcph.61E2Od5C9/e', 1, NULL, NULL, '2025-01-09 00:37:51', '2025-01-09 00:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
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

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `date`, `panel`, `f_year`, `txn_id`, `referable_type`, `referable_id`, `type`, `amount`, `ref_no`, `narration`, `rejection_comment`, `is_approve`, `is_transfer`, `is_invoiced`, `is_advanced`, `is_opening`, `is_manual_entry`, `is_work_order_based`, `pay_or_rcv_type`, `concern_person`, `mac_address`, `ip`, `attachment`, `approved_by`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2025-01-09', 'opening_balance', 2425, 100001, NULL, NULL, 'others', 4350000, NULL, 'Opening Balance add to Start Business', NULL, 1, 0, 0, 0, 1, 1, 0, NULL, NULL, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, 1, 1, NULL, '2025-01-09 03:49:44', '2025-01-09 04:54:06', NULL),
(2, '2025-01-09', 'purchase', 2425, 100001, 'Modules\\Accounts\\App\\Models\\Purchase', 1, 'purchase', 13250, NULL, 'Auto generated voucher for PO#202500001', NULL, 1, 0, 1, 0, 0, 0, 0, 'purchase', '1', '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, NULL, 1, NULL, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(3, '2025-01-09', 'purchase', 2425, 100001, 'Modules\\Accounts\\App\\Models\\Purchase', 1, 'pay', 13250, NULL, 'Payment for PO#202500001', NULL, 1, 0, 1, 0, 0, 0, 0, 'pay', '1', '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, NULL, 1, NULL, '2025-01-09 04:37:13', '2025-01-09 04:37:13', NULL),
(4, '2025-01-09', 'sales', 2425, 100001, 'Modules\\Accounts\\App\\Models\\Sale', 1, 'sales', 1550, NULL, 'Auto generated voucher for S#202500001', NULL, 1, 0, 1, 0, 0, 0, 0, 'sales', '1', '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, NULL, 1, NULL, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(5, '2025-01-09', 'sales', 2425, 100001, 'Modules\\Accounts\\App\\Models\\Sale', 1, 'rcv', 1550, NULL, 'Payment Received for S#202500001', NULL, 1, 0, 1, 0, 0, 0, 0, 'rcv', '1', '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, NULL, 1, NULL, '2025-01-09 04:38:58', '2025-01-09 04:38:58', NULL),
(6, '2025-01-09', 'bank_payment_multiple', 2425, 100001, NULL, NULL, 'pay_bank', 15000, NULL, 'Monthly Vehicle maintenance cost', NULL, 1, 0, 0, 0, 0, 1, 0, 'Cheque', NULL, '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, 1, 1, NULL, '2025-01-09 04:50:31', '2025-01-09 04:54:06', NULL),
(7, '2025-01-10', 'sales', 2425, 100002, 'Modules\\Accounts\\App\\Models\\Sale', 3, 'sales', 29.7, NULL, 'Auto generated voucher for S#202500003', NULL, 1, 0, 1, 0, 0, 0, 0, 'sales', '1', '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, NULL, 1, NULL, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL),
(8, '2025-01-10', 'sales', 2425, 100002, 'Modules\\Accounts\\App\\Models\\Sale', 3, 'rcv', 9.7, NULL, 'Payment Received for S#202500003', NULL, 1, 0, 1, 0, 0, 0, 0, 'rcv', '1', '70-CD-0D-8F-79-55   Media disconnected', '127.0.0.1', NULL, NULL, 1, NULL, '2025-01-09 04:55:48', '2025-01-09 04:55:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_orders`
--

CREATE TABLE `work_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2025-01-09',
  `final_date` date NOT NULL DEFAULT '2025-01-09',
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
(1, '2025-01-01', '2025-04-30', 2, 'Json Stathum', 'LPD Dummy Work Order', 'LDP10001', 1200000, NULL, 1, 1, NULL, '2025-01-09 01:06:22', '2025-01-09 01:06:22');

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
(1, 1, 22, 380000, 0, '2025-01-09 01:06:22', '2025-01-09 01:06:22'),
(2, 1, 33, 80000, 0, '2025-01-09 01:06:22', '2025-01-09 01:06:22'),
(3, 1, 40, 150000, 0, '2025-01-09 01:06:22', '2025-01-09 01:06:22'),
(4, 1, 47, 60000, 0, '2025-01-09 01:06:22', '2025-01-09 01:06:22');

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
(1, 1, 'Dhaka Site Golf', 'Banani Location', 0, 'Md Delowar', NULL, '2025-01-09 01:07:08', '2025-01-09 01:07:08');

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
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ledgers_name_index` (`name`),
  ADD KEY `ledgers_code_index` (`code`),
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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staffs_staff_id_unique` (`staff_id`),
  ADD KEY `staffs_phone_index` (`phone`),
  ADD KEY `staffs_joining_date_index` (`joining_date`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_ledgers`
--
ALTER TABLE `sub_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_ledger_types`
--
ALTER TABLE `sub_ledger_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_order_estimation_costs`
--
ALTER TABLE `work_order_estimation_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `work_order_sites`
--
ALTER TABLE `work_order_sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
