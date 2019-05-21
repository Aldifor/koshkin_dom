-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 23 2019 г., 17:25
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cat_house`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `new_id`, `us_id`, `message`, `date`) VALUES
(1, 8, 3, '12324werewrwerterfgsdfgsegrewrsgdsdgfdg', '2019-03-02 18:00:00'),
(2, 8, 18, 'sadsad', '2019-03-02 17:00:42'),
(3, 8, 18, 'eeq&nbsp; ', '2019-03-02 17:01:10'),
(4, 12, 18, 'asdsd', '2019-03-02 17:09:21'),
(5, 11, 18, 'qweqwe', '2019-03-02 17:13:17'),
(6, 11, 18, ' ', '2019-03-02 17:13:26'),
(7, 11, 18, '  ', '2019-03-02 17:13:42'),
(8, 11, 18, '\n                  ', '2019-03-03 07:05:40'),
(9, 10, 18, 'wqev qwed awesdffs d:standart-6: ', '2019-03-03 07:13:55'),
(10, 10, 18, ':standart-8: ', '2019-03-03 07:14:03'),
(11, 10, 18, '\n                :standart-4: ', '2019-03-03 07:14:50'),
(12, 10, 18, '\n                :standart-6: ', '2019-03-03 07:15:21'),
(13, 13, 3, 'wqewerwer ADS asd:standart-5: ', '2019-03-07 10:27:49'),
(14, 13, 3, ':standart-12: :pigs-41: :monkeys-43: :monkeys-47: :monkeys-48: ', '2019-03-07 10:28:02');

-- --------------------------------------------------------

--
-- Структура таблицы `kos_list`
--

CREATE TABLE `kos_list` (
  `id` int(11) NOT NULL,
  `nicname` varchar(9) NOT NULL,
  `prof` int(11) NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_us` int(11) NOT NULL DEFAULT '0',
  `to_us` int(11) NOT NULL DEFAULT '0',
  `general` int(11) NOT NULL DEFAULT '0',
  `gild` int(11) NOT NULL DEFAULT '0',
  `private` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `nameNav` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `href` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `navbar`
--

INSERT INTO `navbar` (`id`, `nameNav`, `name`, `href`) VALUES
(1, 'index', 'Главная', '/'),
(2, 'abclan', 'О Клане', '/abclan'),
(4, 'news', 'Новости', '/news'),
(5, 'communication', 'Общение', '/communication'),
(6, 'useful', 'Полезное', '/useful'),
(7, 'voiseservis', 'Голосовой чат', '/voiseservis'),
(8, 'admin', 'Админка', '/admin');

-- --------------------------------------------------------

--
-- Структура таблицы `navbar_admin`
--

CREATE TABLE `navbar_admin` (
  `id` int(10) NOT NULL,
  `nameNav` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `href` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `navbar_admin`
--

INSERT INTO `navbar_admin` (`id`, `nameNav`, `name`, `href`) VALUES
(1, 'creat-news', 'Создать новость', '/admin/creat-news'),
(2, 'list-users', 'Список пользователей', '/admin/list-users'),
(3, 'cos', 'Кос лист', '/admin/kos');

-- --------------------------------------------------------

--
-- Структура таблицы `new`
--

CREATE TABLE `new` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `img` varchar(50) DEFAULT NULL,
  `creat_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `item_post` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `item_post`) VALUES
(1, 'Рядовой'),
(2, 'Капитан'),
(3, 'Майор'),
(4, 'Маршл'),
(5, 'Мастер');

-- --------------------------------------------------------

--
-- Структура таблицы `profations`
--

CREATE TABLE `profations` (
  `id` int(11) NOT NULL,
  `prof_name` varchar(10) NOT NULL,
  `prof_icon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `profations`
--

INSERT INTO `profations` (`id`, `prof_name`, `prof_icon`) VALUES
(1, 'Вар', '/img/prof/1.png'),
(2, 'Маг', '/img/prof/2.png'),
(3, 'Друид', '/img/prof/3.png'),
(4, 'Оборотень', '/img/prof/4.png'),
(5, 'Жрец', '/img/prof/5.png'),
(6, 'Лучник', '/img/prof/6.png'),
(7, 'Мистик', '/img/prof/7.png'),
(8, 'Страж', '/img/prof/8.png'),
(9, 'Убийца', '/img/prof/9.png'),
(10, 'Шаман', '/img/prof/10.png'),
(11, 'Жнец', '/img/prof/11.png'),
(12, 'Призрак', '/img/prof/12.png');

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `test` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`id`, `test`) VALUES
(1, '4_214m-eaSk.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `new_user` tinyint(1) NOT NULL DEFAULT '1',
  `admit` tinyint(1) NOT NULL DEFAULT '0',
  `is_party` tinyint(1) NOT NULL DEFAULT '0',
  `profation` int(2) NOT NULL DEFAULT '1',
  `post` int(1) NOT NULL DEFAULT '1',
  `root` varchar(10) NOT NULL DEFAULT 'user',
  `login` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nicname` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(50) NOT NULL,
  `usericon` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`new_user`, `admit`, `is_party`, `profation`, `post`, `root`, `login`, `name`, `nicname`, `email`, `usericon`, `password`, `id`) VALUES
(0, 1, 1, 11, 1, 'admin', 'qwerty@mal.ru', 'Максим', '\"Эльфийк@', 'qwerty@mal.ru', '', '202cb962ac59075b964b07152d234b70', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kos_list`
--
ALTER TABLE `kos_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `navbar_admin`
--
ALTER TABLE `navbar_admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `new`
--
ALTER TABLE `new`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `profations`
--
ALTER TABLE `profations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `kos_list`
--
ALTER TABLE `kos_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `navbar_admin`
--
ALTER TABLE `navbar_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `new`
--
ALTER TABLE `new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `profations`
--
ALTER TABLE `profations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
