-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Abr-2023 às 04:43
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_startec`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_arquivo`
--

CREATE TABLE `tb_arquivo` (
  `cd_arquivo` int(11) NOT NULL,
  `nm_arquivo` varchar(300) NOT NULL,
  `ds_caminho` varchar(300) NOT NULL,
  `extensao` varchar(6) NOT NULL,
  `id_autor_arquivo` int(11) NOT NULL,
  `id_projeto_arquivo` int(11) NOT NULL,
  `created_arquivo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_candidato`
--

CREATE TABLE `tb_candidato` (
  `cd_candidato` int(11) NOT NULL,
  `id_candidato` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `id_autor_vaga_candidato` int(11) NOT NULL,
  `created_candidato` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_comentario_curriculo`
--

CREATE TABLE `tb_comentario_curriculo` (
  `cd_comentario_curriculo` int(11) NOT NULL,
  `ds_comentario_curriculo` varchar(400) NOT NULL,
  `id_autor_comentario_curriculo` int(11) NOT NULL,
  `id_comentario_curriculo` int(11) NOT NULL,
  `id_autor_curriculo_comentado` int(11) NOT NULL,
  `created_comentario_curriculo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_comentario_projeto`
--

CREATE TABLE `tb_comentario_projeto` (
  `cd_comentario_projeto` int(11) NOT NULL,
  `ds_comentario_projeto` varchar(400) NOT NULL,
  `id_autor_comentario_projeto` int(11) NOT NULL,
  `id_comentario_projeto` int(11) NOT NULL,
  `id_autor_projeto_comentado` int(11) NOT NULL,
  `created_comentario_projeto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_comentario_vaga`
--

CREATE TABLE `tb_comentario_vaga` (
  `cd_comentario_vaga` int(11) NOT NULL,
  `ds_comentario_vaga` varchar(400) NOT NULL,
  `id_autor_comentario_vaga` int(11) NOT NULL,
  `id_comentario_vaga` int(11) NOT NULL,
  `id_autor_vaga_comentada` int(11) NOT NULL,
  `created_comentario_vaga` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_curriculo`
--

CREATE TABLE `tb_curriculo` (
  `cd_curriculo` int(11) NOT NULL,
  `nm_foto_curriculo` varchar(200) DEFAULT NULL,
  `path_foto_curriculo` varchar(200) DEFAULT NULL,
  `nm_completo_curriculo` varchar(100) NOT NULL,
  `ds_contato_email` varchar(300) NOT NULL,
  `ds_cargo` varchar(300) NOT NULL,
  `ds_nascimento` date NOT NULL,
  `ds_contato_telefone` varchar(15) DEFAULT NULL,
  `ds_idioma` varchar(300) DEFAULT NULL,
  `ds_qualidade` varchar(500) DEFAULT NULL,
  `ds_curso` varchar(2000) DEFAULT NULL,
  `ds_url_curriculo` varchar(200) DEFAULT NULL,
  `id_autor_curriculo` int(11) NOT NULL,
  `id_estado_civil` int(11) NOT NULL,
  `id_municipio` int(11) NOT NULL,
  `ds_cep` varchar(9) NOT NULL,
  `id_etec_curriculo` int(11) NOT NULL,
  `id_pchave_curriculo` int(11) NOT NULL,
  `id_genero_curriculo` int(11) NOT NULL,
  `created_curriculo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_curtida_curriculo`
--

CREATE TABLE `tb_curtida_curriculo` (
  `cd_curtida_curriculo` int(11) NOT NULL,
  `id_autor_curtida_curriculo` int(11) NOT NULL,
  `id_curtida_curriculo` int(11) NOT NULL,
  `id_autor_curriculo_curtido` int(11) NOT NULL,
  `created_curtida_curriculo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_curtida_projeto`
--

CREATE TABLE `tb_curtida_projeto` (
  `cd_curtida_projeto` int(11) NOT NULL,
  `id_autor_curtida_projeto` int(11) NOT NULL,
  `id_curtida_projeto` int(11) NOT NULL,
  `id_autor_projeto_curtido` int(11) NOT NULL,
  `created_curtida_projeto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_curtida_vaga`
--

CREATE TABLE `tb_curtida_vaga` (
  `cd_curtida_vaga` int(11) NOT NULL,
  `id_autor_curtida_vaga` int(11) NOT NULL,
  `id_curtida_vaga` int(11) NOT NULL,
  `id_autor_vaga_curtida` int(11) NOT NULL,
  `created_curtida_vaga` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_denuncia_curriculo`
--

CREATE TABLE `tb_denuncia_curriculo` (
  `cd_denuncia_curriculo` int(11) NOT NULL,
  `ds_denuncia_curriculo` varchar(400) DEFAULT NULL,
  `id_pchave_denuncia_curriculo` int(11) NOT NULL,
  `id_autor_denuncia_curriculo` int(11) NOT NULL,
  `id_denuncia_curriculo` int(11) NOT NULL,
  `id_autor_curriculo_denunciado` int(11) NOT NULL,
  `created_denuncia_curriculo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_denuncia_projeto`
--

CREATE TABLE `tb_denuncia_projeto` (
  `cd_denuncia_projeto` int(11) NOT NULL,
  `ds_denuncia_projeto` varchar(400) DEFAULT NULL,
  `id_pchave_denuncia_projeto` int(11) NOT NULL,
  `id_autor_denuncia_projeto` int(11) NOT NULL,
  `id_denuncia_projeto` int(11) NOT NULL,
  `id_autor_projeto_denunciado` int(11) NOT NULL,
  `created_denuncia_projeto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_denuncia_usuario`
--

CREATE TABLE `tb_denuncia_usuario` (
  `cd_denuncia_usuario` int(11) NOT NULL,
  `ds_denuncia_usuario` varchar(400) DEFAULT NULL,
  `id_pchave_denuncia_usuario` int(11) NOT NULL,
  `id_autor_denuncia_usuario` int(11) NOT NULL,
  `id_denuncia_usuario` int(11) NOT NULL,
  `created_denuncia_usuario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_denuncia_vaga`
--

CREATE TABLE `tb_denuncia_vaga` (
  `cd_denuncia_vaga` int(11) NOT NULL,
  `ds_denuncia_vaga` varchar(400) DEFAULT NULL,
  `id_pchave_denuncia_vaga` int(11) NOT NULL,
  `id_autor_denuncia_vaga` int(11) NOT NULL,
  `id_denuncia_vaga` int(11) NOT NULL,
  `id_autor_vaga_denunciada` int(11) NOT NULL,
  `created_denuncia_vaga` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_escolaridade`
--

CREATE TABLE `tb_escolaridade` (
  `cd_escolaridade` int(11) NOT NULL,
  `nm_escolaridade` varchar(100) NOT NULL,
  `ds_escolaridade` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_escolaridade`
--

INSERT INTO `tb_escolaridade` (`cd_escolaridade`, `nm_escolaridade`, `ds_escolaridade`) VALUES
(1, 'Cursando 1º ano do ETIM', 'Cursando 1º ano do ETIM'),
(2, 'Cursando 2º ano do ETIM', 'Cursando 2º ano do ETIM'),
(3, 'Cursando 3º ano do ETIM', 'Cursando 3º ano do ETIM'),
(4, 'Cursando apenas o modular', 'Cursando apenas o curso'),
(5, 'ETIM concluído', 'Já concluiu o ETIM'),
(6, 'Modular concluído', 'Já concluiu o curso'),
(7, 'Não declarado', 'Não declarado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_estado_civil`
--

CREATE TABLE `tb_estado_civil` (
  `cd_estado_civil` int(11) NOT NULL,
  `nm_estado_civil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_estado_civil`
--

INSERT INTO `tb_estado_civil` (`cd_estado_civil`, `nm_estado_civil`) VALUES
(1, 'Solteiro(a)'),
(2, 'Casado(a)'),
(3, 'Prefiro não dizer');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_etec`
--

CREATE TABLE `tb_etec` (
  `cd_etec` int(11) NOT NULL,
  `nm_etec` varchar(100) NOT NULL,
  `ds_etec` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_etec`
--

INSERT INTO `tb_etec` (`cd_etec`, `nm_etec`, `ds_etec`) VALUES
(1, 'ETEC de Itanhaém', 'Uma ETEC da baixada santista'),
(2, 'ETEC de Peruíbe', 'Uma ETEC da baixada santista'),
(3, 'ETEC Adolpho Berezin', 'ETEC de Mongaguá'),
(4, 'ETEC de Praia Grande', 'Uma ETEC da baixada santista'),
(5, 'ETEC de Praia Grande - Extensão Balneária Maracanã', 'Uma ETEC da baixada santista'),
(6, 'ETEC Alberto Santos Dumont', 'ETEC de Guarujá'),
(7, 'ETEC Aristóteles Ferreira', 'Uma das ETECs de Santos'),
(8, 'ETEC de Cubatão', 'ETEC de Cubatão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_genero`
--

CREATE TABLE `tb_genero` (
  `cd_genero` int(11) NOT NULL,
  `nm_genero` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_genero`
--

INSERT INTO `tb_genero` (`cd_genero`, `nm_genero`) VALUES
(1, 'Masculino'),
(2, 'Feminino'),
(3, 'Outro'),
(4, 'Prefiro não dizer'),
(5, 'Não declarado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_municipio`
--

CREATE TABLE `tb_municipio` (
  `cd_municipio` int(11) NOT NULL,
  `nm_municipio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_municipio`
--

INSERT INTO `tb_municipio` (`cd_municipio`, `nm_municipio`) VALUES
(1, 'Cubatão'),
(2, 'Guarujá'),
(3, 'Itanhaém'),
(4, 'Mongaguá'),
(5, 'Peruíbe'),
(6, 'Praia Grande'),
(7, 'Santos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_nivel`
--

CREATE TABLE `tb_nivel` (
  `cd_nivel` int(11) NOT NULL,
  `nm_nivel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_nivel`
--

INSERT INTO `tb_nivel` (`cd_nivel`, `nm_nivel`) VALUES
(1, 'Aluno'),
(2, 'Empresa'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pchave_curriculo`
--

CREATE TABLE `tb_pchave_curriculo` (
  `cd_pchave_curriculo` int(11) NOT NULL,
  `nm_pchave_curriculo` varchar(100) NOT NULL,
  `ds_pchave_curriculo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_pchave_curriculo`
--

INSERT INTO `tb_pchave_curriculo` (`cd_pchave_curriculo`, `nm_pchave_curriculo`, `ds_pchave_curriculo`) VALUES
(1, 'Ajax', 'Este usuário possui parcial, ou total, domínio em Ajax'),
(2, 'C#', 'Este usuário possui parcial, ou total, domínio em C#'),
(3, 'C++', 'Este usuário possui parcial, ou total, domínio em C++'),
(4, 'CSS', 'Este usuário possui parcial, ou total, domínio em CSS'),
(5, 'Java', 'Este usuário possui parcial, ou total, domínio em Java'),
(6, 'JavaScript', 'Este usuário possui parcial, ou total, domínio em JavaScript'),
(7, 'jQuery', 'Este usuário possui parcial, ou total, domínio em jQuery'),
(8, 'SQL', 'Este usuário possui parcial, ou total, domínio em SQL'),
(9, 'PHP', 'Este usuário possui parcial, ou total, domínio em PHP'),
(10, 'Python', 'Este usuário possui parcial, ou total, domínio em Python');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pchave_denuncia`
--

CREATE TABLE `tb_pchave_denuncia` (
  `cd_pchave_denuncia` int(11) NOT NULL,
  `nm_pchave_denuncia` varchar(100) NOT NULL,
  `ds_pchave_denuncia` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_pchave_denuncia`
--

INSERT INTO `tb_pchave_denuncia` (`cd_pchave_denuncia`, `nm_pchave_denuncia`, `ds_pchave_denuncia`) VALUES
(1, 'Nome/título inadequado', 'Este nome/título inflinge as diretrizes da comunidade'),
(2, 'Plágio', 'Este perfil, ou postagem, se trata de uma cópia (parcial, integral ou conceitual) de uma obra'),
(3, 'Conteúdo inadequado', 'Este perfil, ou postagem, inflinge as diretrizes da comunidade'),
(4, 'Spam', 'Este perfil, ou postagem, se trata de uma quantidade excessiva de uma única informação publicação'),
(5, 'Informação falsa', 'Este perfil, ou postagem, possui dados inválidos/incorretos'),
(6, 'Discurso ofensivo', 'Este perfil, ou postagem, possui informações que ferem nossas diretrizes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pchave_projeto`
--

CREATE TABLE `tb_pchave_projeto` (
  `cd_pchave_projeto` int(11) NOT NULL,
  `nm_pchave_projeto` varchar(100) NOT NULL,
  `ds_pchave_projeto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_pchave_projeto`
--

INSERT INTO `tb_pchave_projeto` (`cd_pchave_projeto`, `nm_pchave_projeto`, `ds_pchave_projeto`) VALUES
(1, 'Ajax', 'Este projeto foi criado e desenvolvido baseado em Ajax'),
(2, 'C#', 'Este projeto foi criado e desenvolvido baseado em C#'),
(3, 'C++', 'Este projeto foi criado e desenvolvido baseado em C++'),
(4, 'CSS', 'Este projeto foi criado e desenvolvido baseado em CSS'),
(5, 'Java', 'Este projeto foi criado e desenvolvido baseado em Java'),
(6, 'JavaScript', 'Este projeto foi criado e desenvolvido baseado em JavaScript'),
(7, 'jQuery', 'Este projeto foi criado e desenvolvido baseado em jQuery'),
(8, 'SQL', 'Este projeto foi criado e desenvolvido baseado em SQL'),
(9, 'PHP', 'Este projeto foi criado e desenvolvido baseado em PHP'),
(10, 'Python', 'Este projeto foi criado e desenvolvido baseado em Python');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pchave_vaga`
--

CREATE TABLE `tb_pchave_vaga` (
  `cd_pchave_vaga` int(11) NOT NULL,
  `nm_pchave_vaga` varchar(100) NOT NULL,
  `ds_pchave_vaga` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_pchave_vaga`
--

INSERT INTO `tb_pchave_vaga` (`cd_pchave_vaga`, `nm_pchave_vaga`, `ds_pchave_vaga`) VALUES
(1, 'Diurno', 'Carga horária diurna'),
(2, 'Vespertino', 'Carga horária vespertina'),
(3, 'Noturno', 'Carga horária noturna'),
(4, 'Meio período', 'Carga horária de meio período');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_projeto`
--

CREATE TABLE `tb_projeto` (
  `cd_projeto` int(11) NOT NULL,
  `nm_projeto` varchar(100) NOT NULL,
  `ds_projeto` varchar(2000) DEFAULT NULL,
  `ds_site` varchar(200) DEFAULT NULL,
  `ds_github` varchar(200) DEFAULT NULL,
  `ds_url_projeto` varchar(200) DEFAULT NULL,
  `id_autor_projeto` int(11) NOT NULL,
  `id_pchave_projeto` int(11) NOT NULL,
  `arquivos` int(11) DEFAULT NULL,
  `created_projeto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `cd_usuario` int(11) NOT NULL,
  `nm_foto_usuario` varchar(200) DEFAULT NULL,
  `path_foto_usuario` varchar(200) DEFAULT NULL,
  `nm_usuario` varchar(100) DEFAULT NULL,
  `nm_completo` varchar(100) DEFAULT NULL,
  `ds_email` varchar(200) NOT NULL,
  `ds_senha` varchar(30) NOT NULL,
  `ds_cnpj` varchar(18) DEFAULT NULL,
  `nm_github` varchar(100) DEFAULT NULL,
  `ds_github_url` varchar(200) DEFAULT NULL,
  `ds_descricao` varchar(400) DEFAULT NULL,
  `ds_url_usuario` varchar(200) DEFAULT NULL,
  `id_genero` int(11) DEFAULT NULL,
  `id_etec` int(11) DEFAULT NULL,
  `id_escolaridade` int(11) DEFAULT NULL,
  `id_nivel` int(11) NOT NULL,
  `created_usuario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`cd_usuario`, `nm_foto_usuario`, `path_foto_usuario`, `nm_usuario`, `nm_completo`, `ds_email`, `ds_senha`, `ds_cnpj`, `nm_github`, `ds_github_url`, `ds_descricao`, `ds_url_usuario`, `id_genero`, `id_etec`, `id_escolaridade`, `id_nivel`, `created_usuario`) VALUES
(1, 'user.jpg', 'dados/img/ft_usuarios/user.jpg', 'Administrador', '-', 'adm@gmail.com', 'adm12345678adm', NULL, NULL, NULL, '-', '-', NULL, NULL, NULL, 3, '2023-04-21 23:37:17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_vaga`
--

CREATE TABLE `tb_vaga` (
  `cd_vaga` int(11) NOT NULL,
  `nm_vaga` varchar(100) NOT NULL,
  `ds_localizacao` varchar(300) NOT NULL,
  `id_pchave_vaga` int(11) NOT NULL,
  `ds_contato_email` varchar(200) NOT NULL,
  `ds_contato_telefone` varchar(15) DEFAULT NULL,
  `ds_vaga` varchar(2000) NOT NULL,
  `ds_url_vaga` varchar(200) DEFAULT NULL,
  `id_autor_vaga` int(11) NOT NULL,
  `id_pchave_curriculo` int(11) NOT NULL,
  `created_vaga` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_arquivo`
--
ALTER TABLE `tb_arquivo`
  ADD PRIMARY KEY (`cd_arquivo`),
  ADD KEY `fk_autor_arquivo` (`id_autor_arquivo`),
  ADD KEY `fk_projeto_arquivo` (`id_projeto_arquivo`);

--
-- Índices para tabela `tb_candidato`
--
ALTER TABLE `tb_candidato`
  ADD PRIMARY KEY (`cd_candidato`),
  ADD KEY `fk_candidato` (`id_candidato`),
  ADD KEY `fk_candidato_vaga` (`id_vaga`),
  ADD KEY `fk_autor_vaga_usuario` (`id_autor_vaga_candidato`);

--
-- Índices para tabela `tb_comentario_curriculo`
--
ALTER TABLE `tb_comentario_curriculo`
  ADD PRIMARY KEY (`cd_comentario_curriculo`),
  ADD KEY `fk_autor_curriculo_comentado` (`id_autor_curriculo_comentado`),
  ADD KEY `fk_autor_comentario_curriculo` (`id_autor_comentario_curriculo`),
  ADD KEY `fk_comentario_curriculo` (`id_comentario_curriculo`);

--
-- Índices para tabela `tb_comentario_projeto`
--
ALTER TABLE `tb_comentario_projeto`
  ADD PRIMARY KEY (`cd_comentario_projeto`),
  ADD KEY `fk_autor_projeto_comentado` (`id_autor_projeto_comentado`),
  ADD KEY `fk_autor_comentario_projeto` (`id_autor_comentario_projeto`),
  ADD KEY `fk_comentario_projeto` (`id_comentario_projeto`);

--
-- Índices para tabela `tb_comentario_vaga`
--
ALTER TABLE `tb_comentario_vaga`
  ADD PRIMARY KEY (`cd_comentario_vaga`),
  ADD KEY `fk_autor_vaga_comentada` (`id_autor_vaga_comentada`),
  ADD KEY `fk_autor_comentario_vaga` (`id_autor_comentario_vaga`),
  ADD KEY `fk_comentario_vaga` (`id_comentario_vaga`);

--
-- Índices para tabela `tb_curriculo`
--
ALTER TABLE `tb_curriculo`
  ADD PRIMARY KEY (`cd_curriculo`),
  ADD KEY `fk_autor_curriculo` (`id_autor_curriculo`),
  ADD KEY `fk_estado_civil_curriculo` (`id_estado_civil`),
  ADD KEY `fk_municipio_curriculo` (`id_municipio`),
  ADD KEY `fk_etec_curriculo` (`id_etec_curriculo`),
  ADD KEY `fk_pchave_curriculo` (`id_pchave_curriculo`),
  ADD KEY `fk_genero_curriculo` (`id_genero_curriculo`);

--
-- Índices para tabela `tb_curtida_curriculo`
--
ALTER TABLE `tb_curtida_curriculo`
  ADD PRIMARY KEY (`cd_curtida_curriculo`),
  ADD KEY `fk_autor_curriculo_curtida` (`id_autor_curriculo_curtido`),
  ADD KEY `fk_autor_curtida_curriculo` (`id_autor_curtida_curriculo`),
  ADD KEY `fk_curtida_curriculo` (`id_curtida_curriculo`);

--
-- Índices para tabela `tb_curtida_projeto`
--
ALTER TABLE `tb_curtida_projeto`
  ADD PRIMARY KEY (`cd_curtida_projeto`),
  ADD KEY `fk_autor_projeto_curtido` (`id_autor_projeto_curtido`),
  ADD KEY `fk_autor_curtida_projeto` (`id_autor_curtida_projeto`),
  ADD KEY `fk_curtida_projeto` (`id_curtida_projeto`);

--
-- Índices para tabela `tb_curtida_vaga`
--
ALTER TABLE `tb_curtida_vaga`
  ADD PRIMARY KEY (`cd_curtida_vaga`),
  ADD KEY `fk_autor_vaga_curtida` (`id_autor_vaga_curtida`),
  ADD KEY `fk_autor_curtida_vaga` (`id_autor_curtida_vaga`),
  ADD KEY `fk_curtida_vaga` (`id_curtida_vaga`);

--
-- Índices para tabela `tb_denuncia_curriculo`
--
ALTER TABLE `tb_denuncia_curriculo`
  ADD PRIMARY KEY (`cd_denuncia_curriculo`),
  ADD KEY `fk_autor_curriculo_denunciado` (`id_autor_curriculo_denunciado`),
  ADD KEY `fk_pchave_denuncia_curriculo` (`id_pchave_denuncia_curriculo`),
  ADD KEY `fk_autor_denuncia_curriculo` (`id_autor_denuncia_curriculo`),
  ADD KEY `fk_denuncia_curriculo` (`id_denuncia_curriculo`);

--
-- Índices para tabela `tb_denuncia_projeto`
--
ALTER TABLE `tb_denuncia_projeto`
  ADD PRIMARY KEY (`cd_denuncia_projeto`),
  ADD KEY `fk_autor_projeto_denunciado` (`id_autor_projeto_denunciado`),
  ADD KEY `fk_pchave_denuncia_projeto` (`id_pchave_denuncia_projeto`),
  ADD KEY `fk_autor_denuncia_projeto` (`id_autor_denuncia_projeto`),
  ADD KEY `fk_denuncia_projeto` (`id_denuncia_projeto`);

--
-- Índices para tabela `tb_denuncia_usuario`
--
ALTER TABLE `tb_denuncia_usuario`
  ADD PRIMARY KEY (`cd_denuncia_usuario`),
  ADD KEY `fk_pchave_denuncia_usuario` (`id_pchave_denuncia_usuario`),
  ADD KEY `fk_autor_denuncia_usuario` (`id_autor_denuncia_usuario`),
  ADD KEY `fk_denuncia_usuario` (`id_denuncia_usuario`);

--
-- Índices para tabela `tb_denuncia_vaga`
--
ALTER TABLE `tb_denuncia_vaga`
  ADD PRIMARY KEY (`cd_denuncia_vaga`),
  ADD KEY `fk_autor_vaga_denunciada` (`id_autor_vaga_denunciada`),
  ADD KEY `fk_pchave_denuncia_vaga` (`id_pchave_denuncia_vaga`),
  ADD KEY `fk_autor_denuncia_vaga` (`id_autor_denuncia_vaga`),
  ADD KEY `fk_denuncia_vaga` (`id_denuncia_vaga`);

--
-- Índices para tabela `tb_escolaridade`
--
ALTER TABLE `tb_escolaridade`
  ADD PRIMARY KEY (`cd_escolaridade`);

--
-- Índices para tabela `tb_estado_civil`
--
ALTER TABLE `tb_estado_civil`
  ADD PRIMARY KEY (`cd_estado_civil`);

--
-- Índices para tabela `tb_etec`
--
ALTER TABLE `tb_etec`
  ADD PRIMARY KEY (`cd_etec`);

--
-- Índices para tabela `tb_genero`
--
ALTER TABLE `tb_genero`
  ADD PRIMARY KEY (`cd_genero`);

--
-- Índices para tabela `tb_municipio`
--
ALTER TABLE `tb_municipio`
  ADD PRIMARY KEY (`cd_municipio`);

--
-- Índices para tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  ADD PRIMARY KEY (`cd_nivel`);

--
-- Índices para tabela `tb_pchave_curriculo`
--
ALTER TABLE `tb_pchave_curriculo`
  ADD PRIMARY KEY (`cd_pchave_curriculo`);

--
-- Índices para tabela `tb_pchave_denuncia`
--
ALTER TABLE `tb_pchave_denuncia`
  ADD PRIMARY KEY (`cd_pchave_denuncia`);

--
-- Índices para tabela `tb_pchave_projeto`
--
ALTER TABLE `tb_pchave_projeto`
  ADD PRIMARY KEY (`cd_pchave_projeto`);

--
-- Índices para tabela `tb_pchave_vaga`
--
ALTER TABLE `tb_pchave_vaga`
  ADD PRIMARY KEY (`cd_pchave_vaga`);

--
-- Índices para tabela `tb_projeto`
--
ALTER TABLE `tb_projeto`
  ADD PRIMARY KEY (`cd_projeto`),
  ADD KEY `fk_autor_projeto` (`id_autor_projeto`),
  ADD KEY `fk_pchave_projeto` (`id_pchave_projeto`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`cd_usuario`),
  ADD KEY `fk_genero_usuario` (`id_genero`),
  ADD KEY `fk_etec_usuario` (`id_etec`),
  ADD KEY `fk_escolaridade_usuario` (`id_escolaridade`),
  ADD KEY `fk_nivel_usuario` (`id_nivel`);

--
-- Índices para tabela `tb_vaga`
--
ALTER TABLE `tb_vaga`
  ADD PRIMARY KEY (`cd_vaga`),
  ADD KEY `fk_autor_vaga` (`id_autor_vaga`),
  ADD KEY `fk_pchave_periodo` (`id_pchave_vaga`),
  ADD KEY `fk_pchave_requisito` (`id_pchave_curriculo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_arquivo`
--
ALTER TABLE `tb_arquivo`
  MODIFY `cd_arquivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_candidato`
--
ALTER TABLE `tb_candidato`
  MODIFY `cd_candidato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_comentario_curriculo`
--
ALTER TABLE `tb_comentario_curriculo`
  MODIFY `cd_comentario_curriculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_comentario_projeto`
--
ALTER TABLE `tb_comentario_projeto`
  MODIFY `cd_comentario_projeto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_comentario_vaga`
--
ALTER TABLE `tb_comentario_vaga`
  MODIFY `cd_comentario_vaga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curriculo`
--
ALTER TABLE `tb_curriculo`
  MODIFY `cd_curriculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curtida_curriculo`
--
ALTER TABLE `tb_curtida_curriculo`
  MODIFY `cd_curtida_curriculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curtida_projeto`
--
ALTER TABLE `tb_curtida_projeto`
  MODIFY `cd_curtida_projeto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curtida_vaga`
--
ALTER TABLE `tb_curtida_vaga`
  MODIFY `cd_curtida_vaga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_denuncia_curriculo`
--
ALTER TABLE `tb_denuncia_curriculo`
  MODIFY `cd_denuncia_curriculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_denuncia_projeto`
--
ALTER TABLE `tb_denuncia_projeto`
  MODIFY `cd_denuncia_projeto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_denuncia_usuario`
--
ALTER TABLE `tb_denuncia_usuario`
  MODIFY `cd_denuncia_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_denuncia_vaga`
--
ALTER TABLE `tb_denuncia_vaga`
  MODIFY `cd_denuncia_vaga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_escolaridade`
--
ALTER TABLE `tb_escolaridade`
  MODIFY `cd_escolaridade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_estado_civil`
--
ALTER TABLE `tb_estado_civil`
  MODIFY `cd_estado_civil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_etec`
--
ALTER TABLE `tb_etec`
  MODIFY `cd_etec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_genero`
--
ALTER TABLE `tb_genero`
  MODIFY `cd_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_municipio`
--
ALTER TABLE `tb_municipio`
  MODIFY `cd_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  MODIFY `cd_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_pchave_curriculo`
--
ALTER TABLE `tb_pchave_curriculo`
  MODIFY `cd_pchave_curriculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_pchave_denuncia`
--
ALTER TABLE `tb_pchave_denuncia`
  MODIFY `cd_pchave_denuncia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_pchave_projeto`
--
ALTER TABLE `tb_pchave_projeto`
  MODIFY `cd_pchave_projeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_pchave_vaga`
--
ALTER TABLE `tb_pchave_vaga`
  MODIFY `cd_pchave_vaga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_projeto`
--
ALTER TABLE `tb_projeto`
  MODIFY `cd_projeto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `cd_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_vaga`
--
ALTER TABLE `tb_vaga`
  MODIFY `cd_vaga` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_arquivo`
--
ALTER TABLE `tb_arquivo`
  ADD CONSTRAINT `fk_autor_arquivo` FOREIGN KEY (`id_autor_arquivo`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_projeto_arquivo` FOREIGN KEY (`id_projeto_arquivo`) REFERENCES `tb_projeto` (`cd_projeto`);

--
-- Limitadores para a tabela `tb_candidato`
--
ALTER TABLE `tb_candidato`
  ADD CONSTRAINT `fk_autor_vaga_usuario` FOREIGN KEY (`id_autor_vaga_candidato`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_candidato` FOREIGN KEY (`id_candidato`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_candidato_vaga` FOREIGN KEY (`id_vaga`) REFERENCES `tb_vaga` (`cd_vaga`);

--
-- Limitadores para a tabela `tb_comentario_curriculo`
--
ALTER TABLE `tb_comentario_curriculo`
  ADD CONSTRAINT `fk_autor_comentario_curriculo` FOREIGN KEY (`id_autor_comentario_curriculo`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_curriculo_comentado` FOREIGN KEY (`id_autor_curriculo_comentado`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_comentario_curriculo` FOREIGN KEY (`id_comentario_curriculo`) REFERENCES `tb_curriculo` (`cd_curriculo`);

--
-- Limitadores para a tabela `tb_comentario_projeto`
--
ALTER TABLE `tb_comentario_projeto`
  ADD CONSTRAINT `fk_autor_comentario_projeto` FOREIGN KEY (`id_autor_comentario_projeto`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_projeto_comentado` FOREIGN KEY (`id_autor_projeto_comentado`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_comentario_projeto` FOREIGN KEY (`id_comentario_projeto`) REFERENCES `tb_projeto` (`cd_projeto`);

--
-- Limitadores para a tabela `tb_comentario_vaga`
--
ALTER TABLE `tb_comentario_vaga`
  ADD CONSTRAINT `fk_autor_comentario_vaga` FOREIGN KEY (`id_autor_comentario_vaga`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_vaga_comentada` FOREIGN KEY (`id_autor_vaga_comentada`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_comentario_vaga` FOREIGN KEY (`id_comentario_vaga`) REFERENCES `tb_vaga` (`cd_vaga`);

--
-- Limitadores para a tabela `tb_curriculo`
--
ALTER TABLE `tb_curriculo`
  ADD CONSTRAINT `fk_autor_curriculo` FOREIGN KEY (`id_autor_curriculo`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_estado_civil_curriculo` FOREIGN KEY (`id_estado_civil`) REFERENCES `tb_estado_civil` (`cd_estado_civil`),
  ADD CONSTRAINT `fk_etec_curriculo` FOREIGN KEY (`id_etec_curriculo`) REFERENCES `tb_etec` (`cd_etec`),
  ADD CONSTRAINT `fk_genero_curriculo` FOREIGN KEY (`id_genero_curriculo`) REFERENCES `tb_genero` (`cd_genero`),
  ADD CONSTRAINT `fk_municipio_curriculo` FOREIGN KEY (`id_municipio`) REFERENCES `tb_municipio` (`cd_municipio`),
  ADD CONSTRAINT `fk_pchave_curriculo` FOREIGN KEY (`id_pchave_curriculo`) REFERENCES `tb_pchave_curriculo` (`cd_pchave_curriculo`);

--
-- Limitadores para a tabela `tb_curtida_curriculo`
--
ALTER TABLE `tb_curtida_curriculo`
  ADD CONSTRAINT `fk_autor_curriculo_curtida` FOREIGN KEY (`id_autor_curriculo_curtido`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_curtida_curriculo` FOREIGN KEY (`id_autor_curtida_curriculo`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_curtida_curriculo` FOREIGN KEY (`id_curtida_curriculo`) REFERENCES `tb_curriculo` (`cd_curriculo`);

--
-- Limitadores para a tabela `tb_curtida_projeto`
--
ALTER TABLE `tb_curtida_projeto`
  ADD CONSTRAINT `fk_autor_curtida_projeto` FOREIGN KEY (`id_autor_curtida_projeto`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_projeto_curtido` FOREIGN KEY (`id_autor_projeto_curtido`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_curtida_projeto` FOREIGN KEY (`id_curtida_projeto`) REFERENCES `tb_projeto` (`cd_projeto`);

--
-- Limitadores para a tabela `tb_curtida_vaga`
--
ALTER TABLE `tb_curtida_vaga`
  ADD CONSTRAINT `fk_autor_curtida_vaga` FOREIGN KEY (`id_autor_curtida_vaga`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_vaga_curtida` FOREIGN KEY (`id_autor_vaga_curtida`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_curtida_vaga` FOREIGN KEY (`id_curtida_vaga`) REFERENCES `tb_vaga` (`cd_vaga`);

--
-- Limitadores para a tabela `tb_denuncia_curriculo`
--
ALTER TABLE `tb_denuncia_curriculo`
  ADD CONSTRAINT `fk_autor_curriculo_denunciado` FOREIGN KEY (`id_autor_curriculo_denunciado`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_denuncia_curriculo` FOREIGN KEY (`id_autor_denuncia_curriculo`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_denuncia_curriculo` FOREIGN KEY (`id_denuncia_curriculo`) REFERENCES `tb_curriculo` (`cd_curriculo`),
  ADD CONSTRAINT `fk_pchave_denuncia_curriculo` FOREIGN KEY (`id_pchave_denuncia_curriculo`) REFERENCES `tb_pchave_denuncia` (`cd_pchave_denuncia`);

--
-- Limitadores para a tabela `tb_denuncia_projeto`
--
ALTER TABLE `tb_denuncia_projeto`
  ADD CONSTRAINT `fk_autor_denuncia_projeto` FOREIGN KEY (`id_autor_denuncia_projeto`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_projeto_denunciado` FOREIGN KEY (`id_autor_projeto_denunciado`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_denuncia_projeto` FOREIGN KEY (`id_denuncia_projeto`) REFERENCES `tb_projeto` (`cd_projeto`),
  ADD CONSTRAINT `fk_pchave_denuncia_projeto` FOREIGN KEY (`id_pchave_denuncia_projeto`) REFERENCES `tb_pchave_denuncia` (`cd_pchave_denuncia`);

--
-- Limitadores para a tabela `tb_denuncia_usuario`
--
ALTER TABLE `tb_denuncia_usuario`
  ADD CONSTRAINT `fk_autor_denuncia_usuario` FOREIGN KEY (`id_autor_denuncia_usuario`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_denuncia_usuario` FOREIGN KEY (`id_denuncia_usuario`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_pchave_denuncia_usuario` FOREIGN KEY (`id_pchave_denuncia_usuario`) REFERENCES `tb_pchave_denuncia` (`cd_pchave_denuncia`);

--
-- Limitadores para a tabela `tb_denuncia_vaga`
--
ALTER TABLE `tb_denuncia_vaga`
  ADD CONSTRAINT `fk_autor_denuncia_vaga` FOREIGN KEY (`id_autor_denuncia_vaga`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_autor_vaga_denunciada` FOREIGN KEY (`id_autor_vaga_denunciada`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_denuncia_vaga` FOREIGN KEY (`id_denuncia_vaga`) REFERENCES `tb_vaga` (`cd_vaga`),
  ADD CONSTRAINT `fk_pchave_denuncia_vaga` FOREIGN KEY (`id_pchave_denuncia_vaga`) REFERENCES `tb_pchave_denuncia` (`cd_pchave_denuncia`);

--
-- Limitadores para a tabela `tb_projeto`
--
ALTER TABLE `tb_projeto`
  ADD CONSTRAINT `fk_autor_projeto` FOREIGN KEY (`id_autor_projeto`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_pchave_projeto` FOREIGN KEY (`id_pchave_projeto`) REFERENCES `tb_pchave_projeto` (`cd_pchave_projeto`);

--
-- Limitadores para a tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `fk_escolaridade_usuario` FOREIGN KEY (`id_escolaridade`) REFERENCES `tb_escolaridade` (`cd_escolaridade`),
  ADD CONSTRAINT `fk_etec_usuario` FOREIGN KEY (`id_etec`) REFERENCES `tb_etec` (`cd_etec`),
  ADD CONSTRAINT `fk_genero_usuario` FOREIGN KEY (`id_genero`) REFERENCES `tb_genero` (`cd_genero`),
  ADD CONSTRAINT `fk_nivel_usuario` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`cd_nivel`);

--
-- Limitadores para a tabela `tb_vaga`
--
ALTER TABLE `tb_vaga`
  ADD CONSTRAINT `fk_autor_vaga` FOREIGN KEY (`id_autor_vaga`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `fk_pchave_periodo` FOREIGN KEY (`id_pchave_vaga`) REFERENCES `tb_pchave_vaga` (`cd_pchave_vaga`),
  ADD CONSTRAINT `fk_pchave_requisito` FOREIGN KEY (`id_pchave_curriculo`) REFERENCES `tb_pchave_curriculo` (`cd_pchave_curriculo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
