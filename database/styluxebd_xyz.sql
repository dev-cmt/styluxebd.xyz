-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2026 at 02:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `styluxebd.xyz`
--

-- --------------------------------------------------------

--
-- Table structure for table `abandoned_carts`
--

CREATE TABLE `abandoned_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `abandoned_item` text DEFAULT NULL,
  `shipping_cost` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `subtotal` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `total` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `source` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abandoned_carts`
--

INSERT INTO `abandoned_carts` (`id`, `theme_id`, `user_id`, `shipping_id`, `customer_name`, `customer_phone`, `customer_address`, `abandoned_item`, `shipping_cost`, `discount`, `subtotal`, `total`, `source`, `status`, `created_at`, `updated_at`) VALUES
(71, 8, NULL, NULL, 'Test Customer', '01767891011', NULL, '{\"dfdf\":{\"product_id\":9,\"qty\":\"1\",\"price\":2300,\"sku\":\"dfdf\",\"variant\":null}}', '80.0000', '0.0000', '2300.0000', '2380.0000', NULL, NULL, '2026-10-10 10:30:25', '2026-10-10 10:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_type` tinyint(4) NOT NULL COMMENT '1=Bank; 2=Bkash; 3=Nagad; 4=Rocket',
  `bkash_no` varchar(255) DEFAULT NULL,
  `rocket_no` varchar(255) DEFAULT NULL,
  `nagad_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `routing_no` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `balance` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_default` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type`, `bkash_no`, `rocket_no`, `nagad_no`, `bank_name`, `branch_name`, `routing_no`, `bank_account_no`, `bank_account_name`, `balance`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3000.0000', 1, 1, '2026-10-08 05:10:52', '2026-10-10 09:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `account_transactions`
--

CREATE TABLE `account_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `transaction_type` tinyint(4) DEFAULT NULL COMMENT '0=Cash In; 1=Cash Out',
  `purpose` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_transactions`
--

INSERT INTO `account_transactions` (`id`, `account_id`, `purchase_id`, `expense_id`, `order_id`, `amount`, `transaction_type`, `purpose`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, '100000.0000', 0, 'New account created.', '2026-10-08 05:10:52', '2026-10-08 05:10:52'),
(2, 1, 1, NULL, NULL, '3500.0000', 1, 'Purchase Payment (Memo: MEMO-1)', '2026-10-08 05:18:53', '2026-10-08 05:18:53'),
(3, 1, 2, NULL, NULL, '2500.0000', 1, 'Purchase Due Payment (Memo: MEMO-2)', '2026-10-08 05:20:00', '2026-10-08 05:20:00'),
(4, 1, 2, NULL, NULL, '2500.0000', 1, 'Purchase Due Payment (Memo: MEMO-2)', '2026-10-08 05:21:02', '2026-10-08 05:21:02'),
(5, 1, 3, NULL, NULL, '1500.0000', 1, 'Purchase Due Payment (Memo: MEMO-3)', '2026-10-08 05:25:37', '2026-10-08 05:25:37'),
(6, 1, 5, NULL, NULL, '5000.0000', 1, 'Purchase Payment (Memo: MEMO-5)', '2026-10-08 05:32:30', '2026-10-08 05:32:30'),
(7, 1, 6, NULL, NULL, '3000.0000', 1, 'Initial Purchase Payment (Memo: MEMO-6)', '2026-10-08 05:43:54', '2026-10-08 05:43:54'),
(8, 1, 1, NULL, NULL, '3500.0000', 1, 'Initial Purchase Payment (Memo: MEMO-1)', '2026-10-08 05:48:41', '2026-10-08 05:48:41'),
(9, 1, 2, NULL, NULL, '500.0000', 1, 'Initial Purchase Payment (Memo: MEMO-2)', '2026-10-08 05:49:51', '2026-10-08 05:49:51'),
(10, 1, 2, NULL, NULL, '500.0000', 1, 'Additional Payment during Update (Memo: MEMO-2)', '2026-10-08 05:51:03', '2026-10-08 05:51:03'),
(11, 1, 2, NULL, NULL, '2500.0000', 1, 'Purchase Due Payment (Memo: MEMO-2)', '2026-10-08 05:51:43', '2026-10-08 05:51:43'),
(12, 1, 1, NULL, NULL, '8500.0000', 1, 'Purchase Due Payment (Memo: MEMO-1)', '2026-10-08 12:30:12', '2026-10-08 12:30:12'),
(13, 1, 1, NULL, NULL, '3500.0000', 1, 'Purchase Due Payment (Memo: MEMO-1)', '2026-10-10 08:57:18', '2026-10-10 08:57:18'),
(14, 1, 2, NULL, NULL, '60000.0000', 1, 'Purchase Due Payment (Memo: MEMO-2)', '2026-10-10 09:26:28', '2026-10-10 09:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` tinyint(4) DEFAULT NULL,
  `role_id` tinyint(4) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_order_assign` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `theme_id`, `role_id`, `role`, `name`, `email`, `phone`, `image`, `email_verified_at`, `password`, `status`, `is_order_assign`, `token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'super_admin', 'Super admin', 'super_admin@gmail.com', NULL, NULL, NULL, '$2y$10$Yknq654uqbuGzajJX9fzMO.DWpWFcgKMjQpY5ZkLvCqHuEhSP510O', 1, 0, NULL, NULL, '2025-09-27 05:16:58', '2025-09-27 05:16:58'),
(7, NULL, 4, 'Admin', 'Md. Fazlur Rahman', 'admin@gmail.com', NULL, NULL, NULL, '$2y$10$V/0Nt592IsBU3BzoDuefV.stMKFxccgB/wCrqBV5OD5L8544iU66C', 1, 0, NULL, NULL, '2026-08-08 19:23:51', '2026-08-20 05:01:04'),
(8, NULL, 4, 'Admin', 'Arnab (KTI)', 'arnab@gmail.com', '01896050915', NULL, NULL, '$2y$10$XDfBaxJSQd7.b0GujDokXubvXBVNJKI2HWr6m9tPNebbCmHZtq6pS', 1, 0, NULL, NULL, '2026-08-20 05:00:22', '2026-08-20 05:00:22'),
(9, NULL, 3, 'Employee', 'Office', 'genesisfashionwear2008@gmail.com', '01348969023', NULL, NULL, '$2y$10$Z/KGL53JdvpzlsdsTITt3eHxME62.DJuqPnRZ7kHuzakdDvypGNiO', 1, 1, NULL, NULL, '2026-09-06 13:36:53', '2026-09-08 13:30:00'),
(14, NULL, 3, 'Employee', 'Employee', 'employee@gmail.com', NULL, NULL, NULL, '$2y$10$xbzQuBWedhQzahtEmaGn1.9LZIn4zjlRguY6uMyAh5Yq633T2QdHe', 1, 1, NULL, NULL, '2026-10-05 08:23:56', '2026-10-05 08:23:56');

-- --------------------------------------------------------

--
-- Table structure for table `api_couriers`
--

CREATE TABLE `api_couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courier_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `base_url` text DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_couriers`
--

