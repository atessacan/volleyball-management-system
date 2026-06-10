-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 10 Haz 2026, 17:32:08
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `volleyball_management_system`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(2, 'Antrenman Saati Değişikliği', 'Bugünkü antrenman saat 18:00 yerine 19:00\'da başlayacaktır.', '2026-06-10 15:06:51'),
(3, 'Takım Toplantısı', 'Cuma günü saat 16:00\'da takım toplantısı yapılacaktır.', '2026-06-10 15:07:07'),
(4, 'Maç Kadrosu', 'Cumartesi günü oynanacak maçın kadrosu açıklanmıştır.', '2026-06-10 15:07:24');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `conditioning_programs`
--

CREATE TABLE `conditioning_programs` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `program_title` varchar(100) NOT NULL,
  `exercises` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `conditioning_programs`
--

INSERT INTO `conditioning_programs` (`id`, `player_id`, `program_title`, `exercises`, `start_date`, `end_date`, `notes`, `created_at`) VALUES
(2, 8, 'Alt Vücut Güç Programı', 'Squat 3x12\r\nLunge 3x10\r\nDeadlift 3x8', '2026-06-10', '2026-06-24', 'Hareketler kontrollü yapılmalıdır.', '2026-06-10 15:21:36'),
(3, 9, 'Patlayıcı Kuvvet Programı', 'Box Jump 3x10\r\nBurpee 3x12\r\nSprint 5x20 m', '2026-06-10', '2026-06-30', 'Egzersiz öncesi ısınma yapılmalıdır.', '2026-06-10 15:22:36'),
(4, 10, 'Dayanıklılık Programı', 'Koşu 20 dk\r\nPlank 3x45 sn\r\nBisiklet 15 dk', '2026-06-10', '2026-07-10', 'Kalp ritmi düzenli takip edilmelidir.', '2026-06-10 15:23:14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `injuries`
--

CREATE TABLE `injuries` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `injury_type` varchar(100) NOT NULL,
  `injury_date` date NOT NULL,
  `treatment_plan` text DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `status` enum('devam ediyor','iyileşti') DEFAULT 'devam ediyor',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `injuries`
--

INSERT INTO `injuries` (`id`, `player_id`, `injury_type`, `injury_date`, `treatment_plan`, `expected_return_date`, `status`, `notes`, `created_at`) VALUES
(2, 9, 'Ayak Bileği Burkulması', '2026-06-15', '', '2026-08-10', 'devam ediyor', 'Fizik tedavi uygulanıyor.', '2026-06-10 15:13:10'),
(3, 8, 'Omuz Zorlanması', '2026-06-12', '', '2026-06-16', 'iyileşti', 'Antrenmanlara kontrollü dönüş yapacak.', '2026-06-10 15:14:12'),
(4, 11, 'Diz Ağrısı', '2026-06-07', '', '2026-06-20', 'devam ediyor', 'MR sonucu bekleniyor.', '2026-06-10 15:15:12');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `nutrition_plans`
--

CREATE TABLE `nutrition_plans` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `plan_title` varchar(100) NOT NULL,
  `meal_plan` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `nutrition_plans`
--

INSERT INTO `nutrition_plans` (`id`, `player_id`, `plan_title`, `meal_plan`, `start_date`, `end_date`, `notes`, `created_at`) VALUES
(2, 8, 'Maç Haftası Beslenme Programı', 'Kahvaltı: Yulaf + Muz\r\nÖğle: Tavuk + Pirinç\r\nAkşam: Balık + Salata', '2026-06-06', '2026-06-13', 'Günde en az 2.5 litre su tüketilmeli.', '2026-06-10 15:18:35'),
(3, 9, 'Yüksek Protein Diyeti', 'Kahvaltı: Omlet\r\nÖğle: Izgara Tavuk\r\nAkşam: Kırmızı Et + Sebze', '2026-06-10', '2026-07-10', 'Antrenman sonrası protein alımı artırılmalı.', '2026-06-10 15:19:41'),
(4, 12, 'Karbonhidrat Yükleme Programı', 'Kahvaltı: Tam Tahıllı Ekmek\r\nÖğle: Makarna + Tavuk\r\nAkşam: Pirinç + Yoğurt', '2026-06-10', '2026-06-24', 'Maçtan önce enerji depolarını doldurmak amaçlanmıştır.', '2026-06-10 15:20:19');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `position` enum('Pasör','Smaçör','Orta Oyuncu','Libero','Pasör Çaprazı') NOT NULL,
  `jersey_number` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `players`
--

INSERT INTO `players` (`id`, `full_name`, `position`, `jersey_number`, `height`, `birth_date`, `created_by`) VALUES
(8, 'Ayşe Yılmaz', 'Pasör', 7, 178, '2001-05-14', 7),
(9, 'Elif Demir', 'Smaçör', 12, 182, '2000-11-22', 7),
(10, 'Zeynep Kaya', 'Libero', 5, 168, '2001-03-09', 7),
(11, 'Buse Çelik', 'Orta Oyuncu', 10, 185, '2000-12-17', 7),
(12, 'Merve Aydın', 'Pasör Çaprazı', 9, 180, '1999-12-11', 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `player_statistics`
--

CREATE TABLE `player_statistics` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `total_serves` int(11) DEFAULT 0,
  `aces` int(11) DEFAULT 0,
  `service_errors` int(11) DEFAULT 0,
  `total_attacks` int(11) DEFAULT 0,
  `attack_kills` int(11) DEFAULT 0,
  `attack_errors` int(11) DEFAULT 0,
  `blocked_attacks` int(11) DEFAULT 0,
  `kill_blocks` int(11) DEFAULT 0,
  `block_errors` int(11) DEFAULT 0,
  `touch_blocks` int(11) DEFAULT 0,
  `total_receptions` int(11) DEFAULT 0,
  `perfect_receptions` int(11) DEFAULT 0,
  `positive_receptions` int(11) DEFAULT 0,
  `reception_errors` int(11) DEFAULT 0,
  `successful_digs` int(11) DEFAULT 0,
  `dig_errors` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `opponent` varchar(100) NOT NULL,
  `match_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `player_statistics`
--

INSERT INTO `player_statistics` (`id`, `player_id`, `total_serves`, `aces`, `service_errors`, `total_attacks`, `attack_kills`, `attack_errors`, `blocked_attacks`, `kill_blocks`, `block_errors`, `touch_blocks`, `total_receptions`, `perfect_receptions`, `positive_receptions`, `reception_errors`, `successful_digs`, `dig_errors`, `created_at`, `opponent`, `match_date`) VALUES
(3, 8, 10, 3, 2, 30, 15, 3, 5, 2, 2, 5, 0, 0, 0, 0, 8, 3, '2026-06-10 15:09:41', 'Vakıfbank', '2026-06-12'),
(4, 9, 18, 3, 2, 25, 14, 5, 3, 4, 2, 6, 30, 22, 6, 2, 8, 2, '2026-06-10 15:10:46', 'Eczacıbaşı', '2026-06-10'),
(5, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 36, 24, 10, 2, 12, 3, '2026-06-10 15:11:19', 'Fenerbahçe', '2026-06-08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('coach','statistician','physiotherapist','conditioner','dietitian') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `training_date` date NOT NULL,
  `training_time` time NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `trainings`
--

INSERT INTO `trainings` (`id`, `title`, `training_date`, `training_time`, `location`, `description`, `created_at`) VALUES
(3, 'Servis Karşılama Çalışması', '2026-06-13', '17:00:00', 'Ana Salon', 'Servis karşılama ve savunma çalışmaları yapılacaktır.', '2026-06-10 15:16:20'),
(4, 'Hücum Organizasyonu', '2026-06-15', '18:00:00', 'Ana Salon', 'Hücum varyasyonları ve blok çalışması yapılacaktır.', '2026-06-10 15:16:51'),
(5, 'Maç Öncesi Hafif Antrenman', '2026-06-17', '16:00:00', 'Fitness Salonu', 'Esneme ve taktik çalışmaları yapılacaktır.', '2026-06-10 15:17:21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('coach','statistician','manager','physiotherapist','conditioner','dietitian') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'beyza', 'atessacanbeyzanur@gmail.com', '$2y$10$iNArdjitpsT5rYw6YTRZpupcRiYm1yfJ/9rHVdgl6oz8NrinJDpJe', 'statistician', '2026-06-09 17:53:01'),
(3, 'gf', 'adsf@hotmail.com', '$2y$10$4jebqd2XwG9rIuNxhIFR9OMvIjnqMeUsg9XQX4KD2SWuH4IuFoH/.', 'manager', '2026-06-10 05:01:57'),
(4, 'b', 'ates@gmail.com', '$2y$10$R3wmb8wP4MnF7pMJG3w0uuriw3GaW20l02HwFk76fcX5bq2pU22Cm', 'statistician', '2026-06-10 06:57:01'),
(5, 'a', 'a@hotmail.com', '$2y$10$NuqQhGOLh.y3wQJnxWlQg.DOAQxqFIu525oUnGXIk5lvxFZavM2Eq', 'manager', '2026-06-10 07:26:41'),
(6, 'c', 'c@hotmail.com', '$2y$10$VQ60Vuq1j5gy9mS54Ivnk.zvjre8fv2DD1DqfzMtZLVWMScKtXgha', 'physiotherapist', '2026-06-10 07:32:19'),
(7, 'm', 'm@gmail.com', '$2y$10$uJdwrbG.via4xTF.PWCBqemV.aJE2EvMy0oFO.1eOUQv3PLbDabHW', 'manager', '2026-06-10 08:28:44'),
(8, 'i', 'i@gmail.com', '$2y$10$exqqDKQ3tK1999Ty.coM.eJXqCR/IQkxAZkHn0cq2JHymrLawxeQ.', 'statistician', '2026-06-10 08:37:31'),
(9, 'a', 'a@gmail.com', '$2y$10$DHNyNF8zdl6UHpPUNKBzTe06PxQUhIm6ZPVDCyGdHT.KIkX6GzMQi', 'coach', '2026-06-10 14:25:35'),
(10, 'd', 'd@gmail.com', '$2y$10$7lK6Ujy.Rl0ovKqp0zVlqOl4qsZ2kI5dyl8nZNbRxHs8gfYDgawze', 'dietitian', '2026-06-10 14:38:03'),
(11, 'k', 'k@gmail.com', '$2y$10$T7g3FuSwOkX9hnr..saWyOAJ8CPLwx4lYlOgyuIc3Jux7OpSqY.di', 'conditioner', '2026-06-10 14:53:24'),
(12, 'f', 'f@gmail.com', '$2y$10$FX3BeS6UFKoMeuAs5f3QqOEwqLEOIdFvVdM7cvYDhaxJg9cAAXxF6', 'physiotherapist', '2026-06-10 15:12:00');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `conditioning_programs`
--
ALTER TABLE `conditioning_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Tablo için indeksler `injuries`
--
ALTER TABLE `injuries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Tablo için indeksler `nutrition_plans`
--
ALTER TABLE `nutrition_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Tablo için indeksler `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_player` (`full_name`,`jersey_number`),
  ADD KEY `created_by` (`created_by`);

--
-- Tablo için indeksler `player_statistics`
--
ALTER TABLE `player_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_match_statistics` (`player_id`,`opponent`,`match_date`);

--
-- Tablo için indeksler `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `conditioning_programs`
--
ALTER TABLE `conditioning_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `injuries`
--
ALTER TABLE `injuries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `nutrition_plans`
--
ALTER TABLE `nutrition_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `player_statistics`
--
ALTER TABLE `player_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `conditioning_programs`
--
ALTER TABLE `conditioning_programs`
  ADD CONSTRAINT `conditioning_programs_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);

--
-- Tablo kısıtlamaları `injuries`
--
ALTER TABLE `injuries`
  ADD CONSTRAINT `injuries_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `nutrition_plans`
--
ALTER TABLE `nutrition_plans`
  ADD CONSTRAINT `nutrition_plans_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);

--
-- Tablo kısıtlamaları `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `player_statistics`
--
ALTER TABLE `player_statistics`
  ADD CONSTRAINT `player_statistics_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
