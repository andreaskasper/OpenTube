-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 12. Apr 2020 um 17:10
-- Server-Version: 10.1.26-MariaDB-0+deb9u1
-- PHP-Version: 7.0.33-0+deb9u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `opentube_dev`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE `config` (
  `site_id` bigint(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `blowfish_secret` varchar(32) DEFAULT NULL,
  `data_json` mediumtext NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `config`
--

INSERT INTO `config` (`site_id`, `title`, `blowfish_secret`, `data_json`, `stamp`) VALUES
(1, 'Demosite', 'fIDbRoSLohcJBbb0hRoWC81z7kRBYGs3', '{}', '2020-04-12 15:08:54');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trainers`
--

CREATE TABLE `trainers` (
  `id` bigint(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` bigint(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `stamp`) VALUES
(1, 'test@test.de', '2020-04-10 10:54:48');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_logins`
--

CREATE TABLE `users_logins` (
  `user_id` bigint(10) NOT NULL,
  `provider` varchar(10) NOT NULL,
  `value` varchar(100) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users_logins`
--

INSERT INTO `users_logins` (`user_id`, `provider`, `value`, `stamp`) VALUES
(1, 'ep', '40078c6a20f77b23248775a229a4d7e9', '2020-04-12 15:09:40');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_rights`
--

CREATE TABLE `users_rights` (
  `user_id` bigint(10) NOT NULL,
  `right` varchar(20) NOT NULL,
  `dt_from` timestamp NULL DEFAULT NULL,
  `dt_to` timestamp NULL DEFAULT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users_rights`
--

INSERT INTO `users_rights` (`user_id`, `right`, `dt_from`, `dt_to`, `stamp`) VALUES
(1, 'admin', NULL, NULL, '2020-04-10 10:56:02');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `videos`
--

CREATE TABLE `videos` (
  `id` bigint(10) NOT NULL,
  `enabled_from` timestamp NULL DEFAULT NULL,
  `enabled_to` timestamp NULL DEFAULT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `videos`
--

INSERT INTO `videos` (`id`, `enabled_from`, `enabled_to`, `stamp`) VALUES
(1, '2019-12-31 23:00:00', '2020-12-30 23:00:00', '2020-04-07 12:27:01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `videos_prices`
--

CREATE TABLE `videos_prices` (
  `video_id` bigint(10) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `dt_from` timestamp NULL DEFAULT NULL,
  `dt_to` timestamp NULL DEFAULT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `videos_texts`
--

CREATE TABLE `videos_texts` (
  `video_id` bigint(10) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` mediumtext,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `videos_texts`
--

INSERT INTO `videos_texts` (`video_id`, `lang`, `title`, `description`, `stamp`) VALUES
(1, 'de', 'Testvideo', 'Dies ist ein Testvideo', '2020-04-07 16:29:50'),
(1, 'en', 'Testvideo', 'Lorem Ipsum', '2020-04-10 10:55:50');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `videos_trainers`
--

CREATE TABLE `videos_trainers` (
  `video_id` bigint(10) NOT NULL,
  `trainer_id` bigint(10) NOT NULL,
  `prio` int(3) NOT NULL,
  `stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`site_id`);

--
-- Indizes für die Tabelle `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `users_logins`
--
ALTER TABLE `users_logins`
  ADD PRIMARY KEY (`user_id`,`provider`,`value`);

--
-- Indizes für die Tabelle `users_rights`
--
ALTER TABLE `users_rights`
  ADD PRIMARY KEY (`user_id`,`right`);

--
-- Indizes für die Tabelle `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `videos_prices`
--
ALTER TABLE `videos_prices`
  ADD KEY `amou` (`video_id`);

--
-- Indizes für die Tabelle `videos_texts`
--
ALTER TABLE `videos_texts`
  ADD PRIMARY KEY (`video_id`,`lang`);
ALTER TABLE `videos_texts` ADD FULLTEXT KEY `FULLTEXT` (`title`,`description`);

--
-- Indizes für die Tabelle `videos_trainers`
--
ALTER TABLE `videos_trainers`
  ADD PRIMARY KEY (`video_id`,`trainer_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `config`
--
ALTER TABLE `config`
  MODIFY `site_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
