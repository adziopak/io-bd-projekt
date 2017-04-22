-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql.cba.pl
-- Czas generowania: 22 Kwi 2017, 20:40
-- Wersja serwera: 10.0.30-MariaDB-300+deb8u1
-- Wersja PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `skkshowcase`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `maps`
--

CREATE TABLE `maps` (
  `id` int(11) NOT NULL,
  `floor` int(45) NOT NULL,
  `image` varchar(45) NOT NULL,
  `image_md5` int(11) NOT NULL,
  `map_width` int(11) NOT NULL,
  `map_height` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `editor_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `maps`
--

INSERT INTO `maps` (`id`, `floor`, `image`, `image_md5`, `map_width`, `map_height`, `building_id`, `editor_id`) VALUES
(1, 0, 'v0.png', 0, 1470, 1086, 1, 0),
(2, 1, 'v1.png', 0, 1500, 1231, 1, 0),
(3, 2, 'v2.png', 0, 1500, 1239, 1, 0),
(4, 3, 'v3.png', 0, 1500, 1236, 1, 0),
(5, 4, 'v4.png', 0, 1500, 1238, 1, 0),
(6, 0, 's0.png', 0, 1346, 830, 2, 0),
(7, 0, 's1.png', 0, 1344, 838, 2, 0),
(9, 1, 'j1.png', 0, 737, 1500, 3, 0),
(8, 0, 'j0.png', 0, 940, 1500, 3, 0),
(10, 2, 'j2.png', 0, 740, 1500, 3, 0),
(11, 3, 'j3.png', 0, 740, 1500, 3, 0),
(12, 0, 'p0.png', 0, 1500, 1448, 4, 0),
(13, 1, 'p1.png', 0, 1456, 1500, 4, 0),
(14, 2, 'p2.png', 0, 1439, 1500, 4, 0),
(15, 3, 'p3.png', 0, 1463, 1500, 4, 0),
(16, 4, 'p4.png', 0, 1474, 1500, 4, 0),
(17, 5, 'p5.png', 0, 1459, 1500, 4, 0),
(18, 6, 'p6.png', 0, 1461, 1500, 4, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `building_id_2` (`building_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
