-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 09:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `description`, `status`, `created_at`) VALUES
(1, 'Cây nội thất', 'Cây trang trí trong nhà', 1, '2025-05-22 21:46:33'),
(2, 'Cây để bàn', 'Cây mini để bàn làm việc', 1, '2025-05-22 21:46:33'),
(3, 'Sen đá', 'Các loại sen đá xinh xắn', 1, '2025-05-22 21:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `manufacturer_id` int(11) NOT NULL,
  `manufacturer_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`manufacturer_id`, `manufacturer_name`) VALUES
(1, 'GreenLife Co.'),
(2, 'Happy Garden'),
(3, 'Nature House');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Đang chờ','Đã xác nhận','Đã giao','Đã hủy') DEFAULT NULL,
  `Customer_name` varchar(256) NOT NULL,
  `Customer_numberphone` varchar(256) NOT NULL,
  `Customer_address` varchar(256) NOT NULL,
  `payment_method` enum('banking','cod') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `Customer_name`, `Customer_numberphone`, `Customer_address`, `payment_method`) VALUES
(3, 5, '2025-05-25 17:13:37', 300000.00, 'Đã giao', 'Sang 1', '0111111111', 'Thốt Nốt Cần Thơ', 'banking'),
(4, 5, '2025-05-25 17:13:53', 9000000.00, 'Đang chờ', 'Sang 2', '022222222', 'Thốt Nốt Cần Thơ 2', 'banking'),
(5, 5, '2025-05-25 17:14:04', 22222222.00, 'Đang chờ', 'Sang 3', '0333333333', 'Thốt Nốt Cần Thơ 3', 'banking'),
(6, 5, '2025-05-25 18:36:13', 433332.00, 'Đã hủy', 'sangnp', '0999887766', '103A Bình Thới, Phường 11, Quận 11, TP. HCM', 'cod'),
(7, 5, '2025-05-25 18:36:50', 3693639.00, 'Đang chờ', 'sangnp', '0999887766', '103A Bình Thới, Phường 11, Quận 11, TP. HCM', 'banking'),
(8, 5, '2025-05-25 18:37:31', 122222.00, 'Đang chờ', 'sangnp', '0999887766', '103A Bình Thới, Phường 11, Quận 11, TP. HCM', 'banking');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(4, 3, 20, 2, 333333.00),
(5, 4, 19, 22, 33333.00),
(6, 4, 13, 33, 222222.00),
(7, 5, 15, 34444, 99999999.99),
(8, 5, 9, 12, 200000.00),
(9, 5, 18, 25, 999999.00),
(10, 6, 23, 3, 122222.00),
(11, 6, 20, 3, 22222.00),
(12, 7, 19, 3, 1231213.00),
(13, 8, 23, 1, 122222.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `imageURL` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `category_id`, `manufacturer_id`, `stock`, `created_at`, `imageURL`) VALUES
(9, 'Cây Con Cặc', 30000000.00, 2, 1, NULL, '2025-05-23 07:25:12', 'cay-ngoc-bich-nho-super-white-2-768x768.jpg'),
(10, 'Cây cái lồn', 9000000.00, 1, 1, NULL, '2025-05-23 07:32:34', 'ngocbi.jpg'),
(11, 'Cây con cua', 99999999.99, 1, 2, NULL, '2025-05-24 23:57:27', '2038854.png'),
(12, 'Cây con cá sấu', 23232323.00, 2, 2, NULL, '2025-05-25 00:10:50', 'cay-chuoi-ngoc-bi.jpg'),
(13, 'Con cò biết bơi', 223333.00, 2, 2, NULL, '2025-05-25 00:11:20', 'Screenshot 2025-03-07 224240.png'),
(14, 'Hai con thằng lằn', 5555555.00, 1, 2, NULL, '2025-05-25 00:11:50', 'cay-ngoc-bich-nho-super-white-2-768x768.jpg'),
(15, 'Eimi-Fukada', 122222.00, 3, 3, NULL, '2025-05-25 00:12:20', 'Screenshot 2025-03-02 132200.png'),
(16, 'Yua Mikami', 1111111.00, 2, 3, NULL, '2025-05-25 00:12:42', 'trúc phú quý.jpg'),
(17, 'Momo Sakura', 88888888.00, 2, 2, NULL, '2025-05-25 00:15:24', '6831feace5652.jpg'),
(18, 'NKYD_954', 1211111.00, 1, 2, NULL, '2025-05-25 00:15:55', '6831fecb5de47.png'),
(19, 'Con cặc ba mày', 1231213.00, 2, 3, NULL, '2025-05-25 00:35:59', '6832037f96c30.png'),
(20, 'Chao mẹ bạn nha', 22222.00, 2, 2, NULL, '2025-05-25 16:10:56', 'product_n9crHiTvU7.ccc'),
(21, 'Vãi Luôn', 9000000.00, 1, 3, NULL, '2025-05-25 16:11:30', 'product_GFiBmLbNep.jpg'),
(22, 'Con cá leo cây', 555555.00, 3, 2, NULL, '2025-05-25 16:20:53', 'product_F7CJd8lQVH.jpg'),
(23, 'Cây sen đá', 122222.00, 1, 3, NULL, '2025-05-25 20:20:00', 'product_IpY5er3PWl.png'),
(24, 'NADS-332', 1500000.00, 2, 2, NULL, '2025-05-26 22:54:57', 'product_93SPVNueB1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `number_phone` varchar(10) NOT NULL,
  `address` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `created_at`, `number_phone`, `address`) VALUES
(5, 'sangnp', '$2y$10$CnMepwcw3q8kFsKfUmuU4eT6LgmfRygQ47Wkdie8Oh8GNTs3AxqN6', 'phuocnsang@gmail.com', '2025-05-22 23:32:08', '0999887766', '103A Bình Thới, Phường 11, Quận 11, TP. HCM'),
(16, 'sangnp123', 'ssssssssss', 'truntrun@gmail.com', '2025-05-26 21:55:03', '0999999999', '12 aaaa'),
(17, 'sangnp2222', '$2y$10$CnMepwcw3q8kFsKfUmuU4eT6LgmfRygQ47Wkdie8Oh8GNTs3AxqN6', 'sang@gmail.com', '2025-05-26 21:55:59', '9384637444', '130a hcm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`manufacturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
