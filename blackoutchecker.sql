-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 16, 2025 alle 22:09
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blackout checker`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `blackouts`
--

CREATE TABLE `blackouts` (
  `codice` varchar(10) NOT NULL,
  `data` datetime NOT NULL,
  `tempo` text NOT NULL,
  `caso` text NOT NULL,
  `tentativi` int(11) NOT NULL,
  `id_entry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `blackouts`
--

INSERT INTO `blackouts` (`codice`, `data`, `tempo`, `caso`, `tentativi`, `id_entry`) VALUES
('tony_stark', '2025-12-02 17:34:51', '5 hours, 22 minutes, 10 seconds', 'FAILURE', 1, 1),
('katebishop', '2025-12-05 15:00:27', '2 hours, 1 minute, 20 seconds', 'OVERLOAD', 1, 2),
('tony_stark', '2025-12-06 08:12:44', '1 hour, 32 minutes, 10 seconds', 'OVERLOAD', 1, 3),
('rocket_rcc', '2025-12-06 23:17:51', '12 hours, 6 minutes, 33 seconds', 'FAILURE', 12, 4),
('rocket_rcc', '2025-12-08 15:20:01', '5 hours, 1 minute, 2 seconds', 'OVERLOAD', 1, 5),
('katebishop', '2025-12-13 22:31:37', '9 hours, 3 minutes, 30 seconds', 'FAILURE', 7, 6),
('hrvd_CS50x', '2025-12-16 10:28:39', '7 seconds', 'OVERLOAD', 1, 7),
('hrvd_CS50x', '2025-12-16 10:31:10', '20 seconds', 'FAILURE', 3, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `nome` text NOT NULL,
  `cognome` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `codice` varchar(10) NOT NULL,
  `genere` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`nome`, `cognome`, `username`, `password`, `codice`, `genere`) VALUES
('Administrator', 'Root', 'Admin', '5D217882476FC1ADF1F49357A50293C9', 'Arrq37X0s1', 'N'),
('Testing', 'Testing', 'userTest', '4015DFA9558521AC5D7B2492E48A09A5', 'hrvd_CS50x', 'N'),
('Katherine', 'Bishop', 'HawkeyeKateB', '0BA2A2324623AE05AE58802712FDB294', 'katebishop', 'F'),
('Rocket', 'Raccoon', 'RocketRCC', '648B3519BD4469E1A48DFF4DC4827315', 'rocket_rcc', 'N'),
('Anthony', 'Stark', 'TonyStark', 'D50BA4DD3FE42E17E9FAA9EC29F89708', 'tony_stark', 'M');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `blackouts`
--
ALTER TABLE `blackouts`
  ADD PRIMARY KEY (`id_entry`),
  ADD KEY `blackouts_ibfk_1` (`codice`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`codice`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `blackouts`
--
ALTER TABLE `blackouts`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `blackouts`
--
ALTER TABLE `blackouts`
  ADD CONSTRAINT `blackouts_ibfk_1` FOREIGN KEY (`codice`) REFERENCES `users` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
