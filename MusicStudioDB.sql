-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 24 2023 г., 13:35
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `MusicStudio`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Clients`
--

CREATE TABLE `Clients` (
  `ID_Client` int NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  `Fathername` varchar(100) NOT NULL,
  `Phone` char(20) DEFAULT NULL,
  `Passport` char(255) NOT NULL,
  `Birthdate` date DEFAULT NULL,
  `Adress` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `Contracts`
--

CREATE TABLE `Contracts` (
  `ID_Contract` int NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `GeneralCost` double NOT NULL,
  `ID_Service` int NOT NULL,
  `ID_Client` int NOT NULL,
  `ID_Room` int NOT NULL,
  `Status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `MusicEquipment`
--

CREATE TABLE `MusicEquipment` (
  `ID_Equipment` int NOT NULL,
  `Nomination` varchar(100) NOT NULL,
  `CostPerHour` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `MusicEquipment`
--

INSERT INTO `MusicEquipment` (`ID_Equipment`, `Nomination`, `CostPerHour`) VALUES
(5, 'Бас-гитара', 100),
(6, 'Педаль перегруза', 70),
(7, 'Микрофон', 50),
(8, 'Сэмплер', 90);

-- --------------------------------------------------------

--
-- Структура таблицы `Rooms`
--

CREATE TABLE `Rooms` (
  `ID_Room` int NOT NULL,
  `TarifPerHour` int NOT NULL,
  `RoomNumber` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Rooms`
--

INSERT INTO `Rooms` (`ID_Room`, `TarifPerHour`, `RoomNumber`) VALUES
(4, 1000, 'Зал Звукозаписи'),
(5, 350, 'Зал-1'),
(6, 350, 'Зал-2'),
(7, 400, 'Зал-3');

-- --------------------------------------------------------

--
-- Структура таблицы `SelectedEquipment`
--

CREATE TABLE `SelectedEquipment` (
  `ID_Contract` int NOT NULL,
  `ID_Equipment` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `Services`
--

CREATE TABLE `Services` (
  `ID_Service` int NOT NULL,
  `Nomination` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Services`
--

INSERT INTO `Services` (`ID_Service`, `Nomination`) VALUES
(1, 'Звукозапись'),
(2, 'Аренда помещения');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`ID_Client`);

--
-- Индексы таблицы `Contracts`
--
ALTER TABLE `Contracts`
  ADD PRIMARY KEY (`ID_Contract`),
  ADD KEY `R_5` (`ID_Client`),
  ADD KEY `R_7` (`ID_Room`),
  ADD KEY `R_10` (`ID_Service`);

--
-- Индексы таблицы `MusicEquipment`
--
ALTER TABLE `MusicEquipment`
  ADD PRIMARY KEY (`ID_Equipment`);

--
-- Индексы таблицы `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`ID_Room`);

--
-- Индексы таблицы `SelectedEquipment`
--
ALTER TABLE `SelectedEquipment`
  ADD PRIMARY KEY (`ID_Contract`,`ID_Equipment`),
  ADD KEY `R_12` (`ID_Equipment`);

--
-- Индексы таблицы `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`ID_Service`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Clients`
--
ALTER TABLE `Clients`
  MODIFY `ID_Client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `Contracts`
--
ALTER TABLE `Contracts`
  MODIFY `ID_Contract` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `MusicEquipment`
--
ALTER TABLE `MusicEquipment`
  MODIFY `ID_Equipment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `ID_Room` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `Services`
--
ALTER TABLE `Services`
  MODIFY `ID_Service` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Contracts`
--
ALTER TABLE `Contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `Clients` (`ID_Client`),
  ADD CONSTRAINT `contracts_ibfk_3` FOREIGN KEY (`ID_Room`) REFERENCES `Rooms` (`ID_Room`),
  ADD CONSTRAINT `contracts_ibfk_4` FOREIGN KEY (`ID_Service`) REFERENCES `Services` (`ID_Service`);

--
-- Ограничения внешнего ключа таблицы `SelectedEquipment`
--
ALTER TABLE `SelectedEquipment`
  ADD CONSTRAINT `selectedequipment_ibfk_1` FOREIGN KEY (`ID_Contract`) REFERENCES `Contracts` (`ID_Contract`),
  ADD CONSTRAINT `selectedequipment_ibfk_2` FOREIGN KEY (`ID_Equipment`) REFERENCES `MusicEquipment` (`ID_Equipment`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
