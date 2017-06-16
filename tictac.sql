-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29 Mai 2017 la 00:03
-- Versiune server: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tictac`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Salvarea datelor din tabel `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Timex'),
(2, 'Casio'),
(3, 'Hamilton'),
(4, 'Fossil'),
(5, 'Police'),
(7, 'Atlantic'),
(8, 'Orient');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Salvarea datelor din tabel `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`) VALUES
(1, '[{\"id\":\"9\",\"quantity\":\"1\"}]', '2017-06-26 20:46:35', 0),
(2, '[{\"id\":\"9\",\"quantity\":\"1\"}]', '2017-06-26 20:46:46', 0),
(7, '[{\"id\":\"16\",\"quantity\":\"6\"}]', '2017-06-27 00:27:43', 0),
(8, '[{\"id\":\"17\",\"quantity\":\"1\"}]', '2017-06-27 01:21:15', 0),
(9, '[{\"id\":\"1\",\"quantity\":\"1\"}]', '2017-06-27 02:14:47', 0),
(10, '[{\"id\":\"16\",\"quantity\":1},{\"id\":\"1\",\"quantity\":\"1\"}]', '2017-06-27 09:33:44', 1),
(11, '[{\"id\":\"1\",\"quantity\":\"4\"}]', '2017-06-27 11:16:21', 1),
(12, '[{\"id\":\"3\",\"quantity\":\"2\"},{\"id\":\"1\",\"quantity\":2}]', '2017-06-27 11:46:28', 0),
(13, '[{\"id\":\"1\",\"quantity\":\"1\"}]', '2017-06-27 11:55:38', 0),
(14, '[{\"id\":\"15\",\"quantity\":\"1\"}]', '2017-06-27 18:05:34', 0),
(15, '[{\"id\":\"16\",\"quantity\":\"1\"},{\"id\":\"1\",\"quantity\":\"3\"}]', '2017-06-27 22:33:03', 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Salvarea datelor din tabel `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Barbati', 0),
(2, 'Dama', 0),
(3, 'Ceasuri', 1),
(4, 'Curele', 1),
(5, 'Ceasuri', 2),
(6, 'Curele', 2);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `oferta` tinyint(4) NOT NULL DEFAULT '0',
  `qty` int(11) DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Salvarea datelor din tabel `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `oferta`, `qty`, `deleted`) VALUES
