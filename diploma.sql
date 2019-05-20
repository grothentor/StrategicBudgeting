-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 20, 2019 at 09:05 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diploma`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('current','variant') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'variant',
  `subdivision_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `name`, `type`, `subdivision_id`, `created_at`, `updated_at`) VALUES
(5, 'Текущий бюджет', 'current', 3, '2019-05-14 07:34:43', '2019-05-14 07:34:43'),
(6, 'Текущий бюджет', 'current', 4, '2019-05-14 07:34:56', '2019-05-14 07:34:56'),
(7, 'Текущий бюджет', 'current', 5, '2019-05-14 07:35:06', '2019-05-14 07:35:06'),
(8, 'Текущий бюджет', 'current', 6, '2019-05-14 07:35:20', '2019-05-14 07:35:20'),
(9, 'Магазини', 'variant', 3, '2019-05-14 07:42:58', '2019-05-20 11:28:11'),
(10, 'Спеціалізовані магазини', 'variant', 3, '2019-05-14 07:47:51', '2019-05-20 11:28:31'),
(13, 'Cупермаркети', 'variant', 4, '2019-05-14 13:09:26', '2019-05-20 11:31:04'),
(14, 'Магазинчики (ларьки)', 'variant', 4, '2019-05-14 13:13:15', '2019-05-20 11:31:25'),
(15, 'VIP ресторани', 'variant', 5, '2019-05-14 22:52:22', '2019-05-20 11:31:40'),
(16, 'Їдальні', 'variant', 5, '2019-05-14 22:54:12', '2019-05-20 11:31:53'),
(17, 'Закордонні магазини', 'variant', 6, '2019-05-14 22:55:00', '2019-05-20 11:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `budget_indicators`
--

CREATE TABLE `budget_indicators` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('income','expense','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budget_indicators`
--

INSERT INTO `budget_indicators` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(4, 'Прибуток від реалізації', 'income', '2019-05-14 07:43:55', '2019-05-20 12:30:20'),
(5, 'Витрати на управління', 'expense', '2019-05-14 07:44:19', '2019-05-20 12:30:32'),
(6, 'Собівартість товарів', 'expense', '2019-05-14 08:22:04', '2019-05-20 12:30:44'),
(7, 'Витрати на рекламу', 'expense', '2019-05-14 08:22:40', '2019-05-20 12:30:56'),
(8, 'Витрати через брак', 'expense', '2019-05-14 08:23:01', '2019-05-20 12:31:09'),
(9, 'Операційний прибуток', 'income', '2019-05-14 21:28:17', '2019-05-20 12:31:22'),
(10, 'Фінансовий прибуток', 'income', '2019-05-14 21:28:36', '2019-05-20 12:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `budget_values`
--

CREATE TABLE `budget_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(12,2) DEFAULT NULL,
  `singular_value` double(8,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `budget_id` int(10) UNSIGNED NOT NULL,
  `budget_indicator_id` int(10) UNSIGNED NOT NULL,
  `periodicity` enum('once','monthly','quarterly','annually') COLLATE utf8mb4_unicode_ci NOT NULL,
  `offset` int(10) UNSIGNED NOT NULL,
  `use_length` int(11) DEFAULT NULL,
  `pay_at_end` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budget_values`
--

INSERT INTO `budget_values` (`id`, `comment`, `value`, `singular_value`, `count`, `budget_id`, `budget_indicator_id`, `periodicity`, `offset`, `use_length`, `pay_at_end`, `created_at`, `updated_at`) VALUES
(11, 'Продукт 1', NULL, 4970.00, 11270, 5, 4, 'quarterly', 0, NULL, 0, '2019-05-14 07:54:26', '2019-05-14 07:54:26'),
(12, 'Продукт 2', NULL, 5010.00, 2640, 5, 4, 'quarterly', 0, NULL, 0, '2019-05-14 07:54:26', '2019-05-16 08:53:34'),
(13, 'Продукт 3', NULL, 5120.00, 9700, 5, 4, 'quarterly', 0, NULL, 0, '2019-05-14 07:54:26', '2019-05-14 07:54:26'),
(14, 'Продукт 4', NULL, 4990.00, 9340, 5, 4, 'quarterly', 0, NULL, 0, '2019-05-14 07:54:26', '2019-05-14 07:54:26'),
(15, 'Продукт 5', NULL, 5150.00, 3790, 5, 4, 'quarterly', 0, NULL, 0, '2019-05-14 07:54:26', '2019-05-16 08:53:34'),
(16, 'ЗП', 2500000.00, NULL, NULL, 5, 6, 'monthly', 0, NULL, 0, '2019-05-14 07:54:26', '2019-05-14 21:29:17'),
(17, 'Брак', 254100.00, NULL, NULL, 5, 8, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(18, 'Електроенергия', 3170000.00, NULL, NULL, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 21:29:17'),
(19, 'Ремонт', 5200000.00, NULL, NULL, 5, 5, 'annually', 0, NULL, 1, '2019-05-14 08:35:54', '2019-05-14 08:38:16'),
(20, 'Безопасность', 408000.00, NULL, NULL, 5, 5, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(21, 'Паросиловой цех', 938100.00, NULL, NULL, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(22, 'Ячмень', NULL, 4.62, 30000, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(23, 'Солод', NULL, 8.12, 22500, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(24, 'Хмель', NULL, 2.01, 12400, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(25, 'Сахар', NULL, 12.80, 318000, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(26, 'Сода', NULL, 1.72, 1500, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(27, 'Молочная кислота', NULL, 51.40, 15000, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(28, 'Целюкласт', NULL, 2292.00, 120, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(29, 'Фенизим', NULL, 560.00, 510, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(30, 'Метурекс', NULL, 3876.50, 1000, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(31, 'Бекосорб', NULL, 112.00, 7500, 5, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(32, 'Етикетки', 3063500.00, NULL, NULL, 5, 7, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(33, 'Строй материалы', 207000.00, NULL, NULL, 5, 5, 'annually', 0, NULL, 1, '2019-05-14 08:35:54', '2019-05-14 08:38:17'),
(34, 'Канцтовары', 12000.00, NULL, NULL, 5, 5, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 08:35:54'),
(35, 'Основные средства', 13754000.00, NULL, NULL, 5, 9, 'quarterly', 0, NULL, 0, '2019-05-14 08:35:54', '2019-05-14 23:00:41'),
(36, 'Продукт 6', NULL, 5350.00, 3800, 6, 4, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(37, 'Продукт 7', NULL, 5450.00, 2570, 6, 4, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(38, 'Продукт 8', NULL, 5420.00, 1280, 6, 4, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(39, 'Продукт 9', NULL, 5950.00, 3200, 6, 4, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(40, 'Продукт 10', NULL, 5840.00, 1800, 6, 4, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(41, 'Продукт 11', NULL, 5640.00, 14000, 6, 4, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(42, 'ЗП', 2150000.00, NULL, NULL, 6, 5, 'monthly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(43, 'Безопасность', 503000.00, NULL, NULL, 6, 5, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(44, 'Електроенергия', 4230000.00, NULL, NULL, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(45, 'Ремонт', 4200000.00, NULL, NULL, 6, 5, 'quarterly', 0, NULL, 1, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(46, 'Затраты на брак', 441100.00, NULL, NULL, 6, 8, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(47, 'Холодильно-компресний цех', 637500.00, NULL, NULL, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(48, 'Основные средства', 4568000.00, NULL, NULL, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(49, 'Ячмень', NULL, 4.62, 30000, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(50, 'Солод', NULL, 8.12, 22500, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 12:55:05'),
(51, 'Сахар', NULL, 12.80, 31800, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 12:55:05'),
(52, 'Хмель', NULL, 0.20, 12400, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(53, 'Сода', NULL, 1.72, 750, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 12:55:05'),
(54, 'Молочная кислота', NULL, 51.04, 15000, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(55, 'Фенизим', NULL, 560.00, 510, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(56, 'Тернадив', NULL, 275.45, 1350, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(57, 'Метурекс', NULL, 3876.50, 950, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(58, 'Поликар', NULL, 700.00, 6300, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(59, 'Щелочь', NULL, 77.12, 900, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(60, 'Гипохлоран', NULL, 48.00, 3000, 6, 6, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(61, 'Етикетки', 3063500.00, NULL, NULL, 6, 7, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(62, 'Стройматериалы', 910000.00, NULL, NULL, 6, 5, 'annually', 0, NULL, 1, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(63, 'Канцтовары', 206000.00, NULL, NULL, 6, 5, 'quarterly', 0, NULL, 0, '2019-05-14 08:53:44', '2019-05-14 08:53:44'),
(64, 'Магазин 1', 4752000.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-16 08:56:06'),
(65, 'Магазин 2', 5701000.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-16 08:56:06'),
(66, 'Магазин 3', 5544000.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-16 08:56:06'),
(67, 'Продажа тары', 1053600.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(68, 'Продажа отходов', 140700.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(69, 'Аренда тары', 2080000.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(70, 'Другие доходы', 5410000.00, NULL, NULL, 7, 9, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(71, 'Депозитный сертификат', 18070000.00, NULL, NULL, 7, 9, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(72, 'Вексили', 10500000.00, NULL, NULL, 7, 10, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(73, 'ЗП', 750000.00, NULL, NULL, 7, 6, 'monthly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(74, 'Магазин 4', 3284000.00, NULL, NULL, 7, 4, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(75, 'Профсоюзы', 225000.00, NULL, NULL, 7, 5, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(76, 'Кредиты', 4500000.00, NULL, NULL, 7, 10, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(77, 'Гос. целевые фонды', 8010000.00, NULL, NULL, 7, 10, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(78, 'Сельхоз договоры', 616800.00, NULL, NULL, 7, 9, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 21:31:11'),
(79, 'Реклама', 47628000.00, NULL, NULL, 7, 7, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(80, 'Розмещение реклами', 12864300.00, NULL, NULL, 7, 7, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(81, 'Транспортные затраты', 5737400.00, NULL, NULL, 7, 5, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(82, 'Другие', 1360300.00, NULL, NULL, 7, 6, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(83, 'Активы', 963000.00, NULL, NULL, 7, 5, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(84, 'Безопасность', 139300.00, NULL, NULL, 7, 5, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(85, 'Информатизация', 1369000.00, NULL, NULL, 7, 5, 'quarterly', 0, NULL, 0, '2019-05-14 09:06:30', '2019-05-14 09:06:30'),
(86, 'Ремонт', 750000.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-16 08:55:10'),
(87, 'Затрати в лаборатории', 605400.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-14 12:24:44'),
(88, 'Контрольные примеры', 373500.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-14 12:24:44'),
(89, 'ЗП', 200000.00, NULL, NULL, 8, 5, 'monthly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-16 08:55:10'),
(90, 'Внутришний аудит', 373500.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-14 12:24:44'),
(91, 'Отдел Кадров', 380700.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-14 12:24:44'),
(92, 'Безопасность', 123000.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-14 12:24:44'),
(93, 'Здравпункт', 68700.00, NULL, NULL, 8, 5, 'quarterly', 0, NULL, 0, '2019-05-14 12:24:44', '2019-05-14 12:24:44'),
(94, 'Продукт 12', NULL, 643.00, 2008, 9, 4, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-16 08:54:36'),
(95, 'Ячмень', NULL, 4.62, 30000, 9, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(96, 'Солод', NULL, 8.12, 22500, 9, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(97, 'Хмель', NULL, 0.20, 1240, 9, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(98, 'Сахар', NULL, 12.80, 3180, 9, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(99, 'Продукт 13', NULL, 653.00, 3008, 9, 4, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-16 08:54:36'),
(100, 'Ячмень', NULL, 4.62, 30000, 9, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(101, 'Солод', NULL, 8.12, 22500, 9, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(102, 'Хмель', NULL, 0.20, 1240, 9, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(103, 'Сахар', NULL, 12.80, 3180, 9, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(104, 'Продукт 14', NULL, 600.00, 4008, 9, 4, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-16 08:54:36'),
(105, 'Ячмень', NULL, 4.62, 30000, 9, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(106, 'Солод', NULL, 8.12, 22500, 9, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(107, 'Хмель', NULL, 0.20, 1240, 9, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(108, 'Сахар', NULL, 12.80, 3180, 9, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(169, 'Продукт 12', NULL, 643.00, 60, 13, 4, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-16 09:02:45'),
(170, 'Ячмень', NULL, 4.62, 30000, 13, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(171, 'Солод', NULL, 8.12, 22500, 13, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(172, 'Хмель', NULL, 0.20, 1240, 13, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(173, 'Сахар', NULL, 12.80, 3180, 13, 6, 'monthly', 0, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(174, 'Продукт 13', NULL, 653.00, 608, 13, 4, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(175, 'Ячмень', NULL, 4.62, 30000, 13, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(176, 'Солод', NULL, 8.12, 225000, 13, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-16 09:02:45'),
(177, 'Хмель', NULL, 0.20, 1240, 13, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(178, 'Сахар', NULL, 12.80, 3180, 13, 6, 'monthly', 4, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(179, 'Продукт 14', NULL, 600.00, 60, 13, 4, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-16 08:47:46'),
(180, 'Ячмень', NULL, 4.62, 30000, 13, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(181, 'Солод', NULL, 8.12, 22500, 13, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(182, 'Хмель', NULL, 0.20, 1240, 13, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(183, 'Сахар', NULL, 12.80, 3180, 13, 6, 'monthly', 8, NULL, 0, '2019-05-14 12:52:40', '2019-05-14 12:52:40'),
(184, 'Исследование рынка', 500000.00, NULL, NULL, 10, 5, 'once', 0, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:08'),
(185, 'Продукт 4', NULL, 650.00, 1009, 10, 4, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-16 08:50:46'),
(186, 'Ячмень', NULL, 4.62, 32000, 10, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:08'),
(187, 'Солод', NULL, 8.12, 23000, 10, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:08'),
(188, 'Хмель', NULL, 0.20, 1300, 10, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:08'),
(189, 'Сахар', NULL, 12.80, 3200, 10, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:08'),
(190, 'Исследование рынка', 600000.00, NULL, NULL, 14, 5, 'once', 0, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:43'),
(191, 'Продукт 7', NULL, 650.00, 7000, 14, 4, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-16 08:57:52'),
(192, 'Ячмень', NULL, 4.62, 30000, 14, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:43'),
(193, 'Солод', NULL, 8.12, 20000, 14, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:43'),
(194, 'Хмель', NULL, 0.20, 1000, 14, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:43'),
(195, 'Сахар', NULL, 12.80, 3000, 14, 6, 'monthly', 1, NULL, 0, '2019-05-14 13:13:08', '2019-05-14 13:13:43'),
(196, 'Реклама', 3000000.00, NULL, NULL, 15, 7, 'quarterly', 0, NULL, 0, '2019-05-14 22:53:02', '2019-05-16 08:43:39'),
(197, 'Реклама', -8000000.00, NULL, NULL, 16, 7, 'monthly', 0, NULL, 0, '2019-05-14 22:53:02', '2019-05-16 08:59:14'),
(198, 'Обучение', 200000.00, NULL, NULL, 17, 5, 'quarterly', 0, 4, 0, '2019-05-14 22:55:44', '2019-05-14 22:55:44'),
(199, 'Реклама нового продукта', 4000000.00, NULL, NULL, 15, 7, 'monthly', 12, NULL, 0, '2019-05-16 08:41:58', '2019-05-16 08:44:53'),
(200, 'Рекламная акция', 6000000.00, NULL, NULL, 15, 7, 'once', 24, NULL, 0, '2019-05-16 08:44:33', '2019-05-16 08:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Company name', 'superadmin@mail.com', '$2y$10$B3A2bzQlHj8UaR79GqXLpeLKroZ206IpDf2w.j8LgxO9ZLGyV5slu', 'PfuoM3nA6UHN5Ao8nMnjkWM8NVITKPp3SeBXRJWuCij4R5lwzx5f4Fott7Fy', '2019-04-14 18:56:41', '2019-04-14 18:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `companies_kpis`
--

CREATE TABLE `companies_kpis` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `kpi_id` int(10) UNSIGNED NOT NULL,
  `target_value` double(8,2) NOT NULL,
  `importance` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies_kpis`
--

INSERT INTO `companies_kpis` (`id`, `company_id`, `kpi_id`, `target_value`, `importance`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 1.06, 0.14, '2019-05-14 08:00:02', '2019-05-14 08:06:04'),
(4, 1, 4, 1.10, 0.10, '2019-05-14 08:00:27', '2019-05-14 22:22:48'),
(7, 1, 7, 1.10, 0.56, '2019-05-14 08:05:35', '2019-05-16 08:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `compares`
--

CREATE TABLE `compares` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `left_kpi_id` int(10) UNSIGNED NOT NULL,
  `right_kpi_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compares`
--

INSERT INTO `compares` (`id`, `value`, `company_id`, `left_kpi_id`, `right_kpi_id`, `created_at`, `updated_at`) VALUES
(2, -2, 1, 3, 4, NULL, NULL),
(8, 4, 1, 3, 7, NULL, NULL),
(9, 4, 1, 4, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `experiments`
--

CREATE TABLE `experiments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `calculated` tinyint(1) NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0.22',
  `budget` double NOT NULL DEFAULT '5000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiments`
--

INSERT INTO `experiments` (`id`, `company_id`, `name`, `date`, `calculated`, `tax`, `budget`, `created_at`, `updated_at`) VALUES
(2, 1, 'Усі сегменти', '2019-06-01', 1, 0.22, 3000000, '2019-05-14 08:24:39', '2019-05-20 11:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `experiment_budget`
--

CREATE TABLE `experiment_budget` (
  `id` int(10) UNSIGNED NOT NULL,
  `experiment_id` int(10) UNSIGNED NOT NULL,
  `budget_id` int(10) UNSIGNED NOT NULL,
  `use` tinyint(1) NOT NULL DEFAULT '1',
  `answer` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiment_budget`
--

INSERT INTO `experiment_budget` (`id`, `experiment_id`, `budget_id`, `use`, `answer`, `created_at`, `updated_at`) VALUES
(5, 2, 5, 0, 0, NULL, NULL),
(6, 2, 6, 0, 0, NULL, NULL),
(7, 2, 7, 0, 0, NULL, NULL),
(8, 2, 8, 0, 0, NULL, NULL),
(9, 2, 9, 1, 1, NULL, NULL),
(10, 2, 10, 1, 1, NULL, NULL),
(13, 2, 13, 1, 0, NULL, NULL),
(14, 2, 14, 1, 1, NULL, NULL),
(15, 2, 15, 1, 1, NULL, NULL),
(16, 2, 16, 1, 0, NULL, NULL),
(17, 2, 17, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `experiment_compare`
--

CREATE TABLE `experiment_compare` (
  `id` int(10) UNSIGNED NOT NULL,
  `experiment_id` int(10) UNSIGNED NOT NULL,
  `compare_id` int(10) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiment_compare`
--

INSERT INTO `experiment_compare` (`id`, `experiment_id`, `compare_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 2, NULL, NULL),
(4, 2, 8, 4, NULL, NULL),
(5, 2, 9, -2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `experiment_kpi`
--

CREATE TABLE `experiment_kpi` (
  `id` int(10) UNSIGNED NOT NULL,
  `experiment_id` int(10) UNSIGNED NOT NULL,
  `kpi_id` int(10) UNSIGNED NOT NULL,
  `target_value` double NOT NULL,
  `result_value` double DEFAULT NULL,
  `importance` double DEFAULT NULL,
  `use` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiment_kpi`
--

INSERT INTO `experiment_kpi` (`id`, `experiment_id`, `kpi_id`, `target_value`, `result_value`, `importance`, `use`, `created_at`, `updated_at`) VALUES
(3, 2, 3, 0.35, 0.3555609572571907, 0.14937313613223, 1, NULL, '2019-05-16 09:03:31'),
(4, 2, 4, 1.2, 1.1949909772356897, 0.47423014686417, 1, NULL, '2019-05-16 09:03:31'),
(6, 2, 7, 1.065, 1.0647077597707386, 0.37639671700361, 1, NULL, '2019-05-16 09:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `kpis`
--

CREATE TABLE `kpis` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holding_target_value` double(8,2) DEFAULT NULL,
  `holding_importance` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `holding_target_value`, `holding_importance`, `created_at`, `updated_at`) VALUES
(3, 'Збільшення рентабельності капіталу', NULL, NULL, '2019-05-14 08:00:02', '2019-05-20 11:32:32'),
(4, 'Збільшення пізнаваності бренду', NULL, NULL, '2019-05-14 08:00:27', '2019-05-20 11:33:00'),
(7, 'Збільшення прибутку', NULL, NULL, '2019-05-14 08:05:35', '2019-05-20 11:33:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_companies_table', 1),
(2, '2014_10_12_100000_password_resets_table', 1),
(3, '2017_04_29_174719_subdivisions_table', 1),
(4, '2017_04_29_175220_kpis_table', 1),
(5, '2017_04_29_175401_budgets_table', 1),
(6, '2017_04_29_175411_compares_table', 1),
(7, '2017_04_29_175535_companies_kpis_table', 1),
(8, '2017_04_29_175540_budget_indicators_table', 1),
(9, '2017_04_29_175624_budgets_values_table', 1),
(10, '2017_04_29_175652_transformations_table', 1),
(11, '2017_06_04_090135_experiments_table', 1),
(12, '2017_06_04_090154_experiment_compare_table', 1),
(13, '2017_06_04_090203_experiment_budget_table', 1),
(14, '2017_06_04_090214_experiment_kpi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subdivisions`
--

CREATE TABLE `subdivisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subdivisions`
--

INSERT INTO `subdivisions` (`id`, `name`, `company_id`, `created_at`, `updated_at`) VALUES
(3, 'Посилення роботи у торгівельних точках', 1, '2019-05-14 07:34:43', '2019-05-20 10:10:13'),
(4, 'Розширення точок збуту', 1, '2019-05-14 07:34:56', '2019-05-20 11:27:10'),
(5, 'Підвищення якості продукції', 1, '2019-05-14 07:35:06', '2019-05-20 11:27:22'),
(6, 'Вихід на закордонні ринки', 1, '2019-05-14 07:35:20', '2019-05-20 11:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `transformations`
--

CREATE TABLE `transformations` (
  `id` int(10) UNSIGNED NOT NULL,
  `kpi_id` int(10) UNSIGNED NOT NULL,
  `left_budget_indicator_id` int(10) UNSIGNED DEFAULT NULL,
  `right_budget_indicator_id` int(10) UNSIGNED DEFAULT NULL,
  `left_transformation_id` int(10) UNSIGNED DEFAULT NULL,
  `right_transformation_id` int(10) UNSIGNED DEFAULT NULL,
  `value` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation` enum('+','-','*','/') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transformations`
--

INSERT INTO `transformations` (`id`, `kpi_id`, `left_budget_indicator_id`, `right_budget_indicator_id`, `left_transformation_id`, `right_transformation_id`, `value`, `operation`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 6, NULL, NULL, NULL, '-', NULL, NULL),
(2, 3, NULL, 9, 1, NULL, NULL, '+', NULL, NULL),
(3, 3, NULL, 10, 2, NULL, NULL, '+', NULL, NULL),
(5, 3, NULL, NULL, NULL, NULL, '%budget%', '+', NULL, NULL),
(7, 3, NULL, NULL, 5, NULL, '2', '/', NULL, NULL),
(8, 3, NULL, NULL, 3, 7, NULL, '/', NULL, NULL),
(9, 3, NULL, NULL, 8, NULL, '(1 - %tax%)', '*', NULL, NULL),
(13, 7, 4, 6, NULL, NULL, NULL, '-', NULL, NULL),
(14, 7, NULL, 9, 13, NULL, NULL, '+', NULL, NULL),
(15, 7, NULL, 10, 14, NULL, NULL, '+', NULL, NULL),
(17, 7, NULL, NULL, 15, 15, NULL, '/', NULL, NULL),
(18, 4, 7, 7, NULL, NULL, NULL, '/', NULL, NULL),
(19, 3, NULL, NULL, 9, NULL, '0.75', '-', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budgets_subdivision_id_foreign` (`subdivision_id`);

--
-- Indexes for table `budget_indicators`
--
ALTER TABLE `budget_indicators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_values`
--
ALTER TABLE `budget_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_values_budget_id_foreign` (`budget_id`),
  ADD KEY `budget_values_budget_indicator_id_foreign` (`budget_indicator_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`);

--
-- Indexes for table `companies_kpis`
--
ALTER TABLE `companies_kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_kpis_company_id_foreign` (`company_id`),
  ADD KEY `companies_kpis_kpi_id_foreign` (`kpi_id`);

--
-- Indexes for table `compares`
--
ALTER TABLE `compares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compares_company_id_foreign` (`company_id`),
  ADD KEY `compares_left_kpi_id_foreign` (`left_kpi_id`),
  ADD KEY `compares_right_kpi_id_foreign` (`right_kpi_id`);

--
-- Indexes for table `experiments`
--
ALTER TABLE `experiments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiments_company_id_foreign` (`company_id`);

--
-- Indexes for table `experiment_budget`
--
ALTER TABLE `experiment_budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiment_budget_experiment_id_foreign` (`experiment_id`),
  ADD KEY `experiment_budget_budget_id_foreign` (`budget_id`);

--
-- Indexes for table `experiment_compare`
--
ALTER TABLE `experiment_compare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiment_compare_experiment_id_foreign` (`experiment_id`),
  ADD KEY `experiment_compare_compare_id_foreign` (`compare_id`);

--
-- Indexes for table `experiment_kpi`
--
ALTER TABLE `experiment_kpi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiment_kpi_experiment_id_foreign` (`experiment_id`),
  ADD KEY `experiment_kpi_kpi_id_foreign` (`kpi_id`);

--
-- Indexes for table `kpis`
--
ALTER TABLE `kpis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `subdivisions`
--
ALTER TABLE `subdivisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subdivisions_company_id_foreign` (`company_id`);

--
-- Indexes for table `transformations`
--
ALTER TABLE `transformations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transformations_kpi_id_foreign` (`kpi_id`),
  ADD KEY `transformations_left_budget_indicator_id_foreign` (`left_budget_indicator_id`),
  ADD KEY `transformations_right_budget_indicator_id_foreign` (`right_budget_indicator_id`),
  ADD KEY `transformations_left_transformation_id_foreign` (`left_transformation_id`),
  ADD KEY `transformations_right_transformation_id_foreign` (`right_transformation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `budget_indicators`
--
ALTER TABLE `budget_indicators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `budget_values`
--
ALTER TABLE `budget_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies_kpis`
--
ALTER TABLE `companies_kpis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `compares`
--
ALTER TABLE `compares`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `experiments`
--
ALTER TABLE `experiments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `experiment_budget`
--
ALTER TABLE `experiment_budget`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `experiment_compare`
--
ALTER TABLE `experiment_compare`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `experiment_kpi`
--
ALTER TABLE `experiment_kpi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kpis`
--
ALTER TABLE `kpis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subdivisions`
--
ALTER TABLE `subdivisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transformations`
--
ALTER TABLE `transformations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_subdivision_id_foreign` FOREIGN KEY (`subdivision_id`) REFERENCES `subdivisions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_values`
--
ALTER TABLE `budget_values`
  ADD CONSTRAINT `budget_values_budget_id_foreign` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budget_values_budget_indicator_id_foreign` FOREIGN KEY (`budget_indicator_id`) REFERENCES `budget_indicators` (`id`);

--
-- Constraints for table `companies_kpis`
--
ALTER TABLE `companies_kpis`
  ADD CONSTRAINT `companies_kpis_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_kpis_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compares`
--
ALTER TABLE `compares`
  ADD CONSTRAINT `compares_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compares_left_kpi_id_foreign` FOREIGN KEY (`left_kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compares_right_kpi_id_foreign` FOREIGN KEY (`right_kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiments`
--
ALTER TABLE `experiments`
  ADD CONSTRAINT `experiments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiment_budget`
--
ALTER TABLE `experiment_budget`
  ADD CONSTRAINT `experiment_budget_budget_id_foreign` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `experiment_budget_experiment_id_foreign` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiment_compare`
--
ALTER TABLE `experiment_compare`
  ADD CONSTRAINT `experiment_compare_compare_id_foreign` FOREIGN KEY (`compare_id`) REFERENCES `compares` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `experiment_compare_experiment_id_foreign` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiment_kpi`
--
ALTER TABLE `experiment_kpi`
  ADD CONSTRAINT `experiment_kpi_experiment_id_foreign` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `experiment_kpi_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subdivisions`
--
ALTER TABLE `subdivisions`
  ADD CONSTRAINT `subdivisions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transformations`
--
ALTER TABLE `transformations`
  ADD CONSTRAINT `transformations_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transformations_left_budget_indicator_id_foreign` FOREIGN KEY (`left_budget_indicator_id`) REFERENCES `budget_indicators` (`id`),
  ADD CONSTRAINT `transformations_left_transformation_id_foreign` FOREIGN KEY (`left_transformation_id`) REFERENCES `transformations` (`id`),
  ADD CONSTRAINT `transformations_right_budget_indicator_id_foreign` FOREIGN KEY (`right_budget_indicator_id`) REFERENCES `budget_indicators` (`id`),
  ADD CONSTRAINT `transformations_right_transformation_id_foreign` FOREIGN KEY (`right_transformation_id`) REFERENCES `transformations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
