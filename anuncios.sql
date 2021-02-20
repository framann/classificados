-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Fev-2021 às 11:12
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `anuncios`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios`
--

CREATE TABLE `anuncios` (
  `anuncio_id` int(11) NOT NULL,
  `anuncio_user_id` int(11) UNSIGNED NOT NULL,
  `anuncio_codigo` longtext NOT NULL,
  `anuncio_titulo` varchar(255) NOT NULL,
  `anuncio_descricao` longtext NOT NULL,
  `anuncio_categoria_pai_id` int(11) NOT NULL,
  `anuncio_categoria_id` int(11) NOT NULL,
  `anuncio_preco` decimal(15,2) NOT NULL,
  `anuncio_localizacao_cep` varchar(15) NOT NULL,
  `anuncio_logradouro` varchar(255) DEFAULT NULL COMMENT 'Preenchido via consulta API Via CEP',
  `anuncio_bairro` varchar(50) DEFAULT NULL COMMENT 'Preenchido via consulta API Via CEP',
  `anuncio_cidade` varchar(50) DEFAULT NULL COMMENT 'Preenchido via consulta API Via CEP',
  `anuncio_estado` varchar(2) DEFAULT NULL COMMENT 'Preenchido via consulta API Via CEP',
  `anuncio_bairro_metalink` varchar(50) DEFAULT NULL,
  `anuncio_cidade_metalink` varchar(50) DEFAULT NULL,
  `anuncio_data_criacao` timestamp NULL DEFAULT current_timestamp(),
  `anuncio_data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `anuncio_publicado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Publicado ou não',
  `anuncio_situacao` tinyint(1) NOT NULL COMMENT 'Novo ou usado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `anuncios`
--

INSERT INTO `anuncios` (`anuncio_id`, `anuncio_user_id`, `anuncio_codigo`, `anuncio_titulo`, `anuncio_descricao`, `anuncio_categoria_pai_id`, `anuncio_categoria_id`, `anuncio_preco`, `anuncio_localizacao_cep`, `anuncio_logradouro`, `anuncio_bairro`, `anuncio_cidade`, `anuncio_estado`, `anuncio_bairro_metalink`, `anuncio_cidade_metalink`, `anuncio_data_criacao`, `anuncio_data_alteracao`, `anuncio_publicado`, `anuncio_situacao`) VALUES
(6, 6, '12345678', 'Controle de ps4 usado em excelente estado', 'Controle de ps4 usado em excelente estado', 3, 5, '100.00', '80510-000', NULL, NULL, NULL, NULL, '', '', '2021-02-19 10:53:46', '2021-02-19 16:58:34', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios_fotos`
--

