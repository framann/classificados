-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Mar-2021 às 01:25
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
(7, 12, '12345678', 'Controle de ps4 usado em bom estado', 'Controle de ps4 usado em bom estado \r\nEntregue na região central de Curitiba', 3, 5, '150.00', '80510-000', NULL, NULL, NULL, NULL, '', '', '2021-02-28 15:13:24', '2021-03-03 17:13:06', 1, 1),
(8, 12, '24106539', 'Violão usado em excelente estado', 'Violão usado em bom estado', 4, 6, '50.00', '80510-000', 'Rua Inácio Lustosa', 'São Francisco', 'Curitiba', 'PR', 'sao-francisco', 'curitiba', '2021-03-04 16:46:09', '2021-03-04 16:47:36', 1, 0);

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
(3775, 7, '99ad2a08e183f5997f2231c06c549def.jpg'),
(3780, 8, 'bde426b88a1b447fe244e5f781a4c77e.jpg'),
(3781, 8, 'f68107c40c062744aab8ed0488ab0ba1.jpg'),
(3782, 8, '4fa03b3cfc4ae7d2a5f5e35a783828dd.jpg'),
(3783, 8, '3b4807a7624060850d1c6d39d52a95eb.jpg');

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
(5, 3, 'Controles', 1, 'controles', '2021-02-13 11:40:07', NULL),
(6, 4, 'violão', 1, 'violao', '2021-03-04 16:38:35', NULL);

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
(3, 'Games', 1, 'games', 'ini-laptop', '2021-02-10 18:36:06', NULL),
(4, 'Instrumentos musicais', 1, 'instrumentos-musicais', 'ini-laptop', '2021-03-04 16:14:22', NULL);

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
(1, '127.0.0.1', 'administrator', '$2y$12$r0W3kFHxKmAimCQOYYH6kuydG6M1azUXMiIoiRKUcYNAlgASlGCzy', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1614905506, 1, 'Admin', 'souza', 'ADMIN', '(41) 3232-3232', 'user-5.png', '576.719.480-71', '80540-000', 'Rua de teste', '45', 'Centro', 'Curitiba', 'PR'),
(2, '::1', NULL, '$2y$10$nkyouRgykyYt3vJdmQtNuud7CCB82F5jAI7tUqtTwgRt/PkhXiSFq', 'fabinho.palhoca@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1612637226, 1613167696, 1, 'Natária', 'souza', NULL, '(16) 2541-0663', '8ace9b91780e1cd2aa424ed127e34253.jpg', '295.506.244-80', '14811-443', 'Rua Zenilton Duclerc Verçosa', '100', 'Jardim Ana Adelaide', 'Araraquara', 'SP'),
(11, '::1', NULL, '$2y$10$fJFbY6zV1KzVX9xtFDwkMucdUbla8eOO16Fau2ySC5bnqSgqNegua', 'rebecaaliciasuelisilveira.rebecaaliciasuelisilveira@riquefroes.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1614195584, NULL, 1, 'Rebeca', 'Alícia Sueli Silveira', NULL, '(69) 99755-0270', '3837a679426b3ef39b95abf0c26812ad.jpg', '467.493.029-47', '76828-514', 'Rua Olidina Batista', '542', 'Jardim Santana', 'Porto Velho', 'RO'),
(12, '::1', NULL, '$2y$10$SaL6fI0J76wExhO6csGiB.Jzg5mip5POeMGdW0C7IsYfcR.MbjnJu', 'likosi7598@timothyjsilverman.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1614196063, 1615169305, 1, 'Iago', 'Theo Freitas', NULL, '(68) 3947-3164', '215350eb6576b3d4c364a4e627b9b2bc.jpg', '854.442.580-13', '80420-010', 'Avenida Vicente Machado', '251', 'Centro', 'Curitiba', 'PR');

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
(51, 2, 2),
(54, 11, 2),
(58, 12, 2);

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
  MODIFY `anuncio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `anuncios_fotos`
--
ALTER TABLE `anuncios_fotos`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3784;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `categorias_pai`
--
ALTER TABLE `categorias_pai`
  MODIFY `categoria_pai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
