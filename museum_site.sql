-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Трв 20 2025 р., 14:50
-- Версія сервера: 9.1.0
-- Версія PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `museum_site`
--

-- --------------------------------------------------------

--
-- Структура таблиці `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `value`, `updated_at`) VALUES
(1, 'Адреса', 'м. Київ, вул. Музейна, 12', '2025-05-19 10:56:24'),
(2, 'Телефон', '+380441234567', '2025-05-19 10:56:24'),
(3, 'Email', 'info@museum.ua', '2025-05-19 10:56:24'),
(4, 'Map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2551.529852536302!2d28.6339366760475!3d50.2446876021584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x472c6493ebf252ed%3A0xc400e72454e33b55!2z0JTQtdGA0LbQsNCy0L3QuNC5INGD0L3RltCy0LXRgNGB0LjRgtC10YIgwqvQltC40YLQvtC80LjRgNGB0YzQutCwINC_0L7Qu9GW0YLQtdGF0L3RltC60LDCuw!5e0!3m2!1suk!2sua!4v1747640415651!5m2!1suk!2sua', '2025-05-20 17:24:44');

-- --------------------------------------------------------

--
-- Структура таблиці `exhibitions`
--

DROP TABLE IF EXISTS `exhibitions`;
CREATE TABLE IF NOT EXISTS `exhibitions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `type_id` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `exhibitions`
--

INSERT INTO `exhibitions` (`id`, `title`, `description`, `type_id`, `start_date`, `end_date`, `created_at`) VALUES
(13, 'Скарби трипільської культури', '<p>Експозиція, присвячена культурі Трипілля.</p>', 4, NULL, NULL, '2025-05-19 09:55:49'),
(14, 'Сучасне мистецтво України', 'Виставка сучасних українських художників.', 5, '2025-06-01', '2025-09-01', '2025-05-19 09:55:49'),
(15, 'Інтерактивна VR-виставка', 'Цифрова подорож у світ стародавніх цивілізацій.', 6, '2025-07-15', '2025-10-15', '2025-05-19 09:55:49');

-- --------------------------------------------------------

--
-- Структура таблиці `exhibition_images`
--

DROP TABLE IF EXISTS `exhibition_images`;
CREATE TABLE IF NOT EXISTS `exhibition_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exhibition_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exhibition_id` (`exhibition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `exhibition_images`
--

INSERT INTO `exhibition_images` (`id`, `exhibition_id`, `image_path`, `created_at`) VALUES
(13, 13, '/public/images/exhibitions/trypillya_1.jpg', '2025-05-19 14:14:39'),
(14, 13, '../public/images/exhibitions/trypillya_2.jpg', '2025-05-19 14:14:39'),
(15, 13, '../public/images/exhibitions/trypillya_3.jpg', '2025-05-19 14:14:39');

-- --------------------------------------------------------

--
-- Структура таблиці `exhibition_types`
--

DROP TABLE IF EXISTS `exhibition_types`;
CREATE TABLE IF NOT EXISTS `exhibition_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `exhibition_types`
--

INSERT INTO `exhibition_types` (`id`, `name`) VALUES
(4, 'Постійна виставка'),
(5, 'Тимчасова виставка'),
(6, 'Цифрова експозиція');

-- --------------------------------------------------------

--
-- Структура таблиці `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Іван Петренко', 'ivan@example.com', 'Дуже сподобалась виставка Трипілля! Дякую!', '2025-05-19 09:52:55'),
(2, 'Олена Іванова', 'olena@example.com', 'Чи буде доступна VR-виставка для дітей молодшого віку?', '2025-05-19 09:52:55');

-- --------------------------------------------------------

--
-- Структура таблиці `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `news`
--

INSERT INTO `news` (`id`, `title`, `excerpt`, `content`, `image`, `published_at`, `created_at`) VALUES
(1, 'День відкритих дверей у музеї', '1 червня музей відкриває свої двері для всіх охочих з безкоштовним входом.', '<p>1 червня музей відкриває свої двері для всіх охочих з безкоштовним входом.</p><p>&nbsp;</p><ul><li>сфва</li><li>пі ірвап</li><li>авфа</li><li>фавафа</li></ul>', '../public/images/news/openDoors.png', '2025-05-19 09:52:55', '2025-05-19 09:52:55'),
(2, 'Нова VR-виставка вже доступна', 'Запрошуємо відвідати нашу нову цифрову експозицію!', 'Запрошуємо відвідати нашу нову цифрову експозицію!', '../public/images/news/vr.png', '2025-05-19 09:52:55', '2025-05-19 09:52:55'),
(9, 'йййй', 'івпвіп', '<p>впвіп<strong>пвіп ві</strong></p><ul><li><strong>авф ааіфаіфа</strong></li><li><strong>прґ</strong></li></ul>', '../public/images/news/682c7a6a9479d.jpg', '2025-05-20 15:46:50', '2025-05-20 15:46:50');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isSuperAdmin` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `isSuperAdmin`, `created_at`) VALUES
(3, 'admin', '123456', 1, '2025-05-19 16:14:23');

-- --------------------------------------------------------

--
-- Структура таблиці `visitor_info`
--

DROP TABLE IF EXISTS `visitor_info`;
CREATE TABLE IF NOT EXISTS `visitor_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `visitor_info`
--

INSERT INTO `visitor_info` (`id`, `category`, `content`, `updated_at`) VALUES
(1, 'Графік роботи', '<ul>\r\n    <li>Понеділок — П’ятниця: <strong>10:00 – 18:00</strong></li>\r\n    <li>Субота — Неділя: <strong>11:00 – 17:00</strong></li>\r\n    <li>Вихідний: <strong>вівторок</strong></li>\r\n</ul>', '2025-05-19 10:50:19'),
(2, 'Ціни на квитки', '<ul>\r\n    <li>Дорослі: <strong>100 грн</strong></li>\r\n    <li>Діти до 12 років: <strong>50 грн</strong></li>\r\n    <li>Студенти: <strong>70 грн</strong></li>\r\n    <li>Пенсіонери: <strong>70 грн</strong></li>\r\n    <li>Групові екскурсії: <strong>договірна</strong></li>\r\n</ul>', '2025-05-19 10:50:19'),
(3, 'Правила відвідування', '<ul>\r\n    <li>Фотографування дозволено <strong>без спалаху</strong>.</li>\r\n    <li>Не торкайтеся експонатів.</li>\r\n    <li>Заборонено вхід з їжею та напоями.</li>\r\n    <li>Будьте тихими, поважайте інших відвідувачів.</li>\r\n    <li>Діти до 12 років повинні бути у супроводі дорослих.</li>\r\n</ul>', '2025-05-19 10:50:19'),
(4, 'Як дістатися', '<p>Музей розташований за адресою: <strong>м. Київ, вул. Музейна, 12</strong></p><p>Найближча станція метро: <strong>Поштова площа</strong>.</p><p>Громадський транспорт:</p><ul><li>Маршрутне таксі №5, №18</li><li>Автобус №24</li><li>Тролейбус №14</li></ul><p><a href=\"https://maps.google.com/?q=вул.+Музейна,+12,+Київ\">Переглянути на мапі</a></p>', '2025-05-20 16:52:15');

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `exhibitions`
--
ALTER TABLE `exhibitions`
  ADD CONSTRAINT `exhibitions_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `exhibition_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Обмеження зовнішнього ключа таблиці `exhibition_images`
--
ALTER TABLE `exhibition_images`
  ADD CONSTRAINT `exhibition_images_ibfk_1` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
