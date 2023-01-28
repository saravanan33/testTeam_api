-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 28, 2023 at 05:24 PM
-- Server version: 8.0.32-0buntu0.20.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TeamTest`
--

-- --------------------------------------------------------

--
-- Table structure for table `APIDetails`
--

CREATE TABLE `APIDetails` (
  `api_details_id` int NOT NULL,
  `api_key` longtext,
  `expire_date` datetime DEFAULT NULL,
  `status` enum('A','IA','E','D') NOT NULL DEFAULT 'IA' COMMENT 'A - active, IA - In active ,D - delete, E - Expired',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `APIDetails`
--

INSERT INTO `APIDetails` (`api_details_id`, `api_key`, `expire_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '56933A09-7F79-450F-96C6-34666A36DC21', '2023-01-28 12:26:06', 'A', '2023-01-23 19:41:53', '2023-01-28 11:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `featured_products`
--

CREATE TABLE `featured_products` (
  `featured_products_id` int NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_category_id` int NOT NULL,
  `product_description` text NOT NULL,
  `product_price` int NOT NULL,
  `sku_code` varchar(100) NOT NULL,
  `status` enum('A','IA','D') NOT NULL COMMENT 'A-Active,IA-In Active,D-Delete',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `featured_products`
--

INSERT INTO `featured_products` (`featured_products_id`, `product_name`, `product_category_id`, `product_description`, `product_price`, `sku_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'fridgas', 3, 'Fridge is one of the home appiencessss', 45000, '316745859759853', 'IA', '2023-01-24 17:46:51', '2023-01-24 18:54:21'),
(2, 'fridg', 1, 'Fridge is one of the home appience', 20000, '116745828891975', 'A', '2023-01-24 17:54:49', '2023-01-24 17:54:49'),
(3, 'fridga', 1, 'Fridge is one of the home appience', 20000, '116745829875537', 'A', '2023-01-24 17:56:27', '2023-01-24 17:56:27'),
(4, 'fridgas', 1, 'Fridge is one of the home appience', 20000, '116745830007905', 'A', '2023-01-24 17:56:40', '2023-01-24 17:56:40'),
(5, 'fri', 1, 'Fridge is one of the home appience', 20000, '116747559427659', 'A', '2023-01-26 17:59:02', '2023-01-26 17:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_category_id` int NOT NULL,
  `product_category_label` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `product_category_name` varchar(100) DEFAULT NULL,
  `status` enum('A','IA','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'IA' COMMENT 'A-Active,IA-In Active, D-Delete',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_category_id`, `product_category_label`, `product_category_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'H', 'Home', 'A', '2023-01-24 22:04:41', '2023-01-24 22:04:41'),
(2, 'G', 'Garden', 'A', '2023-01-24 22:04:41', '2023-01-24 22:04:41'),
(3, 'E', 'Electronics', 'A', '2023-01-24 22:05:33', '2023-01-24 22:05:33'),
(4, 'F', 'Fitness', 'A', '2023-01-24 22:05:33', '2023-01-24 22:05:33'),
(5, 'T', 'Toys', 'A', '2023-01-24 22:06:28', '2023-01-24 22:06:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `APIDetails`
--
ALTER TABLE `APIDetails`
  ADD PRIMARY KEY (`api_details_id`);

--
-- Indexes for table `featured_products`
--
ALTER TABLE `featured_products`
  ADD PRIMARY KEY (`featured_products_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `APIDetails`
--
ALTER TABLE `APIDetails`
  MODIFY `api_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `featured_products`
--
ALTER TABLE `featured_products`
  MODIFY `featured_products_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
