-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2020 at 12:28 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `fakturorama`
--
CREATE DATABASE IF NOT EXISTS `fakturorama` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fakturorama`;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200902222540', '2020-09-03 00:25:44', 910);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_tax_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `due_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `number`, `issue_date`, `buyer_name`, `buyer_tax_id`, `buyer_address`, `created_at`, `due_date`) VALUES
(1, '2020/0001', '2020-08-12', 'Zakład usług kanalizacyjnych', '123-41-12-222', 'ul. Zawiślanska 12, 00-419 Warszawa', '2020-09-03 00:25:48', '2020-08-26'),
(2, '2020/0002', '2020-08-13', 'Drutex Sp. z o.o.', '143-211-12-44', 'ul. Nadmorska 8, 71-120 Bezrzecze', '2020-09-03 00:25:48', '2020-08-27'),
(3, '2020/0003', '2020-08-18', 'Mróz Sp. Jawna', '747-21-133-24', 'ul. Gostyńska 8, 41-124 Borek Wlkp.', '2020-09-03 00:25:48', '2020-09-01'),
(4, '2020/0004', '2020-08-23', 'Pogoń Szczecin S/A', '771-231-33-14', 'ul. Twardowskiego 1, 71-899 Szczecin', '2020-09-03 00:25:48', '2020-09-06'),
(5, '2020/0005', '2020-08-28', 'Taran Sp. z o.o.', '817-100-05-72', 'Olsztyńska 1B, 71-042 Szczecin', '2020-09-03 00:25:48', '2020-09-11'),
(6, '2020/0006', '2020-08-28', 'Wilhelmsen Marine Personnel', '819-00-05-733', 'pl. Rodła 8, 70-419 Szczecin', '2020-09-03 00:25:48', '2020-09-11'),
(7, '2020/0007', '2020-08-29', 'Mróz Sp. Jawna', '747-21-13-214', 'ul. Gostyńska 8, 41-124 Borek Wlkp.', '2020-09-03 00:25:48', '2020-09-12'),
(8, '2020/0008', '2020-08-30', 'Taran Sp. z o.o.', '817-00-05-762', 'ul. Olsztyńska 1B, 71-042 Szczecin', '2020-09-03 00:25:48', '2020-09-13'),
(9, '2020/0009', '2020-08-13', 'Drutex Sp. z o.o.', '143-211-12-44', 'ul. Nadmorska 8, 71-120 Bezrzecze', '2020-09-03 00:25:48', '2020-08-27'),
(10, '2020/0010', '2020-08-31', 'Zakład usług kanalizacyjnych', '123-41-12-222', 'ul. Zawiślanska 12, 00-419 Warszawa', '2020-09-03 00:25:48', '2020-09-14'),
(11, '2020/0011', '2020-08-31', 'Pogoń Szczecin S/A', '771-21-33-214', 'ul. Twardowskiego 1, 71-899 Szczecin', '2020-09-03 00:25:48', '2020-09-14'),
(12, '2020/0012', '2020-09-01', 'Pazim Sp. z o.o.', '413-214-33-21', 'pl. Rodła 8 , 70-419 Szczecin', '2020-09-03 00:25:48', '2020-09-15'),
(13, '2020/0013', '2020-09-01', 'Akwiaria Sp. z o.o.', '451-244-23-21', 'ul. Rybia 4 , 75-449 Koszalin', '2020-09-03 00:25:48', '2020-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id_id` int(11) NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DCC4B9F8429ECEE2` (`invoice_id_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id_id`, `product`, `quantity`, `price`, `total`, `created_at`) VALUES
(1, 1, 'Pakiet MS Office', 20, 35000, 700000, '2020-09-03 00:25:48'),
(2, 1, 'Windows 10', 20, 65000, 1300000, '2020-09-03 00:25:48'),
(3, 2, 'Drukarka', 1, 79200, 79200, '2020-09-03 00:25:48'),
(4, 2, 'Klawiatura', 2, 4300, 8600, '2020-09-03 00:25:48'),
(5, 2, 'Mysz', 2, 3900, 7800, '2020-09-03 00:25:48'),
(6, 3, 'Mysz', 6, 3900, 23400, '2020-09-03 00:25:48'),
(7, 3, 'Przewód HDMI', 1, 5850, 5850, '2020-09-03 00:25:48'),
(8, 4, 'Drukarka', 2, 79200, 158400, '2020-09-03 00:25:49'),
(9, 4, 'Windows 10', 1, 65000, 65000, '2020-09-03 00:25:49'),
(10, 5, 'Klawiatura', 2, 4300, 8600, '2020-09-03 00:25:49'),
(11, 6, 'Mysz', 2, 3900, 7800, '2020-09-03 00:25:49'),
(12, 7, 'Mysz', 6, 3900, 23400, '2020-09-03 00:25:49'),
(13, 8, 'Drukarka', 2, 79200, 158400, '2020-09-03 00:25:49'),
(14, 9, 'Mysz', 6, 3900, 23400, '2020-09-03 00:25:49'),
(15, 9, 'Klawiatura', 6, 4300, 25800, '2020-09-03 00:25:49'),
(16, 10, 'Pakiet MS Office', 20, 35000, 700000, '2020-09-03 00:25:49'),
(17, 11, 'Windows 10', 20, 65000, 1300000, '2020-09-03 00:25:49'),
(18, 12, 'Windows 10', 1, 65000, 65000, '2020-09-03 00:25:49'),
(19, 12, 'Drukarka', 1, 79200, 79200, '2020-09-03 00:25:49'),
(20, 13, 'Mysz', 4, 3900, 15600, '2020-09-03 00:25:49'),
(21, 13, 'Przewód HDMI', 2, 5850, 11700, '2020-09-03 00:25:49'),
(22, 13, 'Pendriver 64GB', 5, 3000, 15000, '2020-09-03 00:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_tax_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_account` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_vat` int(11) NOT NULL,
  `default_due_date_days` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `company_name`, `company_address`, `company_tax_id`, `default_currency`, `company_account`, `default_vat`, `default_due_date_days`) VALUES
(1, 'Fakturorama Sp. z o. o.', 'Woronicza 1, 00-491 Warszawa', '851-21-22-11', 'PLN', 'PL 12 1234 5678 9012 3456 7890 1234', 23, 14);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `FK_DCC4B9F8429ECEE2` FOREIGN KEY (`invoice_id_id`) REFERENCES `invoices` (`id`);
COMMIT;
