-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 07, 2026 at 05:19 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ticketsystem`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `priority_id` smallint(6) NOT NULL,
  `case_desc` text NOT NULL,
  `case_name` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `case_handlers`
--

CREATE TABLE `case_handlers` (
  `case_id` int(11) NOT NULL,
  `handler_id` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `case_messages`
--

CREATE TABLE `case_messages` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Wyzwalacze `case_messages`
--
DELIMITER $$
CREATE TRIGGER `after_case_message_insert` AFTER INSERT ON `case_messages` FOR EACH ROW BEGIN
    UPDATE cases
    SET updated_at = CURRENT_TIMESTAMP
    WHERE id = NEW.case_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_case_status_after_message` AFTER INSERT ON `case_messages` FOR EACH ROW BEGIN
    IF NEW.status_id IS NOT NULL THEN
        UPDATE cases
        SET status_id = NEW.status_id,
            updated_at = CURRENT_TIMESTAMP()
        WHERE id = NEW.case_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `case_message_overview`
-- (See below for the actual view)
--
CREATE TABLE `case_message_overview` (
`id` int(11)
,`case_id` int(11)
,`user_id` int(11)
,`FullName` varchar(511)
,`message` text
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `case_message_overview_attachments`
-- (See below for the actual view)
--
CREATE TABLE `case_message_overview_attachments` (
`message_id` int(11)
,`case_id` int(11)
,`user_id` int(11)
,`FullName` varchar(511)
,`message` text
,`created_at` timestamp
,`attachment_id` int(11)
,`hash_id` text
,`filename` varchar(255)
,`mime_type` varchar(100)
,`file_size` int(10) unsigned
,`file_data` mediumblob
);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `case_overview`
-- (See below for the actual view)
--
CREATE TABLE `case_overview` (
`id` int(11)
,`user_id` int(11)
,`FullName` varchar(511)
,`case_name` varchar(255)
,`case_desc` text
,`priority_id` smallint(6)
,`status_id` int(11)
,`Status` varchar(50)
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_data` mediumblob NOT NULL,
  `file_size` int(10) UNSIGNED NOT NULL,
  `hash_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `priorities`
--

CREATE TABLE `priorities` (
  `id` smallint(6) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(12, ''),
(6, 'Big Problem'),
(3, 'Closed'),
(2, 'In progress'),
(1, 'Open'),
(5, 'Quarantine'),
(10, 'Unknown');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `First_name` varchar(255) NOT NULL,
  `Last_name` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `profile_image_data` mediumblob DEFAULT NULL,
  `profile_image_type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`) VALUES
(2, 'Admin'),
(3, 'Employee'),
(1, 'User');

-- --------------------------------------------------------

--
-- Struktura widoku `case_message_overview`
--
DROP TABLE IF EXISTS `case_message_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `case_message_overview`  AS SELECT `cm`.`id` AS `id`, `cm`.`case_id` AS `case_id`, `cm`.`user_id` AS `user_id`, concat(`u`.`First_name`,' ',`u`.`Last_name`) AS `FullName`, `cm`.`message` AS `message`, `cm`.`created_at` AS `created_at` FROM (`case_messages` `cm` join `user` `u` on(`cm`.`user_id` = `u`.`ID`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `case_message_overview_attachments`
--
DROP TABLE IF EXISTS `case_message_overview_attachments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `case_message_overview_attachments`  AS SELECT `cmo`.`id` AS `message_id`, `cmo`.`case_id` AS `case_id`, `cmo`.`user_id` AS `user_id`, `cmo`.`FullName` AS `FullName`, `cmo`.`message` AS `message`, `cmo`.`created_at` AS `created_at`, `ma`.`id` AS `attachment_id`, `ma`.`hash_id` AS `hash_id`, `ma`.`filename` AS `filename`, `ma`.`mime_type` AS `mime_type`, `ma`.`file_size` AS `file_size`, `ma`.`file_data` AS `file_data` FROM (`case_message_overview` `cmo` join `message_attachments` `ma` on(`ma`.`message_id` = `cmo`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `case_overview`
--
DROP TABLE IF EXISTS `case_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `case_overview`  AS SELECT `c`.`id` AS `id`, `c`.`user_id` AS `user_id`, concat(`u`.`First_name`,' ',`u`.`Last_name`) AS `FullName`, `c`.`case_name` AS `case_name`, `c`.`case_desc` AS `case_desc`, `c`.`priority_id` AS `priority_id`, `c`.`status_id` AS `status_id`, `s`.`name` AS `Status`, `c`.`created_at` AS `created_at`, `c`.`updated_at` AS `updated_at` FROM ((`cases` `c` join `user` `u` on(`c`.`user_id` = `u`.`ID`)) join `statuses` `s` on(`c`.`status_id` = `s`.`id`)) ORDER BY `c`.`updated_at` DESC ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attachments_case` (`case_id`),
  ADD KEY `fk_attachments_user` (`user_id`);

--
-- Indeksy dla tabeli `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cases_user` (`user_id`),
  ADD KEY `fk_cases_priority` (`priority_id`),
  ADD KEY `fk_cases_status` (`status_id`);

--
-- Indeksy dla tabeli `case_handlers`
--
ALTER TABLE `case_handlers`
  ADD PRIMARY KEY (`case_id`,`handler_id`),
  ADD KEY `fk_case_handlers_user` (`handler_id`);

--
-- Indeksy dla tabeli `case_messages`
--
ALTER TABLE `case_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages_case` (`case_id`),
  ADD KEY `fk_messages_user` (`user_id`);

--
-- Indeksy dla tabeli `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indeksy dla tabeli `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeksy dla tabeli `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_user_email` (`email`),
  ADD KEY `fk_user_user_type` (`user_type_id`);

--
-- Indeksy dla tabeli `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_messages`
--
ALTER TABLE `case_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `fk_attachments_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`),
  ADD CONSTRAINT `fk_attachments_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`ID`);

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `fk_cases_priority` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`),
  ADD CONSTRAINT `fk_cases_status` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `fk_cases_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`ID`);

--
-- Constraints for table `case_handlers`
--
ALTER TABLE `case_handlers`
  ADD CONSTRAINT `fk_case_handlers_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`),
  ADD CONSTRAINT `fk_case_handlers_user` FOREIGN KEY (`handler_id`) REFERENCES `user` (`ID`);

--
-- Constraints for table `case_messages`
--
ALTER TABLE `case_messages`
  ADD CONSTRAINT `fk_messages_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`),
  ADD CONSTRAINT `fk_messages_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`ID`);

--
-- Constraints for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD CONSTRAINT `message_attachments_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `case_messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`);
COMMIT;
