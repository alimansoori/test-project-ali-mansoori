-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 23, 2019 at 12:53 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `ilya_categories`
--

DROP TABLE IF EXISTS `ilya_categories`;
CREATE TABLE IF NOT EXISTS `ilya_categories` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL,
  `title` varchar(80) NOT NULL,
  `content` varchar(200) DEFAULT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ilya_categories`
--

INSERT INTO `ilya_categories` (`id`, `parent_id`, `title`, `content`, `position`, `created`) VALUES
(1, NULL, 'کالای دیجیتال', 'توضیحات کالای دیجیتال', 1, '2019-08-23 12:08:16'),
(2, NULL, 'خودرو، ابزار و اداری', 'توضیحات دسته بندی خودرو ابزار و اداری', 2, '2019-08-23 12:08:55'),
(3, NULL, 'مد و پوشاک', 'توضیحات دسته بندی مد و پوشاک', 3, '2019-08-23 12:09:27'),
(4, 1, 'لوازم جانبی گوشی', 'توضیحات لوازم جانبی گوشی', 2, '2019-08-23 12:14:30'),
(5, 1, 'دوربین', 'توضیحات دسته بندی دوربین', 1, '2019-08-23 12:14:30'),
(6, 2, 'ابزار برقی', 'توضیحات دسته بندی ابزار برقی', 1, '2019-08-23 12:14:30'),
(7, 2, 'ابزار غیر برقی', 'توضیحات دسته بندی ابزار غیربرقی', 2, '2019-08-23 12:14:30'),
(8, 3, 'لباس زنانه', 'توضیجات دسته بندی لباس زنانه', 1, '2019-08-23 12:14:30'),
(9, 3, 'زیورآلات زنانه', 'توضیحات دسته بندی زیورآلات زنانه', 2, '2019-08-23 12:14:30'),
(10, 5, 'دوربین عکاسی دیجیتال', 'توضیحات دوربین عکاسی دیجیتال', 2, '2019-08-23 12:16:24'),
(11, 5, 'دوربی چاپ سریع', 'توضیحات دسته بندی دوربین چاپ سریع', 1, '2019-08-23 12:16:24');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ilya_categories`
--
ALTER TABLE `ilya_categories`
  ADD CONSTRAINT `fk1_categories` FOREIGN KEY (`parent_id`) REFERENCES `ilya_categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
