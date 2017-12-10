-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 10 2017 г., 11:56
-- Версия сервера: 5.7.19-0ubuntu0.16.04.1
-- Версия PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_maslennikov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday_date` bigint(20) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `name`, `surname`, `patronymic`, `position`, `sex`, `pass`, `phone`, `email`, `birthday_date`, `is_deleted`) VALUES
(1, 'Ксения', 'Цукерка', 'Сергеевна', 'Бухгалтер', 'Женский', '1431 096854', '+7 (123) 11-18-443', 'cuker@mail.com', 596228400, 0),
(2, 'Джон', 'Константиновский', 'Константин', 'Профессиональный экзорцист', 'Мужской', '1234 321091', '+7 (908) 98-44-999', 'saint@gmail.com', 546807600, 0),
(3, 'Гай', 'Юлий', 'Цезарь', 'Император', 'Мужской', '1234 999543', '+7 (897) 00-12-743', 'guy@cesarrrr.com', -15915600, 0),
(4, 'Иван', 'Грозный', 'Васильевич', 'Царь', 'Мужской', '1234 321880', '+7 (112) 59-09-456', 'tsar@russia.com', 63054000, 0),
(5, 'Petr', 'Петрович', 'Геннадьевич', 'Главный по расчесыванию собак', 'Мужской', '1232 112112', '+7 (445) 35-23-999', 'genndy@gmail.com', 645822000, 1),
(6, 'Джимми', 'Нейтрон', 'Хьюивич', 'Мальчишка, герой приключений', 'Мужской', '1234 988925', '+7 (159) 17-99-743', 'rocket@neitron.com', 855860400, 0),
(7, 'Николай', 'Кусачий', 'Шредорович', 'Счетовод', 'Мужской', '1234 123321', '+7 (123) 45-67-890', '12@345.com', 881175600, 0),
(8, 'Елена', 'Горелкина', 'Захаровна', 'Защитница пряников', 'Женский', '2355 585732', '+7 (999) 71-56-456', 'ksen@mail.com', 611262000, 0),
(9, 'Наталья', 'Рубилкина', 'Александровна', 'Технарь со стажем', 'Женский', '1237 999111', '+7 (991) 88-01-777', 'rub@mail.com', 575924400, 0),
(10, 'Светлана', 'Приветова', 'Йогуртовна', 'Занимается танцами', 'Женский', '1111 896746', '+7 (000) 95-16-888', 'dance@dance.com', 857502000, 0),
(11, 'Анна', 'Дружева', 'Николаевна', 'Знает все!', 'Женский', '5896 147264', '+7 (333) 33-79-258', 'friend@mail.co', 870807600, 1),
(12, 'Альбина', 'Егоровна', 'Дмитриевна', 'Заведующая праздниками', 'Женский', '1920 772211', '+7 (111) 00-99-123', '1234@gmail.com', 547153200, 1),
(13, 'фыввы', 'фыф', 'Вап', 'ыаы', 'Мужской', '1234 111777', '+7 (445) 35-23-999', 'overlords1234@gmail.com', 1513710000, 0),
(14, 'Зефира', 'Носкова', 'Олеговна', 'Прачка', 'Женский', '4854 773120', '+7 (555) 35-23-123', 'socks@asd.com', 571518000, 0),
(15, 'Екатерина', 'Вишнева', 'Владимировна', 'Садовод', 'Женский', '5768 553621', '+7 (827) 35-23-000', 'cherry@mail.rom', 565297200, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `employees_history`
--

CREATE TABLE `employees_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` bigint(20) NOT NULL,
  `json_param` varchar(10000) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `employees_history`
--

INSERT INTO `employees_history` (`id`, `user_id`, `date`, `json_param`) VALUES
(6, 5, 1512821785, '{"action":"edit","params":{"name":"Вася","surname":"Петрович","patronymic":"Геннадьевич","position":"Главный по расчесыванию собак","sex":"Мужской","pass":"1232 112112","phone":"+7 (445) 35-23-999","email":"genndy@gmail.com","birthday_date":false,"add_emp_btn":"","emp_id":"5"},"params_old":{"name":"Петя","surname":"Петрович","patronymic":"Геннадьевич","position":"Главный по расчесыванию собак","sex":"Мужской","pass":"1232 112112","phone":"+7 (445) 35-23-999","email":"genndy@gmail.com","birthday_date":"645822000"}}'),
(7, 5, 1512821809, '{"action":"edit","params":{"name":"Petr","surname":"Петрович","patronymic":"Геннадьевич","position":"Главный по расчесыванию собак","sex":"Мужской","pass":"1232 112112","phone":"+7 (445) 35-23-999","email":"genndy@gmail.com","birthday_date":645822000,"add_emp_btn":"","emp_id":"5"},"params_old":{"name":"Вася","surname":"Петрович","patronymic":"Геннадьевич","position":"Главный по расчесыванию собак","sex":"Мужской","pass":"1232 112112","phone":"+7 (445) 35-23-999","email":"genndy@gmail.com","birthday_date":"645822000"}}'),
(8, 15, 1512824807, '{"action":"add","params":{"name":"Екатерина","surname":"Вишнева","patronymic":"Владимировна","position":"Садовод","sex":"Женский","pass":"5768 553621","phone":"+7 (827) 35-23-000","email":"cherry@mail.rom","birthday_date":"12\\/01\\/1987","add_emp_btn":""},"params_old":[]}'),
(9, 5, 1512824853, '{"action":"delete","params":[],"params_old":[]}'),
(10, 1, 1512825398, '{"action":"edit","params":{"name":"Ксения","surname":"Цукерка","patronymic":"Петровна","position":"Бухгалтер","sex":"Женский","pass":"1431 096854","phone":"+7 (123) 11-18-443","email":"cuker@mail.com","birthday_date":596228400,"add_emp_btn":"","emp_id":"1"},"params_old":{"name":"Ксения","surname":"Цукерка","patronymic":"Петровна","position":"Бухгалтер","sex":"Женский","pass":"1431 234512","phone":"+7 (123) 11-18-443","email":"cuker@mail.com","birthday_date":"596228400"}}'),
(11, 1, 1512886691, '{"action":"edit","params":{"name":"Ксения","surname":"Цукерка","patronymic":"Сергеевна","position":"Бухгалтер","sex":"Женский","pass":"1431 096854","phone":"+7 (123) 11-18-443","email":"cuker@mail.com","birthday_date":596228400,"add_emp_btn":"","emp_id":"1"},"params_old":{"name":"Ксения","surname":"Цукерка","patronymic":"Петровна","position":"Бухгалтер","sex":"Женский","pass":"1431 096854","phone":"+7 (123) 11-18-443","email":"cuker@mail.com","birthday_date":"596228400"}}'),
(12, 3, 1512886924, '{"action":"edit","params":{"name":"Гай","surname":"Юлий","patronymic":"Цезарь","position":"Император","sex":"Мужской","pass":"1234 999543","phone":"+7 (897) 00-12-743","email":"guy@cesarrrr.com","birthday_date":-15915600,"add_emp_btn":"","emp_id":"3"},"params_old":{"name":"Гай","surname":"Юлий","patronymic":"Цезарь","position":"Император","sex":"Мужской","pass":"1234 999543","phone":"+7 (897) 00-12-743","email":"guy@cesarrrr.com","birthday_date":"-15915600"}}');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `employees_history`
--
ALTER TABLE `employees_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `employees_history`
--
ALTER TABLE `employees_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `employees_history`
--
ALTER TABLE `employees_history`
  ADD CONSTRAINT `employees_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employees` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
