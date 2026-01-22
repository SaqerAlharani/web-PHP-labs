-- SwiftPay Database Setup
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `swiftpay_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `swiftpay_db`;

-- Table structure for table `accounts`
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `accounts`
INSERT INTO `accounts` (`full_name`, `balance`) VALUES
('صقر الحراني', 50000.00),
('مستلم تجريبي', 10000.00);

-- Table structure for table `transactions`
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `executed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
