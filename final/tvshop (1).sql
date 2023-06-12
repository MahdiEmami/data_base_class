-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2023 at 10:42 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tvshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `status`) VALUES
(1, 'TV', 1),
(2, 'Monitor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `comment_text` text,
  `comment_date` date DEFAULT NULL,
  `comment_parent_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`comment_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  KEY `comment_parent_id` (`comment_parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `product_id`, `customer_id`, `comment_text`, `comment_date`, `comment_parent_id`, `status`) VALUES
(1, 1, 1, 'test comment', '2023-06-06', NULL, 1),
(2, 1, 2, 'test comment on product 1 answer to comment 1', '2023-06-08', 1, 1),
(3, 2, 1, 'test comment on product 2 from user 1', '2023-06-10', NULL, 1),
(22, 1, 2, 'fghjtyururtu', '2023-06-12', 2, 1),
(21, 1, 2, 'uyityuti', '2023-06-12', 17, 1),
(17, 1, 2, 'hdfhdfghxcvh', '2023-06-15', NULL, 1),
(23, 2, 2, 'ertertdgsdfg', '2023-06-12', 3, 1),
(24, 3, 2, 'rtyeryryeryfchc', NULL, NULL, 1),
(25, 3, 2, 'reply test\r\n', '2023-06-12', 24, 1),
(26, 3, 2, 'gdfretertwst', '2023-06-12', 24, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `email`, `address`, `phone_number`, `status`) VALUES
(1, 'John Doe', 'john.doe@example.com', '123 Main St', '555-1234', 1),
(2, 'Alice Johnson', 'alice.johnson@example.com', '789 Oak St', '555-9876', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `employee_manager_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`employee_id`),
  KEY `employee_manager_id` (`employee_manager_id`),
  KEY `salary` (`salary`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `email`, `address`, `phone_number`, `hire_date`, `position`, `salary`, `employee_manager_id`, `status`) VALUES
(1, 'Jane Smith', 'jane.smith@example.com', '456 Elm St', '555-5678', '2023-01-01', 'Manager', '5000.00', NULL, 1),
(2, 'Bob Wilson', 'bob.wilson@example.com', '987 Pine St', '555-5432', '2023-02-01', 'Sales Representative', '3000.00', 1, 1),
(3, 'emp3', 'emp3@test.com', 'test p14', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`invoice_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `order_id`, `invoice_date`, `total_amount`, `tax`, `status`) VALUES
(1, 1, '2023-06-01', '999.99', '99.99', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_postal` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `shipper_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `shipper_id` (`shipper_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `total_amount`, `shipping_address`, `shipping_city`, `shipping_postal`, `shipping_country`, `payment_method`, `employee_id`, `shipper_id`, `status`) VALUES
(1, 1, '2023-06-01', '999.99', '123 Main St', 'Los Angeles', '90001', 'USA', 'Credit Card', 1, 1, 1),
(2, 2, '2023-06-02', '1999.99', '789 Oak St', 'New York', '10001', 'USA', 'PayPal', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `unit_price`, `discount`) VALUES
(1, 1, 1, '999.99', '0.00'),
(2, 2, 1, '1999.99', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `dimension` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `display_technology` varchar(255) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  `refresh_rate` int DEFAULT NULL,
  `smart_tv` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `price`, `description`, `dimension`, `brand`, `model`, `display_technology`, `resolution`, `refresh_rate`, `smart_tv`, `status`) VALUES
(1, 'Samsung 55', 1, '1400.00', 'Experience stunning visuals with this 55-inch 4K Smart TV from Samsung.', '55', 'Samsung', 'ABC123', 'LED', '3840x2160', 60, 1, 1),
(2, 'LG 65', 1, '1999.99', 'Immerse yourself in lifelike visuals with this 65-inch OLED 4K Smart TV from LG.', '65', 'LG', 'DEF456', 'OLED', '3840x2160', 120, 1, 1),
(3, 'sony 85 oled', 1, '1000.00', 'sony oled high quality', '85 inch', 'sony', 'braviaxra90j', 'OLED', '3840x2160', 120, 1, 1),
(4, 'alienware aw3423dw QD Oled ultrawide', 2, '1200.00', 'qd oled supporting hdr,hdr 1000 certified', '34 Inch', 'alienware', 'aw3423dw', 'OLED', '3500*1440', 165, 0, 1),
(7, 'TCL tv', 1, '1100.00', 'mini LED 4k tv', '50 Inch', 'TCL', 'TCL src501', 'mini LED', '4k', 120, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shippers`
--

DROP TABLE IF EXISTS `shippers`;
CREATE TABLE IF NOT EXISTS `shippers` (
  `shipper_id` int NOT NULL,
  `shipper_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`shipper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shippers`
--

INSERT INTO `shippers` (`shipper_id`, `shipper_name`, `phone_number`, `email`, `status`) VALUES
(1, 'ABC Logistics', '555-9999', 'info@abclogistics.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees` ADD FULLTEXT KEY `position` (`position`);

--
-- Indexes for table `products`
--
ALTER TABLE `products` ADD FULLTEXT KEY `product_name` (`product_name`);
ALTER TABLE `products` ADD FULLTEXT KEY `brand` (`brand`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
