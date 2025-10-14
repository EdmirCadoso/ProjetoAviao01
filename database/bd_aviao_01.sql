-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Out-2025 às 18:07
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_aviao_01`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aviaos`
--

CREATE TABLE `aviaos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(50) NOT NULL,
  `airline` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `aviaos`
--

INSERT INTO `aviaos` (`id`, `user_id`, `model`, `airline`, `capacity`, `image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Boeing 737', 'TACV', 180, 'images/boeing737.jpg', '2025-10-14 12:50:10', '2025-10-14 12:50:10', NULL),
(2, 2, 'Airbus A320', 'Cabo Verde Airlines', 160, 'images/a320.jpg', '2025-10-14 12:50:10', '2025-10-14 12:50:10', NULL),
(3, 3, 'Embraer E190', 'BestFly', 100, 'images/e190.jpg', '2025-10-14 12:50:10', '2025-10-14 12:50:10', NULL),
(4, 4, 'ATR 72', 'SevenAir', 70, 'images/atr72.jpg', '2025-10-14 12:50:10', '2025-10-14 12:50:10', NULL),
(5, 5, 'Boeing 777', 'TACV', 300, 'images/boeing777.jpg', '2025-10-14 12:50:10', '2025-10-14 12:50:10', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2025_10_14_110715_create_users_table', 1),
(7, '2025_10_14_122545_create_aviaos_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `blocked_until` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `email_verified_at`, `last_login_at`, `active`, `blocked_until`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user1', 'user1@gmail.com', '$2y$12$0fr.5n/uQB4ofQM4emPaqeTKdUVb3RqW.nFtJesHl41TeQUGMLGq6', NULL, '2025-10-14 13:32:39', NULL, 1, NULL, '2025-10-14 14:32:39', '2025-10-14 14:32:39', NULL),
(2, 'user2', 'user2@gmail.com', '$2y$12$mr5ow7m4eNnpp7eRCfSa2eEerMCwmtYnxHXyJx1CjcO7t1JaNi3xe', NULL, '2025-10-14 13:32:39', NULL, 1, NULL, '2025-10-14 14:32:39', '2025-10-14 14:32:39', NULL),
(3, 'user3', 'user3@gmail.com', '$2y$12$ulbYnbRbEUyq/ThuLeKrJ.V9Y24zdsGwFKqEWF6e9tby.GXZBJ.qi', NULL, '2025-10-14 13:32:39', NULL, 1, NULL, '2025-10-14 14:32:39', '2025-10-14 14:32:39', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aviaos`
--
ALTER TABLE `aviaos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aviaos`
--
ALTER TABLE `aviaos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
