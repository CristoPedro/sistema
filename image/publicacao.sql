-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Maio-2024 às 19:58
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `publicacao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adm`
--

CREATE TABLE `adm` (
  `id` int(11) NOT NULL,
  `user_adm` varchar(50) NOT NULL,
  `password_adm` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `adm`
--

INSERT INTO `adm` (`id`, `user_adm`, `password_adm`, `photo`) VALUES
(1, 'PSG', '123', 'default.jpg'),
(2, 'Pedro Cristo', '1234', 'default.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `publicacao_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `incendio_anonimo`
--

CREATE TABLE `incendio_anonimo` (
  `id` int(11) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `tempo_publica` datetime NOT NULL,
  `foto_incendio` varchar(100) NOT NULL DEFAULT 'default.png',
  `detalhes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `type` enum('like','dislike') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `lido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `user_id`, `post_id`, `type`, `timestamp`, `lido`) VALUES
(1, 35, 96, 'like', '2024-05-24 15:53:29', 0),
(2, 35, 96, 'dislike', '2024-05-24 15:56:13', 0),
(3, 35, 96, 'dislike', '2024-05-24 15:56:16', 0),
(4, 35, 96, 'like', '2024-05-24 15:56:29', 0),
(5, 35, 96, 'like', '2024-05-24 15:56:37', 0),
(6, 35, 96, 'like', '2024-05-24 15:56:40', 0),
(7, 35, 96, 'like', '2024-05-24 15:56:40', 0),
(8, 35, 96, 'like', '2024-05-24 15:56:40', 0),
(9, 35, 96, 'like', '2024-05-24 15:56:40', 0),
(10, 35, 96, 'like', '2024-05-24 15:56:40', 0),
(11, 35, 96, 'like', '2024-05-24 15:56:46', 0),
(12, 35, 96, 'like', '2024-05-24 15:58:08', 0),
(13, 35, 96, 'like', '2024-05-24 15:58:10', 0),
(14, 35, 96, 'like', '2024-05-24 15:58:10', 0),
(15, 35, 96, 'like', '2024-05-24 15:58:10', 0),
(16, 35, 96, 'like', '2024-05-24 15:58:11', 0),
(17, 35, 96, 'like', '2024-05-24 15:58:11', 0),
(18, 35, 96, 'like', '2024-05-24 15:58:11', 0),
(19, 35, 96, 'dislike', '2024-05-24 15:58:12', 0),
(20, 35, 96, 'dislike', '2024-05-24 15:58:12', 0),
(21, 35, 96, 'dislike', '2024-05-24 15:58:13', 0),
(22, 35, 96, 'dislike', '2024-05-24 15:58:13', 0),
(23, 35, 96, 'like', '2024-05-24 16:17:47', 0),
(24, 35, 96, 'like', '2024-05-24 16:17:49', 0),
(25, 35, 96, 'like', '2024-05-24 16:17:50', 0),
(26, 35, 96, 'like', '2024-05-24 16:17:54', 0),
(27, 35, 96, 'like', '2024-05-24 16:18:06', 0),
(28, 35, 96, 'dislike', '2024-05-24 16:18:08', 0),
(29, 35, 96, 'like', '2024-05-24 16:18:10', 0),
(30, 35, 96, 'dislike', '2024-05-24 16:18:11', 0),
(31, 35, 96, 'like', '2024-05-24 16:18:19', 0),
(32, 36, 95, 'like', '2024-05-24 16:20:58', 1),
(33, 35, 96, 'like', '2024-05-25 13:36:26', 0),
(34, 35, 96, 'like', '2024-05-25 13:36:27', 0),
(35, 35, 97, 'like', '2024-05-25 16:04:03', 0),
(36, 35, 97, 'dislike', '2024-05-25 16:04:06', 0),
(37, 35, 97, 'like', '2024-05-25 16:06:26', 0),
(38, 35, 97, 'dislike', '2024-05-25 16:06:29', 0),
(39, 35, 97, 'like', '2024-05-25 16:12:53', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `publica_incendio`
--

CREATE TABLE `publica_incendio` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `detalhes` varchar(100) NOT NULL,
  `tempo_publicacao` datetime DEFAULT NULL,
  `foto_publica` varchar(244) DEFAULT 'defult.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `publica_incendio`
--

INSERT INTO `publica_incendio` (`id`, `idusuario`, `location`, `cidade`, `detalhes`, `tempo_publicacao`, `foto_publica`) VALUES
(95, 36, 'Maianga', 'Luanda', 'Incêndio em mayanga', '2024-05-24 16:51:40', '6650b78cf31f2.jpeg'),
(96, 35, 'Malueca', 'Luanda', 'Incêndo', '2024-05-24 16:52:35', '6650b7c363a5b.jpeg'),
(97, 35, 'Amabaca', 'Cunene', 'Incêndio chamem os bombeiros', '2024-05-25 14:38:03', '6651e9bb8b39c.jpeg'),
(98, 36, 'dsaa', 'Luanda', 'test', '2024-05-25 17:06:45', 'defult.png'),
(99, 36, 'Armazem amarelo', 'Luanda', 'Test', '2024-05-25 17:13:04', 'defult.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ratings`
--

INSERT INTO `ratings` (`id`, `post_id`, `user_id`, `status`) VALUES
(33, 95, 35, 'like'),
(34, 96, 35, 'like'),
(35, 96, 36, 'like'),
(36, 97, 36, 'like'),
(37, 98, 36, 'like'),
(38, 99, 36, 'like');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `photo`) VALUES
(35, 'Manuel', '202cb962ac59075b964b07152d234b70', 'mendes@gmail.com', '6650b6c53fb86.jpeg'),
(36, 'Mendes', '202cb962ac59075b964b07152d234b70', 'marcos@gmail.com', '6650b729bd998.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publicacao_id` (`publicacao_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `incendio_anonimo`
--
ALTER TABLE `incendio_anonimo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Índices para tabela `publica_incendio`
--
ALTER TABLE `publica_incendio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Índices para tabela `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post` (`post_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `incendio_anonimo`
--
ALTER TABLE `incendio_anonimo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `publica_incendio`
--
ALTER TABLE `publica_incendio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de tabela `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`publicacao_id`) REFERENCES `publica_incendio` (`id`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `notificacoes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `publica_incendio` (`id`);

--
-- Limitadores para a tabela `publica_incendio`
--
ALTER TABLE `publica_incendio`
  ADD CONSTRAINT `publica_incendio_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`post_id`) REFERENCES `publica_incendio` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
