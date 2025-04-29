-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 04:19 PM
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
-- Database: `cineverse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'zeff', '$2y$10$roIb8uk0JAz9RmND15pFzOGgSuiSIVerKlVhioAhW81SduT4.whD6', '2024-12-01 10:42:07'),
(2, 'admin', '$2y$10$9I8p3g6ftpmPfNxJTsd1hOCBd9APuVvatXnIivxdSP/pAIsrFWqRm', '2024-12-01 10:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `showtime_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL COMMENT 'Total amount paid',
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `customer_id`, `showtime_id`, `booking_date`, `total_amount`, `payment_id`) VALUES
(1, 3, 2, '2024-11-30 10:54:56', 4800.00, 4),
(3, 3, 2, '2024-11-30 11:00:44', 1200.00, 6);

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `booking_detail_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`booking_detail_id`, `booking_id`, `seat_id`) VALUES
(1, 1, 11),
(2, 1, 20),
(4, 3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `showtime_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) DEFAULT 0.00,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `cart_detail_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `email`, `phone`, `created_at`, `password`) VALUES
(3, 'abc', 'zeffwastestime@gmail.com', '12311', '2024-11-29 04:24:34', '$2y$10$XugWogyg1VHT2x2GLz6ivOGrMUNBtMTu63OV4LO8TSIrFQ.x0OVFe');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `intro` text DEFAULT NULL COMMENT 'Short introduction of the movie',
  `trailer_link` varchar(255) DEFAULT NULL COMMENT 'Link to the movie trailer',
  `photo_url` varchar(255) DEFAULT NULL COMMENT 'Link to the movie photo',
  `price` int(11) NOT NULL DEFAULT 800,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movie_id`, `title`, `genre`, `release_date`, `duration`, `intro`, `trailer_link`, `photo_url`, `price`, `is_deleted`) VALUES
