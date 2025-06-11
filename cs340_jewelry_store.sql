-- phpMyAdmin SQL Dump
-- version 5.2.2-1.el9.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2025 at 10:27 AM
-- Server version: 10.11.11-MariaDB-log
-- PHP Version: 8.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs340_terbeekl`
--

-- --------------------------------------------------------

--
-- Table structure for table `fp_customer`
--

CREATE TABLE `fp_customer` (
  `customer_id` int(11) NOT NULL,
  `c_name` varchar(30) NOT NULL,
  `c_email` varchar(30) NOT NULL,
  `c_address` varchar(30) NOT NULL,
  `card_number` bigint(20) NOT NULL,
  `sec_code` int(11) NOT NULL,
  `exp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_customer`
--

INSERT INTO `fp_customer` (`customer_id`, `c_name`, `c_email`, `c_address`, `card_number`, `sec_code`, `exp_date`) VALUES
(574743, 'Hailey Prater', 'praterh@oregonstate.edu', '580 S 10th St', 3453445678874384, 456, '2023-12-05'),
(780042, 'Jenna Pernta', 'jpernta@gmail.com', '1232 Main Ave Apt 3B', 4539148803436467, 293, '2027-08-01'),
(780044, 'Ava Marlowe', 'ava.marlowe2@gmail.com', '9478 Copperleaf Dr Suite 210', 5500000000000004, 611, '2028-04-01'),
(780047, 'Liam Stratton', 'stratton.liam@yahoo.com', '56 Winding Creek Rd', 6011000990139424, 128, '2026-11-01'),
(780050, 'Mia Valdez', 'm.valdez@outlook.com', '1201 Sapphire St Unit 5', 4000056655665556, 732, '2025-12-01'),
(780055, 'Noah Everhart', 'noaheverhart@gmail.com', '377 Elmwood Ave', 379282246310005, 410, '2025-10-01'),
(780057, 'Zoe Dellinger', 'zoe.dellinger@yahoo.com', '8049 Garnet Ridge Trl', 6011510000000000, 847, '2026-09-01'),
(780059, 'Leo Ravenshaw', 'leo.ravenshaw450@gmail.com', '22 Briar Rose Court Apt 204', 4005519200000000, 364, '2028-11-01'),
(780061, 'Lily Fontaine', 'lfontaine@outlookl.com', '688 Crystal Hollow Way', 5424180012345678, 911, '2028-07-01'),
(780068, 'Owen Marquette', 'marquette.owen@gmail.com', '1054 Goldenleaf Blvd', 4111111111111111, 222, '2024-02-01'),
(780073, 'Isla Granger', 'islagranger@yahoo.com', '413 Pearlstone Dr', 6011123443211111, 45, '2030-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `fp_employee`
--

CREATE TABLE `fp_employee` (
  `employee_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `e_name` varchar(30) NOT NULL,
  `shop_address` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_employee`
--

INSERT INTO `fp_employee` (`employee_id`, `salary`, `e_name`, `shop_address`) VALUES
(111222, 34500, 'Gertrude Banker', '345 SW Mangrove St'),
(230001, 33000, 'Jimmy John Man', '111 NW 3rd St'),
(230002, 38500, 'Bart Squareson', '122 Birch Ln'),
(230003, 37000, 'Amanda Brunescelli', '222 4th St'),
(230006, 48000, 'Helena Rockfield', '435 6th St'),
(230007, 47500, 'Stewart Stepson', '435 6th St'),
(230008, 40000, 'Wanda Statson', '579 Boltzman Ave'),
(230009, 40000, 'Linda Bregese', '645 Lentz Ln'),
(230011, 42000, 'Harold Grant', '789 Oak St'),
(230012, 39500, 'Gerald Schienden', '887 Lorenz Path'),
(230014, 39000, 'Natalie Burgess', '978 Bart Rd'),
(333334, 34500, 'Bobby Jones', '111 NW 3rd St'),
(333345, 30000, 'Gart Newsome', '345 SW Mangrove St');

--
-- Triggers `fp_employee`
--
DELIMITER $$
CREATE TRIGGER `enforce_min_salary` BEFORE INSERT ON `fp_employee` FOR EACH ROW BEGIN
	IF NEW.salary < 30000 THEN
    	SET NEW.salary = 30000;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fp_jewelry`