INSERT INTO `api_couriers` (`id`, `courier_name`, `status`, `base_url`, `username`, `password`, `config`, `created_at`, `updated_at`) VALUES
(1, 'pathao', 1, 'https://api-hermes.pathao.com', 'frahman010@gmail.com', 'Styluxebd#123', '{\"store_id\":\"336546\",\"client_id\":\"lNbWpXxdyg\",\"client_secret\":\"6UV9ofnggEjD2E6HxRhnk7tDsyS8fI4kXQCelqre\",\"access_token\":\"eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzNjc2MDUiLCJhdWQiOlsiMjYxNzQiXSwiZXhwIjoxNzk2Mzg2NzM3LCJuYmYiOjE3ODg2MTA3MzcsImlhdCI6MTc4ODYxMDczNywianRpIjoiMTRmMTA1MDZmMmFjMWY0MDdiYjVlZmI4YTdmODRiYjU4MDNhYzI0NTBhMWE4ZjI3YjQ5OGEyZTVmNDkzN2YwYSIsIm1lcmNoYW50X2lkIjoiWDdheHZZZ0pkeSIsInNjb3BlcyI6W119.sJOw9_tB95EOYKOn_fyqo5igCwTYxqaFPhsr_UHJZilca3Mt0JJm26KPpJm_ipYLQjNoFhqNhwhVJBgOEctSnARiFRIF9zDaLrG7urP4G0sg1GPdKWOKkpNU24nrRt4bPgnMiMY7_K2tB7jWjue-d-2Qt2ve8yoh3cSXhnT3IBb-vyWHpkJ-CUfoSlHWkgX-tnWkT5Uqwu3_hhk1bLM6tkgWQpMJIvfDNw_uWbtuZBSpDlt_yBYdXrpv3U0sDoHNcuR9Xa218vr73fc59dV8vSXMHVUAHy9ik235EzeZUcmGPGgPiq1CoHZZCFE91ELqVQKLSohoPhMQXVzLbd62ig0FTeCCDHKOMxO8VslB84IltK3Ri_DLwso6VmX968-fCdYn12n-sJUTfUcXTgdYxFeBOSJuuC-l_VTMDAK3MW-ubrkKjliTBMCHoXDKuh8HuZGq5F8ExSJm0EYboiGjFIyRS5kEH3ZqAouJZuqFdjwP01aB_YpsChiyVcTBp6Snm6DEXP0BXBWym39JRIbqxFi7Ut2tukCKRygfBgxhu3fBY_LVkbtVQiEf09lPJgxvyG3t9YgSlWn3YSxXE-2qZRUiK89aovQRw22T6xrD5aZamSmg55p2eAGJ20XA5rB8mLRwKi4eV2eF6-xNVnaPjQB3Jl-MGYqktvcjEwO7qLQ\",\"refresh_token\":\"def502000e21d7dad34eba41342db9d9ce8c8d1cceb5c49e89f3d032c90348103b0340febbb67ffce35f68796261fe4c3e9eee391f5c13858719f9fdee91e5b978fcf67ba937e348da30a68b622ed8a86f3412ba8bbdb6620c98dc24c794319a2b43353000ec2d85edb7058e10ee17f83437bbe860eed3b7c68072f0ad7854fad4e36f79360ab3348ccb140c11b94fe2acfb876963787f1d0bd10083c40d5495a9ecdb16965318fec1d0abb789ab257aee3e40ed1d1b7c6a65343925a13441dfa5df44fb857b35fb2e80aa2202b53042e62c9a51fdef1d525347476c84745f59058f2acd95964e112e6d3885930754bb314c5b4907c98012b39894658fb90c8686c2e30e57523b4a4055250665bc64386c11627ff5d47c61e078c25ebd7f444f42b52cab6645d8ef41d55dfff35f9695b605e4860a4764a2d84cd1c8e3d753e25b5d43ee226046794ecfa1b07277976aa6a1ba2e2af76d1d5ada9692\"}', '2025-11-25 23:53:45', '2026-09-05 12:18:58'),
(2, 'steadfast', 1, 'https://portal.packzy.com/api/v1', 'styluxebd890@gmail.com', 'Styluxebd#123', '{\"api_key\":\"7bnumbsc0q3cy3u8vuyzxfviyqnhidrw\",\"secret_key\":\"i1mqwvabjxghx7vjn2kmqgr4\"}', '2025-11-26 00:42:58', '2026-09-05 12:14:46'),
(3, 'redx', 1, NULL, '01972431245', 'Frodly2025_$', '{\"api_token\":null}', '2025-11-26 00:51:30', '2025-11-26 00:51:30'),
(4, 'carrybee', 0, NULL, '01627910111', 'Styluxebd#123', '{\"store_id\":null,\"client_id\":null,\"client_secret\":null,\"client_context\":null}', '2026-09-05 11:51:19', '2026-09-05 11:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_image` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `slug`, `status`, `is_image`, `created_at`, `updated_at`) VALUES
(1, 'Color', 'color', NULL, 1, '2026-08-08 13:12:49', '2026-08-08 13:12:49'),
(2, 'Size', 'size', NULL, 0, '2026-08-10 06:33:40', '2026-08-10 06:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_items`
--

CREATE TABLE `attribute_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_items`
--

INSERT INTO `attribute_items` (`id`, `attribute_id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'black', NULL, NULL, '2026-08-09 16:20:50', '2026-08-09 16:20:50'),
(2, 2, '30 & 31', '30-31', NULL, '2026-08-10 06:34:10', '2026-08-10 06:38:18'),
(3, 2, '32 & 33', '32-33', NULL, '2026-08-10 06:34:19', '2026-08-10 06:38:24'),
(4, 2, '34 & 35', '34-35', NULL, '2026-08-10 06:34:33', '2026-08-10 06:38:30'),
(5, 2, '36 & 37', '36-37', NULL, '2026-08-10 06:34:39', '2026-08-10 06:38:36'),
(6, 2, '38 & 39', '38-39', NULL, '2026-08-10 06:34:46', '2026-08-10 06:38:41'),
(7, 1, 'Ash Gray', 'ash-gray', NULL, '2026-08-10 06:34:58', '2026-08-26 12:06:13'),
(8, 1, 'Olive Green', 'olive-green', NULL, '2026-08-10 06:35:06', '2026-08-10 06:35:06'),
(9, 1, 'Beige', 'beige', NULL, '2026-08-10 06:35:14', '2026-08-10 06:35:14'),
(10, 2, '30', '30', NULL, '2026-08-13 05:27:40', '2026-08-13 05:27:40'),
(11, 2, '32', '32', NULL, '2026-08-13 05:27:46', '2026-08-13 05:27:46'),
(12, 2, '34', '34', NULL, '2026-08-13 05:27:52', '2026-08-13 05:27:52'),
(13, 2, '36', '36', NULL, '2026-08-13 05:27:58', '2026-08-13 05:27:58'),
(14, 2, '38', '38', NULL, '2026-08-13 05:28:04', '2026-08-13 05:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_section_id` bigint(20) UNSIGNED NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner_sections`
--

CREATE TABLE `banner_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` bigint(20) UNSIGNED NOT NULL,
  `section` varchar(255) NOT NULL,
  `max_items` int(11) NOT NULL DEFAULT 1,
  `height` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_sections`
--

INSERT INTO `banner_sections` (`id`, `theme_id`, `section`, `max_items`, `height`, `width`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 'middle', 2, 400, 1200, 1, '2026-08-08 13:12:27', '2026-08-08 13:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `carrybee_cities`
--

CREATE TABLE `carrybee_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carrybee_zones`
--

CREATE TABLE `carrybee_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(100) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `is_show_home` int(11) DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `extra_fields` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `theme_id`, `position`, `slug`, `category_name`, `file_url`, `is_show_home`, `status`, `extra_fields`, `created_at`, `updated_at`) VALUES
(2, NULL, 8, 0, 'ice-silk-pant', 'Ice Silk Pant', 'uploads/category/6a7799a6b35e8.webp', 1, 1, '{\"is_top_category\":\"0\"}', '2026-08-08 20:59:58', '2026-09-08 14:18:26'),
(3, NULL, 8, 0, '06-pocket-cargo-joggers', '06 Pocket Cargo Joggers', 'uploads/category/6a796e0188c96.webp', 1, 1, '{\"is_top_category\":\"0\"}', '2026-08-10 06:21:22', '2026-09-08 14:17:59'),
(4, NULL, 8, 0, 'straight-cut-cargo-pants', 'Straight Cut Cargo Pants', 'uploads/category/6a8ed33928db1.webp', 1, 1, '{\"is_top_category\":\"0\"}', '2026-08-26 11:51:21', '2026-09-08 14:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `category_products`
--

CREATE TABLE `category_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_products`
--

INSERT INTO `category_products` (`id`, `category_id`, `product_id`) VALUES
(1, 3, 1),
(2, 4, 2),
(3, 3, 3),
(4, 2, 4),
(5, 3, 9),
(6, 3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `combo_products`
--

CREATE TABLE `combo_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `combo_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `regular_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `sale_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `combo_products`
--

INSERT INTO `combo_products` (`id`, `combo_product_id`, `product_id`, `purchase_price`, `regular_price`, `sale_price`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 4, 1, '0.0000', '1500.0000', '1000.0000', 1, '2026-10-07 06:14:56', '2026-10-07 06:14:56'),
(4, 4, 2, '0.0000', '2000.0000', '1500.0000', 1, '2026-10-07 06:14:56', '2026-10-07 06:14:56'),
(5, 9, 2, '500.0000', '2000.0000', '1500.0000', 1, '2026-10-10 04:31:41', '2026-10-10 04:31:41'),
(6, 9, 3, '250.0000', '1200.0000', '800.0000', 1, '2026-10-10 04:31:41', '2026-10-10 04:31:41'),
(7, 10, 3, '250.0000', '1200.0000', '800.0000', 1, '2026-10-10 10:37:50', '2026-10-10 10:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `conversion_apis`
--

CREATE TABLE `conversion_apis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percentage') NOT NULL DEFAULT 'fixed',
  `amount` decimal(10,2) NOT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `min_purchase` decimal(10,2) NOT NULL DEFAULT 0.00,
  `apply_on` enum('cart','product','shipping','payment','first_time') NOT NULL DEFAULT 'cart',
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `payment_method` varchar(255) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `per_user_limit` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `amount`, `max_discount`, `min_purchase`, `apply_on`, `product_ids`, `payment_method`, `usage_limit`, `used_count`, `per_user_limit`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Culpa aut esse aut', 'percentage', '61.00', NULL, '67.00', 'first_time', NULL, 'cod', 87, 0, 26, '1989-07-26', '2019-11-20', 0, '2026-10-05 08:47:54', '2026-10-05 08:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_users`
--

CREATE TABLE `coupon_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courier_name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `courier_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SteadFast', 1, '2025-10-07 11:28:42', '2025-11-02 09:12:42'),
(2, 'Pathao', 1, '2025-10-07 11:35:43', '2025-10-07 11:35:43'),
(3, 'Redx', 1, '2025-11-26 10:42:49', '2025-10-07 11:35:43'),
(4, 'CarryBee', 1, '2025-11-26 10:42:49', '2025-10-07 11:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `courier_cities`
--

CREATE TABLE `courier_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courier_id` int(11) NOT NULL,
  `courier_name` varchar(255) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courier_zones`
--

CREATE TABLE `courier_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courier_id` int(11) NOT NULL,
  `courier_name` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `zone_name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tracks`
--

CREATE TABLE `device_tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `device_tracks`
--

INSERT INTO `device_tracks` (`id`, `device_id`, `user_id`, `device_name`, `device_type`, `status`, `created_at`, `updated_at`) VALUES
(1, '3j13HRBV4WfkBSJa', NULL, 'Windows 10 - Chrome', 'Desktop', 1, '2026-08-08 21:10:52', '2026-08-08 21:10:52'),
(2, '4Q4wBIuGuXSdFW8x', 3, 'Windows 10 - Chrome', 'Desktop', 1, '2026-08-19 07:08:32', '2026-08-31 13:19:36'),
(3, 'G5cGHWKwKAqytN7G', 4, 'Mac OS X - Chrome', 'Desktop', 1, '2026-08-19 07:22:31', '2026-08-19 07:23:30'),
(4, 'O4qLgJfaDS262tSI', NULL, 'Android - Chrome', 'Mobile', 1, '2026-08-19 17:38:15', '2026-08-19 17:38:15'),
(5, '8YQQA4g3iECJq5eR', NULL, 'Android - Chrome', 'Mobile', 1, '2026-08-22 12:02:39', '2026-08-22 12:02:39'),
(6, 'Sx1FGtZyYX7CGCGg', NULL, 'Mac OS X - Safari', 'Mobile', 1, '2026-08-22 15:06:12', '2026-08-22 15:06:12'),
(7, '8B5UADaHdIETFbuX', NULL, 'Mac OS X - Safari', 'Mobile', 1, '2026-08-24 11:17:38', '2026-08-24 11:17:38'),
(8, 'w5cQaxVY9j9RxlBu', NULL, 'Android - Chrome', 'Mobile', 1, '2026-08-24 12:14:02', '2026-08-24 12:14:02'),
(9, 'zOJsiTnxs7HNmmfw', NULL, 'Android - Chrome', 'Mobile', 1, '2026-08-24 17:12:20', '2026-08-24 17:12:20'),
(10, '2dx8cMgvRh6SoTGt', 16, 'Windows 10 - Chrome', 'Desktop', 1, '2026-09-01 05:21:32', '2026-09-06 12:17:55'),
(11, '8t9TvXJSKCX6aE4P', NULL, 'Android - Chrome', 'Mobile', 1, '2026-09-05 06:20:04', '2026-09-05 06:20:04'),
(12, 'CqecDZ0M8wcSi53s', NULL, 'Windows 10 - Chrome', 'Desktop', 1, '2026-09-05 07:03:24', '2026-09-05 07:03:24'),
(13, '5coXjHta6DgrEPuY', 13, 'Windows 10 - Chrome', 'Desktop', 1, '2026-09-06 13:21:02', '2026-09-06 13:21:02'),
(14, 'wR9Wz1hSE7SAfn2p', 17, 'Windows 10 - Chrome', 'Desktop', 1, '2026-09-26 06:30:44', '2026-10-10 10:58:57');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Fixed Asset', 1, '2026-10-10 11:06:39', '2026-10-10 11:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_deals`
--

CREATE TABLE `flash_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_deal_products`
--

CREATE TABLE `flash_deal_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_deal_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_page_settings`
--

CREATE TABLE `home_page_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_page_settings`
--

INSERT INTO `home_page_settings` (`id`, `theme_id`, `section`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'top-header', '{\"free_shipping\":\"\\u201c\\u0995\\u09ae\\u09ab\\u09cb\\u09b0\\u09cd\\u099f, \\u09b8\\u09cd\\u099f\\u09be\\u0987\\u09b2 & \\u09aa\\u09be\\u09b0\\u09ab\\u09c7\\u0995\\u09cd\\u099f \\u09ab\\u09bf\\u099f \\u2014 \\u09b8\\u09c7\\u09b0\\u09be \\u0986\\u09a8\\u09cd\\u09a1\\u09be\\u09b0\\u0997\\u09be\\u09b0\\u09cd\\u09ae\\u09c7\\u09a8\\u09cd\\u099f\\u09b8 \\u098f\\u0996\\u09a8 \\u0998\\u09b0\\u09c7 \\u09ac\\u09b8\\u09c7\\u0987 \\u09aa\\u09be\\u099a\\u09cd\\u099b\\u09c7\\u09a8!\\u201d\"}', 0, '2026-02-11 06:43:49', '2026-02-11 06:43:49'),
(2, 9, 'footer', '{\"newsletter_text\":null,\"payment_url\":\"payment\\/1770813875_1770785478_ssl banner.webp\"}', 0, '2026-02-11 06:44:35', '2026-02-11 06:44:35'),
(3, 8, 'footer', '{\"newsletter_text\":null,\"payment_url\":\"payment\\/1770814082_1770711522_payment-item.png.webp\"}', 0, '2026-02-11 06:45:04', '2026-02-11 06:48:02'),
(4, 8, 'top-header', '{\"free_shipping\":\"\\u201c\\u0995\\u09ae\\u09ab\\u09cb\\u09b0\\u09cd\\u099f, \\u09b8\\u09cd\\u099f\\u09be\\u0987\\u09b2 & \\u09aa\\u09be\\u09b0\\u09ab\\u09c7\\u0995\\u09cd\\u099f \\u09ab\\u09bf\\u099f \\u2014 \\u09b8\\u09c7\\u09b0\\u09be \\u0986\\u09a8\\u09cd\\u09a1\\u09be\\u09b0\\u0997\\u09be\\u09b0\\u09cd\\u09ae\\u09c7\\u09a8\\u09cd\\u099f\\u09b8 \\u098f\\u0996\\u09a8 \\u0998\\u09b0\\u09c7 \\u09ac\\u09b8\\u09c7\\u0987 \\u09aa\\u09be\\u099a\\u09cd\\u099b\\u09c7\\u09a8!\\u201d\"}', 0, '2026-02-11 06:45:09', '2026-02-11 06:45:09'),
(5, 13, 'top-header', '{\"free_shipping\":\"\\u201c\\u0995\\u09ae\\u09ab\\u09cb\\u09b0\\u09cd\\u099f, \\u09b8\\u09cd\\u099f\\u09be\\u0987\\u09b2 & \\u09aa\\u09be\\u09b0\\u09ab\\u09c7\\u0995\\u09cd\\u099f \\u09ab\\u09bf\\u099f \\u2014 \\u09b8\\u09c7\\u09b0\\u09be \\u0986\\u09a8\\u09cd\\u09a1\\u09be\\u09b0\\u0997\\u09be\\u09b0\\u09cd\\u09ae\\u09c7\\u09a8\\u09cd\\u099f\\u09b8 \\u098f\\u0996\\u09a8 \\u0998\\u09b0\\u09c7 \\u09ac\\u09b8\\u09c7\\u0987 \\u09aa\\u09be\\u099a\\u09cd\\u099b\\u09c7\\u09a8!\\u201d\"}', 0, '2026-02-11 06:46:09', '2026-02-11 06:46:09'),
(6, 13, 'footer', '{\"newsletter_text\":null,\"payment_url\":\"payment\\/1770814011_1770711522_payment-item.png.webp\"}', 0, '2026-02-11 06:46:16', '2026-02-11 06:46:51'),
(7, 14, 'footer', '{\"newsletter_text\":null,\"payment_url\":\"payment\\/1771131836_ssl banner.webp\"}', 0, '2026-02-14 23:03:56', '2026-02-14 23:03:56'),
(8, 1, 'footer', '{\"newsletter_text\":null,\"payment_url\":\"payment\\/1771819488_ssl banner.webp\"}', 0, '2026-02-22 22:04:48', '2026-02-22 22:04:48'),
(9, 1, 'hero', '{\"call_support_text\":null,\"marquee_text\":\"Test Product marquee\"}', 0, '2026-03-08 12:00:21', '2026-03-08 12:00:21'),
(10, 1, 'top-header', '{\"free_shipping\":\"Free Shipping upto 500tk purchase\"}', 0, '2026-03-08 12:16:22', '2026-03-08 12:16:22');

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `total_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=block; 1=unblock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ip_addresses`
--

INSERT INTO `ip_addresses` (`id`, `ip_address`, `total_order`, `status`, `created_at`, `updated_at`) VALUES
(1, '::1', 29, 1, '2026-08-04 11:05:49', '2026-10-10 11:04:01'),
(2, '45.250.230.69', 1, 1, '2026-08-08 21:10:52', '2026-08-08 21:10:52'),
(3, '103.102.206.163', 3, 1, '2026-08-19 07:08:32', '2026-08-19 07:16:05'),
(4, '103.102.206.149', 4, 1, '2026-08-19 07:22:31', '2026-09-06 12:17:55'),
(5, '202.125.68.185', 1, 1, '2026-08-19 17:38:15', '2026-08-19 17:38:15'),
(6, '36.255.80.162', 1, 1, '2026-08-22 12:02:39', '2026-08-22 12:02:39'),
(7, '37.111.210.133', 1, 1, '2026-08-22 15:06:12', '2026-08-22 15:06:12'),
(8, '42.0.7.78', 1, 1, '2026-08-24 11:17:38', '2026-08-24 11:17:38'),
(9, '37.111.242.162', 1, 1, '2026-08-24 12:14:02', '2026-08-24 12:14:02'),
(10, '37.111.212.98', 1, 1, '2026-08-24 17:12:20', '2026-08-24 17:12:20'),
(11, '103.102.206.162', 1, 1, '2026-08-31 13:19:36', '2026-08-31 13:19:36'),
(12, '103.142.68.251', 3, 1, '2026-09-05 06:20:04', '2026-09-06 13:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `landing_categories`
--

CREATE TABLE `landing_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `style` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`style`)),
  `theme_id` bigint(20) UNSIGNED NOT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landing_themes`
--

CREATE TABLE `landing_themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '1=800x800, 2=180x180, 3=1110x280',
  `file_original_name` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `type`, `file_original_name`, `file_url`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '0', '68b2edf23b77e.png', 'uploads/6a77872844f31.png', 7, '2026-08-08 19:44:40', '2026-08-08 19:44:40'),
(2, '3', 'C Banner-01.jpg', 'uploads/6a7787aac678a_1920x800.webp', 7, '2026-08-08 19:46:51', '2026-08-08 19:46:51'),
(3, '1', '69d9e29d006c4_800x800', 'uploads/6a779950ebf53_1000x1000.webp', 7, '2026-08-08 21:02:09', '2026-08-08 21:02:09'),
(4, '1', '69d9e29d269fd_800x800', 'uploads/6a77995116c51_1000x1000.webp', 7, '2026-08-08 21:02:09', '2026-08-08 21:02:09'),
(5, '1', '69d9e29d1778d_800x800', 'uploads/6a77995129214_1000x1000.webp', 7, '2026-08-08 21:02:09', '2026-08-08 21:02:09'),
(6, '1', 'photo edit 3.1', 'uploads/6a796e7da9fff_1000x1000.webp', 7, '2026-08-10 06:23:57', '2026-08-10 06:23:57'),
(7, '1', 'photo edit 3.2', 'uploads/6a796e7dc9208_1000x1000.webp', 7, '2026-08-10 06:23:57', '2026-08-10 06:23:57'),
(8, '1', 'photo edit 3.3', 'uploads/6a796e7ddd76d_1000x1000.webp', 7, '2026-08-10 06:23:57', '2026-08-10 06:23:57'),
(9, '1', 'photo edit 3.4', 'uploads/6a796e7df30f0_1000x1000.webp', 7, '2026-08-10 06:23:58', '2026-08-10 06:23:58'),
(10, '1', 'photo edit 2.3', 'uploads/6a7970afc0c76_1000x1000.webp', 7, '2026-08-10 06:33:19', '2026-08-10 06:33:19'),
(11, '1', 'photo edit 2.1', 'uploads/6a7970afe4d46_1000x1000.webp', 7, '2026-08-10 06:33:20', '2026-08-10 06:33:20'),
(12, '1', 'photo edit 2.2', 'uploads/6a7970b007bd0_1000x1000.webp', 7, '2026-08-10 06:33:20', '2026-08-10 06:33:20'),
(13, '1', 'photo edit 2.4', 'uploads/6a7970b01ebb7_1000x1000.webp', 7, '2026-08-10 06:33:20', '2026-08-10 06:33:20'),
(14, '1', 'photo edit 4.1', 'uploads/6a7971f209e84_1000x1000.webp', 7, '2026-08-10 06:38:42', '2026-08-10 06:38:42'),
(15, '1', 'photo edit 4.2', 'uploads/6a7971f235547_1000x1000.webp', 7, '2026-08-10 06:38:42', '2026-08-10 06:38:42'),
(16, '1', 'photo edit 4.3', 'uploads/6a7971f24cc9d_1000x1000.webp', 7, '2026-08-10 06:38:42', '2026-08-10 06:38:42'),
(17, '1', 'photo edit 4.4', 'uploads/6a7971f262f6c_1000x1000.webp', 7, '2026-08-10 06:38:42', '2026-08-10 06:38:42'),
(18, '1', 'photo edit 1.4', 'uploads/6a7972b1a1a61_1000x1000.webp', 7, '2026-08-10 06:41:53', '2026-08-10 06:41:53'),
(19, '1', 'photo edit 1.1', 'uploads/6a7972b1dc845_1000x1000.webp', 7, '2026-08-10 06:41:54', '2026-08-10 06:41:54'),
(20, '1', 'photo edit 1.2', 'uploads/6a7972b207067_1000x1000.webp', 7, '2026-08-10 06:41:54', '2026-08-10 06:41:54'),
(21, '1', 'photo edit 1.3', 'uploads/6a7972b223fef_1000x1000.webp', 7, '2026-08-10 06:41:54', '2026-08-10 06:41:54'),
(22, '1', '3 combo 1.2', 'uploads/6a79744e69a35_1000x1000.webp', 7, '2026-08-10 06:48:46', '2026-08-10 06:48:46'),
(23, '1', 'photo edit 1.1', 'uploads/6a79744e8749b_1000x1000.webp', 7, '2026-08-10 06:48:46', '2026-08-10 06:48:46'),
(24, '1', 'photo edit 1.2', 'uploads/6a79744e9a425_1000x1000.webp', 7, '2026-08-10 06:48:46', '2026-08-10 06:48:46'),
(25, '1', 'photo edit 1.3', 'uploads/6a79744eaddd3_1000x1000.webp', 7, '2026-08-10 06:48:46', '2026-08-10 06:48:46'),
(26, '1', 'photo edit 1.4', 'uploads/6a79744ec16fb_1000x1000.webp', 7, '2026-08-10 06:48:46', '2026-08-10 06:48:46'),
(27, '1', 'photo edit 2.1', 'uploads/6a79744ed677f_1000x1000.webp', 7, '2026-08-10 06:48:46', '2026-08-10 06:48:46'),
(28, '1', 'photo edit 2.2', 'uploads/6a79744eefa96_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(29, '1', 'photo edit 2.3', 'uploads/6a79744f10b58_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(30, '1', 'photo edit 2.4', 'uploads/6a79744f26ed2_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(31, '1', 'photo edit 3.1', 'uploads/6a79744f3c452_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(32, '1', 'photo edit 3.2', 'uploads/6a79744f50b73_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(33, '1', 'photo edit 3.3', 'uploads/6a79744f666d6_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(34, '1', 'photo edit 3.4', 'uploads/6a79744f7bcf6_1000x1000.webp', 7, '2026-08-10 06:48:47', '2026-08-10 06:48:47'),
(35, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a798c764c92a_1000x1000.webp', 7, '2026-08-10 08:31:50', '2026-08-10 08:31:50'),
(36, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a798c76885d3_1000x1000.webp', 7, '2026-08-10 08:31:50', '2026-08-10 08:31:50'),
(37, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a798c76b3a5f_1000x1000.webp', 7, '2026-08-10 08:31:50', '2026-08-10 08:31:50'),
(38, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a798c76e3b80_1000x1000.webp', 7, '2026-08-10 08:31:51', '2026-08-10 08:31:51'),
(39, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a798d40347f9_1000x1000.webp', 7, '2026-08-10 08:35:12', '2026-08-10 08:35:12'),
(40, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a798d40b2589_1000x1000.webp', 7, '2026-08-10 08:35:13', '2026-08-10 08:35:13'),
(41, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a798d4102f35_1000x1000.webp', 7, '2026-08-10 08:35:13', '2026-08-10 08:35:13'),
(42, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a798d412f0f8_1000x1000.webp', 7, '2026-08-10 08:35:13', '2026-08-10 08:35:13'),
(43, '1', 'Ice-Silk-Pant-White-color-05', 'uploads/6a798d415400a_1000x1000.webp', 7, '2026-08-10 08:35:13', '2026-08-10 08:35:13'),
(44, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a798da6340cf_1000x1000.webp', 7, '2026-08-10 08:36:54', '2026-08-10 08:36:54'),
(45, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a798da66acf9_1000x1000.webp', 7, '2026-08-10 08:36:54', '2026-08-10 08:36:54'),
(46, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a798da69104c_1000x1000.webp', 7, '2026-08-10 08:36:54', '2026-08-10 08:36:54'),
(47, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a798da6b54c1_1000x1000.webp', 7, '2026-08-10 08:36:54', '2026-08-10 08:36:54'),
(48, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a798e7d71c6d_1000x1000.webp', 7, '2026-08-10 08:40:29', '2026-08-10 08:40:29'),
(49, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a798e7da5e16_1000x1000.webp', 7, '2026-08-10 08:40:29', '2026-08-10 08:40:29'),
(50, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a798e7dcdf67_1000x1000.webp', 7, '2026-08-10 08:40:29', '2026-08-10 08:40:29'),
(51, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a798e7df165e_1000x1000.webp', 7, '2026-08-10 08:40:30', '2026-08-10 08:40:30'),
(52, '1', 'beige,white', 'uploads/6a79933a0484a_1000x1000.webp', 7, '2026-08-10 09:00:42', '2026-08-10 09:00:42'),
(53, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a79933a3b4ff_1000x1000.webp', 7, '2026-08-10 09:00:42', '2026-08-10 09:00:42'),
(54, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a79933a5d296_1000x1000.webp', 7, '2026-08-10 09:00:42', '2026-08-10 09:00:42'),
(55, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a79933a85ca6_1000x1000.webp', 7, '2026-08-10 09:00:42', '2026-08-10 09:00:42'),
(56, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a79933aa873a_1000x1000.webp', 7, '2026-08-10 09:00:42', '2026-08-10 09:00:42'),
(57, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a79933acb908_1000x1000.webp', 7, '2026-08-10 09:00:42', '2026-08-10 09:00:42'),
(58, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a79933aec00f_1000x1000.webp', 7, '2026-08-10 09:00:43', '2026-08-10 09:00:43'),
(59, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a79933b1aed3_1000x1000.webp', 7, '2026-08-10 09:00:43', '2026-08-10 09:00:43'),
(60, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a79933b3c11a_1000x1000.webp', 7, '2026-08-10 09:00:43', '2026-08-10 09:00:43'),
(61, '1', 'black,beige', 'uploads/6a799439059b2_1000x1000.webp', 7, '2026-08-10 09:04:57', '2026-08-10 09:04:57'),
(62, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a7994393ceb7_1000x1000.webp', 7, '2026-08-10 09:04:57', '2026-08-10 09:04:57'),
(63, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a7994395e9ed_1000x1000.webp', 7, '2026-08-10 09:04:57', '2026-08-10 09:04:57'),
(64, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a7994397f9da_1000x1000.webp', 7, '2026-08-10 09:04:57', '2026-08-10 09:04:57'),
(65, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a799439a01c9_1000x1000.webp', 7, '2026-08-10 09:04:57', '2026-08-10 09:04:57'),
(66, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a799439c342d_1000x1000.webp', 7, '2026-08-10 09:04:57', '2026-08-10 09:04:57'),
(67, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a799439e7cc1_1000x1000.webp', 7, '2026-08-10 09:04:58', '2026-08-10 09:04:58'),
(68, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a79943a1c039_1000x1000.webp', 7, '2026-08-10 09:04:58', '2026-08-10 09:04:58'),
(69, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a79943a3fdaf_1000x1000.webp', 7, '2026-08-10 09:04:58', '2026-08-10 09:04:58'),
(70, '1', 'WHITE, BLACK', 'uploads/6a7996544a689_1000x1000.webp', 7, '2026-08-10 09:13:56', '2026-08-10 09:13:56'),
(71, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a799654a6fc8_1000x1000.webp', 7, '2026-08-10 09:13:56', '2026-08-10 09:13:56'),
(72, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a799654d1726_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(73, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a79965500b46_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(74, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a799655246dd_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(75, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a7996554e085_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(76, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a799655746ab_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(77, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a7996559dabd_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(78, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a799655c15ca_1000x1000.webp', 7, '2026-08-10 09:13:57', '2026-08-10 09:13:57'),
(79, '1', 'black,beige,white', 'uploads/6a7997a556808_1000x1000.webp', 7, '2026-08-10 09:19:33', '2026-08-10 09:19:33'),
(80, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a7997a592a83_1000x1000.webp', 7, '2026-08-10 09:19:33', '2026-08-10 09:19:33'),
(81, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a7997a5b55ab_1000x1000.webp', 7, '2026-08-10 09:19:33', '2026-08-10 09:19:33'),
(82, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a7997a5d7819_1000x1000.webp', 7, '2026-08-10 09:19:34', '2026-08-10 09:19:34'),
(83, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a7997a60e72d_1000x1000.webp', 7, '2026-08-10 09:19:34', '2026-08-10 09:19:34'),
(84, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a7997a63e908_1000x1000.webp', 7, '2026-08-10 09:19:34', '2026-08-10 09:19:34'),
(85, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a7997a6659e2_1000x1000.webp', 7, '2026-08-10 09:19:34', '2026-08-10 09:19:34'),
(86, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a7997a691189_1000x1000.webp', 7, '2026-08-10 09:19:34', '2026-08-10 09:19:34'),
(87, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a7997a6bb18a_1000x1000.webp', 7, '2026-08-10 09:19:34', '2026-08-10 09:19:34'),
(88, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a7997a6e3f57_1000x1000.webp', 7, '2026-08-10 09:19:35', '2026-08-10 09:19:35'),
(89, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a7997a71554c_1000x1000.webp', 7, '2026-08-10 09:19:35', '2026-08-10 09:19:35'),
(90, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a7997a73b294_1000x1000.webp', 7, '2026-08-10 09:19:35', '2026-08-10 09:19:35'),
(91, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a7997a763584_1000x1000.webp', 7, '2026-08-10 09:19:35', '2026-08-10 09:19:35'),
(92, '1', 'ash, black', 'uploads/6a79981fdb01d_1000x1000.webp', 7, '2026-08-10 09:21:36', '2026-08-10 09:21:36'),
(93, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a79982022376_1000x1000.webp', 7, '2026-08-10 09:21:36', '2026-08-10 09:21:36'),
(94, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a79982048b7c_1000x1000.webp', 7, '2026-08-10 09:21:36', '2026-08-10 09:21:36'),
(95, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a7998206e397_1000x1000.webp', 7, '2026-08-10 09:21:36', '2026-08-10 09:21:36'),
(96, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a79982090084_1000x1000.webp', 7, '2026-08-10 09:21:36', '2026-08-10 09:21:36'),
(97, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a799820b027b_1000x1000.webp', 7, '2026-08-10 09:21:36', '2026-08-10 09:21:36'),
(98, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a799820d2850_1000x1000.webp', 7, '2026-08-10 09:21:37', '2026-08-10 09:21:37'),
(99, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a79982101ef9_1000x1000.webp', 7, '2026-08-10 09:21:37', '2026-08-10 09:21:37'),
(100, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a79982123158_1000x1000.webp', 7, '2026-08-10 09:21:37', '2026-08-10 09:21:37'),
(101, '1', 'white,ash', 'uploads/6a799bd83bfe9_1000x1000.webp', 7, '2026-08-10 09:37:28', '2026-08-10 09:37:28'),
(102, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a799bd896277_1000x1000.webp', 7, '2026-08-10 09:37:28', '2026-08-10 09:37:28'),
(103, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a799bd8cbc79_1000x1000.webp', 7, '2026-08-10 09:37:28', '2026-08-10 09:37:28'),
(104, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a799bd90035c_1000x1000.webp', 7, '2026-08-10 09:37:29', '2026-08-10 09:37:29'),
(105, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a799bd93063a_1000x1000.webp', 7, '2026-08-10 09:37:29', '2026-08-10 09:37:29'),
(106, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a799bd96833f_1000x1000.webp', 7, '2026-08-10 09:37:29', '2026-08-10 09:37:29'),
(107, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a799bd98d238_1000x1000.webp', 7, '2026-08-10 09:37:29', '2026-08-10 09:37:29'),
(108, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a799bd9af1a2_1000x1000.webp', 7, '2026-08-10 09:37:29', '2026-08-10 09:37:29'),
(109, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a799bd9d9f26_1000x1000.webp', 7, '2026-08-10 09:37:30', '2026-08-10 09:37:30'),
(110, '1', 'beige, ash', 'uploads/6a799d32c764b_1000x1000.webp', 7, '2026-08-10 09:43:15', '2026-08-10 09:43:15'),
(111, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a799d332588d_1000x1000.webp', 7, '2026-08-10 09:43:15', '2026-08-10 09:43:15'),
(112, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a799d33588b0_1000x1000.webp', 7, '2026-08-10 09:43:15', '2026-08-10 09:43:15'),
(113, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a799d3395169_1000x1000.webp', 7, '2026-08-10 09:43:16', '2026-08-10 09:43:16'),
(114, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a799d3403a08_1000x1000.webp', 7, '2026-08-10 09:43:16', '2026-08-10 09:43:16'),
(115, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a799d342e290_1000x1000.webp', 7, '2026-08-10 09:43:16', '2026-08-10 09:43:16'),
(116, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a799d3457b22_1000x1000.webp', 7, '2026-08-10 09:43:16', '2026-08-10 09:43:16'),
(117, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a799d3481b91_1000x1000.webp', 7, '2026-08-10 09:43:16', '2026-08-10 09:43:16'),
(118, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a799d34a4c60_1000x1000.webp', 7, '2026-08-10 09:43:16', '2026-08-10 09:43:16'),
(119, '1', 'White, black, ash', 'uploads/6a799e18d79e5_1000x1000.webp', 7, '2026-08-10 09:47:05', '2026-08-10 09:47:05'),
(120, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a799e1938fe8_1000x1000.webp', 7, '2026-08-10 09:47:05', '2026-08-10 09:47:05'),
(121, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a799e19683e9_1000x1000.webp', 7, '2026-08-10 09:47:05', '2026-08-10 09:47:05'),
(122, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a799e19965d2_1000x1000.webp', 7, '2026-08-10 09:47:05', '2026-08-10 09:47:05'),
(123, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a799e19d9b38_1000x1000.webp', 7, '2026-08-10 09:47:06', '2026-08-10 09:47:06'),
(124, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a799e1a17403_1000x1000.webp', 7, '2026-08-10 09:47:06', '2026-08-10 09:47:06'),
(125, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a799e1a424da_1000x1000.webp', 7, '2026-08-10 09:47:06', '2026-08-10 09:47:06'),
(126, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a799e1a79edc_1000x1000.webp', 7, '2026-08-10 09:47:06', '2026-08-10 09:47:06'),
(127, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a799e1aa15c8_1000x1000.webp', 7, '2026-08-10 09:47:06', '2026-08-10 09:47:06'),
(128, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a799e1aca0f0_1000x1000.webp', 7, '2026-08-10 09:47:07', '2026-08-10 09:47:07'),
(129, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a799e1b07aa2_1000x1000.webp', 7, '2026-08-10 09:47:07', '2026-08-10 09:47:07'),
(130, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a799e1b3e16d_1000x1000.webp', 7, '2026-08-10 09:47:07', '2026-08-10 09:47:07'),
(131, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a799e1b70e81_1000x1000.webp', 7, '2026-08-10 09:47:07', '2026-08-10 09:47:07'),
(132, '1', 'black,ash,beige', 'uploads/6a799ea636800_1000x1000.webp', 7, '2026-08-10 09:49:26', '2026-08-10 09:49:26'),
(133, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a799ea680abd_1000x1000.webp', 7, '2026-08-10 09:49:26', '2026-08-10 09:49:26'),
(134, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a799ea6b341f_1000x1000.webp', 7, '2026-08-10 09:49:26', '2026-08-10 09:49:26'),
(135, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a799ea6d93d1_1000x1000.webp', 7, '2026-08-10 09:49:27', '2026-08-10 09:49:27'),
(136, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a799ea70bef1_1000x1000.webp', 7, '2026-08-10 09:49:27', '2026-08-10 09:49:27'),
(137, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a799ea72f8ce_1000x1000.webp', 7, '2026-08-10 09:49:27', '2026-08-10 09:49:27'),
(138, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a799ea750281_1000x1000.webp', 7, '2026-08-10 09:49:27', '2026-08-10 09:49:27'),
(139, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a799ea7702b9_1000x1000.webp', 7, '2026-08-10 09:49:27', '2026-08-10 09:49:27'),
(140, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a799ea7949ac_1000x1000.webp', 7, '2026-08-10 09:49:27', '2026-08-10 09:49:27'),
(141, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a799ea7babda_1000x1000.webp', 7, '2026-08-10 09:49:28', '2026-08-10 09:49:28'),
(142, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a799ea8010cc_1000x1000.webp', 7, '2026-08-10 09:49:28', '2026-08-10 09:49:28'),
(143, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a799ea830b42_1000x1000.webp', 7, '2026-08-10 09:49:28', '2026-08-10 09:49:28'),
(144, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a799ea86241d_1000x1000.webp', 7, '2026-08-10 09:49:28', '2026-08-10 09:49:28'),
(145, '1', 'white, ash, beige', 'uploads/6a799f67e685f_1000x1000.webp', 7, '2026-08-10 09:52:40', '2026-08-10 09:52:40'),
(146, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a799f68420a6_1000x1000.webp', 7, '2026-08-10 09:52:40', '2026-08-10 09:52:40'),
(147, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a799f687eeb6_1000x1000.webp', 7, '2026-08-10 09:52:40', '2026-08-10 09:52:40'),
(148, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a799f68a50c9_1000x1000.webp', 7, '2026-08-10 09:52:40', '2026-08-10 09:52:40'),
(149, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a799f68d125f_1000x1000.webp', 7, '2026-08-10 09:52:41', '2026-08-10 09:52:41'),
(150, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a799f6902720_1000x1000.webp', 7, '2026-08-10 09:52:41', '2026-08-10 09:52:41'),
(151, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a799f6929522_1000x1000.webp', 7, '2026-08-10 09:52:41', '2026-08-10 09:52:41'),
(152, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a799f694e94c_1000x1000.webp', 7, '2026-08-10 09:52:41', '2026-08-10 09:52:41'),
(153, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a799f697c4c7_1000x1000.webp', 7, '2026-08-10 09:52:41', '2026-08-10 09:52:41'),
(154, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a799f69a34a6_1000x1000.webp', 7, '2026-08-10 09:52:41', '2026-08-10 09:52:41'),
(155, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a799f69c89f2_1000x1000.webp', 7, '2026-08-10 09:52:42', '2026-08-10 09:52:42'),
(156, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a799f6a01c0c_1000x1000.webp', 7, '2026-08-10 09:52:42', '2026-08-10 09:52:42'),
(157, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a799f6a2f4ab_1000x1000.webp', 7, '2026-08-10 09:52:42', '2026-08-10 09:52:42'),
(158, '1', '6931192dcb071_800x800', 'uploads/6a79a0dfd6263_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(159, '1', 'Ice-Silk-Pant-Ash-color-01', 'uploads/6a79a0e001d47_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(160, '1', 'Ice-Silk-Pant-Ash-color-02', 'uploads/6a79a0e02b44e_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(161, '1', 'Ice-Silk-Pant-Ash-color-03', 'uploads/6a79a0e050180_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(162, '1', 'Ice-Silk-Pant-Ash-color-04', 'uploads/6a79a0e071f7c_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(163, '1', 'Ice-Silk-Pant-beige-color-01', 'uploads/6a79a0e095bf9_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(164, '1', 'Ice-Silk-Pant-beige-color-02', 'uploads/6a79a0e0b9f07_1000x1000.webp', 7, '2026-08-10 09:58:56', '2026-08-10 09:58:56'),
(165, '1', 'Ice-Silk-Pant-beige-color-03', 'uploads/6a79a0e0db540_1000x1000.webp', 7, '2026-08-10 09:58:57', '2026-08-10 09:58:57'),
(166, '1', 'Ice-Silk-Pant-beige-color-04', 'uploads/6a79a0e107b12_1000x1000.webp', 7, '2026-08-10 09:58:57', '2026-08-10 09:58:57'),
(167, '1', 'Ice-Silk-Pant-black-01', 'uploads/6a79a0e12b976_1000x1000.webp', 7, '2026-08-10 09:58:57', '2026-08-10 09:58:57'),
(168, '1', 'Ice-Silk-Pant-black-02', 'uploads/6a79a0e14fa77_1000x1000.webp', 7, '2026-08-10 09:58:57', '2026-08-10 09:58:57'),
(169, '1', 'Ice-Silk-Pant-black-03', 'uploads/6a79a0e17761c_1000x1000.webp', 7, '2026-08-10 09:58:57', '2026-08-10 09:58:57'),
(170, '1', 'Ice-Silk-Pant-black-04', 'uploads/6a79a0e1b449a_1000x1000.webp', 7, '2026-08-10 09:58:58', '2026-08-10 09:58:58'),
(171, '1', 'Ice-Silk-Pant-White-color-01', 'uploads/6a79a0e21283c_1000x1000.webp', 7, '2026-08-10 09:58:58', '2026-08-10 09:58:58'),
(172, '1', 'Ice-Silk-Pant-White-color-02', 'uploads/6a79a0e25d7ff_1000x1000.webp', 7, '2026-08-10 09:58:58', '2026-08-10 09:58:58'),
(173, '1', 'Ice-Silk-Pant-White-color-03', 'uploads/6a79a0e28813b_1000x1000.webp', 7, '2026-08-10 09:58:58', '2026-08-10 09:58:58'),
(174, '1', 'Ice-Silk-Pant-White-color-04', 'uploads/6a79a0e2b1dee_1000x1000.webp', 7, '2026-08-10 09:58:58', '2026-08-10 09:58:58'),
(175, '1', '3 combo 1.1', 'uploads/6a79a55d6ea22_1000x1000.webp', 7, '2026-08-10 10:18:05', '2026-08-10 10:18:05'),
(176, '1', 'photo edit 1.1', 'uploads/6a79a55da15a9_1000x1000.webp', 7, '2026-08-10 10:18:05', '2026-08-10 10:18:05'),
(177, '1', 'photo edit 1.2', 'uploads/6a79a55dc2dba_1000x1000.webp', 7, '2026-08-10 10:18:05', '2026-08-10 10:18:05'),
(178, '1', 'photo edit 1.3', 'uploads/6a79a55de31b4_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(179, '1', 'photo edit 1.4', 'uploads/6a79a55e109e0_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(180, '1', 'photo edit 2.1', 'uploads/6a79a55e30ddd_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(181, '1', 'photo edit 2.2', 'uploads/6a79a55e4e225_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(182, '1', 'photo edit 2.3', 'uploads/6a79a55e6cc56_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(183, '1', 'photo edit 2.4', 'uploads/6a79a55e8a391_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(184, '1', 'photo edit 4.1', 'uploads/6a79a55ea330d_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(185, '1', 'photo edit 4.2', 'uploads/6a79a55ec3924_1000x1000.webp', 7, '2026-08-10 10:18:06', '2026-08-10 10:18:06'),
(186, '1', 'photo edit 4.3', 'uploads/6a79a55ee720c_1000x1000.webp', 7, '2026-08-10 10:18:07', '2026-08-10 10:18:07'),
(187, '1', 'photo edit 4.4', 'uploads/6a79a55f1109a_1000x1000.webp', 7, '2026-08-10 10:18:07', '2026-08-10 10:18:07'),
(188, '1', '3 combo 1.4', 'uploads/6a79a614dc49e_1000x1000.webp', 7, '2026-08-10 10:21:09', '2026-08-10 10:21:09'),
(189, '1', 'photo edit 1.1', 'uploads/6a79a6153488a_1000x1000.webp', 7, '2026-08-10 10:21:09', '2026-08-10 10:21:09'),
(190, '1', 'photo edit 1.2', 'uploads/6a79a6156260a_1000x1000.webp', 7, '2026-08-10 10:21:09', '2026-08-10 10:21:09'),
(191, '1', 'photo edit 1.3', 'uploads/6a79a6158c647_1000x1000.webp', 7, '2026-08-10 10:21:09', '2026-08-10 10:21:09'),
(192, '1', 'photo edit 1.4', 'uploads/6a79a615be7a7_1000x1000.webp', 7, '2026-08-10 10:21:09', '2026-08-10 10:21:09'),
(193, '1', 'photo edit 3.1', 'uploads/6a79a615e8b4a_1000x1000.webp', 7, '2026-08-10 10:21:10', '2026-08-10 10:21:10'),
(194, '1', 'photo edit 3.2', 'uploads/6a79a61622b8a_1000x1000.webp', 7, '2026-08-10 10:21:10', '2026-08-10 10:21:10'),
(195, '1', 'photo edit 3.3', 'uploads/6a79a6164ca70_1000x1000.webp', 7, '2026-08-10 10:21:10', '2026-08-10 10:21:10'),
(196, '1', 'photo edit 3.4', 'uploads/6a79a61672df0_1000x1000.webp', 7, '2026-08-10 10:21:10', '2026-08-10 10:21:10'),
(197, '1', 'photo edit 4.1', 'uploads/6a79a6169bf6b_1000x1000.webp', 7, '2026-08-10 10:21:10', '2026-08-10 10:21:10'),
(198, '1', 'photo edit 4.2', 'uploads/6a79a616c8a21_1000x1000.webp', 7, '2026-08-10 10:21:10', '2026-08-10 10:21:10'),
(199, '1', 'photo edit 4.3', 'uploads/6a79a616f1359_1000x1000.webp', 7, '2026-08-10 10:21:11', '2026-08-10 10:21:11'),
(200, '1', 'photo edit 4.4', 'uploads/6a79a6172b0ee_1000x1000.webp', 7, '2026-08-10 10:21:11', '2026-08-10 10:21:11'),
(201, '1', '3 combo 1.3', 'uploads/6a79b1651cfdc_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(202, '1', 'photo edit 2.1', 'uploads/6a79b1654516a_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(203, '1', 'photo edit 2.2', 'uploads/6a79b1655c7f4_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(204, '1', 'photo edit 2.3', 'uploads/6a79b1657b32e_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(205, '1', 'photo edit 2.4', 'uploads/6a79b16598bfe_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(206, '1', 'photo edit 3.1', 'uploads/6a79b165b5ba2_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(207, '1', 'photo edit 3.2', 'uploads/6a79b165d16fb_1000x1000.webp', 7, '2026-08-10 11:09:25', '2026-08-10 11:09:25'),
(208, '1', 'photo edit 3.3', 'uploads/6a79b165efdf4_1000x1000.webp', 7, '2026-08-10 11:09:26', '2026-08-10 11:09:26'),
(209, '1', 'photo edit 3.4', 'uploads/6a79b1661576e_1000x1000.webp', 7, '2026-08-10 11:09:26', '2026-08-10 11:09:26'),
(210, '1', 'photo edit 4.1', 'uploads/6a79b1662bcea_1000x1000.webp', 7, '2026-08-10 11:09:26', '2026-08-10 11:09:26'),
(211, '1', 'photo edit 4.2', 'uploads/6a79b16642520_1000x1000.webp', 7, '2026-08-10 11:09:26', '2026-08-10 11:09:26'),
(212, '1', 'photo edit 4.3', 'uploads/6a79b16656f7a_1000x1000.webp', 7, '2026-08-10 11:09:26', '2026-08-10 11:09:26'),
(213, '1', 'photo edit 4.4', 'uploads/6a79b1666c1cd_1000x1000.webp', 7, '2026-08-10 11:09:26', '2026-08-10 11:09:26'),
(214, '1', '3 combo 1.2', 'uploads/6a79b39aae0e6_1000x1000.webp', 7, '2026-08-10 11:18:50', '2026-08-10 11:18:50'),
(215, '1', 'photo edit 1.1', 'uploads/6a79b39acf559_1000x1000.webp', 7, '2026-08-10 11:18:50', '2026-08-10 11:18:50'),
(216, '1', 'photo edit 1.2', 'uploads/6a79b39ae2e29_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(217, '1', 'photo edit 1.3', 'uploads/6a79b39b0239e_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(218, '1', 'photo edit 1.4', 'uploads/6a79b39b178d8_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(219, '1', 'photo edit 2.1', 'uploads/6a79b39b2c555_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(220, '1', 'photo edit 2.2', 'uploads/6a79b39b43ba1_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(221, '1', 'photo edit 2.3', 'uploads/6a79b39b58841_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(222, '1', 'photo edit 2.4', 'uploads/6a79b39b6eef8_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(223, '1', 'photo edit 3.1', 'uploads/6a79b39b82e93_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(224, '1', 'photo edit 3.2', 'uploads/6a79b39b96c32_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(225, '1', 'photo edit 3.3', 'uploads/6a79b39baa41f_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(226, '1', 'photo edit 3.4', 'uploads/6a79b39bbd5c1_1000x1000.webp', 7, '2026-08-10 11:18:51', '2026-08-10 11:18:51'),
(227, '1', 'photo edit 3.1', 'uploads/6a79b459e3449_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(228, '1', 'photo edit 1.1', 'uploads/6a79b45a28c7c_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(229, '1', 'photo edit 1.2', 'uploads/6a79b45a48361_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(230, '1', 'photo edit 1.3', 'uploads/6a79b45a64a29_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(231, '1', 'photo edit 1.4', 'uploads/6a79b45a7ebc8_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(232, '1', 'photo edit 2.1', 'uploads/6a79b45a9a39b_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(233, '1', 'photo edit 2.2', 'uploads/6a79b45ab8095_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(234, '1', 'photo edit 2.3', 'uploads/6a79b45ad5635_1000x1000.webp', 7, '2026-08-10 11:22:02', '2026-08-10 11:22:02'),
(235, '1', 'photo edit 2.4', 'uploads/6a79b45aee7f1_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(236, '1', 'photo edit 3.1', 'uploads/6a79b45b16763_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(237, '1', 'photo edit 3.2', 'uploads/6a79b45b33a00_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(238, '1', 'photo edit 3.3', 'uploads/6a79b45b58e9d_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(239, '1', 'photo edit 3.4', 'uploads/6a79b45b75f4f_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(240, '1', 'photo edit 4.1', 'uploads/6a79b45b91248_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(241, '1', 'photo edit 4.2', 'uploads/6a79b45bab5df_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(242, '1', 'photo edit 4.3', 'uploads/6a79b45bc43ff_1000x1000.webp', 7, '2026-08-10 11:22:03', '2026-08-10 11:22:03'),
(243, '1', 'photo edit 4.1', 'uploads/6a79b45be84cb_1000x1000.webp', 7, '2026-08-10 11:22:04', '2026-08-10 11:22:04'),
(244, '1', 'photo edit 4.1', 'uploads/6a79b45c240f2_1000x1000.webp', 7, '2026-08-10 11:22:04', '2026-08-10 11:22:04'),
(245, '1', 'photo edit 4.1', 'uploads/6a79b45c537b9_1000x1000.webp', 7, '2026-08-10 11:22:04', '2026-08-10 11:22:04'),
(246, '1', 'photo edit 4.1', 'uploads/6a79b45c7683a_1000x1000.webp', 7, '2026-08-10 11:22:04', '2026-08-10 11:22:04'),
(247, '1', 'photo edit 4.1', 'uploads/6a79b45c9e42d_1000x1000.webp', 7, '2026-08-10 11:22:04', '2026-08-10 11:22:04'),
(248, '1', 'photo edit 2.3', 'uploads/6a79b45cc4516_1000x1000.webp', 7, '2026-08-10 11:22:04', '2026-08-10 11:22:04'),
(249, '1', 'photo edit 2.3', 'uploads/6a79b45ceca05_1000x1000.webp', 7, '2026-08-10 11:22:05', '2026-08-10 11:22:05'),
(250, '1', 'photo edit 2.3', 'uploads/6a79b45d25981_1000x1000.webp', 7, '2026-08-10 11:22:05', '2026-08-10 11:22:05'),
(251, '1', 'photo edit 2.3', 'uploads/6a79b45d46fb3_1000x1000.webp', 7, '2026-08-10 11:22:05', '2026-08-10 11:22:05'),
(252, '1', 'photo edit 2.3', 'uploads/6a79b45d6d6e5_1000x1000.webp', 7, '2026-08-10 11:22:05', '2026-08-10 11:22:05'),
(253, '1', 'photo edit 1.4', 'uploads/6a79b45d94fda_1000x1000.webp', 7, '2026-08-10 11:22:05', '2026-08-10 11:22:05'),
(254, '1', 'photo edit 1.4', 'uploads/6a79b45dbdcfc_1000x1000.webp', 7, '2026-08-10 11:22:05', '2026-08-10 11:22:05'),
(255, '1', 'photo edit 1.4', 'uploads/6a79b45ded1ab_1000x1000.webp', 7, '2026-08-10 11:22:06', '2026-08-10 11:22:06'),
(256, '1', 'photo edit 1.4', 'uploads/6a79b45e240b7_1000x1000.webp', 7, '2026-08-10 11:22:06', '2026-08-10 11:22:06'),
(257, '1', 'photo edit 1.4', 'uploads/6a79b45e4e3ca_1000x1000.webp', 7, '2026-08-10 11:22:06', '2026-08-10 11:22:06'),
(258, '1', 'photo edit 3.1', 'uploads/6a79b45e707e9_1000x1000.webp', 7, '2026-08-10 11:22:06', '2026-08-10 11:22:06'),
(259, '1', 'photo edit 3.1', 'uploads/6a79b45e9064e_1000x1000.webp', 7, '2026-08-10 11:22:06', '2026-08-10 11:22:06'),
(260, '1', 'photo edit 3.1', 'uploads/6a79b45eba072_1000x1000.webp', 7, '2026-08-10 11:22:06', '2026-08-10 11:22:06'),
(261, '1', 'photo edit 3.1', 'uploads/6a79b45edcb1a_1000x1000.webp', 7, '2026-08-10 11:22:07', '2026-08-10 11:22:07'),
(262, '1', 'photo edit 3.1', 'uploads/6a79b45f084f6_1000x1000.webp', 7, '2026-08-10 11:22:07', '2026-08-10 11:22:07'),
(263, '3', '6a79b569c6865_1920x800.webp', 'uploads/6a79b569c6865_1920x800.webp', 7, '2026-08-10 11:26:34', '2026-08-10 11:26:34'),
(264, '0', 'New-logo-icon.png', 'uploads/6a81760db6997.png', 7, '2026-08-16 08:34:21', '2026-08-16 08:34:21'),
(265, '0', 'New-logo-icon.png', 'uploads/6a81760db879c.png', 7, '2026-08-16 08:34:21', '2026-08-16 08:34:21'),
(266, '0', 'Styluxe-BD-logo-new.png', 'uploads/6a81760dbe255.png', 7, '2026-08-16 08:34:21', '2026-08-16 08:34:21'),
(283, '1', 'Cargo-Pant-01.2', 'uploads/6a8ed77270923_1000x1000.webp', 7, '2026-08-26 12:09:22', '2026-08-26 12:09:22'),
(284, '1', 'Cargo-Pant-01.1', 'uploads/6a8ed772bf18f_1000x1000.webp', 7, '2026-08-26 12:09:23', '2026-08-26 12:09:23'),
(285, '1', 'Cargo-Pant-01.3', 'uploads/6a8ed77309f43_1000x1000.webp', 7, '2026-08-26 12:09:23', '2026-08-26 12:09:23'),
(286, '1', 'Cargo-Pant-01', 'uploads/6a8ed7733c317_1000x1000.webp', 7, '2026-08-26 12:09:23', '2026-08-26 12:09:23'),
(287, '1', 'Cargo-Pant-02.1', 'uploads/6a8ed773754ac_1000x1000.webp', 7, '2026-08-26 12:09:23', '2026-08-26 12:09:23'),
(288, '1', 'Cargo-Pant-02.2', 'uploads/6a8ed773b2cc5_1000x1000.webp', 7, '2026-08-26 12:09:23', '2026-08-26 12:09:23'),
(289, '1', 'Cargo-Pant-02.3', 'uploads/6a8ed773efd2b_1000x1000.webp', 7, '2026-08-26 12:09:24', '2026-08-26 12:09:24'),
(290, '1', 'Cargo-Pant-02', 'uploads/6a8ed7743befd_1000x1000.webp', 7, '2026-08-26 12:09:24', '2026-08-26 12:09:24'),
(291, '1', 'Cargo-Pant-03.1', 'uploads/6a8ed7746cb6e_1000x1000.webp', 7, '2026-08-26 12:09:24', '2026-08-26 12:09:24'),
(292, '1', 'Cargo-Pant-03.2', 'uploads/6a8ed7749aed6_1000x1000.webp', 7, '2026-08-26 12:09:24', '2026-08-26 12:09:24'),
(293, '1', 'Cargo-Pant-03.3', 'uploads/6a8ed774c3e30_1000x1000.webp', 7, '2026-08-26 12:09:24', '2026-08-26 12:09:24'),
(294, '1', 'Cargo-Pant-03', 'uploads/6a8ed774f27c4_1000x1000.webp', 7, '2026-08-26 12:09:25', '2026-08-26 12:09:25'),
(295, '1', 'Cargo-Pant-04.1', 'uploads/6a8ed7753f4ba_1000x1000.webp', 7, '2026-08-26 12:09:25', '2026-08-26 12:09:25'),
(296, '1', 'Cargo-Pant-04.2', 'uploads/6a8ed77572432_1000x1000.webp', 7, '2026-08-26 12:09:25', '2026-08-26 12:09:25'),
(297, '1', 'Cargo-Pant-04.3', 'uploads/6a8ed775ba807_1000x1000.webp', 7, '2026-08-26 12:09:25', '2026-08-26 12:09:25'),
(298, '1', 'Cargo-Pant-04', 'uploads/6a8ed775ea826_1000x1000.webp', 7, '2026-08-26 12:09:26', '2026-08-26 12:09:26'),
(299, '1', 'ChatGPT Image Sep 9, 2026, 06_20_55 PM', 'uploads/6aa151801576d_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(300, '1', '6a93b0eb2db9e_800x800', 'uploads/6aa15180544ee_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(301, '1', '6a93b0ec1a41c_800x800', 'uploads/6aa1518069b12_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(302, '1', '6a93b176e8532_800x800', 'uploads/6aa151807e69c_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(303, '1', '6a93b178437b9_800x800', 'uploads/6aa1518093494_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(304, '1', '6a93b1776884b_800x800', 'uploads/6aa15180a64d3_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(305, '1', '6a93b177cd9ad_800x800', 'uploads/6aa15180bcb17_1000x1000.webp', 7, '2026-09-09 12:30:56', '2026-09-09 12:30:56'),
(306, '1', '6a93b177cd9ad_800x800', 'uploads/6aa15180dc78c_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(307, '1', '6a93b177cd9ad_800x800', 'uploads/6aa15181065f1_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(308, '1', '6a93b177cd9ad_800x800', 'uploads/6aa1518125da3_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(309, '1', '6a93b177cd9ad_800x800', 'uploads/6aa1518144312_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(310, '1', '6a93b0eb9e088_800x800', 'uploads/6aa15181646af_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(311, '1', '6a93b0eb9e088_800x800', 'uploads/6aa1518183ef8_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(312, '1', '6a93b0eb9e088_800x800', 'uploads/6aa15181a232a_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(313, '1', '6a93b0eb9e088_800x800', 'uploads/6aa15181c2b7c_1000x1000.webp', 7, '2026-09-09 12:30:57', '2026-09-09 12:30:57'),
(314, '1', '6a93b0eb9e088_800x800', 'uploads/6aa15181e0bfe_1000x1000.webp', 7, '2026-09-09 12:30:58', '2026-09-09 12:30:58'),
(315, '1', '01', 'uploads/6aa155e7c9cc7_1000x1000.webp', 7, '2026-09-09 12:49:44', '2026-09-09 12:49:44'),
(316, '1', '02', 'uploads/6aa155e81eab0_1000x1000.webp', 7, '2026-09-09 12:49:44', '2026-09-09 12:49:44'),
(317, '1', '03', 'uploads/6aa155e85973c_1000x1000.webp', 7, '2026-09-09 12:49:44', '2026-09-09 12:49:44'),
(318, '1', '04', 'uploads/6aa155e88e07c_1000x1000.webp', 7, '2026-09-09 12:49:44', '2026-09-09 12:49:44'),
(319, '1', '01 copy', 'uploads/6aa155fd55a20_1000x1000.webp', 7, '2026-09-09 12:50:05', '2026-09-09 12:50:05'),
(320, '1', '03 copy', 'uploads/6aa155fdac7a3_1000x1000.webp', 7, '2026-09-09 12:50:05', '2026-09-09 12:50:05'),
(321, '1', '04 copy', 'uploads/6aa155fdde470_1000x1000.webp', 7, '2026-09-09 12:50:06', '2026-09-09 12:50:06'),
(322, '1', '05', 'uploads/6aa155fe29cce_1000x1000.webp', 7, '2026-09-09 12:50:06', '2026-09-09 12:50:06'),
(323, '1', '001', 'uploads/6aa156163f424_1000x1000.webp', 7, '2026-09-09 12:50:30', '2026-09-09 12:50:30'),
(324, '1', '002', 'uploads/6aa156168373e_1000x1000.webp', 7, '2026-09-09 12:50:30', '2026-09-09 12:50:30'),
(325, '1', '003', 'uploads/6aa15616ac6cb_1000x1000.webp', 7, '2026-09-09 12:50:30', '2026-09-09 12:50:30'),
(326, '1', '004', 'uploads/6aa15616d78fd_1000x1000.webp', 7, '2026-09-09 12:50:31', '2026-09-09 12:50:31'),
(327, '1', '0001', 'uploads/6aa156314853b_1000x1000.webp', 7, '2026-09-09 12:50:57', '2026-09-09 12:50:57'),
(328, '1', '0002', 'uploads/6aa1563191a2b_1000x1000.webp', 7, '2026-09-09 12:50:57', '2026-09-09 12:50:57'),
(329, '1', '0004', 'uploads/6aa15631c1bdf_1000x1000.webp', 7, '2026-09-09 12:50:57', '2026-09-09 12:50:57'),
(330, '1', '0005', 'uploads/6aa15631ed0cc_1000x1000.webp', 7, '2026-09-09 12:50:58', '2026-09-09 12:50:58'),
(331, '1', '38fd9cb4-1ded-4010-b61c-13344bec6ecb', 'uploads/6ac5de1a286d7_1000x1000.webp', 7, '2026-10-07 05:52:26', '2026-10-07 05:52:26');

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
(3, '2022_01_23_195251_create_products_table', 1),
(4, '2025_01_28_173908_create_product_variants_table', 2),
(5, '2025_10_25_120957_create_attributes_table', 3),
(6, '2025_10_25_121159_create_attribute_items_table', 4),
(7, '2025_01_28_174159_create_product_variant_items_table', 5),
(8, '2025_10_30_171014_create_combo_products_table', 6),
(9, '2025_11_02_174706_create_themes_table', 7),
(10, '2025_11_12_111737_create_theme_extra_fields_table', 8),
(14, '2025_11_25_103047_create_device_tracks_table', 9),
(15, '2025_01_19_142254_create_api_couriers_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Admin', 1),
(1, 'App\\Admin', 7),
(2, 'App\\Admin', 5),
(2, 'App\\Admin', 6),
(2, 'App\\Admin', 12),
(3, 'App\\Admin', 2),
(3, 'App\\Admin', 3),
(3, 'App\\Admin', 4),
(3, 'App\\Admin', 9),
(3, 'App\\Admin', 14),
(4, 'App\\Admin', 7),
(4, 'App\\Admin', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `memo_number` varchar(255) DEFAULT NULL,
  `customer_activity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customer_activity`)),
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) NOT NULL,
  `courier_id` int(11) DEFAULT NULL,
  `courier_city_id` int(11) DEFAULT NULL,
  `courier_zone_id` int(11) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `coupon_applied_on` varchar(255) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `shipping_method` tinyint(4) DEFAULT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1= paid, 0= unpaid',
  `source` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending/on hold, 1=delivered, 2=processing, 3=pending payment, 4=canceled',
  `customer_note` varchar(255) DEFAULT NULL,
  `staff_note` varchar(255) DEFAULT NULL,
  `courier_status` varchar(255) DEFAULT NULL,
  `courier_reason_msg` varchar(255) DEFAULT NULL,
  `courier_error_msg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`courier_error_msg`)),
  `consignment_id` varchar(255) DEFAULT NULL,
  `tracking_id` varchar(255) DEFAULT NULL,
  `is_sent_to_courier` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Not Sent, 1 = Sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `theme_id`, `invoice_id`, `ip_address`, `device_id`, `memo_number`, `customer_activity`, `customer_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `courier_id`, `courier_city_id`, `courier_zone_id`, `coupon_code`, `coupon_discount`, `coupon_applied_on`, `payment_method`, `shipping_method`, `shipping_cost`, `discount`, `sub_total`, `total`, `paid`, `due`, `payment_status`, `source`, `status`, `customer_note`, `staff_note`, `courier_status`, `courier_reason_msg`, `courier_error_msg`, `consignment_id`, `tracking_id`, `is_sent_to_courier`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2026-10-10', 8, 'SB1', '::1', 'wR9Wz1hSE7SAfn2p', NULL, NULL, 17, 'Test Customer', '01767891011', NULL, 'Test Address', NULL, NULL, NULL, NULL, '0.00', NULL, 'cod', 1, '80.00', '0.00', '2500.00', '2580.00', '0.00', '2580.00', 0, 'website', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-10-10 11:04:01', '2026-10-10 11:05:35', NULL),
(2, '2026-10-10', 8, 'SB2', NULL, NULL, NULL, NULL, 17, 'Test Customer', '01767891011', NULL, 'Test Address', NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 1, '80.00', '0.00', '4800.00', '4880.00', '0.00', '4880.00', 0, 'whatsapp', 12, NULL, 'sdfsdf', NULL, NULL, NULL, NULL, NULL, 0, '2026-10-10 11:08:26', '2026-10-10 12:02:44', NULL),
(3, '2026-10-12', 8, 'SB3', NULL, NULL, NULL, NULL, 17, 'Test Customer', '01767891011', NULL, 'Test Address', NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 1, '80.00', '0.00', '800.00', '880.00', '0.00', '880.00', 0, 'whatsapp', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-10-12 03:36:25', '2026-10-12 03:36:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_activities`
--

CREATE TABLE `order_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_type` varchar(50) NOT NULL,
  `field` varchar(100) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_activities`
--

INSERT INTO `order_activities` (`id`, `order_id`, `causer_type`, `causer_id`, `activity_type`, `field`, `old_value`, `new_value`, `text`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Admin', 7, 'created', NULL, NULL, NULL, 'Admin created the order', '2026-10-10 11:04:01', '2026-10-10 11:04:01'),
(2, 1, 'App\\Admin', 7, 'product_added', 'product', NULL, 'Combo Product (qty: 1)', '\"Combo Product\" (qty: 1) অর্ডারে যুক্ত হয়েছে', '2026-10-10 11:04:01', '2026-10-10 11:04:01'),
(3, 1, 'App\\Admin', 7, 'assigned', 'assigned_employee', NULL, 'Employee', 'অর্ডারটি \"Employee\"-কে assign করা হয়েছে', '2026-10-10 11:04:01', '2026-10-10 11:04:01'),
(4, 1, 'App\\Admin', 7, 'purchase_price_changed', 'purchase_price', '710.00', '350.00', '\"Combo Product\" এর purchase price পরিবর্তন হয়েছে: 710.00 → 350.00', '2026-10-10 11:04:54', '2026-10-10 11:04:54'),
(5, 1, 'App\\Admin', 7, 'updated', 'status', 'pending', 'on_delivery', 'status পরিবর্তন হয়েছে: pending → on_delivery', '2026-10-10 11:05:11', '2026-10-10 11:05:11'),
(6, 1, 'App\\Admin', 7, 'updated', 'status', 'on_delivery', '12', 'status পরিবর্তন হয়েছে: on_delivery → 12', '2026-10-10 11:05:35', '2026-10-10 11:05:35'),
(7, 2, 'App\\Admin', 7, 'created', NULL, NULL, NULL, 'Admin created the order', '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(8, 2, 'App\\Admin', 7, 'product_added', 'product', NULL, 'Combo Product (qty: 1)', '\"Combo Product\" (qty: 1) অর্ডারে যুক্ত হয়েছে', '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(9, 2, 'App\\Admin', 7, 'product_added', 'product', NULL, 'combo product - 02 (qty: 1)', '\"combo product - 02\" (qty: 1) অর্ডারে যুক্ত হয়েছে', '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(10, 2, 'App\\Admin', 7, 'assigned', 'assigned_employee', NULL, 'Office', 'অর্ডারটি \"Office\"-কে assign করা হয়েছে', '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(11, 2, 'App\\Admin', 7, 'updated', 'status', 'pending', 'on_delivery', 'status পরিবর্তন হয়েছে: pending → on_delivery', '2026-10-10 11:10:33', '2026-10-10 11:10:33'),
(12, 2, 'App\\Admin', 7, 'updated', 'status', 'on_delivery', '12', 'status পরিবর্তন হয়েছে: on_delivery → 12', '2026-10-10 11:16:42', '2026-10-10 11:16:42'),
(13, 2, 'App\\Admin', 7, 'updated', 'staff_note', ' ', 'sdfsdf', 'staff_note পরিবর্তন হয়েছে:   → sdfsdf', '2026-10-10 12:02:44', '2026-10-10 12:02:44'),
(14, 3, 'App\\Admin', 7, 'created', NULL, NULL, NULL, 'Admin created the order', '2026-10-12 03:36:25', '2026-10-12 03:36:25'),
(15, 3, 'App\\Admin', 7, 'product_added', 'product', NULL, 'test product-03 (qty: 1)', '\"test product-03\" (qty: 1) অর্ডারে যুক্ত হয়েছে', '2026-10-12 03:36:25', '2026-10-12 03:36:25'),
(16, 3, 'App\\Admin', 7, 'assigned', 'assigned_employee', NULL, 'Office', 'অর্ডারটি \"Office\"-কে assign করা হয়েছে', '2026-10-12 03:36:25', '2026-10-12 03:36:25'),
(17, 3, 'App\\Admin', 7, 'updated', 'status', 'pending', 'on_delivery', 'status পরিবর্তন হয়েছে: pending → on_delivery', '2026-10-12 03:36:42', '2026-10-12 03:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_assigns`
--

CREATE TABLE `order_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_assigns`
--

INSERT INTO `order_assigns` (`id`, `order_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 14, '2026-10-10 11:04:01', '2026-10-10 11:04:01'),
(2, 2, 9, '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(3, 3, 9, '2026-10-12 03:36:25', '2026-10-12 03:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_combo_items`
--

CREATE TABLE `order_combo_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_combo_items`
--

INSERT INTO `order_combo_items` (`id`, `order_product_id`, `product_id`, `sku`, `qty`, `variant_id`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 'prod-001', 1, NULL, '2026-10-10 11:05:00', '2026-10-10 11:05:00'),
(13, 2, 1, 'prod-001', 1, NULL, '2026-10-10 12:02:44', '2026-10-10 12:02:44'),
(14, 2, 2, 'prod-002', 1, NULL, '2026-10-10 12:02:44', '2026-10-10 12:02:44'),
(15, 3, 2, 'prod-002', 1, NULL, '2026-10-10 12:02:44', '2026-10-10 12:02:44'),
(16, 3, 3, 'PROD-003-30_&_31', 1, 1, '2026-10-10 12:02:44', '2026-10-10 12:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE `order_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `purchase_price` decimal(12,2) DEFAULT 0.00,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `attributes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `product_sku`, `qty`, `purchase_price`, `price`, `discount`, `attributes`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'adfsdf', 1, '350.00', '2500.00', '0.00', NULL, '2026-10-10 11:04:01', '2026-10-10 11:04:54'),
(2, 2, 4, 'adfsdf', 1, '710.00', '2500.00', '0.00', NULL, '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(3, 2, 9, 'dfdf', 1, '610.00', '2300.00', '0.00', NULL, '2026-10-10 11:08:26', '2026-10-10 11:08:26'),
(4, 3, 3, 'PROD-003-30_&_31', 1, '250.00', '800.00', '0.00', '2', '2026-10-12 03:36:25', '2026-10-12 03:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `page_settings`
--

CREATE TABLE `page_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `about_us` longtext DEFAULT NULL,
  `delivery_policy` longtext DEFAULT NULL,
  `return_policy` longtext DEFAULT NULL,
  `how_to_order` longtext DEFAULT NULL,
  `privacy_policy` longtext DEFAULT NULL,
  `terms_condition` longtext DEFAULT NULL,
  `why_us` longtext DEFAULT NULL,
  `contact_us` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_settings`
--

INSERT INTO `page_settings` (`id`, `about_us`, `delivery_policy`, `return_policy`, `how_to_order`, `privacy_policy`, `terms_condition`, `why_us`, `contact_us`, `created_at`, `updated_at`) VALUES
(1, '<p>adfds</p>', '<p>sss</p>', '<p>sdfdf</p>', NULL, NULL, NULL, NULL, NULL, '2025-11-13 06:20:36', '2025-11-13 06:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pathao_cities`
--

CREATE TABLE `pathao_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pathao_cities`
--

INSERT INTO `pathao_cities` (`id`, `parent_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 52, 'Bagerhat', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(2, 62, 'Bandarban ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(3, 34, 'Barguna ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(4, 17, 'Barisal', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(5, 32, 'B. Baria', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(6, 53, 'Bhola', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(7, 9, 'Bogra', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(8, 8, 'Chandpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(9, 15, 'Chapainawabganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(10, 2, 'Chittagong', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(11, 61, 'Chuadanga', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(12, 11, 'Cox\'s Bazar', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(13, 5, 'Cumilla', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(14, 1, 'Dhaka', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(15, 35, 'Dinajpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(16, 18, 'Faridpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(17, 6, 'Feni', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(18, 38, 'Gaibandha', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(19, 22, 'Gazipur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(20, 56, 'Gopalgonj ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(21, 30, 'Habiganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(22, 41, 'Jamalpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(23, 19, 'Jashore', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(24, 27, 'Jhalokathi', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(25, 49, 'Jhenidah', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(26, 48, 'Joypurhat', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(27, 63, 'Khagrachari', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(28, 20, 'Khulna', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(29, 42, 'Kishoreganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(30, 55, 'Kurigram ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(31, 28, 'Kushtia', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(32, 40, 'Lakshmipur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(33, 57, 'Lalmonirhat ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(34, 43, 'Madaripur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(35, 60, 'Magura ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(36, 16, 'Manikganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(37, 50, 'Meherpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(38, 12, 'Moulvibazar', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(39, 23, 'Munsiganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(40, 26, 'Mymensingh', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(41, 46, 'Naogaon', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(42, 54, 'Narail ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(43, 21, 'Narayanganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(44, 47, 'Narshingdi', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(45, 14, 'Natore', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(46, 44, 'Netrakona', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(47, 39, 'Nilphamari', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(48, 7, 'Noakhali', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(49, 24, 'Pabna', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(50, 37, 'Panchagarh', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(51, 29, 'Patuakhali', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(52, 31, 'Pirojpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(53, 58, 'Rajbari ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(54, 4, 'Rajshahi', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(55, 59, 'Rangamati ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(56, 25, 'Rangpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(57, 51, 'Satkhira', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(58, 64, 'Shariatpur ', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(59, 33, 'Sherpur', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(60, 10, 'Sirajganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(61, 45, 'Sunamganj', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(62, 3, 'Sylhet', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(63, 13, 'Tangail', '2025-05-11 12:21:23', '2025-05-11 12:21:23'),
(64, 36, 'Thakurgaon ', '2025-05-11 12:21:23', '2025-05-11 12:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `pathao_zones`
--

CREATE TABLE `pathao_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pathao_zones`
--

INSERT INTO `pathao_zones` (`id`, `parent_id`, `city_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 156, 52, 'Bagerhat Sadar', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(2, 594, 52, 'Chitalmari', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(3, 989, 52, 'Dacope', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(4, 595, 52, 'Fakirhat', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(5, 596, 52, 'Kachua', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(6, 593, 52, 'Mollahat', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(7, 868, 52, 'Mongla', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(8, 597, 52, 'Morelganj', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(9, 598, 52, 'Rampal', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(10, 599, 52, 'Rayenda', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(11, 984, 52, 'Sarankhola', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(12, 714, 62, 'Alikadam', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(13, 166, 62, 'Bandarban Sadar', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(14, 692, 62, 'Kalaghata', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(15, 696, 62, 'Lama', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(16, 1008, 62, 'Naikhong', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(17, 693, 62, 'Roanchhari', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(18, 695, 62, 'Thanchi', '2025-05-12 13:01:45', '2025-05-12 13:01:45'),
(19, 931, 34, 'Amtali', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(20, 933, 34, 'Bamna', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(21, 135, 34, 'Barguna Sadar', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(22, 932, 34, 'Betagi', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(23, 934, 34, 'Patharghata', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(24, 930, 34, 'Taltoli', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(25, 911, 17, 'Agailzhara', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(26, 916, 17, 'Babuganj', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(27, 915, 17, 'Bakergonj', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(28, 914, 17, 'Banaripara', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(29, 1014, 17, 'Barisal Bandor Thana', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(30, 113, 17, 'Barisal Sadar', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(31, 910, 17, 'Gauronodi', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(32, 912, 17, 'Hizla', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(33, 909, 17, 'Kotowali', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(34, 607, 17, 'Mahendiganj', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(35, 913, 17, 'Muladi', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(36, 917, 17, 'Wazirpur Powrosova', '2025-05-12 13:01:46', '2025-05-12 13:01:46'),
(37, 546, 32, 'Akhaura', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(38, 728, 32, 'Asugonj', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(39, 133, 32, 'Banchharampur', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(40, 748, 32, 'Bijoynagar', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(41, 547, 32, 'Brahamanbaria Sadar', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(42, 548, 32, 'Kasba', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(43, 549, 32, 'Nabinagar', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(44, 551, 32, 'Nasirnagar', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(45, 550, 32, 'Sarail', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(46, 157, 53, 'Bhola Sadar', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(47, 900, 53, 'Burhanuddin', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(48, 903, 53, 'Char fashion', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(49, 904, 53, 'Dokkhin aicha', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(50, 899, 53, 'Doulatkhan', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(51, 901, 53, 'Lalmohon', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(52, 902, 53, 'Tazumuddin', '2025-05-12 13:01:47', '2025-05-12 13:01:47'),
(53, 753, 9, 'Adamdighi', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(54, 480, 9, 'Bogra - Gabtoli', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(55, 104, 9, 'Bogra Sadar', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(56, 756, 9, 'Dhunat', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(57, 719, 9, 'Dupchachia', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(58, 479, 9, 'Kahalu', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(59, 754, 9, 'Nandigram', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(60, 752, 9, 'Sariakandi', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(61, 1488, 9, 'Shahjahanpur', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(62, 751, 9, 'Shajahanpur-Bogra', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(63, 757, 9, 'Shantaher', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(64, 478, 9, 'Sherpur', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(65, 481, 9, 'Shibganj', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(66, 755, 9, 'Sonatola', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(67, 102, 8, 'Chandpur Sadar', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(68, 563, 8, 'Faridganj', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(69, 565, 8, 'Hayemchar', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(70, 564, 8, 'Haziganj', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(71, 566, 8, 'Kachua', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(72, 667, 8, 'Matlab', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(73, 749, 8, 'Matlab-Uttar', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(74, 567, 8, 'Shahrasti', '2025-05-12 13:01:48', '2025-05-12 13:01:48'),
(75, 558, 15, 'Bholahat', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(76, 111, 15, 'Chapainawabganj Sadar', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(77, 508, 15, 'Gomastapur', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(78, 559, 15, 'Nachole', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(79, 509, 15, 'Shibganj', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(80, 78, 2, 'Akbarsha', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(81, 434, 2, 'Anawara', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(82, 69, 2, 'Andarkilla', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(83, 453, 2, 'Anowara', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(84, 83, 2, 'Bakoliya thana', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(85, 459, 2, 'Bashkhali', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(86, 80, 2, 'Bayazid', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(87, 681, 2, 'Boalkhali', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(88, 1027, 2, 'Bondor', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(89, 1015, 2, 'Chandanaish', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(90, 375, 2, 'Chandgaon', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(91, 79, 2, 'Chawkbazar (Chattogram)', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(92, 460, 2, 'CTG - Lohagara', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(93, 1032, 2, 'Dohajari', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(94, 86, 2, 'Double mooring', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(95, 400, 2, 'East Joara', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(96, 405, 2, 'Enayet bazar', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(97, 73, 2, 'EPZ', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(98, 417, 2, 'Fatikchhari', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(99, 75, 2, 'Halishahar', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(100, 81, 2, 'Hathazari', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(101, 993, 2, 'Karnophuli', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(102, 716, 2, 'Keranihat', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(103, 84, 2, 'Khulshi', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(104, 364, 2, 'Kotowali Chittagong', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(105, 987, 2, 'Kotwali (Chattogram)', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(106, 70, 2, 'Lalkhan Bazar', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(107, 87, 2, 'Mirsharai', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(108, 685, 2, 'Nasirabad', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(109, 703, 2, 'Nazirhat', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(110, 72, 2, 'New Market CTG', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(111, 986, 2, 'Pahartali', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(112, 333, 2, 'Panchlaish ctg', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(113, 457, 2, 'Patia', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(114, 378, 2, 'Rangunia', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(115, 68, 2, 'Raozan', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(116, 365, 2, 'Sadarghat (Chattogram)', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(117, 705, 2, 'Sandwip', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(118, 371, 2, 'Satkaniya', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(119, 420, 2, 'Sitakunda', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(120, 1026, 2, 'Vatiary', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(121, 730, 2, 'Zorarganj', '2025-05-12 13:01:49', '2025-05-12 13:01:49'),
(122, 647, 61, 'Alamdanga', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(123, 165, 61, 'Chuadanga Sadar', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(124, 591, 61, 'Damurhuda', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(125, 968, 61, 'Darshana', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(126, 592, 61, 'Doulatganj', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(127, 646, 61, 'Jiban nagar', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(128, 107, 11, 'Chakaria', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(129, 106, 11, 'Cox\'s bazar Sadar', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(130, 898, 11, 'Eidgah', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(131, 638, 11, 'Kutubdia', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(132, 896, 11, 'Moheshkhali', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(133, 560, 11, 'Pakua', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(134, 561, 11, 'Ramu', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(135, 897, 11, 'Teknaf', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(136, 562, 11, 'Ukhia', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(137, 2019, 5, 'Adarsha Sadar', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(138, 534, 5, 'Barura', '2025-05-12 13:01:50', '2025-05-12 13:01:50'),
(139, 738, 5, 'Batakandi', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(140, 91, 5, 'B.Para', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(141, 92, 5, 'B. Para - Burichang', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(142, 98, 5, 'Chandina', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(143, 97, 5, 'Chauddagram', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(144, 1497, 5, 'Chayfullakandi', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(145, 732, 5, 'Comilla Companigonj', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(146, 741, 5, 'Cumilla Cantonment', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(147, 93, 5, 'Cumilla Sadar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(148, 734, 5, 'Cumilla Sadar Dakkhin ', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(149, 545, 5, 'Daudkandi', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(150, 1528, 5, 'Delivery Cumilla City A', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(151, 1529, 5, 'Delivery Cumilla City B', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(152, 99, 5, 'Devidwar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(153, 736, 5, 'Eliotgonj', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(154, 1496, 5, 'Farry Ghat', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(155, 737, 5, 'Gouripur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(156, 96, 5, 'Homna', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(157, 2020, 5, 'Kangshanagar ', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(158, 731, 5, 'Kotbari', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(159, 94, 5, 'Laksam', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(160, 735, 5, 'Lalmai', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(161, 740, 5, 'Meghna ', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(162, 552, 5, 'Mia-Bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(163, 733, 5, 'Monohorgonj', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(164, 2034, 5, 'Moynamoti', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(165, 103, 5, 'Muddafarganj', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(166, 553, 5, 'Muradnagar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(167, 95, 5, 'Nangolkot', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(168, 2021, 5, 'Nimshar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(169, 1494, 5, 'Ruposhdi', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(170, 1495, 5, 'Sonarampur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(171, 739, 5, 'Titash', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(172, 298, 1, '60 feet', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(173, 1070, 1, 'Abdullahpur Uttara', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(174, 1066, 1, 'Abul Hotel', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(175, 52, 1, 'Adabor', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(176, 1094, 1, 'Adarsha Nagar - Kutubpur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(177, 300, 1, 'Aftab Nagar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(178, 1764, 1, 'Aganagar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(179, 17, 1, 'Agargaon', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(180, 1108, 1, 'Agargaon-Taltola', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(181, 1757, 1, 'Akran Bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(182, 1465, 1, 'Amin Bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(183, 1765, 1, 'Amritopur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(184, 1749, 1, 'Amtola', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(185, 317, 1, 'Arambag', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(186, 965, 1, 'Ashkona', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(187, 1538, 1, 'Ashulia Bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(188, 1041, 1, 'azampur (Uttara)', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(189, 55, 1, 'Azimpur (Lalbag)', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(190, 30, 1, 'Badda', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(191, 312, 1, 'Baily Road', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(192, 1476, 1, 'Baipail', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(193, 274, 1, 'Bakshi Bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(194, 1466, 1, 'Bakurta', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(195, 292, 1, 'Balughat', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(196, 1, 1, 'Banani', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(197, 181, 1, 'Banani DOHS', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(198, 1763, 1, 'banani hq', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(199, 24, 1, 'Banasree (Block A-G)', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(200, 1058, 1, 'Banasree (Block H-J)', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(201, 40, 1, 'Bangla bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(202, 355, 1, 'Banglamotor', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(203, 250, 1, 'Bangshal', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(204, 1531, 1, 'Bank Colony, Savar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(205, 958, 1, 'Baridhara Diplomatic Zone', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(206, 959, 1, 'Baridhara DOHS', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(207, 960, 1, 'Baridhara J Block', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(208, 1747, 1, 'Barobaria', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(209, 1477, 1, 'Baroipara', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(210, 303, 1, 'Bashabo', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(211, 6, 1, 'Bashundhara R/A', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(212, 176, 1, 'Bawnia', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(213, 1138, 1, 'Begunbari', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(214, 1132, 1, 'Benaroshi Polli', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(215, 1169, 1, 'Benaroshi polli Blok A', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(216, 1170, 1, 'Benaroshi polli Blok B,C', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(217, 1171, 1, 'Benaroshi polli Blok D', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(218, 981, 1, 'Beraid', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(219, 1554, 1, 'Bibir Bagicha', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(220, 1167, 1, 'Block A,B, Mirpur 6', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(221, 1154, 1, 'Block A, C, Mirpur 11', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(222, 1155, 1, 'Block B, D, Mirpur 11', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(223, 1166, 1, 'Block D,E , Mirpur 6', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(224, 1165, 1, 'Block-E, Mirpur 12', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(225, 1759, 1, 'Bolivodro', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(226, 1503, 1, 'Borobag', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(227, 964, 1, 'Boro Moghbazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(228, 1499, 1, 'Bosila', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(229, 1785, 1, 'Brahmonkitta', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(230, 351, 1, 'BUET', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(231, 1168, 1, 'Bulk Merchant', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(232, 972, 1, 'Central Road', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(233, 1478, 1, 'Chakraborty', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(234, 1539, 1, 'Charabag, Ashulia', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(235, 630, 1, 'ChawkBazar (Dhaka)', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(236, 1766, 1, 'Chunkutia', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(237, 15, 1, 'Dakshinkhan', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(238, 287, 1, 'Darussalam', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(239, 245, 1, 'Demra', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(240, 1533, 1, 'Deogao, Savar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(241, 342, 1, 'Dhaka cantonment', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(242, 1056, 1, 'Dhaka Medical', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(243, 1501, 1, 'Dhaka Uddyan', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(244, 200, 1, 'Dhaka University', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(245, 1744, 1, 'Dhamrai', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(246, 1016, 1, 'Dhamrai , Savar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(247, 62, 1, 'Dhanmondi', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(248, 1552, 1, 'Dholaipar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(249, 979, 1, 'Dholpur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(250, 264, 1, 'Dhonia', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(251, 1745, 1, 'Dhulivita', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(252, 1045, 1, 'Diabari', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(253, 966, 1, 'DIT Road', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(254, 1948, 1, 'Document-Central', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(255, 1075, 1, 'Dohar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(256, 23, 1, 'ECB', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(257, 967, 1, 'Elephant Road', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(258, 1479, 1, 'EPZ', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(259, 1079, 1, 'Equria Thana', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(260, 311, 1, 'Eskaton', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(261, 1149, 1, 'Estern Housing', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(262, 1131, 1, 'Extension Pallabi', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(263, 13, 1, 'Faidabad', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(264, 978, 1, 'Faridabad', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(265, 46, 1, 'Farmgate', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(266, 1469, 1, 'Fulbariya', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(267, 293, 1, 'Gabtoli', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(268, 42, 1, 'Gandaria', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(269, 1537, 1, 'Ganda, Savar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(270, 1767, 1, 'GhatarChar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(271, 1097, 1, 'Giridhara Abashik', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(272, 1541, 1, 'Gobindopur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(273, 1768, 1, 'Golam Bazar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(274, 254, 1, 'Gopibagh', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(275, 308, 1, 'Goran', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(276, 1062, 1, 'Gulbagh', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(277, 35, 1, 'Gulisthan', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(278, 4, 1, 'Gulshan 1', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(279, 5, 1, 'Gulshan 2', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(280, 1769, 1, 'Hasnabad', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(281, 213, 1, 'Hatirpool', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(282, 56, 1, 'Hazaribagh', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(283, 1467, 1, 'Hemayetpur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(284, 1043, 1, 'house building', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(285, 1935, 1, 'Huzurbari Gate', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(286, 1035, 1, 'Ibrahimpur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(287, 1984, 1, 'Islambag', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(288, 257, 1, 'Islampur', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(289, 243, 1, 'Islampur (Dhamrai)', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(290, 1520, 1, 'Jahangirnagar, Savar', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(291, 1473, 1, 'Jamgora', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(292, 1054, 1, 'Jhauchor', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(293, 61, 1, 'Jigatola', '2025-05-12 13:01:51', '2025-05-12 13:01:51'),
(294, 1063, 1, 'Joardar Lane', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(295, 1934, 1, 'Jonopoth More Bus Stop', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(296, 1150, 1, 'Journalist Residential Area', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(297, 977, 1, 'Jurain', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(298, 980, 1, 'Kadamtoli', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(299, 63, 1, 'Kalabagan', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(300, 1491, 1, 'kalachadpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(301, 1746, 1, 'Kalampur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(302, 1771, 1, 'Kalindi', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(303, 64, 1, 'Kallyanpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(304, 252, 1, 'Kamalapur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(305, 655, 1, 'Kamranggirchar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(306, 1938, 1, 'Karatitola', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(307, 1556, 1, 'Katashur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(308, 1536, 1, 'Katghora, Savar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(309, 59, 1, 'Kathalbagan', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(310, 1750, 1, 'Kawalipara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(311, 16, 1, 'Kawla', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(312, 58, 1, 'Kawran Bazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(313, 286, 1, 'Kazipara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(314, 66, 1, 'Keraniganj', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(315, 1772, 1, 'Keraniganj Abdullahpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(316, 1773, 1, 'Keraniganj Atibazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(317, 1774, 1, 'Keraniganj BoshundhoraRiverview ', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(318, 1770, 1, 'Keraniganj Kaliganj', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(319, 1077, 1, 'Keraniganj Model Thana', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(320, 1775, 1, 'Keraniganj Rajendrapur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(321, 1776, 1, 'Khejurbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(322, 29, 1, 'Khilgaon', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(323, 178, 1, 'Khilkhet', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(324, 1777, 1, 'Kholamura', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(325, 1748, 1, 'Khorarchar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(326, 290, 1, 'Kochukhet', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(327, 1778, 1, 'Kodomtoli.', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(328, 1779, 1, 'Kolatia', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(329, 1756, 1, 'Kolma', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(330, 1780, 1, 'Konakhola', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(331, 247, 1, 'Konapara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(332, 239, 1, 'Kotwali (Dhaka)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(333, 177, 1, 'Kuril', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(334, 1551, 1, 'Kutubkhali', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(335, 260, 1, 'Lakshmibazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(336, 57, 1, 'Lalbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(337, 1036, 1, 'Lalkuthi', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(338, 1498, 1, 'Lalmatia', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(339, 1540, 1, 'LaxmiBazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(340, 1102, 1, 'london market', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(341, 1140, 1, 'lost', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(342, 1157, 1, 'Love Road, Mirpur-2', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(343, 1093, 1, 'Madani nagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(344, 1065, 1, 'Malibagh  Baganbari', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(345, 1060, 1, 'Malibagh College Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(346, 1061, 1, 'Malibagh Lane', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(347, 1064, 1, 'Malibagh Pabna Colony', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(348, 1937, 1, 'Maloncho Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(349, 971, 1, 'Manda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(350, 337, 1, 'Manikdi', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(351, 251, 1, 'Manik Nagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(352, 1158, 1, 'Masjid Market, Mirpur 2', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(353, 291, 1, 'Matikata', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(354, 255, 1, 'Matuail', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(355, 1134, 1, 'Mazar road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(356, 1099, 1, 'Middle Rosulbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(357, 1553, 1, 'Mirhazirbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(358, 171, 1, 'Mirpur 1', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(359, 19, 1, 'Mirpur 10', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(360, 20, 1, 'Mirpur 11', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(361, 1156, 1, 'Mirpur 11 Lalmatia', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(362, 280, 1, 'Mirpur 12', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(363, 1163, 1, 'Mirpur 12 Block A,C', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(364, 1164, 1, 'Mirpur 12 Block-Dhak, B', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(365, 1176, 1, 'Mirpur 12 Block Ta', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(366, 717, 1, 'Mirpur 13', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(367, 21, 1, 'Mirpur 14', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(368, 1151, 1, 'Mirpur 1 Market Area', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(369, 22, 1, 'Mirpur 2', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(370, 283, 1, 'Mirpur 6', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(371, 1172, 1, 'Mirpur 6 (Block C)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(372, 475, 1, 'Mirpur 7', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(373, 1159, 1, 'Mirpur Cantonment', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(374, 1174, 1, 'Mirpur Cantonment (Ave new 3 )', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(375, 281, 1, 'Mirpur DOHS', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(376, 1173, 1, 'Mirpur DOHS (Ave new 2)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(377, 1175, 1, 'Mirpur DOHS (Ave New 9)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(378, 1161, 1, 'Mirpur-Rupnagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(379, 315, 1, 'Modhubag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(380, 32, 1, 'Mogbazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(381, 2, 1, 'Mohakhali', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(382, 11, 1, 'Mohakhali DOHS', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(383, 50, 1, 'Mohammadpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(384, 233, 1, 'Monipur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(385, 1101, 1, 'Monumia Market', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(386, 34, 1, 'Motijheel', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(387, 307, 1, 'Mugda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(388, 1096, 1, 'mukti nagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(389, 182, 1, 'Nadda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(390, 10, 1, 'Nakhalpara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(391, 1074, 1, 'Nakhal para', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(392, 1095, 1, 'narayanpur - keshobpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(393, 266, 1, 'Narinda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(394, 627, 1, 'Nawabganj (Dhaka)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(395, 1076, 1, 'Nawabganj (Dohar)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(396, 259, 1, 'Nawabpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(397, 41, 1, 'Naya Bazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(398, 1139, 1, 'Nayanagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(399, 205, 1, 'Nazim Uddin Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(400, 36, 1, 'Nazira Bazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(401, 60, 1, 'New Elephant Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(402, 201, 1, 'New Market', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(403, 1055, 1, 'new paltan azimpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(404, 1942, 1, 'New Town R/A ', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(405, 9, 1, 'Niketan', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(406, 8, 1, 'Nikunja', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(407, 961, 1, 'Nikunja 2', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(408, 210, 1, 'Nilkhet', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(409, 1092, 1, 'Nimaikishori', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(410, 1470, 1, 'Nischintapur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(411, 1482, 1, 'Nobinagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(412, 1500, 1, 'Nobodoy', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(413, 1471, 1, 'Norosinhopur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(414, 1557, 1, 'North Badda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(415, 1113, 1, 'North Sanarpar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(416, 179, 1, 'Notun Bazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(417, 1484, 1, 'Noyarhat', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(418, 1067, 1, 'Noyatola road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(419, 316, 1, 'Nurerchala', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(420, 2035, 1, 'On-Demand', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(421, 1009, 1, 'On-demand  transfer', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(422, 18, 1, 'Paikpara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(423, 1534, 1, 'Pakiza, Savar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(424, 975, 1, 'Pallabi', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(425, 1160, 1, 'Pallabi Residential area', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(426, 1481, 1, 'Palli Bidyut', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(427, 33, 1, 'Paltan', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(428, 750, 1, 'Panthapath', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(429, 1939, 1, 'Paterbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(430, 2016, 1, 'Pathao Central FTL', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(431, 2017, 1, 'Pathao Central LTL', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(432, 973, 1, 'Pirerbagh', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(433, 1480, 1, 'Polashbari', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(434, 1940, 1, 'Polashpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(435, 1530, 1, 'Radio Colony, Savar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(436, 1535, 1, 'Rajashon, Savar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(437, 1042, 1, 'rajlakkhi market', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(438, 28, 1, 'Rampura', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(439, 324, 1, 'ranavola', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(440, 244, 1, 'Rayerbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(441, 1071, 1, 'Rayer Bazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(442, 1137, 1, 'Razarbag Police line', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(443, 1543, 1, 'Rohitpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(444, 974, 1, 'Rupnagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(445, 258, 1, 'Sadarghat (Dhaka)', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(446, 1941, 1, 'Saddam Market', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(447, 1472, 1, 'Sarkar Market', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(448, 1754, 1, 'Savar Bazar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(449, 1046, 1, 'Savar-Nabinagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(450, 1755, 1, 'Savar Thana Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(451, 39, 1, 'Saydabad', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(452, 1936, 1, 'Sayedabad Bus Terminal', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(453, 173, 1, 'Senpara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(454, 1502, 1, 'Senpara Parbata', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(455, 1162, 1, 'Shagufta Block-D', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(456, 1135, 1, 'Shah Ali Bag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(457, 199, 1, 'Shahbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(458, 1550, 1, 'Shahid Faruk Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(459, 957, 1, 'Shahid Nagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(460, 180, 1, 'Shahjadpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(461, 318, 1, 'Shajahanpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(462, 976, 1, 'shampur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(463, 38, 1, 'Shanir Akhra', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(464, 1072, 1, 'shankar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(465, 26, 1, 'Shantinagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(466, 302, 1, 'Shegunbagicha', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(467, 1542, 1, 'Sheikhdi', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(468, 1152, 1, 'Sheikh Rasel Park', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(469, 1037, 1, 'Sher-e Bangla Nagar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(470, 1133, 1, 'Sher-E-Bangla National Cricket Stadium', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(471, 174, 1, 'Shewrapara', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(472, 306, 1, 'Shiddeshwari', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(473, 1100, 1, 'Shimrail', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(474, 1474, 1, 'Shimultola Jamgora', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(475, 1532, 1, 'Shimultola, Savar', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(476, 1128, 1, 'Shishu Mela', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(477, 304, 1, 'Shobujbag', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(478, 31, 1, 'Shonalibagh', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(479, 1555, 1, 'Shukrabad', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(480, 1782, 1, 'Shuvadda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(481, 198, 1, 'Shyamoli', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(482, 1468, 1, 'Singair Road', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(483, 1492, 1, 'Solmaid', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(484, 297, 1, 'SONY Cinema Hall', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(485, 1558, 1, 'South Badda', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(486, 963, 1, 'South Banasree', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(487, 1111, 1, 'South kafrul', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(488, 1487, 1, 'Sreepur-Kashimpur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(489, 661, 1, 'Sutrapur', '2025-05-12 13:01:52', '2025-05-12 13:01:52'),
(490, 1136, 1, 'Technical', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(491, 3, 1, 'Tejgaon', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(492, 1559, 1, 'Tejkunipara', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(493, 1485, 1, 'Tenari Savar', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(494, 282, 1, 'Tolarbag', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(495, 327, 1, 'Turag', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(496, 1475, 1, 'Unique Bus Stand', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(497, 12, 1, 'Uttara Sector 1', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(498, 941, 1, 'Uttara Sector 10', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(499, 942, 1, 'Uttara Sector 11', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(500, 943, 1, 'Uttara Sector 12', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(501, 944, 1, 'Uttara Sector 13', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(502, 945, 1, 'Uttara Sector 14', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(503, 1000, 1, 'Uttara Sector 15', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(504, 1001, 1, 'Uttara Sector 16', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(505, 1002, 1, 'Uttara Sector 17', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(506, 1003, 1, 'Uttara Sector 18', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(507, 935, 1, 'Uttara Sector 3', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(508, 936, 1, 'Uttara Sector 4', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(509, 937, 1, 'Uttara Sector 5', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(510, 938, 1, 'Uttara sector 6', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(511, 939, 1, 'Uttara Sector 7', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(512, 946, 1, 'Uttara Sector 8', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(513, 940, 1, 'Uttara Sector 9', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(514, 14, 1, 'UttarKhan', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(515, 1483, 1, 'Vadail', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(516, 289, 1, 'Vasan Tek', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(517, 236, 1, 'Vootergoli', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(518, 37, 1, 'Wari', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(519, 1109, 1, 'West Agargaon', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(520, 1112, 1, 'West Kafrul', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(521, 1783, 1, 'Zazira', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(522, 1784, 1, 'Zinzira', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(523, 1758, 1, 'Zirabo', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(524, 1486, 1, 'Zirani', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(525, 1153, 1, 'Zoo Road', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(526, 582, 35, 'Biral', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(527, 817, 35, 'Birampur', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(528, 811, 35, 'Birganj', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(529, 814, 35, 'Bochaganj', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(530, 810, 35, 'Chirirbandar', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(531, 136, 35, 'Dinajpur Sadar', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(532, 816, 35, 'Fulbari', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(533, 819, 35, 'Ghoraghat', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(534, 820, 35, 'Hakimpur (Hili)', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(535, 812, 35, 'Kaharol', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(536, 813, 35, 'Khanshama', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(537, 818, 35, 'Nawabganj Dinajpur', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(538, 815, 35, 'Parbatipur', '2025-05-12 13:01:53', '2025-05-12 13:01:53'),
(539, 922, 18, 'Alfadanga', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(540, 923, 18, 'Bhanga', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(541, 924, 18, 'Boalmari', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(542, 925, 18, 'Charbhadrashan', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(543, 114, 18, 'Faridpur Sadar', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(544, 2001, 18, 'Madhukhali Upazila', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(545, 926, 18, 'Madukhali', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(546, 927, 18, 'Nagarkanda', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(547, 928, 18, 'Sadarpur', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(548, 929, 18, 'Saltha', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(549, 568, 6, 'Chhagalnaiya', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(550, 569, 6, 'Daganbhuiyan', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(551, 100, 6, 'Feni Sadar', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(552, 746, 6, 'Ful-Gazi', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(553, 572, 6, 'Pashuram', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(554, 573, 6, 'Sonagazi', '2025-05-12 13:01:54', '2025-05-12 13:01:54'),
(555, 781, 38, 'Fulchhari', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(556, 139, 38, 'Gaibandha Sadar', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(557, 645, 38, 'Gobindaganj', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(558, 644, 38, 'Palashbari', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(559, 782, 38, 'Sadulllahpur', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(560, 783, 38, 'Saghata', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(561, 784, 38, 'Sundarganj', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(562, 1732, 22, '1 No CNB', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(563, 1733, 22, '2 No CNB', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(564, 1714, 22, 'Ambagh', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(565, 1184, 22, 'Amraid', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(566, 1731, 22, 'Anser Road', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(567, 1182, 22, 'Aral', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(568, 1719, 22, 'Arikhola', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(569, 1727, 22, 'Bagher Bazar', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(570, 1736, 22, 'Barotopa', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(571, 863, 22, 'Bason', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(572, 1723, 22, 'Bhabanipur', '2025-05-12 13:01:55', '2025-05-12 13:01:55'),
(573, 1178, 22, 'Bhawal Mirzapur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(574, 862, 22, 'Board Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(575, 1722, 22, 'Bonmala', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(576, 1742, 22, 'Bormi Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(577, 861, 22, 'Borobari', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(578, 1183, 22, 'Chalar Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(579, 1710, 22, 'Chondra', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(580, 859, 22, 'College gate', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(581, 1718, 22, 'Dolan Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(582, 1760, 22, 'Fulbaria.', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(583, 990, 22, 'Gacha', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(584, 860, 22, 'Gazipura', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(585, 123, 22, 'Gazipur Chowrasta', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(586, 1730, 22, 'Gorgoria Masterbari', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(587, 1751, 22, 'Haydrabad', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(588, 866, 22, 'Hotapara', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(589, 1720, 22, 'Jamalpur Kaliganj', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(590, 1741, 22, 'Joina Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(591, 1713, 22, 'Jorun', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(592, 864, 22, 'Joydebpur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(593, 724, 22, 'Kaliakair', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(594, 715, 22, 'Kaliganj', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(595, 1743, 22, 'Kaoraid', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(596, 865, 22, 'Kapashiya', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(597, 1181, 22, 'Kapasia', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(598, 1048, 22, 'Kashimpur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(599, 1737, 22, 'Kawran Bazar Mawna', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(600, 1068, 22, 'Konabari', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(601, 1547, 22, 'Majukhan', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(602, 1752, 22, 'Maleker Bari', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(603, 867, 22, 'Mawna', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(604, 1735, 22, 'Mawna Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(605, 1734, 22, 'Mawna Chowrasta', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(606, 1738, 22, 'Mawna Gazipur Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(607, 1739, 22, 'MC Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(608, 1549, 22, 'Mirer Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(609, 1725, 22, 'Monipur Mawna', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(610, 1047, 22, 'Mowchak', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(611, 1740, 22, 'Nayonpur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(612, 1728, 22, 'Notun Bazar Mawna', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(613, 1726, 22, 'Pach Pirer Mazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(614, 1724, 22, 'Pirozali', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(615, 1711, 22, 'Pollibiddut', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(616, 1177, 22, 'Porabari', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(617, 1717, 22, 'PRAN RFL Gate', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(618, 1546, 22, 'Pubail', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(619, 1729, 22, 'Puran Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(620, 1716, 22, 'Raja Bari Sreepur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(621, 1179, 22, 'Rajendrapur Bangla Bazar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(622, 1180, 22, 'Rajendrapur Cantonment', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(623, 1715, 22, 'Raniganj', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(624, 1753, 22, 'Salna', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(625, 1712, 22, 'Shafipur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(626, 1544, 22, 'Shimultoli', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(627, 529, 22, 'Sreepur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(628, 1721, 22, 'Station Road Tongi', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(629, 1185, 22, 'Toke', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(630, 517, 22, 'Tongi', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(631, 858, 22, 'Tongi Cherag Ali', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(632, 1548, 22, 'Ulukhola', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(633, 160, 56, 'Gopalganj Sadar', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(634, 918, 56, 'Kashiani', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(635, 919, 56, 'Kotalipara', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(636, 920, 56, 'Muksudpur', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(637, 921, 56, 'Tungipara', '2025-05-12 13:01:56', '2025-05-12 13:01:56'),
(638, 684, 30, 'Azmireeganj', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(639, 725, 30, 'Bahubal', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(640, 842, 30, 'Baniachong', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(641, 843, 30, 'Chunarughat', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(642, 131, 30, 'Habiganj Sadar', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(643, 844, 30, 'Lakhai', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(644, 726, 30, 'Madhabpur', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(645, 727, 30, 'Nabiganj', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(646, 1490, 30, 'Shaistaganj', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(647, 871, 41, 'Bakshiganj', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(648, 519, 41, 'Dewangonj', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(649, 649, 41, 'Islampur (Jamalpur)', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(650, 143, 41, 'Jamalpur Sadar', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(651, 532, 41, 'Madarganj', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(652, 531, 41, 'Melandaha', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(653, 533, 41, 'Sarishabari', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(654, 600, 19, 'Bagharpara', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(655, 116, 19, 'Benapole', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(656, 601, 19, 'Chaugachha', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(657, 115, 19, 'Jessore Sadar', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(658, 602, 19, 'Jhikargachha', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(659, 603, 19, 'Keshabpur', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(660, 604, 19, 'Monirampur', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(661, 605, 19, 'Obhoynagar', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(662, 606, 19, 'Sarsa', '2025-05-12 13:01:57', '2025-05-12 13:01:57'),
(663, 128, 27, 'Jhalokathi Sadar', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(664, 583, 27, 'Kathalia', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(665, 609, 27, 'Nalchhiti', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(666, 608, 27, 'Rajapur', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(667, 465, 49, 'Harinakundu', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(668, 153, 49, 'Jhenaidah sadar', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(669, 466, 49, 'Kaligonj-Jhenidah', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(670, 467, 49, 'Kotchandpur', '2025-05-12 13:01:58', '2025-05-12 13:01:58');
INSERT INTO `pathao_zones` (`id`, `parent_id`, `city_id`, `name`, `created_at`, `updated_at`) VALUES
(671, 468, 49, 'Maheshpur', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(672, 469, 49, 'Shailakupa', '2025-05-12 13:01:58', '2025-05-12 13:01:58'),
(673, 787, 48, 'Akkelpur', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(674, 152, 48, 'Joypurhat Sadar', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(675, 785, 48, 'Kalai', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(676, 786, 48, 'Khetlal', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(677, 687, 48, 'Panchbibi', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(678, 1142, 63, 'Bagaichari', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(679, 709, 63, 'Dighinala', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(680, 888, 63, 'Guimara', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(681, 167, 63, 'Khagrachari Sadar', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(682, 890, 63, 'Lakkhichhari', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(683, 1143, 63, 'Langodu', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(684, 997, 63, 'Mahalchhari', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(685, 893, 63, 'Maischori', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(686, 891, 63, 'Manikchhari', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(687, 892, 63, 'Matiranga', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(688, 894, 63, 'Mohalchori', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(689, 895, 63, 'Panchhari', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(690, 889, 63, 'Ramgar', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(691, 1947, 63, 'Tabalcchari', '2025-05-12 13:01:59', '2025-05-12 13:01:59'),
(692, 515, 20, 'Batiaghata', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(693, 824, 20, 'Boyra', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(694, 1028, 20, 'Chandkhali', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(695, 827, 20, 'Daulatpur-Khulna ', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(696, 514, 20, 'Digholia', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(697, 516, 20, 'Dumuria', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(698, 826, 20, 'Fultola', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(699, 825, 20, 'Khalishpur', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(700, 117, 20, 'Khulna Sadar', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(701, 1006, 20, 'Kopilmuni', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(702, 1005, 20, 'Koyra', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(703, 970, 20, 'Paikgachha Upozila', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(704, 822, 20, 'Rupsha', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(705, 1545, 20, 'Shiromoni', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(706, 823, 20, 'Sonadanga', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(707, 969, 20, 'Tala Upozilla', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(708, 992, 20, 'Terokhada', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(709, 996, 42, 'Astagram', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(710, 881, 42, 'Bajitpur', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(711, 720, 42, 'Bhairab', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(712, 882, 42, 'Hossainpur', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(713, 995, 42, 'Itna', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(714, 883, 42, 'Karimganj', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(715, 1144, 42, 'Katiadi Upozila', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(716, 144, 42, 'Kishoreganj Sadar', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(717, 884, 42, 'Kuliarchar', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(718, 994, 42, 'Mithamoin', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(719, 887, 42, 'Nikli', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(720, 885, 42, 'Pakundia', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(721, 886, 42, 'Tarial', '2025-05-12 13:02:00', '2025-05-12 13:02:00'),
(722, 788, 55, 'Bhurungamari', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(723, 795, 55, 'Char Rajibpur', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(724, 792, 55, 'Chilmari', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(725, 159, 55, 'Kurigram Sadar', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(726, 793, 55, 'Nagesshari', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(727, 789, 55, 'Phulbari', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(728, 790, 55, 'Rajarhat', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(729, 794, 55, 'Rawmari', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(730, 791, 55, 'Ulipur', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(731, 636, 28, 'Bheramara', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(732, 829, 28, 'Daulatpur-Kushtia', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(733, 828, 28, 'Islamic University', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(734, 637, 28, 'Khoksha', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(735, 634, 28, 'Kumarkhali', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(736, 635, 28, 'Kushtia-Mirpur', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(737, 129, 28, 'Kushtia Sadar', '2025-05-12 13:02:01', '2025-05-12 13:02:01'),
(738, 1526, 40, 'Chandraganj', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(739, 1527, 40, 'kamalnagar', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(740, 530, 40, 'Komalnagar', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(741, 142, 40, 'Lakshimpur Sadar', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(742, 575, 40, 'Raipur', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(743, 574, 40, 'Ramganj', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(744, 747, 40, 'Ramgoti', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(745, 802, 57, 'Aditmari', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(746, 804, 57, 'Hatibandha', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(747, 803, 57, 'Kaliganj - Lalmonirhat', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(748, 161, 57, 'Lalmonirhat Sadar', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(749, 805, 57, 'Patgram', '2025-05-12 13:02:02', '2025-05-12 13:02:02'),
(750, 870, 43, 'Dasar Thana', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(751, 869, 43, 'Kalkini Thana', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(752, 1521, 43, 'Kodombari', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(753, 145, 43, 'Madaripur Sadar', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(754, 146, 43, 'Rajoir thana', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(755, 718, 43, 'Shibchar', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(756, 1522, 43, 'Takerhat Sadar', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(757, 164, 60, 'Magura Sadar', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(758, 463, 60, 'Mohammadpur-Magura', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(759, 956, 60, 'Shalikha', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(760, 464, 60, 'Sreepur (Magura)', '2025-05-12 13:02:03', '2025-05-12 13:02:03'),
(761, 1196, 16, 'ANGAR PARA', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(762, 856, 16, 'Daulatpur - Manikganj', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(763, 1194, 16, 'DAULATPUR-Manikganj', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(764, 1193, 16, 'Ghior', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(765, 854, 16, 'Ghior Thana', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(766, 853, 16, 'Harirampur', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(767, 112, 16, 'Manikganj Sadar', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(768, 857, 16, 'Saturia', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(769, 1195, 16, 'SHIBALAYA', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(770, 855, 16, 'Shivalaya', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(771, 852, 16, 'Singair', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(772, 610, 50, 'Gangni', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(773, 154, 50, 'Meherpur Sadar', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(774, 830, 50, 'Mujibnagar', '2025-05-12 13:02:04', '2025-05-12 13:02:04'),
(775, 676, 12, 'Baralekha', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(776, 678, 12, 'Juri', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(777, 679, 12, 'Kamalganj', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(778, 680, 12, 'Kulaura', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(779, 108, 12, 'Mouluvibazar Sadar', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(780, 677, 12, 'Rajnagar', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(781, 624, 12, 'Sreemangal', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(782, 1896, 23, 'Baluakandi', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(783, 821, 23, 'Gazaria', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(784, 1895, 23, 'Hosseindi', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(785, 710, 23, 'Lohajong', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(786, 124, 23, 'Munshiganj Sadar', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(787, 1506, 23, 'Pakhir mor', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(788, 1116, 23, 'Rosulpur', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(789, 711, 23, 'Sirajdikhan', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(790, 712, 23, 'Sreenagar', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(791, 713, 23, 'Tongibari', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(792, 1115, 23, 'Vabarchar', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(793, 850, 26, 'Bhaluka', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(794, 847, 26, 'Dhobaura', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(795, 511, 26, 'Fulbaria', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(796, 845, 26, 'Gafargaon', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(797, 846, 26, 'Gauripur', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(798, 851, 26, 'Haluaghat', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(799, 513, 26, 'Ishwarganj', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(800, 512, 26, 'Muktagachha', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(801, 127, 26, 'Mymensingh Sadar', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(802, 848, 26, 'Nandail', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(803, 1038, 26, 'Pagla', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(804, 849, 26, 'Phulpur', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(805, 1489, 26, 'Shomvugonj', '2025-05-12 13:02:05', '2025-05-12 13:02:05'),
(806, 1049, 26, 'Tarakanda', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(807, 510, 26, 'Trishal', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(808, 584, 46, 'Atrai', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(809, 766, 46, 'Bodolgaci', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(810, 765, 46, 'Dhamairhat', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(811, 759, 46, 'Manda (Naogaon)', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(812, 761, 46, 'Mohadebpur', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(813, 150, 46, 'Naogaon  Sadar', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(814, 760, 46, 'Niyamatpur', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(815, 764, 46, 'Porsha', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(816, 762, 46, 'Potnitola', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(817, 758, 46, 'Raninagaor', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(818, 763, 46, 'Sapaher', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(819, 706, 54, 'Kalia', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(820, 707, 54, 'Narail - Lohagara', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(821, 158, 54, 'Narail Sadar', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(822, 982, 54, 'Terokhada', '2025-05-12 13:02:06', '2025-05-12 13:02:06'),
(823, 1025, 21, '2 no gate', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(824, 1513, 21, 'Adomji', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(825, 1085, 21, 'Amlapara', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(826, 1052, 21, 'ananda bazar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(827, 721, 21, 'Araihazar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(828, 1460, 21, 'Araihazar Sador', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(829, 1569, 21, 'Atlapur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(830, 1088, 21, 'baburail', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(831, 1010, 21, 'Baidder Bazar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(832, 648, 21, 'Bandar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(833, 1508, 21, 'Bandar Amin/ Rupali', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(834, 1507, 21, 'Bandar Shabdi', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(835, 1566, 21, 'Banti-Bazar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(836, 1114, 21, 'Bausia', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(837, 1084, 21, 'Bb road', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(838, 1145, 21, 'Beldi-Daudpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(839, 1127, 21, 'Bhuighor', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(840, 1762, 21, 'Bhulta', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(841, 723, 21, 'Bhulta/Gawsia', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(842, 1189, 21, 'Bisic', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(843, 1191, 21, 'Boktaboli', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(844, 1562, 21, 'Borabo', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(845, 1568, 21, 'Chanpara-Nawra', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(846, 1120, 21, 'Chashara', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(847, 1504, 21, 'Chowdhuri bari', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(848, 1516, 21, 'Chowdhuri bari- Siddhirganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(849, 1124, 21, 'Delpara', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(850, 1505, 21, 'Deobhog', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(851, 121, 21, 'Don Chamber', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(852, 1083, 21, 'Ekrampur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(853, 1126, 21, 'Epz', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(854, 1511, 21, 'Fatullah Bazar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(855, 1517, 21, 'Fatullah Rail station ', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(856, 1761, 21, 'Gawsia', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(857, 1464, 21, 'Gopaldi', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(858, 1192, 21, 'Isdair', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(859, 1082, 21, 'Ispahani Bandar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(860, 1570, 21, 'Jahangir Road', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(861, 1017, 21, 'Jalkuri', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(862, 1033, 21, 'Kachpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(863, 1051, 21, 'kaikartek', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(864, 1560, 21, 'Kanchan', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(865, 1050, 21, 'kanchpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(866, 1089, 21, 'Kashipur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(867, 1463, 21, 'Khaira', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(868, 1123, 21, 'Khanpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(869, 1509, 21, 'Lokkhon khola', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(870, 1080, 21, 'Madanganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(871, 1004, 21, 'Madanpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(872, 1186, 21, 'Mahmudpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(873, 1118, 21, 'Majdair', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(874, 1020, 21, 'Masdair', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(875, 1188, 21, 'Mitali Market', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(876, 1039, 21, 'Modonpur', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(877, 1091, 21, 'Mograpara', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(878, 1567, 21, 'Murapara', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(879, 1081, 21, 'Nabiganj Bandar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(880, 1146, 21, 'Neela Market', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(881, 1117, 21, 'New town', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(882, 1148, 21, 'Nila Market', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(883, 1024, 21, 'Nitaiganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(884, 1564, 21, 'Nowa para - Bhulta', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(885, 1565, 21, 'Pachgaon - Bhulta', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(886, 334, 21, 'Pagla', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(887, 1087, 21, 'paikpara Narayanganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(888, 1119, 21, 'Panchabati', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(889, 1187, 21, 'Passport office (Siddhirganj)', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(890, 1518, 21, 'Pathantoli-Hajiganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(891, 1021, 21, 'Ponchoboti', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(892, 1462, 21, 'Provakordi', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(893, 1147, 21, 'Purbachal', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(894, 722, 21, 'Rupganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(895, 1561, 21, 'Rupshi', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(896, 1086, 21, 'Sayedpur - Narayanganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(897, 1103, 21, 'Shaheb para', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(898, 1022, 21, 'Shanarpar', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(899, 1018, 21, 'Shibu Market', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(900, 1125, 21, 'Shiddriganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(901, 1512, 21, 'Shiddriganj Pool', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(902, 493, 21, 'Siddirganj', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(903, 1515, 21, 'Signboard', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(904, 654, 21, 'Sonargaon', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(905, 120, 21, 'South Chashara', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(906, 1563, 21, 'Tarabo', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(907, 1510, 21, 'Tin Gao', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(908, 1461, 21, 'Uchitpura', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(909, 1190, 21, 'Volail', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(910, 1019, 21, 'Zilla Parishod', '2025-05-12 13:02:07', '2025-05-12 13:02:07'),
(911, 520, 47, 'Belabo', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(912, 1199, 47, 'Chalakchar', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(913, 1198, 47, 'Hatirdia', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(914, 708, 47, 'Madhabdi', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(915, 1197, 47, 'MONOHARDI', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(916, 521, 47, 'Monohordi', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(917, 151, 47, 'Narshingdi Sadar', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(918, 522, 47, 'Palash', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(919, 1141, 47, 'Raipura North', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(920, 523, 47, 'Raipura South', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(921, 524, 47, 'Shibpur', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(922, 503, 14, 'Bagatipara', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(923, 500, 14, 'Baraigram', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(924, 991, 14, 'Gopalpur UPO', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(925, 502, 14, 'Gurdaspur', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(926, 1007, 14, 'Lalpur', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(927, 579, 14, 'Naldanga - Natore', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(928, 110, 14, 'Natore Sadar', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(929, 501, 14, 'Singra', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(930, 872, 44, 'Atpara', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(931, 878, 44, 'Barhatta', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(932, 873, 44, 'Kalmakanda', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(933, 874, 44, 'Kendua', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(934, 875, 44, 'Khaliajuri', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(935, 879, 44, 'Madan', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(936, 880, 44, 'Mohanganj', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(937, 147, 44, 'Netrokona Sadar', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(938, 877, 44, 'Purbadhala', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(939, 876, 44, 'Susang Durgapur', '2025-05-12 13:02:08', '2025-05-12 13:02:08'),
(940, 640, 39, 'Dimla', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(941, 641, 39, 'Domar', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(942, 642, 39, 'Jaldhaka', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(943, 643, 39, 'Kishoriganj', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(944, 140, 39, 'Nilphamari Sadar', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(945, 141, 39, 'Saidpur', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(946, 590, 39, 'Taraganj ', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(947, 620, 7, 'Basurhat', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(948, 621, 7, 'Begumganj', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(949, 622, 7, 'Chatkhil', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(950, 742, 7, 'Chondrogonj Thana', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(951, 744, 7, 'Companigonj', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(952, 983, 7, 'Hatia', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(953, 1106, 7, 'Kobirhat', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(954, 639, 7, 'Maizdee', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(955, 101, 7, 'Noakhali Sadar', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(956, 623, 7, 'Senbag', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(957, 704, 7, 'Sonaimuri', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(958, 743, 7, 'Sonapur', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(959, 745, 7, 'Subornochar', '2025-05-12 13:02:09', '2025-05-12 13:02:09'),
(960, 1040, 24, 'Aminpur', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(961, 773, 24, 'Ataikula', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(962, 505, 24, 'Atghoria', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(963, 555, 24, 'Bera', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(964, 556, 24, 'Bhangura', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(965, 557, 24, 'Chatmohar', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(966, 1394, 24, 'Faridpur', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(967, 504, 24, 'Ishwardi', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(968, 772, 24, 'Kasinathpur', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(969, 770, 24, 'Pabna-Faridpur', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(970, 125, 24, 'Pabna Sadar', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(971, 771, 24, 'Sathia', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(972, 506, 24, 'Sujanagar', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(973, 554, 24, 'Tebunia', '2025-05-12 13:02:10', '2025-05-12 13:02:10'),
(974, 806, 37, 'Atwari', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(975, 809, 37, 'Boda', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(976, 808, 37, 'Debiganj', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(977, 138, 37, 'Panchagarh Sadar', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(978, 807, 37, 'Tetulia', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(979, 470, 29, 'Bauphal', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(980, 999, 29, 'Dashmina', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(981, 471, 29, 'Dumkee', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(982, 472, 29, 'Gala chipa', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(983, 473, 29, 'Kala para', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(984, 988, 29, 'Khepupara', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(985, 1034, 29, 'Mohipur', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(986, 130, 29, 'Patuakhali Sadar', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(987, 474, 29, 'Rangabali', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(988, 998, 29, 'Subidkhali', '2025-05-12 13:02:11', '2025-05-12 13:02:11'),
(989, 906, 31, 'Bhandaria', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(990, 570, 31, 'kaukhali', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(991, 907, 31, 'Mathbaria', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(992, 571, 31, 'Nazirpur', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(993, 1395, 31, 'Pirojpur-Indurkani', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(994, 132, 31, 'Pirojpur Sadar', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(995, 905, 31, 'Swarupkathi', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(996, 947, 58, 'Baliakandi', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(997, 948, 58, 'Goalanda', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(998, 950, 58, 'Kalukhali', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(999, 949, 58, 'Pangsha', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1000, 162, 58, 'Rajbari Sadar', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1001, 577, 4, 'Bagha', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1002, 497, 4, 'Bagmara', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1003, 1011, 4, 'Banseshwar', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1004, 499, 4, 'Charghat', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1005, 498, 4, 'Durgapur', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1006, 578, 4, 'Godagari', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1007, 767, 4, 'Katakhali', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1008, 495, 4, 'Mohonpur', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1009, 768, 4, 'Motihar', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1010, 494, 4, 'Paba', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1011, 576, 4, 'Puthia', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1012, 769, 4, 'Rajpara', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1013, 90, 4, 'Rajshahi Sadar (Boalia)', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1014, 580, 4, 'Shah Mokdum', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1015, 1012, 4, 'Sharda', '2025-05-12 13:02:12', '2025-05-12 13:02:12'),
(1016, 1013, 4, 'Taherpur', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1017, 496, 4, 'Tanor', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1018, 672, 59, 'Kaptai', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1019, 669, 59, 'Kawkhali Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1020, 163, 59, 'Kotwali Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1021, 673, 59, 'Nanichhar', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1022, 674, 59, 'Rajasthali', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1023, 585, 25, 'Badarganj', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1024, 586, 25, 'Gangachara', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1025, 796, 25, 'Haragach Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1026, 587, 25, 'Kaunia', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1027, 801, 25, 'Mahiganj Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1028, 588, 25, 'Mithapukur', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1029, 589, 25, 'Pirgachha', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1030, 797, 25, 'Pirganj Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1031, 799, 25, 'Porshurampur Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1032, 798, 25, 'Rangpur Cantonment', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1033, 126, 25, 'Rangpur Sadar(Kotowali Thana)', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1034, 800, 25, 'Tajhat Thana', '2025-05-12 13:02:13', '2025-05-12 13:02:13'),
(1035, 658, 51, 'Ashashuni Thana', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1036, 652, 51, 'Debhata Thana', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1037, 650, 51, 'Kalaroa', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1038, 653, 51, 'Kaliganj-Satkhira', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1039, 155, 51, 'Satkhira Sadar', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1040, 659, 51, 'Shymnagar', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1041, 651, 51, 'Tala Thana', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1042, 662, 64, 'Bhedorganj', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1043, 663, 64, 'Damudhya', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1044, 664, 64, 'Gosairhat', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1045, 665, 64, 'Jajira', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1046, 666, 64, 'Naria', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1047, 1073, 64, 'Shakhipur', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1048, 168, 64, 'Shariatpur Sadar (Palong)', '2025-05-12 13:02:14', '2025-05-12 13:02:14'),
(1049, 526, 33, 'Jhinaigati', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1050, 527, 33, 'Nakla', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1051, 528, 33, 'Nalitabari', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1052, 134, 33, 'Sherpur Sadar', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1053, 625, 33, 'Sreebardi', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1054, 581, 10, 'Belkuchi', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1055, 1029, 10, 'Chowhali', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1056, 774, 10, 'Kamarkhanda', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1057, 780, 10, 'Kazipur', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1058, 779, 10, 'Rayganj', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1059, 777, 10, 'Salonga', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1060, 775, 10, 'Shahjadpur - Shahjadpur', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1061, 105, 10, 'Sirajganj Sadar', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1062, 778, 10, 'Tarash', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1063, 776, 10, 'Ullapara', '2025-05-12 13:02:15', '2025-05-12 13:02:15'),
(1064, 834, 45, 'Bishwamvarpur', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1065, 149, 45, 'Chhatak', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1066, 836, 45, 'Derai', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1067, 835, 45, 'Dharmapasha', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1068, 837, 45, 'Dowarabazar', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1069, 619, 45, 'Jagnnathpur', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1070, 838, 45, 'Jamalganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1071, 840, 45, 'Salla', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1072, 839, 45, 'Shantiganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1073, 148, 45, 'Sunamganj Sadar', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1074, 841, 45, 'Tahirpur', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1075, 611, 3, 'Balaganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1076, 461, 3, 'Beanibazar', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1077, 612, 3, 'Bishwanath', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1078, 618, 3, 'Companyganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1079, 831, 3, 'Dakshin Surma', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1080, 613, 3, 'Fenchuganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1081, 615, 3, 'Golapganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1082, 614, 3, 'Gowainghat', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1083, 616, 3, 'Jaintapur', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1084, 617, 3, 'Kanaighat', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1085, 832, 3, 'Osmani Nagar', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1086, 89, 3, 'Sylhet Sadar', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1087, 1519, 3, 'Ward No-01', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1088, 833, 3, 'Zakiganj', '2025-05-12 13:02:16', '2025-05-12 13:02:16'),
(1089, 535, 13, 'Bashail', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1090, 536, 13, 'Bhuapur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1091, 537, 13, 'Delduar', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1092, 675, 13, 'Dhanbari', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1093, 538, 13, 'Ghatail', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1094, 539, 13, 'Gopalpur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1095, 540, 13, 'Kalihati', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1096, 541, 13, 'Madhupur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1097, 542, 13, 'Mirzapur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1098, 543, 13, 'Nagarpur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1099, 544, 13, 'Sakhipur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1100, 109, 13, 'Tangail Sadar', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1101, 951, 36, 'Baliadangi', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1102, 952, 36, 'Haripur', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1103, 953, 36, 'Pirganj', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1104, 954, 36, 'Ranisankail', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1105, 955, 36, 'Ruhiya', '2025-05-12 13:02:17', '2025-05-12 13:02:17'),
(1106, 137, 36, 'Thakurgaon Sadar', '2025-05-12 13:02:17', '2025-05-12 13:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(2, 'products.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(3, 'products.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(4, 'products.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(5, 'products.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(6, 'products.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(7, 'orders.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(8, 'orders.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(9, 'orders.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(10, 'orders.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(11, 'orders.payment_status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(12, 'orders.print', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(13, 'orders.send_courier', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(14, 'orders.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(15, 'orders.bulk.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(16, 'orders.bulk.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(17, 'orders.bulk.print', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(18, 'orders.courier_export', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(19, 'orders.bulk.send_courier', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(20, 'customers.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(21, 'customers.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(22, 'customers.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(23, 'customers.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(24, 'customers.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(25, 'suppliers.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(26, 'suppliers.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(27, 'suppliers.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(28, 'suppliers.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(29, 'suppliers.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(30, 'purchases.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(31, 'purchases.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(32, 'purchases.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(33, 'purchases.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(34, 'purchases.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(35, 'visitors.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(36, 'ip_address.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(37, 'ip_address.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(38, 'ip_address.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(39, 'couriers.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(40, 'shipping_method.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(41, 'shipping_method.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(42, 'shipping_method.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(43, 'shipping_method.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(44, 'shipping_method.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(45, 'roles.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(46, 'roles.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(47, 'roles.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(48, 'roles.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(49, 'staffs.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(50, 'staffs.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(51, 'staffs.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(52, 'staffs.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(53, 'staffs.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(54, 'settings.general', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(55, 'settings.page', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(57, 'media.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(58, 'media.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(59, 'media.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(60, 'media.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(61, 'media.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(62, 'promotion_banner.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(63, 'sliders.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(64, 'sliders.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(65, 'sliders.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(66, 'sliders.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(67, 'sliders.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(68, 'categories.list', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(69, 'categories.create', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(70, 'categories.edit', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(71, 'categories.delete', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(72, 'categories.status', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(73, 'test.list', 'admin', '2025-11-02 09:56:06', '2025-11-02 09:56:06'),
(74, 'test.create', 'admin', '2025-11-02 09:56:06', '2025-11-02 09:56:06'),
(75, 'test.edit', 'admin', '2025-11-02 09:56:06', '2025-11-02 09:56:06'),
(76, 'test.status', 'admin', '2025-11-02 09:56:06', '2025-11-02 09:56:06'),
(78, 'products.combo.list', 'admin', '2025-12-01 06:52:01', '2025-12-01 06:52:01'),
(79, 'products.combo.create', 'admin', '2025-12-01 06:52:01', '2025-12-01 06:52:01'),
(80, 'products.combo.edit', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(81, 'products.combo.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(82, 'settings.attribute', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(83, 'incomplete.order.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(84, 'incomplete.order.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(85, 'incomplete.order.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(86, 'abandoned.cart.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(87, 'abandoned.order.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(88, 'abandoned.order.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(89, 'device.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(90, 'landing.page.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(91, 'landing.page.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(92, 'landing.page.edit', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(93, 'landing.page.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(94, 'review.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(95, 'newsletter.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(96, 'newsletter.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(97, 'theme.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(98, 'theme.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(99, 'theme.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(100, 'theme.status', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(101, 'accounts.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(102, 'accounts.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(103, 'accounts.edit', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(104, 'accounts.balance.add', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(105, 'accounts.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(106, 'accounts.transaction.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(107, 'expenses.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(108, 'expenses.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(109, 'expenses.edit', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(110, 'expenses.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(111, 'expenses.category.list', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(112, 'expenses.category.create', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(113, 'expenses.category.edit', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(114, 'expenses.category.delete', 'admin', '2025-12-01 06:52:02', '2025-12-01 06:52:02'),
(120, 'dashboard.order.status', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(121, 'dashboard.order.ratio', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(122, 'dashboard.order.range', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(123, 'dashboard.stock.warning', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(124, 'dashboard.top.products', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(125, 'dashboard.courier.status', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(126, 'dashboard.expense', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(127, 'dashboard.account', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(128, 'dashboard.staff', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(129, 'dashboard.financial', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(130, 'purchase.receive.list', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(131, 'purchase.receive.create', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(132, 'purchase.receive.edit', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(133, 'purchase.receive.status', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(134, 'purchase.receive.delete', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(135, 'settings.print', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(136, 'settings.home.page', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(137, 'testimonial.list', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(138, 'testimonial.create', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(139, 'testimonial.edit', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(140, 'testimonial.delete', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(141, 'reports.sales', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(142, 'reports.sales.products', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(143, 'reports.stock.products', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(144, 'stock.control', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(145, 'stock.adjustment', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(146, 'coupon.list', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(147, 'flash.deal.list', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39'),
(148, 'marketing.list', 'admin', '2026-10-05 08:22:39', '2026-10-05 08:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `print_settings`
--

CREATE TABLE `print_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `single_print` varchar(255) NOT NULL DEFAULT '0' COMMENT '0 = default',
  `bulk_print` varchar(255) NOT NULL DEFAULT '0' COMMENT '0 = default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `print_settings`
--

INSERT INTO `print_settings` (`id`, `single_print`, `bulk_print`, `created_at`, `updated_at`) VALUES
(2, '0', '2', '2026-02-22 22:11:57', '2026-02-25 03:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `thumb` int(11) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `gallery_images` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `package_qty` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_image` varchar(255) DEFAULT NULL,
  `regular_price` decimal(10,4) DEFAULT 0.0000,
  `sale_price` decimal(10,4) DEFAULT 0.0000,
  `purchase_price` decimal(10,4) DEFAULT 0.0000,
  `has_variant` tinyint(4) NOT NULL DEFAULT 0,
  `is_combo` tinyint(4) NOT NULL DEFAULT 0,
  `is_package` tinyint(4) DEFAULT 0,
  `free_shipping` tinyint(1) DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `extra_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_fields`)),
  `related_products` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `theme_id`, `sku`, `thumb`, `image`, `gallery_images`, `name`, `slug`, `stock`, `package_qty`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `meta_image`, `regular_price`, `sale_price`, `purchase_price`, `has_variant`, `is_combo`, `is_package`, `free_shipping`, `status`, `extra_fields`, `related_products`, `created_at`, `updated_at`) VALUES
(1, 8, 'prod-001', NULL, NULL, NULL, 'test product', 'test-product', 15, 1, NULL, NULL, NULL, NULL, NULL, '1500.0000', '1000.0000', '350.0000', 0, 0, 0, 0, 1, NULL, NULL, '2026-10-07 06:11:22', '2026-10-10 11:16:42'),
(2, 8, 'prod-002', NULL, NULL, NULL, 'test product-02', 'test-product-02', 99, 1, NULL, NULL, NULL, NULL, NULL, '2000.0000', '1500.0000', '360.0000', 0, 0, 0, 0, 1, NULL, NULL, '2026-10-07 06:12:00', '2026-10-10 11:16:42'),
(3, 8, 'prod-003', NULL, NULL, NULL, 'test product-03', 'test-product-03', 97, 1, NULL, NULL, NULL, NULL, NULL, '1200.0000', '800.0000', '250.0000', 1, 0, 0, 0, 1, NULL, NULL, '2026-10-07 06:12:50', '2026-10-12 03:36:42'),
(4, 8, 'adfsdf', NULL, NULL, NULL, 'Combo Product', 'combo-product', -2, NULL, NULL, NULL, NULL, NULL, NULL, '3500.0000', '2500.0000', '0.0000', 0, 1, 0, 0, 1, NULL, NULL, '2026-10-07 06:14:11', '2026-10-10 11:10:33'),
(9, 8, 'dfdf', NULL, NULL, NULL, 'combo product - 02', 'combo-product-02', -3, NULL, NULL, NULL, NULL, NULL, NULL, '3200.0000', '2300.0000', '0.0000', 0, 1, 0, 0, 1, NULL, NULL, '2026-10-10 04:31:41', '2026-10-10 11:10:33'),
(10, 8, 'sssss', NULL, NULL, NULL, 'combo product-03', 'combo-product-03', 0, NULL, NULL, NULL, NULL, NULL, NULL, '1200.0000', '800.0000', '0.0000', 0, 1, 0, 0, 1, NULL, NULL, '2026-10-10 10:37:50', '2026-10-10 10:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `variant` varchar(100) DEFAULT NULL,
  `purchase_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `regular_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `sale_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `stock` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `variant`, `purchase_price`, `regular_price`, `sale_price`, `stock`, `created_at`, `updated_at`) VALUES
(1, 3, 'PROD-003-30_&_31', '2', '250.0000', '1200.0000', '800.0000', 49, '2026-10-07 06:12:50', '2026-10-12 03:36:42'),
(2, 3, 'PROD-003-32_&_33', '3', '250.0000', '1200.0000', '800.0000', 48, '2026-10-07 06:12:50', '2026-10-10 09:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_items`
--

CREATE TABLE `product_variant_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variant_items`
--

INSERT INTO `product_variant_items` (`id`, `product_variant_id`, `attribute_id`, `attribute_item_id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, '30 & 31', NULL, '2026-10-07 06:12:50', '2026-10-07 06:12:50'),
(2, 2, 2, 3, '32 & 33', NULL, '2026-10-07 06:12:50', '2026-10-07 06:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `promotional_banners`
--

CREATE TABLE `promotional_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_banner_1_url` varchar(255) DEFAULT NULL,
  `promo_banner_file_1_url` varchar(255) DEFAULT NULL,
  `promo_banner_1_status` tinyint(4) DEFAULT NULL,
  `promo_banner_2_url` varchar(255) DEFAULT NULL,
  `promo_banner_file_2_url` varchar(255) DEFAULT NULL,
  `promo_banner_2_status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `memo_no` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `previous_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `purchase_date` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('ordered','partial','received') NOT NULL DEFAULT 'ordered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `account_id`, `memo_no`, `remarks`, `subtotal`, `discount`, `tax`, `shipping_cost`, `total`, `paid_amount`, `previous_due`, `due_amount`, `purchase_date`, `note`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'MEMO-1', NULL, '3500.00', '0.00', '0.00', '0.00', '3500.00', '3500.00', '0.00', '0.00', '10-10-2026', NULL, NULL, 'received', '2026-10-10 08:55:38', '2026-10-10 08:57:18'),
(2, 1, NULL, 'MEMO-2', NULL, '61000.00', '1000.00', '0.00', '0.00', '60000.00', '60000.00', '0.00', '0.00', '10-10-2026', NULL, NULL, 'received', '2026-10-10 09:24:05', '2026-10-10 09:26:27'),
(3, 1, NULL, 'MEMO-3', NULL, '3500.00', '0.00', '0.00', '0.00', '3500.00', '0.00', '0.00', '3500.00', '12-10-2026', NULL, NULL, 'ordered', '2026-10-12 05:19:43', '2026-10-12 05:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `ordered_quantity` int(10) UNSIGNED NOT NULL,
  `received_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sale_priority` int(11) NOT NULL DEFAULT 0,
  `purchase_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `sku`, `ordered_quantity`, `received_quantity`, `stock_quantity`, `sale_priority`, `purchase_cost`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'prod-001', 10, 10, 15, 0, '350.00', '3500.00', '2026-10-10 08:55:38', '2026-10-10 11:16:42'),
(2, 2, 2, 'prod-002', 100, 100, 99, 0, '360.00', '36000.00', '2026-10-10 09:24:05', '2026-10-10 11:16:42'),
(3, 2, 3, 'PROD-003-30_&_31', 50, 50, 49, 0, '250.00', '12500.00', '2026-10-10 09:24:05', '2026-10-12 03:36:42'),
(4, 2, 3, 'PROD-003-32_&_33', 50, 50, 48, 0, '250.00', '12500.00', '2026-10-10 09:24:05', '2026-10-10 09:39:13'),
(5, 3, 1, 'prod-001', 10, 0, 0, 0, '350.00', '3500.00', '2026-10-12 05:19:43', '2026-10-12 05:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `redx_areas`
--

CREATE TABLE `redx_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'admin', '2025-11-02 06:39:07', '2025-11-02 06:39:07'),
(2, 'Manager', 'admin', '2025-11-02 06:39:53', '2025-11-02 06:39:53'),
(3, 'Employee', 'admin', '2025-11-25 03:03:07', '2025-11-25 03:03:07'),
(4, 'Admin', 'admin', '2026-08-08 14:13:04', '2026-08-08 14:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(2, 2),
(2, 3),
(2, 4),
(3, 2),
(3, 3),
(3, 4),
(4, 2),
(4, 3),
(4, 4),
(5, 2),
(5, 3),
(5, 4),
(6, 4),
(7, 2),
(7, 3),
(7, 4),
(8, 2),
(8, 3),
(8, 4),
(9, 2),
(9, 3),
(9, 4),
(10, 2),
(10, 3),
(10, 4),
(11, 2),
(11, 3),
(11, 4),
(12, 2),
(12, 3),
(12, 4),
(13, 2),
(13, 3),
(13, 4),
(14, 4),
(15, 2),
(15, 4),
(16, 2),
(16, 3),
(16, 4),
(17, 2),
(17, 3),
(17, 4),
(18, 2),
(18, 3),
(18, 4),
(19, 2),
(19, 3),
(19, 4),
(20, 2),
(20, 4),
(21, 2),
(21, 4),
(22, 2),
(22, 4),
(23, 2),
(23, 4),
(24, 4),
(25, 2),
(25, 4),
(26, 2),
(26, 4),
(27, 2),
(27, 4),
(28, 2),
(28, 4),
(29, 4),
(30, 2),
(30, 4),
(31, 2),
(31, 4),
(32, 2),
(32, 4),
(33, 2),
(33, 4),
(34, 4),
(35, 2),
(35, 4),
(36, 2),
(36, 4),
(37, 4),
(38, 4),
(39, 2),
(39, 4),
(40, 2),
(40, 4),
(41, 2),
(41, 4),
(42, 2),
(42, 4),
(43, 2),
(43, 4),
(44, 2),
(44, 4),
(45, 4),
(46, 4),
(47, 4),
(48, 4),
(49, 2),
(49, 4),
(50, 2),
(50, 4),
(51, 2),
(51, 4),
(52, 2),
(52, 4),
(53, 2),
(53, 4),
(54, 2),
(54, 4),
(55, 2),
(55, 4),
(57, 2),
(57, 4),
(58, 2),
(58, 4),
(59, 2),
(59, 4),
(60, 2),
(60, 4),
(61, 2),
(61, 4),
(62, 2),
(62, 4),
(63, 2),
(63, 4),
(64, 2),
(64, 4),
(65, 2),
(65, 4),
(66, 2),
(66, 4),
(67, 2),
(67, 4),
(68, 2),
(68, 3),
(68, 4),
(69, 2),
(69, 4),
(70, 2),
(70, 4),
(71, 2),
(71, 4),
(72, 2),
(72, 4),
(73, 4),
(74, 4),
(75, 4),
(76, 4),
(78, 2),
(78, 4),
(79, 2),
(79, 4),
(80, 2),
(80, 4),
(81, 4),
(82, 4),
(83, 2),
(83, 3),
(83, 4),
(84, 2),
(84, 4),
(85, 2),
(85, 4),
(86, 2),
(86, 4),
(87, 2),
(87, 4),
(88, 2),
(88, 4),
(89, 2),
(89, 4),
(90, 2),
(90, 4),
(91, 2),
(91, 4),
(92, 2),
(92, 4),
(93, 2),
(93, 4),
(94, 2),
(94, 4),
(95, 2),
(95, 4),
(96, 2),
(96, 4),
(97, 2),
(97, 4),
(98, 2),
(98, 4),
(99, 4),
(100, 2),
(100, 4),
(101, 2),
(101, 4),
(102, 2),
(102, 4),
(103, 2),
(103, 4),
(104, 2),
(104, 4),
(105, 4),
(106, 2),
(106, 4),
(107, 2),
(107, 4),
(108, 2),
(108, 3),
(108, 4),
(109, 2),
(109, 4),
(110, 4),
(111, 2),
(111, 3),
(111, 4),
(112, 2),
(112, 3),
(112, 4),
(113, 2),
(113, 4),
(114, 4),
(120, 3),
(121, 3),
(122, 3),
(129, 3);

-- --------------------------------------------------------

--
-- Table structure for table `shetabit_visits`
--

CREATE TABLE `shetabit_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `request` mediumtext DEFAULT NULL,
  `url` mediumtext DEFAULT NULL,
  `referer` mediumtext DEFAULT NULL,
  `languages` text DEFAULT NULL,
  `useragent` text DEFAULT NULL,
  `headers` text DEFAULT NULL,
  `device` text DEFAULT NULL,
  `platform` text DEFAULT NULL,
  `browser` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `visitable_type` varchar(255) DEFAULT NULL,
  `visitable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `visitor_type` varchar(255) DEFAULT NULL,
  `visitor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shetabit_visits`
--

INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product', 'http://localhost/styluxebd.xyz/public/admin/report-product-stock', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/admin\\/report-product-stock\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; XSRF-TOKEN=eyJpdiI6ImZXbUFYNGs4N3VWN2lHZnFIZWZvcVE9PSIsInZhbHVlIjoiWTJtVnhmU2dkMjN1Q3pwaHM2alBQTzUvVnRRUDNLZ1dLWi9ZSkdza1VpS0tSZFdMc3VkY1IxTGIvbzZSbFhIcmlxOVJpaVc4NXViRGxoS2V0ZEdFbStkYXlPMVc3aTlVV3pGNk10aHpBWWQ1OE1RRjVVZTRCb2xvdUJvQmxlckEiLCJtYWMiOiIyNWI1NTU3YzRmZWFjZGE1ZDFlYmYyMjQ2MjMyOWNhZDIzMzIwZWM2NmFjODBiM2Q3MTBkNGE3ZWY4YzUzMTY2In0%3D; styluxebd_session=eyJpdiI6IlhXMENiTThYalVubng4UEhqL1NaTWc9PSIsInZhbHVlIjoiRFVaaS9jSE01amZpVTJhSDJDZHB6TmVJNFJnQm9FZTNLdlF4Um1zME9OMVFVbm00T1RHdjFNVWRjalRmZ240SHRPMXYrM2xuYjRmWmxRWGY3VjRCTldMNGpoR2wvaU5VQ3NidzlGN1ZFUm9tT2JiaDlDOGV0cmFrNVZqaHgzdWQiLCJtYWMiOiJjZTYyODM2M2E4ZmI5ZjY1OWM0MWRiNzViZjhmZmQ0ODc2NzU0OGZhZDAwMTlhOTA0M2Y4ZGFlZjY0NTg5MThhIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-07 05:42:28', '2026-10-07 05:42:28'),
(2, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/product/combo-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; XSRF-TOKEN=eyJpdiI6IjNlenhrKzdXMExSNklMZE5JdWdDOWc9PSIsInZhbHVlIjoiYnRHQUNNMGdQMTByV3pZNTZQWUhaRVdOd0pFUW9MYURTVnVmYWxGaUxoMUZhejRYSWJFOUdiVFh4dFR6V3o2NVc0S3BwWVM1MXV5bG5vQTRGclEzNTllZWNJU3o3UEtFYnpCL04xalQydG5VOFFRZjVVb1lIWXczUXMvR1RBY2IiLCJtYWMiOiI0ZGE4Y2NjYzMwYWVjNDI4ODAzNmQ0MTI2MDk5NjY1ZGQ0Yzg2OTgxMTQ1MGZkOTQ5ZTJiNmE4NjJjZmYwMjVhIn0%3D; styluxebd_session=eyJpdiI6InBTOWtSdXo1M29nRElPYzZDTHM0WFE9PSIsInZhbHVlIjoib0wycHJqOWdTSlRZU25pL0JmcnFTVUxtTGlLdU9PT2lPZ3pZYm9XRGdydnViTzA3Z3FrSWJUT3RWWk91ODM5eGMyamdjV0lEZG85NXNjSnNIRHJWNGxyeUgwZFNWbWk0SDFodzBQbXNLN0tQdk5QUm1CY0RIczQ5T09sRmZZSWQiLCJtYWMiOiJiOWQ2ODBhMmYyZDQyYTRhZGE3NmM3OGZhNDc3NzFkZjQ4NTlhYzg1NWQwMDUwZDk3MjA2YmRhYjk4MDMzMmI0In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-07 08:17:47', '2026-10-07 08:17:47'),
(3, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; XSRF-TOKEN=eyJpdiI6IndvMlVSR0NOY0YxWGNobW85SHlLUUE9PSIsInZhbHVlIjoiMzZ6b2VBWUh2VG5URi9Fd29hMEFSQmJkKytUazdZMEp0emt4UDB5SjdQSzAzU1RkQm0zZm1jQTdjOWp3dHYvcFA5SDBiekdpUlJuQVBoYlYxa05MTnk0MFoveFBWd0ZQQnc1aFR1ZmpZNTcybTRoRk5xYitzekV4NDBPTUpuRlAiLCJtYWMiOiJiNDUyNTM3YjRkNmFlOGVhMGQwOTM5NWU5MTg4ODEyYWQ4OTg4ZDYxOGY5MTI3YjAzYTc1YjUwZGFmZDlmZDYyIn0%3D; styluxebd_session=eyJpdiI6InZVcVkwTWhyQkZGNkM1WGdoa1ROdUE9PSIsInZhbHVlIjoidjFnLzRzeG05WGRHQXhmdkhFc3dIK3NpbVNOR2h0SmhXUmlzUmZFQlQ4TnptY0Q2UEZZeUFVM2ZPRGJVZTYwRkxhaHVteWl3Z3BYcG9HN0x5U3EvejZGaGM1dVl1MjIwYWtLWHUxN3NTM01wMUxkZXBrWkNRTm5UZnBzL3pNN2UiLCJtYWMiOiIzMWY3MmQ1ODc1NTg1ZTYzNDA3ZTJkMGQ2MjVhOThlMWJiMmIzODJjZTdiMTI4NjU3ZjZmOTY4ZmEwMzMwMjdlIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-07 08:21:37', '2026-10-07 08:21:37'),
(4, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/test-product', 'http://localhost/styluxebd.xyz/public/admin-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/admin-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; XSRF-TOKEN=eyJpdiI6IkQ5UzF1Z0Vpek1WKzNYTjFOckt1Znc9PSIsInZhbHVlIjoidW5NVjZmcDZUUWk2ZnhBVjdpU1FoSmg5REpMM2t3NWluR1MwMGxTZDBlV2F1SlorNFZ1bVZvMjlnUFF3MVZnSkc5UkdJdGkwbjQ2M3FMMWoxdG9ZZkg1M3FIcHNuNURUYlZGdGFVMGtsdDdScGFveGFEQnExbHQrd2xqMXMyYVciLCJtYWMiOiJjMzY0ZjViZDk3ZGY1MjdiZGZkNDQwMmQzYmEzMmI1YmIzNGNmYTExNmYzNDU4YWUwNzk4ZWM4YTcwNDk1ZmViIn0%3D; styluxebd_session=eyJpdiI6IklVaXFLOTRTNVR3SENCVnVWZjlPVFE9PSIsInZhbHVlIjoiT3BMSjc5L1V6UUFVdkY0SUdIbHZzb0FrVVNtSXREYlpabE4wNUNMSkVtSk0wYWlpYzRVSERCVFk0T250RkhmRVh2d1d5TnZEZGdvRHZoUXRPeGNVSzVBYTZZbE5BbFhuenFXazRSVnU0Tm5yM1dWdmF0L0VVSmwzM0x4Z2RMN1QiLCJtYWMiOiI3MTg1ZGZkOTIyZWMwMTE0OGVkOGY5MzdmZDg0Y2JhYzc1M2RjNTBiNTc1MTgzOWY2YTRlY2U0ZWQ1NjAyYTFmIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-07 08:32:56', '2026-10-07 08:32:56'),
(5, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/test-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/test-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; XSRF-TOKEN=eyJpdiI6InpLSEYyc1MrbWIzMGhvRjByZHpoaEE9PSIsInZhbHVlIjoiYytnVGt0UUY4OG5IcG1BaHU5c0JDcjkrcUdQcSswM3VLNE1tYjAxSjFXd2h1QmNTS3B5YmRRQ1h6WWdGUHlFbTEzaUdQQTVoZFV6NXI4UXdtMklSTHo1Z05JZkIyMVA3YnAyZ1BmbWVUWWovWktHZzVJNUhkTkQzM0NVZ2dSc2giLCJtYWMiOiJiMDAyNjg3ZTBlYjA3NzVjMWVhMDJmNTZiYWI4YzQ2ZjdiMDdjYjZmNWE3MzVmZmJkNmYyYjllNjYxY2UyOTk0In0%3D; styluxebd_session=eyJpdiI6ImxURlR0dUNIZmVhOVJwSEx0UGNZK3c9PSIsInZhbHVlIjoiaTJFR2EwVnppT2FaWnJNeG13aW9mdFZZOWNJOXlPUkRBQzc5MU1YUTQ1SnJ2TkRCTm8xQmFiNzMxNGNQTHF1bjNMT3JsOGdyeTU1cUU4YmxNRTZVMXZyVVdxczJhVlpROGVpWE9Uc2I0K0xEbUtBcEc3aVdqZzdZVEZWd3MyWkciLCJtYWMiOiIwZjAxODYxNWIwMTAyNTMzNjM4MGQ3ZWNhNTE1OTkwYWU5NmM5MDE0ODExMmZjNzBiNGE1NDM3OGNkNDFkZTJmIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-07 08:33:01', '2026-10-07 08:33:01'),
(6, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', NULL, '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"none\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-08 03:18:08', '2026-10-08 03:18:08'),
(7, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', NULL, '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"sec-purpose\":[\"prefetch;prerender\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"none\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; XSRF-TOKEN=eyJpdiI6InU0Snp3bVJ0eXk1aGVkM215NUtjSUE9PSIsInZhbHVlIjoidXZGZTZiR1o3emE4OHZ1b2JuKzZ5M3RjVzYwQnZrdm1FTEpUUWxuekg3WUZWR2duQTBMeFgwWWZkeXNNUWVMaHlGcTZtMU5yTjFTOVMzYXk0SldIbVJ3dmI0MmRzeGJHWEhLaWNtMDY5blk5TWNnZWpBanBIUk0yd2NqcUFjSCsiLCJtYWMiOiIxYmZjYjFiMjUyYTJjNDJhMTZmNmJkOGQ4ZjRkZDQ4Y2NjNDg2ZDBlOGI4ZWI4MzMzNmNhY2UxZmRkNDY0ZTU1In0%3D; styluxebd_session=eyJpdiI6IllZcXYwZXBVNnlhTWFRazNjTjVqU3c9PSIsInZhbHVlIjoiUEtYY0kwNjJRZWY3enJwYS9lRTRka21uVTl1cDBiYkd6RStEUm9BOFoyOTZ6WXVTblFzei8veXJpaXViSDQxTXZDRXJaUkJhQlNMTHk5ai9qY1lPUkxhSFZwR3YwWUFuMVFoMUg2T0tVYlNJcnFlbnNXWHZsMGpPV3RWaHBVWGUiLCJtYWMiOiJmNjAzYjRkOTU4ZWJlZWY4MDczY2VmYTEyMmY2MTkxNzUwZjZjZmIwNTBmNDg4YTg5MzYzOGNmNTBjOGViYTU5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-08 09:23:00', '2026-10-08 09:23:00'),
(8, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', NULL, '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"cache-control\":[\"max-age=0\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"none\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; PHPDEBUGBAR_STACK_DATA=%5B%5D; master_quickshop_session=eyJpdiI6Imk2dm5SNTRyOHRJUlBMQkhYYno2U0E9PSIsInZhbHVlIjoicXMxNzZnU1BlUTM3U3Y0NUFvSXMvVGNrM1FrRW9JN3BxZUVxWFRWNFdJUnVnME4wTmNyZ2Y1dzZDMDBpdmQrMWdkZDI3clBBcEtLdG1yVThubDhJVEFGTW5tTm1VU2FRaWZqNmkyNVdGQnpnZ1pVZloya0RlcFlobHBNS1VDamwiLCJtYWMiOiJmNmZhYmRlMjYxZGE0Zjg0MjIxZDU3YjA3NDUyZTI4NDI5N2JmNzcxYzY0OTkxNzhlMjExMDUzMGI3MTEyYTNiIiwidGFnIjoiIn0%3D; XSRF-TOKEN=eyJpdiI6InBVaUh1MGpDVnJKcXg2YW02eGplc0E9PSIsInZhbHVlIjoiSjA1U2lkYnZ2cXp4Ni9tYUJ1ZFdzc0JRUEhzWDFUdHhuREx2amh4S1htUnJWaTFwVFErZ2tIQm4rVXFOZTN2WjJ4eU9zek1MM2RaNm52N3lkcWVlZjA1cnBQdTVBKzEwUEhMS3VKdFVBbTNsUzBjUjJzbmhTTUFvdDlJd0xmNHMiLCJtYWMiOiI4ZWQwZjY3MmM2MjAxYzA0NjAzNGQ2YWY3NGM3YTNlZDUyZjY3YTMwNjgzMmM3NDhhZGRhMTE3MjEwODVmOTA4In0%3D; styluxebd_session=eyJpdiI6ImFKc3pQSzBVSnlhQU5SeW9qY2ZENEE9PSIsInZhbHVlIjoiNkIxV0tXOU1wVGhqN3AxQzh2dVdmdDZHMXl0elBEYTI1K3pSYUZrZHVMN2dhYjZWWUppSDJsaVFjY1lDRlVKcVFCUW1TUG8wTmF6amZyYlFnb1R3UDIwU2c5aTRVRjVGYmd6bURFVmlLeGtSWFFGMlNvck9PdTZFZm01VjBjZHkiLCJtYWMiOiJmY2EzNTBjYjJkMmNjYjJjZmJlMThmMGJmMzJjZDlmZmUwOTgyMGI4MmEzNzQ1MzVhZTg0MThhODU2NTBlY2I4In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-08 11:36:47', '2026-10-08 11:36:47');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(9, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', NULL, '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"cache-control\":[\"max-age=0\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"none\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; PHPDEBUGBAR_STACK_DATA=%5B%5D; master_quickshop_session=eyJpdiI6Imk2dm5SNTRyOHRJUlBMQkhYYno2U0E9PSIsInZhbHVlIjoicXMxNzZnU1BlUTM3U3Y0NUFvSXMvVGNrM1FrRW9JN3BxZUVxWFRWNFdJUnVnME4wTmNyZ2Y1dzZDMDBpdmQrMWdkZDI3clBBcEtLdG1yVThubDhJVEFGTW5tTm1VU2FRaWZqNmkyNVdGQnpnZ1pVZloya0RlcFlobHBNS1VDamwiLCJtYWMiOiJmNmZhYmRlMjYxZGE0Zjg0MjIxZDU3YjA3NDUyZTI4NDI5N2JmNzcxYzY0OTkxNzhlMjExMDUzMGI3MTEyYTNiIiwidGFnIjoiIn0%3D; XSRF-TOKEN=eyJpdiI6Ikljd0JFNVg5OEZQQ2dqZkREYWtFckE9PSIsInZhbHVlIjoiMWo1NzgyL2l5SVlqbVhSMUE2N0x2MWdPNjVxa3FEVkxwMHIwM0JYVTlleEdOdTFTbmRyaGZpVUZEakExajJyK0dSZG5iVTlySE9IUkZOVlNVa0ZyUnMrWTAxMEE4RUxnMFJVQmRZVmtSZjJ6dzMvNjNsTGhINytNNnp2M0J3bXoiLCJtYWMiOiI3ZDA3MzEwZDRmZjZiYTdmMDY4MjY4ZDdkZWQyM2MxZWQ1MjllZmUwMmQwOTQ3MDI0ZGJmMGVkYWRiYjJiMzlhIn0%3D; styluxebd_session=eyJpdiI6Ilc4OCtOT2hKcUw5bG14QmtIMXFVZkE9PSIsInZhbHVlIjoiNjltZHltekxzTXdyWS81MHlVVTlHK0JYVjNRZkpwUUtydFNwam43K1p5MFdNbFMwNEEvNHdnYkpUeDE3RGtoWHZ0eTFLWHIrVFIyWElmSEF6K2o3Qzh1QUpkcG9CMWRaRVNia0wzRk1EQzhkd0FLYmgxZGtJemQya2NnZmxxSCsiLCJtYWMiOiI3YTMwZDM1NzU5NTQ4NTZmMWNlYTI5N2JjYzNiZWUxZjg5ODJhZGM5MzFiMzhhOWZmYzhkODBkYWZjM2IzMGYzIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-08 11:37:12', '2026-10-08 11:37:12'),
(10, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', NULL, '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"none\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; tuki_takee_session=eyJpdiI6ImtZbjFFSklQdzdUeHRwRmdJbnlTZnc9PSIsInZhbHVlIjoiQkxxQkFUMngyZGlWSVpQUTBtMUVvajJUa016MmZkc0JYeHRTUkluWXJ0RkpWbTZyWWxIMXgyb08zRFNHd242MzdFQ0kxaE5lcUhVd2t6bmtKdXZVaHltdUtVM1hLYUNTZkRzVWxYb004TU11eVFHY05iV05KK093VkM1dkh6eHEiLCJtYWMiOiJkYjVmZDcxYTE3ZGMyNWZkOTdjYjViYTMwNzI1NzYzYWZjMTM1ZWYzNmUxZDRlNDU1MDNiOTVhODZhNWRjZmQ1In0%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 03:22:10', '2026-10-10 03:22:10'),
(11, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/test-product-02', 'http://localhost/styluxebd.xyz/public/', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IlB6S1czOG9WL2dOSnhRQnlFQjZ1OWc9PSIsInZhbHVlIjoiZU9IeGJ3a1JsUzVPSGdqbENpeWJpdjltWkM1TTRsTTA5SDdaU1lDUDNKWmR4NElnN0JtcXNlR2xGU0I2Um1YcWQwaEpqTWVzdGcxZjNaNVVEU3VGeHRvdnpOYkc0TEpBOXZsZ1B1TDBlT3BldmpMdWFVby9iZjVYWURBY3FSTVQiLCJtYWMiOiI5ZWE3YzIzODRkOGJjOWU3YWQ0MmM4Y2IyYzFiMzdiMjM1ZTdkMTQxOThjN2QwOGQ3NWJjNzc2ZmJmMTg1OWUzIn0%3D; styluxebd_session=eyJpdiI6IlZubk5TQThveGtrUW5QZTh2Nk5IclE9PSIsInZhbHVlIjoiM1NRVHVTemhPbUo4UFl6TENoMnA4bC9vOWlTVWd0eDFuanB5YTQ5UHpxcmY3N1pGQUJhM2NhZ2c0L3B0MVMyWjRMSEkvWDRVd2ZJUDJPYktLbzdnVVF3UkhVdDJNN2lmR041Y0lvWFgyUlYrSTBxaU5Jd0IyLzl0cHZnWjlRMnAiLCJtYWMiOiI4YmE0ZDc2MzhjMDI5MjUzODMwYjhiMDAyNGVkOWM0NzMzZDVjMDJiNzhhNTc0Mzg1YmZlOTBjMjNhNmI1MGFkIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:29:57', '2026-10-10 09:29:57'),
(12, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/test-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/test-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Im95WnpCYjlXenI2NkgraVV2d0JheUE9PSIsInZhbHVlIjoiL1czYVphdHBQOHNCNkNiWkdZd05TWFRrT2pWbDZTbDdMUFE2KzFZam50bWtoVHVkMGNyZHJPWTcxZWJVWWhNSVRiODdpQk9OaGVKOXd4bEVjQks1SnhvSHljb1BvU2JrUi9UQmZMd0c2UWRMU0VZR0oreG44L3poSHVkcDB3eGMiLCJtYWMiOiI1Mjk0YjBjMGMzODA4OGQ1NGMxMjAxZDAxNmIzMmMyZDMwYmJkODBlYTRkYjQyN2U1YjQ3NjFiMTE0OThmMGVlIn0%3D; styluxebd_session=eyJpdiI6Im5vVU5GbFV3VTFjR1V4NStiQ3FMOFE9PSIsInZhbHVlIjoibzNSTjd5ZGVWcWxCMFdQTnRHTkNmZ3IxTUdRZG1XM01qTTM2RGpITWJFemhkTzBBbk5pa0tMcDdEeGlIYlo2b2RKK2hyRFBnbDVvZ05PVS8wVC8rZWVsY3FaQ0RDdUhlWlFGckRoMXpDWVFsUU8vZDc2eEkxMEZLRkRvbTk3K3IiLCJtYWMiOiI1Njg2NThlOWY5N2U0ZmU3ZDUzYmQzYjIxNWExNTM5MThhODFlOGY3ZmUxNDExM2IwZTZlYTA5NmIxYWMxZTVkIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:30:15', '2026-10-10 09:30:15'),
(13, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/test-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/test-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImVZenhhTnBoa1FxS1ptMTUwU283ekE9PSIsInZhbHVlIjoiSnQvOUFXWWEycEhiRDBGMmlCMnZJZncwNzRlWUJzbU5wRTQ5VVBaQStkNmJ3MDA1NkF6b1hKc0NiRmtENXpsOGFYaDVuOEI4TmlkbHpiZXlPQlROTjN4aDBzTkFrWlI3N3VvK1FIbzdrQzJiSGZVTS9sT0RUTzE4TWdjeHpIQXkiLCJtYWMiOiIxMDE0YzRlYTk5MjkyZDI4YmU2MDA5ZGQ2NmY5NmJhZjliZDBmZWU4OWFkMjk2NmQ4ZjYxN2ZhYTUzYzE5Yjk5In0%3D; styluxebd_session=eyJpdiI6InFVUUQzbk4zQ0VucGx2VHUvNkdvUnc9PSIsInZhbHVlIjoiZDQ3U2FZbWFZbzFIZHVtV2c1dHNOZUZHMklhNnhQUnRvZjkxdFBkZmR0Y3o0cC9XdDVuNTJ0b2xrQTN5dHRwNk5oODlWbE5HMytJQjVFWlhDM3lhOElvUGE3ZWFTaDZUS2ZhdExDYUlSajNhUm01L0N4WC84SWpScUpJRmkrWnUiLCJtYWMiOiIzOTRhNmJkMDE1MjA4MmFhZjhiNWMzZWE5Mjg2NDNhZjc2ODQxZDU3Y2UwYzlkNmU1Y2Y0ZTc1OGE1YjEzMjQ1In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:30:15', '2026-10-10 09:30:15'),
(14, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/checkout', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/checkout\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IkZ0V2xJZEtkcHhJSFVWcmhrUjRJaEE9PSIsInZhbHVlIjoieHE1VWM1bFpTT2kwcFRER3VhWlJwNDE0b1ptNmllT2JiVjIyZmoyWFNORmJJQlRpWjhWTldHUFJwNFdybXlzRENqNzJ0L0RTRys5Q0paYUZPem93Z2dweURvNDdYWTZVaWp4Vmp2TVRXV1dsSVd6NGJMZy8ySW0zVk5UVndJczciLCJtYWMiOiIxYTE1NjFmNDE1ZjUwOGNhNjA0YTI1M2MxNDYwZDllNTlkNzRhZWQ2YjlmOTdmZjc1N2RjYWMzMWMyNTkyOWM2In0%3D; styluxebd_session=eyJpdiI6ImhHU3U0MFYzTkc0Rk1pOENnemhaWGc9PSIsInZhbHVlIjoidzZQSkhZdWFhZnFGVkxucUVML0pBMXF5eUg3YkQrZnB1RlcwSTlhU0VZcnNtMUFacCtROVN5Q0t0VnlqeEQycmVDdGU2MW04MEhML2FmSTFmNTNvQ1ZJUEF6ZDdsM1RlMjlLTGJnNGgrK2p6a2sxUXFpTHVIUVVSWDNRbndtaWQiLCJtYWMiOiIyZWIzMDMwYjcxYTY4MzA1NTBkN2Q3NDE4NDBhNTNhOTdmNzk1N2Q2ZDBiMjIxN2JjNGZjOWQxZWY2YzVjZDk0In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:02', '2026-10-10 09:32:02'),
(15, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImxhOXZVK2hOdEJYdlkrbWlqd1ZXYnc9PSIsInZhbHVlIjoiTW1qcHdibVAwRVNNVGZFc0JaSytNZWtJNVMrTlllTGdLSkZaZ0YvSFFkSnZRRks0aWVMVFpuUllUc1pPK21kSU45UG9EcWF6RUtVdEFrQ3gxSGZQYWNOd1F0TVNIeUlBZm02NFpwMjBiRzRweDBQa0txZWNXMjVuWjdRdUE5OVkiLCJtYWMiOiIzYjEzNmZlZTE1ZDUyYjUzOTM3NDM3ZDk5MDQ0MzZiYmFjNjZhMmQyM2M1MjE3MGE1MmQ1YWNhMjk0MzFiMDJkIn0%3D; styluxebd_session=eyJpdiI6InUxUE1TNUM0MmhJUGxFY2R6Wi9TUFE9PSIsInZhbHVlIjoiekUyWmJyL0FwVmpLbHBobHJaM3JwOXQ3ZCt2by9xazc3SWdDUFZKOWFLTlUyVlZKeUQvb0VWSzB5SW8yOExTbzlpemRTdEgzemxzcFZyc3MyRU92YkJQaFViQWlxWm10WkhibG1SQ21iTHRUaVlPZ1lLSjNXLzBFUWVjZWpYM00iLCJtYWMiOiJiODU1OWJkY2U5Y2JhY2QyMjBjNWEzMTBjOWVhNGNjMGFiYzEyZGI4Y2Y4MTlmODRmZDM3MzViNGE3OTc5MzFkIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:22', '2026-10-10 09:32:22'),
(16, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/test-product-03', 'http://localhost/styluxebd.xyz/public/', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IktEcWRwNGZhZ2t5bFFUQnhJZWg5aHc9PSIsInZhbHVlIjoiZ0ZYNUNBei82anA4dWIrNFozUzZDUU91cmhTcHRLK04wMk9YSGhicnlSejUxNVB4R2M1K0VJQldxVzR0OEx1d09XSlg2WWhWcXhhQ3lCcWxKbEJ4VkJTL29VenRTZVRFdERiRXJCSE9DaDM1azVIK2FoRlY3MFRlLzhWbzVBbVIiLCJtYWMiOiI0NjBhOGY2MDNhNjg4MjM2MTE4OGQ2MmI0YjY1MzUzYTExMWQ3MDg0MTNhYjZmNmI1Y2Y1OTAzNWQ1YjQwZTI3In0%3D; styluxebd_session=eyJpdiI6ImFlOExUdExBMzU2dWxReTRDZ3BCNFE9PSIsInZhbHVlIjoiWjZiVFZUYWZ3V1pVZUUrR1RwRkR6Mnl5bC9ZaGRWa2p6TXQyd1dpd0lrUmN3TEZKZmE0YTFscjZJWmNKM0ZCN1prYmoyalE5MzZHdWJyYnhGdHpycTk4YXRtZnFMSE1neW9ESkVPSmp3a1c3VVhvRGFjV3FCS0hPbWNsMW1RTzciLCJtYWMiOiI2OGU5OGVhMWIxOTBmYWViNjgxNDUwYjU1MDJmZjZmZDdkMWNlZGYwMTdmYTkxYTliOThlNmFjOWZjOWUxZGU2In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:27', '2026-10-10 09:32:27');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(17, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/test-product-03', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/test-product-03\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6InEwcml2elYvVXlwYWdCaURTTkdYL1E9PSIsInZhbHVlIjoiR2t6SnhEWTVvOUNSTC9TcnljK1NaaEdBTTJEM2ZMUytLZjFuNjdYcWEwSmE4NEdQeVJKVndIcjJCZlFOMnlWTlBKUFBhNkRxWXp2NXM5MTdhUWQvNFJuYVhrMFdTNW4wTjhKa202R0dqTzRrMjNMRVIzd2JNWlQ2TjhLSlY5RnkiLCJtYWMiOiI5YmQyYzQzMWIzMTEwNzYwMTU5NWRlZWE5YzdiODBlYmFjZjUxZWU0NmNhOGQ2ZTBhOTVkYjI5NTQyYzU0MDQwIn0%3D; styluxebd_session=eyJpdiI6IjhyVHJKWUJwUWN0WjBBUG1Rek9aM2c9PSIsInZhbHVlIjoicVlsNzB4cWxpY09MajYxUjdMR3RZM0kzcmdPcXFMZ0RVZ3lDemdzWWlKeDV5OUE1bWM0cjdJdjhQRTJsSTJpbjkrc3VxUGpHVVNaWVZtME1lRGNvb1UwcmN2emRjeS9nMDRuUEN2aWJwdFU4b3cvSjBGV0ZYTWYyY3llRlVWZjQiLCJtYWMiOiI1ODg5YmZhMjY1NmZiODdlZjIzNGM2NmY0NDlhYTUzMmNlODU2ZTllNzNlYzQ4NjA2MTUwZTY4N2U5OWMxMTE5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:32', '2026-10-10 09:32:32'),
(18, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/test-product-03', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/test-product-03\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IkQ5VzRwU05iTkFNdWw2UlF6UXJHSVE9PSIsInZhbHVlIjoiNkpmMVVqVDBQWGtDdGRzNllubzNqd3FLWVhJV2owbkRjeWNRc3hzUVZSRk9NdWF1dVcwMWlXRXB3NVh6UjhRSUxQVnpPZUFzQis2dC9ONTBQY1lsSTVZR1hZWXBVeFJBMjl4d1ZHVnR5UVJyekR5OGNOUTFpdDB2Ly9FRlNiWlgiLCJtYWMiOiJlODUyNWYyMGExNTYwNjg0MDI3OWM3MzI1NWFhMTFhNGUyMTJlNDZlMTM1YmExNzI5MTY1ZTEzN2QyMDQ3ODU1In0%3D; styluxebd_session=eyJpdiI6Ilgxd2pjeHhZOUdWSENxeVR0UWRSQ0E9PSIsInZhbHVlIjoiNmlRb1hPQXVRWnU1M1NuK3BCbzdOVmdwNTJ3bXN5S3NFVXIrV0hBRVhLQU1JcERnYUVhbGFjMEJPME0zOUFieDVxRC9tWHhQdkZsTkVPN2swL3hyU3JpZFdzSjRYaHV0cGp2QWxJS2pGRUIwci9nSndncEJrTDZrS0ZpSFFtaTUiLCJtYWMiOiIyMWM3YjhiNmFlZjNmNmIyMzg3MzViOThlOGRjMTE5ZDNmNWM5NmFiNGY3N2UwYmUxNzliMGQ3YTMwZjUzNTY1In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:32', '2026-10-10 09:32:32'),
(19, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/checkout', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/checkout\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IitHRUE2Y1Vib0hGMkxkM0w0WFM5MlE9PSIsInZhbHVlIjoieFptbHlNSjVZK1N3WFdDTHhXb1lJTGpsUEFzbkhGMVE2b0Y1bkEzODNydzJaeDcwVStjT1RjUHBWVjkrZDlPTFdzWVRoM3NSVml0ZkFRS0RMY05MU1Z0OUtOUXZZeWJ0RXIwOXNJYXRzNUg2RXg0dFFNK3U1V01XMTZhSHRaVU8iLCJtYWMiOiI1NGZjYjZkNmY4NjZkYzAyMDMyNmIyYjVlNWFjY2ZhYmU1NDE1ZWVkNGI0ZmJjZDIxNTFlNDRhZDQ3MjhkMmFkIn0%3D; styluxebd_session=eyJpdiI6InRFa0JRUVlpbjlnQTdlZGR4a2lZaHc9PSIsInZhbHVlIjoiOXE2Nys2Z3QvOVVPbHgvYUtoWDNsREx2a0V1NTVhSFIxclRvTkRZZ2oxc1JQVTBBQ3dnNThuWUp0Z0VjQ2pwQ2NiSlFXdTVLYSsxWTFVZU83Y0lRWnRrU3ZHSldVcFU1QTd4d3JkOWozNmNURnNkQkpiRHA3MG9IRlhCV0RTYzYiLCJtYWMiOiJhNDUxYzEwMmY3YTJlNDk5MzBiYzgwZmEzMDI2ZTg1MGFkNzEzZTQ2NWY4MWYwNzQ0ODFhYzhlNWU1NzRiMWM2In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:35', '2026-10-10 09:32:35'),
(20, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IlFCOXNVZW1NU3VCWDdQQW9nd0owOWc9PSIsInZhbHVlIjoianY0L1liQWhPbjFFSEZJNFhtYitXeFpCOGlvTDhIL0syU2YxOUJyT2JKc3B6YWxTVW9QYmhXR00wWFFqb2ROcFdIVXFLbSt2REJDeUZPVG03K3Q2bzM2MWpYZUdhMStNRE5NNmk0WVo3YlBINU9lWTc1cFJiMWtWZytJb1RrRXYiLCJtYWMiOiI0OTcxNDlhOTg4NDBkNjg3M2YxYjVlNTZlN2Q5N2EyMzNjYjc4NDM2YzE5NmEwMjFjNzgyOGNjNzk2YmQ3NTVlIn0%3D; styluxebd_session=eyJpdiI6InRrOFFWVitiTWxhUmlsak51TFZBTEE9PSIsInZhbHVlIjoicEV2bVphRWFPSnI4cWl6c1VSYUlIbDRJOGZXekh6U1l2T0dwRUlvbHk1SmtsV01TaTVQMzBKUVBqZHd0akxvYXBOckNCbk1lSlQ1SENORW9xOS9DLytBU3ZrdisyZ3pXeG4rRU5RVHl3ckxkRGdOUnVHRGZJejVGNmtFdmF2bDAiLCJtYWMiOiIzZTQ0MmY0MmYwMDg1ODUxNzVkMTI4YWNmMmVhMjg3ZjM0MzY3YjRkNDUyMTljZTZkMzBmMjAxMzA5NTMxZGQzIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:41', '2026-10-10 09:32:41'),
(21, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"x-requested-with\":[\"XMLHttpRequest\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"*\\/*\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"cors\"],\"sec-fetch-dest\":[\"empty\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6InFFQlh5emVLckJOcWdCRUw5b2EvQlE9PSIsInZhbHVlIjoiOXlBTlIxeGNUL2V5Q21IVzlhclRyQ1duQ1g3cUkzbmxIRm02OWtxUlFqNmJDaWlqc2JZVklzM2dndWsxODArVytQenJmc3h3Q3BLcU1lTnZua3lqYWxFNnZ2TTlBWE5qQ1RCYXRNKzVuQVpUNHcramdrdDNWZ3JmNXR2RytacXgiLCJtYWMiOiIzMTNkZDY4YjRkYjJmMjNiMjQ1Y2VkODBlYmU0YzVlODgxYjYzZjE0MjBjZGQzMTVmY2FjOTRmMjAxMTAzOTA4In0%3D; styluxebd_session=eyJpdiI6ImpLR0ZBL0kxNmJaakFadmQzRVNVRWc9PSIsInZhbHVlIjoiWk4xWlVndk1uSUtxdS9ha2l3Y2pudWF4UzZjbXZpMmQvRnJxZHJMTmdtQzQzUE55SnBhL1EwTFNVTlJYS25iRWZpSVJSUmNmeGNXS0p3V1NPOFBiVE9IYkxVRjVNRVJWYm5tcnNPUU5IdnRZMExRZ0QvRDZPbVRUbm9XUkMwaksiLCJtYWMiOiI4NjNhMjZlZjJhOWI4ZjVhMzFhOGM3NTdlYTlhOWFiZjFhMmU0ODlmOTBhM2ViOTZlMWQ1ZjZlMGE1ZjhmNWUwIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:45', '2026-10-10 09:32:45'),
(22, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IktYVUxhYUY3b2cwTlBKQ1kzRVpwaXc9PSIsInZhbHVlIjoiV0pVQWUvMHJuelBvOERLUzMwUkZ3R0lRU2R2d0hWKzdLeUI1NjVKdVA1NUNSZUNXU2N6dzJpeVlxV2ZtTFpocEJ5VEI5WVN6RThMV2RwamVxZGd6MDNBblpjU0RwVkFrMVJMQlNpZzdCLzFtZDhmQ0pndFhWb0Z0blVUT1RaZnciLCJtYWMiOiI1NzgxMTRlNDcyOTdlY2MwZDliODNlMzRiMTEyMWFmMWQ0MzRmZTFjZjFlY2ZiY2M0YWE1YjNjY2M2OTc2ODA4In0%3D; styluxebd_session=eyJpdiI6ImM3S2RqdTRJb08ybkQ3bzVSQVZMc2c9PSIsInZhbHVlIjoiTzlPRVRzS2RCeURtNmZjbWY0UHNlTFMvV1NVUkozc2Vrank5cTVNVmF2WnBhanFtaXZLeE5KdEtDL0JLeEVQemJZK2k4TEZYUXUwTkloQTlIdzJ0UU56ZHQvK3Z3bUtLd3gwY1diYjlqZ3VDSFVMMHB3bTB0SHUxY2QyTnp2VmoiLCJtYWMiOiIyZTZhNmE3NGY1MTJlNzFjNTdkNWM0ZTEyNzdiMjYxMjA4ODY3MTc5NDM1YjhjNTZhNjBkOTA2ZTNhM2Q5NWQ5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 09:32:47', '2026-10-10 09:32:47'),
(23, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/checkout', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/checkout\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IkZEbWtGbkVPN1lIQWxxcjR5VTZpb1E9PSIsInZhbHVlIjoiOEpWL3RSREYyd3owdldTaHM1VUhISDUxSHlpcXc5WDBEM3cvS1I2MEQ4ZkZLWEZETzdxamtSNEZRUzlaQkp4bVV3eU5pTmdQOXlqdThGaThsNVZxM0c5akxVVXQxNGJKTzdybndIeVFVbzllZEd1RGs2bkNPazNsNE9aY1RYRVgiLCJtYWMiOiI1NDFiMzdlNWMxZDhkZTNlOGQ3ZmQ2ZDRkY2EzOGE2MzFkZmQ2YTRjNjRjMzAxNGU5ODZjNDU0Y2YyZDI2NzRiIn0%3D; styluxebd_session=eyJpdiI6Inp1REw5ZFZVVDdSUEIzYVBiUDhFdVE9PSIsInZhbHVlIjoiM2JUWFJEclBBZ2VFcWhmQnZDY3R1UW5pR2FqUDZqbTJkdGpQb3daamUvRTlES25SWjdiTksrYlRJYXBGeWdQVHpsb3RNMFhKd2VnRHY1M1BmbmhoZ2d4OUMyS0o3Q0xueHBNWFpzK2dDSytmN081dHVhQXhxbUM4M2djek9vYzkiLCJtYWMiOiJmODlmNDMxYzg5NDNiZjllNzFkMTJkNTVkOGY0NTFkNWQ2YjdkNmE5ZjU2MTI1ZmI5YzhiODRlMTg2NmFjMDVlIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:30:21', '2026-10-10 10:30:21'),
(24, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IjFoTVZIZmdPQnZOM2JNNE5CUkZBZWc9PSIsInZhbHVlIjoiVnlMMmxwVHg1MDFORWl0c0xhYk9jV0YySk1xNGEzM1pidExXamw5d0ZnZVRuMzFJck0yYW5jeEF4MU56VkZQRFMzZ0RnbFg5dnFKdHVpMWFmV1F2Qmd5eldOdExqVXpIZEgvVmN3SDM4WEFjU1I4b3ExVThRblQ1ajE1WTNUWkoiLCJtYWMiOiI3MGI0Yjk3NTMyNDlmN2Y4NWVjMjkzZGVhZjhmNDhjMjdmZTEzYzFlM2IxODBmMDhiMGE0ZWM3NWM3NTMzMjg0In0%3D; styluxebd_session=eyJpdiI6IldHcGd0VmZRM2FJbEdqR3Z6WjhmaFE9PSIsInZhbHVlIjoiWGFVaTZTQVU5Y3BFbW9jTWlVNTIrejVSUG1BVjNYWjRVS0cxUmJYbStyQmFUaWkvdTJWOXJkRWtDWEMzK3dMWWFqdUpnVUlpR0dXSFNleFU0RTA5REkxMkpPREFjK3VMelpHcDNJalZTcjJ0Q0VXNWVHalo4dDRkc1pnMkM4b3AiLCJtYWMiOiI3OGQwMTFjOGZlNTBkODQ4YzQ3YmJmODdlOGRjMDdhNGE4NGU0NWYwNTQ2MzRkMGI3NWYyZjE5NzQyNDI2Mjc2In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:30:23', '2026-10-10 10:30:23');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(25, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', NULL, '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"sec-purpose\":[\"prefetch;prerender\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"none\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Ik1VTUxab2JqTWxrOTBybU9GVjh4N2c9PSIsInZhbHVlIjoiWXhhOHV6c1RnR1lHZzQzYnVIMCtPTDE4VUFEUCtwa00rSm02aXRXb3RESjFCMEMxTUZQaTBIZXcvWndqZzd3Sk51RUFENEY2WVNqWjQ5eG9OU2kzYUUrb2JFVDFnd3NudXAyTy85S0o1VTk2TGJnRGNTdEJQN2MrdkFTbnYwbEwiLCJtYWMiOiJiOTkxODAwYjBiNWQwNTk3YjQyOGZkYTdhYWJmMjBmM2E0Yzk3ZTgyMzIxOWIxYzBlZTZhZGVjZTU5NDg1ODEyIn0%3D; styluxebd_session=eyJpdiI6IndkVklCZThmeEJTZnVLRFlEQkFpZ0E9PSIsInZhbHVlIjoibGcwZncxbVp2ZTFhQ29zSHcrSGllcTlCQkswcGdIb2cxYWx1VEdyVG4wZFR4MzVOSDl1ZEN4K2syU2VSWVk5bWRYM0t0VjlZc0x3OFk4cmJ5M3dQamN6TTJ1UjNoTnU5UlRJazkwSFc3TFEySXRqczhoLzNKeDdkT2dkak9CSm0iLCJtYWMiOiIzNGNlMDRkMTNkZWIxOTQxMDJlNTYwZTk3OGJkYzE2OTIyMWU0NDZiNWY5ZDFiN2MwMGMxMmFlMWE2YjEzZDE5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:34:12', '2026-10-10 10:34:12'),
(26, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/test-product-03', 'http://localhost/styluxebd.xyz/public/category/straight-cut-cargo-pants?categories=3%2C4%2C4', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/straight-cut-cargo-pants?categories=3%2C4%2C4\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImFnZkdGbnVFbjRkN1lnOCtEL3ZxVUE9PSIsInZhbHVlIjoiWStjSVV3cktlbHhqM3dRSE1sZU42cm1XTGx1aDZTS0JFQkNoTGp2QWdySm55UUpmbEVWWlZ2bHJnUVFGYTh4TGZLZzhlN1M2VUZ2TUVBYzJiaVp4eDFBbkJGQjdUOXAvTVMwV3NhRkxaQmNnSXVaV2QyK243UjJHU2dVSENaUDIiLCJtYWMiOiI4ZjkzZThiMzAzYWI3YzllZWMyYjNjYmVjYTVmMDk5ZGM5ZDBlOTFiNDVhOWU0NTgxOTIzMmJiNjZhNTZjYTE4In0%3D; styluxebd_session=eyJpdiI6InNEUnRSUXpEeU1ENFg0K0JyQW9ZOVE9PSIsInZhbHVlIjoiWU9kdXJKQzlzYzJTR1FGWVVhUXRSdGZYWnFIeUJIU2ZFNXRJakdYOWdBa0wrWFBPSGFXY2dqMjRYQVREckdCejh4K2VFZXp6OVNwejl5Vmxrcmg1ZDhpWjRlU1hiaHBCZTBtZGJTa212U1pxbXBMcDhrb0R5TWVMWFV5dEpwY0siLCJtYWMiOiJiYTNkZjY1MTdlN2E2NTk2NmE0ZjdkMDk1MWEwODdlYjM5ZmY0MTBjZmNlNjlmYmFmYTUxYTE5ODRjMDNlZTk5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:34:21', '2026-10-10 10:34:21'),
(27, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/category/straight-cut-cargo-pants?categories=3%2C4%2C4', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/straight-cut-cargo-pants?categories=3%2C4%2C4\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IkVlblZtdnB5QTA3WVc0eDl0RE9URFE9PSIsInZhbHVlIjoiZUp4TDV3TGRrVjdCR1NaREVWcFBVTi9kOU51dE5JMHg1UWR5Uy92K1lxWnNaVTY5b1AwWDRuRHRzenVhQU1NVWg4U1ZtZ1o4VUl5S0VWNmx6bDJNbWxUZ0w1QWpWcUtEa05MdUNVNGlUZ3JvWGlkQmpWNm00ZjlzVE9DbVk2QnIiLCJtYWMiOiJlYTUwNTZlZTIxM2RkMDM1NjIwMWI1MDhkZGIxOTM5ZjE0YWI1ZTk2M2Q3YWRjY2VlNGUyOWMzZmNjNGQzOTgzIn0%3D; styluxebd_session=eyJpdiI6ImhOOGs0U0M4ZWRIVzVXdGN4K0Z3cnc9PSIsInZhbHVlIjoiL0hpbTRSeUxDbUlqWFlObkVVWml4UDdSV3U3WkZKOS9ld0FnUnc5MkZrVWxLd3EzdXVSSXZLQWx4bm1DbnRleFZpUkw0RE5Wd1Zad0t5dVgzVTFUUGJiUGJDdVF5dFBmc0xabDNmY3BGZUw5ZFlCYnVIb0RZbGJqdENjVTNYZkkiLCJtYWMiOiJmZDM5YmI0OGZhZWZlNTQ1MzlmNTIxY2I3MjhhYWVmZWYzYmZhOWQ0YTI1NDE1MTQzYTFiY2ZjN2EwYzU1YWEzIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:34:27', '2026-10-10 10:34:27'),
(28, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImtGUnlnMWl6S3JueE1QZFZ4ZjJPMFE9PSIsInZhbHVlIjoiVXIrZlBkZGVISVNqZnBVN3NTT0o1SXVweDNTUUVlTkZjQTQvdEVwSmFUQ3cxREIzdjVYd2lxWnRSQnl4Z1RCazUvR25yeFExUWIwWXI5MDVkSlAxMk9rcWJtdDdUZHkyMEhCMVM3dVNGVEp5d2daUzRHVnNIMkVxdVJ1bEhKU3IiLCJtYWMiOiJhMzg3ZDkyYzYwYThmY2NiZGZiNmQyZTJiNmZiM2FjODUyMmI4N2RlYWY2YTNkNjA0OGMxOTc4ZGZiODllYjE5In0%3D; styluxebd_session=eyJpdiI6InNlcmI1SjdUcisyRzNoeHhEc3Z2WXc9PSIsInZhbHVlIjoiSU5mUGFNVnhlTG9GL0NhSndhTVg0TVZ6VXVQalZlZG9PTUdpT2ljUjY5Y0FFeEFZRTRiN1ZyaXV4QnhnVHZZRzA3NkRWWk5OR281RnZKdEp0MXg3c0xjTTlLc2U4Qkg3NVM1emg4a0lodHF5bEFteEcyZVVqUllvcSs2c2RXRjYiLCJtYWMiOiI4MTRhM2UxZDc2ZDAzNzRmMDc2NDE4ODlkMGJkMjkzYzk0ZThlNWIzZjM2MDgwMTFmZjUyNzZkMTUyYjI0MzcyIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:34:29', '2026-10-10 10:34:29'),
(29, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6InE0MFFsOTdTREtQSlF0RXZqd3lOOHc9PSIsInZhbHVlIjoiMndsYmtIMTZBd2lSYUdWQkNJc3c3UkJ3ZGVSNys4ajRjalNNWnRKQ2R1THZnbkFvM0F1NHdZaXpwOUJ4MmdCQzZITk81dlRXTXJoeWN0MXZkeS9IZmRLODRweS9zeklUUnRKcm8xSmZsazFyaDZzbzA4TFhJU0RldC9jSTJYS2YiLCJtYWMiOiI1N2QxNDg0N2ViZTdlODk5MWUxMDM1MDdhYjdmMWQ1MTU4OTgzMjg2YjYzOGEyNmM5ZTVhOGYzZGE2MTRlNWNiIn0%3D; styluxebd_session=eyJpdiI6Ik90K0d0SWtEaTh3SklndWNXdk1YTFE9PSIsInZhbHVlIjoicmdOSmZBSUlxdzdDcnNVTTZFRWdZdUIrbTZtc1dWL2NoVGxzMWpvVUlobzR1bm5vYi9acVBiK3JFVGNkM2hZakhWRVZuR0FpdDZVQzBwVXJoSE1PYVZFcVJiZXpiZmRrcW9HdERwM0xFODN4bkVxTjBtSVVTS2wzQTJkYzZwaW8iLCJtYWMiOiI4YTYyNjBkZWFjYTNmZmUzMDM2Yzg5NGY5ZDllMzlkMWNiOGRiZDkzYTYxMjY1MjkzZmQzMjdiOGViZDNkYjZmIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:34:29', '2026-10-10 10:34:29'),
(30, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/checkout', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/checkout\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Ink0cnN3eGY3dzV2RHV6MThwM1A4Y1E9PSIsInZhbHVlIjoiN0VBUHRZRGZxMkRRTWppRFlDcGxHN2JkY3p4dWphWERDR3hPNWxMN0V6b3FYazBFcmpkOFM2U0NrUWJDSDExVmhwZUhpbWdpa1BXbUZDbVM2cXRTWFZnM3NvaXlQMEJrVVVKd0hML2JFSXQ2VDVsUHFoR0g2eVU3S2hvRnZKNUsiLCJtYWMiOiIzNTIzZGY2ZWZmY2FkNTQ0YzI1M2I0NmFmMmZhZDJmZWNkNjUzYmNjNzE2OTA0OWJmOGJhNjYyYWE3ZDcwNzU3In0%3D; styluxebd_session=eyJpdiI6Ii84Z1NuV0JGNkpNbksxbjZ2M0hCRlE9PSIsInZhbHVlIjoiMXlYVEMxV0pZa0ZNcCtTdExKVzFPMVBOR3RtV0xXRW5RSWdha0NzS2NMSlVtU2FyamtKS1cxSXRmQVRKSUtBc3Z2UDZpVDUvV28xNWkvZUUxVDZkQkRDUy85d1BqcWkzclpOUFN1RDBkTDlFbWpBaTJZQ2YrV1VuRkVyOVRINHUiLCJtYWMiOiIxODRjNDgwMDdjNDI2N2JjMTJhZjQxZWM5ZjU0ZGFhMDZjYWY0ZTJlM2QxM2M3ZTk3ODcxZTRkMGNiMTM3MzFiIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:35:51', '2026-10-10 10:35:51'),
(31, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImxqdlYxZ1ZVYzdGWHIzQ2pOWlV5SXc9PSIsInZhbHVlIjoickxCU3lvWTI2eno3Y0hDZ1hXcGhXa1BoUGFDVGwxQWpNNTdCdlRFTDhnTjUraUJ2dU9jRGtkME5aanNCaStyVXVqVm1GNG5RcWVMVkJqMmN2Y3A5UGZsNWg2T2tZNHB0dkJWKzR5cFBmRFpLQW9oWm5QbnFCem1vbW1mV3pGZSsiLCJtYWMiOiJhZDRhMWQxZDljNDA3YTczNzE1MTFmMDQxMzdhOWE2OGM2NTk0YzhlNDQwM2E5ODIxMTg3MTFjNDQ2NTA1MDJhIn0%3D; styluxebd_session=eyJpdiI6InpPR2xOdG1IZ2VYcUhuUDdvNjZKQ3c9PSIsInZhbHVlIjoibUtJTDF2ODJLTzU5bjlQai9JdHZoM3ZOWTE2TlZIVFFwSmptOUsxc2JkdWYzemR1cXBBQzQwbTIwWVhuUHZvOXpSc2FpcStlcjl0WGxjMisrWkx3TTdidUp6SlJlSEMzeFU5eThPYmkwM25PKzNDUEtUNWovdytDUXRaVjFqQ0QiLCJtYWMiOiJiYTUzMjExM2NiMTU5MWIwMDM1MjY3NzdiN2JlZjZmOTJiMTczZmRlMDI5Y2RhYjk5ZjEyYzZmZDFkY2VmZDBmIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:35:53', '2026-10-10 10:35:53'),
(32, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImxqdlYxZ1ZVYzdGWHIzQ2pOWlV5SXc9PSIsInZhbHVlIjoickxCU3lvWTI2eno3Y0hDZ1hXcGhXa1BoUGFDVGwxQWpNNTdCdlRFTDhnTjUraUJ2dU9jRGtkME5aanNCaStyVXVqVm1GNG5RcWVMVkJqMmN2Y3A5UGZsNWg2T2tZNHB0dkJWKzR5cFBmRFpLQW9oWm5QbnFCem1vbW1mV3pGZSsiLCJtYWMiOiJhZDRhMWQxZDljNDA3YTczNzE1MTFmMDQxMzdhOWE2OGM2NTk0YzhlNDQwM2E5ODIxMTg3MTFjNDQ2NTA1MDJhIn0%3D; styluxebd_session=eyJpdiI6InpPR2xOdG1IZ2VYcUhuUDdvNjZKQ3c9PSIsInZhbHVlIjoibUtJTDF2ODJLTzU5bjlQai9JdHZoM3ZOWTE2TlZIVFFwSmptOUsxc2JkdWYzemR1cXBBQzQwbTIwWVhuUHZvOXpSc2FpcStlcjl0WGxjMisrWkx3TTdidUp6SlJlSEMzeFU5eThPYmkwM25PKzNDUEtUNWovdytDUXRaVjFqQ0QiLCJtYWMiOiJiYTUzMjExM2NiMTU5MWIwMDM1MjY3NzdiN2JlZjZmOTJiMTczZmRlMDI5Y2RhYjk5ZjEyYzZmZDFkY2VmZDBmIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:35:53', '2026-10-10 10:35:53');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(33, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-03', 'http://localhost/styluxebd.xyz/public/category/06-pocket-cargo-joggers', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/06-pocket-cargo-joggers\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IjZGOUpzcnYxYTIvRnIwRlFRaHBmYmc9PSIsInZhbHVlIjoid1NvWTZKS2wxOWFQS01ZeEtWRmRneEgvb2lYZUxQNmZqalhpbE44aDU2Q2FDWGR6T0JGTjBXRHNka0Y0aU9QWHN6NENsTkg2b3FoVHlaalRsVnY4NXpzNy9rdm5UcFcydGErOXVLM0x4bWhGb2JZU3RJY1IwYU5EQkN2NHl1Tk0iLCJtYWMiOiI0ZjI2ZmVmOWJiNzIxZGJjODUxY2EyZjFlZGQ1YjgwMzdlZmQ2NmFjM2U0N2Q3OGVkY2YzODkwZDVlNGQ4YzAwIn0%3D; styluxebd_session=eyJpdiI6IkZacHYwOXhkUTZLV2NGOGVTSTZ4YlE9PSIsInZhbHVlIjoia0dCWXQ5Y0NzTjNmVm1XYzhzU2tpNXpDSE45NG1Zc2cwN2N3OXN3S2NZQnl6a1JSQ0lQZnJ6U0NOTHlNemZab0piWlg3WC9JZS82VW5iV1lCdGF5K3B6bHBzSVk0MDgyWlFaOFY0ZWRlWG1JbklKeisyWFh6R3B4SmJRRzRwVDYiLCJtYWMiOiJiZGU3NTcyMDZlMTYxOTU4YjE2YzJlMzlhOWVlOGZmMzkwNjZjMzAyN2M5YzczOTgwMmFkYzI3MjFjZmM4YTM3In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:38:12', '2026-10-10 10:38:12'),
(34, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-03', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-03\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6InNRZEY1cGZOY2MvLzlFSHB3azBXYWc9PSIsInZhbHVlIjoiNHZ2ZUlLQTlJdjJRb3dPbTVXNUVLTTBMWnVpcm9wTnVrNXlHY1l4bk01bTFxenFGODQzMXErdDB3V045R0gzVnc2UTUzbmEwem9jUlg2UERsYUtaSmZ3N1BtWG1GbDJIYkJGS3dpOVQxVVpVOWxRaXdmMTBKWUZXRlR0eExNL1giLCJtYWMiOiJlZTViYzY3MmE5NjNhMWI4ZDhkYjkxYWRkM2NjMTJjNDczNDYxN2Q1ODYyZWFlZmZmM2Y0MWJmZmRiY2ZmOWRkIn0%3D; styluxebd_session=eyJpdiI6IkdCYzUyRmxFaTQxT0tQK1RzdmFyNHc9PSIsInZhbHVlIjoibFpTN3R6MkV5eWl2Ry9CVWJHeEFVQ3dtREJQeTNUYnVqZ0F6YUJHNkhzS2x3UE5VL1lYODF2aVpIMnZwbEw1NElzZDZIZG15UFZMMHliRCtyZXB1Mjl3cytoQktPSEVjcHJiaXhjc2FJNUVzMEltUU82d3NTWHMvaW5nTnpOYjgiLCJtYWMiOiIzYzY4OTU4NTM5NzFiOTExMWViNjNlZjAwZDQ5MTQ2Y2U1MDM1YjBkOGE0M2Y2YTA3ZTljNTcyYWYzNjljZmRjIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:38:15', '2026-10-10 10:38:15'),
(35, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/cart-products', 'http://localhost/styluxebd.xyz/public/checkout', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/checkout\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Ind2NWV6MUtXV1FYMTRMVEwrZFJjemc9PSIsInZhbHVlIjoieEd0bUNncDZsOUZDcjdCQWtvNkJyeGs0TDhyelloUStnRzMrTkgzUUhNSy80cmkxOHZMeVc4a2xYQjU0ZEkzZWZWdE1neEFwNEJmazZXM2xYMVpGVDZZMFhoaWYwM2ZiTkdCYUh4S2VtRUlYeVZidGcrT0F1QXgweUYyY25iazAiLCJtYWMiOiJmYjcyMWFlMTM2OTkwZDYwOTY5ODA1ZTU4OTk3ODA3MTMzNWU5YWVhZWMyMzU4MmUyMjJkYjIwMzgzNTcxNDE4In0%3D; styluxebd_session=eyJpdiI6IkZuVGVTVHZtdHdHcGlzcVRSTU92ZEE9PSIsInZhbHVlIjoiMUdRNitVclBVOVdxVkhDUGtNNGRPUlk1NFQ0aXZkay9QN0lWMmJ1ckZEZ0lPMzFBa3R2dG9WbHRITUs2TFcvam9wVmRQR2c5cFcxWWZvUGZVZk0wNTlzanUvaGx3S25zVDEwOUtTUlZqc3l4eWlSd3k4RWp6Wm1FNEhzMXdXNGMiLCJtYWMiOiJhYjU5NWVkOTY1MzAwM2RkMmIyNjI1MjBkZTdlMTQwZTBkNWE3MzUzZGZlYzZkMzk4NTcwY2E2MzJhYTQ1MDUzIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:38:18', '2026-10-10 10:38:18'),
(36, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/cart-products', 'http://localhost/styluxebd.xyz/public/cart-products', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"x-requested-with\":[\"XMLHttpRequest\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"*\\/*\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"cors\"],\"sec-fetch-dest\":[\"empty\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/cart-products\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IlBYeEc4cjNKT1ZpNDBtS2FuY1htVUE9PSIsInZhbHVlIjoiWUE4Rlg3KzFvZ2lWKzczL2RJN0pjWUlxcm9FUFRPV0xxbllrSTZUdHdsbzRUenRsU3BkQXoydC9NTEg1VjZvZVZxSUxDeUNZTzRjSkZnTGVkSER3bzN3cDVDcjBZTTE1RndQSklGT2RWd1E2QTRCK0JXd0hoM2RLVit2cXErd3AiLCJtYWMiOiIwMDgwZDFhNWM2Y2QyZjE3MjQ1ZDJmNDI3Y2NjOTNhZTFiMmQ0YmM3YjBkYzg2OTY3Nzc1NTgwOGZmMTVhMDE2In0%3D; styluxebd_session=eyJpdiI6ImZFUC9EZ1pxTHBOYWZUb1hlbjQ0QWc9PSIsInZhbHVlIjoiSHdiMFB3bVpjaE5TY3B2bERZcVpUT0tucHI4SFVJUEF6ZVM1Y0NrTUdVa01RWjJvTWEyTnFJbk5hR2FGUXc1TDYwR1VYNVZKbDZCZnhSRmlMVkFzM1FHVUVUU0pTVFkremh5Qi9ZRGV0NG5peTJOVWthd05PSzZXWHpwMS9POUciLCJtYWMiOiI1NWRlNDM2NGFjZjA5ZjI5YzdlOWU4N2RkZjBlNjJjMTVhNDdiZjc5Yzg4NGJhOGVkZWY5YzU3NWI3ZjU3YmY3In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:38:22', '2026-10-10 10:38:22'),
(37, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/cart-products', 'http://localhost/styluxebd.xyz/public/cart-products', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"x-requested-with\":[\"XMLHttpRequest\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html, *\\/*; q=0.01\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"cors\"],\"sec-fetch-dest\":[\"empty\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/cart-products\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Ik9XTWFETFNRM1NpUjA4Z0RpU2dpT2c9PSIsInZhbHVlIjoiR0kwZG5EbStySlNsaXlMNGdnc0dTTHJhWHVka0FFNmV0TldaZ1JsNTVFUnlVYk54Nko3djV2RHdtdkV3NzRMd2hPd2dQMWl0SXNXU2JFVyt6V3dlNHQ5TkxvMXNBZWsxUUZSOTBXb3E1Tm9sRStjR2FzUmo4bW5LdEdtWnVGaVciLCJtYWMiOiJhZDQwMTI2ZTYxYTU5MzIzNWVhODFjM2E5Njc5Mzg3N2YxODc2NDAxYWFhN2E4Zjk1M2M0NzE5NTA4ZTZmMTkzIn0%3D; styluxebd_session=eyJpdiI6IlZGYVcveEVyOUxIWXJvUndkSVZDa2c9PSIsInZhbHVlIjoiQUNXWFplWVdtWXF3RVFDVUZxb0xtYUNpdFFkdnc0U3RIanJQeG5Na0xyTlFBdVRiOXBZNzYzdlZqUXVWNlBXY3lyWXMzSEN0UDhGTEJzTUowOWFYZTREN3lLNkkrLzJOdUoraXhPWEV2SmFRRDlZRUlTY0ZuVXZ0Y3VvUXM0R3EiLCJtYWMiOiJiMmYwODJmMmRjZGMyOGNmNTZjMzAwNzQwYWI2ZTU5MTEwZWVlODUwMjQ3ODdiYTg5ZWY3YTU4MGZmZGY2NjVhIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:38:23', '2026-10-10 10:38:23'),
(38, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/cart-products', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/cart-products\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IlIvd09IU3FkOFM1MzZkNUdkbFhycnc9PSIsInZhbHVlIjoia0VhUnlkRTZzbm1rd2o2S0RhZkFOM3o0MUw3eFVTcVRWZThEaGtKSmMzM1NsWmVCNjJMQXZKbGh5ci9ybExNU2xySXNoV3NBNDRCd1gyK0Y4ZUd5OTNjVk90TVAxTUxIMUh4SjgwSHM5cU5mQ0VURGF3TWc4V0c2WlNDa2RnSngiLCJtYWMiOiJmM2VlZjllNzY0MzM3MTk4NjAxMTUyMjQ3MWExZDU0ZTE4YjdkNGE0ZjE1Y2NlODFmMWI5OGIxYzI3ODhkNWQ1In0%3D; styluxebd_session=eyJpdiI6IjhDNExONjJBaTRuZ3JSNzQ2WTVZK2c9PSIsInZhbHVlIjoiMWhsYWFCMWVqVXdua2RiVXQxT0Fka0JrWTE0aGo1VDN6MUZmakZybGlJNlViQnliWS9oYUZhU0dGMnRYZnQxN21nb3h0dlNVYVFNOTBNQVJ5TTZSaDFkc2tCcnRPdzNmbVArR0RiajNzcVlLZks2ZWZDOWdiaUh0ZXZWRXhmdmwiLCJtYWMiOiIwNDUxY2I3MGI4NTBhYjRlNTViNzliNDBhYzNiYmViYjBiN2RlMzEyNzFjMjU3Mjc4MzdmYTliMzUxZDVlNTg3In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:38:25', '2026-10-10 10:38:25'),
(39, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/confirm-order?invoice_id=SB10', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/confirm-order?invoice_id=SB10\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6InQyOUd5ZTJIM08xQ0xJbTNvWDVXRlE9PSIsInZhbHVlIjoieTNJOEhuSENaOW1veEtSam5QWG1STnROeTQxWittR0ZEMDk2bUcwNDAvbUV1ek1RSzNtcnByTDlVK2NhZjBNUXQwU24zMmFzTm9YWTE5aTExYlNGR3FZQ3REeER5SmRCNHhwc0VoNG9hTTZLengrL2VvcTEvVCtFekx3bGVGMFoiLCJtYWMiOiJkNzlmMDZlMmE2ZWM3MDlmNjU5YjdiM2M3NGY4OTlmOTEzOGQzODE3YmRiZTg3NDI2NzBkOTY1ODkwMjY5NGMxIn0%3D; styluxebd_session=eyJpdiI6IkdSbGRFd0VOb2RhRmliVTB1NFBEN0E9PSIsInZhbHVlIjoiTlI2ZG1OYWFJUzdjYVNEbVJVNGNhR2FZQ1ZHQTF6OWdJVXhMWnVHTkhTQlpUV1grY01JcVdsTDVuWm5LcmpxZDRSaEN4SnNUT0tZcXkrRVRuTW1PRnNnT0dZZlRSYmlzTnBoU1ZFYWRSNVNxeVlFQ1RIc0VWclhxMEpEUFZnaUgiLCJtYWMiOiIwY2YwMGM1NDE4MjI1NmFhZjhjODUzZGFlMmZhNmQ4NzI0MWI2Njk1NGMyMWU2MjU3OWM0MjBmNTQzMDA1NTNkIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:40:03', '2026-10-10 10:40:03'),
(40, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/category/06-pocket-cargo-joggers', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/06-pocket-cargo-joggers\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IktPWFVYNHgzd2VzSTJmUzZBUVI1TGc9PSIsInZhbHVlIjoiZEJ6VGxTZlBoWlpFVGwvS2xtalR6VGxPaEZaUVROQjdpbVFXU2IyNWlNcHRSVE9JKzVzNk8vQnNGWjVRL2VUbExTbUgxKzJjcFFnSEVlTVdrUUR0clpHcWZZcnZDMVhrdzhZa0w0TGFJS09CTEJ5L1N3MDlIbHhFZWpuT29HU00iLCJtYWMiOiIzMDE0OTc2YzI4MDBiMzUyODdhNjljMzE2Y2M5YzFhNmRlNzk4OWU0OGE3MzlhOTJlM2IyMGRmMWM1MWZiM2ZmIn0%3D; styluxebd_session=eyJpdiI6ImZkQVBrOWZac1hjbjhHTU8zVmNsTXc9PSIsInZhbHVlIjoiTkt3OUJkT2M1YlhOR09nNVVGSjNxM1pDc1ZQY2JCOUdLVFIxQUo4bzlxOURxb0YwS0JhSUFEeVhyanp4U2pmQVZCbVhYbDE4OHRJaEtGL0cyVmdBbktGTUdpenBzVTFCVUwrOUlmb2s1c2I4dkZlV2pNU0J0UHpyVU8vdDRxMVYiLCJtYWMiOiI3NWFiYzQ3YWU5Zjk3ZWY3ODQ3NWY3MzI0NDE1MTIxZTBhMzUyMDBmMDFiZmRiMmZiNzA1N2ZjMmFiMzliYTc2In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:40:07', '2026-10-10 10:40:07');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(41, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Iml2cTRSTUpobThMN2tRNkRYYW9iYnc9PSIsInZhbHVlIjoiZll5R1pXL1dDY2hjU01rb2FvWVNuUFl6YldLaldNamt4NnAwRmUybHBzMWZmRU44ZkVrc2tSNzVlc3JFUGdncE1ZVE5lbDJmb0VBTk1vWU02L1NmcklHYzBNSFVseGprOGplMFpROEl3a3ROblRQUXJId0hqWGtOSkFZYUJlengiLCJtYWMiOiJjNjkxZTczMjc3MmYzODE4OWQzOWE0MTFjZTkzYTI0OTRiMTljZjk5YTMxMmE1NDIzNDI3NjA2NTJiZjQyMDdkIn0%3D; styluxebd_session=eyJpdiI6IkpiS3hEZzFiMkJoSVpSL1hNYzJUb1E9PSIsInZhbHVlIjoidFJ5c1IzbEl0K0VsMlM0YzJCcGdiVjlnMUtzNkFmSnA4R2RsMllaMHg3dit2OWtaUERxTnY5N3BPMTQzSjZvd1gvOWJOZzl4K09UMU14RGg1Sy9ZRm9nTUdZTmFNdS9LZkMyN1ZMTml5aVViV2dHWVlzaERYenRwOHYzT3ZMNXIiLCJtYWMiOiI0MjRmMzczNWE1NTRlOGU2OWYwYmJmZTJmYzkxYTkwNTBiNmI0YmNmZWU5MjkwMDA1MjczZDFlNTJhZjMzNjdhIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:40:09', '2026-10-10 10:40:09'),
(42, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product-02\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Iml2cTRSTUpobThMN2tRNkRYYW9iYnc9PSIsInZhbHVlIjoiZll5R1pXL1dDY2hjU01rb2FvWVNuUFl6YldLaldNamt4NnAwRmUybHBzMWZmRU44ZkVrc2tSNzVlc3JFUGdncE1ZVE5lbDJmb0VBTk1vWU02L1NmcklHYzBNSFVseGprOGplMFpROEl3a3ROblRQUXJId0hqWGtOSkFZYUJlengiLCJtYWMiOiJjNjkxZTczMjc3MmYzODE4OWQzOWE0MTFjZTkzYTI0OTRiMTljZjk5YTMxMmE1NDIzNDI3NjA2NTJiZjQyMDdkIn0%3D; styluxebd_session=eyJpdiI6IkpiS3hEZzFiMkJoSVpSL1hNYzJUb1E9PSIsInZhbHVlIjoidFJ5c1IzbEl0K0VsMlM0YzJCcGdiVjlnMUtzNkFmSnA4R2RsMllaMHg3dit2OWtaUERxTnY5N3BPMTQzSjZvd1gvOWJOZzl4K09UMU14RGg1Sy9ZRm9nTUdZTmFNdS9LZkMyN1ZMTml5aVViV2dHWVlzaERYenRwOHYzT3ZMNXIiLCJtYWMiOiI0MjRmMzczNWE1NTRlOGU2OWYwYmJmZTJmYzkxYTkwNTBiNmI0YmNmZWU5MjkwMDA1MjczZDFlNTJhZjMzNjdhIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:40:09', '2026-10-10 10:40:09'),
(43, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product-02', 'http://localhost/styluxebd.xyz/public/checkout', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/checkout\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Iit1Um1YTGFyRmRWQS9iang3YUUxb3c9PSIsInZhbHVlIjoiY0pRaENrZHBxMEU5clhaK0VyRGZhVjU4eGRRVFVNUlZDWmttSXlKK1NoSFgvWFNlWEtrUHAzZE1ONWZvZFJyZWVDaW1TR2JTZGxXQ1FnSXNKNzlVRkZvZUsyRFVkUmNZN0xaVU5HUTliRWp4NFBrNTBwdGYrVDRtazhCci9Fc0oiLCJtYWMiOiI5Y2QzMjJlODZmOTAzMTAyZDViZTQ0NjFkMTEwYWZjYzA3NmJjOGJiMmY5YzA3M2YzZmUyYmRmOWUxMWQzOWVjIn0%3D; styluxebd_session=eyJpdiI6Im1ZK3BETERhNFRGV05PT3l6ZWxqeXc9PSIsInZhbHVlIjoieWxubG5rZ2VLei9aMG1Gc3c0UzE5RDBsVG1MQjR5ZGE0R1dhYWpsT3l3Q0IxYmVXVzFNUEJNNmlBUnpTV01YL0VKVmlpbW1aTU54dGt2UnRXZmFRZytaRDJXbVBzamVSVlg3TTFiYytlL2lPUFJsWU5UR0JlQ2NpQzlDbEVOcDUiLCJtYWMiOiI5MjhhZjFkZTkxMDg1NTRmOWFhYzczZmFmNGNmYjc3YTJlYmI1OGVlN2I5NTNhODZlNjk4YzA5NDhiYTllNDViIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:58:32', '2026-10-10 10:58:32'),
(44, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product', 'http://localhost/styluxebd.xyz/public/category/06-pocket-cargo-joggers?categories=2%2C3%2C3', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/06-pocket-cargo-joggers?categories=2%2C3%2C3\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IjlvNnlxbDRqK29UQUM0ZzNPM1F5U0E9PSIsInZhbHVlIjoiSWQ4MTh6NmRYRC9keEQ2cWhKSTNlVGYzUnpIWHRJdEJtemo0Rms0YlVLeVZaL0VDMThKVzNFRWtzclg0YWl2YmsvWjZubnp1dHovekJvWEVEZDVwYnc1eHJtSC9xVWdYUFk2UEZPQ2RkbnhZQi80ZjI3NXhYUmxrdmpIbVQrMVEiLCJtYWMiOiJkYTlhODhhMjQ3OWFiNmZjYjBiNTgxOWFmY2NlYTZmZGQzMmYxM2I1OTgwZDE4ZTE4MjdkYmU3ZjhmMmZiZjFkIn0%3D; styluxebd_session=eyJpdiI6ImhKV3g5Z2MyUy9sRnp6ZjFGQ0Ria2c9PSIsInZhbHVlIjoidUVIZUJJYUdFWFNkRkZEUEtNS01NSUt1NE5XUk9iRWdyaXpXV0xSWDI0cEpEVXlDUmtDSGdLcXlUeEVFaUc2T05aOFFLUzZ2SE55bE9XdXMxZGJ5VUZuQnNCVHdWYmFxMTErZTlrcWxEd2grNG0vYmp0d1luSzY5UFZvcjB2MysiLCJtYWMiOiI3YzlhOWRiZWE2Y2M5NDdmN2QxOTQ2NzFiZGM3ZWJmMWY1NWM1OGQ0MTZiZjVlZDVhZDVkMjg0ZjFlNTA5OWNmIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:58:47', '2026-10-10 10:58:47'),
(45, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImpzanVYa1RRdGZ2enRTV0g4b0x4aFE9PSIsInZhbHVlIjoiQUNOdUNyVTZldXFiU3hCd1EwN2JUQ0ZWdE43c1Z5ZFB0YWdjTE1sUnViT2E2SFZGQUN1ZExpYXIrazI0NVdCTEZhZWlhV1hwcDNleDc3NEYrb1g5YU5INTF2bGdwTUJzZk1wZkhscXpnZXdRb2tnbEo1N0dzSVVycmdTK2FqeVMiLCJtYWMiOiIxMTVlM2U2YzkyNThhNmYwMGUxNDIyODRkMGQ5MDAzNzIyYTk2Y2I5YjIyMjJhZWE4MmFmZDcyYTE3MzE3MGNlIn0%3D; styluxebd_session=eyJpdiI6IndzalBHN0RYN0hHbVpKNlJiY2tyL1E9PSIsInZhbHVlIjoiVndlOCtxRFV1Vzhya3N3eCtYdnppSkg3YW92RkVubUEydGJtOTFyTkcxcjFuS0dVRWduRGdxbWwrbmtFa0JOQ2N1MUw4SEE0cTQ0aGxPeUEwVEsxTzVROXYveHpLWi9DTmhzZlJ3aFFwVEMzdm5DUXRrTTU4WUw4aFZFYzZLS0QiLCJtYWMiOiIwMjkxYzNmY2ZkMDA0NDM0M2M0NzM2NTU5NjAzYzMwNjBjZTZkMzkwODNkODQxYTg3YmMxNGZjYWE1ZTdkY2I5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:58:51', '2026-10-10 10:58:51'),
(46, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IktkTDRYS1VKRGh1ZjN2alBQZGIvWFE9PSIsInZhbHVlIjoiT3hGYmFYQ2J2ZWs4NHJ6SEhNK1JRUkt1Yy8xcWhGZ01PWGhYSWtOMnplUkdsaENPeFdJZXp2RHY2WWFiYmJpYWppNndackFpOWtZeGs0YS9CTXRNa1lGdUhGR1loS0pRZmREVFFTdXBGV0NQUkF2bjNlaks5RUhTVGxzSS9meDAiLCJtYWMiOiI0ZTUyMmQ0MTNmZTQzMDNiZmNjN2Q0MTE2ODgyMDg3YzM5MzJmZWE2OGM3MDNiOTZkNDY4NDg1M2UwYTZiYmUzIn0%3D; styluxebd_session=eyJpdiI6IkFwUXhzbm1pZW5FRmlHbm04cGtva2c9PSIsInZhbHVlIjoidnRnMUJKNDhPMnFjWEtYRkFFZ2ZSbWZHeUFQMjlnVTI5bHdHOUtzNmtVR2ZXK0lLTmVoVDZJb1VVRXdRZmxPZUt6czFIbWlwRTIxVWpVdkh6OWNYQ1p2c05DSnhneUgyZXl3bW51cm8wZ0t0N3hTWnBKRzZ6RXJ1NHFoQ0UxZlkiLCJtYWMiOiI0NTk2NTdhNTE4MzZjNzRjZDczMDA1NTJhNGYwMzdiMzdkMjdkMWEzMDI4ZTQxOTFhNDQ5NzE3NDA5ZjgzM2I0In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 10:58:51', '2026-10-10 10:58:51'),
(47, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/confirm-order?invoice_id=SB12', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/confirm-order?invoice_id=SB12\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6InIzZlpyajlsMEVIYXltdTNlLzExclE9PSIsInZhbHVlIjoiYlNyYjh5ZGMwOWVvRWZ0QU8vMVlmblRrNVJTb0dlbXJJOENVYlZFQVNycXZuZHFkdC9YdGdmUCs3akdPeEZMQWJQdmF3SHFwY0hOVWd6Sm4xdHVmN0M2K2dCcEs1c01tRE9oTHl2T2J3R0IxS2RNMDc2alpRa1dUTnY3dytqb2UiLCJtYWMiOiI1NmJkNmU3MzA0NzE5YTk5ZmJhYjk5ZGJhMjhiNjdlYzI0YWQ2MmEzYzI4YzBhNjM2YzRlMDQ2NjU1YjQxZmYwIn0%3D; styluxebd_session=eyJpdiI6IjVVaWZFaFRsWm1jMUZKa3gySHRnYkE9PSIsInZhbHVlIjoiM1NKUkpQdGEweE4xN0tvNmFFKzhBbzF2aGdxeTdBbDIvSDIwejZGS0RWelJ4WXlaazc3SmxDc21JckNaejBuQW1mN2FlbXo2ZXdDNitlMmdiSFZpWCtCVEUvZ2s4NlFsb2VFcDAwcXVMZjErV0o0RDhRTkwzMUlNckl0MFhEVHAiLCJtYWMiOiJiNTEwODBlZDViY2E2OWIzMzliZDVjYjQ0MTUyMWQ3OGIzZWI5M2ZhMzRjNzQ2MTdmYWIxNTlkNDgwYTYzNTE1In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:03:51', '2026-10-10 11:03:51'),
(48, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product', 'http://localhost/styluxebd.xyz/public/category/ice-silk-pant', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/ice-silk-pant\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Im5uUFhneXR4c3M2UXkvVExMZlp3NkE9PSIsInZhbHVlIjoiZVVIcUhkZk9PWUx3bkxlbmdxWVJFOWY1Mkg2Z0hkNGx0M1JNdGVXRWRmbHpkZXdTbnJrVk5GbG9vRElzeklBNmEvdUpkREt3dXd3dW5jRWlIc0loSGtmSzI3SHY2ZUlJbVh6RHpyNUluZlFuTnllb1dnd2lrTlkya1JVRFlCai8iLCJtYWMiOiI4ZDU0MzIzNGQ0MDNmMjYwN2IxMTMwN2YxOGJmMTRlNjRmZmQwODg4ZThlYjI4ODI3NTJhYWIyNWZmYmE4NGUwIn0%3D; styluxebd_session=eyJpdiI6IitnM1dFUHpKZk1TL3ArZnZiRzMzdnc9PSIsInZhbHVlIjoiV3VZV3pEUFpqbnhVZmtVYVVHb3JoZWpZZlRHQVRpOExPMmZ4RTZnenZoMHB3MVNneDlURlVna0ZwZGFzcnFoakFmZHZXZWtJdnp0aGduNmhZK3ZwRlZoQVM3WjlnSGlLNXM5L3djTWxVZUZndWp1TnkzQitzdkQ1Qy9sTEkyV0QiLCJtYWMiOiI1YTlkY2E5YjgwMGE2ZjZmMTI2YjQwNGY1NzE3Njg3MWY3ZGViOTExMDk3NTFhY2Q4ZDAzM2QzMGU0YTU1Nzk1In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:03:54', '2026-10-10 11:03:54');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(49, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Ik9ieklzZTcrUEFHMHN2UjBVVit6SWc9PSIsInZhbHVlIjoiS0ZxcE9VSndpOFhmUEdUZUFEZmkxdzYrVGtsdUMvREhVZHBTYW5XNE5rTzRPa1MyOHo1V2ZlZXlLbCsyWDFNUHZ5N2M4V09vWmNsM3U3c29PcDB2VWtWKzZKL3EyaWlkaFVlTGZXMG5KdU1LQmNkUjNHU1NMMmFELzRxajQ1UmsiLCJtYWMiOiJiNzNiZjY4Y2IwMmE4Y2RjN2VmNDNhOGNkOTJkMGRiODdmMGU4YzQ2MTIxYzllYzg0NzE1OTk2ZmIwYmRlZWRhIn0%3D; styluxebd_session=eyJpdiI6IkNMMS84SGMxRnNrT3RyL3FzcThTdmc9PSIsInZhbHVlIjoidWUxbzhSTjh6c0phZjVaYmFQcjlvYzlSSWdrakRmTmJuZ1V3TjhTOTZDYmpTZXViZ2ZtVWhUaE54YmtER2lMRWhzd1lvTTByZ0xmVW1rV2V4MmUwWXVMRk5vREdLWlZkT0t3c2N5cVRtamppZDIzTXJuQ1FoTGZ3elN4dFdIZ0oiLCJtYWMiOiI3YTdkMjhjOTcxYjZkNzgyNGNlNzQ0NGE5MTQxYjA1ZmNhM2JkZDRmYmVkNGJjZWNmNDRlZmEwOGEwZDk0YTE0In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:03:58', '2026-10-10 11:03:58'),
(50, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/checkout', 'http://localhost/styluxebd.xyz/public/product/combo-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IlA0WFg0NUZ2cUlTUWc0QVpGNWFWZWc9PSIsInZhbHVlIjoiaWFLWFo1T0w3ZnZYYm5ybW9ZZVlEdHBDU0FYMEFiYU43UmlKU21hMmRSQUd4dVFqMjVoRzBidS92UE9rbi9mUTFmeXMvSHZ6U2xaOG9wN0J4UStvZVlZQkI5bW1iaWxtQXhnR1dBWnhDMEdyeXJFSmVtNnJnWmxvb0lkbG1hMkwiLCJtYWMiOiI1ZDNjODMwMjY0MTM1NDYxYzFiMTA3MTMxNWE5ZmE2MjhmZjIzNGU2MzIzZGY1ZTdjNWJiOTljMzQ0OWQxY2JlIn0%3D; styluxebd_session=eyJpdiI6IlhvRFYyaUpTaDNXT2ZZWnAzRS80WVE9PSIsInZhbHVlIjoiWTV3YnNoOXBGRk9tUDVBZjQxZ25ZV0hOZTR3T0RtL0daSGJ6Q0k1RGRpOFdSLzhhdEpsRTR1eExFa0VGZENyRzlROG43NzZGVHl4Slk3SitCTXNXd29jTFFSR09Na3FhMC84Rk5XbFVSeGNxek5JVkNGWEtkUXpFSTdjR0tROU0iLCJtYWMiOiJmMWFkOGU4ODNhMDVlMTcxYTcyZDRmYjkwM2ZhMGE5MzU1ZmFhZDk5YzJjMmRlNTVmZjllODY1MDA5Yzc1Y2U4In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:03:58', '2026-10-10 11:03:58'),
(51, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/confirm-order?invoice_id=SB1', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/confirm-order?invoice_id=SB1\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IjRadGVndHJGQjFoSU5HbnF4eHV2cEE9PSIsInZhbHVlIjoielBPOFZuMnJKRldCUTBpL01EL2FTWHFTR3pacjJHOVAwYXlRQzduOEE0SHh0aXc5WDdFVzh2M0l3dU5veUR6TURKRjRSOXU4QnNBRnM1SENNT2tGR3F3d3FnN2d4VXp5c2prbEgrL29QSWdRYlNRVzlVdGxoNldhbXdoMkhIMGEiLCJtYWMiOiI0MGYxZTI2MzY4MzdkOWU4ZWQ4ZjRjMjBkNWNiYWU1ODM5MTVkMDc1ZWQ0MzJkZTk5MTdmMTc1MjFjMjY2NGE0In0%3D; styluxebd_session=eyJpdiI6Ikw1cTI5czRWTXZHUDVPcGdUZElNa0E9PSIsInZhbHVlIjoiNlRMOTdIendQdGtxbmh4Q3V4SjJMejBsNEdrUk55dVlwK3p6L0p0eS9Pb0ppUEVTZlpOSGdmWkxEY2R6VzRpWG9lNTN1WHZpTmtQRE14SjZwM3FoQWRIbkN0ZEQxcUFXWDF3T21tekIyL0RYbUtELzBQdzlocVg1VmdNRXVvaE4iLCJtYWMiOiJiZmE3M2RiYTEwODU4YWVjNTg4YTE0ZTM0ZTg5OWVmMWY2Y2UzYTg2OWZkMzcxODgxOGUzYzlmZTYxNzJiYWY0In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:25:32', '2026-10-10 11:25:32'),
(52, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/confirm-order?invoice_id=SB1', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/confirm-order?invoice_id=SB1\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IktsVmFzTEdzUkJ2cXczVjBhZk1rVmc9PSIsInZhbHVlIjoicGlHalNNMXc2aCs1NXhKOFh5Q3BzcU5zVzV3VXJGLzZXMGttMTRUTkdaL1ZZT1FKMUlqRUlNeTdycjlMUTFjQ1FQNGVQeFdLRDE4dmxrU2IrcFhFUGcvN0FPbE9nVmVqb25ZU01mUTNZUzJpOCtBaGdZcWtlZnBDM2hQWTNGZG0iLCJtYWMiOiIwMTI5NjkwOWMwNWUyYmQ2NTlmMTcyNzJhYjdmMTQ5YjU5ZWE3NmNmOTNlMjg0OTFmNjczMDI0ZTdmZmJkYjc5In0%3D; styluxebd_session=eyJpdiI6ImVPb0VCYjczWENuNWs4aThuYU0vcXc9PSIsInZhbHVlIjoiWUdNNGJKekppMnRscFZzTThHdzBaZXRPY3hJbGZHZkNQSFA2ek45c0F5Yld0eGZQZ0hFNHFyWExSWHhWRCtyek0yaThRZDVrdmhJRys4UWQwMUdHTlhSRmNnbHZQQ2kyWkZXMFJsdUY3OCt5YmtvaGF0eTRFWitvQ0E1bjNNYzEiLCJtYWMiOiI1MDY0ZTYwY2QzNTNjNzdlOWRhNDMyMzc3MWViMTFiZWNjNjk4MjkwM2Q3MzRiMTdiN2U2NjY2ODNjNTBhMTRkIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:25:33', '2026-10-10 11:25:33'),
(53, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/category/straight-cut-cargo-pants', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/straight-cut-cargo-pants\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6ImJ4bktIMS9FbVBFZ0pVQmRpSjVtZFE9PSIsInZhbHVlIjoiWnl0aW1iZ3p6aXVJckNpeWNuaU96aVJXTmRBV0pabFQrNTVUSHpMU3krZFpmMGF4cXNMQjJsZkV1d0FQSHZ1YlhkeHVSL1I3aWg1SlIzZHVqaXRDL05uZ250UFM0WndYRnYvTHdXR0k1OWdmUmkxNEdqU0FtTEE4ekVqVjl3K1EiLCJtYWMiOiI5MGNlOGI4ZTE4NDIwM2U3NGM2NDA0ZjkzYjdkNTFhZTM4MTkyNmE0MDMzMWU4ZTgxODE0N2M0ZDVmZDhjMDYxIn0%3D; styluxebd_session=eyJpdiI6IlZkYkNUb1VndjdBRlhlWm8xV1Zmenc9PSIsInZhbHVlIjoiYi9NSGhkMW5KbEdKSGZMTkdkUExueDJxaFNLL3grbzJqVTZDbXVPMTRwWTBaNkdLR0szTysyeFIrcFhwYUlsK1FLRUZqaEdEUkxGVGgzaGNoMkoyQ1h4ZE9zVFJxSkhtUDJKUklGazJtWVEwMmIxbjlsRENvcFZtM0s2OTErekwiLCJtYWMiOiIxNDVkZmZmYTU2Y2FhMDc5ZDAxNGNlODYyZjNhN2JkMDlkNTVhZmExMzM3N2ZmZmQ4MjM5NDhmNWVkN2Q3NTg5In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 11:25:42', '2026-10-10 11:25:42'),
(54, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/category/straight-cut-cargo-pants?categories=2%2C3%2C4%2C4', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/straight-cut-cargo-pants?categories=2%2C3%2C4%2C4\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6Ik8yeDlmZVZzQmp6Tm5zS0l0NHFnZ1E9PSIsInZhbHVlIjoiL1dzM3NIMVk1cjR0RTRyeHVUZ0c2TnJOMk9OaU05WkZVRUUzNysvVHBtbDRCZVRabThVcy85aWRoRE5oNHhodjFSelNyOVdQdjBuZzROOEhERTBuMFBvY3FKeDl3cnAxL0RCWHh2WjNHaVM4L2VSbGRsNDNMTjVhWU5kSEw3U3YiLCJtYWMiOiI0YjE3NmNiODQ3ZTAwZTZlMzBhYWQzN2E4MDBhYmYwZjEyNDdkOWYzOTg4ODFkMzBkODMzMTIyOTZlZWY3ZThhIn0%3D; styluxebd_session=eyJpdiI6IjVKQWRLUHBaZ3RmdHhOaE9tZjNycmc9PSIsInZhbHVlIjoiVnh6dVFncjFEeVJLTDZIWGkyamRFSmltUjJSbnA3VTJjRWxtVEpNalY4ck42YUdlVVJjZmw2am5CRjROU3ljVDNZTW9yTDR2SExTN0xsU2xqR1FwMW84QzVWdXVrZVMyRENsQWtJc0U0elN5WEU1MklzTkNrSFpWNmtuQTM5TGgiLCJtYWMiOiJlNzY0OTY4MDY0YzAwMjBlMjg3NjQzZmJjMjFiNmZkYzI5MzBlNDVmOTkwN2EwMjY5ZTJiMWY2ZDI2NGZiNWYyIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 12:33:17', '2026-10-10 12:33:17'),
(55, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product', 'http://localhost/styluxebd.xyz/public/category/ice-silk-pant', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/ice-silk-pant\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; device_id=eyJpdiI6Ii8xZXI5dnBhbktWY3J4M2YyVEJTSkE9PSIsInZhbHVlIjoiUVBWajBpcG0vSlI3QVYreUNIUThUK0cwM3M5TEJlZWRrc2J2STd1UWRibExra3F5M1p1UFIxdE1tT1hKVFA3SjNudTE0Rkw0anhKMGc5QkdUTExXOWc9PSIsIm1hYyI6ImVkNjA0MTNkMjA5YmNkOTEwYmJiMTMwMWI4ODc3OTg4NjQ2NzI2NWFhYTdhNTlkODhlMmZiMDcxYmUxYTE4YTAifQ%3D%3D; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; banijjo24com_session=eyJpdiI6IjNuTDQ5TDRVT1V6T2hLQnRHS1BIYUE9PSIsInZhbHVlIjoiVkk2WVk4YkpaS1R2bmQ4Q0xQN1Bvenl2emtMc0w1aHArQ0hlR2NuSU1JL3hZWDA5KytnaXJnR2FBaWo4OTJCZlNnYS8vcjF1bG0yYWcydXprNWNnM3kvYU5aeHFtWTc2Z090TEdqT2RpRWJGbVFxeFdUajJ5YXhKVHl1QWZkZDEiLCJtYWMiOiI0ZjhkNmFkNDY5ZjVjMmY4ZmYyNDQwNDE4ZGI2OTVhYTRkOTI4NGE4OTJkNTAyZjgwYjEzNjBkNDk4MjU4YmVhIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; XSRF-TOKEN=eyJpdiI6IktYZFRUWEkvYzJXVGU1aUZRamZhUnc9PSIsInZhbHVlIjoieXZQOFl1bVRXWXZQY2JIcnF6T0t1T1hKZXJaNUo0cFNsZVJwWG1EMTdXeHRTQ1lXT2hPUmowKzB5MlcwUitielJtaXovaXBJUnJrTzIxRWNvSjltbXR0TGVOQzZCaWxVUk5mTzhRSHdaMThjZlI4THVmcjZmV2tMcDBWckYxNHAiLCJtYWMiOiI3ODY5ZTQ3MTk2NDg2NmI4ODhiZTVkMjkyN2QxZTZhOGZjMDkzMjhiYmE0NGVjNWY4ZDZlOTk4MTU1Mzg0OGRiIn0%3D; styluxebd_session=eyJpdiI6IkkxSEovNWJBdjFwY0JvdG9DZkRJN0E9PSIsInZhbHVlIjoiYUtvQ1NDMElBclFhcldReDY2a0djQUFTMTJFNGFSY3Fxazd1dUJYSGNYVWswQVE2S2ZVSXhhc3NadUY3ZkJOajlnMndiWllpRWVTZHRuOE1yNmxRdUtKSko0NHZ5VUhRUXBaVjdOVk1MQzNWamxBZlB1ZytWVXNEazEzQ0hSRW4iLCJtYWMiOiI2YWNmMDFmZDc1MWNmZmY4OTgzOTE4NWRmOTU5YTc4ZDgxMDE1OTU1NGYyM2FhZmIxYTY0MGIwNzAzMWY1ZjUyIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-10 12:33:25', '2026-10-10 12:33:25'),
(56, 'GET', '[]', 'http://localhost/styluxebd.xyz/public/product/combo-product', 'http://localhost/styluxebd.xyz/public/category/ice-silk-pant', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/category\\/ice-silk-pant\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; device_id=eyJpdiI6Ik1GNmZER2UzSlpYYldMVm1GVzMyL3c9PSIsInZhbHVlIjoic1FOUW02b3NZbGdwb2pXcUdwL29Xb0lyNTJQNys3eWFvcnp2aWpvTDRnVlRwMXcwRXNRZHlzYk5IWnl4cjRPanJEUTdZcmlkQTVzTXB0elAyaG01cXc9PSIsIm1hYyI6IjZhNzQzNzQ4ZTZlNjFlYzlkNmQ2MmQxNjY2MTkzY2M5MTI2ZDI3NDQwYTFkMTBhNWExYWZkODc0MWEyYzI4MDgifQ%3D%3D; nest_cart_bd_session=eyJpdiI6Imo0U1h4VzB1bmdkNkhYei9rRk9waUE9PSIsInZhbHVlIjoiQi9raGFkZ1lhdUxNbkIvejNIYml2TkFUckpXbEhqQjVPOFRmOEZITHZld252VHRSeTBSY3lmV3pWQ2lCVDhhQndyaXFpSGtGcGdpVVQ5TnRkWVBDQjgxdnRrTnA5VmVSNGJrRW9hVkw5MkVMRnBrVEdYdE5sNG5lSUgyUlZsQWgiLCJtYWMiOiJjZDllMzM5ODdlMzAyZTUwMGUxYzIyZGFmZjhlNzhlOWIwY2M3Mjc1MjgwYmIzOTQzNDJlODRkMzk3YTdmNzQxIn0%3D; banijjo24com_session=eyJpdiI6Im9pTFRFT1owU3VMSWdsK0xXaXhZS3c9PSIsInZhbHVlIjoiZnFObEFEY1NLYjQxblE1dnNZWkcyUU5XV2Z1LzZCYXN1MkcxSjFHVTZHa1FOdFBaSnNsUDVQekNpaWVTRzZxN2FlZFVURE5tcTZEOVpRM1NGRUZWZ0FKSkZHeEFTNS9yMVBjcmJEekVRbkEvY2lNbUdFNFB5eTJHOVFqelZLRlYiLCJtYWMiOiIwNDRjZGVhN2IyODZmZDFjMWI0NDUxNWEyYWVlMGJjMjUyMGVhOWU5MzFmNTU2MmEwN2ZmNmU5OTQ3MjE5ZDI4In0%3D; XSRF-TOKEN=eyJpdiI6IllJVmFRTEJvYkxIT25SZkFqaytEeXc9PSIsInZhbHVlIjoiMCtoanp4T3dibk1WUVZpeVFRYk9Dc1orYmZLcWUrcmRNQXFNZUFoVTJTQXVXdkpDdEN1aC9OMk1BemxKTXJJYjI1c2prU1g0aHlkTnAvMlNrT1h2cHZGeWowK2RwSEoyc3dQZnpudmRJNkQ0aFRzK3l3RVY0aWQzMUFmd2cwR3QiLCJtYWMiOiI5ODExMTY5MDEwNTM2ZmJmNjM3ZmMyZmQwMGY2MDhlZmNiZTEyOWNkYzhlYTAwNGU4YzVhZDY4ZjllOTEyODZmIn0%3D; styluxebd_session=eyJpdiI6Iksyd0o0RmtnUlVXOWVkc2NpNjZSN0E9PSIsInZhbHVlIjoiMUxlTFFaV0d2YU1qR081ZUdVakMrT1BSR29Tcjk3cm1xTWd1SzErYjU5WW9Cbys1TG14OHJBN3VxTEFnV3B1WldqQzJ2MzFrVXRVUlMvYytHZWNGM05FTlNIUnQ1eGNBNmhBUEVjQlZDcHNiM0h4OEFRN1dURU1BcVhoTktMbEsiLCJtYWMiOiIxYTk2OWMyOGYwNzFhOTI5NmUzMjNmNjg0MWY3NDM4ZDVmMWUzODk2MzNjMzU2N2RkZmJlOWVjNTc3ZDA5YTk3In0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-12 03:37:56', '2026-10-12 03:37:56');
INSERT INTO `shetabit_visits` (`id`, `method`, `request`, `url`, `referer`, `languages`, `useragent`, `headers`, `device`, `platform`, `browser`, `ip`, `visitable_type`, `visitable_id`, `visitor_type`, `visitor_id`, `duration`, `created_at`, `updated_at`) VALUES
(57, 'GET', '[]', 'http://localhost/styluxebd.xyz/public', 'http://localhost/styluxebd.xyz/public/product/combo-product', '[\"en-us\",\"en\",\"bn\"]', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '{\"host\":[\"localhost\"],\"connection\":[\"keep-alive\"],\"upgrade-insecure-requests\":[\"1\"],\"user-agent\":[\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/154.0.0.0 Safari\\/537.36\"],\"accept\":[\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.7\"],\"sec-fetch-site\":[\"same-origin\"],\"sec-fetch-mode\":[\"navigate\"],\"sec-fetch-user\":[\"?1\"],\"sec-fetch-dest\":[\"document\"],\"sec-ch-ua\":[\"\\\"Chromium\\\";v=\\\"154\\\", \\\"Google Chrome\\\";v=\\\"154\\\", \\\"Not A(Brand\\\";v=\\\"99\\\"\"],\"sec-ch-ua-mobile\":[\"?0\"],\"sec-ch-ua-platform\":[\"\\\"Windows\\\"\"],\"referer\":[\"http:\\/\\/localhost\\/styluxebd.xyz\\/public\\/product\\/combo-product\"],\"accept-encoding\":[\"gzip, deflate, br, zstd\"],\"accept-language\":[\"en-US,en;q=0.9,bn;q=0.8\"],\"cookie\":[\"external_id=7a9cf1c7-7157-4c03-99f0-a516e83a6db1; _ga=GA1.1.740521714.1790247586; _clck=280wkc%5E2%5Eg9q%5E0%5E2458; _tt_enable_cookie=1; _ttp=01M39J46YZVGG5RTT05MY802C9_.tt.0.1790248623071; marketing_source=eyJpdiI6IjQ4VmlSTVZCQXd3K2l0R0haSzI3cHc9PSIsInZhbHVlIjoianJBWWZiKzJZc0dmellESkovQXhVVlp0MTlmK3o0Ri9wa1N3M3U3NnVmV3JUQ1F3U3Q2MnluOWJzSDBpSVJPNDg0NjRBM3RiK0tGaXBVeGJtUGdKN3c9PSIsIm1hYyI6ImRmNDdjNWRlMTljZTlmYTlkYTE2ODU2MmJjYTVmNWRmNjhiZGEwYjg5Zjg4YjU1MDY5NWI0NDEzNzNlOTI2ZDcifQ%3D%3D; _gcl_au=1.1.449346604.1790247586.-.-.1790248519.378778970.1790248519.1790253295; grow_organic_bd_session=eyJpdiI6InlxWUh2NkFPOEpiWWNYYmFYL0tpcFE9PSIsInZhbHVlIjoiV1BhSXNTOEdXRE5UWS9mUmg3YUpPTndXeHM1ZklLeVN6NWpYVm42ZUVPZjdCZjBCaS9URGE2Wm5aNi95emIxcjRsWDRxNWk5SXBFZVIzcEdyb0NOYmJMWStjaDFMUGloclkrN2FTaGhoR2ZBN2ZoVUVPS3JJbFdQNExIRHg4L0kiLCJtYWMiOiJkMDYwZGRiMDkzMTM5NGRlYjZiNDY2MmYzNDVhNzFmMzdlMWExZjhiZmZhYWViMzkwMTU2MTlhZmQyNjA1YmQxIn0%3D; _ga_99HH99HH99=GS2.1.s1790247586$o1$g1$t1790253517$j35$l0$h501500531; landing_page_session=eyJpdiI6Im5QRk92MkIzVlVDZDRYazNtbXhSNEE9PSIsInZhbHVlIjoiUE1DSDhXcW5qQmFDQlpjRzcxSTFyR0pnaHNaOFF5N0RBSklML0htRXhFUkVNRWxJQlRaRXQ2dUN4dUErZ3Btb0JiYmc5NG9hY2dCNjdodXFSMVlaYzRVUXV6OTc4NkV2M3ZiUUNvd3V0T2NwczNVV0ZmeG9CN1VERVpTTkpEVC8iLCJtYWMiOiIxMWQwNmQ2ZGQxMDM3MjNlNzk5YzkwMjA5YWJkZGFlMWMxOTkyMjk5NTk5OTNhOTYwYjgwNmU4Y2NhZmRhNTBhIn0%3D; marketing_landing_url=eyJpdiI6Im01QU1EMjZIbzhKMU1iT2M3ZllDZ0E9PSIsInZhbHVlIjoiQWlNU3hWWXhHUk5Ybm1yYmh1K3VDb3FZM3AxLzk2RnlOUWFNeUZyN2luOXFadjlCZDVJVE9hdm1ueVBkVjBXOUdFU1NRU3FvcXlXczA5ZzRodGtrYVpscnc0eUg3dGUrSmVvcitVLzlkY1Q0NFF0Rkc2N2JvbkxUMlRheEdsMFEiLCJtYWMiOiJlYmNiYzQyYTYzYTA0ZDc2ZGQyMWY0ZDJkNTVjN2IyMDIwZGMwOTdmNzc3NDcxYWMyZWIzMWVhZjQyNGFkNjM5IiwidGFnIjoiIn0%3D; marketing_referrer=eyJpdiI6IldubWVUK1ZFaXV2OEVJVEg3dDFwM1E9PSIsInZhbHVlIjoiQ2tQSFdvL0J2MUdiaHJMczJLNXNudTF3RHYzV0xWYWJOcnlGQnkvVmErdTJxZ3kvcU1mNFJlbDlLRVkwanRET3N5ejViVVMwRzliT1VWUDYzRlM5TWprbW5PMzJ3TCttNTlBMGpYMlpySklNVjJmS1JHWE1JZ1ZqRWRrSTAxU04iLCJtYWMiOiJhNDFhMWNmZDQ1YTAwY2JmMThlM2NjMjkwZDllYmVhMWQ2MTg0M2FjZGRlM2Y1MTc1NjgyYzIzZDdiYWI3ZWQ0IiwidGFnIjoiIn0%3D; unisale_mart_session=eyJpdiI6IlhqVUl1ZnptMC8zUWVsY1FYc3pJa1E9PSIsInZhbHVlIjoiZ3BTVnF6NXVFVW4zSWVYbXZDY3VVaDY1NmRIZmZsQkNicFpXQUJiUEFQbDROcnlWdFJGU09jMWFFYUxYVU9xQlJZZFBwUjc5dWNOV21MZHFVc1U3MEl1b2ErQUY1bmVVWGQ4dWNhUUxJeTl2UkhuTjRTb0RiellYbTdQeWNEczciLCJtYWMiOiIxMzUzMjJmODMyODY2YWVlMjE0YmVmZDhkNjIyYmZjZDk5NDMyZWY2Y2ZjNzQ1ZDExMTcxYWVmMDVlNDUyYTg0In0%3D; _fbp=fb.0.1790404230629.992120643325033748.AQYAAQMC; borno_shop_session=eyJpdiI6IlFvQUdZYWN1Y2FzQzd5amxpa29oeEE9PSIsInZhbHVlIjoiQlZDdFJkaFlGODNBcXVta3FrSWR0UVRaM0h6Z1AzanBZaG13VzExRjRtZVZqRHJLT2lGMjJpUEZ3ajBXdlpRRFBvcVFTQjZPYUx1Qk51ZWFDQ3MxVjBmaVhndWZqU2lPdHBqYktpNGgvYWNKV3RZRkF4Z2xIYkQ3US9EMzB1dS8iLCJtYWMiOiIxZDg3Y2Q0NGM0MmQxNmZiMTAxM2NlNDkzZjMzODU2NjRmMDQxNDU4NjcxNjRjNjZhYjBkYTg5ZGIzOGUzMWRlIn0%3D; _ga_SERVERGA40=GS2.1.s1791031282$o2$g0$t1791031282$j60$l0$h1368976585; tuki_takee_session=eyJpdiI6Im5SbE43QTkzLzN0VDNNdGlCdnNBVFE9PSIsInZhbHVlIjoiL0JwRisrS0dmc25qOGsvZUlnSlRHelVKK0NJa2hCbFowZG5PN3l5clJLY0tyNjA3cG14TjlpZFVaWDB5a1FzWllWUlAzUTFYT2syRFZ5djlFOHZyQTd1TEJHRkNMeEdZTytwTG5jdlBTQURQYTdTNkNQQ0c2QU91Y0NadlN3NlciLCJtYWMiOiI0NDNiODdhMjE0NTQ2MDg4ZWVmMDBhOWUwNjMyMDVmYzFmMDY4ODc4NmM5ZGNhNzA1ZDU0MWJjMWU3NDk2YTY3In0%3D; device_id=eyJpdiI6Ik1GNmZER2UzSlpYYldMVm1GVzMyL3c9PSIsInZhbHVlIjoic1FOUW02b3NZbGdwb2pXcUdwL29Xb0lyNTJQNys3eWFvcnp2aWpvTDRnVlRwMXcwRXNRZHlzYk5IWnl4cjRPanJEUTdZcmlkQTVzTXB0elAyaG01cXc9PSIsIm1hYyI6IjZhNzQzNzQ4ZTZlNjFlYzlkNmQ2MmQxNjY2MTkzY2M5MTI2ZDI3NDQwYTFkMTBhNWExYWZkODc0MWEyYzI4MDgifQ%3D%3D; nest_cart_bd_session=eyJpdiI6Imo0U1h4VzB1bmdkNkhYei9rRk9waUE9PSIsInZhbHVlIjoiQi9raGFkZ1lhdUxNbkIvejNIYml2TkFUckpXbEhqQjVPOFRmOEZITHZld252VHRSeTBSY3lmV3pWQ2lCVDhhQndyaXFpSGtGcGdpVVQ5TnRkWVBDQjgxdnRrTnA5VmVSNGJrRW9hVkw5MkVMRnBrVEdYdE5sNG5lSUgyUlZsQWgiLCJtYWMiOiJjZDllMzM5ODdlMzAyZTUwMGUxYzIyZGFmZjhlNzhlOWIwY2M3Mjc1MjgwYmIzOTQzNDJlODRkMzk3YTdmNzQxIn0%3D; banijjo24com_session=eyJpdiI6Im9pTFRFT1owU3VMSWdsK0xXaXhZS3c9PSIsInZhbHVlIjoiZnFObEFEY1NLYjQxblE1dnNZWkcyUU5XV2Z1LzZCYXN1MkcxSjFHVTZHa1FOdFBaSnNsUDVQekNpaWVTRzZxN2FlZFVURE5tcTZEOVpRM1NGRUZWZ0FKSkZHeEFTNS9yMVBjcmJEekVRbkEvY2lNbUdFNFB5eTJHOVFqelZLRlYiLCJtYWMiOiIwNDRjZGVhN2IyODZmZDFjMWI0NDUxNWEyYWVlMGJjMjUyMGVhOWU5MzFmNTU2MmEwN2ZmNmU5OTQ3MjE5ZDI4In0%3D; XSRF-TOKEN=eyJpdiI6IjdOUTZCWnpJbTlUaUNCQzhsZ1E0WUE9PSIsInZhbHVlIjoiaUx3Mm1KTTU1dUdOWU53MWU2blJVazZzaU5tbDdoVHhUV2hGQ1YyaEVYaDdhL1VuUnNpd2lUQUQ1TDgyUktEbUpYV1dRNkE5dnI0NndEVnBOaWNyRlRTdFRoZWhnbVEyZXRGVHdQeGwrcXhJSWE4TU4renEwbUkydEppNUtORXUiLCJtYWMiOiJmMWFhMGRkMzFhNmZjMjE1YTAwNWFiNmI5OTE5MjMwNTE1YTc3MzdkNjMzZThmY2Y1OTQ4Yzk5MWFiMDdmMzRjIn0%3D; styluxebd_session=eyJpdiI6IjJhY2JqWVhmNUxnV1ROUzhZckc4bVE9PSIsInZhbHVlIjoiSXIwVnFka1BuV05RM2NvaHczSU1uYWFOdm5WREdRU29CbUlnL09WWHVBSXdaYUJjUVc4Sk9BUU9nVWoyYk5XOGR2MGhQZG5BTGhhL0dOdll2ZDI1RDJ6YkpDL2J6Z2JSU2lRcjVhblhFUEJ5d21tTUVaMzV0Y3A1UU1Kbi9zNVMiLCJtYWMiOiIyYjYzOWVhNTJmZTgwNGM1NDA1YWViZTFjOTZhYjY4YzI5MTk3MGE2OWUzNGVmZDRhNDk4YjdkOTRiZjYyMmM0In0%3D; laravel_session=eyJpdiI6InY3bGRUS0J2N1lUblpoYlVOdkFKVkE9PSIsInZhbHVlIjoiT1dNelg2cGxqME9oOVBRaXVZS0RnRkwrQmRvdEZFalBFSHl6RUtIYzlHR1RlbFBMdmluZTB1aXRmdlV2eDYxeU8vMmhGT1RESjM3RVVBM25zc09uUC9nMkprUlBUVjIrTXhwK3VISnZNNmpKamE3Z00yNEdTalYvaUtNazBmZm0iLCJtYWMiOiJhZDk1ZWU0MmE5MDIwZDg4M2QxNjVkZmEyMGNhNGQzNTdmMDlmOTY3YTA0MzEwOWVjZWVkYmFiNGY5MDNiYjkwIn0%3D\"]}', 'WebKit', 'Windows', 'Chrome', '::1', NULL, NULL, NULL, NULL, NULL, '2026-10-12 03:37:58', '2026-10-12 03:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `type`, `text`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ঢাকার ভিতরে', 'ঢাকার ভিতরে ডেলিভারি', 80, 1, '2025-10-16 05:57:59', '2025-10-16 05:57:59'),
(2, 'ঢাকার বাইরে', 'ঢাকার বাইরে ডেলিভারি', 120, 1, '2025-10-16 05:58:16', '2025-10-16 05:58:16');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `slider_image` int(11) DEFAULT NULL,
  `slider_url` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=unpublished, 1=published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `theme_id`, `slider_image`, `slider_url`, `position`, `status`, `created_at`, `updated_at`) VALUES
(2, 8, 263, 'https://styluxebd.xyz/category/silk-pant', NULL, 1, '2026-08-08 19:46:51', '2026-08-10 11:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjustment_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_adjustments`
--

INSERT INTO `stock_adjustments` (`id`, `adjustment_date`, `reason`, `note`, `created_at`, `updated_at`) VALUES
(1, '2026-10-10', 'Damage', NULL, '2026-10-10 08:56:33', '2026-10-10 08:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_items`
--

CREATE TABLE `stock_adjustment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_adjustment_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `current_stock` int(11) NOT NULL,
  `adjusted_quantity` int(11) NOT NULL,
  `type` enum('addition','subtraction') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_adjustment_items`
--

INSERT INTO `stock_adjustment_items` (`id`, `stock_adjustment_id`, `product_id`, `sku`, `current_stock`, `adjusted_quantity`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'prod-001', 15, 5, 'addition', '2026-10-10 08:56:33', '2026-10-10 08:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `subscribes`
--

CREATE TABLE `subscribes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribes`
--

INSERT INTO `subscribes` (`id`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'madamtaisia@mail.ru', 0, '2026-09-10 03:55:56', '2026-09-10 03:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `balance` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `balance`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Genesis Fashion wear', 'frahman010@gmail.com', '01730288442', '52500.0000', 1, '2026-09-08 13:15:08', '2026-10-12 05:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_transactions`
--

CREATE TABLE `supplier_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('payment','purchase') NOT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `previous_balance` decimal(10,4) DEFAULT NULL,
  `new_balance` decimal(10,4) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_transactions`
--

INSERT INTO `supplier_transactions` (`id`, `supplier_id`, `type`, `amount`, `previous_balance`, `new_balance`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'purchase', '3500.0000', '49000.0000', '52500.0000', 'Purchase created with memo: MEMO-1', '2026-10-10 08:55:38', '2026-10-10 08:55:38'),
(2, 1, 'payment', '3500.0000', '52500.0000', '49000.0000', 'Paid for purchase memo: MEMO-1', '2026-10-10 08:57:18', '2026-10-10 08:57:18'),
(3, 1, 'purchase', '60000.0000', '49000.0000', '109000.0000', 'Purchase created with memo: MEMO-2', '2026-10-10 09:24:05', '2026-10-10 09:24:05'),
(4, 1, 'payment', '60000.0000', '109000.0000', '49000.0000', 'Paid for purchase memo: MEMO-2', '2026-10-10 09:26:28', '2026-10-10 09:26:28'),
(5, 1, 'purchase', '3500.0000', '49000.0000', '52500.0000', 'Purchase created with memo: MEMO-3', '2026-10-12 05:19:43', '2026-10-12 05:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` int(11) NOT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `path`, `image`, `is_active`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SVE1.1', 'theme-1', 'uploads/1762330719.png', 0, 1, '2025-11-05 08:18:39', '2026-05-08 05:11:46'),
(2, 'Corporate Sign BD', 'theme-2', 'uploads/1762330812.png', 0, 1, '2025-11-05 08:20:12', '2026-05-08 05:11:46'),
(8, 'Isra', 'theme-3', NULL, 1, 1, '2025-11-30 11:27:20', '2026-05-08 05:11:46'),
(9, 'Voyagetm', 'theme-4', 'uploads/1765343036.png', 0, 1, '2025-12-09 23:03:56', '2026-05-08 05:11:46'),
(10, 'Unisale Mart', 'theme-5', 'uploads/1766574880.png', 0, 1, '2025-12-24 11:14:40', '2026-05-08 05:11:46'),
(11, 'Bikroy Bazar', 'theme-6', 'uploads/1767273962.png', 0, 1, '2026-01-01 07:26:02', '2026-05-08 05:11:46'),
(12, 'Organic Theme', 'theme-8', 'uploads/1767273962.png', 0, 1, '2026-01-01 07:26:02', '2026-05-08 05:11:46'),
(13, 'Sokhfn', 'theme-7', NULL, 0, 1, '2026-01-08 07:05:31', '2026-05-08 05:11:46'),
(14, 'Nutellin', 'theme-9', NULL, 0, 1, '2026-01-08 07:05:51', '2026-05-08 05:11:46'),
(15, 'Mercy Glocery', 'theme-10', 'uploads/1769105070.png', 0, 1, '2026-01-22 12:04:30', '2026-05-08 05:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `theme_extra_fields`
--

CREATE TABLE `theme_extra_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `theme_path` varchar(255) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_label` varchar(255) DEFAULT NULL,
  `field_type` varchar(255) NOT NULL DEFAULT 'text',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Md Rumon Hossain', NULL, '01750159011', 'Dhaka Bangladesh', NULL, '$2y$10$OxmF02e3BAX8XaE7iX51k.SmHdlUQ3TKM/z55pD/CKPvphXlJEsE6', 1, NULL, '2026-08-19 07:22:31', '2026-08-19 07:22:31'),
(5, 'md tosar', NULL, '01627189029', 'সানার পার সোনা মিয়া মার্কেট ডেমরা ঢাকা', NULL, '$2y$10$8ae9HdAhVMWBXGcYbbHip.7hEhKQx5GylAqarjLiqE160w1/8yyY.', 1, NULL, '2026-08-19 17:38:15', '2026-08-19 17:38:15'),
(6, 'Shahriar Ahmed', NULL, '01730453321', 'Akkelpur Railway Station, Akkelpur, Joypurhat', NULL, '$2y$10$RDXrpsqA1y2DEh4RD5mXpOREEIXmxN7KLgfNo0R4LWV/YmUkCCjiy', 1, NULL, '2026-08-22 12:02:39', '2026-08-22 12:02:39'),
(7, 'Moshikur Rahman', NULL, '01712879358', 'Ka120/1/b, Kazi bari masjid road, panir pump, kuril, Dhaka 1229', NULL, '$2y$10$4/bNryP/sXzD18IrBmNmeeiWWR8TNxPCiwnl24fOSndvE5v2MKhjK', 1, NULL, '2026-08-22 15:06:12', '2026-08-22 15:06:12'),
(8, 'Faysal Ahamed', NULL, '01689526998', 'Aziron Feed mill, Soling more, Mawna , Sreepur, Gazipur', NULL, '$2y$10$2g9KgETMJ6eh9u3OQ2LPWOErATCpaSx91zf7ylfV9PR5LLn46omrW', 1, NULL, '2026-08-24 11:17:38', '2026-08-24 11:17:38'),
(9, 'Ripon Suter', NULL, '01627417075', 'nesarabad pirojpur', NULL, '$2y$10$rVSuqmxiU4wtSeemL8uXCeZ.7L/v03PP3QOZDd/kqXxFVNqfpT/GW', 1, NULL, '2026-08-24 12:14:02', '2026-08-24 12:14:02'),
(10, 'Nahid Hossain sazib', NULL, '01322352773', 'Boribari mokos bilL Kaliakoir Gazipur', NULL, '$2y$10$yGxfG5kuvDabg2ZlQfvz2e37H4Ke6UpgQPrUzy6gW834b9PLGz.t.', 1, NULL, '2026-08-24 17:12:20', '2026-08-24 17:12:20'),
(11, 'Arnab Test Order', NULL, '01747706183', 'Culture Housing Society', NULL, '$2y$10$tDAgDpFBNovsJ8bRDc50E.xh5YovbYe3GHFi3M/FC1BQPg6v1IQSy', 1, NULL, '2026-09-01 05:21:32', '2026-09-01 05:21:32'),
(15, 'Motiur Rahman', NULL, '01909302126', 'Mirpur 10, Dhaka, Bangladesh', NULL, '$2y$10$uqtNUoetYRHMWNS7DKTKauKkSoeG3lHBKgcepJDi3pl/Pzdhu27uK', 1, NULL, '2026-09-05 11:53:00', '2026-09-05 11:53:00'),
(17, 'Test Customer', NULL, '01767891011', 'Test Address', NULL, '$2y$10$X1uMpkMMJzvZUeA6IgQckOFHYOskbXmODzUx3.F55DOCFFc5QWo.a', 1, NULL, '2026-09-26 06:30:18', '2026-09-26 06:30:18'),
(18, 'Test Developer', NULL, '01700000000', 'Mirpur-10, Dhaka.', NULL, '$2y$10$DYq0MSY8hy47uJKHydALy.wMTPJkqhLHz/wATRiEn27ZEkkMT/Vnq', 1, NULL, '2026-10-01 05:42:30', '2026-10-01 05:42:30'),
(19, 'Rabbil', NULL, '01846760532', 'Mirpur 10, Dhaka - 1216, Bangladesh.', NULL, '$2y$10$p7DUwe1knaQBNeSOALto3uaZZkj1OMoRgvtPPBfNUvv20XqalZnmi', 1, NULL, '2026-10-07 03:26:51', '2026-10-07 03:26:51'),
(20, 'Sabbir Mia', NULL, '01846760588', 'Kagatua, Muradnagar, Cumilla.', NULL, '$2y$10$b/.rQjArgPmOLq8BM1tji.ihesXSp3T.EQsxKgJSUtjXNYdG/48LG', 1, NULL, '2026-10-07 06:29:38', '2026-10-07 06:29:38'),
(21, 'Humayon Kabir', NULL, '01846760555', 'Mirpur-10, Dhaka.', NULL, '$2y$10$cT1hYQI0kGPG2kW6sXK8aOOjLzghpdZ6NQAoo2J4EdsChAdCOG/Mi', 1, NULL, '2026-10-07 06:39:51', '2026-10-07 06:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_address` varchar(255) DEFAULT NULL,
  `website_phone` varchar(255) DEFAULT NULL,
  `website_phone2` varchar(255) DEFAULT NULL,
  `website_phone3` varchar(255) DEFAULT NULL,
  `website_email` varchar(255) DEFAULT NULL,
  `website_email2` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `messenger_url` text DEFAULT NULL,
  `website_facebook` varchar(255) DEFAULT NULL,
  `website_twitter` varchar(255) DEFAULT NULL,
  `website_youtube` varchar(255) DEFAULT NULL,
  `website_instagram` varchar(255) DEFAULT NULL,
  `website_header_logo` int(11) DEFAULT NULL,
  `website_footer_logo` varchar(255) DEFAULT NULL,
  `website_favicon` int(11) DEFAULT NULL,
  `website_copyright_text` text DEFAULT NULL,
  `currency_sign` varchar(255) DEFAULT NULL,
  `bkash_merchant_numb` varchar(255) DEFAULT NULL,
  `fb_pixel` text DEFAULT NULL,
  `stock_management` tinyint(4) DEFAULT NULL COMMENT '1= active, 0= inactive',
  `stock_alert` int(11) DEFAULT NULL,
  `guest_review` tinyint(4) DEFAULT NULL,
  `invoice_prefix` varchar(20) DEFAULT NULL,
  `is_demo` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `website_address`, `website_phone`, `website_phone2`, `website_phone3`, `website_email`, `website_email2`, `whatsapp_number`, `messenger_url`, `website_facebook`, `website_twitter`, `website_youtube`, `website_instagram`, `website_header_logo`, `website_footer_logo`, `website_favicon`, `website_copyright_text`, `currency_sign`, `bkash_merchant_numb`, `fb_pixel`, `stock_management`, `stock_alert`, `guest_review`, `invoice_prefix`, `is_demo`, `created_at`, `updated_at`) VALUES
(1, NULL, '+8801606288442', NULL, NULL, NULL, NULL, '+8801606288442', 'https://m.me/styluxebd890', 'https://www.facebook.com/styluxebd890', NULL, NULL, NULL, 264, '265', 266, '<i class=\"fa fa-copyright\" aria-hidden=\"true\"></i> 2026 <a class=\"text-info\" href=\"https://styluxebd.xyz\" target=\"_blank\">Styluxe BD</a> All Right Reserved.', 'Tk', NULL, '<!-- Google Tag Manager -->\r\n<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':\r\nnew Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],\r\nj=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=\r\n\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);\r\n})(window,document,\'script\',\'dataLayer\',\'GTM-NXSW9J5H\');</script>\r\n<!-- End Google Tag Manager -->', 1, NULL, 1, 'SB', 0, '2025-09-27 10:43:34', '2026-10-01 06:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `attributes` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abandoned_carts`
--
ALTER TABLE `abandoned_carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_transactoins_account_id_foreign` (`account_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_phone_unique` (`phone`);

--
-- Indexes for table `api_couriers`
--
ALTER TABLE `api_couriers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_couriers_courier_name_unique` (`courier_name`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_items`
--
ALTER TABLE `attribute_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_banner_section_id_foreign` (`banner_section_id`);

--
-- Indexes for table `banner_sections`
--
ALTER TABLE `banner_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banner_sections_theme_id_foreign` (`theme_id`);

--
-- Indexes for table `carrybee_cities`
--
ALTER TABLE `carrybee_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carrybee_zones`
--
ALTER TABLE `carrybee_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_products`
--
ALTER TABLE `category_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_products`
--
ALTER TABLE `combo_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversion_apis`
--
ALTER TABLE `conversion_apis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `coupon_users`
--
ALTER TABLE `coupon_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_cities`
--
ALTER TABLE `courier_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_zones`
--
ALTER TABLE `courier_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tracks`
--
ALTER TABLE `device_tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_tracks_device_id_unique` (`device_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD UNIQUE KEY `employees_phone_unique` (`phone`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_category_id_foreign` (`category_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deals`
--
ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_page_settings`
--
ALTER TABLE `home_page_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_categories`
--
ALTER TABLE `landing_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_page_theme` (`theme_id`);

--
-- Indexes for table `landing_themes`
--
ALTER TABLE `landing_themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_theme_category` (`category_id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `managers_email_unique` (`email`),
  ADD UNIQUE KEY `managers_phone_unique` (`phone`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_id_unique` (`invoice_id`),
  ADD KEY `idx_orders_theme_status` (`theme_id`,`status`),
  ADD KEY `idx_orders_customer_phone` (`customer_phone`),
  ADD KEY `idx_orders_invoice_id` (`invoice_id`),
  ADD KEY `idx_orders_courier_id` (`courier_id`),
  ADD KEY `idx_orders_source` (`source`),
  ADD KEY `idx_orders_created_at` (`created_at`);

--
-- Indexes for table `order_activities`
--
ALTER TABLE `order_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_activities_causer_type_causer_id_index` (`causer_type`,`causer_id`),
  ADD KEY `order_activities_order_id_created_at_index` (`order_id`,`created_at`);

--
-- Indexes for table `order_assigns`
--
ALTER TABLE `order_assigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_combo_items`
--
ALTER TABLE `order_combo_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_notes_order_id_foreign` (`order_id`),
  ADD KEY `order_notes_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_op_order_id` (`order_id`),
  ADD KEY `idx_op_product_id` (`product_id`);

--
-- Indexes for table `page_settings`
--
ALTER TABLE `page_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pathao_cities`
--
ALTER TABLE `pathao_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pathao_zones`
--
ALTER TABLE `pathao_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `print_settings`
--
ALTER TABLE `print_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variant_items`
--
ALTER TABLE `product_variant_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotional_banners`
--
ALTER TABLE `promotional_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `redx_areas`
--
ALTER TABLE `redx_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
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
-- Indexes for table `shetabit_visits`
--
ALTER TABLE `shetabit_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shetabit_visits_visitable_type_visitable_id_index` (`visitable_type`,`visitable_id`),
  ADD KEY `shetabit_visits_visitor_type_visitor_id_index` (`visitor_type`,`visitor_id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_adjustment_items`
--
ALTER TABLE `stock_adjustment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_adjustment_items_stock_adjustment_id_index` (`stock_adjustment_id`),
  ADD KEY `stock_adjustment_items_product_id_index` (`product_id`);

--
-- Indexes for table `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribes_email_unique` (`email`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_transactions`
--
ALTER TABLE `supplier_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_transactions_supplier_id_index` (`supplier_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_extra_fields`
--
ALTER TABLE `theme_extra_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `web_settings`
--
ALTER TABLE `web_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abandoned_carts`
--
ALTER TABLE `abandoned_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `api_couriers`
--
ALTER TABLE `api_couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attribute_items`
--
ALTER TABLE `attribute_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner_sections`
--
ALTER TABLE `banner_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carrybee_cities`
--
ALTER TABLE `carrybee_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carrybee_zones`
--
ALTER TABLE `carrybee_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category_products`
--
ALTER TABLE `category_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `combo_products`
--
ALTER TABLE `combo_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conversion_apis`
--
ALTER TABLE `conversion_apis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_users`
--
ALTER TABLE `coupon_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courier_cities`
--
ALTER TABLE `courier_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courier_zones`
--
ALTER TABLE `courier_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tracks`
--
ALTER TABLE `device_tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_deals`
--
ALTER TABLE `flash_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_page_settings`
--
ALTER TABLE `home_page_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `landing_categories`
--
ALTER TABLE `landing_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_themes`
--
ALTER TABLE `landing_themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_activities`
--
ALTER TABLE `order_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_assigns`
--
ALTER TABLE `order_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_combo_items`
--
ALTER TABLE `order_combo_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_notes`
--
ALTER TABLE `order_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `page_settings`
--
ALTER TABLE `page_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pathao_cities`
--
ALTER TABLE `pathao_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `pathao_zones`
--
ALTER TABLE `pathao_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1107;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `print_settings`
--
ALTER TABLE `print_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_variant_items`
--
ALTER TABLE `product_variant_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotional_banners`
--
ALTER TABLE `promotional_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `redx_areas`
--
ALTER TABLE `redx_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shetabit_visits`
--
ALTER TABLE `shetabit_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_adjustment_items`
--
ALTER TABLE `stock_adjustment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_transactions`
--
ALTER TABLE `supplier_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `theme_extra_fields`
--
ALTER TABLE `theme_extra_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `web_settings`
--
ALTER TABLE `web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD CONSTRAINT `account_transactoins_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_banner_section_id_foreign` FOREIGN KEY (`banner_section_id`) REFERENCES `banner_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banner_sections`
--
ALTER TABLE `banner_sections`
  ADD CONSTRAINT `banner_sections_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD CONSTRAINT `fk_page_theme` FOREIGN KEY (`theme_id`) REFERENCES `landing_themes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `landing_themes`
--
ALTER TABLE `landing_themes`
  ADD CONSTRAINT `fk_theme_category` FOREIGN KEY (`category_id`) REFERENCES `landing_categories` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `order_activities`
--
ALTER TABLE `order_activities`
  ADD CONSTRAINT `order_activities_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD CONSTRAINT `order_notes_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_adjustment_items`
--
ALTER TABLE `stock_adjustment_items`
  ADD CONSTRAINT `stock_adjustment_items_stock_adjustment_id_foreign` FOREIGN KEY (`stock_adjustment_id`) REFERENCES `stock_adjustments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