(1, 'Ceas Hamilton', '29.99', '39.99', 3, '3', '/_webProject/images/hamilton.jpg', 'Acest ceas are un design unic, este facut sa reziste sub apa, pana la 3 atm. Cadranul are cristale bla bla si este la oferta, deci cumpara-l!', 1, 46, 0),
(2, 'Ceas Police ass', '199.99', '500.00', 5, '3', '/_webProject/images/police_b_1.jpeg', 'Acest ceas este conceput pentru sportivitate...bla bla', 1, 565, 0),
(3, 'Ceas Police a', '189.99', '500.00', 5, '3', '/_webProject/images/police_b_2.jpeg', 'Acest ceas este conceput pentru sportivitate...bla bla', 0, 77, 0),
(4, 'Ceas Police b', '89.99', '500.00', 5, '3', '/_webProject/images/police_b_3.jpeg', 'Acest ceas este conceput pentru sportivitate...bla bla', 0, 77, 0),
(6, 'Ceas Atlantic b', '229.99', '500.00', 7, '3', '/_webProject/images/atlantic_B_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 77, 0),
(7, 'Ceas Atlantic c', '500.00', '500.00', 7, '3', '/_webProject/images/atlantic_B_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 33, 1),
(8, 'Ceas Casio sa', '221.99', '500.00', 2, '3', '/_webProject/images/casio_b_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 33, 1),
(9, 'Ceas Casio ss', '321.99', '500.00', 2, '3', '/_webProject/images/casio_b_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 33, 1),
(10, 'Ceas Casio cj', '211.99', '500.00', 2, '3', '/_webProject/images/casio_b_3.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 12, 1),
(11, 'Ceas Casio dss', '221.99', '500.00', 2, '3', '/_webProject/images/casio_b_4.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 312, 0),
(12, 'Ceas Casio b', '121.99', '300.00', 2, '3', '/_webProject/images/casio_b_4.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 54, 0),
(13, 'Ceas Fossil a', '333.99', '500.00', 7, '3', '/_webProject/images/fossil_b_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 45, 0),
(14, 'Ceas timex b', '113.99', '500.00', 1, '3', '/_webProject/images/timex_b_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 5453, 0),
(15, 'Ceas timex b', '1.00', '500.00', 1, '3', '/_webProject/images/timex_B_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 54, 0),
(16, 'Ceas timex f', '221.99', '520.00', 1, '5', '/_webProject/images/timex_f_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 0, 76, 0),
(17, 'Ceas timex f', '421.99', '520.00', 1, '5', '/_webProject/images/timex_f_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 44, 0),
(18, 'Ceas timex ss', '321.99', '520.00', 1, '5', '/_webProject/images/timex_f_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 44, 0),
(19, 'Ceas timex sf', '331.99', '520.00', 1, '5', '/_webProject/images/timex_f_5.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 66, 0),
(20, 'Ceas Casio saf', '171.99', '520.00', 2, '5', '/_webProject/images/sadasd.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 45, 0),
(21, 'Ceas Casio saf', '122.99', '520.00', 2, '5', '/_webProject/images/casio_f_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 3, 0),
(22, 'Ceas Fossil sadsa', '199.99', '520.00', 4, '5', '/_webProject/images/fossil_f_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 3, 0),
(23, 'Ceas Fossil sadsa', '149.99', '520.00', 4, '5', '/_webProject/images/fossil_f_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 54, 0),
(24, 'Ceas Fossil saaadsa', '249.99', '520.00', 4, '5', '/_webProject/images/fossil_f_3.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 6, 0),
(25, 'Ceas Police sadsa', '449.99', '520.00', 5, '5', '/_webProject/images/police_f_1.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 54, 1),
(26, 'Ceas Police saaadsdsa', '349.99', '520.00', 5, '5', '/_webProject/images/police_f_2.jpeg', 'Acest ceas este conceput pentru eleganta...bla bla', 1, 45, 0),
(27, '212s', '1.00', '1.00', 2, '5', '/_webProject/images/sadasd.jpeg', '', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(123) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(123) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(123) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(123) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(123) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(123) COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `txn_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Salvarea datelor din tabel `transactions`
--

INSERT INTO `transactions` (`id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `txn_data`) VALUES
(2, 10, 'asd', 'allex.iuga@gmail.com', 'str randunelelor nr 133', 'ads', 'Viseu de sus', 'maramures', '37500', 'asd', '251.98', '0.00', '251.98', '2017-05-28 01:48:02'),
(3, 0, 'asd', 'allex.iuga@gmail.com', 'str randunelelor nr 133', 'ads', 'Viseu de sus', 'maramures', '37500', 'asd', '0.00', '0.00', '0.00', '2017-05-28 01:48:31'),
(4, 11, 'ad', 'allex.iuga@gmail.com', 'str randunelelor nr 133', 'a', 'Viseu de sus', 'maramures', '37500', 'a', '119.96', '0.00', '119.96', '2017-05-28 02:19:50'),
(5, 15, 'Alexandru Grigore', 'web@user.ro', 'cosbuc', '29', 'sector 5', 'Bucuresti', '375100', 'Romania', '311.96', '0.00', '311.96', '2017-05-28 13:49:16'),
(6, 15, 'Alexandru Grigore', 'web@user.ro', 'cosbuc', '29', 'sector 5', 'Bucuresti', '375100', 'Romania', '311.96', '0.00', '311.96', '2017-05-28 13:49:16');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `adresa` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'activ',
  `permissions` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `telefon`, `adresa`, `password`, `status`, `permissions`, `last_login`, `join_date`) VALUES
(1, 'Iuga Alexandru', 'admin@tictac.ro', '0', 'bv george cosbuc nr 39-49', '$2y$10$kL65smRcvdqm.S9Tuk71PuyymmUYHAJkHnwPDZiAi69zk6qMlaPNC', 'activ', 'admin,edit', '2017-05-29 05:40:37', '2017-05-21 08:38:48'),
(9, 'Tehnologii WEB', 'web@admin.ro', '0658265268', 'ATM', '$2y$10$Ow7IUvZCUwI17XyNyh5Zq.bp5a9jnI/ZBHM.R6InF4042FCZoJoVK', 'activ', 'admin, editor', '2017-05-29 06:31:38', '2017-05-28 20:42:30'),
(11, 'Tehnologii WEB', 'web@user.ro', '34324', 'ATM', '$2y$10$LjslVf5ErozRVW/nWq4I2uvIRVq39tdFwq6jKj0NwsRiPDvjIQgW2', 'activ', 'user', '2017-05-29 06:51:37', '2017-05-28 20:44:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