--

CREATE TABLE `fp_jewelry` (
  `jewelry_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `primary_material` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `order_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_jewelry`
--

INSERT INTO `fp_jewelry` (`jewelry_id`, `type`, `primary_material`, `price`, `order_number`) VALUES
(101, 'Frost Ring', 'Silver', 550, 430127),
(102, 'Celestial Bangle', 'Silver', 60, 430120),
(103, 'Crimson Tide Cuff', 'Gold', 60, 430121),
(104, 'Dark Quartz Earrings', 'Gold', 60, 430123),
(105, 'Dusktide Bracelet', 'Titanium', 100, 430126),
(106, 'Frosted Spiral Headpiece', 'Silver', 80, 430124),
(107, 'Frosted Spiral Ring', 'Silver', 60, 430124),
(108, 'Iridescent Bracelet', 'Silver', 140, 430126),
(109, 'Iridescent Pendant', 'Silver', 120, 430126),
(110, 'Ivy Armpiece', 'Silver', 60, 430125),
(111, 'Ivy Necklace', 'Silver', 60, 430125),
(112, 'Luna Whisper Ring', 'Silver', 20, 430127),
(113, 'Midnight Earrings', 'Tungsten', 70, 430124),
(114, 'Midnight Ring', 'Tungsten', 70, 430124),
(115, 'Mystic Quartz Bracelet', 'Gold', 60, 430123),
(116, 'Mystic Quartz Earrings', 'Gold', 70, 430123),
(117, 'Mystic Quartz Necklace', 'Gold', 60, 430123),
(118, 'Mysitc Quartz Ring', 'Gold', 50, 430123),
(119, 'Opaline Necklace', 'Silver', 65, 430122),
(120, 'Pearl Earrings', 'Gold', 60, 430126),
(121, 'Rosemist Anklet', 'Gold', 180, 430126),
(122, 'Starlace Pendant', 'Platinum', 40, 430121),
(123, 'Sunflare Bangle', 'Gold', 100, 430128),
(124, 'Twilight Bracelet', 'Titanium', 80, 430129),
(125, 'Twilight Earrings', 'Titanium', 70, 430120),
(126, 'Twilight Necklace', 'Titanium', 80, 430120),
(127, 'Velvet Dawn Brooch', 'Gold', 260, 430129);

--
-- Triggers `fp_jewelry`
--
DELIMITER $$
CREATE TRIGGER `prevent_jewelry_deletion` BEFORE DELETE ON `fp_jewelry` FOR EACH ROW BEGIN
    DECLARE item_count INT;

    SELECT quantity_in_stock INTO item_count
    FROM fp_stock
    WHERE jewelry_id = OLD.jewelry_id;
    
    IF item_count IS NOT NULL AND item_count > 0 THEN
    	SIGNAL SQLSTATE '45000'
    	SET MESSAGE_TEXT = 'Cannot delete: Jewelry still in stock.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fp_order`
--

CREATE TABLE `fp_order` (
  `order_number` int(11) NOT NULL,
  `date` date NOT NULL,
  `num_items` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_order`
--

INSERT INTO `fp_order` (`order_number`, `date`, `num_items`, `cost`, `customer_id`) VALUES
(430120, '2024-12-13', 3, 200, 780044),
(430121, '2024-12-24', 2, 100, 780047),
(430122, '2024-12-24', 1, 65, 780057),
(430123, '2025-01-02', 5, 300, 780050),
(430124, '2025-01-15', 4, 280, 780073),
(430125, '2025-02-10', 2, 120, 780068),
(430126, '2025-03-09', 5, 600, 780059),
(430127, '2025-04-26', 2, 80, 780055),
(430128, '2025-05-22', 6, 440, 780042),
(430129, '2025-05-28', 3, 400, 780044),
(574321, '2025-06-07', 5, 500, 780042);

--
-- Triggers `fp_order`
--
DELIMITER $$
CREATE TRIGGER `prevent_expired_card_order` BEFORE INSERT ON `fp_order` FOR EACH ROW BEGIN
    DECLARE card_exp DATE;

    SELECT c_card_expiration INTO card_exp
    FROM fp_customer
    WHERE customer_id = NEW.customer_id;

    IF card_exp < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot place order with an expired card.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fp_order_jewelry`
--

CREATE TABLE `fp_order_jewelry` (
  `jewelry_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_order_jewelry`
--

INSERT INTO `fp_order_jewelry` (`jewelry_id`, `order_number`) VALUES
(102, 430120),
(103, 430120),
(103, 430121),
(105, 430126),
(106, 430124),
(106, 430128),
(107, 430124),
(107, 430128),
(107, 430129),
(108, 430124),
(108, 430128),
(109, 430126),
(110, 430125),
(111, 430125),
(111, 430128),
(112, 430127),
(113, 430124),
(114, 430124),
(115, 430123),
(116, 430123),
(117, 430123),
(118, 430123),
(119, 430122),
(120, 430126),
(121, 430126),
(122, 430121),
(123, 430128),
(124, 430129),
(126, 430120),
(127, 430129),
(98238484, 430121);

--
-- Triggers `fp_order_jewelry`
--
DELIMITER $$
CREATE TRIGGER `update_num_items_after_insert` AFTER INSERT ON `fp_order_jewelry` FOR EACH ROW BEGIN
    UPDATE fp_order
    SET num_items = (
        SELECT COUNT(*)
        FROM fp_order_jewelry
        WHERE order_number = NEW.order_number
    )
    WHERE order_number = NEW.order_number;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_order_cost_after_insert` AFTER INSERT ON `fp_order_jewelry` FOR EACH ROW BEGIN
    UPDATE fp_order
    SET cost = (
        SELECT SUM(j.price)
        FROM fp_order_jewelry oj
        JOIN fp_jewelry j ON oj.jewelry_id = j.jewelry_id
        WHERE oj.order_number = NEW.order_number
    )
    WHERE order_number = NEW.order_number;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fp_shop`
--

CREATE TABLE `fp_shop` (
  `shop_address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_shop`
--

INSERT INTO `fp_shop` (`shop_address`) VALUES
('111 NW 3rd St'),
('122 Birch Ln'),
('222 4th St'),
('345 SW Mangrove St'),
('435 6th St'),
('579 Boltzman Ave'),
('645 Lentz Ln'),
('789 Oak St'),
('887 Lorenz Path'),
('9670 Ruthberg Way'),
('978 Bart Rd');

-- --------------------------------------------------------

--
-- Table structure for table `fp_stock`
--

CREATE TABLE `fp_stock` (
  `quantity_in_stock` int(11) NOT NULL,
  `shop_address` varchar(30) NOT NULL,
  `jewelry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_stock`
--

INSERT INTO `fp_stock` (`quantity_in_stock`, `shop_address`, `jewelry_id`) VALUES
(1, '111 NW 3rd St', 101),
(1, '111 NW 3rd St', 104),
(1, '122 Birch Ln', 102),
(2, '222 4th St', 103),
(1, '345 SW Mangrove St', 104),
(3, '435 6th St', 105),
(1, '435 6th St', 110),
(1, '435 6th St', 111),
(1, '579 Boltzman Ave', 127),
(1, '645 Lentz Ln', 106),
(2, '645 Lentz Ln', 107),
(1, '789 Oak St', 107),
(1, '789 Oak St', 115),
(1, '789 Oak St', 116),
(1, '789 Oak St', 117),
(1, '789 Oak St', 118),
(2, '887 Lorenz Path', 123),
(1, '978 Bart Rd', 124),
(2, '978 Bart Rd', 125),
(1, '978 Bart Rd', 126);

-- --------------------------------------------------------

--
-- Table structure for table `fp_visits`
--

CREATE TABLE `fp_visits` (
  `shop_address` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_visits`
--

INSERT INTO `fp_visits` (`shop_address`, `customer_id`) VALUES
('111 NW 3rd St', 780044),
('122 Birch Ln', 780055),
('122 Birch Ln', 780057),
('222 4th St', 780050),
('222 4th St', 780061),
('222 4th St', 780068),
('345 SW Mangrove St', 780057),
('579 Boltzman Ave', 780044),
('789 Oak St', 780061),
('887 Lorenz Path', 780042);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fp_customer`
--
ALTER TABLE `fp_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `fp_employee`
--
ALTER TABLE `fp_employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `shop_address` (`shop_address`);

--
-- Indexes for table `fp_jewelry`
--
ALTER TABLE `fp_jewelry`
  ADD PRIMARY KEY (`jewelry_id`),
  ADD KEY `order_number` (`order_number`);

--
-- Indexes for table `fp_order`
--
ALTER TABLE `fp_order`
  ADD PRIMARY KEY (`order_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `fp_order_jewelry`
--
ALTER TABLE `fp_order_jewelry`
  ADD PRIMARY KEY (`jewelry_id`,`order_number`),
  ADD KEY `order_number` (`order_number`);

--
-- Indexes for table `fp_shop`
--
ALTER TABLE `fp_shop`
  ADD PRIMARY KEY (`shop_address`);

--
-- Indexes for table `fp_stock`
--
ALTER TABLE `fp_stock`
  ADD PRIMARY KEY (`shop_address`,`jewelry_id`),
  ADD KEY `jewelry_id` (`jewelry_id`);

--
-- Indexes for table `fp_visits`
--
ALTER TABLE `fp_visits`
  ADD PRIMARY KEY (`shop_address`,`customer_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fp_employee`
--
ALTER TABLE `fp_employee`
  ADD CONSTRAINT `fp_employee_ibfk_1` FOREIGN KEY (`shop_address`) REFERENCES `fp_shop` (`shop_address`);

--
-- Constraints for table `fp_jewelry`
--
ALTER TABLE `fp_jewelry`
  ADD CONSTRAINT `fp_jewelry_ibfk_1` FOREIGN KEY (`order_number`) REFERENCES `fp_order` (`order_number`);

--
-- Constraints for table `fp_order`
--
ALTER TABLE `fp_order`
  ADD CONSTRAINT `fp_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `fp_customer` (`customer_id`);

--
-- Constraints for table `fp_order_jewelry`
--
ALTER TABLE `fp_order_jewelry`
  ADD CONSTRAINT `fp_order_jewelry_ibfk_1` FOREIGN KEY (`order_number`) REFERENCES `fp_order` (`order_number`);

--
-- Constraints for table `fp_stock`
--
ALTER TABLE `fp_stock`
  ADD CONSTRAINT `fp_stock_ibfk_1` FOREIGN KEY (`shop_address`) REFERENCES `fp_shop` (`shop_address`),
  ADD CONSTRAINT `fp_stock_ibfk_2` FOREIGN KEY (`jewelry_id`) REFERENCES `fp_jewelry` (`jewelry_id`);

--
-- Constraints for table `fp_visits`
--
ALTER TABLE `fp_visits`
  ADD CONSTRAINT `fp_visits_ibfk_1` FOREIGN KEY (`shop_address`) REFERENCES `fp_shop` (`shop_address`),
  ADD CONSTRAINT `fp_visits_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `fp_customer` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
