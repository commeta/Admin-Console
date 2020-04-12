-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 13 2020 г., 02:43
-- Версия сервера: 5.5.64-MariaDB
-- Версия PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `admin_console`
--

-- --------------------------------------------------------

--
-- Структура таблицы `md_meta`
--

CREATE TABLE IF NOT EXISTS `md_meta` (
  `meta_id` int(11) NOT NULL,
  `friendly_url` varchar(256) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_h1` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_text` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `md_meta`
--

INSERT INTO `md_meta` (`meta_id`, `friendly_url`, `meta_title`, `meta_h1`, `meta_description`, `meta_keywords`, `meta_text`, `content`, `image`) VALUES
(1, '/index.html', 'Главная meta_title', 'Главная meta_h1', 'Главная meta_description', 'Главная meta_description', 'Главная meta_text', 'Главная content', ''),
(7, '/price.html', 'Прайс', '', '', '', '', '', 'undefined');

-- --------------------------------------------------------

--
-- Структура таблицы `md_users`
--

CREATE TABLE IF NOT EXISTS `md_users` (
  `user_id` int(11) NOT NULL,
  `role` int(11) NOT NULL COMMENT '0 - пользователь, 1 - админ',
  `login` varchar(255) NOT NULL COMMENT 'E-mail',
  `password` varchar(255) NOT NULL,
  `reg_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `gender` int(1) NOT NULL COMMENT '0 - не указан, 1 - М, 2 - Ж',
  `birthday` date NOT NULL,
  `phone` varchar(255) NOT NULL,
  `photo_url` varchar(500) NOT NULL,
  `news_check` int(1) NOT NULL COMMENT 'Согласие на получение рассылки'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `md_users`
--

INSERT INTO `md_users` (`user_id`, `role`, `login`, `password`, `reg_datetime`, `name`, `surname`, `patronymic`, `gender`, `birthday`, `phone`, `photo_url`, `news_check`) VALUES
(1, 1, 'admin', '099e2b0784894dcdf96531488cf8a6fc', '2020-02-15 01:59:13', 'Администратор', '', '', 0, '1981-11-09', '', 'files/user_upload/photo-10.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `md_users_login`
--

CREATE TABLE IF NOT EXISTS `md_users_login` (
  `user_login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  `login_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xauthtoken` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `md_meta`
--
ALTER TABLE `md_meta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `friendly_url` (`friendly_url`);

--
-- Индексы таблицы `md_users`
--
ALTER TABLE `md_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `md_users_login`
--
ALTER TABLE `md_users_login`
  ADD PRIMARY KEY (`user_login_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `key` (`key`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `md_meta`
--
ALTER TABLE `md_meta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `md_users`
--
ALTER TABLE `md_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `md_users_login`
--
ALTER TABLE `md_users_login`
  MODIFY `user_login_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
