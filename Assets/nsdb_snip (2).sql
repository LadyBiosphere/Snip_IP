-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2014 at 02:42 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nsdb_snip`
--

-- --------------------------------------------------------

--
-- Table structure for table `s_categories`
--

CREATE TABLE IF NOT EXISTS `s_categories` (
  `cat_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(60) NOT NULL,
  PRIMARY KEY (`cat_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains categories for products, e.g. shampoo and conditioner' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `s_categories`
--

INSERT INTO `s_categories` (`cat_ID`, `category`) VALUES
(1, 'Men''s & Boys styling'),
(2, 'Women''s & Girls Styling'),
(3, 'Shampoo'),
(4, 'Conditioner'),
(5, 'Treatment'),
(6, 'Styling');

-- --------------------------------------------------------

--
-- Table structure for table `s_cat_prods`
--

CREATE TABLE IF NOT EXISTS `s_cat_prods` (
  `catprod_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_ID` smallint(5) unsigned NOT NULL,
  `product_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`catprod_ID`),
  KEY `cat_ID` (`cat_ID`),
  KEY `cat_ID_2` (`cat_ID`),
  KEY `product_ID` (`product_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains relationship between product categories and products.' AUTO_INCREMENT=36 ;

--
-- Dumping data for table `s_cat_prods`
--

INSERT INTO `s_cat_prods` (`catprod_ID`, `cat_ID`, `product_ID`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 9),
(10, 2, 10),
(11, 2, 11),
(12, 2, 12),
(13, 2, 13),
(14, 2, 14),
(15, 2, 15),
(16, 4, 16),
(17, 4, 17),
(18, 4, 18),
(19, 5, 19),
(20, 5, 20),
(21, 5, 21),
(22, 6, 22),
(24, 6, 23),
(25, 6, 24),
(26, 6, 25),
(27, 6, 26),
(28, 6, 27),
(29, 6, 28),
(30, 6, 29),
(31, 6, 30),
(32, 6, 31),
(33, 6, 32),
(34, 6, 33),
(35, 1, 34);

-- --------------------------------------------------------

--
-- Table structure for table `s_news`
--

CREATE TABLE IF NOT EXISTS `s_news` (
  `news_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `news_title` varchar(60) NOT NULL,
  `news_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `news_photo` varchar(400) NOT NULL,
  `news_desc` varchar(250) NOT NULL,
  PRIMARY KEY (`news_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains news from the salon' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `s_news`
--

INSERT INTO `s_news` (`news_ID`, `news_title`, `news_date`, `news_photo`, `news_desc`) VALUES
(1, 'Welcome to a new SNIP!', '2014-11-25 00:46:14', '', 'We''ve got a new website and it''s compatible with mobile, tablet, desktop and a variety of mouse-less devices. We love it and think that you will love it too!');

-- --------------------------------------------------------

--
-- Table structure for table `s_pages`
--

CREATE TABLE IF NOT EXISTS `s_pages` (
  `page_ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `page_name` varchar(12) NOT NULL,
  `meta_desc` varchar(160) NOT NULL,
  `page_title` varchar(30) NOT NULL,
  `page_heading` varchar(250) NOT NULL,
  `sub_heading` varchar(250) NOT NULL,
  `access_restriction` enum('admin','user') NOT NULL,
  PRIMARY KEY (`page_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains website pages' AUTO_INCREMENT=19 ;

--
-- Dumping data for table `s_pages`
--

INSERT INTO `s_pages` (`page_ID`, `page_name`, `meta_desc`, `page_title`, `page_heading`, `sub_heading`, `access_restriction`) VALUES
(1, 'home', 'Find affordable haircuts, minus the fuss and nasty chemicals! Situated in Wellington CBD, drop in for a SNIP without booking appointments.', 'Home', 'We are honest and simple, with no silly frills or upsells. Just a damn good haircut, in GOOD TIME, EVERY TIME.', 'No appointments necessary!', 'user'),
(2, 'news', 'Learn about our upcoming events, celebrations, recent stories, time changes and product additions.', 'Latest News', 'We like keeping everyone on the same page because our news is your news.', '', 'user'),
(3, 'learn', 'Learn about our customer-oriented service and discover a connection to community.', 'Learn About Us', 'There''s more to us than cutting hair. We care about people too.', '', 'user'),
(4, 'team', 'Get acquainted with our team of professional hair stylists.', 'Meet the Team', 'We have a team who know hair with confidence.', '', 'user'),
(5, 'prices', 'Discover our range of hair services, organic products and prices.', 'Check out our prices', 'Exceptional prices, minus the chemicals.', '', 'user'),
(6, 'contact', 'Take a note of our address and come in! No appointments necessary!', 'Contact Us', 'Come in and get yourself a snip!', '', 'user'),
(7, 'login', 'Login to update this website.', 'Login', 'Need to update something? No problem!', '', 'user'),
(8, 'admin', 'Keep SNIP up-to-date to ensure that customers are always informed.', 'Admin', 'Admin Controls.', '', 'admin'),
(9, 'logout', 'Thank you for keeping this website up-to-date.', 'Logout', 'See ya later!', '', 'user'),
(10, 'error', 'The content you requested could not be found on the SNIP website.', 'Page Not Found', 'Yikes! Something went wrong!', '', 'user'),
(11, 'access', 'Access SNIP on mobile, tablet, desktop computer and a range of devices.', 'Accessibility', 'How to navigate this website, without your keyboard.', '', 'user'),
(12, 'editstaff', 'Restricted access | Edit Staff', 'Edit Hairdresser', 'Edit an existing hairdresser.', '', 'admin'),
(13, 'deletestaff', 'Restricted access | Delete Staff', 'Delete Hairdresser', 'Delete this hairdresser?', 'Are you sure you want to delete this?', 'admin'),
(14, 'newsSuccess', 'Updates have been successfully applied.', 'Success', 'Successfully updated.', '', 'admin'),
(15, 'editNews', 'Restricted | Edit news snippet.', 'Edit News', 'Edit this snippet.', '', 'admin'),
(16, 'deleteNews', 'Restricted | Delete news snippet.', 'Delete News', 'Delete this snippet.', 'Are you sure you want to delete this?', 'admin'),
(17, 'editProd', 'Restricted | Edit service or product.', 'Edit Product or Service', 'Edit an existing product', '', 'admin'),
(18, 'deleteProd', 'Restricted | Delete service or product.', 'Delete Product or Service', 'Delete this product or service?', 'Are you sure you want to delete this?', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `s_products`
--

CREATE TABLE IF NOT EXISTS `s_products` (
  `product_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(4,2) NOT NULL,
  PRIMARY KEY (`product_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains list of products being sold at SNIP' AUTO_INCREMENT=35 ;

--
-- Dumping data for table `s_products`
--

INSERT INTO `s_products` (`product_ID`, `product_name`, `product_price`) VALUES
(1, 'Status Quo Silver', '32.50'),
(2, 'Status Quo / Aqua Boost / Power Build', '28.00'),
(3, 'Soothe Plus', '35.50'),
(4, 'Clipper Shave', '12.00'),
(5, 'Clipper Sides & Back', '23.00'),
(6, 'Scissor Cut', '29.00'),
(7, 'Restyle', '35.00'),
(8, 'Wash', '5.00'),
(9, 'Trim One Length', '28.00'),
(10, 'Layered Cut', '38.00'),
(11, 'Wash & Blowwave', '0.00'),
(12, 'Wash, Cut & Blowwave', '55.00'),
(13, 'Restyle', '60.00'),
(14, 'Wash', '5.00'),
(15, 'Treatment', '20.00'),
(16, 'Status Quo / Aqua Boost / Power Build', '30.00'),
(17, 'Status Quo / Aqua Boost Leave In', '32.50'),
(18, 'Soothe Plus', '35.50'),
(19, 'Aqua Boost / Power Build', '32.00'),
(20, 'Revamp', '29.50'),
(21, 'Soothe Plus', '35.50'),
(22, 'Finale', '32.50'),
(23, 'Root Lift', '28.50'),
(24, 'Volume', '34.00'),
(25, 'Spritz', '28.50'),
(26, 'Texture', '35.00'),
(27, 'Define', '35.00'),
(28, 'Scuplt', '35.00'),
(29, 'Shape', '35.00'),
(30, 'Glaze', '28.50'),
(31, 'Shine', '35.00'),
(32, 'Thermal 220', '32.50'),
(33, 'Argan Gloss', '36.00'),
(34, 'FICTIONAL ITEMZ', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `s_staff`
--

CREATE TABLE IF NOT EXISTS `s_staff` (
  `staff_ID` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(35) NOT NULL,
  `staff_photo` varchar(300) NOT NULL,
  `staff_desc` varchar(400) NOT NULL,
  PRIMARY KEY (`staff_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains info about staff working at salon' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `s_staff`
--

INSERT INTO `s_staff` (`staff_ID`, `staff_name`, `staff_photo`, `staff_desc`) VALUES
(1, 'Jess', '54739e876fa918963190242_c33f059b5a_z.jpg', 'Hi. My name is Jess. I don''t actually work at SNIP. I found this pic online.'),
(2, 'Lemongrab', '5473a4f913ad3lemongrab-2.jpg', 'Rrrrrrrrrrrrrrggh! PUT YOU IN MY OVEN!');

-- --------------------------------------------------------

--
-- Table structure for table `s_users`
--

CREATE TABLE IF NOT EXISTS `s_users` (
  `user_ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_username` varchar(30) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `user_access` enum('user','admin') NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains user data.' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `s_users`
--

INSERT INTO `s_users` (`user_ID`, `user_username`, `user_password`, `user_access`) VALUES
(1, 'admin', '$2y$10$KacieUfzxiiDPSvPfJv.GeAF0.eLLe9lxS7c4Jkq/6U9qkMmk6nZW', 'admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `s_cat_prods`
--
ALTER TABLE `s_cat_prods`
  ADD CONSTRAINT `s_cat_prods_ibfk_1` FOREIGN KEY (`cat_ID`) REFERENCES `s_categories` (`cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s_cat_prods_ibfk_2` FOREIGN KEY (`product_ID`) REFERENCES `s_products` (`product_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