(1, 'The Dark Knight', 'Action, Crime', '2024-12-19', 152, ' Batman faces off against the Joker, a criminal mastermind who wants to create chaos in Gotham City. The Dark Knight explores the complexities of good and evil.', 'https://www.youtube.com/watch?v=EXeTwQWrcwY', 'assets/images/dark_knight.jpg', 1600, 0),
(2, 'Inception', 'Sci-Fi,Thriller', NULL, 148, ' A thief who enters the dreams of others to steal secrets must perform an inception: planting an idea in someone\'s mind, which leads to a dangerous mission.', 'https://www.youtube.com/watch?v=YoHD9XEInc0', 'assets/images/inception.jpg', 1200, 0),
(3, 'Shawshank', 'Drama, Crime', NULL, 142, 'Andy Dufresne, wrongly convicted of murder, forms an unlikely friendship with fellow inmate Ellis Redding as they navigate life in Shawshank prison.', 'https://www.youtube.com/watch?v=6hB3S9bIaco', 'assets/images/shawshank.jpg', 1000, 1),
(4, 'The Godfather', 'Crime, Drama', NULL, 175, 'The story of the powerful Corleone crime family, as Michael Corleone becomes involved in the world of organized crime, succeeding his father as Don.', 'https://www.youtube.com/watch?v=sY1S34973zA', 'assets/images/godfather.jpg', 1200, 0),
(5, 'The Avengers', 'Action, Sci-Fi', NULL, 143, 'Earth\'s mightiest heroes must come together to stop Loki and his alien army from subjugating the planet in a thrilling battle.', 'https://www.youtube.com/watch?v=eOrNdBpGMv8', 'assets/images/avengers.jpg', 1500, 0),
(6, 'Interstellar', 'Sci-Fi, Adventure', NULL, 169, ' A team of explorers travels through a wormhole in space in an attempt to ensure humanity\'s survival by finding a new habitable planet.', 'https://www.youtube.com/watch?v=zSWdZVtXT7E', 'assets/images/interstellar.jpg', 1800, 0),
(7, 'Gladiator', 'Action, Drama', NULL, 155, 'Maximus, a betrayed Roman general, seeks revenge against the corrupt emperor who murdered his family and sent him into slavery.', 'https://www.youtube.com/watch?v=ol67qo3WhJk', 'assets/images/gladiator.jpg', 800, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) DEFAULT 'pending',
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `total_amount`, `payment_status`, `payment_date`) VALUES
(4, 3, 2400.00, 'true', '2024-11-30 15:54:56'),
(6, 3, 1200.00, 'true', '2024-11-30 16:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `theater_id` int(11) NOT NULL,
  `seat_name` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'empty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seat_id`, `theater_id`, `seat_name`, `status`) VALUES
(8, 1, 'A1', 'empty'),
(9, 1, 'A2', 'empty'),
(10, 1, 'A3', 'empty'),
(11, 1, 'A4', 'empty'),
(12, 1, 'A5', 'empty'),
(13, 1, 'A6', 'empty'),
(14, 1, 'A7', 'empty'),
(15, 1, 'A8', 'empty'),
(16, 1, 'A9', 'empty'),
(17, 1, 'A10', 'empty'),
(18, 1, 'B1', 'empty'),
(19, 1, 'B2', 'empty'),
(20, 1, 'B3', 'empty'),
(21, 1, 'B4', 'empty'),
(22, 1, 'B5', 'empty');

-- --------------------------------------------------------

--
-- Table structure for table `seat_showtime`
--

CREATE TABLE `seat_showtime` (
  `id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `showtime_id` int(11) NOT NULL,
  `status` enum('empty','booked') DEFAULT 'empty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat_showtime`
--

INSERT INTO `seat_showtime` (`id`, `seat_id`, `showtime_id`, `status`) VALUES
(1, 8, 1, 'booked'),
(2, 9, 1, 'booked'),
(3, 10, 1, 'booked'),
(4, 11, 1, 'booked'),
(5, 12, 1, 'booked'),
(6, 13, 1, 'booked'),
(7, 14, 1, 'empty'),
(8, 15, 1, 'empty'),
(9, 16, 1, 'empty'),
(10, 17, 1, 'empty'),
(11, 18, 1, 'booked'),
(12, 19, 1, 'booked'),
(13, 20, 1, 'booked'),
(14, 21, 1, 'booked'),
(15, 22, 1, 'booked'),
(16, 8, 2, 'booked'),
(17, 9, 2, 'booked'),
(18, 10, 2, 'booked'),
(19, 11, 2, 'booked'),
(20, 12, 2, 'booked'),
(21, 13, 2, 'empty'),
(22, 14, 2, 'empty'),
(23, 15, 2, 'empty'),
(24, 16, 2, 'empty'),
(25, 17, 2, 'empty'),
(26, 18, 2, 'booked'),
(27, 19, 2, 'booked'),
(28, 20, 2, 'booked'),
(29, 21, 2, 'booked'),
(30, 22, 2, 'empty'),
(31, 8, 20, 'empty'),
(32, 9, 20, 'empty'),
(33, 10, 20, 'empty'),
(34, 11, 20, 'empty'),
(35, 12, 20, 'empty'),
(36, 13, 20, 'empty'),
(37, 14, 20, 'empty'),
(38, 15, 20, 'empty'),
(39, 16, 20, 'empty'),
(40, 17, 20, 'empty'),
(41, 18, 20, 'empty'),
(42, 19, 20, 'empty'),
(43, 20, 20, 'empty'),
(44, 21, 20, 'empty'),
(45, 22, 20, 'empty');

-- --------------------------------------------------------

--
-- Table structure for table `showtime`
--

CREATE TABLE `showtime` (
  `showtime_id` int(11) NOT NULL,
  `theater_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showtime`
--

INSERT INTO `showtime` (`showtime_id`, `theater_id`, `movie_id`, `show_date`, `start_time`, `end_time`, `is_deleted`) VALUES
(1, 1, 1, '2024-11-26', '15:00:00', '17:20:00', 0),
(2, 1, 2, '2024-11-28', '18:00:00', '20:00:00', 0),
(20, 1, 1, '2024-12-18', '21:08:00', '23:08:00', 0);

--
-- Triggers `showtime`
--
DELIMITER $$
CREATE TRIGGER `after_showtime_insert` AFTER INSERT ON `showtime` FOR EACH ROW BEGIN
    -- Insert into seat_showtime table
    INSERT INTO seat_showtime (seat_id, showtime_id)
    SELECT seat.seat_id, NEW.showtime_id
    FROM seat
    WHERE seat.theater_id = NEW.theater_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `theater_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`theater_id`, `name`, `location`, `capacity`) VALUES
(1, 'Cinema-A', 'Third Floor', 150),
(2, 'Cinema-B', 'Second Floor', 200),
(3, 'Cinema-C', 'First Floor', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `showtime_id` (`showtime_id`),
  ADD KEY `fk_payment_id` (`payment_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`booking_detail_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `showtime_id` (`showtime_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`cart_detail_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `theater_id` (`theater_id`);

--
-- Indexes for table `seat_showtime`
--
ALTER TABLE `seat_showtime`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seat_id` (`seat_id`,`showtime_id`),
  ADD KEY `showtime_id` (`showtime_id`);

--
-- Indexes for table `showtime`
--
ALTER TABLE `showtime`
  ADD PRIMARY KEY (`showtime_id`),
  ADD KEY `theater_id` (`theater_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`theater_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `booking_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `cart_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `seat_showtime`
--
ALTER TABLE `seat_showtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `showtime`
--
ALTER TABLE `showtime`
  MODIFY `showtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `theater_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtime` (`showtime_id`),
  ADD CONSTRAINT `fk_payment_id` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`),
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtime` (`showtime_id`),
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`);

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `cart_details_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_details_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`theater_id`) REFERENCES `theater` (`theater_id`);

--
-- Constraints for table `seat_showtime`
--
ALTER TABLE `seat_showtime`
  ADD CONSTRAINT `seat_showtime_ibfk_1` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seat_showtime_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtime` (`showtime_id`) ON DELETE CASCADE;

--
-- Constraints for table `showtime`
--
ALTER TABLE `showtime`
  ADD CONSTRAINT `showtime_ibfk_1` FOREIGN KEY (`theater_id`) REFERENCES `theater` (`theater_id`),
  ADD CONSTRAINT `showtime_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
