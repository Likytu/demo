-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.4
-- Время создания: Май 25 2026 г., 01:40
-- Версия сервера: 8.4.6
-- Версия PHP: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `primer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `forma`
--

CREATE TABLE `forma` (
  `ID` int NOT NULL,
  `USER` int NOT NULL,
  `BIG_TEXT` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SPISOK` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TEXT` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PHONE` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RATING` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `STATUS` tinyint NOT NULL,
  `DATA` datetime DEFAULT NULL,
  `RADIO` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CHECK` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `AGREE` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `forma`
--

INSERT INTO `forma` (`ID`, `USER`, `BIG_TEXT`, `SPISOK`, `TEXT`, `PHONE`, `RATING`, `STATUS`, `DATA`, `RADIO`, `CHECK`, `AGREE`) VALUES
(9, 6, 'ТекстТекстТекстТекстТекстТекстТекстТекстТекст', 'Вариант1', 'Текст', '+7 (000) 000-00-00', NULL, 2, '2026-05-24 22:00:00', 'Вариант1', 'Вариант1, Вариант2, Вариант4', 1),
(10, 6, 'текст текст текст текст текст текст текст текст текст текст ', 'Вариант4', 'текст', '+7 (000) 000-00-00', NULL, 0, '2026-05-25 00:12:00', 'Вариант3', 'Вариант3', 1),
(11, 1, 'тексттексттексттексттексттексттекст ', 'Вариант2', 'Текст текст ', '+7 (913) 771-27-71', NULL, 1, '2026-05-21 00:14:00', 'Вариант3', 'Вариант1, Вариант4', 1),
(12, 1, 'ТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекстТекст', 'Вариант5', 'ТекстТекст', '+7 (913) 771-27-71', NULL, 2, '2026-05-07 03:17:00', 'Вариант2', 'Вариант1, Вариант2, Вариант3, Вариант4', 1),
(13, 1, 'Текст Текст Текст', 'Вариант3', 'текст Текст', '+7 (913) 771-27-71', 'Отлично', 2, '2026-05-06 19:21:00', 'Вариант1', 'Вариант2, Вариант3', 1),
(14, 1, 'ТекстТекст', 'Вариант4', 'Текст', '+7 (913) 771-27-71', NULL, 0, '2026-05-14 20:39:00', 'Вариант2', 'Вариант4', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int NOT NULL,
  `LOGIN` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NAME` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PHONE` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EMAIL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RANK` tinyint NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `LOGIN`, `NAME`, `PHONE`, `EMAIL`, `PASSWORD`, `RANK`) VALUES
(1, 'admin', 'Тарасова Анастасия Алексеевна', '+7 (913) 771-27-71', 'tarasova@gmail.com', 'password', 90),
(6, 'users1', 'Иванов Иван Иванович', '+7 (000) 000-00-00', 'ivanov@mail.ru', '12345678', 20);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `forma`
--
ALTER TABLE `forma`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER` (`USER`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `forma`
--
ALTER TABLE `forma`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `forma`
--
ALTER TABLE `forma`
  ADD CONSTRAINT `forma_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
