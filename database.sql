-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2023 at 06:27 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_deposits`
--

CREATE TABLE `wp_viser_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `method_code` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amo` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int(10) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_deposits`
--

INSERT INTO `wp_viser_deposits` (`id`, `user_id`, `method_code`, `amount`, `method_currency`, `charge`, `rate`, `final_amo`, `detail`, `btc_amo`, `btc_wallet`, `trx`, `payment_try`, `status`, `from_api`, `admin_feedback`, `created_at`, `updated_at`) VALUES
(1, 1, 103, '10.00000000', 'USD', '1.10000000', '1.00000000', '11.10000000', NULL, '0', '', '2MF7PV8AMUT8', 0, 1, 0, NULL, '2023-02-12 06:56:41', '2023-02-12 06:56:41'),
(2, 1, 1008, '10.00000000', 'USD', '1.20000000', '100.00000000', '1120.00000000', 'a:2:{i:0;a:3:{s:4:\"name\";s:9:\"Bank Name\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"World Bank\";}i:1;a:3:{s:4:\"name\";s:10:\"Screenshot\";s:4:\"type\";s:4:\"file\";s:5:\"value\";s:38:\"2023/02/12/63e88df1c3ddf1676185073.png\";}}', '0', '', 'HJVJO6BGAKGO', 0, 3, 0, 'asdfasdf', '2023-02-12 06:57:46', '2023-02-12 06:59:26'),
(3, 1, 1007, '10.00000000', 'BDT', '1.10000000', '106.00000000', '1176.60000000', 'a:1:{i:0;a:3:{s:4:\"name\";s:9:\"Bank Name\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"World Bank\";}}', '0', '', 'TRMNXXEB2C2K', 0, 1, 0, NULL, '2023-02-12 06:59:01', '2023-02-12 09:19:52'),
(4, 1, 504, '10.00000000', 'AUD', '1.00000000', '1.00000000', '11.00000000', NULL, '0', '', 'XOWCV432WGV6', 0, 0, 0, NULL, '2023-02-12 09:24:44', '2023-02-12 09:24:44'),
(5, 1, 1009, '10.00000000', 'USD', '1.20000000', '1.00000000', '11.20000000', 'a:0:{}', '0', '', '3BAONWST19GT', 0, 1, 0, NULL, '2023-02-12 09:38:00', '2023-02-13 09:24:56'),
(6, 1, 115, '100.00000000', 'USD', '2.00000000', '1.00000000', '102.00000000', NULL, '0', '', 'J2RG6KCU4ZAM', 0, 0, 0, NULL, '2023-02-12 09:50:35', '2023-02-12 09:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_extensions`
--

CREATE TABLE `wp_viser_extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_extensions`
--

INSERT INTO `wp_viser_extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 17:16:05', '2023-01-15 04:28:49'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 17:16:05', '2023-01-15 04:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_forms`
--

CREATE TABLE `wp_viser_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_forms`
--

INSERT INTO `wp_viser_forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(3, 'manual_deposit', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-29 09:46:47', '2023-01-29 09:46:47'),
(7, 'manual_deposit', 'a:0:{}', '2023-01-29 09:57:33', '2023-01-29 09:57:33'),
(8, 'manual_deposit', 'a:0:{}', '2023-01-29 12:45:11', '2023-01-29 12:45:11'),
(12, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 05:35:00', '2023-01-31 05:35:00'),
(13, 'withdraw_method', 'a:0:{}', '2023-01-31 09:56:41', '2023-01-31 09:56:41'),
(14, 'withdraw_method', 'a:0:{}', '2023-01-31 09:56:55', '2023-01-31 09:56:55'),
(15, 'withdraw_method', 'a:0:{}', '2023-01-31 09:58:17', '2023-01-31 09:58:17'),
(16, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 09:58:44', '2023-01-31 09:58:44'),
(17, 'withdraw_method', 'a:0:{}', '2023-01-31 10:01:40', '2023-01-31 10:01:40'),
(18, 'withdraw_method', 'a:0:{}', '2023-01-31 10:41:34', '2023-01-31 10:41:34'),
(19, 'withdraw_method', 'a:0:{}', '2023-01-31 10:42:03', '2023-01-31 10:42:03'),
(20, 'withdraw_method', 'a:0:{}', '2023-01-31 10:42:42', '2023-01-31 10:42:42'),
(21, 'withdraw_method', 'a:0:{}', '2023-01-31 11:10:04', '2023-01-31 11:10:04'),
(24, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 11:17:31', '2023-01-31 11:17:31'),
(25, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 11:18:33', '2023-01-31 11:18:33'),
(26, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 11:19:16', '2023-01-31 11:19:16'),
(27, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 11:19:35', '2023-01-31 11:19:35'),
(28, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 11:20:34', '2023-01-31 11:20:34'),
(29, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-01-31 11:21:15', '2023-01-31 11:21:15'),
(30, 'withdraw_method', 'a:0:{}', '2023-01-31 12:26:15', '2023-01-31 12:26:15'),
(31, 'withdraw_method', 'a:0:{}', '2023-01-31 12:26:35', '2023-01-31 12:26:35'),
(32, 'withdraw_method', 'a:0:{}', '2023-01-31 12:26:52', '2023-01-31 12:26:52'),
(33, 'withdraw_method', 'a:0:{}', '2023-01-31 12:27:53', '2023-01-31 12:27:53'),
(34, 'withdraw_method', 'a:0:{}', '2023-01-31 12:28:13', '2023-01-31 12:28:13'),
(35, 'withdraw_method', 'a:0:{}', '2023-01-31 12:28:52', '2023-01-31 12:28:52'),
(36, 'withdraw_method', 'a:0:{}', '2023-01-31 12:29:08', '2023-01-31 12:29:08'),
(37, 'withdraw_method', 'a:0:{}', '2023-01-31 12:30:00', '2023-01-31 12:30:00'),
(38, 'withdraw_method', 'a:0:{}', '2023-01-31 12:30:35', '2023-01-31 12:30:35'),
(39, 'withdraw_method', 'a:0:{}', '2023-01-31 12:31:14', '2023-01-31 12:31:14'),
(40, 'withdraw_method', 'a:0:{}', '2023-01-31 12:31:19', '2023-01-31 12:31:19'),
(41, 'withdraw_method', 'a:0:{}', '2023-01-31 12:31:50', '2023-01-31 12:31:50'),
(42, 'withdraw_method', 'a:0:{}', '2023-01-31 12:32:05', '2023-01-31 12:32:05'),
(43, 'withdraw_method', 'a:0:{}', '2023-01-31 12:32:17', '2023-01-31 12:32:17'),
(44, 'withdraw_method', 'a:0:{}', '2023-01-31 12:32:25', '2023-01-31 12:32:25'),
(45, 'withdraw_method', 'a:0:{}', '2023-01-31 12:32:34', '2023-01-31 12:32:34'),
(46, 'withdraw_method', 'a:0:{}', '2023-01-31 12:33:04', '2023-01-31 12:33:04'),
(47, 'withdraw_method', 'a:0:{}', '2023-01-31 12:33:14', '2023-01-31 12:33:14'),
(48, 'withdraw_method', 'a:0:{}', '2023-01-31 12:33:29', '2023-01-31 12:33:29'),
(49, 'withdraw_method', 'a:0:{}', '2023-01-31 12:34:15', '2023-01-31 12:34:15'),
(50, 'withdraw_method', 'a:0:{}', '2023-02-01 10:34:13', '2023-02-01 10:34:13'),
(51, 'withdraw_method', 'a:0:{}', '2023-02-01 10:34:22', '2023-02-01 10:34:22'),
(52, 'withdraw_method', 'a:0:{}', '2023-02-01 10:34:59', '2023-02-01 10:34:59'),
(53, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-01 10:40:00', '2023-02-01 10:40:00'),
(54, 'withdraw_method', 'a:0:{}', '2023-02-01 10:40:44', '2023-02-01 10:40:44'),
(55, 'withdraw_method', 'a:1:{s:10:\"screenshot\";a:6:{s:4:\"name\";s:10:\"Screenshot\";s:5:\"label\";s:10:\"screenshot\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:12:\"jpg,jpeg,png\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"file\";}}', '2023-02-01 10:50:26', '2023-02-01 10:50:26'),
(56, 'manual_deposit', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 09:44:11', '2023-02-02 09:44:11'),
(57, 'manual_deposit', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 09:44:28', '2023-02-02 09:44:28'),
(58, 'manual_deposit', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 09:45:33', '2023-02-02 09:45:33'),
(59, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 09:47:59', '2023-02-02 09:47:59'),
(60, 'manual_deposit', 'a:1:{s:6:\"gender\";a:6:{s:4:\"name\";s:6:\"Gender\";s:5:\"label\";s:6:\"gender\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 09:48:40', '2023-02-02 09:48:40'),
(61, 'manual_deposit', 'a:0:{}', '2023-02-02 09:50:37', '2023-02-02 09:50:37'),
(62, 'manual_deposit', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 10:07:51', '2023-02-02 10:07:51'),
(63, 'manual_deposit', 'a:0:{}', '2023-02-02 10:08:07', '2023-02-02 10:08:07'),
(64, 'manual_deposit', 'a:1:{s:18:\"transaction_number\";a:6:{s:4:\"name\";s:18:\"Transaction Number\";s:5:\"label\";s:18:\"transaction_number\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 10:12:22', '2023-02-02 10:12:22'),
(65, 'manual_deposit', 'a:3:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}s:11:\"branch_name\";a:6:{s:4:\"name\";s:11:\"Branch Name\";s:5:\"label\";s:11:\"branch_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}s:14:\"account_number\";a:6:{s:4:\"name\";s:14:\"Account Number\";s:5:\"label\";s:14:\"account_number\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-02 10:21:08', '2023-02-02 10:21:08'),
(66, 'manual_deposit', 'a:0:{}', '2023-02-09 10:00:58', '2023-02-09 10:00:58'),
(67, 'withdraw_method', 'a:1:{s:9:\"bank_name\";a:6:{s:4:\"name\";s:9:\"Bank Name\";s:5:\"label\";s:9:\"bank_name\";s:11:\"is_required\";s:8:\"required\";s:10:\"extensions\";s:0:\"\";s:7:\"options\";a:0:{}s:4:\"type\";s:4:\"text\";}}', '2023-02-09 11:52:16', '2023-02-09 11:52:16'),
(68, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:05', '2023-02-12 10:04:05'),
(69, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:05', '2023-02-12 10:04:05'),
(70, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:05', '2023-02-12 10:04:05'),
(71, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:46', '2023-02-12 10:04:46'),
(72, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:46', '2023-02-12 10:04:46'),
(73, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:46', '2023-02-12 10:04:46'),
(74, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:46', '2023-02-12 10:04:46'),
(75, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:47', '2023-02-12 10:04:47'),
(76, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:47', '2023-02-12 10:04:47'),
(77, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:47', '2023-02-12 10:04:47'),
(78, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:47', '2023-02-12 10:04:47'),
(79, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:47', '2023-02-12 10:04:47'),
(80, 'withdraw_method', 'a:0:{}', '2023-02-12 10:04:47', '2023-02-12 10:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_gateways`
--

CREATE TABLE `wp_viser_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `code` int(10) DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_gateways`
--

INSERT INTO `wp_viser_gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 18:04:38'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', 1, '{\"passphrase\":{\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\",\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true},\"wallet_id\":{\"value\":\"\",\"title\":\"PM Wallet\",\"global\":false}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 19:35:33'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 18:48:36'),
(4, 0, 104, 'Skrill', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 19:30:16'),
(5, 0, 105, 'PayTM', 'Paytm', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 21:00:44'),
(6, 0, 106, 'Payeer', 'Payeer', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 07:14:22', '2022-08-28 04:11:14'),
(7, 0, 107, 'PayStack', 'Paystack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 07:14:22', '2021-05-20 19:49:51'),
(8, 0, 108, 'VoguePay', 'Voguepay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 19:22:38'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-06-05 05:37:45'),
(10, 0, 110, 'RazorPay', 'Razorpay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 20:51:32'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 18:53:10'),
(12, 0, 112, 'Instamojo', 'Instamojo', 0, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 20:56:20'),
(13, 0, 501, 'Blockchain', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 07:14:22', '2022-03-21 01:41:56'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 20:07:14'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 20:07:44'),
(17, 0, 505, 'Coingate', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2022-03-30 03:24:57'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 07:14:22', '2021-05-20 20:02:47'),
(24, 0, 113, 'Paypal Express', 'PaypalSdk', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 17:01:08'),
(25, 0, 114, 'Stripe Checkout', 'StripeV3', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 07:14:22', '2021-05-20 18:58:38'),
(27, 0, 115, 'Mollie', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 07:14:22', '2021-05-20 20:44:45'),
(30, 0, 116, 'Cashmaal', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2021-06-22 02:05:04'),
(36, 0, 119, 'Mercado Pago', 'MercadoPago', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2022-09-14 01:41:14'),
(37, 0, 120, 'Authorize.net', 'Authorize', 1, '{\"login_id\":{\"value\":\"59e4P9DBcZv\",\"title\":\"Login ID\",\"global\":true},\"transaction_key\":{\"value\":\"47x47TJyLw2E7DbR\",\"title\":\"Transaction Key\",\"global\":true}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2022-08-28 03:33:06'),
(46, 0, 121, 'NMI', 'NMI', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2022-08-28 04:32:31'),
(51, 64, 1007, 'Mobile Money', 'mobile_money', 1, '[]', '[]', 0, NULL, '<p>Please Send To below Mobile Money Number:</p><div>Mobile Money Number: 000-000-000-000-000</div>', NULL, NULL),
(52, 65, 1008, 'Bank Wire', 'bank_wire', 1, '[]', '[]', 0, NULL, '<p><b>Please Send To below bank Details</b></p><div>Bank Name: Demo Test Bank</div><div>Account Name: Demo Account Name</div><div>Account Number: 000-000-000-000-000</div><div>Routing Number: 0123456789</div>', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_gateway_currencies`
--

CREATE TABLE `wp_viser_gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int(10) DEFAULT NULL,
  `gateway_alias` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_gateway_currencies`
--

INSERT INTO `wp_viser_gateway_currencies` (`id`, `name`, `currency`, `symbol`, `method_code`, `gateway_alias`, `min_amount`, `max_amount`, `percent_charge`, `fixed_charge`, `rate`, `image`, `gateway_parameter`, `created_at`, `updated_at`) VALUES
(39, 'RazorPay - INR', 'INR', '$', 110, 'Razorpay', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"key_id\":\"rzp_test_kiOtejPbRZU90E\",\"key_secret\":\"osRDebzEqbsE1kbyQJ4y0re7\"}', '2020-09-25 22:51:34', '2020-09-25 22:51:34'),
(42, 'VoguePay - USD', 'USD', '$', 108, 'Voguepay', '1.00000000', '1000.00000000', '0.00', '1.00000000', '1.00000000', NULL, '{\"merchant_id\":\"demo\"}', '2020-09-25 22:52:09', '2020-09-25 22:52:09'),
(75, 'Skrill - AED', 'AED', '$', 104, 'Skrill', '1.00000000', '10000.00000000', '1.00', '1.00000000', '10.00000000', NULL, '{\"pay_to_email\":\"merchant@skrill.com\",\"secret_key\":\"---\"}', '2021-05-19 06:04:56', '2021-05-19 06:04:56'),
(76, 'Skrill - USD', 'USD', '$', 104, 'Skrill', '1.00000000', '10000.00000000', '1.00', '1.00000000', '2.00000000', NULL, '{\"pay_to_email\":\"merchant@skrill.com\",\"secret_key\":\"---\"}', '2021-05-19 06:04:56', '2021-05-19 06:04:56'),
(82, 'Paypal Express - USD', 'USD', '$', 113, 'PaypalSdk', '1.00000000', '1000000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"clientId\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\",\"clientSecret\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}', '2021-05-20 18:00:14', '2021-05-20 18:00:14'),
(83, 'Paypal - USD', 'USD', '$', 101, 'Paypal', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"paypal_email\":\"sb-owud61543012@business.example.com\"}', '2021-05-20 18:04:38', '2021-05-20 18:04:38'),
(84, 'Stripe Hosted - USD', 'USD', '$', 103, 'Stripe', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"secret_key\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\",\"publishable_key\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}', '2021-05-20 18:48:36', '2021-05-20 18:48:36'),
(86, 'Stripe Storefront - USD', 'USD', '$', 111, 'StripeJs', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"secret_key\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\",\"publishable_key\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}', '2021-05-20 18:53:13', '2021-05-20 18:53:13'),
(91, 'Stripe Checkout - USD', 'USD', 'USD', 114, 'StripeV3', '10.00000000', '1000.00000000', '0.00', '1.00000000', '1.00000000', NULL, '{\"secret_key\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\",\"publishable_key\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\",\"end_point\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}', '2021-05-20 19:21:58', '2021-05-20 19:21:58'),
(96, 'PayStack - NGN', 'NGN', '₦', 107, 'Paystack', '1.00000000', '10000.00000000', '1.00', '1.00000000', '420.00000000', NULL, '{\"public_key\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\",\"secret_key\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}', '2021-05-20 19:52:11', '2021-05-20 19:52:11'),
(97, 'CoinPayments - BTC', 'BTC', '$', 503, 'Coinpayments', '1.00000000', '10000.00000000', '10.00', '1.00000000', '10.00000000', NULL, '{\"public_key\":\"---------------\",\"private_key\":\"------------\",\"merchant_id\":\"93a1e014c4ad60a7980b4a7239673cb4\"}', '2021-05-20 20:07:14', '2021-05-20 20:07:14'),
(109, 'Mollie - USD', 'USD', '$', 115, 'Mollie', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"mollie_email\":\"vi@gmail.com\",\"api_key\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}', '2021-05-20 20:44:45', '2021-05-20 20:44:45'),
(113, 'Instamojo - INR', 'INR', '₹', 112, 'Instamojo', '1.00000000', '10000.00000000', '1.00', '1.00000000', '75.00000000', NULL, '{\"api_key\":\"test_2241633c3bc44a3de84a3b33969\",\"auth_token\":\"test_279f083f7bebefd35217feef22d\",\"salt\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}', '2021-05-20 20:57:00', '2021-05-20 20:57:00'),
(115, 'Flutterwave - USD', 'USD', 'USD', 109, 'Flutterwave', '1.00000000', '2000.00000000', '0.00', '1.00000000', '1.00000000', NULL, '{\"public_key\":\"----------------\",\"secret_key\":\"-----------------------\",\"encryption_key\":\"------------------\"}', '2021-06-05 05:37:45', '2021-06-05 05:37:45'),
(116, 'PayTM - AUD', 'AUD', '$', 105, 'Paytm', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"MID\":\"DIY12386817555501617\",\"merchant_key\":\"bKMfNxPPf_QdZppa\",\"WEBSITE\":\"DIYtestingweb\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\",\"transaction_url\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\",\"transaction_status_url\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}', '2021-06-14 06:16:39', '2021-06-14 06:16:39'),
(117, 'PayTM - USD', 'USD', '$', 105, 'Paytm', '1.00000000', '10000.00000000', '1.00', '1.00000000', '2.00000000', NULL, '{\"MID\":\"DIY12386817555501617\",\"merchant_key\":\"bKMfNxPPf_QdZppa\",\"WEBSITE\":\"DIYtestingweb\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\",\"transaction_url\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\",\"transaction_status_url\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}', '2021-06-14 06:16:39', '2021-06-14 06:16:39'),
(121, 'Cashmaal - PKR', 'PKR', 'pkr', 116, 'Cashmaal', '1.00000000', '10000.00000000', '10.00', '1.00000000', '100.00000000', NULL, '{\"web_id\":\"3748\",\"ipn_key\":\"546254628759524554647987\"}', '2021-06-22 02:05:04', '2021-06-22 02:05:04'),
(136, 'CoinPayments Fiat - USD', 'USD', '$', 504, 'CoinpaymentsFiat', '1.00000000', '10000.00000000', '10.00', '1.00000000', '10.00000000', NULL, '{\"merchant_id\":\"6515561\"}', '2022-03-09 21:55:32', '2022-03-09 21:55:32'),
(137, 'CoinPayments Fiat - AUD', 'AUD', '$', 504, 'CoinpaymentsFiat', '1.00000000', '10000.00000000', '0.00', '1.00000000', '1.00000000', NULL, '{\"merchant_id\":\"6515561\"}', '2022-03-09 21:55:32', '2022-03-09 21:55:32'),
(140, 'Payeer - USD', 'USD', '$', 106, 'Payeer', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"merchant_id\":\"866989763\",\"secret_key\":\"7575\"}', '2022-03-20 20:54:29', '2022-03-20 20:54:29'),
(142, 'Blockchain - BTC', 'BTC', '$', 501, 'Blockchain', '1.00000000', '1.11000000', '1.00', '11.00000000', '1.00000000', NULL, '{\"api_key\":\"55529946-05ca-48ff-8710-f279d86b1cc5\",\"xpub_code\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}', '2022-03-20 21:53:18', '2022-03-20 21:53:18'),
(144, 'Coinbase Commerce - USD', 'USD', '$', 506, 'CoinbaseCommerce', '1.00000000', '10000.00000000', '10.00', '1.00000000', '10.00000000', NULL, '{\"api_key\":\"c47cd7df-d8e8-424b-a20a\",\"secret\":\"55871878-2c32-4f64-ab66\"}', '2022-03-30 01:48:19', '2022-03-30 01:48:19'),
(145, 'CoinPayments - ETH', 'JPY', '111', 506, 'CoinbaseCommerce', '1.00000000', '11.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"api_key\":\"c47cd7df-d8e8-424b-a20a\",\"secret\":\"55871878-2c32-4f64-ab66\"}', '2022-03-30 01:48:19', '2022-03-30 01:48:19'),
(156, 'NMI - USD', 'USD', '$', 121, 'NMI', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"api_key\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}', '2022-08-28 04:32:31', '2022-08-28 04:32:31'),
(161, 'Advance Cash - USD', 'USD', '$', 123, 'AdvCash', '1.00000000', '1000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"account_email\":\"viserlabteam@gmail.com\",\"api_name\":\"MYAPP\",\"api_password\":\"2B8iTL_0ee\"}', '2022-08-31 01:14:42', '2022-08-31 01:14:42'),
(163, 'Mercado Pago - USD', 'USD', '$', 119, 'MercadoPago', '1.00000000', '10.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"access_token\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}', '2022-09-14 01:41:14', '2022-09-14 01:41:14'),
(167, 'Mobile Money', 'USD', '', 1007, 'mobile_money', '10.00000000', '1000.00000000', '0.85', '2.56000000', '1.00000000', NULL, NULL, '2023-02-02 10:12:22', '2023-02-02 10:12:22'),
(168, 'Bank Wire', 'USD', '', 1008, 'bank_wire', '10.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, NULL, '2023-02-02 10:21:08', '2023-02-02 10:21:08'),
(175, 'Payment', 'USD', '', 1009, 'payment', '1.00000000', '1000.00000000', '2.00', '1.00000000', '1.00000000', NULL, NULL, '2023-02-09 10:00:58', '2023-02-09 10:00:58'),
(185, 'Authorize.net - USD', 'USD', '$', 120, 'Authorize', '1.00000000', '1000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"login_id\":\"59e4P9DBcZv\",\"transaction_key\":\"47x47TJyLw2E7DbR\"}', '2023-02-12 08:51:03', '2023-02-12 08:51:03'),
(193, 'Perfect Money - USD', 'USD', '$', 102, 'PerfectMoney', '1.00000000', '10000.00000000', '1.00', '1.00000000', '1.00000000', NULL, '{\"passphrase\":null,\"wallet_id\":\"U30603391\"}', '2023-02-12 09:15:08', '2023-02-12 09:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_notification_templates`
--

CREATE TABLE `wp_viser_notification_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_notification_templates`
--

INSERT INTO `wp_viser_notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '<div>Your deposit of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit successfully by {{method_name}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:25:43'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Your Deposit is Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:26:07'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Your Deposit Request is Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}} has been rejected</span>.<span style=\"font-weight: bolder;\"><br></span></div><div><br></div><div><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge: {{charge}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number was : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">if you have any queries, feel free to contact us.<br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><br><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">{{rejection_message}}</span><br>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 06:00:00', '2022-04-04 21:45:27'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit requested by {{method_name}}. Charge: {{charge}} . Trx: {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:29:19'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, '2021-11-03 06:00:00', '2022-03-20 14:47:51'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdraw Request has been Processed and your money is sent', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div>', 'Admin Approve Your {{amount}} {{site_currency}} withdraw request by {{method_name}}. Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, 1, '2021-11-03 06:00:00', '2022-03-20 14:50:16'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Rejected.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You should get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">----</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><br></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\">{{amount}} {{currency}} has been&nbsp;<span style=\"font-weight: bolder;\">refunded&nbsp;</span>to your account and your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}}</span><span style=\"font-weight: bolder;\">&nbsp;{{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Rejection :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br><br><br></div><div></div><div></div>', 'Admin Rejected Your {{amount}} {{site_currency}} withdraw request. Your Main Balance {{post_balance}}  {{method_name}} , Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 06:00:00', '2022-03-20 14:57:46'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdraw Request Submitted Successfully', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div>', '{{amount}} {{site_currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} Trx: {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, '2021-11-03 06:00:00', '2022-03-20 22:39:03'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, 1, '2019-09-14 07:14:22', '2021-11-04 03:38:55'),
(18, 'PASSWORD_RESET', 'Reset password', 'Password Reset', '<div>\r\n<div><strong>Someone requested that the password be reset for the following account:</strong></div>\r\n</div>\r\n<div>\r\n<div>\r\n<div>\r\n\r\nIf this was a mistake, just ignore this email and nothing will happen.\r\n<div>\r\n<div>To reset your password, visit the following address:</div>\r\n<div><a href=\\\"{{verify_link}}\\\">{{verify_link}}</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', NULL, '{\"verify_link\" : \"Password rest verify link\"}', 1, 0, NULL, NULL),
(19, 'REGISTER', 'User Registration', 'Account Registration', '<div>\r\n<div><strong>Thank you for registering with {{site_name}}</strong></div>\r\n</div>\r\n<div></div>\r\n<div>\r\n<div>\r\n<div>Please click the link to verify your email :</div>\r\n</div>\r\n</div>\r\n<div><a href=\\\"{{verify_link}}\\\">{{verify_link}}</a></div>', NULL, '{\"verify_link\" : \"Email verification link\"}', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_support_attachments`
--

CREATE TABLE `wp_viser_support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_support_attachments`
--

INSERT INTO `wp_viser_support_attachments` (`id`, `support_message_id`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 6, '63e1e45e066831675748446.png', '2023-02-07 05:40:46', '2023-02-07 05:40:46'),
(2, 7, '63e1e4b6ddea31675748534.png', '2023-02-07 05:42:14', '2023-02-07 05:42:14'),
(3, 10, '63e1f9e6eb6571675753958.png', '2023-02-07 07:12:38', '2023-02-07 07:12:38'),
(4, 12, '63e210b24ca321675759794.png', '2023-02-07 08:49:54', '2023-02-07 08:49:54'),
(5, 17, '63e212d41f6211675760340.png', '2023-02-07 08:59:00', '2023-02-07 08:59:00'),
(6, 20, '63e4ba95b443b1675934357.png', '2023-02-09 09:19:17', '2023-02-09 09:19:17'),
(7, 20, '63e4ba95b4c731675934357.png', '2023-02-09 09:19:17', '2023-02-09 09:19:17'),
(8, 26, '63e75333603ce1676104499.png', '2023-02-11 08:34:59', '2023-02-11 08:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_support_messages`
--

CREATE TABLE `wp_viser_support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_support_messages`
--

INSERT INTO `wp_viser_support_messages` (`id`, `support_ticket_id`, `admin_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Dolorem in commodi e', '2023-02-06 11:23:24', '2023-02-06 11:23:24'),
(2, 1, 0, 'Consequuntur est vo', '2023-02-06 12:17:56', '2023-02-06 12:17:56'),
(3, 1, 0, 'Laboris sit magnam', '2023-02-06 12:19:18', '2023-02-06 12:19:18'),
(4, 2, 0, 'Ut rerum minim offic', '2023-02-06 12:19:40', '2023-02-06 12:19:40'),
(16, 3, 0, 'Est dolorem elit co', '2023-02-07 08:56:44', '2023-02-07 08:56:44'),
(17, 3, 0, 'Dolores soluta enim', '2023-02-07 08:59:00', '2023-02-07 08:59:00'),
(24, 1, 1, 'ok', '2023-02-09 12:27:42', '2023-02-09 12:27:42'),
(26, 4, 1, 'Maiores accusamus qu', '2023-02-11 08:34:59', '2023-02-11 08:34:59'),
(27, 4, 1, 'Et sunt irure amet', '2023-02-11 08:35:23', '2023-02-11 08:35:23'),
(29, 5, 1, 'Esse aut commodo ut', '2023-02-11 09:04:51', '2023-02-11 09:04:51'),
(30, 5, 1, 'Ea in asperiores et', '2023-02-11 09:06:10', '2023-02-11 09:06:10'),
(31, 5, 1, 'Temporibus nostrud q', '2023-02-11 09:06:26', '2023-02-11 09:06:26'),
(32, 2, 1, 'Harum aut est dolore', '2023-02-11 09:20:49', '2023-02-11 09:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_support_tickets`
--

CREATE TABLE `wp_viser_support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) DEFAULT 0,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_support_tickets`
--

INSERT INTO `wp_viser_support_tickets` (`id`, `user_id`, `name`, `email`, `ticket`, `subject`, `status`, `priority`, `last_reply`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rae Parsons', 'user@site.com', '742283', 'Vel rem quos dolorem', 1, 3, '2023-02-09 18:27:42', '2023-02-06 11:23:24', '2023-02-06 11:23:24'),
(2, 1, 'Rae Parsons', 'user@site.com', '393244', 'Possimus perferendi', 1, 3, '2023-02-11 15:20:49', '2023-02-06 12:19:40', '2023-02-06 12:19:40'),
(3, 1, 'Rae Parsons', 'user@site.com', '684413', 'Voluptatibus in volu', 3, 2, '2023-02-07 15:14:06', '2023-02-06 12:20:21', '2023-02-06 12:20:21'),
(4, 1, 'Rae Parsons', 'user@site.com', '551740', 'Qui et iste expedita', 1, 3, '2023-02-11 14:35:23', '2023-02-09 09:19:03', '2023-02-09 09:19:03'),
(5, 11, 'duxupuf', 'wixojis@mailinator.com', '477696', 'Est fugit nulla eos', 3, 3, '2023-02-11 15:06:26', '2023-02-11 08:39:54', '2023-02-11 08:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_transactions`
--

CREATE TABLE `wp_viser_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_transactions`
--

INSERT INTO `wp_viser_transactions` (`id`, `user_id`, `amount`, `charge`, `post_balance`, `trx_type`, `trx`, `details`, `remark`, `created_at`, `updated_at`) VALUES
(1, 1, '100.00000000', '2.00000000', '100.00000000', '+', 'AHROWMD1MXO6', 'Deposit Via Stripe Hosted - USD', 'deposit', '2023-01-30 12:16:45', '2023-01-30 12:16:45'),
(2, 1, '10.00000000', '1.10000000', '10.00000000', '+', 'A3T6CEVWED5Q', 'Deposited viaStripe Hosted - USD', 'deposit', '2023-02-04 07:31:50', NULL),
(3, 1, '500.00000000', '6.00000000', '510.00000000', '+', 'A5PHJ6U2HKYU', 'Deposited via Stripe Hosted - USD', 'deposit', '2023-02-04 07:33:53', NULL),
(4, 1, '100.00000000', '2.00000000', '610.00000000', '+', 'UYKJEERQSS19', 'Deposited via Stripe Hosted - USD', 'deposit', '2023-02-04 08:54:34', NULL),
(5, 1, '100.00000000', '2.00000000', '710.00000000', '+', '8WUR5CO4H7XF', 'Deposited via Mobile Payment', 'deposit', '2023-02-04 10:26:35', NULL),
(6, 1, '100.00000000', '2.00000000', '810.00000000', '+', 'X9DV1F7UU52V', 'Deposited via Stripe Hosted - USD', 'deposit', '2023-02-04 11:04:20', NULL),
(7, 1, '100.00000000', '3.00000000', '910.00000000', '+', '2PGFTZPXXCJP', 'Deposited via Bank Payment', 'deposit', '2023-02-04 11:20:02', NULL),
(8, 1, '100.00000000', '2.00000000', '800.00000000', '-', 'RXOR7Y8H9ZHX', '98.00 USD Withdraw Via Basic', 'withdraw', '2023-02-04 12:37:42', NULL),
(9, 1, '100.00000000', '2.00000000', '900.00000000', '+', 'Q65ORDNY8GTV', 'Deposited via Stripe Hosted - USD', 'deposit', '2023-02-05 08:53:55', NULL),
(10, 1, '10.00000000', '1.10000000', '910.00000000', '+', 'YXJP3V31PXEK', 'Deposited via Authorize.net - USD', 'deposit', '2023-02-05 09:46:35', NULL),
(11, 1, '10.00000000', '1.10000000', '920.00000000', '+', '3WN96ZB4RZPR', 'Deposited via Mollie - USD', 'deposit', '2023-02-05 12:06:28', NULL),
(12, 1, '10.00000000', '1.10000000', '930.00000000', '+', 'ZGDRJTNVWTQW', 'Deposited via PayStack - NGN', 'deposit', '2023-02-06 06:05:21', NULL),
(13, 1, '10.00000000', '1.10000000', '940.00000000', '+', 'XH6EZKHA2KO4', 'Deposited via Stripe Storefront - USD', 'deposit', '2023-02-06 07:20:11', NULL),
(14, 1, '100.00000000', '0.00000000', '1040.00000000', '+', 'RXOR7Y8H9ZHX', '100.00 USD Refunded from withdrawal rejection', 'withdraw_reject', '2023-02-07 10:00:45', NULL),
(15, 1, '100.00000000', '3.00000000', '1140.00000000', '+', 'TEP89TEA4GCN', 'Deposited via Bank Payment', 'deposit', '2023-02-07 11:58:20', NULL),
(16, 1, '100.00000000', '35.00000000', '1040.00000000', '-', 'H4NF71NUS9YT', '1,495.00 USD Withdraw Via Bank Payment', 'withdraw', '2023-02-07 12:29:55', NULL),
(17, 1, '100.00000000', '0.00000000', '1140.00000000', '+', 'H4NF71NUS9YT', '100.00 USD Refunded from withdrawal rejection', 'withdraw_reject', '2023-02-07 12:31:56', NULL),
(18, 1, '100.00000000', '2.00000000', '1040.00000000', '-', 'NTUKWGKF535A', '98.00 USD Withdraw Via Bank Payment', 'withdraw', '2023-02-07 12:32:38', NULL),
(19, 1, '1000.00000000', '11.00000000', '2040.00000000', '+', 'SQ264687A4XX', 'Deposited via Stripe Hosted - USD', 'deposit', '2023-02-08 09:04:27', NULL),
(20, 1, '100.00000000', '2.00000000', '1940.00000000', '-', 'ETJAPZOC98QK', '98.00 USD Withdraw Via Bank Payment', 'withdraw', '2023-02-09 10:59:18', NULL),
(21, 1, '100.00000000', '0.00000000', '2040.00000000', '+', 'ETJAPZOC98QK', '100.00 USD Refunded from withdrawal rejection', 'withdraw_reject', '2023-02-09 11:23:25', NULL),
(22, 1, '10.00000000', '1.10000000', '2050.00000000', '+', '2MF7PV8AMUT8', 'Deposited via Stripe Hosted - USD', 'deposit', '2023-02-12 06:56:53', NULL),
(23, 1, '10.00000000', '1.10000000', '2040.00000000', '-', 'JU8ZCT75OGB7', '8.90 USD Withdraw Via Bank Payment', 'withdraw', '2023-02-12 07:01:11', NULL),
(24, 1, '10.00000000', '1.10000000', '2030.00000000', '-', 'FOGAW6GASVG4', '8.90 USD Withdraw Via Basic', 'withdraw', '2023-02-12 07:01:30', NULL),
(25, 1, '10.00000000', '1.10000000', '2020.00000000', '-', '8NPH8YZB2P86', '8.90 USD Withdraw Via Payment', 'withdraw', '2023-02-12 07:01:44', NULL),
(26, 1, '10.00000000', '0.00000000', '2030.00000000', '+', 'JU8ZCT75OGB7', '10.00 USD Refunded from withdrawal rejection', 'withdraw_reject', '2023-02-12 07:02:02', NULL),
(27, 1, '10.00000000', '1.10000000', '2040.00000000', '+', 'TRMNXXEB2C2K', 'Deposited via Mobile Payment', 'deposit', '2023-02-12 09:19:52', NULL),
(28, 1, '10.00000000', '1.20000000', '2050.00000000', '+', '3BAONWST19GT', 'Deposited via Payment', 'deposit', '2023-02-13 09:24:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_withdrawals`
--

CREATE TABLE `wp_viser_withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_withdrawals`
--

INSERT INTO `wp_viser_withdrawals` (`id`, `method_id`, `user_id`, `amount`, `currency`, `rate`, `charge`, `trx`, `final_amount`, `after_charge`, `withdraw_information`, `status`, `admin_feedback`, `created_at`, `updated_at`) VALUES
(1, 18, 1, '10.00000000', 'USD', '1.00000000', '1.10000000', 'JU8ZCT75OGB7', '8.90000000', '8.90000000', 'a:1:{i:0;a:3:{s:4:\"name\";s:10:\"Screenshot\";s:4:\"type\";s:4:\"file\";s:5:\"value\";s:38:\"2023/02/12/63e88eb7b43421676185271.png\";}}', 3, 'adsfasdfasdf', '2023-02-12 07:01:06', '2023-02-12 07:02:02'),
(2, 19, 1, '10.00000000', 'USD', '1.00000000', '1.10000000', 'FOGAW6GASVG4', '8.90000000', '8.90000000', 'a:1:{i:0;a:3:{s:4:\"name\";s:9:\"Bank Name\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"World Bank\";}}', 2, NULL, '2023-02-12 07:01:27', '2023-02-12 07:01:27'),
(3, 20, 1, '10.00000000', 'USD', '1.00000000', '1.10000000', '8NPH8YZB2P86', '8.90000000', '8.90000000', 'a:1:{i:0;a:3:{s:4:\"name\";s:9:\"Bank Name\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"World Bank\";}}', 1, 'asdfasdfgasdfg', '2023-02-12 07:01:40', '2023-02-12 07:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `wp_viser_withdraw_methods`
--

CREATE TABLE `wp_viser_withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) DEFAULT 0.00000000,
  `rate` decimal(28,8) DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_viser_withdraw_methods`
--

INSERT INTO `wp_viser_withdraw_methods` (`id`, `form_id`, `name`, `min_limit`, `max_limit`, `fixed_charge`, `rate`, `percent_charge`, `currency`, `description`, `status`, `created_at`, `updated_at`) VALUES
(18, 55, 'Bank Payment', '1.00000000', '1000.00000000', '1.00000000', '1.00000000', '1.00', 'USD', 'This is a description', 1, '2023-02-01 10:50:26', '2023-02-01 10:50:26'),
(19, 59, 'Basic', '1.00000000', '1000.00000000', '1.00000000', '1.00000000', '1.00', 'USD', 'This is a withdraw method description', 1, '2023-02-02 09:47:59', '2023-02-02 09:47:59'),
(20, 67, 'Payment', '1.00000000', '1000.00000000', '1.00000000', '1.00000000', '1.00', 'USD', 'Qui quasi sed magna .', 1, '2023-02-09 11:52:16', '2023-02-09 11:52:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_viser_deposits`
--
ALTER TABLE `wp_viser_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_extensions`
--
ALTER TABLE `wp_viser_extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_forms`
--
ALTER TABLE `wp_viser_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_gateways`
--
ALTER TABLE `wp_viser_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_gateway_currencies`
--
ALTER TABLE `wp_viser_gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_notification_templates`
--
ALTER TABLE `wp_viser_notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_support_attachments`
--
ALTER TABLE `wp_viser_support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_support_messages`
--
ALTER TABLE `wp_viser_support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_support_tickets`
--
ALTER TABLE `wp_viser_support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_transactions`
--
ALTER TABLE `wp_viser_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_withdrawals`
--
ALTER TABLE `wp_viser_withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_viser_withdraw_methods`
--
ALTER TABLE `wp_viser_withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_viser_deposits`
--
ALTER TABLE `wp_viser_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp_viser_extensions`
--
ALTER TABLE `wp_viser_extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp_viser_forms`
--
ALTER TABLE `wp_viser_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `wp_viser_gateways`
--
ALTER TABLE `wp_viser_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `wp_viser_gateway_currencies`
--
ALTER TABLE `wp_viser_gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `wp_viser_notification_templates`
--
ALTER TABLE `wp_viser_notification_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wp_viser_support_attachments`
--
ALTER TABLE `wp_viser_support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wp_viser_support_messages`
--
ALTER TABLE `wp_viser_support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `wp_viser_support_tickets`
--
ALTER TABLE `wp_viser_support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wp_viser_transactions`
--
ALTER TABLE `wp_viser_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `wp_viser_withdrawals`
--
ALTER TABLE `wp_viser_withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wp_viser_withdraw_methods`
--
ALTER TABLE `wp_viser_withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
