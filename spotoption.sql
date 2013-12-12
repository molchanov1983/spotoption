-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 12 2013 г., 05:05
-- Версия сервера: 5.5.23
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `spotoption`
--
CREATE DATABASE IF NOT EXISTS `spotoption` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `spotoption`;

-- --------------------------------------------------------

--
-- Структура таблицы `calls`
--

CREATE TABLE IF NOT EXISTS `calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Content` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `CustomerId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DAA35C8FBE22D475` (`CustomerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `calls`
--

INSERT INTO `calls` (`id`, `Subject`, `Content`, `CustomerId`) VALUES
(13, 'sdf', 'sdf', 18);

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstNamee` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `FirstNamee`, `LastName`, `Phone`, `Address`, `Status`) VALUES
(18, 'dgf', 'dfg', '4', 'sdf', 4);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `calls`
--
ALTER TABLE `calls`
  ADD CONSTRAINT `FK_DAA35C8FBE22D475` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
