-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2025 at 11:55 AM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `session_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_id`, `quantity`, `price`, `discount`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, 3, 10, '12000', '2000', '2025-04-18 06:26:04', '2025-04-18 06:26:04'),
(2, 6, NULL, 5, 5, '18000', '3000', '2025-04-18 06:42:30', '2025-04-18 06:42:30'),
(5, 3, NULL, 3, 10, '12000', '2000', '2025-04-18 08:10:14', '2025-04-18 08:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent_id` int DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Mobile', NULL, 'category_1744023029.jpg', '2025-04-07 10:52:39', '2025-04-07 10:52:39'),
(4, 'vivo', 1, 'upload/category_1744023233.jpeg', '2025-04-07 10:53:53', '2025-04-07 10:53:53'),
(5, 'oppo', 1, 'upload/category_1744023301.jpg', '2025-04-07 10:55:01', '2025-04-07 10:55:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `discount` int NOT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('Pending','Completed','Canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_amount`, `discount`, `shipping_address`, `status`, `created_at`, `updated_at`) VALUES
(100001, 6, '15000', 2000, 'Bapunagar', 'Pending', '2025-04-18 06:25:31', '2025-04-18 06:25:31'),
(100002, 6, '20000', 4000, '{\"id\":6,\"name\":\"Yash\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:27:01', '2025-04-18 06:27:01'),
(100003, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:27:45', '2025-04-18 06:27:45'),
(100004, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:32:12', '2025-04-18 06:32:12'),
(100005, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:32:32', '2025-04-18 06:32:32'),
(100006, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:33:11', '2025-04-18 06:33:11'),
(100007, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:33:45', '2025-04-18 06:33:45'),
(100008, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:34:08', '2025-04-18 06:34:08'),
(100009, 6, '50000', 10000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:35:11', '2025-04-18 06:35:11'),
(100010, 6, '60000', 12000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:36:49', '2025-04-18 06:36:49'),
(100011, 6, '80000', 16000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:39:58', '2025-04-18 06:39:58'),
(100012, 6, '80000', 16000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:40:21', '2025-04-18 06:40:21'),
(100013, 6, '80000', 16000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:40:52', '2025-04-18 06:40:52'),
(100014, 6, '80000', 16000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:42:05', '2025-04-18 06:42:05'),
(100015, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 06:42:50', '2025-04-18 06:42:50'),
(100016, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:23:46', '2025-04-18 07:23:46'),
(100017, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:24:44', '2025-04-18 07:24:44'),
(100018, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:25:22', '2025-04-18 07:25:22'),
(100019, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:25:42', '2025-04-18 07:25:42'),
(100020, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:35:37', '2025-04-18 07:35:37'),
(100021, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:35:58', '2025-04-18 07:35:58'),
(100022, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:36:15', '2025-04-18 07:36:15'),
(100023, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:39:44', '2025-04-18 07:39:44'),
(100024, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:42:43', '2025-04-18 07:42:43'),
(100025, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:43:10', '2025-04-18 07:43:10'),
(100026, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:44:07', '2025-04-18 07:44:07'),
(100027, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:44:16', '2025-04-18 07:44:16'),
(100028, 2, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:44:42', '2025-04-18 07:44:42'),
(100029, 2, '50000', 10000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 07:59:35', '2025-04-18 07:59:35'),
(100030, 2, '50000', 10000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:02:50', '2025-04-18 08:02:50'),
(100031, 2, '50000', 10000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:03:53', '2025-04-18 08:03:53'),
(100032, 2, '50000', 10000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:04:17', '2025-04-18 08:04:17'),
(100033, 2, '80000', 10000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:05:19', '2025-04-18 08:05:19'),
(100034, 2, '100000', 14000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:07:08', '2025-04-18 08:07:08'),
(100035, 6, '175000', 35000, '{\"id\":6,\"name\":\"Yash\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:08:22', '2025-04-18 08:08:22'),
(100036, 2, '110000', 16000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:09:01', '2025-04-18 08:09:01'),
(100037, 3, '100000', 20000, '{\"id\":3,\"name\":\"Ankur\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:10:36', '2025-04-18 08:10:36'),
(100038, 6, '175000', 35000, '{\"id\":6,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:12:01', '2025-04-18 08:12:01'),
(100039, 2, '110000', 16000, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:16:26', '2025-04-18 08:16:26'),
(100040, 2, '0', 0, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:16:58', '2025-04-18 08:16:58'),
(100041, 2, '35000', 0, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:45:10', '2025-04-18 08:45:10'),
(100042, 2, '5000', 0, '{\"id\":2,\"name\":\"Ajay\",\"phone_number\":\"09856235745\",\"address\":\"Bapunagar\",\"city\":\"ahmedabad\",\"country\":\"India\",\"state\":\"gujrat\",\"pin_code\":\"380024\",\"full_address\":\"Bapunagar\"}', 'Pending', '2025-04-18 08:47:05', '2025-04-18 08:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 100032, 5, 5, '18000', '2025-04-18 08:04:17', '2025-04-18 08:04:17'),
(2, 100033, 5, 5, '18000', '2025-04-18 08:05:19', '2025-04-18 08:05:19'),
(3, 100034, 5, 5, '18000', '2025-04-18 08:07:08', '2025-04-18 08:07:08'),
(4, 100036, 5, 5, '18000', '2025-04-18 08:09:01', '2025-04-18 08:09:01'),
(5, 100037, 3, 8, '12000', '2025-04-18 08:10:36', '2025-04-18 08:10:36'),
(6, 100039, 5, 5, '18000', '2025-04-18 08:16:26', '2025-04-18 08:16:26'),
(7, 100040, 5, 5, '18000', '2025-04-18 08:16:58', '2025-04-18 08:16:58'),
(8, 100041, 5, 5, '18000', '2025-04-18 08:45:10', '2025-04-18 08:45:10'),
(9, 100042, 5, 5, '18000', '2025-04-18 08:47:05', '2025-04-18 08:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `category_id` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount`, `category_id`, `quantity`, `image`, `created_at`, `updated_at`) VALUES
(1, 'vivo', 'all vivo serice avaliable on show', '200.00', '50.00', 1, 10, 'upload/product_1744719456.jpeg', '2025-04-07 10:57:24', '2025-04-07 10:57:24'),
(2, 'oppo', 'all vivo serice avaliable on show', '500.00', '100.00', 1, 10, 'upload/product_1744266113.jpeg', '2025-04-07 10:57:24', '2025-04-07 10:57:24'),
(3, 'Samsang', 'best phone', '12000.00', '2000.00', 1, 10, 'upload/product_1744273243.jpeg', '2025-04-10 08:14:39', '2025-04-10 08:14:39'),
(4, 'Iphone', '4g phone', '120000.00', '10000.00', 1, 10, 'upload/product_1744273272.jpeg', '2025-04-10 08:16:37', '2025-04-10 08:16:37'),
(5, 'oneplus', 'new phone', '18000.00', '3000.00', 1, 5, 'upload/product_1744273097.jpg', '2025-04-10 08:18:17', '2025-04-10 08:18:17'),
(6, 'boat', 'new boat products', '5000.00', '0.00', 1, 10, 'upload/product_1744279138.jpg', '2025-04-10 09:58:58', '2025-04-10 09:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-04-04 09:42:32', '2025-04-04 09:42:32'),
(2, 'Customer', '2025-04-04 09:42:48', '2025-04-04 09:42:48'),
(3, 'Guest', '2025-04-04 09:42:58', '2025-04-04 09:42:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int NOT NULL DEFAULT '2',
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `name`, `email`, `phone_number`, `address`, `image`, `created_at`, `updated_at`) VALUES
(1, 'ajay', '81dc9bdb52d04dc20036dbd8313ed055', 2, 'Ajay', 'ajay@gmail.com', '9756845260', 'bapunagar', '', '2025-04-18 11:47:53', '2025-04-18 11:47:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`) USING BTREE;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parent_id` (`parent_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_id` (`order_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100043;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