CREATE TABLE `anuncios_fotos` (
  `foto_id` int(11) NOT NULL,
  `foto_anuncio_id` int(11) DEFAULT NULL,
  `foto_nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `anuncios_fotos`
--

INSERT INTO `anuncios_fotos` (`foto_id`, `foto_anuncio_id`, `foto_nome`) VALUES
(3705, 6, 'ad0f4caa149662c5bf2594f94f656ee0.jpg'),
(3706, 6, '1911754dae4478ff77246b2b2f1bac9c.jpg'),
(3707, 6, '3b69f164b69e72f13b078d0216384c19.jpg'),
(3708, 6, '6a8d85d315e18e67c687947722d89528.jpg'),
(3709, 6, 'cb2e6c2469b5b023a3814087dce9e175.jpg'),
(3710, 6, '93f7db8ce4bc4eff943225e97de39541.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_pai_id` int(11) DEFAULT NULL,
  `categoria_nome` varchar(45) NOT NULL,
  `categoria_ativa` tinyint(1) DEFAULT NULL,
  `categoria_meta_link` varchar(100) DEFAULT NULL,
  `categoria_data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria_data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `categoria_pai_id`, `categoria_nome`, `categoria_ativa`, `categoria_meta_link`, `categoria_data_criacao`, `categoria_data_alteracao`) VALUES
(2, 2, 'Mouse', 1, 'mouse', '2021-02-10 18:09:47', NULL),
(3, 3, 'Fone de ouvido games', 1, 'fone-de-ouvido-games', '2021-02-11 19:27:49', NULL),
(4, 2, 'Memória Ram', 1, 'memoria-ram', '2021-02-11 19:33:16', NULL),
(5, 3, 'Controles', 1, 'controles', '2021-02-13 11:40:07', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias_pai`
--

CREATE TABLE `categorias_pai` (
  `categoria_pai_id` int(11) NOT NULL,
  `categoria_pai_nome` varchar(45) NOT NULL,
  `categoria_pai_ativa` tinyint(1) DEFAULT NULL,
  `categoria_pai_meta_link` varchar(100) DEFAULT NULL,
  `categoria_pai_classe_icone` varchar(50) NOT NULL,
  `categoria_pai_data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria_pai_data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias_pai`
--

INSERT INTO `categorias_pai` (`categoria_pai_id`, `categoria_pai_nome`, `categoria_pai_ativa`, `categoria_pai_meta_link`, `categoria_pai_classe_icone`, `categoria_pai_data_criacao`, `categoria_pai_data_alteracao`) VALUES
(2, 'Informática', 1, 'informatica', 'ini-laptop', '2021-02-09 21:23:37', NULL),
(3, 'Games', 1, 'games', 'ini-laptop', '2021-02-10 18:36:06', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'anunciantes', 'Anunciantes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_foto` varchar(255) NOT NULL,
  `user_cpf` varchar(15) NOT NULL,
  `user_cep` varchar(9) NOT NULL,
  `user_endereco` varchar(255) NOT NULL,
  `user_numero_endereco` varchar(50) NOT NULL,
  `user_bairro` varchar(50) NOT NULL,
  `user_cidade` varchar(50) NOT NULL,
  `user_estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `user_foto`, `user_cpf`, `user_cep`, `user_endereco`, `user_numero_endereco`, `user_bairro`, `user_cidade`, `user_estado`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$r0W3kFHxKmAimCQOYYH6kuydG6M1azUXMiIoiRKUcYNAlgASlGCzy', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1613728989, 1, 'Admin', 'souza', 'ADMIN', '(41) 3232-3232', 'user-5.png', '576.719.480-71', '80540-000', 'Rua de teste', '45', 'Centro', 'Curitiba', 'PR'),
(2, '::1', NULL, '$2y$10$nkyouRgykyYt3vJdmQtNuud7CCB82F5jAI7tUqtTwgRt/PkhXiSFq', 'fabinho.palhoca@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1612637226, 1613167696, 1, 'Natária', 'souza', NULL, '(16) 2541-0663', '8ace9b91780e1cd2aa424ed127e34253.jpg', '295.506.244-80', '14811-443', 'Rua Zenilton Duclerc Verçosa', '100', 'Jardim Ana Adelaide', 'Araraquara', 'SP'),
(6, '::1', NULL, '$2y$10$Ft23Xxw3UmckZ2vpwN.dyuvh5cYzgu5Iuj/oQxsSq9GnMc5gTa1l6', 'daianealessandramoraes-90@mouraflorito.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1612707655, 1613167083, 1, 'Daiane', 'moraes', NULL, '(91) 99206-1057', '5d74bc8a2d049ae6e94db44ff3a0abb0.png', '295.506.244-80', '66645-260', 'Passagem Boa Esperança', '101', 'Castanheira', 'Belém', 'PA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(20, 1, 1),
(26, 2, 2),
(25, 6, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`anuncio_id`),
  ADD KEY `fk_anuncio_user_id` (`anuncio_user_id`);

--
-- Índices para tabela `anuncios_fotos`
--
ALTER TABLE `anuncios_fotos`
  ADD PRIMARY KEY (`foto_id`),
  ADD KEY `fk_foto_anuncio_id` (`foto_anuncio_id`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`),
  ADD KEY `categoria_pai_id` (`categoria_pai_id`);

--
-- Índices para tabela `categorias_pai`
--
ALTER TABLE `categorias_pai`
  ADD PRIMARY KEY (`categoria_pai_id`);

--
-- Índices para tabela `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Índices para tabela `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `anuncio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `anuncios_fotos`
--
ALTER TABLE `anuncios_fotos`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3711;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `categorias_pai`
--
ALTER TABLE `categorias_pai`
  MODIFY `categoria_pai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `fk_anuncio_user_id` FOREIGN KEY (`anuncio_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `anuncios_fotos`
--
ALTER TABLE `anuncios_fotos`
  ADD CONSTRAINT `fk_foto_anuncio_id` FOREIGN KEY (`foto_anuncio_id`) REFERENCES `anuncios` (`anuncio_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `fk_categoria_pai_id` FOREIGN KEY (`categoria_pai_id`) REFERENCES `categorias_pai` (`categoria_pai_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
