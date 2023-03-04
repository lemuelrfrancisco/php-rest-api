-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 08:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommercedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `size` int(11) NOT NULL DEFAULT 0,
  `price` varchar(11) NOT NULL,
  `image` varchar(256) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `userid`, `name`, `description`, `size`, `price`, `image`, `is_available`) VALUES
(3, 1, 'burger', '', 999, '1', 'uploads/1676887955.jpg', 1),
(5, 1, 'Bottle Water', '', 10000, '1', 'uploads/1677908272.jpg', 1),
(6, 1, 'tea', '', 1, '5', 'uploads/1677912096.jpg', 0),
(7, 1, 'Chocolate', 'description', 5, '1', 'uploads/1677912218.jpg', 0),
(8, 1, 'Popcorn', 'Test popcorn', 100000, '1', 'uploads/1677913227.jpg', 1),
(9, 1, 'Snack', 'Test Snack', 10000, '2', 'uploads/1677913297.jpg', 1),
(10, 1, 'Coffee', 'Test coffee', 100, '4', 'uploads/1677913344.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `rate` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `datetime_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `middleName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `contactNo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstName`, `middleName`, `lastName`, `contactNo`) VALUES
(1, 'test@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'First name', 'Middle name', 'Last Name', '0987654321'),
(5, 'test2@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'First name', 'Middle name', 'Last Name', '0987654321'),
(7, 'test3@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'First name', 'Middle name', 'Last Name', '0987654321'),
(17, 'test1@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'first', 'middle', 'last', '09123123'),
(19, 'test4@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'first', 'middle', 'last', '12312312'),
(20, 'test6@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'f', 'm', 'l', '0912312321');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
