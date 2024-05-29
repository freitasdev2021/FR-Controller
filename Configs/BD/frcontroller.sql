-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/10/2023 às 01:14
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `frcontroller`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixa`
--

CREATE TABLE `caixa` (
  `IDCaixa` int(11) NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `DTAberturaCaixa` datetime DEFAULT NULL,
  `DTFechamentoCaixa` datetime DEFAULT NULL,
  `STCaixa` int(11) DEFAULT 0,
  `NMPdv` varchar(45) NOT NULL,
  `NMSenhaPDV` varchar(10) NOT NULL,
  `STDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `caixa`
--

INSERT INTO `caixa` (`IDCaixa`, `IDFilial`, `DTAberturaCaixa`, `DTFechamentoCaixa`, `STCaixa`, `NMPdv`, `NMSenhaPDV`, `STDelete`) VALUES
(1, 1, '2023-10-01 04:06:46', '2023-09-25 18:17:20', 1, 'Caixa 1', '12345', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `IDCategoria` int(11) NOT NULL,
  `DSCategoria` varchar(100) NOT NULL,
  `IDFilial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`IDCategoria`, `DSCategoria`, `IDFilial`) VALUES
(1, 'Eletrônicos', 1),
(2, 'Higiene', 1),
(3, 'Bebidas', 1),
(4, 'Alimentos', 1),
(5, 'Capinhas', 1),
(6, 'Telas', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `IDCliente` int(11) NOT NULL,
  `NMCliente` varchar(250) NOT NULL,
  `NMEmailCliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NUTelefoneCliente` varchar(11) NOT NULL,
  `NUCpfCliente` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `DSEnderecoJSON` text DEFAULT NULL,
  `STDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`IDCliente`, `NMCliente`, `NMEmailCliente`, `NUTelefoneCliente`, `NUCpfCliente`, `IDFilial`, `DSEnderecoJSON`, `STDelete`) VALUES
(1, 'ClienteUmmmm', 'clienteum@gmail.com', '31934545353', '16885066672', 1, NULL, NULL),
(2, 'FR Tecnologia', 'frtecnologiadigital@gmail.com', '31983086235', '08901129671', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `colaboradores`
--

CREATE TABLE `colaboradores` (
  `IDColaborador` int(11) NOT NULL,
  `NMColaborador` varchar(100) NOT NULL,
  `NMEmailColaborador` varchar(100) NOT NULL,
  `NMCargoColaborador` varchar(50) NOT NULL,
  `NUCpfColaborador` varchar(11) NOT NULL,
  `VLSalario` float DEFAULT NULL,
  `DTAdmissao` timestamp NOT NULL DEFAULT current_timestamp(),
  `STFerias` int(11) DEFAULT 0,
  `STAcesso` int(11) DEFAULT 1,
  `IDComissao` int(11) DEFAULT 0,
  `IDFilial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `colaboradores`
--

INSERT INTO `colaboradores` (`IDColaborador`, `NMColaborador`, `NMEmailColaborador`, `NMCargoColaborador`, `NUCpfColaborador`, `VLSalario`, `DTAdmissao`, `STFerias`, `STAcesso`, `IDComissao`, `IDFilial`) VALUES
(1, 'Joao da Silva', 'joao@gmail.com', 'Atendente de Caixa', '16885066672', 1380, '2023-10-04 03:00:00', 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comissionados`
--

CREATE TABLE `comissionados` (
  `IDComissionado` int(11) NOT NULL,
  `IDComissao` int(11) NOT NULL,
  `IDColaborador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comissoes`
--

CREATE TABLE `comissoes` (
  `IDComissao` int(11) NOT NULL,
  `NMComissao` varchar(50) NOT NULL,
  `NUPorcentagem` float NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `TPComissao` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `compras`
--

CREATE TABLE `compras` (
  `IDLote` int(11) NOT NULL,
  `IDProduto` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `QTCompra` int(11) NOT NULL,
  `DTReposicao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `compras`
--

INSERT INTO `compras` (`IDLote`, `IDProduto`, `QTCompra`, `DTReposicao`) VALUES
(1, '1', 10, '2023-10-04 20:16:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contapagar`
--

CREATE TABLE `contapagar` (
  `IDConta` int(11) NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `NMConta` varchar(45) NOT NULL,
  `DTExpedicaoConta` timestamp NOT NULL DEFAULT current_timestamp(),
  `DTVencimentoConta` datetime NOT NULL,
  `STConta` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Pendente',
  `VLConta` float NOT NULL DEFAULT 0,
  `DSJustificativaConta` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `contapagar`
--

INSERT INTO `contapagar` (`IDConta`, `IDFilial`, `NMConta`, `DTExpedicaoConta`, `DTVencimentoConta`, `STConta`, `VLConta`, `DSJustificativaConta`) VALUES
(1, 1, 'Conta de Agua', '2023-10-03 03:19:24', '2023-10-20 00:18:00', '1', 50, 'Aqui Está a Conta de Agua');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas`
--

CREATE TABLE `contas` (
  `IDContaPagar` int(11) NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `NMConta` varchar(50) NOT NULL,
  `DTExpedicao` timestamp NOT NULL DEFAULT current_timestamp(),
  `DTVencimento` datetime NOT NULL,
  `STConta` int(11) DEFAULT 0,
  `VLConta` float NOT NULL DEFAULT 0,
  `DSJustificativaConta` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `IDContrato` int(11) NOT NULL,
  `IDPlano` int(11) NOT NULL,
  `STContrato` int(11) DEFAULT 1,
  `DSEndContrato` text NOT NULL,
  `NMContratante` varchar(100) DEFAULT NULL,
  `NMEmailContratante` varchar(100) DEFAULT NULL,
  `NUCpfContratante` varchar(18) DEFAULT NULL,
  `NUTelefoneContato` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `contratos`
--

INSERT INTO `contratos` (`IDContrato`, `IDPlano`, `STContrato`, `DSEndContrato`, `NMContratante`, `NMEmailContratante`, `NUCpfContratante`, `NUTelefoneContato`) VALUES
(1, 1, 1, '{\"cep\":\"35160208\",\"uf\":\"MG\",\"cidade\":\"Ipatinga\",\"rua\":\"Avenida Vinte e Seis de Outubro\",\"bairro\":\"Bela Vista\",\"numero\":\"2014\"}', 'Rayssa Kelleyn', 'rayssa@gmail.com', '53845659009', '31985145592');

-- --------------------------------------------------------

--
-- Estrutura para tabela `crediarios`
--

CREATE TABLE `crediarios` (
  `IDCrediario` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `NUCredito` float NOT NULL,
  `DTInicioCredito` timestamp NOT NULL DEFAULT current_timestamp(),
  `DTTerminoCredito` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cupons`
--

CREATE TABLE `cupons` (
  `IDCupom` int(11) NOT NULL,
  `IDCaixa` int(11) NOT NULL,
  `ANCupom` longtext NOT NULL,
  `CDVenda` varchar(50) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `IDFilial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `cupons`
--

INSERT INTO `cupons` (`IDCupom`, `IDCaixa`, `ANCupom`, `CDVenda`, `IDCliente`, `IDFilial`) VALUES
(1, 1, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"25/09/2023 - 15:04:12\",\"produtos\":[[{\"IDProduto\":\"2\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"0\",\"CDVenda\":\"0KBd1ZJ9A9\",\"IDCliente\":\"\",\"IDColaborador\":\"0\",\"NMProduto\":\"Desodorante\",\"DSCodigoProduto\":\"7791293022567\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"1\",\"IDFilial\":\"1\",\"NUValorProduto\":\"6\",\"IDPagamento\":\"2\",\"VLVenda\":6}]],\"valorpagar\":\"6,00\",\"pagamento\":\"Cartu00e3o de cru00e9dito\",\"IDPagamento\":\"2\"}', 'T45QfxDZKm', 0, 1),
(2, 1, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"25/09/2023 - 15:11:36\",\"produtos\":[[{\"IDProduto\":\"2\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"0\",\"CDVenda\":\"UmEKj1mSW2\",\"IDCliente\":\"\",\"IDColaborador\":\"0\",\"NMProduto\":\"Desodorante\",\"DSCodigoProduto\":\"7791293022567\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"1\",\"IDFilial\":\"1\",\"NUValorProduto\":\"6\",\"IDPagamento\":\"1\",\"VLVenda\":6}]],\"valorpagar\":\"6,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'B83p18wJjY', 0, 1),
(3, 0, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"25/09/2023 - 15:43:38\",\"produtos\":[{\"NMProduto\":\"Desodorante Antitranspirante Aerosol Men Rexona V8 150ml Rexona\",\"DSCodigoProduto\":\"7791293022567\",\"NUValorProduto\":5.7,\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"5.70\"}],\"valorpagar\":\"5,70\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'weRW5IV11d', 0, 1),
(4, 0, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"03/10/2023 - 00:11:09\",\"produtos\":[{\"NMProduto\":\"Desodorante Antitranspirante Aerosol Men Rexona V8 150ml Rexona\",\"DSCodigoProduto\":\"7791293022567\",\"NUValorProduto\":\"6\",\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"6.00\"}],\"valorpagar\":\"6,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'jCgLMYw5dh', 1, 1),
(5, 0, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"03/10/2023 - 00:22:11\",\"produtos\":[{\"NMProduto\":\"Desodorante Antitranspirante Aerosol Men Rexona V8 150ml Rexona\",\"DSCodigoProduto\":\"7791293022567\",\"NUValorProduto\":5.4,\"NUUnidadesVendidas\":\"900\",\"VLVenda\":\"4860.00\"}],\"valorpagar\":\"4,860,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'krenJwIxkK', 1, 1),
(6, 0, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"03/10/2023 - 16:22:05\",\"produtos\":[{\"NMProduto\":\"Desodorante Antitranspirante Aerosol Men Rexona V8 150ml Rexona\",\"DSCodigoProduto\":\"7791293022567\",\"NUValorProduto\":5.4,\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"5.40\"}],\"valorpagar\":\"5,40\",\"pagamento\":\"Cartu00e3o de cru00e9dito\",\"IDPagamento\":\"2\"}', 'O4aI1Zcyir', 1, 1),
(7, 1, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"03/10/2023 - 16:23:13\",\"produtos\":[[{\"IDProduto\":\"2\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"1\",\"CDVenda\":\"agol2fIyyc\",\"IDCliente\":\"1\",\"IDColaborador\":\"0\",\"NMProduto\":\"Desodorante\",\"DSCodigoProduto\":\"7791293022567\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"2\",\"IDFilial\":\"1\",\"NUValorProduto\":\"6\",\"IDPagamento\":\"1\",\"VLVenda\":12},{\"IDProduto\":\"4\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"0\",\"CDVenda\":\"ZBVTJhsIbN\",\"IDCliente\":\"1\",\"IDColaborador\":\"0\",\"NMProduto\":\"Bisc.\",\"DSCodigoProduto\":\"7898249280016\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"1\",\"IDFilial\":\"1\",\"NUValorProduto\":\"3.2\",\"IDPagamento\":\"1\",\"VLVenda\":3.2},{\"IDProduto\":\"3\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"0\",\"CDVenda\":\"RiSsweX8yS\",\"IDCliente\":\"1\",\"IDColaborador\":\"0\",\"NMProduto\":\"Refrigerante\",\"DSCodigoProduto\":\"7894900010046\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"1\",\"IDFilial\":\"1\",\"NUValorProduto\":\"4.5\",\"IDPagamento\":\"1\",\"VLVenda\":4.5}]],\"valorpagar\":\"19,70\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'spCkG2UXZR', 1, 1),
(8, 1, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"produtos\":[{\"IDProduto\":\"2\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"1\",\"CDVenda\":\"agol2fIyyc\",\"IDCliente\":\"1\",\"IDColaborador\":\"0\",\"NMProduto\":\"Desodorante\",\"DSCodigoProduto\":\"7791293022567\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"2\",\"IDFilial\":\"1\",\"NUValorProduto\":\"6\",\"IDPagamento\":\"1\",\"VLVenda\":12},{\"IDProduto\":\"4\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"0\",\"CDVenda\":\"ZBVTJhsIbN\",\"IDCliente\":\"1\",\"IDColaborador\":\"0\",\"NMProduto\":\"Bisc.\",\"DSCodigoProduto\":\"7898249280016\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"1\",\"IDFilial\":\"1\",\"NUValorProduto\":\"3.2\",\"IDPagamento\":\"1\",\"VLVenda\":3.2},{\"IDProduto\":\"3\",\"IDFornecedor\":\"1\",\"IDPromocao\":\"0\",\"CDVenda\":\"RiSsweX8yS\",\"IDCliente\":\"1\",\"IDColaborador\":\"0\",\"NMProduto\":\"Refrigerante\",\"DSCodigoProduto\":\"7894900010046\",\"IDCaixa\":\"1\",\"NUUnidadesVendidas\":\"1\",\"IDFilial\":\"1\",\"NUValorProduto\":\"4.5\",\"IDPagamento\":\"1\",\"VLVenda\":4.5}],\"valorpagar\":\"19.70\",\"pagamento\":\"Dinheiro\",\"IDPagamento\":\"1\"}', 'spCkG2UXZR', 1, 1),
(9, 0, '{\"empresa\":\"Estetica Rayssa\",\"filial\":\"Matriz Puebla\",\"cnpj\":\"02381997000100\",\"data\":\"04/10/2023 - 13:43:40\",\"produtos\":[{\"NMProduto\":\"Desodorante Antitranspirante Aerosol Men Rexona V8 150ml Rexona\",\"DSCodigoProduto\":\"7791293022567\",\"NUValorProduto\":5.4,\"NUUnidadesVendidas\":\"10\",\"VLVenda\":\"54.00\"}],\"valorpagar\":\"54,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'BqybJUh1fS', 0, 1),
(10, 0, '{\"empresa\":\"Empresa teste\",\"filial\":\"Matriz da Empresa\",\"cnpj\":\"02381997000100\",\"data\":\"04/10/2023 - 17:14:21\",\"produtos\":[{\"NMProduto\":\"Capinha Iphone\",\"DSCodigoProduto\":\"567890\",\"NUValorProduto\":\"15\",\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"15.00\"}],\"valorpagar\":\"15,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'gzcjGMfqHr', 1, 1),
(11, 0, '{\"empresa\":\"Empresa teste\",\"filial\":\"Matriz da Empresa\",\"cnpj\":\"02381997000100\",\"data\":\"04/10/2023 - 17:16:01\",\"produtos\":[{\"NMProduto\":\"Capinha Iphone\",\"DSCodigoProduto\":\"567890\",\"NUValorProduto\":\"15\",\"NUUnidadesVendidas\":\"15\",\"VLVenda\":\"225.00\"}],\"valorpagar\":\"225,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'nDEevoS6kD', 1, 1),
(12, 0, '{\"empresa\":\"Empresa teste\",\"filial\":\"Matriz da Empresa\",\"cnpj\":\"02381997000100\",\"data\":\"04/10/2023 - 17:17:19\",\"produtos\":[{\"NMProduto\":\"Capinha Iphone\",\"DSCodigoProduto\":\"567890\",\"NUValorProduto\":\"15\",\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"15.00\"}],\"valorpagar\":\"15,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'kDmR1BhUOS', 0, 1),
(13, 0, '{\"empresa\":\"Empresa teste\",\"filial\":\"Matriz da Empresa\",\"cnpj\":\"02381997000100\",\"data\":\"04/10/2023 - 17:17:29\",\"produtos\":[{\"NMProduto\":\"Capinha Iphone\",\"DSCodigoProduto\":\"567890\",\"NUValorProduto\":\"15\",\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"15.00\"}],\"valorpagar\":\"15,00\",\"pagamento\":\"Pix\",\"IDPagamento\":\"1\"}', 'hUAmfZllYI', 0, 1),
(14, 0, '{\"empresa\":\"Empresa teste\",\"filial\":\"Matriz da Empresa\",\"cnpj\":\"02381997000100\",\"data\":\"04/10/2023 - 17:20:33\",\"produtos\":[{\"NMProduto\":\"Capinha Iphone\",\"DSCodigoProduto\":\"567890\",\"NUValorProduto\":\"15\",\"NUUnidadesVendidas\":\"1\",\"VLVenda\":\"15.00\"}],\"valorpagar\":\"15,00\",\"pagamento\":\"Cartu00e3o de du00e9bito\",\"IDPagamento\":\"4\"}', '2tvIi7faYT', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `custosordem`
--

CREATE TABLE `custosordem` (
  `IDCusto` int(11) NOT NULL,
  `IDProduto` int(11) NOT NULL,
  `IDOrdem` int(11) NOT NULL,
  `NUQuantidade` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `custosordem`
--

INSERT INTO `custosordem` (`IDCusto`, `IDProduto`, `IDOrdem`, `NUQuantidade`) VALUES
(1, 2, 4, 1),
(2, 2, 5, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `devedores`
--

CREATE TABLE `devedores` (
  `IDDevedor` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `VLDivida` float NOT NULL,
  `DTInicioDivida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `devolucoes`
--

CREATE TABLE `devolucoes` (
  `IDDevolucao` int(11) NOT NULL,
  `IDCliente` int(11) DEFAULT NULL,
  `IDProduto` int(11) NOT NULL,
  `IDFilial` int(11) DEFAULT NULL,
  `DSMotivo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `IDEmpresa` int(11) NOT NULL,
  `IDContrato` varchar(45) NOT NULL,
  `NMFantasiaEmpresa` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NMRazaoEmpresa` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NUCnpjEmpresa` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `STEmpresa` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`IDEmpresa`, `IDContrato`, `NMFantasiaEmpresa`, `NMRazaoEmpresa`, `NUCnpjEmpresa`, `STEmpresa`) VALUES
(1, '1', 'Empresa teste', 'Empresa teste', '02381997000100', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filiais`
--

CREATE TABLE `filiais` (
  `IDFilial` int(11) NOT NULL,
  `IDEmpresa` int(11) NOT NULL,
  `DSEnderecoJSON` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NMFilial` varchar(100) NOT NULL,
  `NUTelefoneFilial` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `filiais`
--

INSERT INTO `filiais` (`IDFilial`, `IDEmpresa`, `DSEnderecoJSON`, `NMFilial`, `NUTelefoneFilial`) VALUES
(1, 1, '{\"cep\":\"35164127\",\"uf\":\"MG\",\"rua\":\"Rua Puebla\",\"cidade\":\"Ipatinga\",\"bairro\":\"Bethânia\",\"numero\":\"61\"}', 'Matriz da Empresa', '31345353534'),
(2, 1, '{\"cep\":\"35012160\",\"uf\":\"MG\",\"rua\":\"Rua São Felipe\",\"cidade\":\"Governador Valadares\",\"bairro\":\"Vila Mariana\",\"numero\":\"345\"}', 'Filial Valadares', '33945635455'),
(3, 1, '{\"cep\":\"35160008\",\"uf\":\"MG\",\"rua\":\"Rua Edésio Fernandes\",\"cidade\":\"Ipatinga\",\"bairro\":\"Centro\",\"numero\":\"23442\"}', 'Filial Centro Ipatinga', '31433432234'),
(4, 1, '{\"cep\":\"35160015\",\"uf\":\"MG\",\"rua\":\"Rua Edgard Boy Rossi\",\"cidade\":\"Ipatinga\",\"bairro\":\"Centro\",\"numero\":\"4234\"}', 'Filial Edgard Boy', '31922342423'),
(5, 1, '{\"cep\":\"35160049\",\"uf\":\"MG\",\"rua\":\"Rua Botafogo\",\"cidade\":\"Ipatinga\",\"bairro\":\"Vila Ipanema\",\"numero\":\"456\"}', 'Filial Vila Ipanema', '31923424242'),
(6, 1, '{\"cep\":\"35160072\",\"uf\":\"MG\",\"rua\":\"Rua Marte\",\"cidade\":\"Ipatinga\",\"bairro\":\"Castelo\",\"numero\":\"323\"}', 'Filial Castelo', '31933242342'),
(7, 1, '{\"cep\":\"35160100\",\"uf\":\"MG\",\"rua\":\"Rua Estados Unidos\",\"cidade\":\"Ipatinga\",\"bairro\":\"Cariru\",\"numero\":\"203\"}', 'Filial Cariru', '31432534535');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `IDFornecedor` int(11) NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `NMFornecedor` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DSEmailFornecedor` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DSTelefoneFornecedor` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DSEndFornecedor` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `STDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`IDFornecedor`, `IDFilial`, `NMFornecedor`, `DSEmailFornecedor`, `DSTelefoneFornecedor`, `DSEndFornecedor`, `STDelete`) VALUES
(1, 1, 'FR Fornecedor', 'frfornecedor@gmail.com', '34535353453', '{\"cep\":\"35171-026\",\"uf\":\"MG\",\"cidade\":\"Coronel Fabriciano\",\"bairro\":\"Recanto Verde\",\"rua\":\"Rua Tungstênio\",\"numero\":\"564\",\"complemento\":\"Galpão\"}', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordemservico`
--

CREATE TABLE `ordemservico` (
  `IDOrdem` int(11) NOT NULL,
  `IDServico` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `IDColaborador` int(11) NOT NULL,
  `DTServico` timestamp NOT NULL DEFAULT current_timestamp(),
  `STServico` int(11) DEFAULT 0,
  `DSOrdemServico` varchar(50) NOT NULL,
  `DSServico` longtext DEFAULT NULL,
  `DSNota` text DEFAULT NULL,
  `DTSaida` datetime DEFAULT NULL,
  `IDPagamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `ordemservico`
--

INSERT INTO `ordemservico` (`IDOrdem`, `IDServico`, `IDCliente`, `IDColaborador`, `DTServico`, `STServico`, `DSOrdemServico`, `DSServico`, `DSNota`, `DTSaida`, `IDPagamento`) VALUES
(1, 1, 1, 0, '2023-09-25 18:49:29', 1, 'Olaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaa', '2023-09-25 18:49:43', 2),
(2, 1, 1, 0, '2023-10-03 03:12:12', 1, 'Celular Caiu', 'Serviço será de troca de tela', 'A Tela foi Trocada e o Problema Resolvido', '2023-10-03 03:14:24', 2),
(3, 1, 1, 0, '2023-10-04 16:44:23', 1, 'aaaaaaa', 'aaaaaaaaaaaaaaaa', 'cccccccccccccccccccc', '2023-10-04 16:44:33', 1),
(4, 1, 1, 1, '2023-10-04 20:29:32', 0, 'Tela Quebrada', 'Cliente chegou na loja com a tela rachada', NULL, NULL, NULL),
(5, 2, 2, 0, '2023-10-04 23:03:34', 0, 'aaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaa', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `IDPagamento` int(11) NOT NULL,
  `NMPagamento` varchar(50) NOT NULL,
  `QTDesconto` float DEFAULT NULL,
  `DSMetodo` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `QTParcelas` int(11) DEFAULT NULL,
  `TPDesconto` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `IDFilial` int(11) NOT NULL,
  `NUJuros` float DEFAULT 0,
  `STDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `pagamentos`
--

INSERT INTO `pagamentos` (`IDPagamento`, `NMPagamento`, `QTDesconto`, `DSMetodo`, `QTParcelas`, `TPDesconto`, `IDFilial`, `NUJuros`, `STDelete`) VALUES
(1, 'Dinheiro', 0, '1', 0, '0', 1, 0, NULL),
(2, 'Crédito', 0, '2', 6, '0', 1, 8, NULL),
(3, 'Pix da Loja', 1, '1', 0, '1', 1, 0, NULL),
(4, 'Cartão da Loja', 0, '3', 0, '', 1, 5, NULL),
(5, 'Dinheiro', 0, '1', 0, '0', 7, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE `planos` (
  `IDPlano` int(11) NOT NULL,
  `NMPlano` varchar(100) NOT NULL,
  `DSPlano` text NOT NULL,
  `VLPlano` float NOT NULL,
  `TMPlano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `planos`
--

INSERT INTO `planos` (`IDPlano`, `NMPlano`, `DSPlano`, `VLPlano`, `TMPlano`) VALUES
(1, 'Starter', 'Plano Inicial JSON', 50, 30);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `IDProduto` int(11) NOT NULL,
  `IDFornecedor` int(11) NOT NULL,
  `IDCategoria` int(11) NOT NULL,
  `NMProduto` varchar(250) NOT NULL,
  `NUEstoqueProduto` int(11) NOT NULL,
  `NUEstoqueMinimo` int(11) NOT NULL,
  `DSUnidadeProduto` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DTEntradaProduto` timestamp NOT NULL DEFAULT current_timestamp(),
  `DTValidadeProduto` date DEFAULT NULL,
  `NUCustoProduto` float NOT NULL,
  `NUValorProduto` float NOT NULL,
  `DSImagemProduto` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `DSCodigoProduto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NULucroProduto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DSGarantiaProduto` text DEFAULT NULL,
  `STInsumo` varchar(45) DEFAULT '0',
  `TPIdentificacao` varchar(2) DEFAULT '0',
  `STDelete` int(11) DEFAULT NULL,
  `NUCustoTotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`IDProduto`, `IDFornecedor`, `IDCategoria`, `NMProduto`, `NUEstoqueProduto`, `NUEstoqueMinimo`, `DSUnidadeProduto`, `DTEntradaProduto`, `DTValidadeProduto`, `NUCustoProduto`, `NUValorProduto`, `DSImagemProduto`, `DSCodigoProduto`, `NULucroProduto`, `DSGarantiaProduto`, `STInsumo`, `TPIdentificacao`, `STDelete`, `NUCustoTotal`) VALUES
(1, 1, 5, 'Capinha Iphone', 41, 10, 'UN', '2023-10-04 20:13:24', NULL, 5, 15, 'data:image/jpeg;base64,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', '567890', '200', '{\"Tempo\":\"D\",\"Quantidade\":\"30\"}', '0', 'ID', NULL, 300);
INSERT INTO `produtos` (`IDProduto`, `IDFornecedor`, `IDCategoria`, `NMProduto`, `NUEstoqueProduto`, `NUEstoqueMinimo`, `DSUnidadeProduto`, `DTEntradaProduto`, `DTValidadeProduto`, `NUCustoProduto`, `NUValorProduto`, `DSImagemProduto`, `DSCodigoProduto`, `NULucroProduto`, `DSGarantiaProduto`, `STInsumo`, `TPIdentificacao`, `STDelete`, `NUCustoTotal`) VALUES
(2, 1, 6, 'Tela Iphone ', 10, 1, 'UN', '2023-10-04 20:32:34', NULL, 200, 300, 'data:image/jpeg;base64,/9j/2wCEAAIBAQEBAQIBAQECAgICAgQDAgICAgUEBAMEBgUGBgYFBgYGBwkIBgcJBwYGCAsICQoKCgoKBggLDAsKDAkKCgoBAgICAgICBQMDBQoHBgcKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCv/AABEIBAAEAAMBIgACEQEDEQH/xAGiAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgsQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+gEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoLEQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/AP38ooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPytVSDkipE6/hTaUEg5FclSEpPQ6C6rjy8jsKZ55zimRTgqR7Uh+8K52rFx2JfMkPaje54IoXoPpRVol7hRRRWgh0fenU2PvTqtbEPcKKKKYgooooAeoymKb5QXlacn3RTlAJwaAI9jelPRgCATT9g9TStE23hKAGt833aQqwGcUvzJ1HWnL8wGe9ADApIyBSEEdan2rjGKAoHagCALv8ApS+StTqAnQUu7/ZH5UAV/JWlSHDZWp93+yPypJDlemPpQAgYMgUdcU3Y3pTIwd5+Y9anJTs3NAETfL96k3Ke9SkA9RSbR6UAMCh+DSNbgnIp7R5Hy5pVUquDn8aAIvs3tR9m9qmooAjA2jHpSMCRgU9kHJptAEeCODQ6NgjFPKAnNNdycnFAERBBwaduG3Ge1Mkd+WAFEYdxkgUALRTvLf8Aumjy3/umgBtFKUZRkrSUAFFFB3fwjNG4BRSYl/uUYl/uU+VgNkkKNgelPHIpUTcMuOaUoAMilsAgBPQUhBBwaUMV6UhOTmgAooooAj8yT0pVmZfvVJu/2R+VIcN1A/KgBpMbg/NyRSogRfenCKDbu70lABSr94UqoCM08nIxgUAAViMgUwKWbgd6eHIGMUsaAHOepoAljIwRQgIYk+tNQnfj2p54oARwS2R604kYAoQBhk07YPU0FR3GqpyDin0DgYpQpboKChGVWTrz9KgeIl8MOKtqSq4Kj8aQxGRvmXA9RQVdWK6Jt+UVKOBz6VIluiHOc0hQbifele5Ethi/N92nqCBg0qoT91akWFiM7TTIGKpY4FSwqU+960uD/CtORSR84xQAZAbcelOKCXp2pDGCMDNPhVlBDDFBcdhsYEbbD604oxc8etSxxqxyfWmk4c/jQMROn40oBbpSxoCcZ709IwrYzQAzy933qPLI4ApwPJHpTwgIz3oAiKkdRTk6fjUywHbuxn2prR4OCMUrpgMAJOBS7G9KcEAOaWmAqxvtHy9qCjKMkVPFI4jADdvSlZ2cYY5/CldAVhw6t2B5qd/uH6UuB6CgjII9alu4Edr9z8ae/wBw/SkjjEYwDTiMgj1pAV6Kl8gf3jR5A/vGrugP0PooorpOcKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/LFtuOMU2iiseY6BYeG59amyvqKgHUVJkeorF002NOxMjqRjcM/WlDKxwCD9KZAEPJNPCAH5Bg+tLlSEOwfQ0YPoaQiQdXNOD4GCKYApC/eOPrS70/vD86ZK24DjvUdWtiHuT70/vD86UEHoc1Xp8UgX5cd6YiXB9KCCOop0b7h07UrLu70ACAleBUgX5cgemaIRhcfWnx8Ar6igBQBgcdqXJPGaOwHoKVPvCgBViEn3h09aQxhGxtwAfSpU6/hRcDLYoAiGN/PShyoPBFL5fvR5a9xmgBHB3ZA4pKepycFKdtX/nlQBFSFd/ANTFVIx5dN2BOQlAAYIQvfPtTVX5vu/pTtx/uGjcf7hoAXYG7gUhiAGQ360Ak9RiloAahKnJXP4UPlmzt/SnUUAMwfQ0YPoafRQBGBzgimupB4X9KcSSxGMc9aPm7tmgBhBAyQaayBhgcVJuIOCpIpuD6GgCLyO2aeIwiZDdugNOwfQ0hU46UAMyx6E0Zb1NOAC9TSFdxzmgBu0vwTR5HvTsFeRzSgkjkYoAZ5I/vfrSGNgcJk/SnsnU5pY8qckU1uBDlvU0HeOuRSOSsmNvfrT5JA4wB3qwEU8cmlyvqKZSgZOKTQCuobowH403aRx196Vl296cn3RUAMII6iinuBt5qMEnOT3oAcqknB4pXi9G/WnUUAR+URzu/WlX71PPQ02NCW54oAeV6YHbtQAfSngYGKQPk4xQA1Ad53Dj3qY7QOMVGSR0GaNx/uGgByD5s4p561HGxLYK4qYJkZzQA5NgXt0oVWYkAUxeo+tTwr/Fntik9BrcYI3PRTUsYXBwBThxj2pqJtzz1NLmLGSB95wDj2p6AkYc44706iddoU57VW6BiKNr5DZ9s05oC2WAPPNMi+/VhJNoxjtSSsQ3cjjj2jjn1p4D9ADSxDGfrTlO05piDAHQUYJ6ClUbjjNOUbRjNBfKhqg7ulSDGDSUUAlYIiwPJPWpAisTnHSmqucHNOoGCoVzj1pVB3ZIoVtoxing5GaABY933U/SpIkwfmX9KIO9SVLdgFTGcHpSOqE52j8qKKSdgI5IOfl/Q1JHahlzkUqoWOMYqWNCgIJqk7gQkBDtyOKO2akeNWJ/dnJ70+GEKNr4NFkBXLKv3mAp21uuDUk9skjDAAxShCqEZzS5UJuxFg+ho2t6GlDEtt208dR9aOVC5iPY/90/lR5cn9w/lU9PT7oo5UNO5+gNFFFdRgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAflZvb1o3t60BGJxilMbA4IrnOgTcx700k5ApwQ55HFSoIhnINA1FvYbCzBsA8VMHdztMmPcCmbkHAPFG9fWiyHyyXQmBKjAkLH0NHnAcEc96h3r60uDjd2pWRJKZA4wKSmRuvPNO3r60yJbi0dDmihQdwPrQIsRMFjDml8zd92kAwMGiSJ3XhsUASRs2BzUqkg1FGjKozzjvUisCetAErADGPShPvCgEPjae3elVSG5FAEidfwon+/j6UsKl22r1pJFJI9xxQAPE4HBpuCvDGpKKAAOv8I5pd7etJtQcgHNFAC729aCxPU0lKqlzgUAJRT/Jf2plAAUL9O1J5LU5UZ+lKYnAyaAGeS1HlgcEUtFAEdFPb7tRuuRwRQA1pVzgjpSbWPzA8U5bYEAn09aX7Mv+TQF0NaZVQECje3rTvIYcL0+tM3y+ooC6F3t60FiRgmk3y+oqMyOXK8daAGSAE4NOhAxjtT0QfximuUViAaAHJ1/ClKg9RRCFL4b0p7oM/IOKdmAwxso3Cmkk9TUmxvSjY3pSAhMRb5u1J5CtwoqyoO3bTTGq9BzRdgVngIPFM5U8VZYE8ioZgTgD1q76ADKCASKFAyBSkjAFAUnkCoAZKSDgetIwCrkDqKk2N6U1onJyBQAo5FFOMTgZxSbG9KABeo+tOYkDIoWJ+DinbG9KAIldjnJ71IiLuHFLsb0p6cIQaAAADoKKACelBIDbT1zQAU9fuihEbPTtTijAZIoARUXcOKmjAC4HrUIBJwKki+X71A1uTbRtzjtSKATg0pljIPzfpTVkRepqWi7oVwA2BS3PRfpRjf8AMp4NEylwNvaqWwm1Yji+/U1RpGytkipQjHoKCB4UAcCgcml2tjpRtK4JFALccFA6CloHIzT4uDn3oNLoQxMF3UIAc5FPPJ4o2N6UAIABwKMFuFNPEEhGQP1py28gPIH50XQDETA+bmnYJ4WpI4fmy9OMyDufypPyAbArLncakp9swYEipetCWgFepIo0ZckVLsb0pCCOtFkAqruIUU7y9v3qAwJwDS0wBwAAB6UgUDoKeWBQDPam0BdDH+8aSpTGrpz1qPY3pQTITABzik2jOcU7Y1KEORQSNp6fdFO2N6UbG9KAPv8AoooroMwooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8rC5NAkAGGNJnHOM0ACTlvlxXOdA7zPyo81PWm4A4owPQUBzOI7zU9aFYk4xTcD0FOjIB59KA9ox1GT60gOScGl6daBcyHkbFyO5oU5GaZuz/ABZ/GjJ9aCW7kysScGngkEH0NRA+hp6EkcmgRZznk96erFhg1BFLxtb9akB9DQBOnK4NKiDPU9KbCwC8mnoRnrQA+OIFs7jUhGDimDcOmad5p7oKAHJJsOPWnsfMBVeucj6UyMrJnKDj2p6gBsgYoAKKn2J/dH5UbE/uj8qAISuBnafxFJVtkDrsphtlHX+VAFenwffP0qfyE242Dp1xTYLfBOSaACq9XfIH941BHH5Z+aMEe4oASDofrTn+4fpUi7D0jA+goZVIIwOlAFSipPIG7r2prRMDhQTQARAM2DUnlJ6VGEkHIBpcTf7X50CauNYYYgetJQc55ooFyhUPl+lTUzyyvIY0CasRspU4NJgelSEZ+8PzoWJMg7vwoLWxHSiIsMgUkvHSq19fXNrZs1uMtnv2oAvRxszYKj8BUn2c+9cyfEHiESYheL6Y5pZfEmtYw94sZ/29qiqTSQHRiFi2MUpgK9QT+Nc5B4m1AYka+gbsf3gqrqHiu7gkCSatAuOQDKOf1rNTu7DasjrRGBztP5io3Me48npXF3XxIsYB5b+JbFZD1QyDIqOLx/Z3c2E8Rwe+18/yqhHZM2MhemaiI3Pz61l6Hq1tfXscMepmUOpIBGAfWtdNm/AwaAGmMn7tOAKjBqTAHQUeWrclqAI6Kk8lP79Hkp/foACMjFJsHqaQrIOxpMt0yaAHjgYopoD5wc9afg+hoASlUZOKcq/L939Kcq/N939KAESMlvlpzQtuJ29/SnDjpx9KXc3qaAGiNwcgUpyRtalyfU0BXbkAmgBoQA5pal8gf3jTktlI9fwoAgoqz9lHofyo+yj0P5UAMi/1Yp1L5ZT5QDx7UKp3fd/SgBKkTtRs/wBn9KXBHQGgB9B5GDSJnnOaWgAX7n5U9On401UwmQ2fxpyA46HrQA+Eb3xnFTpb7s/OPzqCEHdyKmwB0FNK5pBXRIF2DbnOKKjyfWlyfU0nBlco+nfZnYfc61Fk+ppVkkyPnP501CwcpYijaMYK4p69R9abkljk0p4BxT5Q5SSkZGY5FQ73/vH86lhZinLHr60cpICNwc4p2JPQUuT6mjJ9TRygJz3pVAJwaACTyKfgDoKkh7gBgYpNg9TS1JgegoEMjUDPFOKgjAFLgDoKPpQA3yn9KPL9af8AP705RxyPzoA+9aKKK6DMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/KnzPajzPam0VznQO8z2o8z2po5NP2L6UEyE8z2pUO9tuMUbF9KMbSCvrQSPH7ts9acfmGfWmHJwcUhmwNoGCO9AD1Xb3paRSSOaWgB6rtOc05GwduKSnIoPOKAHgZOM1YSMbchv0quEcfNu/CnRyyA4DUATg7TtxThnPBpgJLAn1qRcd/TigCeNiq8809WRv+WdRr9wH2qSNRjIHNAEoRVGQOtKvUfWg/dFCg5HFAFhRuOM0vl+9CdfwqRVBGSKAFVMHOadtT+LmgdRx2zUV1f2Vigmu5MBvu+h/GplKMFdsCUqOQDxjimqhHIOfwqFNXtpk3Q2MpyOHYFUH4nGaY+oSRjMk1og7bpwD/WsHi6K2dwLeD6GnNDEV4I/KsuXWJA+I7izI9ftP/2NINbmHIns/wDv/wD/AGNT9dpdn8ikrmjJEExspoQ55FZ769dD7txZ/wDf/wD+xpDr13jJuLLH/Xx/9jR9cp9pfchPc0mRFGdgphjDHIIHtWWdeumbaLiz/wDAj/7Gj+27n/n6sh/28D/CmsZSfSX3CNQxY/jFJ5fvWT/b90nzG6smHp9oX/Ck/wCEln/56WP/AIFCh4ukntL7gNFoCWJ3d6RoXH3cGsw+I7vPAsT/ANvYpD4juu6WZ/3b1R/Ol9cpdpfcBp+VL/dH50hRgccfnWb/AMJFdY/1Vt/4GrTf+Env2PzWdr/wG6XNNYyk+j+YNI0HJJ+6aQMM1mv4jvVPFpF+FylRv4ovl5NlEQOoFwnNaLFUmtgNOYcZrN1eF5rZkJIBPUVGfFU7D59MA/7ek/xqnqXiWcrhdOyD2FxGf/ZqHXgugGfeaDZOC87yE9OGIFY8/hbRWlLvp4bPZ3Zh+prbOtGQ/wDILnB9d0Z/9mqRLxJRubTp/TpH/wDF1P1iPYpJGLb6BpkQIGlQFccAIf8AGnJ4asS3mJpkW49D5P8AjWytzZhvm0266842/wDxVTwXmntIIjp1383Q5Xj/AMepe3pp3sUYk2hWqKN2nBW6DbEv+FOsPDlrHKS1mq88ZGK6SWxKJ5lnYXcgxnnZ/wDFVXtsNORLp19uz/FAMfzp/WYCshum6fuuwQgQKpXKntW5bQNEoiUfKg4yeazXvZrEF/7Iuiex8j/CpIddYFW/sq7yev7g0e3hvcGkafPp+opQF7uB7VS/t8/9Au8/8BmpRrinn+zrjPvC9NV6Te5Be8pf+en6UeUv/PT9Kqpr0RPz2EoH/XCT/Cnf25bnpZS/9+JP8Kr29HuBaIGOG/So/K+bdu/Sof7dsxyLSX8YZP8A4mkPiG1HW1f/AL9v/wDE0e3o9wLYEZIG3k98U/yP9v8ASqY8TWgAzC4A6/uz/hS/8JZpnq//AH7b/wCJpe3o9wLqxADBf9KVo1Vch8+wFUf+El05/mDPz/0zb/4mhPEWlhst5mPZGH9Kft6PcNy2c9lP5U4JkZzVb/hJdHHaX/vp6F8T6MCMq3XuDR7eh3HyS7lpFUH5hmpFxj5Riqj+JdDYcyhcd2//AF00eJtDxxfRgfUf40vrNBaNjUdNTQVGByyE1IpVeNu2qh1+xXhr+MfU1JFqmnzjL3CH0YnArRVKUtIsks9aKdHH5kfmRkFccEd6bg9cVW4CFMnOaAmDnNLRRZgFFFPCqR0ppXAZRT9i+lGxT2qrIBIRk7fapVG0YzQsOw7sU9Iy4yKLIBI+DipAAepxTREVOTSkA9RTtYpSaFwv979KNoPRqQQ7jkHj0p6w+Wc0DU3cTYfUUBCDmnUUFczJVlySdv60pfIxio4+9OoDmYVJE4CYPrUdPTp+NBndkkbB2KjtT/L96jt/9a30qagfMwQZ4pWXaM5pF4PHrUhAPWs3uSMVdxxmn06JFz070uxfSgBlAODmn7F9KDGACdtACeZ7U4HIzUdWLaNHjJYZx0oA+8KKKK6DMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/KvZF6GjZF6Giiuc6ACxA9DT/3PvTKVVDdaCG7jv3PvSqI2OEBzSbB6mhRsO5SaBDwdnDA1EyIWLbT1p7GRjnrQSSu3AzQAkQLEgVIowMU2JGUkmn0AFFFA5bFAE8TBVGT2p3lBiGOKhxjoTVhV28An8aAHImDkdKc3b60RfMwWpBAzHB7UAOiYKQD7VOr4IKnmoo4GLVKtuVbcSaAHFmk4NWk5xUMEKsm8k5qxGigDJPWgCVVIOSR0ps14lvEX2k7eWGOMe9QX+ow2UTNO23j5D/X3+lZupancWqKzsPMYAopHEfoSO5+vSsJ11FuMdwJ9S1R2RZHldFPIjXGfqAfu/Vufas2TVLkOzWYEZb70kgEkjf8AAiOPwAqO3tXnZ5TKzNI26R3OST6k9z9al/s0jkyDFcjTbu3cV0iu73MxXzXldQOA7ZxQIsnp+VW/JQJsAzxgGmJFsOSK1TXUG1Yg8kf7VMqxI5RsBR+VQlBgmlLl6EDGUt0qJlcE8j8qmHQ+xqGRyGA9TUgMfp1/SoX+9/8AWqVz2qJ/vGgBrgspAqu8JIJYd6sM5jG4AH61GZmPVRQBABgYpshYY24/EVKUBOaZMoUAigCPdL/sf980zEp/5YofoKflO5pvmN2pp2AjdZc/8e69KaVJBBiwakY7+WGabICoyrH6V1RfugRFCoIKdfaql0hDk7P0qZriU/xd6Y7l/vAU+a4ESvIpyAKety6jBxSucrjAqtOSDkHtRdgWReMpybjHtTftW9/MM5O3pg15h+1V+0p4N/ZV+FR+JHiuwuL+a6vksdI0q0IEt5csGIQE8KAFZix6CvKf2Nv+Ckvh39p3x5N8L/Enw4uPDWsy2rzaTtuxcwXhjP7xA2FKuowdpGCASDxWipynHm6AfVsOrzHCJK2M9M1dgu7jeGVnH/AsVixqY5du0KQegOcfjWrZwyPHuaRvzqeSHYfM1sTyyXM5O6VsZ/vE0iI4wN2fYMc0hjlThXNSpbsq+a0vT3pctO+wr3E2t33D/gZp0fy9biUewlNISD0Yn61NCsrLwq4/3RmiUIW2sAiJvOBPcj/dlNPVHjPFzeEf9dKekAIyRj6DFOEKgYAJ/wCBVHs4ANzc9Rf3n/fY/wAaDJOv39RvP+/n/wBepPKHpH/3zQYCegX/AICAKj2aAYLi7+6up3mO3740vm3w+7rF0PpMaeE/g8sZ6ZzTHR1zgdB6UeyQCefqP/QZu/8Av6f8aQXmoodx1a7/AO/rVIq/KNw5ocLtPyCj2SARNT1I8JrF0PrLUq6nq4A26zc57fvTUC7VOdgP1pd3OQB+VHskU1JfaJn1jXkwW1mdgezNmmnXNUGd18W9tgH8wajL7hhlFKJCBgAUezj2J+ZINX1MHab5GHvGv9RSrqTscXNnazg9ym3H/fJqus0THBUt7bacI4ZOfKxR7OH8o07MtW2o26SqINWvrMg8CL96n0IOG/U/Stmz8SapZBZNXt1vIM8XVk2Mf7wPT8a5swAfMkjgjphulLaPNZS+fbyMj9nUkH/649qag4r3dCro9Dgu4b+3F7aS7o2HX0xxRjjNcroniGdrhbWApHMzcptxHL7DsG9uldTZSrewPIPlZDhoz1z6/St6c5ST5guhaUISM0+SOJCBuPbvRgDgVcRjdh9RRsPqKdRVAKpAOTTt49DRsHqaNg9TQAo5GaUKW6Ug4GKA5U4HegB6jAxS0UUDW4UUU4ICM0DbTCPvT16j60w/IcDv61Iig8mgkdQAScAVIsKkA5PIqSKFF55oAakaoKdT9g9TRsHqaAFT5gAKXY3WljjZCGA9+akMpIxtH5VLTAZDIqfez1oDgnFBQE5pwhUHOTS5WAA4/OpnIZSR3FR7B6mnK3AXHHSjlYETDaM5z9KnhjbyxQUTsoH0oMrKdoA4o5WB920UUVuZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH5X4HoKMD0FS/J/cFHyf3BXOattkWB6CgLnoKl+T+4KQ7ey4oEM8onksRTjtUZIFPCZGc0GINweaAGKVI+WpABgcUgtyowKX5hxt6e9ACOAMYFNqT5e65pfk/uCgCKlCk8gVJ8n9wUnHYYoAYSehNWICSCTUUce+XGasAADAFAD4uOTU8bsDkc8VAgyAKnUbVBz6UASRTMG5GKm3EjJNRRhV5IzUo5HFAElucR7e9SvcrbLmQAY6e9R2qb2IzjiqeuXPlD1wfug9aipNU4OTKSTRWubsOkmoXJDbZdkSN2cc5/DqPfFULTzb+5KXL7izcue9SeIHW3kFoDxax4nx3kPzMfzNdN4F8GedbJqd8uVmA2Iwrg5twasihaaTKsDFYz+VNOm3EoOxT9MV6Ra6PZRwiB0yq9gKdPpuix8pZcdx6UcxnLc8yGnyqfLKNkdeKbNZyomQhP4V3uoppkWSlqB6ZrB1G6tEc7UH0xVEnJyxShizIcVG3GQfStW8voSSFix74rKk+YlvrQBFuAzk96gkddy89xU5Xdk571Xmj756UANcgniopGCtyevSpKhufvrQA2V1ZMA1HRRQBG0m1j83fpTJpGcDjGPSib7/APwKkZ9g+5nPvQJ7EZ6ZJpN6+tI6s/Q7R6UgGfyoBO4O4B4aopZWPrj1pXPzU2T7h+ldcHHkVxkHfJNRtIAxw1OkbavSoGk5PHekuXoA5XwfmamTkN909qa8wI4Gaargj5hiqA8m/bO/Zfg/av8AhJF4Jt/EyaVq2l6iL7Rr2WMtF5vlmNo5QOQjKxBI5BWvFv2Iv+Cbfij9nv4px/Fr4seNtP1C80+CVNMtNIVygeVdryOzhc4XIAA6HJzxX2AeSaAobgitoVZxhyLYC15ksx+0SHLNyxDE89+TzWrZ3iLEoyPTFZSHP7sD2q9YQuSPlB59ayk+UDQji+1OAH/Kr9t4dvrlNsILZHHFP0TTXkbzFTLZ9a7rw7pmqQbXtoYyV4+aplNJXA5C28E6qD88BGf9irS+E9RQBBGw/wCA/wD1q9QjOqqi/abK36cE1Os0vG7T4D6kKeaz9rKXQDyoeENTAysTH/gFB8I6iT80bD/gFetpehRhdJh/76P+FPGpFRg6XCP+2lP2j6oDxx/DepoSCvQ45So28O37DcUBxxkrXsK6zbCRvO8PwY39fNWlF/pd1Cc6Gi4Y/wCrdD+daAeNnQNQjG4gYHYLVebT7xGO5T+Veu38+i7WVtGbnqfl/pXM67FpzqxgsGXHTvQBwbKycMaa/wB01Y1QBbghUKg9jVd/umgBlFFFA27iFgoyTR5if3hTZ/uD61FSbsIn8+L+6aVZcj5F4qvQZGQYBpJ3Athxjk0ow/QZqqsr5BLVMr8ZU9aoCQjAK4+ore0LWJHQJFIRMigSkn/Xr6/Vf1FYCkkZJqayu2sbyO7RAwRslCeo71LjrdDW56DDF9ot0ushg3THenEDJ4rO8PahzJpMas4CCeJwOCr8gVpSALIUBz71rSlzxuWJgegowPQUUVqAUUUUAFIfvClpD94UAS0UU6PGeRnigBtSL0H0pfk/uChMbuRx6UAMcEkYHapQCq0km3IwuODTm6H6UATp0X/dqROn41GnRf8AdqROn40ALRRRQBIpO0DPalQAnkUi9B9KVTtOcUAPwPQUU3zPanUAFKFbqBSVIvQfSgBh3jqT+dJT36fjTKAPvCiiitDMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/LPI9RRkeop3kp70eSnvXOaDQQSBmn7F9KQRIDkU6gAAA4FKrFTkGkooAd5sn979KQux6mkooAKKdEgckGpPJT3oAhpyplN2Kk8lPej5UHlgGgCOD/WmpJA235WxSxRAZI61IkQJy3agBY1YAZFTxhmIBHFMwBwKmg7fhQX0JQgAGR2p0KhnKsOAOKG7fSnwRsCZCRgiggmgiA3Mo4AHf3rKmnW71oQKmfKmVseuCT/IVrK/kgF/ulsnFc7pNwJNRu5s4IS5IP0jC/8As4/WufFzXs1Gxa2KNy0l9rKwMnNxdg8c17XoXhy5gtUa5lSOPYMLnkcV41oI83WoMgnZIHTHUmvVkg1K8b7VOHbcBxuIFcZFzpLfSbHyy76juA67ay9YTTrfckdy351HbwyxDIlb3UHNQajYeaS7OencUEPcyr6S2MZ+cnng1h3bQvI+09B3+tbs9lHsIz2rD1KFYZG2rz3ouxGTdbQGxiqEiDcQB9au3ALksP1qqUJkLDvRdgVmXbxjvUMqgg8VamjbOcioChyTVp6AVcEdRUcqhgSRyBxU0gIPI7VHgucj9aLoCrRTniZOpFNpgMW3+0zCFfvOwVT7nivij9pT/gof8TNO8Xah4b+BradZabpV3Jbtqtzp4uZrx0fazKGO1EyGAGCSATnkV9r7xDIshz8rg8HHQ5r4S+Nv7Eninwp4n1jUtF0O91nTb2/muNOewhMv7p3LhHVeVYZxnvgc0AesfsM/tr6r+0fqmo/Df4i6ZZWviDTrL7bbXWngpHfW4cI+VJOyRSy5xwQeK+iQGHb9K+X/ANg39kfW/hP4pu/jB4t0e40y5m06Wy06zu5MOFkZXd2HUDCKoHuTX1HQBDIuBnHNRRwzzyiIP95sAVZfr+FMXdE/mIRwc8jNGoHl/wAev2w/2Z/2ddfh8H/FLxz9j1Oa3EwtorWWVwhONxWJWKAnoWxnHFcGf+Cnn7EUvA+I8y8c7tKu/wD43Wj8fv8Agn78A/2hviFP8S/E8usWWp3cMcV3JY3+xZdgwrFSrAsBxnjgAHNcQP8AgkP+zOox/wAJP4mY/wB43ic/+Q61jUUVawHUx/8ABSf9iGQbm+J+0f7djdAf+iqnt/8Ago9+w/LwPirF16/Z7lf5xVxb/wDBIb9nSVdqeJvESn1F3Gf/AGlTD/wR+/Z8/h8YeIgP+vmL/wCN1X1hLoB3yf8ABRP9iGRwo+L9qBn+Lzh/7Sq3F+33+xPLh1+OGnoPQyy/1jFebf8ADnX4Bkb4/G/iAHsTPEf/AGlSp/wR1+BhOV8fa8GH3SZIiB/5DqvrD7AeuWP7eH7D8kQaT44aazEckTv/APEVsaZ+29+xBcbdvxy05cnvdEf+yV4pB/wR9+FCDMfxL1gevyRf/EVfs/8AgkH8LwAI/iZrAGeMQxZ/9BpOrGfxID6R8L/tl/sVtIqRfHCxdCMnZdA8/ior0Hwx+1f+ylr13Fo3hr4v6ZNe3TiO0jmuEBZz0HavmXwT/wAEnvhbpdwgl+I2tOP7wt4mP9K9J0f/AIJc/B0XEUtz4o166jVwWUQwwlgOcB1GV+o5qXKkwPp+3m06+t1eXUTbuOHidjkH8aiuLO1BJh1iQjttkOKmt/CNlaWccEAWNEjVQC24gKNoGe/AHJ5JzVebTo7f91uyBwGC1MpJLQCs0Tb9o1WT6eZTmt2C5XU5P++zV228K212A4kO4+laun+ArOQgz3TLzzWfNfqByEr3cMjBtWmOTkAt3qpeXl6iYW/bH+02a7PVPh3DnK3RbH0rnNc8GywKwVmIPbNaqTvuBzlxcag/zm8YjOeDVa41CZEKtK2T3zWofC06gsFk47k1l6jaiJdrpk9jWqkgMW7/AHkuXOffNRSKoQnFSyxsrHOKikYY2dzT5kBACckVG0rhiA3f0qYRtknI5qJoXLE5HWjV7ARySORy3emb29aklhZVySOtM2H1FLRbgJvb1pV+YfNRsPqKfFEzA4I60XXQAUAkAjjNWI0UZAFRLCwYEkcGpVYL1oTAUlgcLTjGSvzfNngY9aIjl8ipyFEXFDklsBr+G9QaO1064wxxObW4+bG1ckq39K6rIJzknjv1rjtIPmaTdxHkpNDIPzYV2CneiTA8Mg/lU4ZqN4lRFoo7ZpVQt0rsKEp0ahjyKaeGK+lPi6n25oFdAUUE8UbFznFOKk/NSUDCgEjpRRgnoKAHqSRzT12jBz+tMQEDkUoGTigB0QDsd/QdKsCGMnBX9agQFQQaso4f5gPzoAYhO8qeg6CplAAphRGfeo596cXCfKVPTsKAHqATg07YvpTU+8KfQA9UXA47UbF9KVeg+lFACbF9Kk2L6U0ISM07ePQ0AGxfSl6UgYN0paAAgHrSbF9KWigD7sooorQzCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPy3ooornNAooooAKKKdFw/3c+xoAbRVg4ZDlADTIwqyEuBigBIOp+lSU4qDygFAt2Ybt2PxoAbSGNmbctO8ojkMTTowQfmoARF2qW74p0DFmwe+aY+S+FPGas2iqrfMo/KgAVARmpIuGxTTjPHrUidB+FBXMrEp5YD2FTxgYC+1QFWLKR0xzVuIAnOKCE7jLsn7JJn7oQ5Ncl4Yn863vZm6JFMUJ75kQV1upDGnXDDjELH8hXG+EOfDMz+sUvPrmYVx4vRxfd2NF/DZreAbJr/xfY2adXbHNfRI0fw/Bp0UbyRsVQAktzXz38O2uovFVs8A/eKGCflXrEWka9cqswlILKCcnjNc5k3c6CJdIikODCQPTrVLVVsZS2wJ7cVRXwzrpUyRyAAdR3qvcaFry5LTH86LokgvLa2EZIKg/SuY1q3UOSpBrdvNNv41Imn7c81jX9u8ZJL7vb0ougObuowqknrVR0CNgelaWolQcH8aybicqSDxip5kBHcMVPHrVcSHPIFLLOG6vjB71VaQrz5v05o5kUlclmkjyeKrmVAcUx5n5O4dPWq8jsW+8fwNCkmJqw+SVmOCBTaZub1NJuOcZNWpJCGzOQ3HY1EGIzjgHtmpGzuOfWmSdqFNNgAlYZ24GVwcccUgGc/Skop8yAY/3qjkchTwKlfr+FNYZBFHMgKW0elKB2AqeSLOM8UKgUYxmpc0wIWicjAT86FtpCMlRVvAPUUBSRwKNwGxxSBCM0+NWRvnGc9KXD+/505YXYjdn86rmQFiIqFJKjirNjcgttOSAe1RW9qxXJlx6ir+n2K5GKOZAb3h3WFt2Dtb52kda9A8NeJ7FMPcNsAPTODXDaLpyOAjHH411mkeF0faRL39aXOr2A7O41LRryJQbpTn/AGwSP0qvKmkTEKHBI9qSx8IxMg3TZ4GKup4TWI7kOc+9NtMBun2trGQ6EY9BSaveSQL+5TgnrV2GyNsuwxqOO1P+xQXPyypzUgY9tLFOQZUI9yTUd9JpKsY5VB991bR0y3jOWQAe1YHiHRrGRyU3bj3z0q1JIDM1abS4lzHIgH+9XG6+LQuXR8gHtW5rOgLtZhL0zjmuY1O0eNSvP4mrUrgYV5KjzHy/u1XdB970q0yBScjvVdv9Zj60c1gI6Y3U/WnTZDcGmbsDd+NNVrAMn6D61FUks3mLjHQ1HQ582oBUsHQ/WoqMkdDQpJAWKKhgYiT5zxmrO9V6KDT9ogCH71WlUMRGehqtEwe4QAc9xU0ZIuETPJcgD8KE7yAv+HGZ7K/GOTEmPwYf4112mzrcaXbyg9YwD9cVyPhGJpWvMZwbVcc/9NEro/B0nm+HIC3bK/k2M1dFfvbFRNHt+NPj6D60xvvUgJHQ12sbdgb/AFrfWnw9W/3aZ70AkdDQQT/wfhTKbGTvHNTUFJ2I6dGcN07U6nJ1/CgfMhpOe1Kv3hT+pxUir0GOaA5kIYjgFe/WpEXYMUICOv4UvJNA1qPVQBupyxFxkAUxQwPNO81k4FADxGynJpaPNLfLinIAc5FADl6D6UUUHqKAHp90Uynr0FLgegoAbH3p1GAOgooAKKKKAPuyiiitDMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/L7YvpRsX0pcgdTRkHoa5zQTYvpRsX0pcHriigBNi+lKqDOR2FFKuc4FADd6htrGlMEZ+YdT3pzKVI2jtTh05oARRtGM0FQTkilpRHK3KrmgBKBycUqxsD8zZ9qcFXPA5oANgxT422sOKRB/eFNBYOMUATiPHf9KkVMKDn0pi5YDmpo4zt6j8TQBJEqOuWXpx1qeHpx6VAgdTjt7VYhBx07UBaxDrAP9k3TBsYt3P6VynhCIf8IMZepMZB/Gaur1ttmi3eRybdsE/Q1y3hfEPw/Z2OflXH/f05rz8dU5XBeZa+Gx0vwqggHjS3n8vKrEzvk9MCvYxr9nb/ACqdwUkA4x3rzH4F6Ouq+NxabflewlPPbgV7OvgLTFhAlnO4Vxzqq9jHkkYcni2zLfLE+ex7VSu/E9uQTuP5V0cvgfR1baWYn1DVnX/gzSkRsM/5VjKrZ6Cs0cpqWvpIpwPXrXO6pqImBxj6V2Wp+ELER5SYjIrmNe0GC1GI5Cxz3o9qmByWoTjaWP8AOse6u0diSMZ962dXsCsZwcVzt/H5bNzj0FQ6kUBDdTIekmKrSyrt/wBYOlRyFmJ+Y1ASDw0g+lT7eF7FrYe1ypO3d+OKjeZd3D1E4AbIJ6elRSSbXxtJrWNWCeoPYtJOoblgaf56ZzkdKoC4A5ANKLknoDTdelfQmzL5Ksd27rz0pkoAxg5qFblNoyvb1pHnVh8q/rQsVC5XKS8+g/Ojn0H51D5h/uH86fg+351f1hdx8oPnPNJRjFDHAJp/Wqa3Ia1GydqYXUHBakmkOOGqHLMcnk0vrNILMteYvY5qSE7wfaq8aSKu6QDHrU9sRhuaaxNMLMep3DNTRqWxj1pkceUwVxxVq3j2oTjmmsTBsVmTW6MUzitHTY3JHFQ26rtxj61o6cAASAPar9vDsBuaHII2CvGCcg12Oj6hswy2468cVyuiRZZGJIGcHjiu30SwhdRuf65FL2sXsBtWmqyMiH7OTx2rQtr5yeIWJ9MdKXTtNtti4b8q29NtbGDmeQgewo52tx2ZmLdSyfK9k59xTLjzF+YWzL9a3xqOhwSYZie3Ip82oeHrpNu8ficUe1Qjk7y/Ean9yx+grnNZ1Zw5YWEnSvQb6Hw/INschJPTArLvdJ0lwSs3bnNHtkB5fquqyPn/AERwDnrXN6lch2IMTD8K9T1jSNDAKtOoPPcVw/iaz0qJnEV1yDxxmqjWQHD3bq7EquOOlVHKh8hu1Xb+MiRir5HY4xVCUIsnzHFHt1ewENxKFPQdfWo0YSR9hninTtGM4O761GJUVMBPen7SICMoXjcKTA9RSGVD1U0eYn9w/nR7aICbx7UAsfurn8aZT47gQgqR1pqsmADzM8pj3zTi5AzuFONyrJ9zqKYJIyD8lHtkBatBtkWTOcCrumKJ9Wt1PG5z/KqUTLtBTHSr+ghW1u0Xr8/T8K0hPVMC14Nl2veDb0iA/wDIin+ldB4LG3w9An95m5/HNc54Sx5l2B/zzTP/AH0K6XwYudAtiB0zn61vh5N19SomjIu0F89DTQcjNPm+4w96Yo6A13vcT3Cip/LT+6KPKU9EoEQx794wnerCq7fwGkSMBgdtSgkdDQAzy3/umhUZTkin729aASxA60ACLk7s1JHyc0FcYwvanIo7CgBacq5wc0Imc5U07aQOlBa2CnKoI5FNwfSpYkGzkUDAYY4AxTlXb3oCgHIFLQAUHqPrRg+lBByOD1oAkXoPpRQOgoyPUUAFFGQehooAKKKKAPuyiiitDMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/MBo8rzTVUKMCpG6GmDvXOaDkcBdvqMUbD6ikVXyDgYzT6AG7D6iliUq+TS0qfeFACv1/Cm06TgbqFQFQT3FADQhY5HaponCDmmBQvSloAbOXA3J60LIARuB5px4B4B470xFDtk9jxQBM33aI1JJH86UHBpy8nOOnpQA5VKkKfWpDkjApinc/PrU8SKeTQA+JT5YGOgqzB90fSoom/hwPyqeEAtj60AVPEYJ0C8PpA38q5XQDt8BIhHIVV/wDIr11Xic7PDV4w6mBsflXLaQpj8EwEdWjQt9S0hryM1kkoX7mlLqj0L9nVnPjtDHId7WkiBT7rXq2s/EHw3o2pvpV5BeTzRYDtBFlQfTqK4j9jXw6uufEqRJ4d6x6ezgflXr3iX4Y2Z126n+zrlpTyx7dK8HMMROlBcpKhfQ4i6+L3g6A5msNUx6rbj/4qsy8+NXgcwuVsNYP0tV/+KrtLr4UWs/Btkz7ZNZl58FrNkaNbdASP7teJLNa8C/YWPM/EH7Qvw5tIRHLomuFh3FovX/vuvPfFX7VXw009pJJNG11QAck2S9P++69j8V/s+Q3Fv/qeBkArxXiHxI+BsthHNItsDjIyQSRXBWzvEQvc2jSTsjj9X/bS+ECK3maZrxC9dtgn/wAXXNaj+2b8Fbhg8Om6+Mjr/Z4/+LrmfGnwvhtbpluLQEsSQSgOfrxXB6t4AiilOyzVQrYG2MV5VbievB2Rp9Uvuz1S4/bB+EEY/wCPfXhnt/ZgP/s9U5f2x/g4uQ0euj/uFDj/AMfrx+58DJITugzjpkYqlP8AD5C2RB3z1rjnxji4KysUsI7aHskv7ZHwdIwv9ucf9Qsf/FVXP7X/AMHpTvP9uf8Agr/+ua8al8CRx5LW61WfwXEGwIUH1bFcFXjfGwW4LCyTPbF/a7+DW794+tAe+ln/ABqQftb/AATbk3WsD66W3/xVeFL4KhBysCk9sLT/APhC1DALb4yOmyuKtx9jKfvJr7zaGFk0e8J+1j8FSAReat04zpbf40p/aw+DPe/1UfTS3rwtfAsJIPlHP0pT4JRSQU2/hmuV+I+ZJfZ+4v6nM91i/a0+CufLOpaoCO50t6f/AMNW/BX/AKDuqf8AgqlrwNvBuTxGD79KT/hC3/55D/v5UvxJzJfy/cNYCUz33/hq34K/9B3VP/BVLSD9qv4KOdv/AAkOpDPrpUteB/8ACFv/AM8h/wB/KRvBeBk26/UNk0v+Ik5l3X3Ff2a+x7+P2oPgqenie/8A/BTL/hTov2nPgaWzJ4lvM986ZMP6V8/L4OjbrCfypR4LbOY4uO2aqPiZmSetvuB5Wl1PouD9pr4E4+bxPdD66fMP/Zas237TXwG8znxZcdf+fKb/AOJr5w/4Q19u0wjH+/mnQ+DCGyIk69+a6qfiXjpRu0vyJeVyezPpiP8AaQ+BjsCvjSQD/bsJcfj8tXLf9or4IOQB47iH1tJh/Svmm18IS7wPNOM9McVoQ+DpkG+J8kY42DmvUwviDiqkfea+4xlgLaM+mLH9oH4JuwUePYuO/wBmlx/6DXR+HPjT8INWnWCw8bW7t6GGUf8AstfMeieC72ZQYwGOeCVGD+le3fBT4c2R1i1e/soniLbmXAIYdCPw5r1MPxliq8rNGX1S2x9DeEYPDmr20c0XiG2ZZdpjKq3P5gV6JoXh7SZ4BbrqcW/qXyefbpTvhV8OfBqQxyR2SODhY2UY25HYCvVdJ8J6dZRAwYTdg/MmRjFfSYbOZ1o3ZnKjyo4608K2EYQjVIjn/pp/iKvr4Zg4I1GDHvJ/9au+ttLtTtWOCKTH/TMCrEtlGnB09BxyNo4r0Y5lV5dTCzvY85k8JWEvP9pQA+vmf/Wpn/CHQI37rUrfH+9/9avRktbXPNgp/AUG3gziOwUD0yP8Kf8AaUuwcsjzq88HxCM+TeQn2+0Cse98I4ypniGT1Mma9Wl0q2mOX02EntkVVvPDmmtGfNsIV7gbOtNZk77DUZM+f/FOjrbEquqWSjn79wFxXnPiK90K3k8u58RWQd84/wBLT/Gvof4gfD7w5PB50unQMTnqg4r5F/aG+HGmB5VgtIIwH+UxgZ615lfPp023bYapybsWdS1zwpHlZfFumgjjBv4+f/HqybjVNGkYuviPTT6Zvo/8a+b/ABN8MoUeR47Nfl6EgH155Fc3c/D5lQo1omfZAf0NefLiya3iV9Xlc+sBf6Y3TWrU/wDXO6Tn8qJJLeT7l7Ac9Mzrk/rXx7N4IljcqIAP+2YH8qhm8GTqMKjf9/GH9ayXF/aP4lPDp76n2JKoUAC4iyT2lB/lT4YbxhiMRt/wOvjM+D71RlEkU+vnv/Q03/hG9YRsrNcD/dunH9af+uEv5RfVY9j7QNnPjhM+wNH2SfHzR4+pr4ybSddQbv7Svh7rcuD/ADpv2PxFEp2a7qS/S/lXP5NVrjFPeOgfVo9j7RNteKFXym+YcEAmkSzvB96Fj/wE18X/AG/xhbYFv4q1VSvAxqM3H47qik8S/EW3yU8bawM+uqTf/FVtDjGP2YfeH1WPY+1ws0LhXjYcE4xz+XWtnwntl8SWKBTkyHPsdpP9K+F9H+JXxP0a7iu7fx9q6uk6tta+Z1fnowYkMPrX3f4IEUnjfSbZgfnfcxHqYmP86+iyfPIZhe6MZ0lBkfg1s3F9/uqo/wC+hXV+ASG8Pxkdy388VyPg1it5dRDoduf++ia67wMPK0CIL/fI5+ua+qwUlKroZS2Lz/fP1pKkVFc5PcZpTCgB616j3IEjlO75jxUysAKqhSxAU1OgKrg0ASgg96KjVH3Bs8fWpKABuh+lPt/6Uxuh+lPt/wClAEtLF1pKWLrQA+huh+lFDdD9KAHRdPwqVPuiooun4VKn3RQVHcWilUZOKdsHqaChV6D6UUDgYooAKjqSk2D1NACR96dTT8nTvQHJOKAHUUUUAfdlFFFaGYUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+YTAkYFIqkHkVJ5fvR5fvXOaDT14op3l+9Hl+9ACBSeQKArA9KeBgYpQMnFACHkClCtjgUvl+9OAwMUANBKdR1pS4I5pJO1NoAdGpAwRS5VaWmv1/CgCQsCmAe1LHDIx3BeB15pi9B9KsQvtUjHU0ALsYrkLUiAsAB2PNRGZ0+UHj0qxGgUA5+8c0ASqjYHHapraNywwO1MXoPpVm2Taw57UdAMzxcDH4WvWfjFs9c1Zgjwdaqo5W3iyPxkNdP42AbwnfqTj/RzXNQKYfCcBbvDF/KSvCzV8yp/wCI0p7n0F+whZmfxvqk7DHl6KMkdjuQf419D3+mR3d5LcKAQ7krXgf7BUYHi7XBnppCf+hivogDaAM181jZNxT82ior3jNTQId3zjill8P2RHKVo1HcA4GDXi1bXsdkHdGPc+GbKdDHJEuCMAn3rzz4m/C7Sp9OnAt1JYfLXqk7bIl57DmuV8aX4WBxMwIxxXh46KsaRtzHwx8Xvh4tpqkn7hRsJC15JrngxkkYtEOemDX1D8aYILrU5mWME5NeQ63paeZvMQ6dMV8FmdeVOR3ULanjF/4UMbkSBhz2rPn8PBeMEehr1TUtFjlYv5H4YrJu9BQjAiX8a+arY9pbnWqcJanmt14eODl/zFU38NRk7pFU/UV6Jd6FGCQygfQVTm0NMfKoI9xXhYrMG4u7OuNGDZwsfhpFbIRSfapBoAHUKP8AgJrrJNKRVyEx9KhfThno3SvmpZi3J6m8aEEjmf7HiBwcn2AqNtF5JSIjPqa6r7BDj7nNMk09OMR4+lSsYr3uX7KByZ0KUn/U00aICcAH8xXUtpYZtw3fTNK2mR44THviqeNb2D2UDlx4fY9EP5il/wCEefHMS49c81066dgcD9DQdNXBPl8+tL61K17h7KBy/wDwj6/3TR/YrL8ogJHrurqBpYwCQaP7LX0NL63Ml0LnNxaD5jYCZ+tTp4bGQfKWujTT4lTco5xU0NirJnaetS8bUT0Y1RitzFtPDqgAmNcfStOy8NwsQwxgeladrZIQCRitO2s0KqEj7817WDzN2WhnKlFkWhaAVnKpECuR1716z8LPDIF/FArlcyBeOgHXP51x+hRLCwBQce1ep/Ctkj1iPEfcV95lGNdWSRwVaSW59JfDPQZ4tLhBlzgDnHSvULTTnWRFEgI8vkVwfw/vXFlEiAYOK9E059865bnys4r9Oy+bskjy61kiWCzZHyRgetSywzSDaFGB0O881JT0+6K91Tk1Y4L3d7FVLOUHLKB/wPNNmhuvuxxH8MVdpQxHQ0+aQ7+RmmOYDLIcH1qC9INu3yHocVf1KYmDDKWPqBWRqE15HahlQ4wcVlOrOEWyoWcrWOC+ItvNJYyIkjBj0wDxXzP8VPDVzcXEjzO78nhu1fTvi/Ubpo2jMPBzg4rwj4lpdyysGj4yc5FfLZjXk07s7aMY3PnLxD4WLXMm2IEbuMiuU1Pww0c6/uW2nqSK9j1uwBYn/wBlrm9U0dZcFgePUda+NrYuUG9Tt5InmEvhjdKx8vv2qrL4VUEkovXuK9ButIUOWC4/Sqc+lc8xfpXL/aHmHJE4UeGsHCxAnuNtRzeHFVsyWw/Ku3XSV3njHH0pJdGjc4IP4GpeYPuUqcWcNL4biCHbEQfWoZPCyum4oCB/eFd3/ZH/AEzI+pzUdxpPy48vP4VTzDzE6SS1PN77wtbge/0rA1TSFhdkAr1q80m3WLe8XI7Y61xPirTkErBI+uc4Fb4XHOVTcxqU42ueeXVqFmjjHX7Qn6mvvbwMpfx9pOzkjIP/AH5NfCWoRGK9jBPPnxn/AMfr7w+HoLfELS1/2n/9FNX6vwfVcuZnkYh7lPwLg312CekY/PJrrvATb/DcLepP865HwIoN5dvn+AcfnXW/D3/kWIPrX6rlcnKrLy0OCWxqKwXBY/w08OjHaD1qJ/ur9KEba4OOley9yCVIChzT1IX5T1o8z2pM7nzj0oAkCkjIFJT1/wBWfpTKAA8g1Jbo3p2qOp7f+lADtjelKilTyKdRQAUYLZAopU+/+NACxqVHIqVPuimU9PuigqO4oBJwKXY3pQn3hT6CgUHAFLsb0pDwDTN7etADyCDg0UikkZNLQAjgnoKaFYHpT6KACiiigD7sooorQzCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPzE+f3o+f3qXYfUUbD6iuc0Ivn96cmec5p+w+oo2H1FADUB38jipABngUijAxT0X5h8w/OgBMH0NG1vQ08jHegnb82OlAEZHqKMD0FLnzDwCPrS7D6igBtGAeop2w+opNp3bcUAOUDA4HSnx5OcU0qVTJ7CnwHkkjrQA5YGd/mGAPUVZjUlhkcUCNicZFSxIc7cigCRApI4Hap4fv/AIVXXKtsxz7VZiBUgn0o6AZXjjjwpfH/AKYHmucuCx8N2yZ48qLH/fLf410fjwhfCF83qgH5mudYbtAtP92H/wBANeDmrSVNP+YunufRn7B0mPFmvEH/AJhsaKf+BCvoNLkMCMZweea+cv2GZWj8Ra1MD0tlH4F69vHiGytpGS4kG7cRnd718rj6kIwSb6s0ppuR0AmDHABFNn3FRjP1rBj8X6f5u0XA4/2v/r0XPjLTlGBeLkdfmFeDiMXCGiZ2U4ysal4xWEHPRRmuL8aW73NrIxyQOR7Ve1H4gafDHhrpSMdjXK+JviFpktrJFHcrk9s14mMxdFp2Z1wg7rQ8T+Kdk0c8kiqSeegryvVY2kJypP4V6n8SdWiuvMkjb7wPQ15relcktmvzvNaylNndSg1B6djlr+J4yQQfyrHvFLFsjntXT6nHE2cg8HFY17HCG27Tn6V8fiZ3dzvilZHP3lu201TkgXaMkVtXkSlDxWdLAojLEdM183jptXsdUUrmTKu75PU0z7Ju5wPyq3LCqneRnHpTNyj7qn8q+bdRNssqmwAy2B60x7Rz91Afwq8MHrQQo+6KfO0OzKH2WQcFce2Ka0W1c7CPwq+yEnNIYISMbKuNWQWsZ4RugU0jK2CCp/KtFIIlOdtI0G4kbyAfaq9rIRmqCRhvwpREGPDD6VfNkndyfqKFsow2SBTVVjuyBLNGjIjJzj0qWC0KRgE/mKnWOFB8keD65qSMIRgjnNTKqm9WLcZbQeWpB5yeK0dOUMRtOOaht4kzgitHT7eNWUAda7MHVqqorvQEk2aumW3BcuM/Wu88B3/2LV4v3nPHeuJs48PsBBz0rtvBlratqsRlB4A5FfoeTVnzxOOtTTPpL4b+LkS1SJyMjGMivStJ8VW7OsiqchcHNeUfD/RLSWCOSJ+doANej6TpUIAdWGRzya/U8txFTvoeRXpI7C31mKWMP5Y/OpBqKEZHH41l2flrCFVgPenb2bIU8Doa+l+tJpWZwSpwNSLUY93JB49adJebxmJfyrFSdkfkGrKX2wbiD+dUsSrbk+zRoidsbRJ+GahvIhLDxg4bB+lVk1SLJOQuB1NV59ctxGxMyj36VNStBQd2XCNpbGX4m0CO5iMwVQAMk4rw34taHFArsNo4PpXtmteJrf7I8fnDB469q8a+LOr29xGwG3HNfLZlUpuLszppp8x4TrkaLdOuARniufvhlWAHeuq19onuXKRrgHJrAuLMB2zjmvg8ZK0mdtmYMoUNgAe9QTQK3TFak9tGr5I6ntUUlmgBOBz0rzXVaKjF9jH+zqjkhR0pTbhjnA/KrwtBvOcdKU2ihc8U1Ui92aqndGc8EYU5jqGa2VoyVUflWjLCrJgCoJotiFh0HNNzTW5Vn1MPUrDdCCSPfNcL4ts9kzFT7cV6TqUa/Z8kdua4Hxgiq7OP72K6sHJe0OWcZJ6nmGqWu7WYhIuQZ0GD/wBdFr7m+GKtJ8SrBWBwFmI9sQyH+lfEWq86zAvrdxj85Fr7q+ElsLj4m2qjjbBdHn2tpa/ZeCZXizxMfZSVjC8AApJdFm57kn6113gWNl8M25VsZ5rkPBTBZ71cE9/zD12/gplHhS0UoMiHbnHev1/K/jn6nmSLkEbb183kbe9SGNAeFHWiM7+B2GKfsPqK9xkjacgGM4o2H1FKoIGDQA5Cc4zT8D0FNVTkGnqhYEjtQAqohGSop8YAPA7U1eFzT4+efagB1FA5OKdsPqKAG0qff/Gl2H1FCoQ2TQA6lDEcA0lKEyM5oBXHRMS4BNS1HGmHBzUlBauH1pPk9qU8jFN2H1FAxwx2opFGBiloAKKKKACiiigD7sooorQzCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPzO8l/ajyX9qdsb0o2N6VzmgwxOBk02pdrDtQAT0FAEVLFGrPgipPKB5NGxvSgAKhTgUh4BpQjB84p55HTPtQBHF8xO6n7F9KXK7QAmPxooATYvpSfdkwB6U6mv1/CgB4AY4PehgFhDjrmki/i/3afEodWBPpQBYgdmXeTzU0QY8r1qG2jZUAxVmCHyhQA6JJC+SBU3TrTApPQVJB8rkH0FAGP4+/wCRNvf+Afzrnjx4etT/ALMP/oFdJ8SBnwndgD+EfzrAvwV0q0HTEUf/AKKFfPZ1vD/F+hpT3Pdf2MZPs+o686tjEKD/AMeNdTq2pz3ly7Kzg+aw+X6muN/Y5P2i812PP341289eteqWHhS1njErgEEk5z718TnMPaWV7bs2o/GcjAl3JKVZ5ufQU+4025kbIEvvkV6JZeFrBVwsaZ9QOamTw9ZRnlQeeea+PrwVtWd9Lc8tudJujCRsJxwMmuf1vQb5o3KR4I5Ne4XWj6YkJyIhxxk1z+uadpotJATDn2NeNWppNu51J62PmvxnZXdqjh0PB71x15znPrXsvxG0/TmMhUqevC15FqaxxyMEPGK+RzFJSep3w+E5/UlY52+vNZVyoY/MOcYravXXJGe1Zd5Bv+YA889K+UxC5onTT1MiSPcpwPaqdza5iYk1qywBCS3HFZ94AHIB7V89jINps6YO7MmWJskUzyX9qnm/1K1DXyknaTNCJoXyenWjyX9qc3U/Wkq+YrmE8l/amVJSP901UZB8QyiigkDk1otRW1sFFJvX1pQQeRTasDVhVAJ5qSNFAzio1fYc1LHJuHJ5rKceoieGtCyYnIPbpWZD978f61ftWCbGY4GeTXbh52sNG7pWTIoPpXZ+FHkNxFIp5zzXGWrpuRd3O7J+ldFoGpRxXaKsnTkV9rlVdRadznlrofRHw1vbswRiOQAbecnvXpukvdtGf3gzj+9Xzn4O+IF1YIghZSF75r0DS/i5d+Uo2rn13V+j5bj6aVmzza9J8x67YXcqIQzA49Xq1FcyE/KfpzXlsfxOm4aRVH0atCw+KUyjIdeO2a+gpY+nbc4nT97Y9EYzMcn+dRzzSrwWPTsa4p/irPKNvlr+dV7z4lzsucge2a1+v0+4ezOtupLmNjILthx68Vj6pdXDWzZux35Jrlrz4j3twDnaTj1rLvPGM8kBRtvviuCvjoS05jVU9TQ1y4uVhIF2evQN1rzPxnLdSZDzMevU1uat4pkWH7zZz2rj9f1trqRllXOe1eLicVCSsmX7Np3Ry+pAhmz1rNulcOSTxitC/dMHHGe2ayrqRmk2kda+bxdVSdjZblG5+9Ucv3fwqebriodjeledKWhtEroAXOR2pxiZhgAYqbY3pSEEHBpLUopyWxHAqvdQhUIYdR61oPGWXBFQTQruUe5qk7AYmojMAX1GK4PxdF9/eO5r0LU4VMfB71wnjWFXf5e4Nd+Bd6plW+C55teWyzeILaMD/l8gJ/7+LX3Z8KQIvifAIx/y6Xh/8lpa+HWjK+JrFQP+X6D/ANGLX258MZGj+JcZTqbK9UfU20or9o4IXKpHzuP6HP8AgEb3vHbrtH/oLV3HguEt4btuOMGuN8Bqr299uGMow/8AHZK7nwgu3QrdfRSK/Ycr+Kp6nmSLMcXlk57mnUDoP92ivbZIU5VBHIoVSDyKdQAjcLxUkfAPvTACTgVJ2oAMDGKeigLwKaqnIOKfQAL9/wDKpKjX7/5VJQAUUUqKWIwO9AAqlzgU8KVGDUg4XBpdpIGBQVHcjT7wp9FFBQUUUUAFFFFABRRRQAUUUUAfdlFFFaGYUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+adFFFc5oA60pIPQYpKKABfmbbUvkD+8aWBFxllH4inUENu4zyB/eNHkD+8afRQNO4zyBjO40eQP7xqQAkcCjB9DQDbuR+QP7xpPLCtt61Lg+hpCOckUAm7jY4AHznr7VKkIOef0oUDAwKegbd0NBQqDYAPSrQAIB9ai2f7H6VNGhZwuDjFBDbuSRwErkAmpY7cGXJalVSgAzU0agNkjtR0Gnc574ksE8H3Uo6nAx+NYesweVaW9vu6Iq5+kYH9a1/ihu/4RQxAH95KF6e9ZniIqjxIWHyggjPoqivmc5k7x9TWnueofsk61HpuuagX6PDkjPoCa9X0Xx5byQ7EnRAGPDHnrXiH7PkIQ3t2j4Ih6g8ng1b03VXRtqOWYknr2zXxWc1fZtM66cVzaHvEXji3CnFwD9DUUvjJJAdko49Gry7TtXvguxFUg9VDYq2mqanyIrdff5q+HxOKi2z0qcEkdlqvjGQKUWce1cp4j8XXfkOvnAc9hWdqV5q7gERID/KsLVpdQdCJ14J4z614tfFX0N1T1uYXi7XJbiR903XiuJ1VvlaQ10evWsrKzOp5PXFeL/tOftJfDr9mzwHJ4y+JWrxwI8oh0/T7dd1zqEuBiOJAfm4GWY7Qu7JNeG8Ji8zxSw+Gg5Tk7WR1NxhC70R011K8koSOIsS+AqDJJ+g//AFVQvNd02yuf7Mv9StIJwABFNcorH8Ccn8K/KT9p7/go7+0F8e7i/wBMsdcl8H+F2lZY9B0S+ZJJEHQ3NyuHkPsCqDoAeteOeF/gX8d/itG3iLwb8M/EerQFsjUkhfaeevmS4z9Qa/TcL4JT+qKrmeMjQb6PdHmyzVQqONPU/a+/vw0fmRWzbM8Ejk//AFqz5ZPO+fAGR65r8b/+E1/a+/ZO1aO+g13xn4Omdl2pfM7WlyM8Ao+6N+e2PxHWvsz9jX/gqBp3xm1Sz+FXxwisdH8R3LCLS9WtXEdpqL4+4/XyJmPQHKsOAQeK+N4t8G85y/ATxmXVFiaUVry7pd/l28zvw+b4e1qmjPrW5XZGFHY1BTnuA7PGzcq2CD1B9PrSBWIyFP5V/OONoewxDij2YvmimhhTJzmkZdvenkgHBNNcg4wa5xjaaXyMYpx4GTUdaQVx3sIWwcYqKW6VDgjjuabd3SxfKuDx2ryv9qn9p7wZ+y98NZ/H/iiH7ZNK/kaVpkUm2S7uCM7MkEKgGCz4JGeBXu5Nk+LzvHUsJhY81Sbsl+pjXr0sPSdSo7WPUJNSgiVnkYAAZzmuB8bftX/s7fDt3Txj8avDdi6cNAdTSWQH02xlsGvys+PH7bv7SH7ROpyQeIfE9xpWkeYy23h3RJWiiVSejOp3zH/aY5P91RxUfwv/AGNf2hfiPZ/2loHgNrS2mcBLvVW+zI+ecqZMM34A5r+hsF4EZVl+FVfP8fGm39mLUbeV5bv0PnqmfVqkuWhC5+l9t/wUQ/Y5vbhbaD456cCT957S4Cgepby8CvTPh98Zfhj8S7U3vgH4gaPrMa4Lf2feq7Ae653D8QK/NCx/4Jl/HmVFNx4x8OwFWB8qS5kJ/ApGRmsLxn+yB+07+z2r/EPTtPaa2tDvbWPDeplpLQD+N9u2VAfXBHrWOI8JvDnHpUcvzT969k3Fxb/ASzfNKTvWoe75M/XiCYbskY+tWftuVEaKOvXNfnH+yj/wVH8c+F7y28IftAXR1vSzOkKa4UxeWQJx++2jbcIO7DDj1PQfoL4d8R6P4n0i28SeH76K6sbyIS29zBIHjkVhlWUjqCuD6joec1+P8Y8CZ5wZieTExUoPacdYvyXZ+p7GCzDDY6LdN6rodXp9xI0gJPTjrW/pNx5DB1bJHqK5ewlG0SbsfjWxp9yWHBrwcBipRdmzskkdfod1LLLw5H0ruPD0ZmVA8vbOM15jpV/PAw2HA7k11mg+IpYSoLbce9fY4LFo55K7PRhpweMbXwcc/NV2w0snDBvpzXKWviovtH2ntzxWzp3i+yjUK8/I6kDivpcPiY8pxVElI6ODSNxy7Y47Gm3WmIo2CU1Rj8aWIGfOU/hTJ/GenMfml59jiu2GIpuOqIuOltYYgSCR75qrdwxeUQrkk1RvvFitkKPoQaoS+KQAdzAemTWdStSvdMfMxdVjfaEzwDXMa2rb2bdj6Vr6h4kjuEKgA8Hn1rAv7vzSXC5J7CvLxFTm2ZSkzHlVhIQzk81CwXBJXNTzArId361A/wB015M9bmyimiCSJTz7+lMEQIzx+VTP0/GmL0H0rmk3Yq1iOSEEde/pURtQTnefyqw4JHApuD6GlzSAov8AdNROu5gc9BmpnicrgqR+FRPE6noTV3YGTfx8cn+KuG8bKFJI/hB/Gu81FWAPyn73pXCeOULFxyODXp4FL2iMq38NnArbGXxNYMCf+P8AgH/kQV9rfCqEv8VbNG/jiuRx7wSV8Z2UO7xHpwByTqEGAP8AroK+1fhChl+MWmw4J5m+UdeIZCf0r9r4GSkpXPncd0OW8IsyfbvKHBiL/j5bnFd94Rj/AOJBbuTyUJxXEeCoDsuwxHMbjHtskH867rwypTw9bAAjEX9a/Xcq/jTXmebJNInCZ79OKXy/enBSB93v6UuD6Gvce5AlKq7hnNPwPQUAegoAFhcHODTvLbvxTgWwOTQST1NAABgYoJx+dFI3b60APVOQ2adQvQfSigB0cYfOT0qRIwnQ02DvUlABTg+BjFNooC9gJxSkYAPrSHp+NKfuigtaoSiiigYUUUUAFA5OKKVeo+tADtg9TTWGDipMH0NDLlfu8/SizJVz7nooorQkKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/Nry0/uijy0/uipGVQ2AKa4APFc5oMMaEYCikji2nLH8qeVYEHsafsX0oAa2CeBSU/YvpRsTvx70EPcZRT9kX/PSmGN88Nx2oEOj706khQgndzUmxfSgBlNZSTkVLsX0o2L6UANj6j2qRPvCmoqjJAqZI0xnFBSdiRVPBqWAbiSO1JH5ZUZHP1qZI1TO3vQSxxO4gD0qdeg+lQooPNSRsTwaAOb+KZ2eGo89rgD8wax/E2EvjkZxJIP/AB4Vt/FdF/4RlDj/AJe0/rWH4nOb1if+er/+hCvnM5V68DanqrHW/BeaSC3v0EoUCJs89MIxrO0fxBbaTHGZL9GOByx9qqeDriaHQ9XkikKsLSVgR67GrzXQ5tQu/LilkZhhTuJ9QK/MuKZujUSR6GGScNT3vSvG1ij5+0KQRzir48d2C8ZzXlWkadfxRBzIevT1rXW1vjECQenXNfm2KxNXmdj1aCgzubv4gWATgnjsBWJq3j/TGQh1PtXPTJcrH87dOTWRrBYwF1J4NedLE1FFs6+RdDP+L/x48H/CjwZqnxC8bam1ppGk2D3V3IsnzFVH3FX+J2JAA7lh61+Kv7Sv7RHxA/aj+LU/xJ8YFkkmk+zaDpVs29dOtmbi3jQD7x4ZiOXkY9goH1d/wWj+ON5cv4b/AGdtDuyEYjV9eRDjevKWqMfQHzZMeoWvP/8Agmn+zCmv6vJ+0L4u07Njp1y0HhyKVMebcj79xg/88/uj1fJHC1+68C4DBcM8M1OIMXFOrUV4338rfqePj5zq4hUYvQ6v9kX/AIJ8aH4QtLX4j/Hvw/Hfa86o9noV2ivb6cAcgzJ0mn6ZDHajdiRX07/ZkkgSORF8tAVRAMKFz0AAGB7CtkW8cr7shc9ff/6/vVmK1ULjGcdDivyfiLinNs6xLq4iq0uiWyOqGFoxgopfM4Txl8OdC8YaHc+H/FGjW2o6fdRMtzYXkIaKTPGcY6jtjBz3Ffmr+2v+yNffs1a/D4k8L/aZ/C+qzlLNufNs5+SIHfucAsjYGQrDqhr9XryAbTlRz7V538dfhNofxl+Gur/DbxJGn2TU7UxrIy82833opl9GR1Vs/UdCa6uDONsw4ezKKqyc6LdnFu6s3bUjFYKDheJ5D/wTj/a/uP2gfhtP4M8camZfF3hGNPtMrNhr+0YhI5sd3ULsdu5CsfvV9SQX4aNdrHDcqcda/GX4IfETxX+yP+1BZ+JNTMtvJoWty6b4ptWOA0BfyriMj0wpkB/6Zg1+w2l3en3Nuk+mTia1eNGtZlbIkjKgqwPfI5GOxFeH41cHYTJc6p47BR/c17yXZN6tenY9DKMROrB05PY1Sdx3etFOhVWhD4pdi+lfz5KPLKx64yT/AFYqJhlTVgopGCKj2LjGKqn1AxdTkKSYAPTtX5Yf8FOPjQvxZ/aMuvCOmXUkuleDozYxJyitdk77h/c7sJnHSMAda/U7WMJISOMdK/Kv/gpj8JtO+Gn7S8uraRZiOw8UWn9ptvYnbcGQrMufTeA+Onz1/RX0e44B8UzdWN6ih7l9r9T57iBVp4Tkh3PdP+CeX7KHgbSvhlpnxw8S6NBqGt6yzyacbqJZI7K3QlF2oQRvJDHdjI4wRX1na+G7djvYl5GQKGPO32ry79hW/wBD1f8AZQ8D3eh23lwf2MI3QuWImWVxLyf9sH869s0+FVwxGSK+U8Qs5zPGcS4p16kmozcUm9El2X5HTgcJSp4WHexlp4QtUJaSI5Peo7/w5JFtlsmwVBxlcgZGM/XHH0J4NdJEjvneeR2qG5Rwf8RXwdPMatOsqibujsqUo1PiPhn9vL9h7Tz4ev8A42/CfS1tJLNTNr+h2yYjdF5eeJR91sH5kAwR0A5Bq/8ABLL9rLWfDHxAi+AvjLVHm0bWdy6IJ84tb3mTy0z91ZVByBxv/wB6vtu/02G8R7W4iVkkJ8xHXcJMjBBB6gg4x71+Wvx08D337Pf7TOvaLoF40TaLrMV3okq8GKMlZ4iD6jKjP+zX9O8B5lDxA4Yr5JmbU5xi5Qk1rbon5p9d7aHyePpPKsVGvSejdmfshaXbOgyBlgCQpyBXQaYPLbYfQV578HPGMfxF+HmgePIown9saRb3bRjojPGCy/g2R+Fej6XDkCR+SSBxX8yVMqr5fjqlGS1jJxfyfQ+yhNTpxa6pM1rWBsD5hWpp9uwIwTVSxh8xgO2K6LRtKeXHy5PYV72Bo1JbIic1F6i28ZTaHJOavWcETDPzZI6A1r6V4PvboBkg4FbNr4DvRHkQH06V9PhsJiHqonFWa3ObitkxyHH41Mti5H7ssRXV23gK7/iUHj1q5b+BrvG3YMV6cMDiuX4TC6OGFlIHwwYntVO/gkXnYeK9Gn8FzngJzWTqPgW8dWKRscelKWXYjl+EjmS1PO5nkXOAcVWZpCScdq7C+8D3sSndC3NYeo6Bd2WRIpH1FeVVwlWnui00zBuCSfmqu/3TV24t358zr9KqyxjO1R1rzaujZ1xdkkQP0/GmL0H0qWSFttReXIO9cktigop0URLfOeMU5o4wcF8VDaQm7FcHBqG7OccVZ2Rf89KrahhAuxs0RmnIZlaiqFQMc7q4Pxv5fmsNvY132pKAmQO9cF41VS7kjsa9nA61EZVv4bOI0tc+MNMVRx/aMB/8ipX2v8C4xN8brGQDpBfOB/u2kxr4v0FFbxnpakf8xGEf+RUr7X/Z5UN8ZoHPVdJ1Nx9fsktftnAn2j5zHdDk/CYKPeFBwpYf+OMa7rQF/wCJJDH6Jj9c1w3hBj9lvXwM+a4/JJB/Su88PqDo8RPoa/XMp1qVH5nHiN0TupU5PpSVJOADx7fyqOvdbuznHbD6ilUEDBpu9vWnKSRzSAWiiigApG7fWnqoIyRSlFPagBV6D6UUdKKAJIO9SVDE4RsHvU2QeRQAUU8IpXOKa4APFNK4CHp+NKfuikoyelHKyk1YKKlSJGUE0vkp70crKIaKm8lPekaJAMjNHKwIqVPvj607YPU05YkGDTswH0UUVQH3JRRRQZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH5u/aM0vmZ+9QLQ78AmnNbMCOD0rHlRoJJzt/Cl2N6U8wggMScgdKKTVgGbG9KPLJ4Ip9FIh7jPJWniOMDrRRQINqr900UUUAFI0bN8w6UtPTlce9AEccTjkip0ZlHyimoAeDUsaDnk0AORjgMRU0bs55HGKiUAECrCqBwBQA9On40+JWJ6UiRjpmpEG1tooA5v4tfL4dhQ9Wu1xWJ4oRjqDAD/lo5/wDHq3Pi2N2i2anvfKKw/Fchiv3cDP3jz9c185nLft4G1Hc0PCTRL4d1VZZAuLGYnP8AuGn/AAj8AQ61Zw3TW2792gBxnjArmLu9mtfCutukpXOmzMCD0/dmpf2ev2g9M8J6ZBZa1MzN5IVNo68cGvzbib2X1uPtNrHo4b4D6Cs/gvpcLB5YSFRBuJHAzUHiH4WwWNt5kSAqfTtT9E/aa8Fy6dvMryFhyKztf/aG06+tHgtrPcf4PMAFfH4uplij7u53UlK+hxfiHSBp0jxDAG39a5DW3gW2khmwcqcc9K0fFXi651JmnZgpYcqvQVw/iC+unt5W3kZXGc9K+Przoqo7eZ6EbtWPy0/4KTeIHvf2zvEjzhnW0tNPihD/AMQNqp/Qsa+0v2YNIsNA/Zk8CW2nSr5X/COwTuMZJeXe7n8WY18If8FdNK17w3+1SvieNylr4g8O2ssDAcGSBjFIM/gp/Gvrf9gLx9D8Qv2R/B93HOWl0yybTLtN2dskLEc/VSh/Gv2zjJ1Z+HOX4il8Ct+h4NOtGWayp9bfke5RTxN8wbjHpVuF4Cev6Vl2WdnJq9B94fWv52x2JfM35s9+nCMopj7nyNpwMVg655Sxtk9s9K2rnhawtfdUU/TFebTxcZVEm/63NalNODsfl3/wU/8AAmneC/2o5NatLVVtfE+i2upsqj5WuAWim/PYmf8Aer7d/YJ+JT/EL9kjwTr19LJLcW2nPptxKzZybWVoVz7+WseT7V8m/wDBZPyrLx78PWVf3zaJqabz2HmxFf8Ax4H8q9h/4JI6he3X7I6W8z5ji8UX/k+wIiYj/vomv6B47gs38FsDjqvxwaV+tr2+48XBTnSzWcFsfYunX0csYRG/CrZkQdTWForpjI649a1kyRkmv4/xFP8AeuR9VTlGSJzLGBkt+lMLBo2I/u0w/MNpoDbYjx1GKyirIpqxka2haViDXwP/AMFjPD8UnhjwT412IBBqN9pzsF+ba8aygZ+qsa+99c3NG8i8HH9K+Nf+CuejSXP7KNrqyJzpXiy0nYkZ+V1ljb89wr9m8IcV9S42wfLtJuL+cWeTmSSotst/8EmfFA179mVtGefe+i67c22CeiuiSr/6Ea+s9F+Y8elfBn/BGDxAH8MePfDs03zw3tjdqg6ANC0f/suPwr7y0eRVfGafi7hFguNsbBbOSl/4EtR5bU9rgIy7l9YwsjMOlNnK90B4p6up4DdajuP6V+TnoRipIxL66MFwJD0Dj+dfnD/wUc1W2tv2tNQQkSO3h3TWlUc/MYuv5AV+jOp7pJ2hBxzgHIHUe/Ar8l/2oviPB8Zv2k/Ffi/R0Z7W61M22mtHz5tvDiFCvs+Nw9iK/pHwBws5Z1VxLX7uELSfrt+F/mfI8T16cKEaXVs/Uj9gvU7q4/ZN+HzXhbzToKfeGCV3uR+mK9/0nVUWNULYOfSvGfgX4Tm+Hfwv8LeBnYb9H0K0tpdvQyLEof8A8ezXp2kyF1DMO/SvxPirOI1OIMTWpfDKpK3pdn02BjJYOClvY7zRL9WkDO4Ck+td74V1G1mkjhEqklgMGvKdIuXVcrgY7YrqfDupBHUs4U56iuvJMyjOS5gxFNuLaPqfwP4W024s4HjEbKyjfjtXoVj8NtK2ANGm5+nFfPnwo+Ndxoaix1NMQjgOa9z8KfFvStXiie0ukkAH3S2DX7xw7i8pq0IqTVzwqyqbG+vw10tVGIUz3BWprf4bWZ5S1Uj2Wrlh42sp22JJjjlSMmtEeIrBV3NIhP8AtcV90sLlkkmrHC6la5z7/DuwU5+wqCTwSKjvfhnp8afNbqCe2K6G/wDFthFCrjyevpXO+JfiXpUA3yzwqQOPpWGKo5bh4u9i4c7lqcR478I6XY52qny9SBXh/j64s1uHignRgoI+X1rvfih8W7a886PTLnapBG0ev+FeJ6zeT3btLv8AmcktX5VxBiMJdqkepRiUru4VW+VutZ80yBsg06d36MeaqTuScV+fVaqadzt6j5LsAEZqH7ce2fzqKYmNd3XJqOuFzT2LLIut5wxNI14qHbn9KrOSBwajdyvNZuTuJq5J5zVFc3G0DNRuCpwGNV7wOygqaUWk9RjNRbdH715/4tcpuI/umu6vgwiOWPC1594uJIPP8Jr2sBK9RWMq3wWOZ8PPu8c6PE55/te2/wDRqn+lfan7PMqH4vJz9zSNULfT7HJXxT4XXzPH+jEnrrFsP/Igr7R/Z7O34uOw76Pqg/Kzkr9w4C1Uj5zMNLHOeFTttL1j08+Rvw2PXf6HE66LCxHGDXn/AIYP/Euvz6NJ+kbV6LpXGhQAf3f6V+u5P8VT1OCtJyaHTEO3y+38qYUYdqcfvCnHr+Fe2ZEexvSnKCBzS0UAFFKoycU7YPU0ACfdFLQBgYooAKKKKACpIeOvrRAAc5FSg4GMCqSTQCUUUU0rAFFFFMCeP7g+lLSR/cH0paDQKKKKACiiigAoopyoCM0AfcVFFFBmFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfnR5bA7txP40yQsDyT0qbK9mpCqt1FZmgwcjn0o2g9F/SlKkHgUsfepauTIbtH939KUKOcr29Kf8vdM0jfdpWZJG0DSRs0eQ4B2Y6E44z7Z9KW3SbyI/tyx+fsHm+UPk3Y5x+NPjcxrtKk0/Zu+bPWizAjeIN0AFIIiONuffFS+X70oGBjNFmBE8IUZApu0jov6U8lh1bNKRhd1FmAscOCD+lSeWw6IfypIH3MOKsUgI4oSDubv2NTIDnkU0HBzU0KhjkjtQA+3G7tnmpVQeZyvf0ohUKcAd6kCYYtnrQByvxcA/s2yUD/l9XA/Kuf8AGPHmv3A6/wDAq6D4sfPa6cvrfLXPeMH3RXLY6L/7Oa+czlXxFOx1UDA8QzGH4fa1K5IP9lT/ADZ/2a8d8LXyxPjIG3OPavXfHP7v4W67IDymky/qAP614j4XmDxhwOTnivyHjOs1io+h3YHW5654Z11lskTOBn1610A1l5FAEhxj1rhPDchNogyeDXSW8jeWpz2r8or4i9R6nv0kuUv3V+WyG/WsvUZhJbuhOfl6VYlO7NU7yMmMkNjNcXtXzGjV0fE3/BX34ITfEH4AJ8SdCsmk1TwZeNdyiIHdJp8gEc6/RWMUn/AGrxj/AII7/HaKy17X/gJqt6RHqMQ1PRN7/wDLWNQkyDPdkCvgf3DX6JeMNC07WdLutH1i0W7s7uF4bm1lGUljdSrqR6EYH4V+Nnx3+FnxF/YU/afjTw5dtHFpWprq3hHUXB2z2m/cqk9CV5hkA7o3tX9B+H2NpcY8HV+F8S7Vopzpt9bdF+B8hm9KpgsXHGR9H+B+wVlLtOwHcMZB65/zir0U2TxxXl/7N/7QXg79or4Xab8SvCNwii4TytTsQ2WsLwD95A3fgnKnuhU9676PVIEHMucDsa/n7OssxeX4ueGrRalHe59Zh61OrRUovSxfuGkCEhuMckmue8RM6xs0rdOpzXD/ALRX7X3wq/Zz0qP/AITC/luNVuojLp+g2WGupwP4mBIEMf8A00Ygem6vjb4l/wDBRL9pL4kyuvgGOy8M2MhJiW0svtdyc/8ATWUY/FVH417HDnhnxLxAvbQgqdPpKWnzS3frax5GZcSYDAXi/el2R5//AMFfviEniD9pPSfB1lOJh4c8NRG4VSDtnmeSTYcdDjZxX1J/wS+8Oy+Hf2PvDbPGUbVL29vXH+9MVH6Rivzy1LwR8Wvjr8dxpNzPdatrnifWM3VxOm+UFsAyyEfdVUBPooRR61+uvws8F6D4A8F6N4C8MwBLLRtOhtIDzl1jULuPucbj7sa/U/Fqph+HvD/AcP06inJNc1v7qbb9LswymqsZjZ4i1lI7bQ4pMEYPpmtpePlx0HX1rO0ZTGMEd60PM9q/kKq1Ko2fYUY6DqRvukUnme1NeYb/ACtvU9aiyN7NmZqxPlMM9/6V8z/8FJNCGu/sdeOonj3G1t4LuNAM/cuEbP4AH9a+mr9dyO56DOBXhv7ZOkXXiP8AZn8f6BZ2/myXHhW62R+rIm7j/vkmvuuAcS8LxNg6n/TyK/FI83MoQlQaZ8b/APBGjX5NN+KPjPQpZV8q88OxTqrDJPk3A5+mJMZ96/SHR7lGDSyAYYkrgnpn6V+Lf7Nvxj8c/s/+KIfHvwy1W2F89m0EltfWgmhmhchipBII6KcggjHBr6r8If8ABXbxnpqhPFPwj0m8YcM1jqskOefRg2PxJr+hPFjwzz3iLiJ4/AQUlKMbq9npp6PY+Ry3iPAYOj7GrdWb1Sf+R+hRuYosMVK56E96ivb1olGYz833Se/tXxPD/wAFivCsahr/AOB2qI/cQ65Awz+KZrA+In/BYTxJqGn/AGf4XfCeGzu2QqLvXr4TrGTxkRxBS5HUZYDPUGvyfD+DfG9XEKm8Lyf3nNW/U9h8U5LGDaqP7n/key/8FCP2k1+CHwfu9D0DVII/E3iRXtNIjb/WRxMpWW54+6EUkAngsR3FfF/7CHwPb4w/H/RtKubeSXS9EP8AaWrHsYosEJnsWdUXntk9q426k+Lv7T3xb+13lxfeJPEmrzhVYJ9xc/dVQNkMSdeMKOe9fpX+x1+zLo/7N/w6Xw+scdxrOpMs+t6lCMCaQZCxoevloCVHr1r9kzGeWeE3A08DTmpYuv8AE+vNtf0Sul+SPlqCrcSZuqz0pxa+Z7hoUUtwRNMvzE5bjv8A0+ldVpi7RgjFYuiW6oGYjHpxW3aHa2cdq/jLG1HUrNtn6XFKMbI1LaVowoHrW7o16ARuAzniuehkwAcVcs7wxkcH86jB4ueFr36A1dWO0ttSOz75/Oul8P8Ai+/0sLJb6gwYDgFq89tNQZlHJrStrtSATKc/Wvv8uz6dJKUdzjnh431Wh7HoXx012J2jnlaTaOMkDFbtp+0VNvET72b0YcZ+teGJfxogZX+bPU81NHq3mp5c8jsM8bTjH5V9xh+KsXCClzXOR4GnfQ9o1D4/X03yM7LjoFHSuT1/4j6rq2XuLxtvO3IxXDwasbY4jkTHq3JqG61KeZgTc7h6AVlX4lxtde9MSw1NPRGpqOpm4cztLzjrms25vTKAqPgAdjVeSUOvLHpUMjhVyDXh4nHTnq2bwp8iCV2ZyS5P41XnkBOAO3WnpKpGSagliVW3B815M8QpXLsyKQknBPHvSHoaey7u9RM2CVxWHMu4WaG5J6mmy9PwpWbb2prncMYo9rYpbCEA9RUV0AEGB3qWornnavqa0hqxlG+JJIzxXn/jDG5gPQ1397zu/wBk1594wcea5x0Br18ua52YV7chzXgvB+Jeho3IOsW3B/36+yPgTcC3+IzXG7keH9VYnPf7I9fG/gQfaPihoQHH/E4t+v8AvZ/pX1v8Lb5dN8V3d23/ACy8O6pwD1zbMP61+5+H+lKV+583iutyl4TIbSrs5By0ufxWvSNGwdBiJ/umvNfCR26Jdzdi78fRP/r16Xo640GFc9Ywfzr9gyf4qr8zz6isLIADwPTH5U2n3A2OF9qYRivYbdzIKKKKsBV+9T8j1FRMcDOKb53+wadmwJ6KZHICo4NPoswD+MCp9if3R+VQY+YH0qwORmmlYAAA6ACiiiqAKKKKAFX71PwPQUxPvCn0APT7opaRPuiloNAP34x6tj60Uc4IHcflSgZOM0AJQehpWG04zSEZGKBXQzJ9TUsJJTk1H5fvUkQwuPegS3PuKiiigkKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/O51yuF4P0pEQgfNzUHnP7UeaSPmrM1asrk0jEfKDx0pAAOgqH7RjjPH0pfMGMqaDNu5LTowC3PpUAlkIySPxp32hByG5oESvIEU560iuWwc9ahe4J+bcMUnnvjOR+VAFuUBUyvXNQmcg7Se9RfaT6j8qaZZGORigCwSo5YU5CsvyAVWWSQHnFO85/ak9QLSIqSgKO9T1nh9vzmp4rtSMbc/WlygWamhJA49KgibzRgjGO1SxyFgFbsakCxG7AZz3qwORUEbKF5NP60Acx8VB8mmL/ANRGMY+pGa5vxYMxXA7MOf8Avpq6X4ikDUNHz/z/AKfzFct4qm22kgHTEf8AWvnc3f8AtETqo7HN/EWUp8K9cGfvacR+orxXwspjZUbGVQA8d+texfEVh/wqzWBnpbpn/vtK8Y0DmTcOmyvxjjWX+0o9HAx1Z6J4ZYmBQT/FXSQyBFAPpxXMeHpAEBH93Iretp2UZNfjmKm1UbR71PSJcSZXYqabdovkmojOx5zxULy+YzL7Vxe3kzRamTrMO5DgcZr54/bY/ZO8P/tSfC5/Dk80VprWms0/h3VmXm3nbIKNj70TgDcB0OD2r6NvSGjKjrXM63EjIIT64T5c8mvcyLOsdlGY08VhpNVIO6+Xfuc+Lw1PEUHCaufj9+z18fPif+wd8bdQ0jxF4cuxbLOLbxZ4blm2s6A48yJj8odfvLJja6nHAZcfXH7SH/BSfwF4I8EWR+BeoweIdf1uy+02dwUPkaZEw4knU8+YGBCxHnPL4GN3K/8ABWqx+Cj6VpDXsDHx9cSKNMay2+Y9gCRIbo55iG3CEfMW4+7Xw9I9vpzKBKWG4b1RhvI7/j/XFf1xgcjyLj2jh89xeHcakfiX2ZvzWl9T80xuZ4vJ5vBUqid9U+3kz0r4c+Cfir+0r8TJbqCK68QavqMv2jVtUv5WYRKTgzSt0VRg7Uz04Udq+1/hX+w78P8AwlYRTeNrybxHqChSxkkZLYEDnEYxvHuxJ/2ab+xBrf7P+u/CiHSfgjdlWtQsmuWV7sF8sxHzSXGOoJ6MuUx0wa930yOKRcAjZ1XHpX454mcd51QxMsDhYujTp3SXXTtorLy19T2cjyDCqP1mrLnlLV9k+xgeDvhV4S8NTNP4e8JabYMylWeysI42ZT1BZQCc98mu20jT1jcgJjb6jFWLWKBIgIUBx/FVmCv5szHOcbj5J1pyk11bv6n3tHCUqaXKrFzThhSMdqsYPXFQQdRVveoTr1rwnJNnbF8qI6jf/j5H1pJ8+bnHXpSTkDPNF0ylOxVvseQ59zXn3xD05NW8P6po8n3bzTbiAj/fiZf61392QbZ8VyWs7ftyBhwSAQR2zzXt5LiJYbFwqr7LTOXFcs4NNH5C/sdeHPDevftFeE/B3jTRkvNNvNSezurOcHbJuQhc49wPpX3Jq/8AwTk/Zw1ZMQeF9T092JDHT9UcLuz2DhgB7V8R+B7uX4f/ALYdnLCzI2l/EZYnVuihb8p/Kv1gtGdpXQLhFkYL+DGv6k8YOIM4yPG4Otga8oKdPo9HZvp5ppnxGT4PDYpVKdRJ8smfMV1/wSy+DMr5sdd8Uwr2zNC36+XVvQf+CWHwQtrr7XqWp+Ib4RkEW9xepEjexKJn+X1r6tgRmiUAVbt7ZmUgjnFfjtfxU42lDleMlY9yPD+VQlzchw3wk+APw6+EOm/2Z8PvCNnpKShftDW8eZZ8D+OQ5d/xOK9H0yxUMNy5I7061gAVVPXHSr9nEUlAH418Dmeb4zM6rrYmbnJ9ZO//AAx6dHDUKGlNWRegjCKAB9a0rXr+AqlbAggH1q9Ey5AzXy1Z80juT0LsTKqYYVJFMvIqv53lkDP8NSwupGc9q5Jyu7DNC3uwi1bt78HqetZBkK/dNL5sgw2RW1HE1aezDQ3mvtowhP4Glhvpd2fMP51gi4kc4NWoLmSMDFe9g8yqy3JcYs2ftr/3zR9tf++azkncnIIpzySNjDYx6V7ccXKSMJpRdi+t45YAt3qY3AIwSPxNZKyyK4YngHk1YF1vxtYGr9vJrUguZB5GPwNBdWPTmoRM5HBpfOPZAPepumBLUD/fP1oeTd9403eByDTJ+ISTtTaVnZxg0lBS0Co7j76f71KhCjmo7hgXU+nWuiM7MCjedZPwrz3xh95/oa7+9kAOQei15t45lLM4Y9FNevl7/eIwrr3bmJ8PGI+KehgH/mLwfzNfT+k6gdN1G5mB/wBZpl3F0/vRkV8t/DEh/i5oBX/oJKfyVq+k55w0xDf3DX7xwEr4eb7tfgfN43SxueEwf7IuLY92bP4oua9M0oFdGt1/6ZLn868w8IDGhyBu7S/+goK9O06ZhpkAz/yzx+lfr+T7VPU4K26H3PMv4VHSyPIuDj+ED9KjZixya9hq5iPoqOiqAlUAnmneXu+7UB5BpysAOaqOwD2BRselG9vWo3O7pSI6hsZ7VQEu9vWpVlkwPm7elQb19aXrQBZidmzuNPqC2dU3bvapRMhOM0AOpyqCORTaKAHhQDkCloT7n4UUAPT7opaF6D6U5Ov4UFp3G0qfeFPqOgG7Dn6/hTaKKCXqFPTp+NMp6dPxoHHc+4aKKKCQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD83pLkKcKAaQSNLyeMDtVXzmxuKdO9AuGC5A/WszSTbRMLnJ2HHXFBmYkIrDj1qo1yEbdtGc0jXG4bsAGgzLckrJ/y1X86Z5j/wB41U8zcN7n86aLmUHOD+dAF0u4XfuP0py3RwMmqhumYDA4xTftIUgPgZoA0EuQwOccUw3XPWqwl2jK85prTNnhKALi3AJwW/Wh52B+U1TWZlbBUVKkx25KCgC3BcbsBjVmCVcmsxZsHIUD6VPHNlc7sUAagkORt9asxsXxnj6Vm29yMCNzyB3PWrC3L9v0NQ07gacZKrjOfrUnmMEyAOlU7a4ZuCc/WrfWIYFIDmPiW5OsaHB2e/TJ/EVyXisn7O656iP+tdX8SHT/AISLQF3jIvVJH5VyXionYOeN0efpXzubW+sL0Oqhscz8TJNvwv1kHp9nj/8ARi1474c4IAORgD9K9b+K8ip8MNYctgeVGM+/mLXkHh4lDsJIIbp+Ar8U40v9aVz0sDbU9C8OMSEU/wByt6H7tc94XLCFHbOdnetuKaQLjafxr8dxb99nuw+EufwfhUO5VdmJ7UjXDhQDwahkmJLDHavOe6saLcq3s6qSBxz1NeUftLfG/wAJfAL4Wah8TvFqGaCyHl2tnEwEl7cHPlwoD1LHAJ/hG5u1ek6tdlEZVXLHonr2/rX5S/8ABSP9pdv2g/jdL4H0HUmbwz4NuZLWyjB+W7vlO2e5ODjAZTGvoEYj7xz+m+GnCM+KOIYQqO1GnaVR/wB1dF5ya36K54vEGawyvB8z3eiR5Zc33xR/ay+N8upzIb/xH4mvcKFJENugOERSPuQxIMbegVc8lq+yb39gP4JXXwftvhbrWkNJqNqm/wD4Su3iCXTXbEFmz3jPAEZ4CgY55qb/AIJ+/s3P8Lvh4vxO8U2CLrniOISQI8RDWViQDGuD0Zz8zDsNor6I/sp5l+dlYNyeK/ROO/EOrRzOOByuXLSo7NfzLp5pbX62PncpyOM6MquI1nPuflp8UPgp+0H+x147t/FMGp3dusMpGl+KdDDJFcDOPLfAJBI4MbgjGeGFfTv7Lf8AwUx8L+LYrbwZ8f4IdB1eTCxa9GgSxuj0+dRnyGJ4zyhPpX1LrngzRte0W40HXdPhvLK5j2XFpdW4kikTGCGU+3Axz7ivjr9pT/gmhsafxJ+zxhGkLPJ4ZvrjKp3Aglbr/uvz6MelFPjDhLjrCRwOfRVOqtFNafNmlXLMxyir7XBe9Hqv8kfcPh/VbO8skvIbnKSxK6FPmRlP3WDDhgeoIJBHete2lWQkIcjFfk58Dv2r/wBoH9kLxNJ4Rvo7qXTbeUpf+EtbEiqhz83lMwJt29CoKt124r9D/wBmz9qn4YftIeHX1fwHezxXNuQdQ0q8AFzZk9nCkhl7CRSVPHQ8V+M8deFea8M3xlBqrhntOPRea/XY+kyjP8Ljp+yqe7NdHoewJMoUHvipEuQRj0rPW5jY8SgnGcA1KjueowPWvyCVCzPo009i277zmoJWOaFb5fvfrTJWPm5zxUuk47AMuf8AUMvrXI+Iw6yFoQC+CFB6Z7V1d3IpiJVxjPrXK69JtnV0OSrAgDvXq5Yl7RcxhWV9D8n/ANqjS/8AhD/2wPGssSiNl8VfbowBjBd45gf/AB6v1X0G4i1K1h1CNRsuYUmTH911DD9DX5lf8FItOl0v9rPXXCFDe6dZTo5Xhj5ATd+cZ59q/Rb9nrWG8UfBbwh4hkJL3fhmxdiT1YQID+oNf0X4uS+u8I5RjN/cSb83BfqmfGZDaGa4mn5nfWcBKqCO1aVrCqKcjtVayKlARjg1egKt0wa/merKR9woofEo3DirNuoWZcVEpRW7VPARuzmuScp3GoxuW43KMMDvVlGJcD3qqoJPAqwoOQw9etctRMtx7FvJIBPpViD7o+lUhMVAHX61NDO+3OK5ZRdyS3Tcln2k9DUQllPIX9aXziq5ZADQk1uBN+NSRyAnDMR9DVdL1CMMB+NBuAxygB+laU6soS0Avxzqp2hjUqyqxwWP51nG4Pb9Kelwce9epQzDWwnTW7L7MnI3H86lgQADHFUUldv4avQMoVSW7c17kK6lG5g0ky2kYKg7j+dLtRfmVyT6GoTOVAC8jHrR5xPGMVrF3aZD3JSxbrSVHuJ6N+tJ55B24H51vdCtYkYkDIpN59BTfMLcMMUZHqKqzCzGMxYY/lUcpKJkfrTyQBk1HO6mMkMK0WjBGdqP+rJ9V5rzXxuxW4mTtivRdUf9ycP29a818byAzykP29a9rL7OojlxLdrGR8KTv+Legg9tQ/8AZWr6KaY/aMtjBBFfOfwfPm/GPQUJ4+3E5/4A1fQ166rcgBsZJxiv3ngH/dZep89j7aHVeFXH9jPs5w0n/tOvRrB1OnQ4Y/crzbwiQNIIb+KR8e/+rzXolqyiygAOMJzX69k+1T1OCtuid2IpN59BUbPu+62aT5/evaMSXefQUbz6CoS+3q360oJPIb9admBKrknFMkdiQP5Uzec4DfrSOWOME1STQD1lZRjj8aVHJbOB0qEFsgEmpOR6imBLvPoKernA4HSq+T6mpRIgH3hQBNHIBndT1lTI571AkqD0P1p4fPSIflQBb81PWlVgwyKqrLzhxip4ZE2feFAEocgYFLvPoKjEsZOA4/OnUASq5wOB0pyOc9B0qMEYHNOQjPUdKAJd59BTaKKB3uFFFLg+hoEJUkSApk+tMwfQ1LDwnPrQVHc+3qKKKCQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8xjLMsZGfxzUYnmMRGeB1OapPeOVIJP51GLjgkk9O5rMptNF17obA+/n0pn24jrn8KzZL0YC570C6BBOf1oJNUXaugyxH1FNN3vBVZOlY8t9Iv3ZDUaX1wj7i2c9eKANqO9ZV25Jx70/7Ws21VOGB71lC7QgFSTnrTVvVD4z35oA121COL5SxJ74pU1XPAlwPQrWRFfb9x3dKetyu3cevrQBpvqKtLtjVj6nFWI7tJE2q5z6EVixXDuvDmp4ZJChBbvQBqx3BY7S2MVMJuFUP1rIhlbOGbIqxHcY6A8dOaANuFiSHHOB61atpQ2MmsS1vGIJZzx0qzbXrjPzHihgbsMoWUAN2q5Bcbspux82M1iWt4Nnmy8kHFWUurrzEeCPILZZX/u/3qhqwGF8Rbgt4q0P5v+W+7r7f/WrmfE83yhS3Uxj9K2fiFOP+Ex0NB03nGO/B5rnPFEinGB/y0QD8q+azj+M/8JvBrkOd+L7I3ws1WPdyzQgH/toteSaMyiYvnqw/WvU/i+wHwyvye9xAB/32K8o0TasoRhngf/Wr8Q42lJ4+z/lR62CivZqx3/huQi2GD0GK2Y5WbFYXhx/LgXdyHIxW1AysOB0Jr8gxa99nvpWRNLIw79KhlmZVZye1STdM+1UNSnKQkBq8+KvJIaPDv29fj/cfAj9nbXPGWkuIdXvVXStDkBO43M2QHHrsG5/qBX5w/sTfAwfHT442Hh7UoJZNM04tf65u5Lwo4xGx9ZHwpP8Av+le+f8ABZXx5cP4p8EfDSO6JSG0u9WmiB4EhZIoyfookx9a67/glj8O18N/BPVPiNPAPtXiPWWiSTHzLb2y7AM+jSGRvrX9Q5BKnwV4VSx0f41fRPrq2vw/U/PsbH+1+JI0JP3II+m/KSSR3ECAMAoCHAUKAAAO1Wre1EmPkxVdQGcAjj24rVsI0CKNvav5yxuJm25Sd3c+7UIRskU7i2AQrtrPvbaN428yPOBxity5iDDgVRuLbcCCOvWvm8RiZSnozZwueLftFfsw/DX9obw9JpXifTFt9Ujj26drltEouLc/wqSf9Yn+w3Bzkba+A9a0j4yfsY/G+K4iuXsNX0yQvYahbnNvqNqT15/1qMBgo3fORlVNfqdfW4VGYDBIxmvnz9vj4PRfEz4C6lrUVikmqeGIG1GxnKZcqv8Aro898x5bnP8AqxX7J4a8e4ylW/snMH7ShWtD3teW+mlz5rPMohUp/WaPuzjrddbdz179m747aH8d/hRpvxF0lFSadfK1Kz3ktaXKgb4yT1HOQe4NekQ3m5flP61+e3/BKH4mPaeONa+Ft/MRb6tYLfWMe/jz4SA3HqY2z/wCvvWCZozjPFfD+JHC9LhfiavhKS9x+9H/AAs9nIMdVx+Xwqz+K1ma/wBqP940STnYfnqikwLYNOeYMoCnr1r86sz2xZ5S0RTP41z+ujBLsegP51tSMVTANZGsDMqjGc9R612YVOMrsxrbH55/8FTNGaP47aFrhtsLqHhiOMgnhjFcSKcn1G8CvrH9gXxCNa/ZT8FzswDW9rLasoOcGKZ1x+WBXzh/wV7sJrO28A67E4XDX1rJxkniKXAP5H8PrXrf/BLjWk1P9mBbJFcNY+JryMB+qhmSX+pr+juKKSzLwfwVVa+zlGP4zj+bPkcvpqlxHVX8yPqjT3xgFs5J4q9FKVbA9ay7DKsCPWtCKRdx3c81/M9eK9pofYtpu5cR946VPC+W64xVSJz2NSxOd3LVyyi2OPxGjHN8xG6p4pHx1qgjANnd+tWYJy4xntWU4aam8ZKxZ8x/71TQzMVx/WqnmheGqSGZcVxypyTM5asuLcsBjOKVpWk5zUJaEgbjinpjaNp47VjK9iErC1JA+3Ix1qOnxdfxqSiUHac1LEc8+1Qo5dwpQY9c1NGjE4U1rThKU0kJ7FuAAnG6rKttGMVUt0cTDcxxuFXHUAcCvo6StBIykPST5RxTnztODioQxHANSFieCa7Yv3UjJ7grOv8AGaTJ39ecZzRT41U5ZhzitacGpCEV2Y4Jp1NYBRlaTe3rXfzKKsA6T7h+lVZn2xlcdTTvOlbgt29KikJYHPrUSfNIDO1R8RAY6rivM/Gj/vZTivR9WdgCM9OleaeNHOZmzzzivYy6L50zkxDuZ3wYkDfGTQlx0uXP/kOSvoS9kVrpMH+Emvnj4JnPxo0QHtLIf/IT17/NJi6VmOe1fvnAS/2OXqfPY9e8mdl4ZcJpMfH/AC0lP/j0Veg2zf6HHx/DivOfCzM2lxIzZLNIf/H4/wDCu/glkWBF3dFHav1zJneNR+Z50tixvKdDil88/wB81Wkkc4y36UzzgOCM17RBLJKzNinpIxX7+KrmcE52mjzx/dNbJWAm8xlk5c4z1p/mE9JCfwqt54znFKbnnNEgJhcSKcGni6H8bcVVa4DHLDrSxyR5Py9qkC6rK6hlOQaUkDk1TF3KvyxgYFOF1IyYdPxoAtI4zkVKtwwYYzjNVY3H8H41LQBYklDHIHelSVjwpxVdPvVMoAGRQBMn3h9anEw3HI61XRuM55pyncCGoAsqyscK1SKgB5b9Kr28flndkYPSpdxYdaAJ0wflH50tRQyBTgipaADv+FSVH3/CpKACnqMJuplPTlcGgqO59u0UUUEhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH5SzXzBQEYZbpUMszFApIznmqDyjzGO89aaLsAnc3f1qWlYC9NOjge2M1FJOoxtbH1qi98NxAPf1qOS5YgbTUgXTcMzkBhTxcOxwP5Vl/bGRuSM0n20unyPg+xoA1PtPHIxnvihLlFYrv+b3rMXUXjUJIC2OhxT1v4pXLLEc45oA04Z1OQeT608SFRgSD8azE1KEx8JtYfrTU1Mk4YH8KANWK88nrgn0qdL0MMsp/4CawvtDyS4Q8VZiuCoC7vrQBsQXbHJLYA9+atw3BTPzZz6isCK7VpChfp71djvQAMc/SgDctpGfIyOtXo2KKGDDnisWC4BwF4+pq7a3WV2O4GDQwNa2lbaYyRkkEHtV+K6KjEZ4zznnNZEEqMv38j0FW7d0ZchjUN3A5zx/dAeO9EiU/wsR+RP8ASsDxLcFtiDqHT/0GtPx1Ov8AwsPSAf4LdyP++GrD8RzgTIARy6jn2Ar5rNtcQ1/dOiCXIc98aJ/+LZXMafeN1COfqa8t0qRFkQMwBx616Z8ZnK/DmYsy83sPT6mvLtOETSBz2Ffh3G3/ACMn6I9jApezR3uhzMLZT26D6Vr207E5HYVh6DIrWyIO1bFuSBkV+R4xatntRbcdS07OwArP1RgsD89RV6OUPwetUNUUtEwHpXn0mlVi/NFp2dz83f8AgrtoV6nx68O+I57Ym0u/CghglPQPFNJvUe+HU/RhXtv/AATf8Q6Nqv7LOlWOnXySS6ZqN3bXqL/yycyF1B+qupHqDn1rs/25f2ZJv2lfhONK0NreHX9DmN7odzccI74w9u5/hSQbRkdGVM8Ekfnt8Kvjj8Zf2OPiJqUWn6ZcQOsgt/EfhfVUZY5yvAVxnKMuSFkXscfMOK/qTL6VHj/w6jleGmliMO/hf2ktbryZ+c1ubJuIpYipFunPrvb+rn6oRuh/d7xuB5HpWlZyKwXB6V80fCX/AIKU/s1/EGOG28U6lc+EL50A+za9H/o4b+4lymVI9NwB9a968LeM/DXiuyGpeEPENhq1q65W40y9S4j/AO+oyfyNfgnEfCvEWUzccRQcV3tKz+drH2eFzHBYlL2c7m/MwxwaqTOvc1Vn1EDI8zH41UuL6QruX5vcmvgZ4StCVmj1PaU3sO1DyzCSrDJ6c15X+0z4n0vwf8EPFniLVZcR2/h67VVz95niaJRjvlpEH1YV39/qcKwM8twqIiku7HGAOtfAP/BQD9rvS/ijMfgv8LNYjudGtLpZdX1SGTKXk8YJESHoyJycjhmAweK/RPDbhbHZ9n1PkTUKclKUre6rdL92eLnWPhhcLJX1krJHIf8ABOttRj/ab8Ly2Vuz7I7lLoqfuxi3bc30GQK/TuzuUk2qM/jXxF/wS4+ENzEup/Ga/tCtu0J0zSJGTG5tytM4z2ACpnoSx9DX2pZuySAgd+9e7405lhsw4q9nS19lBRb8+3yM+F4VKOA97qa8DgHFO3j0NVobjDc4zU1fic0lI+oUmxZXXYPY5rN1PLOGXtV+X7g9ziq9ygZcY+la03axE/e0PDf2wf2bdZ/aL8I6TpPhvU9PtrzS9RkuFOoAgOrxGMhWH3Tg+nOaf+xJ8BvHHwE8D6t4b8aLaLJfast1bLYXHmIgEQjbJwOSRn8a9nNuxGCBj61JFHsQKe1fWS4rzWWQ/wBkXXsU+bbW/Nzb37vscEcDSWN+sv4vwL1qcnGewq/Av+0KzoCR09qtxS7SATXxVZLnPQirIvRuqcMfxp+9GYbWBqp9oGMZpUmYt8rZrnaVy47l9XG4j/PSpoZAoyD6VSimffjA61LHO44wOlZ1EjROxoRzBjuNTRSpyc1mpNx8xx9KmhlbsaxdthPU0lYAZz19KmjdSBVOGZDgZ571OkiDAz3rnqwjygWkHmNtU8+9OEZ83bkcVDHMobINSxSqXzmufkiBZiSMvgZyOtWECj7vpzVS3l5LnHTmrKOMZWvWwlFQVyHJ2LUTxPyc/LUscqF8DPNU4R8xbPU1PGSrgivVUIqFzNu5O5DnaDyKXyz6imjru7mnt901UW9DN7jAAW27hT9wXjPIqIL85+Y0ki/OfmPX1rugtLkt2JWlOQWP5UGZPU/lUAGO5pGcg4rVu4uZi719aZMQQMUDmmSuRwPWhbji22ZOtsAwX1WvMfGHymSI9ea9K1yQ+auQPu15h4zuSbmQqB0zXv5fFKaOXExSjdFb4IxtJ8ZtKZcfIszNn08p/wDGve75SHzkcgn868E+A0jP8ZLIED5badhj/rma93uJGa4CHp5Yr964ESjg3bufOY5ttHZeFZF/s2EA9VlP/kQD+legxsBCpJ/hFebeFcmC2TPBjkH/AJGr0FpQsYXJ6etfrWTxUaMn3ZwS2JppUIwM1CBk7sjrTBIg/iP50xpl3YB/WvYILOR6igLG3LGoMn1NGT6mtXLQCdSqtwacQkn3u1VSzAZzSLOV6mpTbAtBQDwRj60rkEcGq6zgjO79aXzv7pz9aYE8cjRt9wEe9T/aS42lFAPfFU1lYjJApVY7utAFuJ1Vsk1OrrI2VP51RSXZnJ6+tPWZgNy0AXiwGDmnrIpHeqUdwx5bHSpoZS/T1oAs5I5FTRszL81QJJ8w3AYqT7QoIUAUAWFZThWBx3qxEq7cJwPeqkRDHJ6Zq1HtZMKT+dAEgYKMVKHBOKgAxUqfeFAD+/4VJUff8KkoAKenT8aZT06fjQVHc+3aKKKCQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8gLnUZI1DIoznmoTdNKxaRx+FUzqEUw8yB94H8QHFQm9fcSW78Y7UnsBea4ySFGab9o2kGQHHsaz3vJo87jw3So3uncDjGKi1gNN7lWf5AMe5ppkUY2t37VlrKzSHJP505Z5CeWx70Aafnpg/vOg9aI5ysYwT74PWstZXD7vN4z0xT/ALUQc56UAaQuYfOKsDnA6mnrOAcgcVjvcqw56+tKtxIqDExx6UAbS3saEkEdOxpUvGkOVPf1rF2j/nq1TWtytsOWJ5zQBsw3WxumT3rRtLpZEHOMVz8OowkZJwe4zVm2ledzsfA+tAHTW1w6vlnBXt61cjuSTlVBz1rn7WaSFhGjEnuc1et7qaJshqGBuQTtGdyE/TNaEF6WhKAc47VjJqEQRWZskgcVZtrgojT4zxnGaizQGB46uGPxC0/B5FtLjnttbFZGvThpoh6sP5CrHiWZ5viXZRsethIw9sK4qn4hGy5jXOdr4z9AK+Xzb/fP+3Tpp/AjnvjW234cuFHP2+AfzrzPS1ZpvmTGO1eifGidz8PjH66lAM/iT/SvONLu5Ek3DoT0r8Q42aeZNeSPYwX8JHceH2AgXn3rYhkG371YGgXEhjjRsHcmf1rdgTI69q/I8Y020ezTTcSyrKO/NV7ti4IBzUwXMnl5/Go54SCcNn8K8xy5NTRJ3Ma9i3JJn+4AB+Oa8q+PH7Mnwb+O+miH4j+DIbq6iTZbahC5hubcdgsq/MwHoQR7V7BcQDaVJ6j0rLv7NG3DOc9sV62WZ7jcrrqvhqjjNdUZV8PQxNNwqQUk+5+fXxO/4JGauks1z8LPitDcxscxWXiTT8MB6CaHj2yyCvFtZ/Ys/bO+DOoNq2keA9X2RHcl/wCE9U8w8c9IXD/oK/Vi9sfLyc5/CqFzBAdhlQtyMAgcfj1r9Sy/xt4io01Tx0Y149pL/gHz1XhbAuTdFuHpsfmHpf7Xv7ZvwylOm618RPEVs8YwbbxJpHnqMdv30W7/AMe/GtK8/wCCnn7TgtlhXxB4ZkcDDMPDkYJPud9fo7faXZXyMbiLfnjD4Yf+PA1gXHgHwg0hkl8M6Y7HqzaZCSfzU10y8UuDcTLnxGURcu65f/kTJZFmlLSGJdj8xPFv7Sf7Unx/L+H9Z8da9qttdkodI0Sy8qGUH+ArAgLL6gmvQP2ev+CeHxJ8X6la6l8U9Mk8O6EkiyPbMAL24PcCNf8AVD3bnBOBX6A2WjWOloU0yygtwTyttCIhj0wmBUsUdtEdu3HOcKAAKwxvjPUo4CeDybCRw8ZaN6X/AASQUeG6kq6qYqq6luj2KHhHwn4e8DeHbHwj4R0tbLT7C3WK1tkA+RAOBn1PU+pJPetq0Dhzuz7U1VXIcelWIIsndu6e1fiOKxNXFVZVasryd7n1VOChZJWRZg65qbJ9TUMAwcUpuMDOz9a85puR0K5Jk+tKvLc0wSZjD469s0sUm4g4pWYSJcD0FMcDd0p9IUyc5ptiC3JPU9qlqKMeX3zT/M9qxnFt6FKbirFhZeB8g6U+NyzcDGPSqoLkZ30+IuDndmsnsUX1Lbjgn86ljYhclqpJI33vXtUsMxztasmrlKSW5aEjfwjNWIJ8AcVWjweAakRtp24rOUWtyXJXL8YUfMG59KmRm4LHFUo7rDE+X1HrVlbjd/B+tc807BzXLiOuc5qdHXI57CqUM27A2/rVhZMYOO1ctVOw7suRHa49M9KuK4duBjiqMLhiG/SrUUwBCkda9HC1HazJexaT5Tk8c1IGB5BqEvkYAp6NtQHHevWTTWhBZiYFME8ingk9T2qBH2jOOoqTzCH2lOx5zRyyUiHuKPvn6Ukn3z9aaZdrk7f1pGl3MW2/rXbT+EmWwOSBwaZTi24dKjL4OMVoQDMMcGobh9vVqex2qWxVa7l3ADb3x1qlCW41d7GTr8qrEx38gGvMPFMqm7kycda9J8RcRMfUmvMPFX+vLf3iTX0WXWc0ceLu6eg/9n0qfi/bsedun3TZ/wCAAV7sSDcqpPOP6V4f+zdEr/FsO3RdLuCf/HR/Wvb2IXUUBGeCK/euB01gHfufPY2SbR1vhGPelsoPIibj6yNXdyjHHpXC+DZw0tsQmP8ARg3X/po/+FdzK+eoxX6pkrboyfmcU1YgEhTPfmms5Zw3T1pN27PHenKgI3FvwxXtEDxM4PI/WpC5bBz2qIzIf+WX60pnU/w4/GnZgSDLcbjzSGML1OfrUbXG0Ehf1pFuWbqv61SVgJegpVbY2CMnHSoHlZjxxToWJOD6UwLAcsMjj6Uu9zxj8c1GZBGvPc0M5IwOPegCVGYZ4z9anhcFfm/KqaMy5LSED1p6ysB8jbzjkL2oAthl6A1PbBscevrVBTJjcWqVLmRDkH9aANFSd2CakQZPIqvbThoyzDnsM1YiOe1AE4J7Gp4GIKgnvzUCjBAqQEgjB6mgC2M859afAT61HGCF5OafCcLn3oAsqBxx2px6mmxncM4pxOTmgAp6dPxplPQfLQNOzPt2iiigQUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+Lvm29sPLiJ+g6Go5nODt+8T09KdKifeU1Hxt460AKZZIwVdsnH5UbyRwaYwXYRtOcde1CEAYJqZAPDsDkGmec45Jz+FIzPu+UjFBXHcVIB5v8AsGkdyeAevakLAHBpvOd2D1oAeAB0FKGOAM8Cm7xjPpQrBhuFAE3nj+6adHfW8ZSKVyheQKuVznP8ulQHg4pyMeFCZ560ATIU3l/Xrz71fju4UAS15fuKooPM+XaAPrU1tGIZQQKAN7TrhowHlADEdM9K0LaZpF+dcc9axbZgWwDyMEj61p2UqsCOeDzmgDTt3RXAIB4/vVpJKBAwC/w9KyrcjzFAPStCGYu2z1PepkBy2vzbvijZAHppsv8A6C9ReIiTdKT/AM9DSa44HxPgP/UMl/RGNGvfPdRgfxSkD8hXy2bf723/AHTpp/AjlPjKM+Av+4lDj/x6vMtPch8bv4hXpnxkJHgCIg9dSi5P0avLtOJLdf4hX4XxpOP9qyXkj1sG7UjvPDu1ljJ7JgVvwMdvBrnPD3ESj3robb7mK/I8VNKbPepq0SzC3zbz1qRgCC59OlRxcH6UTyKF24OTzXh16tnuaLVlW5UE5I7VRubfgnvV2UhiQKguBvUkelc31ixXKjHv7fK81m3lgGjVlAzkd627mLPJqtPCrBR7DNYyxb5rC5TBktGUEdapPYM5JxXRS2sRJGOo4qjLbIhPBx7VdKs5SsxNWMWXTjnGKaNPYHIFas0aqcio66OddxFJbQ8A1NHCEzmpG6n60mOM+lZ3dxrQbko3ynFNA3HGM0p+ZyBUkUbR9SOnaqTuaQdxGGEVAO/SpookUZ2449aRUJbdT6YPcKKKKzEFFFFADwRgc0obHQ1A3U/Wnwd6xlE0LCM20c1J0qJOADUiuCayasJq5atHcjk9/SplZ/MOf5VVSUggr0FTRzMzYPQDmpkuYl6MtoBwfap0fDY3VBGwYDHpUyKpJ45rlnvYE7Fu3IPftViM84Y1SiJXpViJ95yfauepG7sWtS5bnawzxVhNzMCew4qtGN5GKuQHKA/WrozT0QPUtLnYPXFSJvKgEHr6e1MT5gAKmiGRtz0r16M7bkNWHAHaOO1OM7McEHNSRCNgFJ5o8pS4auvmuzN7kOcnrR706RArcUoJMZUR/jXVT+EiWxGhYkhvT0prdT9akHQ/So26n61oSNk+4fpVScZUnHQ8Vbk+4fpVaQHYT710w1iVHcw9fBaDJHbmvL/FTD7RtyMYNep6/wA2ZPsa8o8WcXbKe2a9rLVaojjxPws0/wBmhQfihK+3gaVPn35SvaX5vA/cKxz74rxn9mRCPiHeOT93RpiP+/kdexz5jlJB6D+lf0DwRG+X/M+axZ2XgmHfJBxwLIY/7+SV212ccA8gVyPw9iMjRbiM/YYsfi8tdjPEpOSDzX6hkseXDP1Oap8RSEm3tn6U5ZVxyhoaMD7vrTCMHFewZjnlQDhTTTKh6qad5efvUeSnvWgDfNDDaBSoTnFBjVRkUJ94UASMADgUsbBWyT1HFI/3jSxgFufTigBzg/8ALXBz93npTow45YkgVHJndyQeOMUscuzhulAD5W3AR7SFPLe9EbQA74oVDNzuA54p6OoJDLkfzpsiRly8ceM+hoAnSbK4c59qkiAkfGOMdKrRks2M/mMVaiBQBu9AEyNsYMO3pV2KQFQRwapQnHJq3GNyAg9aAJ1nbcBg9etW4wre5zVOOJmIA7Vbt/3bDPb0oAsxEleetTQqm3B/nUUI3HII59aVxJGNwjY8gYAoAtRjA6U6mRbgMP1p9ABT1I29aZShCRmgD7fooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/FllwOpoVQRk1KygjAApuwjoKAI2I5BAxTCsJ/iapiozyKbIBxwKAIwi9ice9NC4J5PFOMW9uGI9hSGPbzuNKyAaVBOTS/w7cDpRRUWYCbBjHrQqhRtFOH3TSDkc0WYCRlpdx4BFQrc7p9u4jHpUzIgHyAgmkitkDZ4Oe9UlqBYhkZSMenertqcsWI6VTjUBcY6CrEJIYYNOyA0rWMGVpd+CQMj6Vo2KBwxJIz6VmW5wQfzrQs2y2EPHpQ0rAadqxU7vfvV+NisPnDrvIrPtwVXLVfiGYQPoT+NZS2A5DVmJ+JqE/wAOlTEf9+m/xqTXWK30Kj/ns38qi1Yj/haLr6aZJx/wDFP11s3aEHlZTn2r5bNv96f+E6afwI4/463H2b4f2wGMPqaZ/BXI/lXmGlSuCAQOfmr0b9oGVv8AhBbNQBn+1F/9AevNdLLPMHx8oUZr+duPq/JnckuyPbwUV7I9C8PZ+zK565rftnO3oK5vwy5+yhmJweldFbA7c+tfkWKrtydj3KXwFtXIfaO4zRKAwBP0pF/1o/3ac/T8a8eU5Nts0siCSNV5BNQyxr93JxirEvT8Kgm+9XPUqxS0ApXYEQ+UZz61UdAx5q/dgHGRVKRSTlR9a5VJtgVZUA59KqzRkA4HGe9XpI2PJFQTiNeHbBPauum3cDMmgY8VE0Ow4NW3IZ8D3qN0J4I710xlpqFkVTChOcmkaNVGATzUpVh1FIQD1Fbpq5m9yAQoGLZPNPXlc05lOeBTVIb5VNU3bYuLsKrkNtp9Iq4HIpaV2MKKKKm6HZiqATg07YPU0idfwp1RKTvoNIYYUJzk05ECZwTzS0AEnArNt2KHp90VLEgJHJ5psa4QBhzThx0rO9wHZKjA71PB93d68Gq4DN0qxADtC96CHuWo2KgY9Ksxkk5qqhHA9qsxe9clTSQieEbmAPerUMaqMgnrVWIhXGasxt3B4rmm3cd2WrfgirUZKKMfrVWD75PbtVoY3FaxjJwldFlqNyMYqwAxXKdc1Tid92zHP1qyjEADceterSqrS5Mh6PIr4Jqz5je1QAfKT3I4qTcCFAPPevSpyvuJJNisA/JpqM2duTg8GpUUgkMO1Qy8vhfWuum2ZySuPkRUXK1EUBOacu7yvmP8XrSVrdmb3ImAJ2Hoc1DOgRdo7mpz/rPzqG66D611U27CbaWhz/iFytqVHpXlnisBppJT1BNepeI/+PY/SvLfFPWT/er3Mt/iI5cR8DNv9meNR44v5ecjSGH4NKuf5CvXpB5s5DdxzivJ/wBl+Ev4t1V/TTF/D96K9bG0XLj0Sv6E4Jssvj6s+axPwP1O4+Hx2TwKO9lF/OQ12krZQAgdK43wRFuvYscYsIen+65rsrlSh2EYPYV+n5P/ALs/U5qnxFRUDswJPBoNtH1JNLFwzA9c0+vZSVjMjWON1ypOaYY5QcYFOlTym3KOaWMvKMEd+uaYEOSx2mlCAHNOkhCMD70lAATk5oyR0NFPhOG/h6fxUAMyT1NORVYZ3c+hHFS7j6R0uRjGRQAwCRctvB9vSljdi4VgOmacuCcL39KTAxkCgB6PhC+0ZA44qW3meXCnrUONxAUdqdGfLfIPzelAFzGEI9qsWkjCIfXFQQOnBY9u9WoVymQOB1oAtxSsB90VPCS3JqtCy5C561ZHCAjjn+lAFmAZOcmpkdywG41BbugABPNWFA3DAoAnQfKOc+9LSIRjFL1oAKen3RTdjelORmVCu36UAfbtFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH4vk4GaRTuGcUpAPBoAA6UANKZOQaRoXb+E0/pS729aAK5UxyHNNVwXKkdKsMqsdzDJpPs6MflABPegCLK/3f1phRySQtTOqA44/OgYA6UAQEFQQwxnpSAEDmppdr4+TH1phUE5IoAYPM/u49adHxyik88/WnEA9adEMduM0AOQZ49anhPz4qEctkcAH86tW8If5lI4PPvQBcg6CrllMqOGKmqlsCWxjoeK0oFBUcc5pPYC/byCSIFavwHgr6ItZ0G/OMHGPStNFC9BjMY/kKzewHHXzb/itcZXgaY3f2p2vEG9Yr085v50/y0k+Jlyzpk/2eQfplRTNVAacE9TO386+VzX3sXL/AAnTT+BHB/tBkJ4NslPfVR/6LevOdHBJZT/cr0T9ogE+ENNBHXVBn/v21efaMpL5ZeoxX82+ICbz6T/uo9zA600dv4ZP+gRnHeult+EA9q57w0q/ZMY6Dit6yZinzH86/IMXzRkz26StEuL/AK0f7tOfp+NNAOdwHNKMscMK82pzKJoRy9PwqGYDd1FWXTk/LxUEiA9V5rzJ8/MBTuxjHNVWGMD1q9doAn3aqBQQCR0rSndbjs2QOnbNVrmLcwOOlXrhVVsAY4qlOziZUB+XJzXVCSTBqxSli2ndion6/hVucBkyR3qu6Lnp2ros2IrkZJHqajYbTjNSNwxx61HNwMiuiO5DQlIFAOQKaHb1p9WOIUAAnBprsQeDUsYBiDEc5qW0aJMPKi/uH86PKi/uH86WisShAiKcquD9aWiigApyDJz6UoVSOlKAB0FJ7ASA5GaKRPuilqAHxdfxqxaruc89KrI6qOVyc1LbyMGyGxmgh7l1I+evarCDGB71WRz1BqZXYk4NclRe8IsJ94VYjbAC4qrEXIyc/lVm2G4ZYd6xlF3AuwnGDVmL5yX6cdKrQ/d9/wD69WkG1BxjNcy1kXzImtmV335xgdKsJ94VWtVAcnbVqJCzYrtpRcmiW7ky9B9KfHGxIJ4waVI8HBXNTRKN2HGBXsQV2mTzJMANzFvamlVVxkZyalYRgZQ/WocuZBnPWuynuTJq9yOVNp68E9KZVidAQPlqLYvpWyVzNu5Af9Z+dQ3XQfWrLxkjIGD61DPCSoy30roi+VEy2Ob8SHFqT7V5X4pk5k4/ir1vxJbqLQ5x3rybxTED5xDDgnFfQZXBykmctf8AhnT/ALK6+b4h11s4xpcYH/f4V6qBm6lH/TKvLv2U0C63r7EdNPhGf+2jf4fpXqwRfMlbHPljJr+heCoNZdF+bPm8XpG/mdz4FTN3Gc9LC3P5of8AGuv1Ab5DzjmuT8CqftgGOlrAv4eWOK6+4hMhzu5Pev0zJ/8Adn6nNU+IowndGJcfep5OBmlMQijCAdDSda9lbGZFETI+5j26VJuSM8nFARU5C4oKo3JANMBsq7l3Z96iqUhydpHFCbATI0XHTbQBFTolDNggHjvTjEvmA5ABp6BJCfKXBHf1oATyU9PyphTn/VH86nVQBhmBNIAN3I4oAZAMP9wjjuaeqZTOf4qcAucilAAGB0oARV2uvPenxqDIxPbmm98+lPjBwSB1oAliHyBvWr9rnAHbPNUYkwBufgVcgEiDJbKt+lAFpUHmBwasKxYBAOlRQRhlDbsjGetTRp82VOPegCzboMfMOQKsRnPzVDEGT5nOQamiHzBQOM0ATIMDPrTl6j60hAVR2p8SggkigBacrlRjys++abSgtjj+VAH23RRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+MOw+oo2H1FOooAYUIGaSpG6H6VHQAUZI6UUjHAzQAjqnUim8dqcAG+Y0uwUARSdqbUskRONtItuxGf60AMAJOBSOzLhAOtTC3YHI/nR5QBBYcjpQA2IFlH+yec1btFdV2L1JquEy3y9av2gVeQOe+aAJ7MnhSDkHmtW0iY8giqVnGuTVy2mMbbTjBpPYC/CwVQp6k1e3Dgf7IX8aoRg5G761ciO8Ix74P61HQDmQDH8S7zP8ABYHOP95ah1M7Zxn/AJ6Mf1NTy/8AJS9Q/wCvA/8AoS1DqQzdxj1d/wCZr5PMv97l/hOmn8COJ/aAgMvhfTUJGf7UI59o2P8AWvPdLiJYKo969D+PrsNF01QBj7e7fj5eK4TRlAccV+Bcc0Y1M4lLrZHs4GT9mjsPDEDi13MOK6G2iXaPasfQMCyACjrW5ZKGGDX5HjcLHnZ7tFtw1LCxqQBtP5USwbVyPWpEOABgUsihl5ryK1DoalaQYTHsarup3b+1WpFBXA61FKig4FebUw9mBUuUJwfeqkoUR/KOc81fnQYHJ61SmiYKfTrXG1aVi1sVrvhgfaqk42uSatXvBH0qnNMC4VquPxA9iGb/AFQHpVaQgHk9qmuHIQY71VuGJIOa7oasgjf7x+tRSuCMCnByTio36/hXRZIhsaOKfvHoaZRTBOw4jfyKljIEYQnnNQhiBgUqMS4570mlYpSdyaiiisDUKKKKAHBwBinKQ3Q4+tR0jSbOxOfSgLxLC4wBkU7b/tD86qCfn7rfnUnnr/eNKyAmIx3qWLjH0qsku4ZH609LnAzkcVLWpD3NKDofrU0XHNUra6J4OKtwyqawlFOQi3E4xVm3YMMiqcbIFGKuWjR461zz0VwNCExjlfX0q3GitgntWbbsQRzWna/OvPas4Ueb3kBZgiUnHrVuKJF4yPyqCFVHOelWYQJPudfrXs06LUUJuxJlccGnYKp5mAQe1RPGVYAk8+9TbS0G0duldMYq6MnJ3GqxkBUKB700oUfBycHrT4kKZJqVED5z1NdMUkJu5BtMnAGPrSNGFOGGT7VY8kryR+VJIoUZx+ddVKKluIqSQuoxkVXuYmCBjjg1dkBLZTp71FfRP9nDbea6Y0HJ2JlojmfEyE27/Un868k8URkSSqSOpr1zxKsn2d+PSvJ/FEbtPNkeuK+nyzDODSOPESfIdR+yrE51LxAR/wA+sI/8eevVDzJN/tLgV5n+yku268RMRz5ECj67nr00Y8+UdgpNfv3CEJQy6PzPnsXrBep3/gpSL9j6RwD/AMhp/iK62VwOxrmPA6r9ucf9cf8A0XFXVTwpya/SMpSWFdu5zVPiKcylhkUzYfUVO8ZI+X9ab5L+1estjMjZQwwaTy8fdqXYPU01gAcCmAwIM/P071DeM8fzRcg+hqdgWBApqRiViqjK+9AEMCvJDmXGT932qxEqopx9KRY8EJjBPIFSNGyDJ7mmtwIyhJzTlyoxjNFIxwM1VkApJPUAfSgcnFKRwD60L1H1osgF2H1FSQj5dvvTafH0+XrSaVgLEUawIcqHqa2SQAZbj0qO0VlXe/QVaiCNyM9KkCwg2oAPSp4yAoJ7GoYhubafXFTeWpwnOM0AWm5QAelTwf61frUCjBC1YiQCQH3oAsOisATQg2AilP3RSxoGBJoAbT0+6KNg9TSxgF9h6UAfbFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH40/ZT6mj7KfU1NRQBVa25NHkMvQZqwz9RtptAFWSD5ssKQKQeRViYnbgJn3zUQIB5FACHC8HikMbEbtpwT1qXKPyVxj0pDI23YDxn0oAi8vb92jY3pT6KAGeXjoc06JSC2R2pafCR8wK54oAVF8xs45A4qeMhCN1Nizu4i6jrmp44N7fPxjpQBPbNucMoJA64FaNvEsjiXy8c85NVILQEgRSMpxzVy3hdduWJJOM4oAvRO4b7i496uRY8vOOgqrb20vBOMZxmrS/JGy0PYDl4gZPiDq5XnFkP/Q0qvqLK11EAejNmrFnx4+1g+too/wDH0qpen/TP912r5bMv98/7dOmn8COK+O0iDSNK3H/l7f8A9AFcNpv+sIX14rtPjww/snSge93L+iL/AI1xei/vZAwOM1+B8Y+9nE7dkevhP4SO70Eg2aqOtbVqcEYPesTQW22aSYz7VrR3UUEirISMnjAz2zX5ji6U5XSR7NCS5bGjCwDhSeakDL5uM1X3yoguHt2XgEKwPT6gEUgu8NvKgfjXi1qEoys1qbQnGT0Y+Qgszdh1qGb71SKySIfnA3VE77znFePWjO8lbc1Ip+g+tUJw28nsFq/P0H1qlP8Adb3AryKlOVOVgKExJ6ntVOVgJhk1cm6fhVGfm4Ue9VSTKjuV51YA596qyMAME96uXQAyCao3LBBuJ4zXoUlcipvcinkVVB3dqz5dQMcm5WGGOOv+NN1K52kosh5JA4r56/bI/a/tv2eNEg0Dw9ZQ6j4k1cOLG3mOY7WMYBnkA5xk/KO+DmvqcgyDMOIMfHB4WHNKX5LdvyRx4nF0MJTc6jsj6Kt9Qa4YAEHPQDqacJQTgPX5ZJ/wUE/a/wBF1dNQl+JjThjldPutLt2iZfTbszs/H8a+2v2PP2wvDX7TvhmSGZYbHxPpoX+19HRiQVJ5uIc8+UecjqrcHjmvtOKPCfPOGsA8ZOSnFWvy/Z835eey6nFgM3wuPlyxVn+Z7uucc05eo+tVIb5Noz1IyQe3+RU8U6sfxr8tlSknoerfUsZPqaVWGOTTPMT+8Kb5y7iv61HJI0V0yYv5Y3Un2n3qpPdYXbn8arvfFTjj69qpUXIdy+16gbBIpBeIeARWM96GfhiTuwAO+TXAfEX9rD4CfCO6aw8ffE2wtbyNsPYW++4nU+hjiVmU+zYNepgMizPM5+zwlGVR7WirnLVxFCir1JJep62rhzup4O/G0968O+H3/BQD9lfx7ryeGtJ+Jq2l3LJst11mze0SUnssj/u8/wCyWB/lXtkFxFLlt+G6H+f8sGqzThzOMmko46hKnf8AmTQ6GKoYj+HK/oW1l8pcE1G9yBnBFQzO23ANVbmZ/K3A15CpJuyOl6D9U8X6H4bjjuNc12xsUlkEccl7eJCHc9FBcjJPoK2YdSlWLcy4BOM9j/n1r5R/b9/Zr8ZftK+GdFg8IarAJ9Cup5f7MupWiS68xV+ZZBwroEOAwwQ55Bxn4u0n43/Gj4Ma7L4V0f4oajpeo6NIbS7gs9WYqHT5SpG9omIxjIz065r9n4X8JMLxbklPFYTFxVZ/HBq/Le9vvPl8x4jqZdWUZ02490fsfbXCyRJIq/K54YnqK04LpWGD93bwQtfmD8KP+Covx78ESLb+PLXT/FdqowReReRcYBHSWDG76sjc9a+w/wBnH9vr4H/H2WHRbLWZdE12ULs0LWWWN5ie0MoPly89gVb/AGTXyvFXhFxbw5GVWVL2tOO8oq9l5pa/gdmX8S5fj58qlyy8z6ItXXcOa1rX5h8tYVrOvmmIgiRCAyEdPqe3bjrzWxbSsBwK/MaUJJ8rPebT2NOBTtI96tpD8hBGMjiqVsWK789+laKtvQNjGOK9KNNJENNgtvuXcD0qZIlDF1psbYTGOtPifKYxXRFWsZNO4OCRxTFBBANSqu7vTti46V004vcVmMoYArjHNO8v3pCMHFb0/iBqxCy8cCq94rBBkVaddpxmoL37g+tejEl7HMeJVZLViwxhvmryfxaMNMcfSvW/FY/0V1/vNXk/i6PJm56V9PlG8TzsR8DOt/ZXRWs/Ebg8mW3H/jr16ZENplLf88x/SvOP2V4f+JR4hIH/AC8W/P8AwF69J2DMoz2Ar954XTWAi/U8Gs0eheB1P9oznHAmX/0WldXOMTOD/eFcz4Jj2X0/PWVf0RB/SupuIgZWfd1av0HKv90S7HNIqP1/Cm1I8fPXtTfL969VbEEcgd12hKiIKnBqZgSMA4qNosH736UwI2OBmmw52/NJuYdxS3M9vaRGe4b5FGX4osrqx1Fd9k2B3yMUAO8xz95enSjzGfgxbffNOaIn5GPQ8Cgxuoy2PzrQBApPQUm5/ukcUqPgEY70Eqejc+lACU9PuimU9PuigBafF1/GmgZOKmgtwxz5gH1oAkjbchCn/OatxRyFAAO/rUVtGoQjHapYmbgg1MtwLoGE/CrNuBt6VWjyyYPpVm2/1effFSBPF1/GphGqHd6VCg281ajUSfeOBQA+A5U1IBuOPWgCGMD5jzSgkHcuMduaAEuZbPSrWTUNTu4re3jA82aZwqrlgoye2SQB7kDvVvYkQ5h/Ef5/zikSQSLsdAQTyCAR+RBB/H+eDUvzk7t3bpQB9k0UUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfji0e0Z3A/Sm4I6in7x6GmO4z0PSgAwD2oKgdV/Sm+YO1Izu3Q0ADoWP3wB6U0rHGNzIMe4pHkKDLAn6VHJOZF24PXvQBKAhGVApksDHlc8+lJHKqLgg077Qe2aAGxw4J8xwPrTZAA5AIPuKGZmOTSUAB6HFSwAFAcc45qKpbb+L6UATwyqOCvTpU8W6V+AQB1qqv3qtwM2Dt4z60AX4l2AESgkcAYzirlswK/MRuB6Vn2meVPXcKt20i+YeDyaANC3nuHP7yIBc9qtHHbpVe2OYsj1qdQTGR7f1oewHMRFR471ZlI/491yQf9tKpXXzXZAPVjj86ngkC+MdaYg/ciH/j61XmYC7Q+in+dfLY/XFteVjaM2o2OB+PUo/svR494JNzOfr8qc1yWgAAoB6c10fx9YrZ6EqnktP/ACSuT0C5Kup5+YmvwTi5Wzqfoj2sH/CO/wBIbbYKFcKR7Zrj/wBpT4pXfwj+Bni74lafKHu9D8P3N5aMF+5KqHYfwYg/hXVaVMv2UdeleP8A7ejiT9kX4lKo/wCZQu+v+7XzXDmGpYziHD0aqvFzjf7zqrzaw7sfCP7EX7Sf7VXif9qXw8mkfEzXtduNa1NBrFnf6m9xBJbN805aMkoiKpLDAGCBX6y3dzOk+I3yn8PPUZOD9a/Jb/gkVB5n7XelXjNxD4d1FguO4iVR/Ov1RfUJtoDHPev0TxzwWBpcT0qNClGEY00/dVr3dtfRI5cpnP6s23d3N21uZWXkH8Ks1k6VdSsCM8EdDV43Bx+FfzpjaPv6H0FJPluSTEEDBqlKRubJ420/z2YEjvVW5MnPIrwMVSe5oQTA46VRlB88tg4zwasTTNtIJqlNcHHBrnpxd7MadiK9YnOGzz61j6lc+VGys+Pqa0J5GU53Cud8RTkKw9eBXqYenzTSMq03GFzJ1/xBpumxSXOo6nFCsEDTujSgN5ajJcKTkgYr8sPiN478XftEfHfUfF9vYvNPruqCx0OzPJijDeVDGAeg6EntlvUVr/t6XHijT/2tvEzapqtxKrJE+nq9w2Et2gjKoozwM54FdR/wTr+Hdl4k+Okvi3UoXlt/CmkvPEzcqbqbMaH/AICN+B7g9q/sPg3hbB8CcN1M+nVVSU6ScWvs31Uf/ArX+4+BzLESzHFLDRXXU+jtK/Yy+EY+CJ+D2v6HDcTyW+b3XY4FN19s2585JCNwAYYCZ27eP4zj4ltbj4l/sY/tB/arScw6p4evU3N0ivrZzx9Y5Yx93nHzdxX6dkeUisp5C859a+Z/+CgfwDPxB+Gh+JGhWCvrHhuJ5ZRGnzXNmctLGf7xU/OvcYI718nwHxtWxGbTwWay56OKunzbKUr6eUX2PVxuX+wjGdDTlSPqb4TfFPwt8YvAemfEHwjcGW01GDfsDgtC+fmibH8SH5T64z3rrreb90GVTgHrX51f8Exv2jV8B+Opfgx4jvdum+IiraS8jfJDeAYCZzgCRcqffaehzX6F296FXbIGG49GHP41+X8ecJVOGM7qUYp+zlrB9LX2+XQ9jLsWsXRT6ov/AGn6/nQZwvJUjPeqssgZQUanTzKIgGPIFfCKk2z0+Yh1G9MILHNfP37ef7Q3j74HfBqLxF8OtQS21K/1mKxW7lgEht42SRi6g8bvlHJBx2Fe367frtwTjjrXyX/wVB8Q6Q/wX0jwvKx+33/iGKWzTjlIkfex9hvUfVhX6L4b5VhsbxVhadampxcndNXVkm9jys2rvD4Z1IuzPBNS/wCCgH7T/j74ff8ACvNQ8URQGaRvtGu2kPk3lxAwAETOmAOSclVVmBwTxWN8IP2dPiF8Y5JIfBGhtcxRykXGsXTeTaxuOoZz95vYZPrWf+zX8Gpvjn8WLbwJaPLHp0Ctca5cQ4DRWqkA7ScjcxIUemc9q/SHwl4W8O+B/DNn4P8ACmlw2Om6dF5djZ26YWJPfuzE5JY8k8mv6A4y4nyjgeH1XKKEI1anvtRVo8vTmW977I+MweDxOd1HVxLvBHwp8Yf2K/iz8JvDDeKr2Gx1PT0AF9caU7M1qD0Z1dVOw8jcAwB6gV7f/wAE3v2u/FF3qcP7O3xQ1KS7QWrHwxq1wxMnyAs1o5YkkbQTGTypBTkYx9B3skdzBJBcxiSGSF0lidQVdWGGVgeoIr85vi7De/s2/tG6gnhWaQSeGNdS80p2bB2rsmiHHYbiPcZrxMlzSn4n5LicszKKdaMeaMkrWa0T+Wi87m9SjPI8RCvh5Wi3Zn62C9EiBN4OBjcD1/z0/Cq97cqluSKoeHNZttd0Cy123QKl7ZxXCKpzhXjVgM98AgZ9qnviptzz3r+W6mElh8U6U9HF2fqnZn30ainTTWzMXVNSCR3Eqgh0hZ4yDgggEj68gcV+OvgzQ7nx58Q9K8NTXvlSa3rsFo9xIN3lme48svz1IJJ96/YK78pbpWuf9WWIfH93oa/JS7sp/hp8ZpknXZL4d8XncFH3TBeA8Z91Nf0/4FVI0sFj40177jG3daNf8E+RzuDvTb2t+p+jfib/AIJ2fs76/wCC7PwlbaLLpd7Y2KWqa9p7bZ5ygA82eM5SRicsc46jmvkn9ov9jb4ofAQvrN1bHWPDysNviCwjZRDz8omT70LZwc8p/tA4r9L7SaDUXlu7Z90UuJYW/vI/zKR+BFOn0sTRPA0aOkqlZUdQysp6qQRggjgg5BBIxXxOQeJmfZLj5RxcnWpc0uaMndrV/Cycbw7hcThYTprlmloz4m/Y6/4KfeKvhLPY+Av2hJ5tc8MRssNtr65kvdOH3QXJ5uIlHBU/Oo6MQMV+mHhTxFoXinSLXxF4d1O31DTr62Seyv7SUSQ3EbDIZGHUY9gR+g/N79sX/gnzFY6TqHxT+AVkUhtlefWfCsMZYImSZJbUdyOWMX90/IOq1xn/AAT0/bo1b9lbxPbeBfHmpS3nw71ecG7yxJ0iVm/4/IPVO8kY6qNy/MCT9fxZ4fcPeIGVSzzhtKOISvOC0TXkuj9Dky7OMflOJWDx2q6M/XO1wQfTFX4iCnB7/wBKxNF1O31K1iu7GeKaGeJZYJbeRXSWNhlXQrwUIOQRwRW1bg+Xmv5knha1Ko4VFZrSz3utz7z2kWrx1RPx5Yx1x2pYgwXGDTIyGGB2NTxDeciqVLzJcrjkBx0pwUk4IxQwdehFIDITgkVvBWQcwrKFH3wfpSOoCbiKUqy9s0hAC/I24+hrWmryE3ciflc1XuAGZFIzk9KsP0yxwfSoJgfMjyP4q9COrE9jmvFwItm4/iNeT+K+kue57969a8YcW5Psf615J4tYMGx6V9RlC1ieZiPgZ3n7K6Y8Pa8+3k3cIz6/K3H616EMASE/7PWuB/Zb48Lay56HUox/5D/+vXekFonx6Yr954ZVsvj8zwK256V4JXM9yxXkSkZx0IC1010yhm+YdfWud8DENcXa/wB68fH5iugulJJJHBav0HLFbCRffUwlsVskknOaMj1p2wBTtFRN1NemtiBPahmQLgqCaGYBtx96hmZt25TximBHKLVwfP5T+IHpUe6yRwYCRj06Us0LXSFBwSO3eo49PaAgvk1SVwLcdwkigIoHrmhyMcGmgIRnbg0VQAUyuQ2DSCMhC27n60uCegoPHagAPb8c08kYwDTAc9jShT96gCSPtmplwQCPSq4YE4FSRR7x94jmgC9AcRj6c1LErh0DKRknORUEMJXGJefc1dgIkId+gqZbgTwggYx64q1bjEJBGDngVXQ5kDQjaT1z3qxHJLJMFaPoO1SBNGCwwBk+1Twq6/ebv0qCFZI5RyME1aXqPrQBMv3RTlVj82047nFNT7oqeMYtyPWgCWEL6DrUxUqc7e3TFRRoQBkjg1ZxuGQR071fKgPsOiiioAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/G+kMbMcipQCTgUEEdaAIMYbB9adsX0p8pUrhfSotjelAA4B+XFRyqFTIp7s4XYo6VG4mcY29/WgCOipo4xt+fg0Hyvuq3PpigCGilZGU5YUlABT4ZNhI2E59KYSB1qS1Pzl+3TNAE6gDDAVZiOcVXi+YsR3GKniZVPJ/SgC9bqArOOuamteWJPrVe1IJL9s9atwSIJMk0AaNiefwq1EASQfeqlrNHj71W7aRfMJz1HFD2A42DnxRrbnruiH/kRaqXEjfaFOf4antpEPiLW2B486EfjvH+BrPvWDXRAbrxXymPv9cf9dC3pBHn/wAfJwLbQmx0M/8A7JXKaHIgmiTHGSa6b9oGXadDt26qs+T/AN8iuS0MhZowTzur8J4vss3m32R7eCdqSO90mRfsQZeufWvIv28JSn7JfxGX+94Su8/9816vpbqbMYPQ15V+2xaR6j+y/wDEG2JOT4PvmAH+ygNeLwmof6yYZ/34/mdWIt7B+h8Kf8Ehmz+1NYyE/wDMtan/AOgJX6hibzAMY/Cvy1/4JPTxWn7VOiKknNxpOooRj/pln+Yr9QruUYCqcn0r9G8c6DfFsKn/AE7irfNnDl0rUHY29HdsZzV95Cjc9MViaNc7Uyauz3sZ6SCv52x0feeh9HSleC1JftiqxB6DpUUs7PkjoelUjc/OTmnC8QYUtzivna0Lx1NLu5HdO2zr2qlKxUYHpU11MHJyeKpTyoM/N69q44QalqWVrmdcZrmvEk42Fs962ru5+Y81zPiS7VUYE9q9jBU+aojCs01Y/P3/AIKc+HFtPjvoviIwqF1Lw2oLZ6mGYqf/AB1hXpn/AATJ8IG2+EuseOJosNrGuGKP5wcpAoGMf7zV5V/wUl8TDUPjzDo7yM0ekeGoV2g8K05aRv8A2X869w/4Jt3ML/sv6fAJMvFrF8smR/EZAf5EV/VXElTFUvB3Cxk9XyL5XbPjcIqf9v1H5Hv0m5iRIcnvVDU7G3urdoJo1ZGysiuMqVI5B/DNaKMpHB7VU1AEBia/nuhUqQqXT16eXmfTycZLU/NX9qD4Pah+z78arvT/AA/5sFlcldS0CcEr5aFsmNT6xkbcdcAV+hv7LPx8tf2gPg5p3jppozqKr9n1mIceVdIAGOOytyw+oFeT/twfCNPil8IJdQ0qxEuseHy17YsF+Z0x+9iz7rjH0rwT/gnL8c4Phv8AFw+ANa1Fo9L8V7IF3yfJDdAExMc9N3zIT7r6V+9ZtSpeIfh+8TFf7Th9+raS/VHzuHqyyzM+SXwz+4/R6O5+QDPWkuLovwzVShvIPLEaSAsQDjHamy3IKYzX81qjNVLM+p533KGt3SvMIWzjPzfSvz+/4KFeP28SfHweGY7gG28N6RFGV38CWXMjj64ZAfpX3X4hvDEXZj6A/mK/M/8Aau1Jbv8AaA8aS7/m/toxnj+7Gg/pX7z4K4Sj/blTEzXvQg+X1k0r/dofNcS4iSwsYLqzuf8Agm14pg0/9pSTTWYhtd0O8t1yf4owsyfXmMivv+Ff3HmH7xHNfl1+yb4nXwp+0t4J1XcFUa/DbOTxlJcx/wDswr9OH1BSg8ljhskgnpzx/Wunxoy6VLPqFZL44Wv5pmeQzvhHDs/wsAmJlEeMk8YPvX51ftm62Nc/aX8X3FsytHFeLbFgckmOBYjj6MCPwr758deNNL+H3hPUPG+uXKJbaXZyXZMndkHyxj/eYqPqR61+eXwv8IXfxr+L+m6TcSGa68Qa4j3jYyyiSQtIxHZQNzHNdHhJQlhPrmY1FaEYWu9tHzPX5K/qZZ0vauFDq3c/UX4QpJp/wn8L2U0jMYvDlguWOSf9Gj6100nzxcntVDTWs47eOC0QJGiKsSAEAIAAoHttAq+uDEcntX8+ZnVeJzKtXS+Kcpfe2z62mnGio+Ri30ZMuEwMZ5r82/28fh9N4I/aZ8RSSx7LXXtmq2/GAfOH7zB9nV8++a/S26gCyZI4NfMX/BSv4M3HjL4X23xK8PWLTah4ckb7UqJlnsZSAxwf7kgQ/R3r9W8H+II5ZxPHDVW1CtFwfrvF+ull6nkZvQdXCX6xPev2QPHy/E79nbwf4u8wNc/2NFZ3w7rNbAQNn67N3/AhXqUULOTk9+1fDv8AwSc+PtppV9qf7OfinUkQ3Nyb7wy8jcSTEYuLdSe5CrIq9chz3r7thEcuJFOQRwQK+W8ROH63D3FtelytQcnKOmlpa6el7Psb4LEwxWDjFatFKaBhOhQlCuNrJwRjpg9j6HrXwZ/wUW/Zag+Hmvf8Ln8B6THb6PrN4INXtraMKllfOMrJt6JHMQ3QBQ+ePmxX37NGEO9eormPi38OdN+Lfw5134baqFEOtac9uJG/5ZSkExyD/aWQIw+hr6DgDinE8OZtTqQdqcmlJX3j/Wx5ub4GGOoSTdmlo/M8u/4I2/tIXPjD4aX/AOzp4xvzJq3g4C40OSc/NLpMkg/djPJ8mRsY7LKlfdETq0OAMV+Jv7FHxMvfgr+1v4H8V6jO0QXWm0fWUAODDcZtpAR6CQo3/Aa/Z+wuZjGY2U5UlWz6g4P8q7PGjh2jlHE/1mhpCvFT8rve3l/wS+GcwljsBap8UXZ/LqaaMVJI9aswEgZFVrZ12jmrkcaFCAa/G6fvbn0Y5fm+9SlQBkCm+Xt+7QoBOPQ81pawCEk9WofleRt96keEgDaKa6MEwR2NaUk+YCBuF4G73qJ1BeMk5+epypHJFRzdVbtk13wTuD2OX8Zf8e5H1/rXkPisnDfQ16z41YGIgHkkYrybxcwBZSedp/nX1OUp80TysVflZ6L+zJGw8D6rMeh1Rf0jFd1G7FWBPcfzriP2ZI3XwJqMpHytqpwfpEuf512vkyOflHWXjn/azX7xw0msvh8zwarVz1DwFzd3Of8An9k/RyP6V0t2TtIH94iua8CMpuLgg/8AL9Mfw81q6S8yinI/iNfoOWJ/UoGMiIgRJlu9QOFclgOtOM3mAr/SoirEnivSWxA1+Fw3XNRsoYYNOXbuw5xTxt/hNVZgRP8ALjHGOlNLuerVI3DfjSYPWqWwDOp5pWEajJb8qCpY5HQ0hjCcimAqy7RhDx70Ex4yuc0wsB1NL1oAUknqaAT93PFJQrLkc96AHhQOgqSFmU4VCaYRjrx9afGzxncoz+NAFyGMSoecHHWrNrLGjCDdnjtVJXdz5ajPrVuOPGC0RJHSpluBehaMHB3ZHtU0Tx7iQzZx1qrESeXGPSpUOPmA+lSBPaRKlz50lyz/AOyfu1p/uv4c5rOtmYkPIuKuRfM4IoAsp90VYT/Uj61XQjGKsLxAM9jTW4E6dB9alHlY+bOcVEhBHB71KvIAFWB9i0UUVmAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+OgODmkeTnp2opjkE8GgBCcnNFBBAyRRkeooAY/3jSUrfepjEMNqvz7GgB1ACY5PPbikSTjG3OD6Ux0Y5l545oAWfoPrUVPjkDkhx+dPAj6gLQAiwHG5v5UpISPYo5zT8nGM8U393vG/P4UAS2bYQMR+FWFcMclRxVeFkHCsPzqfGcbR9cUAXbaUCIDZ1qeEZkAqtbyDYUxkjpViDOR60AXEQgjDdqvW5IwfYD+lVLWMu2WJ4HerSt5SbsZx2/GqjuBxNq2Na1lz/ABXUGf8Avo/4VRuZUN3kHoasQuTqGsOTjN3D/NqzmOZQevAP16V8njf96mXLWCPPP2hbgHUdHGcYWfofda5PSJgJ1bd0Nb/7QdzjV9JQjJFrKdvuXHNeYeIPi14B+GumnW/iD430vRLTPE+pXYj346hQTlj/ALoJr8Zz/BVMdm9SMIuT00SbPZoThCjG7PYdLvQlpz09c1xX7RiR6r8EvGOnsN32jwrfoo9T5DHH6fpXhnin/gq/+yr4XU2ug6h4h8QOw+Q6TooSPPs87oG/KvNPiN/wVz8C+JvD+oeHdH+CmsBbywmtxLe6xAhUvGybiqo3TdnH616HDvh5xRDMqWIWGkoqUW29NL+bKrY/CKm4813ZnjX/AATP1gaf+1T4PkDbRN9qgDZ67rdv6g1+p41NVjjkbksO9fjH8CPijc/A/wCIGifEux0tLyTQrvzY7OW4MaTgo6kF1GR9705xX0rN/wAFefiRdxrHpvwV0JVH3C+qXMmPxAFfp/iXwNnXE2b0q+FgtI2d3Y8PBZjQwtJwqM/RfTtUiAIBA4pz6qJGK7xxX5y2/wDwVg+Oz/uoPhx4Vi9/9JLfrIKo+Jv+CkX7V2vaTPb+Hp/D+lzyx7UnstGZmj9WBlkbnHtX5JiPBXiXFzt7ke75v8kdC4py6m7cz+4/SUXg678596Z9sPmZ3+2M18n/APBOD9oj49/GLTdb0H4s2t9q9rp0oks/Fc8KQ7s8fZiAAJGJ5BHQV9TAENh+o61+I8X8NYvhfNpYKvKMmtnF3T/X7z6zB4qni6KqRLUtwGBO6q00p2butDnjrUE820bQeK+VhG8jsbuUr+Tr9a5LxRcfOyZ6iuovCNjGQnoa5DxY0akKnUnqa9zLqTdZJehy4iXLFvsfmZ+2xrn9s/tE+NZvOLLDdw2aHPTy4o1x+YP519Of8E17tv8AhnedMABPFF2q9+CsR/rXxj+0Traal8Y/GWom4yJ/FV2R83XbIR/TH4V9F/sF/tA/C34f/A6/0rxz8Q9J0edNfmmSC+uwsjq0cfzCMfMRkdcdq/sDjPKMVX8O6GGw0HKVqWi323PicBVX9pzqT0TufZtvOGUsW/CotRvoGGN3evnTxV/wUk/Z78KK0Ok6vf6/MB8qaTYN5bH/AK6S7R+leN+Pv+CnHxI1uSS3+HXgOw0eJ8rHdanIbmUe4QbUB/Fq/Gsu8MeLsxkn7DkXeTt/wT3KuYYWkrtn2pqd/p0VrKbqZVQLudnbaowD1Y8YwTwa/Nr9oPStB8BfGrWF+HXiC3uLSO8+16dcadOJBbsx3+WCvRkfPfp3qDWfiX8dfjjqa6drPjDXdcuZzhNOsd2wZ7CCPC4/Suk1z9k/4r+DfhRdfEbxBoltZR2rIlxYO+64jiY7fNKoMKASOp79K/YuEOGKHBTl9ZxcXOorcifuv+tj53MsdLGOLpR+HW59r/sY/tKa/wDtGfCyTxR4n0b7Nf6fqBsrz7Op8qSRY1JdSe7ZyR2zjtXr32jfEWzjHrXxD/wS5+Jq6L4h1/4P310fJ1CAarpwb/nqmFmUexXa1faNqx+xNgnIJA9a/DfEHJKeUcU1oU4csJNSiuln29Hc+ry6v9Zwib3SsYviWdmDg92Hf3r8zP2qPOtfj/4zeQcnWZJNufVVNfpf4gOWbc3A+Y59Ac1+dX7buiLpP7Quuqzc3tvb3K56HdEFOfXlT+Nfc+DSis0rxvq4fk0zx8/g3Sj6nnHmz+CfHKOJmWXStRglRyOeCrqeK/VD/hIIr62ivYQQJoxIFA/v4IGPxr8sfiNOR4mtPEJfcb7RLG7kIPU+Ugb68qa+xv2l/wBqu++GPhrS9J8H2hk1vW9GguoLwqDHZwMgG8L/ABP2APAwT1Ar7rxLyLFcQ1sDSoR9737vZJXWv3HHl+Ip4SnKUtEYP/BQj47Q6hbwfAvw3qCyCKZLzXpI/u71+aK3PuCd7f8AAc9qt/8ABMj4Qz3Gvah8adUixFaRtp+mhxgySsAZWB9FUhc+rkV89/B/4c+MPjz8QY/DuiXAkvr1zPe3V3KCY03ZeZ2PJAJ6febtxmv0o+FngTw/8M/B2m+CfC1oI7LTrcRQjILMerM2OrM25j9a+d4yxmE4N4TWSYNr2lTd+T3bfn0KypVsfmPt6q0Wx3ltcl5N4Hb8vatWBiVwT2rG06YMoLr16Z9K14HQrncOnrX8y1ouEmfbJ8yuMmUucAZ/pVPU9FsNU0+40zVbOOe2u4HhuoJlyksTAqyMB1UqSMe+e1aqKh42jnvihoMNwenTBpYbE1cNWVSDs1s1umTOnCrHllsfmd+0p+zd4i/Zc+J63fh+e8TSJ7tbjwtrdtKRJAEO7yt46TxcAY6qAQTmvr39kH/goT4N+LVja+DfjFexaD4pRAgnkZUs9TI4BjbIWKQ4H7tyOfu56V674z+G/hH4leHL3wj408PQ31jfR4mjl6hhyrqRyrA9GXkV8Y/Hb/gmr8SvAk8+tfCBZPFOiySl2sWjC3tsDzt2dJgD0ZMHuVzX9IZTxLwv4k5TTy/PGqeKpq0amz9U+rfmfG4jC47JsS6uGTlF9D9CWu1mQ5XaSu5UY8kev0qlrniTQfCWg6h4t8S3YhsdJsnvLuQsAI4o/mZiT6YAHqSB3r8zvCH7TH7VvwBjj8I2fjXVrG3s/li0bxHZGaKAd1VJ13KPoRUHxc/a3/aC+O+iN4P8ceLoP7KmkRpdJ0mxW3inZfu78Es4B/hzjnpRg/B/HUsXCrCtTlRTTvzdE79Uclbi3DSoy5otStbbuc34DS88ffHrQrm1snSbWPHNrMtv3jM9+sm38Af0r9x7Npnlld2DBp3I/E//AKq/Nn/gm1+w74v1Tx7pvx++Kmg3OnaTo1yt1oGm3K+VLqNyAdsrITuWFC27JxvYKAMLk/pRooVpfLeMqoHy818/43Z1l+PzWhhcPNTdGNm1t0sjv4RoVaWFlVmrczvtYv2ucc+tX4HyMYqtDEsZ25J56mp4vu/jX4ZCLjufYlgjAB9aZs25OetORWcAbj+dBGPlNW3cCVj0+lMmGB+FOypXqM5psvT8K6KAED8fLUEx/dj2qeXrUE/3Pwrth8QPY5HxmcID7mvJ/GA+fd6g16x40+6wHqMV5N4y4LD0avqsq/iI8zE/Cz039mk4+Hd6vrqsn/otK7y2iBkVc/xg1w37NqqPhzctjrqsv4/LGK7/AEyIyXMYIPLr/MV+88P6ZdD5nzlf4jv/AAImJpzn/l7n/wDRzD+ldJe3IaVomjwF53ZrA8AomZGODm4mOfX969bd1FEJDKCdxNfoOW/7lBk1PiIA0T8xtnnmijPamSkjoTXcZjZIgo35pqttGMU6Tdt5z1pEAI5FaAML7n6d6UnDFPYUPtD4GOtKMYJPWgBMbQKRhkUqdBu/WklyD6DNAERG45z0pwGBijGBnGKME84xj9aAEZ9vGOtOUhVxj8aQhD94H2xSjGe+PegBH3SDDtxmpImCpgD9aTCHuKNy9sCgCzbTFX34q+ly7tweg9KzbckEEVfhYswJOfWpluBcj+cgE455NWE/dj92dxqtEQO9WbXaxHf6VIE8TtKCXGCKtQHaM1VjzuIfAHt1qyvBAFAFmI559qtD5rc+xqrACRwKtRf6nn15prcCWA5Gfepg205x6UyEKOwxmpTsz26VYH2JRRRWYBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH45P900ynAljgml2L6VdkAP8yADsKiEZIJyOKeWIyM0D7ppNWAiPBxTWj+bKH86e3U/WkqQEUbRiiTew2q2BjnNLRQBH5B/vCk8mQHhhipaKACkJXupNLShiOhoAdHGvUDr0qxE4XgjrUCk4BqZAMZoAu2zEjaigepNWIGAIf14qtZc81YgBYbV7NxQBeicgZB6irJO6BpP7oBNVIJEYiHHIHPNWyMWzKOhXBpx3A4KNh9r1dsdbqMfo5rP+4AcZ2oBj14q7Gx83VG7m8U/kr1SYtgleuOMeuK+UxeuLmXL+Gj4z/4Kx/tYXn7PD6Dongy2SXxJq+nTvYyzKHitohJsaRl/jJ/hB4POemK/OHRtA+NH7S/xKS3sRqPijxBfSbmeaXeYs8AlmO2JO2RtA6AV+o/7ff7H3ww/aJ8XaPrnjCfUrLUrTR5ILa6025UbYjLkKUYFTg56/nXP/sw/svfDn9mvQbvSfCEl3eXN/OJLu/1Ly2mdR0QeWBhR12+vOawo8W5Lw3hqs6FNSxD3b6M1p0KmItrofO3wu/4JBeKdXiS/+Lnxcs9McLmSy0GzM8g/2TM+1CfoDXqOnf8ABJ79mrToUj1TWfFeoPnDyyalHECT32xoBjPavqWzs1eP90hCjoNtSzWbrbsAvbqR0P8A+rNfAV/EvijFYjnnXatZ2Vrbry89jreDoRpt21Pxt8MeDtNh+LNv4M16FpNPTxYljcRFyrNCLoxldw5B2nrX6Qxf8E9f2QNNjY2nwdgciVwWn1W7YkZ46SgY718FfGbSJfA37S/i+0kQqdP8ZT3EbY4x9o8wfzr9ZILcahpkGoR52XNrFMoz/eQN/Iivt/FPPczwdHCVsPWlHnitna90edldKlOrUhKKdmeReH/2Lf2V7CTdD8D9CLAkZlSWT/0OQ112mfs2fADSJkn0z4QeF4XRgVZNEiyPpkGup07THa4wCeta66SzJzx74r+fM34ozmTtPETfb3n+jPoY4HBVHaVOP3Iq2lrYaeq2unWSQwKPkhhUKkZ7EKMAfSrCkcFu3oKf9h8hCAc59qRkCoPXFflGPq1KteU5Ntvq3d/ez26cYwpqMUkhHYHB9KoXe5SSCMdasvJgEN0xVW5IKZHpXLSimxt2M+9lby2+nauQ8TyFrwRsQArAkn8/6V112cByRwAa4fxlOXSS6U4AiZvyBr6TJoXxcbdzlxWtJ+jPyF+LU02q+PtYv4zxNrF0wX1JlbJp/gr4EfGP4h6OfEXgz4fanqdkJ2hNzaQgp5i9VySKh11he6w0pyfMvpm/8iE190/8E/tGWb9mizuFVi02q3jl2Az/AK3A5+gr+3eJ+IanCuQwxFOCk0oRSe3XtqfDYJPE1uR7nzT8Mf8Agn/8f/GOqJbeJdEHhu0Zf3l7fsjFR1/1cblmP5V9FfDv/gnV8E/C8KP4xu9S8RXCgFzc3BggYjt5ceCR9WNfRFjpLLa7E4AA4DH/APVV220ZpBuJ/GvwXPPFTiXM4OMKvs49oXX4v9D3qWWUoyvLU5Twx8PvCHgLTls/BHg3TtKh27SlnaIob68Zb8TVDxt4Vj8Y+GtU8LX4zFqNlNayB+4kQ5b6hsMPpXoc2mBYAgOcd6x77TmafCLyXHHrXwNLO8XUxUcRUm5TTTu3fZnfPB01T5IxSufm/wDBXxVefBj476D4lvQYn0/XPsmor/djJMMy49ACx/4CK/T+LZFbGJeRkkHPYivza/bE8Dt4N+PPiOxgwiXd1HqMMuNuBOuWI9g6txX3z8DvFJ8afCPw14kZiWvdFt3lycneECtk/UGv1TxWw/1zLMFmceqs/uTX6nj5DVcKlWhLdMveIIy0vK5BFfE3/BSPwfJbeMdA8ZrFhLiwls5JAOrxkyKD+DH8q+6NVs98eccg968I/bN+E7fEX4Pah9mhZ77Sv9PsVQfMxjGZB/3xu/KvlPDnNoZXxHRnU0jL3X89juzelzYVtn596ncnVbfT4LhGP2K1a1B/2PMdl/LeR9AK+z7z9n3w5+0x8B/B/iQ3JstaTw5bx2moqhZSFXBWRB99Qy9uRn6ivjFYy1yAmQrEEAjn2r9Ev2Ko3vv2avCpJ3LFZSxgHsRPIf61+4eI+Y4jK8to4zBz5ZQm0vR7p+p81l1KOLqunPax8dfEX9nP43/BC/8A7dvtGu/LtpA0OuaO7mND6h0w0Z6dQOnaur+GX7ff7RvgR47fU9ZtvEVqmA9vrlsWcL7Sptf8W3V98CwyFVkByvJIyT+J5/DpXDeNv2Wvgb8QmaXxL8O7Jp2JJu7RDBNk9y0ZGfxBr4Ch4m5VmtNU86wvOl9pJP8A4b5HoSyrE0nzUKlvVnn/AMPf+Cn/AMMtS8qHx/4N1TRpGbD3Nmwu4B05xhXH5N9TX0D8Mf2h/g18U1RPA3xF0u+kZcm2FyIp19jFJtf/AMdr5k8W/wDBMTwzqMjXPw9+Id5prnJWDVYvtETe29ArD8c15P4y/YV/aK8HXH2m38FJrsMDcT+H7oTSJ/tbDtkX8BXLU4V8MuJFL6jivY1H9m7X4S0+UfkJ5lnuB0qU+eK7I/TWC7to+GZiSeF2EE/gcVZ+0WL3iWSXEZnkiMkcG8eYwGNxC9cAMCT0wR61+Xfhf41/tG/CCePQrb4g+K9HMTYFhqc0pCn0C3C9PwxVzxXrX7QPxr8a6H4l8Q/EXWNT1HTmWPRPsUwha0aRwzMggUf3QScc7RnpXkLwXhGrKVbHRVFJvmtrdLRNeZdDi6lVqqnKk09tT9R7K13NgjkKDj0/zz+VaQsz5YYpnik0W3laztvtMxmlFsgeduDJxjeR/tEFucHmt6CwR1CupIr8KpzjQxc4t/C2vuPrHB1KSl3MDVPDGi+LVFn4l8P2Gpx43CLULCOdfydT/On+FPgb8LPDeprrehfCvw5Y3AyYprXQrdHVsfeyEzXXWGnhGARBjGOlalnZxwD7+729K9+nnmLhRlCNWdn05pW+65isFh5K8oL7h1jFILmKe43NgYwx6k4ya6C1MMxUhcY9KoWcaK4KruyRx6Vr28A2ALFt56148m6sm5O/qdCjFbFhYwAu08D1qWKM7Bz1pojcDrU8cRVMnt0plDoj5ZyaRzlt3tRQ3Q/SmlcByA/eHahgZB0x9aWI4U00swJ5rroJAQy9fxqC5YKmD6VadFIyRVa7RdvTtXbBLmJk7ROS8YIZEZwehBrybxehkkkwejd69b8XcRso6bRXkviwkM5B6nJr6rKkvaI8zEt8jPTv2cAx+GsrY4OrTD9I69F0ZQb2CPcPnlQD2+YVwH7NkZPwrLjvq9xn8Ald5pcZXUrEHoZo8+/zCv3jIFbLYfM+fkuadmd/4BJFqJApIeWQj8ZGrdnZZGJVvukA8d/SsPwDJHFYxIy92PX/AG2rcu4ruSeOVb0rGhbdb4++pHBPpg19/lv+4QMpu8iuy7BuJpsiFuhqXAcEN61FMxQ/L6V3GbbuNkR+hamg7TtI/Gpgocbm9KhmHzbe1aAm2JJt3AikpyooXGOtDgDoKChrcjFIUUjqT9aXY55Bo2svLGgBoRs/McihmGNopx4XNIqK2NxxnvQBGZHRhtxg9c0u7ecgUOozgrx2NAGOFoAPxp3lnsRTTE56mlDtGNpTPvQBPbuCRj86v2+FAO4c1mygpErR8E9at2STyqCW6e1KyYGjCpLZxxmrdsyo4CqTVS3k2YjftwasRxNM42EjHIxUPcC7Dt+8wPWpl5G70quivEuwn86sR/cNUlcCzZygN9049atD5bduepOKrWiIV5bGas7f3flg5GOKdkBLBu4RjmpthNQRH5hzyKlSRiMk96YH2RRRRWYBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH450U3efQUbz6CtAHN0P0pg+6aC5IxSFiqnFJq4DG6n60lGc8n1oqbMAooopANkcoARTPOanT9B9aioAf5zVJCxfcT6VBUkLOoO1c5oAkiZyNuOPrVyEKygMelVoEGB16VYiXccZxj0oAvCVYQsBj4I61PG+CpXqCKqI37ze54HSrMXLBh0IoAtQQq0+9D8x5OavQqVUlh/CapQjJBBIPqKtxSE227H8Jpp2YHAQsC+o4/wCfj/2SSqcQ/eIueSKuWS+ZHqMxPP2xlx9I3qtYoJryJSf4a+VxT/2uZb+BHm37QNtu8TacoHXTv/ZzXN6JpiQ3CSKp/AV2vxytg/iuzUj7mnJj8WY1i6Nas0gEa9COBX4zndR/X6l+56dOLcYm1p2mHy96r096W90xmiLIO2GHStextXSDayjmp76yBtcqvUV8n7WUKia2uel0Pyj/AOCi/g+Hwz+1nr5tYcJqtha34wuMs8OH/VBX6HfBHVYvE/wU8I+JBIHa88NWcjlem7ylUj/x2vjv/grR4TFl8avCniby9q6h4cmtnf1aK4Jx9dsmPyr6Y/YL1weJP2RfCy+bvk01biykIH9yVsA/QHFfrvGr+vcAZdi+2n6fofO4F+yzetF7PVHptqoW4wPWtMdfwrPt49txufoea0B1/Cv59zXW59VQ3IZyAeT3qpL1FWrrpn0qoWLSBP1r4bEfFY9FJ2IJun4VVueQB69KnuZGAIwPSq0jF1DHtSpaaMUou1zOvwGhlB7jiuG8YI62kxUdIH7/AOya7m/OIHPsa43xPG0kLKFzvRl/Erj+tfSZF/vkF3a/Q4cY/wBzfyZ+P8wCXfmntcSZ/wC+jX6G/sEaeLP9l3w1GVwZmupunrOw/wDZRX5+a/p76br15plz8pt9RnhfI6FZGBr9Kv2PfD76R+zX4Ms5lxINGErDH/PR3f8AqK/qbxcxUFwxTinpKa/9Jv8AkfHZHCUsZNLoel6fABbEY75q5FbYHIqSxtMpsxx61bFsQMBa/lac4qbPtYqyKstuCuB6Vl6tbEc+g5NdAIiTgp2rM1WFXYxlM7gciqoziqlypRbsfC//AAUj0X7J8WtH1uKMAaj4edHb1eGYkH/x8V73/wAE+tZm1j9mHQoppizWdzd2oY9cLMzAfqK8l/4Khxx2a+Dbn5SzHUYwQeSAIT+Wa9H/AOCZUb3P7O5SRjtTxBdFPxCHH61+552/rfhRhZz+y4pet5L9UfJYRex4hqwXU99lg8xChrD1fQI7lDHJGpznlhkDj+XJB+tdUYScjb3qN7BZAQyHmvxGli50ZqcXZrU+qlD2y1Pz9/aN/Yd+Jei+OLrxJ8L/AA3Lq2kXrG5W2tdvm2jkktFtz865JKkc44PSvqD9j3wJ4r8B/s/6J4d8YaFNp97FJcPJbXAAZA8pZcgHg7SDj3r19dJhD7niB6YPOR+NTRadHlhFFty2Tk5r7bPPEPMc9yCGWYiKfK4vm6vlTS/BnmYbJadDEyqp6Pp2KttZOV5XtTxpZb+A8cjArVt7YIMFBx61KIzIdpavzypiJR2PRVGOyMdNPkUcwkenGKmgsXUgmMjHStqGxQqdy5x6mpo7GMqD5dZPFzjuHs2nYyv7MttRUR3tlDcoeDHcQhwfwPFbHhzwtpWis32TSrS23cn7HaLF+qAVa06zRWHyA1s2VgpQuAc1zYjNcTyckZuz6M1hhaV+bl1LegQMpzGNi5zuz1/Pn9a6WytnedT5vU9qzNFs1ZQ0igsPSujsbRAolxjb2FeVRjzu7Oq3ZE1paOWGZM/7JrRtLNS2TGF45PrTbOG3ZBN/F24q9bIZCdo4A5NenTWlmYvcW0tS0gAG3bxn1rQhj8vH7zP4VGUZHVQmQGHP4Zq2tv8ALvUk1vGHYCWP7g+lLvc8EU4RbIxnPSnRwLJF5oYj2NWoSuBHSqpyDintCFGcmheg+laJNAIzhBk0wsGORUqqG4NJJGq8iumEW4gV3Rtp4qG4RtnTtVmTjiq90xVBx1B/QV1R3Jm7ROS8X8Ic9q8j8XA5de4IFeueMuIz7jmvIvFchZmbH3jn9a+qyvSaPLxPw2PWf2cEK/CqNx31O5P6r/hXf2zbdR09x/z8J/6EBXC/s5kR/Ci3UDO7UrnOf94V3jkJq+mxgAZmQn/voGv3jJItZZBeT/FHgz0qanc+CYgdOgHcx5/8eat2XAmIB7Vg+BN0tnDnjFspGPfJrZmB80nceuK/QMvTWCp37HNUd5ElFMjGD1PTvSyM6j5QK71sQMnRiMqMD+6KgBBOBU6RyMN2eO4NNnijX7gxxzTHHciPBwaKaXKnb19zRvPoKCx1I/T8aTefQUhYkYNACUUUcjpQA1wTjFBRkOWFLxu/CnScnBoAbvwNwprMXbOOakDADG0U5PL5bo/agBU2tGokHIPSp4bkq5KKAMetQZIGcZq5biIpkxAjsTQBPaMZMN+Jq3ExSQH86qx4UjaMewq3CocgmgC7bFFXIPGat29uHXORVNEEahQangLoQgcnPrQBaiURPn86srKjjap7VVU5FSxcMMetAFg8gexp8c6f6vDZH+zTKfHMI12ggUAfZtFFFZgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfjfRRRWgBRRRQAxlOeBSZHrUlN8tewxQ9gG0jMFGSacw2nGaimHzFfbNZgNkk3gDFNoooAKlt+nPrUVSwfcP1oAk+YH5c/hViHfnvUUY3D8KlUnIAOKALShjGeDVpBlFAbA9jVSMvg+3tVyDCqqkZoAt2oIBy2eOOasAH7OVX+70qGAJxg4zVhR8h+lNK7A4Cx3fYb8jPN7IR7/I1Jo6q11GcDpwcVJp426dcn1uX/wDQMVJ4UgE91GrDPz4x+FfKYpf7XM0l/DRxHxmgDeLbdSBn+z4h+rVmaBYLHJuLDqOSa7L4uaIZPGluTbnBsk5/76qro/h4kqBbk8DoK/Hc8oylj5nrUPgiWra2jcAKoPpU15YlrYrtwfSti18PtGo82IqPXFWL/Q5BARFGee5r5OeGnzWO7oj4J/4K8+D2PgjwX4v+zkmy1+e0mJH8EsG8fmUrQ/4JWeJBqHwD1rwwXDPp3iEugBydssat/MH9a9O/4KYfDq+8Ufssa7e+QXbQrm21NSByiRuA+P8AgMh/A18+/wDBJ7X4LHx94p+Hz4B1DSlvoFJ+88D7WA/4AwP4V+uU0808LqtJK8qUl9ydz56qvYZypPaSPsG7XEmUXAzzgVZhVjHkg9Kn1Cy2uWUcduKZbDdGR/s1/PmOj7alzI+pouz1Ks45wR+dUsEXHSr9z1z71TxmbHqK+IxcOSqj0otOJRuwcNgVAeIwD1xVq5XBJzVOZ8Mox3NZR3CWxSu0LIw259eKwNT0/KEmIOcghT7EH+mPxrpJgcOR/exWddxZBJXNejhq86TU1umc84KUeVn5M/tL+BdS8L/H3xZotvo1xGjeJppLBDE37xJG3jbx83XtX6VfCrR4tH+HWh6PbrtS00i2iQcggCJQRj6j9a6XVPDmlaq8F7qWl21zJbyBrc3FsshhYdHUtkhh6irKWpYgu2Wxy56t7mv1Pi/jqPEmS4bD8jhKna+t72io3/A8bL8ulgsTUm9mOtVCgAY6dangDHqCeO9LBEq/LViOABcg1+YSqdj2ErkflAqSODWXqVizS7gSOe1a5GDiorqBZBkdadKb5iz4L/4Km6fqTeOvCEUFnILePSrpzIGJUsZFyPQHGPzr2D/gmlZ3Fn+zfCHjciTX7tg2OCMp/gfyNex/En4GfDz4v2cVn8QPD8N/9mRltZHZkeDdgkqykEZwPyq98OPhh4Y+FXhuHwd4O08WunW8rPFbpK5G5jliSxJJJJ796/VMx42y3GcD0smhFqpBpvto7/nb8T56GXYiGcvEv4Wb6JHIFwB7nFTC3hxyFqS3s137cjGKm+xJ/eWvyedR3Vux9DCOhW8iHplaVLVTzGo/AVYNmijO8flT0REGEbPrxUc8mWoq5X+zyDnmnRwgAEEA/WrGM8etPW1UHJAqZSaF7NRFt1GzGQealjQlsdBSRRBeR61PAhLcjisZ1Gy+VNFmyg+cHtW5p0BJBAzg5IrOsolOMLmuh0S0MzAMuAO+K4WnVqKJWkUamh2bTEDycAnrXR2OkiJshQ2Pak8OaNNMBJEx2jrxXVad4VmknVrd25Hzbq+lwuWy5Voc8qqbMuOGCJlEMBKn/Z71cWyTym81drHAUAYNdH/wjz2sXli2DYweB0zUsnh+QqkskO7PoK7P7Pkuhn7RmAbFlCLGTnBJDelSx27BPmCge1a8mnGf/VxbSOCc5xUAtipMYGcHBNRPCuBcW2Z8kJLAbzjvzTiQZAqngdhVlrZFYgj86i8oISxI56DNR7C2pRDJkOc5x2qP5t3fGannXgPmoiMHFVyxAVPvUT9Vx+NKnX8KSYZwfSrikkBDL1/Gq93jy/5VYl6/jUFypKbuw6mtI7kVPgOQ8XjMBbfzjjJ/OvJPFiAkgcV6/wCLlH2XCjJCkfWvI/FsbBju4wcV9VlnR+Z5WKdj2H9nSFE+EtkWIO+/ujk/9dMV32o26wa7pUTKM5g6j/aFcL+znEzfCWx3Dhbu5/H97Xonia1kg8UaVv6tFA6/j0/lX71krtlsfRfkeFV/iHU+CoxBaRpnn7DFgZ77a15dp9M1i+CnZ9Pt2fO77HGef9wH+tbGWJIYdDX6BgP9wpvyOaW4Q7txznpTy6jgsPYUkZxkeoqORSZcgdK7VsSPJY/OWI9s1DM5Zto4461LJJn92UOfrUMilW5PWmOO43aM4xmgqB1X9KUAL82fwoZt3agsaVGOAKb5ZXnJNPJwM00yY/hoATB9DRg+ho87/YNAlycbDQAhGDyKGRiC249PWnkbxnGCOlIjbvkP50AJG6gZOD9aRpULYCAEdGAp7RxonODSKiMhbZyO3rQA4K7KGQZLdj2q9ZNGsITblu4IqtbGQDcIzxVyBYlcsFz60ATKVIBwBU8OcDHrVYfe/GrUJ2rnFAFyNgSMt+tTRnD5HOKqW53tj3qzFEpdS7HK/dK8D8R3oAtpIrDtU0TLkciqygDoc1LF8v40AWyyjqw/Oj5W5GDUefNIA4wKljiCpgyCgD7QooorMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8b6KKK0AKKKKACiigkDk0ADKCm7HNRFFY5I7U5yCeKSiyAilRVA2imVLP0H1qKiyAKlt+VOaiqSJgqEn1osgJwSqZU9qliJJ5qup+XPrViHr+NS0BdtfmfYeh61ag+9j0FUY+HyfWrkTqWzmpAt26gnJ9asxuQCD0GRVRWXKnPSp5ZB5LFT1U4/KrjswOJspI/7LuDj/lvKfxCrj+dXvAVm93qtrHEQA7ZOfWs3S1C6NNIf4rib/0FK6j4RadHfeJbC0kBxISDjr6V8hibuvPuaP4EaXjfwQdZ8WB5YHjt4tNjJlAy2ec8e9O0L4c3sUcLmykLbMcjgjt+NfQfh/4MP4g1eLUZNgVIY1JK8MRnPH06+tdnZ/AbQ7MBJpt4BJ2qOK+Kx2VVMTXlJLc66eISW581r4DnmjzOgQgelRzeDo4YGNxmPjowzn6V9O3nwN0p7dhZqqnjGFrmPEXwXv7aAi3svOyOeK+exeRVqSu0dtDEKW7Pkb4t/DSw8ceDtV8GalF/ouq2E9nMGXJAkQpn6DIP4V+Un7N9/rv7Of7Uelf8JTGbZtM1x9J1kSDAWN2MEmfoNrfhX7n+Lfh5cpHKk1lJERgHjp9OK/Pn/gpH/wAE7PGPxK8Qy/Fv4LeH2v7/AFaOJdb0uGdUmW5TC/aUDFQytGqhgOdyZ719HwfjKeBVbL8S7RrLrsnscuOoe3aqJ6o9Zv4HRVUrjEeTx36f/XrOiidOFPUVwP7FmpftFz/DW70D9o3RdcgvNHv2h03Vtbs0inubUxjaGHVmViRuxyoHJr0iWDZyCpwOy4r8d4iy3+ysdUw6kpJN2a2aPXoS54pmbdRbUJI5zxVGT5Zsr6Vp3yNjp2rMlRtwGPevzHNLe20PVh8KKtwAeveqN2AsigCr0/BxVO7UmRSBXFT2KK/VmB9c1FLbrJxt+tTbG3McdelIQR1rpg7RAoyWgBIx06VH9m9quPEhYsc9aRYkdtoBrTmfczstkVRGEPTmrAUAYAqQ2wBxj9aQxOBnFK5UURmAMcgUjW2RnHSpkRcfODml2xjoDTVVx2NLKxVNuT1p6W3yjip6crADBNL2t9Lk2uQoi56U/YvpUh+f5VPNJ5L+1Q5a7lJJIeIIsA7P1pfJjHRacOBRS5vMeg3yox/D+tOo60uxvSplLzHoxU+6PrVu2VSCCOlUyjEbQOau2aMq4I7VlN66E63NXS4tx+Ud67DwrYySyJ5iYRsKGX19T6Vzfh+MvIoxwcV6V4Gsx9qiZoTII+QjD5WJ7H/GuvKcLLE4i7RNRrlPRPhr8PWv7ISxRE7x+6Iyc/0r0Kx+FmrQqI3sTyvDBcc12f7MXgOzmjWa5O6NYgyRxr8qHuMH69a92HgqwuwkQsgpXv04r9vyfhp4qgppfgeBVxSp1Gj5duPADxszQW9xnYoO4Dpt68+nOfwrKk8JSpiFfOZFVWycAknOc9h2xivqPxJ8L9OuWY8LzkADrXBeIfhl9gieaGNGCBj9z5gccDP4mqxXDU4vRaFwxitqeEXHh0W0MYlXAd/3mBgkYz+FZ0uhmXFxBE7gdcDtmvT9f8JNGrQ2kWEjGP3qfMB2wa5jUtFHnMdp4+VQh5+px718tictdKbTOyOI5locNeWAjumiO3IOBufA9f5VTuLJfL+1AqQegSuj1SxVZYxhtyR8ZTb39axriGYQBY0OBIRkDt615Fehy6F891uZflO672Hyk8Co5YiOVHWr12hZeAOOpzVR2G4qeSRxmuH2aiLml3IkDKfmAolIx0HSnkFRk1HIQVyPenYOaXcbcRoASF/WqdwxyAOmelW5piQAx6A1QvXK27beoFXBe8Jyb6nM+Nzsgm29uleTeJYHkZ2ZiRkkV6r42LSRMx6lTXl/igiNSW/vH+VfXZXGNlp1OTEpHtP7PcSx/B7TlA6yTs31MjE16f8AFKx/s3xz4dtguN2jWEre5aJX/mTXmXwFRB8INMkH8XnbvwkavYvj3ZvZ/Ezw3DKAGHhnS84OR/x7r/jX7llH/IsXp+h4NX4/mM8GgG1h4/5cYP1iXNbEnIBNY/gobrWHHexg/wDRS1sSK5G0RseOwr9BwWmCpryOWXxEKSP5mM9qnHIqKNGyflI+oqTBCY9q61sSRnzvNcZ6dOBUUoYN8x7VI07CDa3UioRuKgt6UyobaibecqOaUh1lCyLgEUHeqF1UnA6AZNOjT7TlGZDxz6igobwep+tIAoPy8+9OEgRCiZyeu71piLHGS/l4LDk4oAdTVcq/J4pUZhu2jrTQJQpDLxQA6SdeKYCDyvenR96cDk7RyfagCJumamhiL7W9qjZGL8Doamhm8pNpjBoAsQO4YR8YK8jFTRKFBCiqkcgYgpHg1bgDt19KAJlUYBxViAArzTCrBMkdqnhGYs0ATQ+VHGXVcuOgqaAl/vHNVoDubAq2iog2p60ASxgDOKmhIyCwyAeajjRXXntQd4+ROh4oAspKokyBxUxCv82P1qtbBQT5lWY9u35elAH2jRRRWYBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH430UUVoAUUUUAFI/3TSvwgIqPJ9aACmSuQSg9KViRnB/hqEMxGSSeKAAknqaKKKACnr/qz9TTKkgYD5SoPPcUAPj5iBqzD1/GoFxuxjj0qRHKngZzQBcXqPrViMlQCPaq0DbiCw79KtoysmAo/KpaAsREsADU14PK055VPKqcflVe3YZwT3qe6ObCdWOcIxwf900r8v5AcVprlvDjMR0uJv8A0GOvQP2f7F7rxzpkMa9zg45zuNcBpIH/AAiSZHzGeXPqfuA167+zDZpc/EXSIVjHMRbIHfJr5SprjZlOV0kfavhTw08emQwiELmIEkDn61rQaKDF908D1rR0iMRWQVf7nyn2xUpifyk25BxyBWnsKZJmrp6/daPiqt7o/mfKqgjB4atpodg3cnHtUDRea3+FY1cPTk7NGtOTicD4t+H+l6tbtFNGA2OSK8G+KPw7TRriS2SKR4GjLSBzhWXPINfV2oaT5iFmHUcGvFvjVo/k3jSo2AITnjt3r4zP8DTo0nUjprY76DcmfIPi/SVjZ42crIshbzCv/s3U5AGPbFcDqtptYsGb6Zr2X4gadBvng8syIG3A7cDI968q8S/ZhMwgjZeOh7c1+K5xJyrNt3PXpRUbHK3iHkNWXNxMB7Vs6gMpkD1rGm/1nvtr88zOH7656UXaKKVzw2aq3XDrViTcVJbPXvUF1jI+nFefT7FJ3IKY/X8KfTH6/hW0dhkT96SD/WilbqaVRgEqOfat2rK5K1kPbqfrSP8AdNMBbuT1p9v8xYNz9azbuapWGUqAMwBqbYn90flSqq7h8o6+lS3YG+gzyE9TTlRVGMfnUmB6CjA9BWadwSsMwB0FFPwPQUYHoKG7DE2D1NGwepp1OQA5yKXMieUYEAOaWn4HoKMD0FJu40rCIoPzVcsgWZVA61XjAyBjvV20G2Zdq854A+tZz01GdJ4at2DggDCtivWfhXbSXOoworph224NeYeFfn4cADcd1es/C61QXMDwKPl3NuA6cjmvquGafNC77nHXk+V2PtH9nyw+x2bFdm1guAo5PrXtVrahYVYrkse9eJ/s93WIfKYEsGHPpwK9ztJt0IJUHnvX9ScM0acsFFJbfqfKVm3UZTutPW4dkdcj+H2rE1Xw+kokil2gEdcda6vanyttGSeTiq1/brMxwgPHHFexiMJTnBpoxjNp3PHfH3gxWDmKQYb+FF5ryzxH4bubNXMVru2kMoHUj3NfSmsackmVmXIGeMV5V4/8NII1D2hffnYEOAeehr86zrKoxbkonp0Kjatc8P1PTlkYxMyAhdpU54Oc9a5/VIwmHIO5ztAC4G2vRNXsvs5ZAGwyDarHODnt6fU1xniSMmKPGV27txUZxzX53j8PGDPQhK5yeo2zRKzr0J5rMeNmm9QBxW5eRbt480kEpxtrKli+b5ZD07L714Famr6GnMiHDY+YVDMAOBVqSMbNwkz857VVnO7nGOK5r20NFJWK8/f8arTQedGy568VdlQOcAVUmcW5Azxnmrg7yJOY8YoyQOdv3RivJfFgaSaSPsrcflXrXjG7X7PsYDk4JNeUeJiDcOQfqffmvrMsdkvU5cTse2/AxfK+DmkAd1uCf+/r17f+0zGsfxa0FO6+GdLx/wB+F/wrxX4EKD8INE3rnKy5z/11evcP2sFEfxz0iJB8o8O2AGB0xb1+6ZOr5an5foeBV/iGR4G5tLc/9OMH/opK27kB4gYtg4wwOeaxvBykW4CjpaQAY7fukrXlhcqCxOPrX3+EVsJT9Dml8RBbII3YCDae5znNTEptOTzimI5Rtgjz6nFLKilixbHtXWtiSCRWdD5YyAKc8Kqypk/dFIHAyFbp1AoDtL82DxxTNAxtBVSR2zTBGIwTGcZ6inkHqRTZMggHigCPbkbgcZ6Y7VIwKgFm3E9Saa6BQp3YyOcU9gpUENnigBFVnyQOgpomlJ2Mox9KdAxBYFvpzSeVLuJJBHYYoACc9hTkwo3KOaaVZeCvXvTlQqNrZ/GgCPa4LORxUkbfIOBSvGPLA8z60iIQNoyfSgC1G0QwOB7mrMXlkZV1/OqSQErkgn2NTxJtGCuPwoAuCcHCnFTRIz8r171WRAWGBxnrVq2l2AqOfegCZYyR8oqcEKcmoYpRnk456VNEVZeSD9aAJoJMg7aeOWz71HG6oCFUU9ZckDaOtAEydfwqRZWQYAFRIRnqOlPoA+2KKKKzAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/G+iiitACiiigAk/wBWKjqST/Vio6AGv3/3ahXoPpUzg88fw1CAQBkdqACijB9KKACnRsA2Cabg+lAiZzuU9KALKcsKkT7wqOEHYCevQ1KiFjle1AEuWQ78/QVbtywQuTkAVUjBb5ZDmrUbfLtB4OM0PYCxAcsHx1qS/lMdlcEkn9038qbaoCQCOAOKbqxI025I7Qv/ACNZ2TA5rR9p8PBSOA8mPxZBXtv7Idobn4qaUoThbUN+prxTR1X/AIRkORyZH59vMSvf/wBi22V/itYBQBtsQRz7E18lNv6zJ+ZaSbR9t28XlRImOiVKq7hnNOEbO3LdFAFPSA4+8OtdpBH5Qb5SetNSxCH7w/KrAhK/NnpRUSSbLjsUr2IyROgGNnf1rxb4xOTb3CvCSxXaD7bhXuU6L5UnHVDXi3xftpGmeQBcDjD9MV81xLBPASXmjpw05OokfL/xH08wzvA0koRWJZQOCa8i8URyS3JEoUZHAC17T8SEmmiwFGVJyFPUbuTXjniclXkC9mIFfgOcw5ZSZ79K7scdqYCggeprDmTMgbNbusDAO2sSf7341+Z5jWbrWZ6sIpwVzOnGFZfQ1VuTlk+lWrjqR71VuAM/QcVy09rjcUtiGmP1/Cn0yQgHk9q2jsIZKuwbs5zTkQhC+etJc/cH0FPUjycZrZt2BJXIW6n61JCuxjz1qNup+tSoDuHBrFuxoSKu4ZzShMHOaVAQORS1m27isgooopR3GBz2FJlv7v605Ov4U+iW4EWW/u/rToyTnIxT6KQChcruzSU8fcpuD6GgB0K73Az0q7bIRLkHpzVS2BD8irsGRIT7VnVegLc6nwgxc/P0PavZfhZEVuYEToxOCf4STjJ9q8b8Hgeaq44wK9t+FEbOYpQRgyADd04OefbNfX8NaQVu5x4lJRZ9ZfAPzEZnyQuRgEfT9eP1r3WzL+SAG6AGvEvgNEpsYXYZLElsnnr3r260GIn46Div6l4YVsIvkz5St/EZZWQMg46Uj/N83bpSKDt4HalPC8+tfRTirM5L3djPu4UmGQoyO5rg/G2lme3mjUAbTlSR0r0CZQI2OOcVy/iSHzIZUA+8CBXz+aUlVotPsdVBtM8I8Z2dvAxUuxQJtCAY59cjmuA1qxti3lBWO7LdMdf8K9X8WWsqxTRNApESMwkPXPYV5nrayl/Nluwm35SAP4uuK/Hs1w0VJns0W7HIalaKkhYDBUghcdcViXCkS5ZOQePrXRasMuzySkMFJGB71iXGQzPMvzE8L618niKfIjcy3lZwQyj73UGq8qbmC561ZmZW3DywhB+6PT1qtMzA7geRnFeW9y1sNkXywGJzms+/XzI/MzjLdKvStuT52wB3xWfqEojjCq2RupxdpDOT8dKEhIDchxXlHiKRhM5bj5vX2r1Txy2QW7eYDXlPixgRlOpJJ5r6vLZPT1OTF3Ubo9/+CDqnwm0RQP8AllI3/kVq9v8A2uAI/j7ZKT/q9Asxj/thXhvwRGPhJoOOpgfP/f1q9y/bG+T9oQFeNuhW2PbFua/ecl/5FS9DwJu87mZ4LQiz3k8i3iz/AN8JW2VGDG/PPWsjwcoFj06wqPyVa1y6twRyevNff4T/AHOn6HPP4iNUiVz3/CmyorAhUpr7RIQD+tPjmUDaa6lsSQPawYTyyQzH5gaSTbESqr061JiMN5zHABzTZkWUGRCSDTNBsUmWzt/A02KYO5NwoGD8pp0SRkbW9OxpqRohDBHIBoAV2hujiJeO9OTEb+UI8qenNKy2xTKx4z701EEJDRq2f9o0AJIFjm2jYOP4lzUhlYrt3cUCSZpM7ttIY5SSVOT6UAMkjLxCTPfpSvIzERgCldZUtcOuDniiWEhwy+lADJY2RMmpIIi4Ug9hTTA7oH38dwas26KsY/xoAciFB605Qzfw/rSqcMKmTGKAEgfBAK96sIFI3KuKhiVS/I71PwgAA6mgB8cbSZx2qwibBjNRwEx/KWHNTbHXktQA5BhS3vUgXA3ZqNM4x2qWN0YFSPagB6DvUyAbMlsHsPWoUbBx61KIHOG3dOnNAH2zRRRWYBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH430UUVoAUUUUAFI/3TS0FgoyaAIfPIbywDjvTgsbcv+FBCFtwFI+RwvegCOd+QgNEcTZ3cYNJcRGL5iT+NSx/cH0oAU8qQOpFMRzAcHuO1KIwH35P0oMayOdxPC9qAJEcOAR6VIh5x61CnyDAqUFV5JoAmAIXFSwKV/LtUSNuUN61YtgCefQUPYC7BKcKFzwKbqjgaTcY7W7/ypYwARj2qPVD/AMSa7b0t3/lULdeouqOb0ks3hK3DD/np/wCjBX0J+xKjH4q2WB00xB+mK+ftF48LQLj+I/q9fQ37E8iD4o25xymnKB+Wa+Rl/vMv8TOn7J9xIDkn2FSR8j8aZAyyZGeiinAlMgetdjaSOccBhSvtUY+8afvPoKbjnPrWUmmyk0kRXrgWxHJ9l4xXjHxjuQYZlZsbY2ZgVycCvZtTQNakNzwa8P8Ai5IyJNIOx2gduTjJr5ziOSWD1N8O/fPnL4hjEk5BGcNye+PSvG/E/X/gZ/lXr3j64V5LlXxxKU80n93knPBryHxRlZCvHBJr+fM9kpTlY+nw+yOO1rq/+9WHcAtG6juTW3rZIkZfXmsKeRgp4H36/L8d/HR6cfhKM4w34f1qrN0Y+lWLhzu6Dp/WoHUMhJ75zRT2FPVFQEAgmkm5OfSpDGu7GTxmo5uPzrdKyMXFsimYSAKvoKcI2RAx7nimqg4NPLkqFPQVbasbJNCL1H1qyn3hVZeo+tWU+8KzkEh9AGTg0UL1H1rJ7lLYXyU96PJT3p9FIBqxqpyKdRRQAE4oUFugx9acqDg09FBzQAiDGB71JSBADmmtIytgAdahu4E0XX8atQdRVSA5fHtmr1vGCCRnI6VlU1VkNbnR+E85DL1LECvbvhRdxebFbhd2GVTxnGevA9K8Q8KlkA46civX/hfdRxX6BxkEEEHnk46fnX2XDclJRscWJdos+yPgPJHHbeXEcgck9P4s9Ote32jb7XGeSFrwn9ne6juLBoThcKjYTp6f0z9DXuEUixxLhuqDvX9S8L1YfUov0PkMRCTqsvRsGOQadIQV6jrVOGdv4gce1SSSjgZPIOc19RLVHMoSuNvrjBYgnA4rkvEFztgKFsdSa6S+lSOAyySDB5rjvFt5bRWsjNIvIIVc+vfNfPZpVUKMl5HVQi0zzfxTeRMkiGTaeWVtoIzXmHiWGSRnXymBd95BXO4+teg+LL+wt3SLO87TtG37w/pXnuvSm484wtgEnCs5+VfUV+PZrLnuezR2OW1VVEskRmwhTG8t1asW8EduvlyyAnbjGO/rmtDVvOeRrt33ALtDhev4f1rFdhtwI+hw5Bz9K+OxDsbw+IzZJQfM2REbD8xJ61DMGMfPYVZuJY3DJtA3HnFVbqREi+XuMc15klZnWypNIzjmqt3gxEN0AyPrU8p2ggVBegC3Ug8vwRWa3KexyXiwh7NxIeSvFeV+IkZbjn+7/WvUfGjbrcRofmxyK8v8TshmXY33Tg8+9fTZX/FicOLTcD3v4IsI/hZ4dRwcm2P/AKMavcf2vSkv7R0684XR7fH/AIDGvDfg2UX4ZeHGY4/0Qf8AoZr3D9rnaf2jr9t2SNNtgNv/AF7Gv6CymyyqPy/I+fnpIp+DizW6xv08pP8A0Fa1NRik2gwMOvftWb4ZXylMKkfIoAY98KB/StKbJh3BsE/3q/QMIrYSmuyOSXxFCBiJfKeBt+eX7VZmglxwd/utCysTs2A+rYp4LxHMTZHtW5JGYyi4kIGKJW3FTCMgDmnSMJEdpAMg4FRfMqKRxnsK0NBscSrcEsDzzxUlxFZvHtlkYc8bG5p25bcebJ0PAJqCV1JyY1DE9RQBYyZFBc9B3GDSbo2kBY4weM1DHLIy4dqbmNSDknnjJoAsvbAtuI689aZgxNkORg8Gnxynyy0p5/hpYlklIMsYx3xQA2e4kYAFOn8VOiclRHtYnPXHFDxSyn5hhT6UpEkJJDhl/uD71ADpNz/uXEZU9QOtIdsUZLNkJ0pY0Rj5u0qffqajuUaSGTDZORwtAE8LrcRK4PNPAaMg5HNVrRHi8uLOQRnIq4sIYZ3/AJ0ASqY8AnOakVeQ2RUYQY5P5VJCvzBSTQBPHGpw5HapYy45lx17UxRhQPapUAcZNAEq/OABUkSohywqJfk6VJH+8PPc9qALC7G+6oFKylTgimLIoOxOWz3pRI00hXcuR1zVcrA+2aKKKxAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/G+iiitACiiigApHUMuCaWkYZU0AM2heAc0dTRmgHBzQA2WUFdrgDHTPelh4HPSmXC5A5p0ThgFPFAD2ZOgIzSEheScZqKYMrZ6c0jSFgAR0OaAJQ6k4DVIqn+IVVDYbdjvVpHV1yDQBJFJt+Ujirdu+Pu89KpqucHNSxyleAKHsBorI+5flpmsMF0W7DHBMDfypLRy4JPaovEswj0a7I5P2cn9Kz6XHGKlKxzukT+V4ZtwW7DP8A32a+g/2KJyfiZEf+nRRnP+yOK+edOCt4YtT0yP8A2Z69x/Y+1L7F8SI3Bx+6Hf2r5GT/AH8n53NL7I++7WZkTcR1A71ZjLSLux1rG0XURd2y45yo5zWxDzEMSY/Ct+dy0MiRVOeRTsDOMCmpuRg0j8DrRJfQR9etZymospK5BqhC27A8YU14V8YJUWG443EcY56k4FeyeIL9TEdsv3h+VeFfGjVtrTQhwOAQhJG7n2r5fiatD6idWHguY+e/iKbhJ2DbmTO0ED72Bk5HY+9eR+JGDylgcjZXq/xDmuz+6jhKYRm4QNknr1PpXkXiFwQxVuR1Ffz7nVVKUj6bDx91HK60yvIWU5GKwbllCEE8luK2dQYsXbtnisW8TPOe+a/NcTPnrtnorRFK5RtzsBwelQnhME1anOIyaqTjjPqKunsLchP38/Wo5geuOM1JTJ/9WP8AerdO6HyoiAwMGgAnoKG6n606PvTB6IQKwPSp1ZQckio6KmQtycMGGQaUcGo4m2rjHenB8nGKhool3r60b19aZRUAPDA9DSj73PSmKdpzinBx3oAm2kDOOKEYDqajEjeuRSg7m6dKT2AmDKGwTSOoLZAHWmscPmnjkZqAHxY8zI6Yq7BIF71Si6/jViMhyFI/Wpa6hsbug3Ukd4q84PXmvU/h/qkdpeQzSEAEAHJ/iHf+VeUaV5BdHjyrjsa7bw1qRtjHHcxDc0uAGHy/U+1e7w7iI0qurOarHmifbn7M2uQMFtg65MSgj1NfQtpcxSJEvmAkDkV8Rfs//EE+HtUVpJCY2ZQdvQmvpnQvihZXjoIbrnHOTiv6K4YzyhDDKlJ7WPm8TRbm5HpymEjKPnHpTZpVAPPQd6w9I8R+ftYOuCM5xU+rasVQzGQDjHBr7mWZU3S5os4/YtDdY1KMLhSG2jO0HrivOPFurARELDuUOAFc9cng1p+JvFMNsGYTwbsH7zcmvL/EniRbxpIr65LkFSsGfkOD1yK+NzfNFUptM6KNPXUzPE2qzSST+QSBkhZG6n1rjdbkkIleafLMRhcYCitHW9VkJmiikUgEhc9ga5LWdTtpoGWJBGRKC0iZwwHbJr87x9dOTsenSiitq9xPbykRkP8Au8bt3asS4nCxPtBCBRlRwc1a1DUIQhj3njB3n+VZE14HWQqDg4OM183iJKWx0Qirkd20KrlwQx6AHtVWR0KdeOetJczMwVmGSeetRGTK7cfrXnSk2zqUU1cazsw+Ze/XNV7+QJ5fpz+FTFwRgjFU9QkDIqDsTWSk7jkrI5Hxe+X3g8ZOfyrzHxCWjlZnHG/v9a9K8XP8rDH8JrzXxMfNZl6fNX02WSamn2scOJ+A98+ERM3ws8PEDG21Q/UeY1ex/tP3Zvv2iNUmDcR6fbqcH/p2ORXjfwek8v4W6ACvWwj7/wC21eh/FjXjrnxdu9QUf6+2y3zZ6QEAfpX9CZS/+EuK9PyPnqvxHUaA0fzn+HYNgHY4FaExmZeI9+Bx6GsvQBiNv9xf/QRWwjnYFK8Y65r9CwmuHicctyvHFI+SwK+3ajzGtThUziptyM23GfxqO7WJFDBCT9a6eVEiRIrbgx4PPNBiLchhgetRwwm5G6R8H2NDs0IKA5APWmaEVw5m/dSDAU8E96jAMnzkc+npT3dX5zUbFwfloAd5bx/vN+8N1T0pYVdS5uXjYeZmIRxlSFx0Oeppq+YSMvUhOMfWgCRpoZU+6Rt6YNT2zmWHgnI7VVcAAEDtRHNIhBUcemaALyxtF8mSR25pQEB3bee5FRQyscluc1LQA2WMSkMSQAc4B5pViQjj5fUetOAycUrRxg/Mxzj0oARYViXBbg9DUmwMBiQ0jDcAMdDUsaZIBOKAHIvybAe2KlhjMeGb6U0RhDlWzz6VNEQ42HjAyKAJ90ZwBj8qVVVTkOajijIGWbvUlAEybWXinLwRj1pkHQ/WpF6j60ASIQjbwoJqNbXEpmDnJ96fT0+6KtO4H2zRRRWABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH430UUVoAUUUZHqKAChuh+lGR6ikZhg80AMHU/Wigd6ULn+IfnQBFcEADJ71HGcNnNSXiYUHcD9DUCSAqDg0AWLmZXj461XDtzzSyMAuc96ZvHoaAHoxJ+Y1LbyBZcZ4PWoF+bpUkKkPt9RQBdV84xwKkjALDNQRkMhYdqmjYEhfxoAuQyeUpC9xVXxQ5Gg3MoOC1uf5VPEwXG7piqni+YHQLvZkEW5qZNcrKg0pq5z8Exi8NWKg4yoz+bV6p+zRrYsPGYuC/Kxjn24ry2GNW8Oaex6+SD+Zauv+CuoCw8Sicg7PlGMZNfGTklVlLsUkz7++H/j62urBWR0PzEBhyOB0rsLHxSkkShhuOOq18aeBvjldaBqV3YR2gWD7TIRAz4/i5x6E+lesaF8dNNuoopNwG8cjzMbPY14izqlFu5rTpOT2Pd5vE8fIRHH1NZ934m3qxDEY6V5mPjBp7ggEFh2B6Vk6j8WIXysd1sJB4Y9K4q3EFGOq1NlhWz0DXvGAggLM+TzivFvil4klvryW6VmxtKjHrRrPjm5viSLjcCcDD8GvPvGXimNw8cUv8e19smcE8dK+LzvPPrUXG+h10qPKjhPHGpxSuIwyyTEMWIGSpPGM15trFxiSTceSvzDHSus8UXjB/tSEEAtmPGM/5NcJrE1wWd2HBFfkGdYmybPbor3UYlzKWjIU8Amsy5Gf0q/OyqrLg5yc1nzOOmDzXwybnJs7incsQmM1VlJK8+hq1dcpiqkrgLg9hXTTTsJJpkdMn/1Y/wB6nEgdfWmTyKYxwfvVtHYohdm3HnvSCRx0NDcsT70la2RDHebJ/e/SpXJABFQVPL0AqZJDjuEbtzzUq9qgUhRk1Oh4BrNot7klFN3j0NOByM1nZiCkKg9RS0UgHRlj1qROv4Uxeg+lPTrmk9gHv9409fuflTGOTmnBwFxg1FrAORiG4NT2zEykE8YqspBO6p7ZwHMnbFJ7AaENzOZADJ06cV1vhrUoLy1Sx1MuCJN0U2e/936Vxtu4LbwDwSK07O4b5YgDjdknNPC1lh6yZMopo9d8H681rMLl5XjZDhVToOODj8K9V8GfEeWZxtu0LYHLOw+tfP3h7X1t0CXUZuV4LfvChJHfK9f/AK9dloPjrSNPQGLwsHIJ4nnLL+QxX6JlWdKKTueZXoXZ9b+DvjTaQ2C2mq3Cl0TqB1H1BrQ1r416Xd2eNOmMqtkCQOAMgZ6Hk18zad8WUS0SOz8PabCzghXW3DbTg881rWnxo1R4IR9i0pHt8bW+wISWHfpX2EOKGqCpyZx+wfU9L1vx/FqMYYXYdT90hQfzxz+dcnq2uxkkOsjkt0Bxj6GuXvfiTe6tJEbwR4hl3fuFWMdMHgL+P4Vn3fiVpCFZm+4OQ/evMxWZ+1V0395caSXQ2tX14xQtH5wBfhC/8PtXM3mp3EiMsDKVY/NgdxVa71F5Xaa4kMkjgDdnGKp/2gpSRg/LNwoAwK8qtXclc2irdB+oXrtFtkHJOc4qjJdbt5UcEDAxSzXAnUqTznvVOadosnI4PavLqTcmbRi7ks0/3VKnpxxUMk5TgHmmG6d2Ge3NNJLHJrlm/eOiKshWmZm2joarXzbQuDjk5qbzVXkg1U1BwxDjpzWMJvmVwlrE5LxdLhyC3G05Fea+I5c3JUH+L+teieLpF3b+cFePyrzbXyDchgeGbj86+py2Ub39Dz8U0oH0N8K1VfhpoCY/5h6ZH/AmrptYdpfGDTFtzG1bJ+kJxXNfC8AfDfQHLDnTkOM+pNb1w+fFUjMRgWrn/wAhNX9D5X/yLIfI+dlrNnpvhuINvDJxwPwAFaafONmcAD9KoeF5B5kqkHIOCO/IxU9tdSl9sluSoXrjt0r9Cwn8CPocstyVY40ckPn8aJnlKYjUHim5jlcgRFcVIqiPIFdRJmSQ3duqvaHcc85NT3DySW6rImGI+Y4qTaqEOFPBp7zoF+7nPODQaFHyowmAOR70qZAwR9Kc0nmTHEO36ClKY6kUANIXOT1+tOVQ/cfWnJFE4wc59aR4Hj+8h2jmgBWQKNrn6Uu3d8g64pJQ0kQlA4AxjvQS6xCRRhunNAE9rGdmX5NTUyA7owSOe5p9AAM54p6ycYZlz7imoeakwvdQaAEwy/MHB+lSoxkA3HOKjXG4bulTRqo+73oAcJAhKqhqWNZHAaLmoohmXcV4HWrAd4iAiAAjjFAEiu6ttlHNPpgDuNzdaeOTigB8RYA4p6l8jr19KYokQcEc09fNyCSMUAT8bffNOUjb1qMMCcCnBCRmqjuB9t0UUViAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+N9FFFaAI33T9Kj2/wC0fzqVuh+lR0AJt/2j+dAXB6mlpGbYM0ADMRnHYZqEzOVzntQ87YIxzUElx2HbtQA6WZyQCc/Wmu5UZAHSo2Z5CCF6dcUrMCuM84oAFmRjgk0oKs2F6VHgDoKRmxgA85oAsK5DYHapInPmjgdDUCuu7rUgYHkGgC5buTGQe5qVGIYEfSq1s4WElj3qxGwKhge9D2AtxklcmqPi8keH7xh/z7GrcTrgHPAPNUvGZK+HLwjqRgfmKykrr5i6oyIHP/CN6ef+mKL+jVs/Dy7FvqW9mKgFeV6jg1ixYGiWMIPKwoSP+A1d8IXJt9SSQdAwzXxNWVo1fVnSgtPG0i+ItREV0Wi+2Skbxt5DEc13XhP4iyWk727XbvGrBHEqgqOB+PevAYdflXXrwtk7ryYHPf8AetXU+G/Eki3DSgZBXD554r8bzHMXGrOKf2meth6cZRufQtj47kkj/eSfLnCBXAY+4B7VJceNXELJcKPML4yT0Hqa8ttNfW8jQuQEZNqnuDV2TxG4jRWy4P7ssfavnquZz2udsKCa0O11PxRBJ925dAw6M3HvjFc74m8Q3UmEUAKoHzDAyc8e9Yl5q01w4dZPLWMYj+ftWVqGsz3DMzS5VuVdu+K8PGY+TerNo0Fch13UpGDJ5zZ3HjOa5TVbiUE5Yn5sYrR1O7JQlpBnPY1z+ozucgNznrmvh80xbqJq5204LoVblzuPy4z61RmOMH0q3IzsPnOeapyso4J53V5dPQ25bu5WuHVgQKpz9/xq1LgKQepNVZ+/411Q+EbViN+g/wB4VFN/qh/vGpX6D/eFRTf6of7xrSOwiJup+tFDdT9aK2Ie4VNL1/GoakpNXHHe4dvxqdPuD6VVYnzQM9qnjJ8rr3qHoW9WSU+L5uDUKuAcMfpTwTjg1mIkoo6jNFRLcB69B9KcGK9KiyfWjJ9TSAmDknFOqBScjk9akyfU0mrgTJ0/GpbblD+FVkJx1PWpom2kEnjFQ9ALtocpn1JNXYJwjbazoj/dPGKtQ8MCfWuapFvVClsbWn3zxkKjdq2rPVZwoAeuZtrnYc4FXE1JowCgz6Cqw+LrU5WuJU1JXZ2FlrEiJgycjoKtWeozr87MWBOfpXJWWrXEsiebgdcitSHUz5e0P36Zr6DD5mnH3mc8qOlzqbfVpJMlAeDz9KmfUssCZCfl9a5y31OYYw42+1WBflsd89K9OOM5ldMUaS6m2+ojavz9/WmJeptOZAfpWObtj1H0ojufk4rR4puNrj5I3NNr1Qx2NUEtwshIYnrmqyzkDJUc0C4VucDrjNYOrc05Etiyk6E/h6U/zk96qCUL05pfPP8AdFK/NqJqxK8qZ21VvZcxtj+FTRJMxPAqpezO0JZR8uOQKCZOyOV8XTBoAShBxjPavOvEJETo+f4h1+tegeM5SYgV4GznnpxXnPipmiuFdjhdoPNfRZf8P3Hm4qN4M+ifhtg/DXw+wY/8gyL+Vb6SB9ekcjJ+xy9e37pua5v4ayKfhv4dxx/xK4uPwrdtZVXU3OetlMD+MTV/SGVP/hNpvyX5HzsvjZ634a+Vp2HL7jhvXFWWleKHYPQc9/Ws/wAJShluFyg2yY+VquzOzzfJyvrX32F/gR9DmluSQSbSS5JJ6ZqZDkc8e5qCFWDh35GOtOkt/PXeLllHoK61sSOZkcFQOvtTBBuYAE4pse7cWPQdakE7E4Cc0zQbLGsI3BRkeoqscv8AMSevarjKJOHOM9apT7o5dqAke1AEkBQcEmppJ1Mfl5Jye9Q26GYcrgetOaAQnJJJ+tACmRkjAMeRmpHVZUUkAfSo03DDE8A1YEkRGQRj6UALG3ylNv40oGBigYxxSGRAdpPNADlYqcgU5CSMn1plKA2OP50APHBzUkcwJ2r1qFVdmwSfwpyqFcNGcsO1AF22ZFwrDnvU8k0fDY6e1VIEmkO9kIbuPSpVUs21ielAE4nRhn+lSRjdyTt9jTIowiAdaeoBYZFAEqgMMEHindBx2FR5PrTx93n0oAkhUM3NPYlDtHamIjj5gOPrQXUspB471UdwPt2iiisQCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPxvopzBccfzptaANLZyuKaMltpGKeVA5A5qOSTYcnrQA1ptrhNvX3ps8mF247+tNeVN24p+NRtOH4IoASR8DdimblI3bf1oc54zxTXIAwDQAjThRgJ196jMmTnH60SdqbQA7zPakJy27FJQOWxQBIh/ixUkcnXioNzBcA96lTAHNAFqJ8xhcdasQSZUrjo1VIGOQM96s2/RvY0PYC3EMJ16mqXjWbPh25G3qQOvuKvQgmMEDtVDxmoPhqc45/wDrio6MaV2ZaDZpVs+c4gTj/gNSaKGW5j2tj5wc4qFyw0q2HP8AqF/9AqbQ2BuULHof6V8Fi5ONGq/M66aTlY8ii1OWbWrxmbH+lytj6yNXTeGbwm5AMnXqK4eCYrqd1IG6zyY/77NdDoF75dwuR261/OOZ4pxxNT/Ez3cLTThoel2epHYkgweAQp6Cr0GpSNE0TzbQ67Tj3rkbLUWMaqc/d6Vcj1BlxjNfM1cfFN3PQpx5I2OinuUZVjxlVGBlqztVuVkAWQ4C8KA1UJdRY9Dn6VUuLtnJyDXk4vMOaLRqldjLmaJWJXJ+rVmzzLIdxfGO1WJWDH2qpLGA2NtfOVanPM3jFIRmDDg1SuBiTb6c1YZvKOCpqrI5eUnPU1qnrcbdircy7cfL+tV5G8wE4xirNyilcharEEBxiuqPYV2xhO5guO9R3C7YwM/xU9f9YSe3Sm3PKjHPNaR2EMMORu3fpTGXb3qbI29e1QyEccitiWlYSpvL96gyPUVL5o/vj86AiI8eHDZ7elPV9qbcd6bu3c5zRUNalCl8kHHSpFkyo4/WosH0NPUgDBNQ0BMk2Rt2/rS+Z7VCGA6MKPMP94VPLcCwCmPv0Hb2bNQecOm0mnRyE5wCPrSsgJQcHNO8z2qIM3c8Zp+QehosgJI5Ogx1PrVoRdt3b0qnH69watJNlcE81nJLUlt3J4X4zirUb7hjFUY2PY1Zt2bZyec1zu6QLXcvW3H3m7elXYTGV2k/jWfCxOMmrULqpAI7Vyu9zWKsi1G2DtBx71a85AFAyPXmqCSbuoxUiS8jPOKxba1QS1RsWF2yqctkdAM1bS+AIGOh9axre4RTgEDn1qZLr9714r2MPi1ypMykjbW9bAIYDnoRTzOoQqDWck67elTbye9elGspJJGTTuX0uF24JpFukQbevzZ61R88pwTmnhsjcR71d2F2aAuUzg+nrThKhGdwqjDOrHle1SCZRwFNawrxgrMNWTGRCSd3Y1WnIK7c8YxSmVGX5B+OaYzxrHu4PJ5z7Vsqik7ELXRnIeNliFsZAMEgAc9K828ZOSQSei4+teg+NpHdMI2FGK878YFicnt/hX0mBelvT8zgxXwM+jvhyNvw78OjGP8AiVQ/+g1t2SrNqMoYcC0lH/jh5rB8BSY+H/h4B+miwZ+uwVuac+3UZmzn/RJPz2mv6Syv/kV0/RfkfOS/iM9U8IGGK2uZWt1x5p6dzk1oPJHG5jXk+lZfhOY/Zp0YdZ3Dr/wKtIsDJgxkH3r9Dw0V9XiczV5As0yNxwD2xUn2lh1FNZNzDmhlQNg4/OugLIkt5VORjOT0qZ2KL8rKCT0JqsqqCQkZQ5ypalYzO4zH5vOWI7UDJmUMuH5B7jvSqsaDAQfjQNu0Ko4B4HpRQArMxGFIH4UsYHRhmm05Ov4UAKyowwFx+NJ5Y8vZ+tOooAQnYAOtAAb5sUjgnGBSr92gBcU9CpXlsUyjBPQUATR7Sd28j6VKhiz8qKT/AHu9VYgQORUsW4Hj0oAuQOI2PmZA7HrUix4/e7vlxxxUcQBGcZOOc1NgSRbQMd6AJFwSqg9e9PCYOc1HEpUgelS5HrQAU8DK49qaoH8VKGO7APGaAJRNhNm39aaqZGc0lPT7oovYD7dooorMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8bt49DRvHoaQoAM1DJIytgVoA9nYEkMPzqOZ0YAg896aWycu2B3ptyqx48uTINADZCHGBUVKGKjFNY4GaAFph5bHvS7z6Cml0HIJzQA1+oFNpSSTk0lABSbgrZNJvPoKQkk5NAD1cM2QD1p5cNJkelQxfeIqVBzn0oAtQnByexqzbODuHr0qrCcrk1PA6jG31pNoDTtuIx7VQ8Yqf8AhHZ37Ej+Yq5bu21R6mqPjaRk8LTsvbb+pqL2T9BrcypyF0q1J/54r/6CtJorAXO7sVJpszFtKtQf+eC/+grUOmzukgxjow/Svgca70Z+rO2kryPE/PXz5cf89nz+Lk1t6LKyyrls/Ln9M1zHm7rhhnrKSfzre0Zi0q5PbH9K/lbPa7jWnNd3+J9JhfgOzsZWKgA9avCZgAC3WsbTJDhSx6rzV17oBduTXw1SvUvc9GEFy6l3zj/eH51DcSMFL5z9DUCyEjIP40FiQQT1rknUc2Wo2GySMVH59ahmkYtjP61I/wDd9Kil+/URj7xQyZXPDEcVUKENk9jViaZ89utV95Y4PeuyMGyWm2QuwZDj+9Vdup+tTH7pHvUJZAxDE9a6ErCaaIJvufjUVSzfc/GoWJAyK0jsIH+4fpUFSFyU59KjrdbktqwUU1nIOKVjgZqmrkk0H3D9aevUfWoIpWVeAOtOE75HAqeVlpqxZpj/AHjTPOf2oMjE5OKlq4XQ6ikjJdsGn7B6mp5WPcRTg5qSJg2cVEeDilVpF+5j3zSGlcnb7m31NKnX8Kh3znAO3FTR88+1Jq4NWJY2AbBpx5OajHBzStIwGRis2mmZvctQSKTt/nVmNmDHB4z61Rt/mcEn8quKxU4Fc8073HHcsxyMRxViG4IPeqisVUYqWNyD+VYVFeJRprygf1p0feoI5nKBeMCpUc4z61xuLsXzIlU4YE+tS+aARtPeqyu3If8ADFC5LDJNVSXLO7Jbua8Ux8sfMKsW06k43j86y4ZGIANWoHVRuIx7ivVw9SPMmQ02XmZWbIPanCUk43cfWqLXcYYDcfzo+2JnAJ/OvS9pFmfKzRQjPUdKUyKDjNUDdlV3DHXnJoW/jmJAPPfmrU42GtEXEk89+CVTvTb+5jVPLjGAoz9arSagqDy+B7Diql5csFO49RVQtFWFZowPF9wi2u0nkNkn8cV514wvFClc9FJ4rtfGFwGXYTwc5/OvOfFcuWbaexHP0r6TLn76+R5uKV4s+nPh+SfAOhbuv9k2/wD6LFb+mcX1wfS2k/8AQa5/wQ7J4K0aNei6Vb4/79rW/pLF7ybPe1kz+Qr+nMtX/CfBeS/I+cl/E+Z6n4WGRcH+9cMR+da8rgzke1ZfhZFETt6yEmtCRju396/QcLrRi/IwluPbhhUgaHoyMWHXAFRg7vmPanbj2HPrXSSK/wA7fOpODwveg28obdEXTP3lB5p0jrhSp+brnvToZHKkluc9aAHoseFDAqQenrUmI/Q0zacbhyccZpN0i/exQBJiP0NJhB90UinIzQTjH1oAWilIxj6UKMnFACDk4oHNLHyxPpQVAbaKAEp6DApPLX3pylA21qAEPCEGnxTKOCD0prqVb5vu96dDHFIeGx9aAL9omR5hIwanwhB2dcVVjkCBY3bI4xtqSRxFKqxtuz2oAS0klaV1fgDvmpxwc1FAx8xlKcY6GpaAJA4YYHalRCDk0yPvUy9B9KACnj5kC9PcUynpyuOnuaAPt2iiiswCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPxr+bvJn2qOfqKkyO2fyqOftWgETMu089qjdScYFNd4wcYOSeTSmQdByPWgCKRnDhWX5R3pu9fWnTlm6LUbrtOM0AK7ArgGmZ2rk9qR0djlf5VGyyDORQBJ9p96a0gY5JqOigAL+WN1IJPMG6hhkdKSMsQdyY5oAfGDvPv0qZARnIqKP74+tTUAT23b61ahwzbV9Kq2wyAPerUCNHNzg/jUPcDRg4C/QVm+PmH/CM3Kg8kJj860bdtwHHpWb8QPl8OTH12fzqX8L9Bx3M2RWGlwMRwYVx/wB8LVKyyI2Ppu/lV+cY0a197dT/AOOLVC0IEbk+j/yr4DG6Yep8zvo/EeCQ3G+VsHP7xv510uhP84LHtXJWrljvUcFyc/jXU+HySm4+lfyVnEuarOPmfR4RXidXYviPeOcCpjOfSqOmysyYPerbjAB96+PnvY9VKyJ1cEDPWhyQODTV5bHvTmG4YzXNa0gGU2ZlYnB6daeRg4qGT5SfetYJN3Ajf/VtVX+P8atSfdx61XCZbOe9dkNkBWPQ/Won+8amaPg8/wAVRvG244Ga1E9iu/3j/vD+dE3HT1pZU2gtnqRTJJcjJHeqjsQQt90/SoXIPQ1Iz5UjHaoq3W5D3CiiirEOTp+NODKG696YrbRjFAOWz70ATb19aN6+tMorMCRHXPXtT96+tQp1/Cn0Du0SdadGzLnaKYvQfSnx96VkWOLyEYxSR7lbnpS0VLViXoTCWMD736UjSoRgN+lRUVnLcht3LttIgYEmraurHIPTFZ8PT8KuQnjHvWU4pxKTsWUIHOeKlidQc571AjZG3FSR88e9cs9dB8zLkNwGG0n9KsQsMHntxVGHg/Sp1kJGBxiuecUnYomjbZ9485NOE5z0qFHLHBHenVCVgLUdwSwI71ZadihIXiqEL4I46GrSnI8v1712UdIg9hDeoG2k8jtTg4Jz3qlNFIZienNWVyIx64raNSRmWVl3JtNIpCMSTjmq0bSZ5GOKkiciT5uldMJNxuBKzB3yDmmXEmyIrjqKZI7F/lFMnfEfrxXTBvmFLRHJ+MMsox6mvPvE6sGwR3Ofyr0DxbIowM9CTXA+JirlmB9f5V9Plsnzx9UeXiZPlZ9OeCHX/hC9H5/5hdv/AOi1rf0WRHuJgp5MDY/MVzvgwpH4O0hC3/MKt/8A0UtdBoKbbqVs/wDLu3/oS1/UOWf8i6D9D56S/eNnrnhM7rUkds5q/HLGTy36VQ8IH/RHHpmrQXZk5r77Cu1CPoc8tydAck9sU8deKbE24HjvTq6lqiR1wZR0jX8DTFeYDg49qc7M5BJ6ChY3YZUD86YEirICNz9s4pZlkZMRtg1GvnGcbgAAOxqagBkMU4I3Px3qwI9qe/emxnABNPLqRgHNADQQelBIHJoAx+dBGRigAJC8nvT4zlcrS7AFGeaEwhz2oAOZOWHTmnQsjN8yZPSh5EIwnr60145Cv7oDJ9TQA6WRQcgZ56U5lhZsqMccikt4wMiTkjtT2QFtwNAEkJQDaefapyrKqsRgZ4qukeDlx8p7irEkgGyM8A9D70ASRSYBQDkin1GgYNtYc44xzmpKAHR96kQgKFJ5qOPvT16j60APpwYbNueabQFYnJxj1zQB9wUUUVmAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+NciStIVGAOxFRSwSKhZpCcHikluhJJ+7J2etMlnwuxWJz61oBHIwaIAR89+KibgALTzIFTj05qJplIxg0ANd2zjccU0knkmg8nNNlkVEJJoAGkKnAemli2cNn8ajMisNwPFRNIxbg4weMUXQEvzgneoHpimybv4c/hSRu5zvYH05pzOq9aLoB0YBHNJOGyNgPvgUjSbBkGnQuXUk+tNK4Eka8g7f0qaIRnO/wDCo0dcgEVKjwg85H4UWYE8CqOg7+lWoI13btvPrVaIqzZToTxVyBSBk+lZvcC1CPkyo/Ksr4hE/wDCNTnP8SD9a17PkYPTNZPxDGPDU/u6fzpacr9Brco3QH9m26gcCIAD2wKoRALYyOOD5TnP/ATWlexNHYQAkcRf0Ws1l8vTJmJ6W8hP/fJr8/x/+71PmdtK6lc+edObMagnucj8q6vRCoQBSOvY1yOnOMD/AD1xXVaByVAr+R80X76Xqz6bB/CdRpwGzpVtQCeR0qrp33Pwq3H3r5SXxHqdESgL1AFDfdpFcAYoLAggVzS3YEbSEMBgnmmNyCTTm++PrSN0P0rWGwEEhweveo5cZBTpnqKfN1/Go1/1Q/3q0TdwIJDhDz3qIM3cmpJ+1R11Q3FLYrsSXZT0B6VFPwyAdzzUrf61vrUVx99P96t4pWIIH71HUj96jrayIe4UUUUCDBPQUoByOKVOn406gAoooqLMBUIB5NOyPUUyikBJv/2v1qSA5zzmq9S2rAFgfaga3J6KKAM1LVymrjHJEigHrTwDg5FNKl5AR2qVvu1lLclpksPT8KsxE5Izzniq0PT8KuQ7RyQc1hNuxKUrkgOFHNPRxkfN6d6Ym1zgipERB8uKwkncqzLERx1NSA+hqMcDFOj71nLYslUgAYNSqQU681AvUfWpFYKeaxdgLFvtwd2PapFk2NuJ4qvG4Xk1K5BQYPWnGTTB7EpljY5KZ96XOeRUKEYxUoIAwSK64tMzB32DJFJHNGeoH407arcFhSC3XHatqc17RK4D224yMZqrNvEbM2cBh1qzg+lRXiEwMtd9GMnNAcd4uYFd3TLiuA1pmLNk8fN/6Ca7zxfx+7PUuDXn2vTBHEffY4P4g19Jlqk6i9UcGJS5WfUPhrC+H9LRD8o0uAAD/rmtdF4cYtcXBJyBGQD7b0Fc9oOItE04EdNOgH/kNa6Dw0QGmX+9GMfjKlf1PlS/4TY+i/I+aq6VD1jwjI/9ns245yc1qPgMR71k+EXH2B+D3/nWo7gtx6199Q/gx9Dln8TJIDgnJqeLYfvYqtEwYkCpo/mGBXQtiR0YyZMjp0pbcMS+4HA9qRM7mjXqeM1OgMbnPQrgj3pgIqKMMF59aXBPQU8KhT5R2oVSvWgAUfLgilwo6j8qKKABcbuM496kwPQUxVJO6n0AGxn6NjFGwjg/nSqwXrTi2RwDQAgjVTnIP0pxjBUkNg4pqAg8ingZ7igB6ICik9T1J60BHWYg5IxUKzOSqjPB6mpvtBjfzDg5HSgCxbmLytrkc9cmpI0hlOAc7T37VXiuUlUFogCevFWYI1RCR3NAAEMc/mjJx0NPpC4BxS9gfWgAyR0NSJzio6khHzBT9aAJKQxlxy/HpRkZxSnigD7gooorMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8XnKxjY1Myp5WkkIDcn1qvNIeQnNVzFcpNLKoGPzqFyw5HQ9KhY5kDH0GaVpQoODRzCasLJK4GEIz71AZQ0eRwc9DSPMxXAqu5AfOaOYRJJMB8rH8qaGJOM8Gm+aV4Wm+Y+7OO9SBKSsfXvTo33jHaoTIWILdqdkHkUAT+Uw5YU6OQRnYD15qBJ8xtEDxmnxy7VAA/HFVzAWVmUsMdantzufDAVST5sY9c1bgYE8GjmkBdiAVsD1q5bEscE9qoREb8+9XoPuk+1SBegUIvy+tY3xEdh4ekXsZEzW3Y/cH0FYnxKGdCIX+K4TH4VMnaL9ATsyLVABaRL2+zg/8Ajq1lSknSJyf+fV//AEE1q6qD5bZ/55uB+lY9/IqeHrxs9LKX/wBFtX59mEuXC1H6/qd1OV7Ls7nzrppO3/gI/pXWeHvvKP8AZrktLIaNHPXaMj8BXY+HuSuO6Gv5KzOV6jfds+mwfwnS6cf3a+45q4nWqdiDjGOgq6hGMV8rL4mem3ZIdwG56ZpiSBmZR2NDsAhyfam25CyZJ7VzyW4xX++PrSN0P0oYEbwahlZQpUnmtYR90BsgBPPrTJQEG1egpoByTUM/U1oo6gEwG3NRCimP9410Q3IbuRN/rW+tRXH30/3qcGKndUE0m5stW8diW7DX71HQSCcimydq2IHUVHRQBKGI6Gje3rTFYAcml3Ke9ADt7etG9vWkooG1YcrEnk06o6KTVxElG4qwwajp0felyjTsy3E5bg1Ivf6VSBwQasRSIx4bt6UmrFJ3Hx/fP1qR/ummo64xnqakj4ODWE1uMfD0/CrKsQcCq1Pi5xj1rnlsBbjJDcVMvY1Xtv8AW/hVxeg+lZS3AkHIpQSOhpF6t9KKykr6ASL2qSo07VJXO9AHr90Uu4gDHao6VWKnIoAsQ8jJp0qgKWHXGar+c1KHDfKT1ranLoTyjUmkUnB7VdgdioFVTGE5FOT7orWnK1VS7Byl7zk/yKZc7JYWPotVBLnhqXzttuyg8mvboTi2Q3ZHH+K/nlXd6mvPfEaL5ofuFY/pXpXieLeGcddp/OvN/EuAylvcH+VfT5arTVu6ODEu0D6j0wD+yrIeljCPyiStvww7NcOCeqp/6OSsGHEem20QPKWcY/JRW/4OkBuSF6/ux/5FWv6gyx2y6K8l+R83V+P5nq/g9QbE57qa0gcjJrO8OyBNODJjBU81cjOQp9QK++o/wY+hyz+IswdT9KljYhsA96gj71KnQV0LYkmQSR85HXNTynDnB/hzioFby2Adtyg9Kl8yKRw0fTPNMB6SLgLzk+1PoJBORSH7woAWlUAnmiTk4FBUjqKAHgAdKaCxbaKbUkLKO9ACorZ+cCpwAowKhcg9DRGwHBNAD2Yk4pjsgOG60r9Pxpogjk+ZjzQA5j8uRTUUE5NO+VhtzUiJHjG79KAFT5QCBVmGaQjaVwPpVZwEHPSpbJ/NYeZxjge9AFoKCMkUrcbAPemLH5beYvNOEjMORxQA9ADnIpzcMhHtSRqTkgU6JpFfGO/FAD8DOaKYu6NipfIbk/WnlI2TIbk8nigD7gooorMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8U537hqquzbjzSvIMcyc/WondSOHH50Gg+SRVTr2qB51Axv6+9NlbIA3Z9eahk7UEtDyyk58yoz+9YgP0pH+5x1qBvMD/Lnn1oJsx7syHBP61JFNuABHaq53fxYz7UCXHyj6UAWmkAXKnNDsAM7j9Kro3XLfrTnfK42598UAWIXUqcd+actyyny+3pVaJsHCt27GpY5QjYY/nQBcSXYM4qeJgQGU9etUg4fgMDntmrFkHx84PfrQBo278gY71pQHERNZkOAwJ6VfgYlSA3bpmgC/ZEugOcY4rK+I/Gixr/03X9a1rIbYxkY6dayPiSR/YkRB/wCXhP51FTSm35DSuyLVzhCPVW/nWFq7lNAvowM/6BMf/HDW/rAGx+OgbH0zWDq4B0e+bA2iwl57fcNfnmaO2En8zuopXPnjSUbylz/dH+f0rr/DzkFBjsK5XTAfJiBB+6M/ma6vw7twDxX8l4+zk792fT4ZJbHS2Mh37cdRV2PvWfa53jb+lXkkRWO5wPTJr5iovedj0H0CYfKV981Hz2NPlZWbKsCNvY01CuSCR0rFoocCWVifSq8w+cj0qUsASA361FKy7s7hz79a0hcCNm29qrzycnipnIz1qtcMvJ3D862igG+Z7U0nJzQORkUySYI2DW0VZmZFJ8pK1Wm6/jU07rn74796ruSTnNbR2IluNBwufamSSHjApzMgB+YdPWonIPQg1sldiDefQUbz6CkpMj1FVygSKSRk0oODmo9wHRv1o3/7X60coE3me1Hme1Q5PqaMn1NJxsO7ZOrbjjFLUG5h0Y/nRvf+8fzqbMRPSq23tUIk6Dfz9aeh65NFmBIHycYqSE7TjHaoQe4NKpbPBNDQ7tFyE7iD6Gp2574qtA6BOXAOfWpkbc3DZ/GspR3LQ9CUzk5qaB8kDHeoakg4IJ9a5ZrQC5D8h39fapRdEDGz9ahVl2/eH50v8Q9Ky5blJKxejfdkkdRRJIUIAFNhZem4fnRMCxG0Z47Vk1oCRLHOpwO/pmpfM9qpqrhwSp6+lTqTnk1zzVmJpInByM0UwsOMN29advUc5B9qizELRRvDdgKMg9DTTa2AfC5VjkZ4708yZDNt6VFhh0Bo+f3rSEnzAPJQDO8VFPKuwgN2pj7gpzmoLiXYhHevUoN3JcVYyPEVwBAxHUDH51574liBlEeT94f4123iKfCYA7VwuvyvJNgE5xx9a+4yNJ14rzX5nlYhvldz6hlUKiAf8+4H6VseDv8Aj6LA4y8X/o1axLqbYFRjg+WoGfoK2fCDEXGRyPPhHH/XQf4V/UWDilhYr0Pnal3NnrXh1iuj5POFq0spGPb3rM8O3WNICluoxgmrH2ggfNkfWvuqelONuxyNvmdzSifcMhjUyMNozJis2K66bW+uKmF0CcFv1rZbAaSMpGSxqxCAACnPPNZySYwQ2Rmp0nlC5RwBjB5pgXhhskSfhT4lAJLP9M1Sg+U7sDNWfNDJktgigCwWBbcKUSY/hqpFdlQVxnHelN2zj5APrQBZdtxzjFCnbVWGeYklwevYVYVlbgEZ7jNAD/MXvxQXB6fnTVGXGRkUi4xmgBwYg880+OTPGKj3AKSBnjilMpEYwmDj0oAmEm442ilBYHKrmo1mHBwPripo3Vx8oH4UAOQ7iSw/CpbZgZgAMU1FB4C8+wqSGMmTAGCKALCcMSfXpTmIboMUFGVMYOaRQdh3Dn3oAckhQYApfMyenemU+NeCWXtwSKAH53jb+tKGUHZnketJGCTkDtSSJuJBX9KAPuOiiiswCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPxGudigkGqbu2cqcCh7ppON36VG7Njr3oNBxlBXrzio5Gfj94PzqJ3QY4+vNQzTgEY9RQBZ3P/z0H51GzkyffAqu9xgZHqajFxvY7u1C0B7Ft5QpwTn6Un2lcYKVX8zP3TSq5BBbp3puSZmTrNG3enK5ZsK/FV3njH3VH50gnAOQKQFsEqcg05GLdTUImUruPB9KdFMu6gC1CShFXbd3PFZwnGeKuWc4J5NAGnb794DNx6VdjIxjBOehFZsc0hkwqcetaNtJtwG6ZFAF+1MoTYSenGazfiGpbQ4M8E3KDn2rVt5UwOKyviExfSbQE8G6FZ1Xam/Qcdw1g5D/APXNh+tc/qjg+GdRbHSwlH/jhrf1cnMg/wBlv51zesuyeFdT29rCU/8Ajpr86zf/AHOfzO+jueDWX7tY1PZAP510/htSyZFcxFwFI9h/Oun8NMR8o6YNfyXmC0fqz6jCK0bHR2xKYPoKeSzHJqG3YliD2FTV89Lc747E0TAqFzTJCVfKt+VMyVBINKBuXeetSMUSeuc0yb+EelNLMCeaZJcZfmmlcAlIVeTVWVlJAJ471LcSoV5qnKTkYraF7EPcllYBQIzjn1qtcOAMs2eKZLKVHJqvLcB/lY/lXTTWupMthSxZslhimSygfKDUYkReRUTOjklv510xhFogeXBGDSKwXrUbTKoIHao2usd/0rRJgTOzFvlfA9KTzU9artcBjk0/zx6D8qfJICXzU9aVXUsKh88eg/KjzlPtRySAtZHqKC4Bqr5if89RSG6VTt89Pxo5WBa3j0NG8ehqst0rHHnL+FL9oH/PVaVmBOD82QaUu4/jquZWIxmljk253UrMCykjkfeNOEzqcljzUKTKF4pyyIx5FRKLkBbgkycsatwuEwc54rOiYM2R24qZZWjO4DOO1Yy00KTRfNwB/AaljkBQHBqpDcZ+8mKnEqggAdqxlB2KLUbjA4NWFYFRzVKOUEACpg64G4dq55bgTneRhmyPrVjTxt3cfrVUOccGpILlos89fasXqi3qi+3U0DBOARVdLsyPsJ6j0p4UDoKzkrEtWJSMGlU4OabHycGhiQMiotcRJvHoaUMMjBqDe2cZp20Zzij2aAnLuBkyfrSea39/9ahfp+NMpez7ATyTKwJwaqXUgweDUoYngntVW9YjgHtXfSny6iexzviSUlhk8AVxeqSo92FB/wCWyf8AoVdX4jmfdJk8KPSuG1K5ZtSEC951A/MV9nkNSX1iPqvzPLxfws+qdUcedEP9la2/CDnzML2uYf8A0I1gajkTop/hcLW94XAjkdl7XEWP/HjX9WYH/do/I+enpI9D0O62aeme7mrxufNOAfrWPpTgWShuzHFW4pxk19vR/hI45bmpHLtGVPX0qWGQM2SazYbs7tuas+cAflrdbEmrHIw4J+XtUkU7MdhbvWe94y26oTyBxSw3bHa5PPSmBsC52fx9OwpRdGTgZ/Gs8TMh8wDOOcGrMdxvALIBQBajkKcMRThctv2nG3HaqzhnYuDxSZOMZoAuC4JOFIFSidYk3Z57nNZ6synINOW4+bBoAvx325wN3HfNSG7gQbGcZ9M1mySbsMvBFOaRfNC4yf60AX0uoy3B4A6VMZkIBB7VmPKpXiLbjgnPepomDRgj0oAvQuAMjBp/nlSCE/KqocqwSLGfc1JG1xzkgfSgC5bzOxJHHfmrUKhv3rSckdqoQOyjJPY5qykg8kbfX+lAFuKRt3l+Zz9acJGI3Fsiq9uA0oJqZQPu9s0ASxjzDgVKrDYM/Q0yIBRkDtQeYOe5oABIVkKq35VKCSMk1XXah3YqxC0LRjfJhj92gD7gooorMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8NXdQMZqKSXaMA0xWGMB8n3qO4fA5b8qjmZoJcXGwKG79KrSTsDk0s0hC8jPHFV5ZiRjaKOZgSi5z3qJrgM+T0qMORSUXYE63EYHJP5VMs0e0Hk8elUqUFsjDEUJ2FyourLE33Rj1pd6+tVYmEZJLcnuaGcs2Qfyo5mHKi4rqPmJ4qa3mT361ThywwT2qeEAHA9aOZhZFtHVn4NXbQ5zWdH1q7ZkrnnNHMw5UacEiLhSe9XbSSNSNh5+lZsRycn1q7Z/fH0o5mHKjWtJWLBT0xnrWZ8QyG0u0RepvF/nWhbMVdcdxWZ49fNlaAjj7ao/Ws68n7GTGoq4/XAQZGPTax/WsDWnVfCepZP/LhL/6Ca3tck3JKR2ib/wBCNc7rTl/COosR/wAw6U/kma/O85bjgqluzf5nbSXvHhdvwIz6gfpXS6B8pDnpmuYhcDylPQLXR6JOuPLXqOa/k3Gpyv8AefUYWzZ0duQEwT2qYyLgDmqdmSxyTVk7v4RmvnpJqWp23jEfvHoaVGGwr3JzUJkUcN170jSLjg0kruwc8eg+RlQ/MarTHDZWmyysxwGH4mo5GD8qxraNO24czG3Dnhn7CqjT4YkdM0txKzjYagd1RcZ7V1QiuVIl6hLdq2cE9KqvOxYmiWVVyfaqcs4Lk5rqjBX0IbuOlmYtgCmNMy9eKZLIhBOagacA8n863jTTWoiZnByc81G0zL94VXaZdx+bv60GRW+635mt1TAn+0+9H2n3qs0wU4LCmfa0p8j7AXPtPvR9p96p/a0oF2hOKOR9gLn2n3o89TyTVZZlPcUvmp60ezYFtbhCcIead5zVS81R0NHmk/dNL2bAufaDnFOSYlsHpVIYzkOc0pmaNhjvSlSbQGkrpnarU4MVORVGKfqScU9ZwTgvWLpNAacE5b5R1qV5mVOe1Z1tKFy4bpU6TCQZYms5U2Nbmha3PzDmrhlVhvzWTDLk/KelWlkAABeuaUGo6lmnAwVPMJ4xU8UisuQaoQT/ALvyx+tW7blMVxSirgW+tOj71EHIGKfG554FYtJIpO5JGCG+pqeMFXy1Vg5zUiMQ3WocUwkWtyhsk9hTndQpOagZzxwOlKoAOWJx71nyq5JJFIrcins68nNRB41GARUZ+Z8bjgmr5UBOZFYYFJTYoljJJc9O9OOM8HinyoBSNh+aqWpMvr0qWaZ85qldy7kbceeorSn8SQpbHMeJpkUOxPuOK4UuZvE1qCOGvIxx7yKBXX+K7gbWH+x/WuMs5lk8UWSd21C3A/7+pX3GRQSrw9UeTi2+U+rtTlLXO1T/AMtOPpW74bkEZdyfvXEQH5N/hXMak5N9kHjdW7oT5iYoxJW7iAH4PX9U4H/dY/I+fnrI7yxudtkgJ5JNWbZ5FJBHvWJa3ZS2UZ+6f8Ksfb7hoyofGeh9K+6hFRjZdDknubC3WMMc9fSrUV2GT5TWEt5IzKJDwKtWt6c7c1qtiTat75mPzfezg1YeVAAzHtWOt4hAcHLDgmporgsfmfNMDUjut65U+3Sp47gkYDEfQVmfbpYxvwNmMAYqa31AE5UgfWgDQE8m7ZyfcmpBdSq2xTx9api8XdknOe9KJUZ/mf8AKpbYGgNRCjDRile7XZu2YrPM0SZJY4z1NOEqsPlbqOBTTuBfE3nKEVyDTo23OHEpwDzWd9sKxhiDnPGKlhuuuM4PrTA0VljyV3c5zUiSJtJ3DisszOzZ3gfjU8DrEDJI24Y7UAX2mdnxEefXNTW93IgIds1RjUsqyRMcN1FTKwVcA5PvQBfjvkRMunU5yKuQ3GQp2Fu9ZdmBIT5rAegqeKWeN/L83KE8c0Aa4uRIV8sAY71YjkbeN3A+tZcbrEMBsVZWVWGWOcGgC+JEbo3epAwK46cd6pwFF+4OSc1YidmbEo78UAP2N6U5QQMGlooA+5KKKKzAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/CmQDqBx7VG7QlCW54qbJVSAO1VLmUqNrKOnaszQrST5AVCcd91RknuaMZ49acUz3pXsBExO7rSoWLYyaWSPByDmmkiNipbBHahtAPp6gYHFNAUjIanblVc59qi7AbNnAxSRkj7xNPIDgEGkZNozmqTVgJbeU9DxViFiW4b9aoLvz9+rEDSeYMc1QGhCR61ZtWbeRuP51VhUgbuvHSrNqWLE7elAGnb81fscYyfWs+2OBux1HSr1rwAPXmgDSgYcHPTFZPj5s6da89b5CPpWlB3/AN2srx0wNlZJ0/0lefxFZ1taMl5DW5PrWBDMR/zyb/0I1zmuuI/CGqFjgDS5cfXZXRayD5FwPRG59fmNcv4qmEfgbVZtvTTZTj/gB/wr87zpN4Gp/hf6nbS+M8MSYSCPB7f0rotB4IPfHJrkraRiI3D9h/Kum0Cc4LZ7V/K+LpOLPpsI7SOmtLjauTxU4uifut+RrPhnVhtp5wf4v1r5+VJylc7XZssvdLuOSM570yS5BXCjP0qDzYRwVz70jzR7fkGDVRo6hy2VxWZVXezDOehqEzyL1cAegqGabj71QvKxO4EfTNaqm4k3Q+a4bdxVee4A+8aZPN3D9OtVLifcRk1004Nol1GnYdNdKTgEVA86A5IFRSzKvNVZroMfl4/GuynT5Vcm6JpbnnhuKhkvEXjAzUElwv3R+dVpJCzZD4rojBslyVy014MH5P0qN7s9o/0qrLMYyAXzmmNcnBy1bKkL2jLX2ljyBUX2ge1VVvMnbk/nSfa29quNIPaMt/aB7UouQOQap/a29qPtbe1V7IPaMvR3Z5+c/nT/ALU394/nWet6y+n50v20nnP60vZBzF5rp/7xHPrT1unI+Vs/jWct3uOCf1p4vFTjJH0FS6Woc7RfF6QfvnPsalF2JNu5sY9azI5lc5DY96k3EnIkBxU+zQ1LU1VuFzgEGnmfpgDr2rNjmKjJYU9LokZyaiVNFc0TWinAWp4JxisqO4LcbiKtxOSmA9YThFdRX1NWKbI+Qc+1T27khi557Amsu2mYEirSTsHCkcGuKcdWVzOJrafIig7zk9quxTOFPHOOCKyrVzu49KvQSORjfiuKcdC1Udi9azF1w35mpgfQ1UgPl8H061YVwoznrXLJNbiTdyQMQQcnrUqSFjjGKrrKCc46VIsgYZVsVk4tlFhZgow3P1p3mkjO3j6VUabacHn3p63BVcMM0/Zq1wLG8N2AoUjcMEZzUcIM3K4H1NPeFo/mzUWYDpmkCjLd+xqPzJP75/OmPcHo2TSeeP7ppAOnJ55PeqV2+2NtwzxVia4GM7ap3soMRGOtbQ+JCexxfjC4AJA6kVx2mzk+MNMVR11S3x7/AL1a6rxayvKAD2rkdG+bxtowHfVbcf8AkZa+9yOLdaFu6PJxfws+rbqVDdOSwH744GfetnR7kopRO94vI/3ZK5q9laW8EWNoM+M/U1v6U6IAQwObwLx/uyV/UWD0w8b+R8+9zrrOYNbnK5IHf6CpbW4ZiVZlxjjJ6VmpMwhDI2MkZH4Uq3O0lAea+7Ssv67HJLc2VmUEKSCKsx3kabSUHHU4rDhviDiQ/SrKXW4AhuPrVrYk2E1G1hXcVxvbIzUw1BMAou2seO4jkf51+XPynPSpxdIW2Y6e9MDbtbkuBubK+/Spo5gZRvXI9xWIly7J5YYgd8VahumRNpPTpUyA1o3y24Hj0qaKcFvnzjFZtpeK3DNT2ucyYWUAVI7M0JZ7ZvkaQrx3FOF1DtxFKxx3C1mu4ADM4P8ASnRS44WXj0pO4WZpi5yoHmf+O06O5GT8/P8Au1lm4UKDIzdegqVJwilg3Apq9gszRRwzjgAA81KszK2xSceorLS+Vp/s4DMxXIGKniuwwCqTkj7oHSqTCzNlbt1h8uFwGHTng1LbyuY1kckkHn3rJtJ2eIluCasLdOFCDjA607oRrLPEWJCnLHt2qzA4QbmP0rJtr1yo8zHA4xVuCcOoJNMDSt53aTDDdnpV0SqCEIAyfSssSmPGzt3q3a3CM5+bAAPA7mgC4NRitJ4IHt5XNwzBJEhLJGVGcsw4T23cE8VoRTrKvnhU4bjaDzWPA0zs43KieYTGF6496uwzhCAx3c457CgDSS43nHl/pT3DGPIXB3Dt2qrEzP8AMg/GpvMYxnB6UAfc9FFFZgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfhOzttPNVbvzGYbVzxVokB2Y9DVZ1YOWxxiszQq4xLtI7dKfSCFy2QOh5ppKyAsGxtPp1qZANnYoSynBqJACxV+TjOc1JtEpy64p0kSAEk9TUgMjUEHPrTjExXg8U6FVVTt9aduGcZoAZbhwDvP0qR/ufhTZO1L1jAFADUAJqaB5FkARcimdKltxxuHXr+FaAXYHcc5wcelXLV8Eg9T0qjAwbAzyauwoe1AGhbbsMG7VetifIL9wODVGzUhSD3q3FIdoh7ZoA07MBowx6kc1j+PhiysyOv2pf51swSFYlAPTk1gfEKYrZ2KofvXQP61nV+CXoxrc0da/1Mo9UbP/fRrj/GhI8A6wo/6BNx+e011Wry5jk3doGP/jxrkfHDbPh5rHP/ADCpiP8Avk1+e5z/AMi6f+FndQjzTPALSYxqik8hR/Kun8Pv5g9q4+xAk2F5Mnavauo0VhDGSnWv5fxy9659FhpanRwuOg6/WpN7etUIrmVsEjipTM4ODivBdN30O5O5b3R7clefrUEtwFzio2uvlA6kdRVe4lc/MDgelEINu5LchZrk4zmoJbnBwDTZrtwuARVWScueDXVGm7XETy3AZeaqXE4xwecVDM7kE/1qnLMx6dq66NLTYh7k8s67SD1781Umcn5gaa87BSSaqvcMTuB4rpjDS1hEgucnk1DLcAZIqOV88rVdiSSzetdMIxaJluSzTyEBi3FRPOzKdpqNpiQUz7dKhMwjyAetdCp+QtCYT7Tknmje3rVRrg56/pSfav8AbFWoPsIub29aN5HJNU/tX+2Kd9sBXbv/ACquR9gLXnLR5hPI6VVW6K9XJ+opftnv+lRyPsPQuCVB0FL5w9T+dUhd5/i/SnC4J6MKXI+waF2K465JqSO5wcZqlDc9s083Lev6VDpO2waGiLjHAK/ieakjmJUBW7+tZqXLbR/hT0uTnqOnpWcqXkI2Infbncc1ZgvJMYD8/SsW2ujnaxGM+lXIW2DcCCBXNVp26FKRtW1w4J3t19qtxXOZMselYsFyOOauW1zsznueK4pwV3oW3c6Gzk3jevAxxVhLgq+0mq1kA1iJs0i3HXaeM+lcFSCbsUtjXgmEnys2PeplwTjdnisiC5zxV23k3dT2riqQlzFLcuklQQppqylSATxQjq2ADSs6pnJrJwkiyUMG5FOViTgmq6OCSAD+VPVipyKTjoBYDsv3WIpTLIeS5qv5z+1Kr8g55zUcoEpJPWimSSyAc460zz3/AMiocdQFlY/dzxmqepcRE+gqW4mVPmB71n6jM3l7scGuijBuoiZ/Ccb4qnCXAHoMVznhHZdfEbQ4GGR/a8GB/wBtFP8AStzxTcbp3HrgVg+ACR8T9CKnn+2IcfnX6DkivWh6r8zyMV8LPqCaVH1CG3A5a8UH8619NIhaJT1N/wCv+w/+Nc/duq6nbsvXz1Jrb0qTzprV5e98+OP9g1/TeH/gw+R4Mtzp3kPlx7eOBmmGcLMVHYUyeYpGMdQarySSSfMB15r7t/19xyT+I0ElKj94QT9KlS5+Uf4VnwGQLn5fxqVJ5gABj8Ka2JNEXQY5c5A5qaK7DthTzWUGkB/1hqVJ8sFUYY9DTK5TdguDt59KkN4WIG6siC5lBKORx15qSG7ZCMUmrhymzBKFJfzce2Kl+0q5yh59c1mpctKSWPGOKkinVRw2DjvS5TTl0NJLl9pDtnNLHKfMyrHaO1Z8dxuYsHHFL55JzvFSSa5nTbvf8cGmHUEcECQjPbFUkuNi7i3HtTY353sO/IoA1YLqQHcZOwGanjmjRw/2kkAYrHhk2OSDjJ6VYjuvmxmgT2Na3vZVlYs/AHpViLUVeQRN3OaxUuZVkIA+XHJq8roYoyG5fkCgg2IHLORu4q7BLEoCCTJHasS1vGUiP3xVyOV9wPvWgG0JnIyOParUF6cKBEA2fmOKy1unEaxiLcT0qxbToGZsZ6cEUAa0MqvKRv2k8k1Zt2tpcsZM+hrKt5yDvDkn+6fSrdvchukQ/GgDXhnIj8uNSR65qaDekW0jGeorPhnbj5vwqf7VIvAoA+96KKKzAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/CZuhqJ2b7obH0qZuh+lQP941maDJEBUnJ6VXMak5yR9KtHGOaY4TsBUy3AhKClp77duBjNMqQDAHQUu7jGBSUUANk7UsXzcGkk7U6Hr+NWkrALEglyGP5VYhjCLgE9MVDbdW+tWI+n40wJIEA5BPSrtsxQ4HOfWqlugzkt+GasqxQg460AaVq5JxVqMhZAT61n2s+AGP51aSQyEEDjPUUAaqsXUbHAJGOa5rx5cSGDT1IGRcD/AOvWwkrKy7fxOaw/H0iq1hFnkXOceuSKxr3VKVuzGviNjXDsjlx/zydfw3f/AF65Hx3Iv/Cu9X5/5hco/wDHf/r10mt3edOkcNkm3OD6nNcl8RJzD8ONal28DSHOfT5TXwObU5Sy+p/hO/D6VD58tZG8uMjjKit/Qr3apL9a5KPVFWCIqRwgzirdnrZDja/61/NOJwzm2j2ac3Bnd2+pxgjMmRU51WNjlQPfmuNtddVPvvz6Zqb/AISJR9wn3ya8z6nI7o1lY6WTUAWLZH51FJqQxg/pXPt4kGDkDpUT+JBjgCqjgpXG6qsb0l5GxxuI+tQvertO3H51iN4liz86kmq83iFWkJVwF9e1dEcJIj2pszX3ykN3qo88eCdx/OsuTW1bd86kduaryax02kYJ9a6I4WUXowdWJqSXSsCoP61XMwxtJrMm1YjO307GqzaoxJJYj8a3hhnfUTqo1ZLyNejfnVZ78ZIyPzrNbUgPvH86ry6iP4a6Y4ddifaGjJenLYI71Cbkk5L1nHVGHBT9aY+p7ui4roVFmbqO2hpGYE53mmfaB7Vn/wBqSDgbce6nNJ/aAHOAfbNWqLXQjnmaP2ge1OMyhc5rN+3luQmKPtxPyk4/Gn7PyDnmaBu0X78hFH2vPKbiPWs8XZPCnOPel+1uOM/rUeyfYr2xox3XzfOCB71IJlYZVyPpistbsg7S2R6k05bs4+U/rSdFvoHtjVS6KdGz9act2T3H51k/bHHQ5/GnR3snPB/KpdF2Gqyua8d427Bxge9Wo72PqSM1hC97k4PeporxdvDfrWUqLL9qmbsNyrtkGrUVwQvWudh1Aq2A361ci1RduN/61jOg2NSbZ0EF0o+830q1HdjjB4+tc/BqIb0P1q2mqRDA3HI9DXBPDNyNIyXU9CsGT+xwxY9KpLdqOp7+tZuneIsaX5Oe3rVeHUxnlx16ZrzVhJc7uWqi7HQw3iK4Aar8VzGVDbz+dcwmognIYVeh1MFAA4/OsqmGvIcZWZ0ltdpwS35VIblGY4bPFYFvqYGPmH51bi1FSOCM1ySw8ovUvnuakV4wbAxU0V15nOAPY1inUYlPOc+xoj1N3cKwwPXNYuhK4KRu+cu0kOuewponbHIGfaswX0WOXFA1Fs8Nxn1qHQfYv2kTWSR5MgAcDuaikkmDYH6GqI1AtxuH50yS64zkD8an2D7EupEvTIQm984+tZmp3QWPYMHHNSPdtt5bj61majdAJuIBGeprahScZrQznUTicn4puB5jDIyTVD4bx/aPi3oBH3RqkX86f4qvo9xAwDz2qP4QSmb4s6BGDknUgQPojH+ma/QMip3xVJNdUeViHeLPpG52vrFtGDw8ykn8a1bV5DcWSRgc3khP4RA/1rJUh9Yt8HOJRj8zWvpzKt/ZKWAPnXBx9I0r+lsNFOnBeaPAm3dnQ/8ALInOc+tRBcfxGklmUJgSdPeoRcNkf419r3/roY2LJmdBtXHNPgkDAbifwqsZ1P3iB+NMNztb5CPrmhXFZF9ZVJwWP51IhB+ZWPBqhHc5OQuc8VZimKLyOpzzVjLIlZSSW69aswTfL8vb1qkWBXrUkcvljCnr70AacMzMM+tSCRNoYnPPc1QjnIQfPg+mafFOd2GYEemal3HdmnG8TL0xjnjvSCaMnlCPeqy3W0YCj8KV5dxCkYzUiLonj2YjYD2NKbo5JOAT121S3AfMOcU4XORjyRn60AXo5wMNuqaOYB8k8VnR3DMAoTn6VMJWDKrL17UAay3HmFUVzhTk+9WYnZkV8fMrZA9BWTbXCs5CnH0q0l55a5V8596AsjYhmVcNuyevNW01DABKZwc5FYlveDjcc57VbikO4Kj5UnOM9K0QmlY6GG9DIsyHGOw61PHco20IfmHUVjWU8kTHcwCjru/pV22lUfMrAk+9BBtQuVwQB0q1C+xMkZycc9qzLS4fYS/b1NW47htqtjIJ9etAWZowToyjY3zZ5FW45RsG481n209u3CxBD3OetWFkjI2s4HvmgdmfoPRRRWYgooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8J26H6VA/wB41ZZVweKgkUByMdqzNBjdD9KjpFeQkA9CeeKeyE/d4qZAMKZOc00qRyRUoQAfN+dC/OdrcjFSBDRUjIoOAKZgbse9ADJO1LEcc1IY0PUU0xMD8jYFUmkgHWw5J9asRdfxqGBQO3pU4AXBApp3AlUleRUysWXntUCYOM1MjhfvDNMCzFKqw7TU9rdfLtDmqIIPIGKmWV9o+b9KANAT7erZyKwPHVwZb/T2H8VyP/QhWiJzj5+TWB4quS+saXG33Tdcj8RU1FelL0Y0tTd1mdWh2r937OR+OTXOeM4Z9Q+HOrabBE0s02mypHGgyWODgAdyc1sa1KselEqMERr/ADNU4LjEAcHDYHNfL4vCuthZ0/5lY6YVFF3PlifQ/FNuBHL4U1SNlADq9i/H5A1EkOtwP/yBL8+oFnJ/hX1XLcz8Ynbkc4amfaJh0kNfnM/Dyi3dVX9x2fWp9z5W+26mpz/Zt4Mdd9q4/pUcmszlfMMcwQdyhH6EV9XG7uHG2SZiPQmoZpEkfdJbox/2ogf5iuap4fxg7e0/AqOJvufKZ8QDGPOIB6FlNMfW1YcXa/hmvqS7gtJWJaxt/wDwHT/CqUtraAkGwtnHpJApH8q5nwFJPSp+A/rM+58z/wBtoFz9rT8XH9aifXI1G4zgj/fH+NfSzaZpLnL6Hp59zaof6VSufD3ht+H8LaeR3Bso/wDChcDV1tUX3FLEvqfOZ1+3kU7J0OOuWpH1iARBvPGRzw/Fe+3PhPwg5Jk8J6aP+3NP8KqSeC/BEmd/hHTznr/oq/4UnwZio6c6+7/gA69zwg61u+YTDnjG+o31dU6ybvcV7bd/D7wCeT4RsP8AvwKpS/Dj4fMuT4RsvwjP+NQ+EMZb4k/v/wAhqukeOSakCcgtj1Kmomvsnk/pXrM/w3+HxPHh2HP+yWz/ADqjP8MPh5kt/YOD/wBdX/8Aiqn/AFRxy2t+P+RSr3PMW1RRlcn0ph1RB1J/OvSpfhl4BC/LojjjteN/jVc/C7wExPmWVwM/dC3R4pf6q4/+VfeX7XQ88/tZM4AalW8RDu3D8GzXdzfC3wWh/dRXQHobpv8ACoZPhl4NY/IbpPb7QD/Sh8K5h/IL2xxg1RF43E/jQL6NmyWxk/3q7EfC3wcfvT33/AJ1/wDiaR/hP4UKkx3uoA/wkyqcfpUPhfMV9gPbLqci2oCMfK+7NJ9uL/Nuxmur/wCFTaCP+Ype/wDjv+FJJ8KdCUcazfD2Cx4/U1lLhrNYr+GHtYHKfbn9acl8+Oveulb4U6cB+78QzMfQxJ/Sk/4VTEfueIJAPQ24P9aj/V3Mk/gD2sDnlviDnf8ApTjqDdpMVvn4TJ1PiRvoYV/lmmv8JQ3+q8TY9c2ZP8mqP9XMz/kH7Sn3MIage71LHf443Z+ta4+EcmePFSfjZN/jTx8Jbgfd8TxZ/wBq0b/Gs5cPZit4B7TsZMepbX5b8qlXVNoOGPtWrH8G9ZceZH4itcepgYf1NTL8FfEEi/L4ksc9t0TiofD2Pf8Ay7Ye30sZMGrvkAOR9TU6600ZzuyT3zWjF8EPFYbjXdNx6/P/AIVMfgb4ufprmmkf8D/wrKXDeYxWtJiVdx2ZVtvE0yJsEpxj+9ViDxExOd56+tWbf4EeNZBmHVNMIHHMrDn8qnX4BfEZPuX+kj/t4b/4muOXDeNvrSZX1qXcih8S8ff/AFqxF4nZyAJcY96ePgB8R8fJJpef+vtv/iafF8A/iYg+9pf/AIFn/wCJrB8M41/8u2V9bl3CPxUY2+Zh165q3b+MFxgTE/Q1FH8BPigwOLfTH/7f8f8AstOX4CfFVfu2enDHpqQ/+JrCpwxjL60mH1yXcmk8WkNgSHn1apD4uMYEnm59t1VW+A/xYkIYaVZMR/d1RcfqKWX4FfGCMfLoVo2OgGpIaxfC2Mf/AC6YfXJdyyPGu7/loBTh42XoZD+BqiPgl8Yl6+Gbf8L1KRfgr8XyTnwlGcd1vo8/hS/1Wxv/AD5f3D+ty7mg3jROMSv19Kc/jJSgzM1Zr/Bn4wLgt4QIHY/bUNJ/wp/4wEY/4RQ4/wCvuP8Axo/1Wxv/AD5f3EvFSb3NB/GgKkbn/wC+iap3Xi5JIShkb8TUEnwo+MKfKfAtyx9Y5UP/ALNUE/wl+MTL8vw+vm+jp/jRHhnGJ39i/uIliJSVrmPrOp/apCN2c5wc9a1fgW5m+MGgPnG26d8ewieqs3wg+MRYN/wrm/z2IaM4/wDHq6j4H/Cj4jaP8R7DXNf8L3NjbWauzTXAUDlGXAwTzlq+iybJ8bTxtPmptJMzc092e7W//IagHYScH1rVsjnUrBvVrk/+OpWUwMet28aEN8/QDpx0rWtwE1HTwoxxdH/0WK/oHD0rcr9DyJq0mjXlGQf96oVkyoOO1PmdghIP8VQBiBgGvp90kZEjNu7UlIhJzk0tNaICWBicRjqT1q0H52MeaooWDgocGrMUcjSCVid3rTAuwsJOOmKVCd+MdO9Rw/KME/WpAzAgL+PFAFg47GnRffqIFgQKntgDJ83pQwLEYBIyccChg7P8rYpNozmlBIORU8rAcokXrJSqwU5Jyab5hHXmmmMsd/apegE3mKwwDipbOUDKuef4TVUbUO7FPSVS4kZenSmlcC7BKY2Kkct0q3byRqmJSMk8ZrL+0O7iXPQ+lTCQzKNxzg8U+Vga8AfO5V46jmr1vPKEEhIODjGKyIrpkcB34Iq7Bd/Jt3DBqgZr28qqQWB2nkgmrltMucqo9qyEmaRBhuPardvcYIYHpQTys2YbkgAE9eoq3b3AgwzHKkE49DWTbzNKNrNxjkVbtWMcW1T8oB4oGtEbFtJ5mHjPX3q5BtmyokGR2rCR3jkEqsQuORV7T5VQeakp+b+GgZ+j9FFFZmYUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+Ez/dNRP1/CpZOOKifr+FZmggQkZpfLbrxQrngUrOVGB3qZARSoWGBSxoQSfanhGb5gOtIvf6VIEb/eNIOTilf7xpyICMmgBNh9RRsPqKl8tcZyaNg9TQAiIQACRTzxgZqN3YHApgmcZHFOO4Ez4QZZhTluFI/dsD61SkuyxKtilhuVTOAKsDRRsoGLjP1pDcMO4rPe+lGQuMULdO4+c4+lAF/wC0t/kVheJbnPiDSgD1uM/qK0Fu1QYJ/M1ia7MH8R6SSf8Alv6/7Qqaj9xlROj1y4DacwPaJaoRXEa2qqc5K1Y1l0Ns8ZPHkr/Ws5pFWFQD/DXmqnzRKLSyKU4o84rwD+dUxMQMMeKRrgA4DfrWfs4E80i15gJ5/WmyOoGdw/CqbTMBkmkEpcEbqTpLogU5IfLMhY4zVYuPMPB6f1p7dTULsVc4TPtmp9nDsac0iOWVQxJB60y4mjYFVUZIqRhu4ZMe2aqSuQ2RGB75o9iuwc0iGbr+NVpXGOnQVZkORk+tVJun4VnLDpvYfPIrTOMdD0qrKQ3AqeeoG+8an6tFdBqo76lWcFeQwqjc/OeZMfSrV2HVCSaouXJwBR9XNFVSK08bH8feohFtPz/oasTccelRSYwOcfhWbwkHtEftiJ9ob5U/GoqnKAnOai8sf3wfpU/U11QvaoYWAODSea3TtRMArYHpTaf1WCWwe1Q7ePU0yZhjqaWn22nXd/IyxqAgH3jwPzrJ4ZJbDVS+xCsqMcAk0PciM7dw6Ut1qXgbRHaHV9eLTrwYLSPzMfU9qzrr4n+ALIESaFfFR0kIXn8Kw9invG5absaPnIec5z6U9SuMlsVkWfxK+FWrOIv7flsHY4VbqIKM/XNbVxpc8dul1autxC4yk0EgZSPwojQjzfCNystBFI4If9amhlO/5/TtVGFnJCspHPepwxP4c1usNfZC9q1uX4nKnIPFWrS5ZOjAH1NZ8MirGN3U1PC4I5HGKpYWP8upzymm2bFvdyPwZFI9qsxSMWJUjFZNvIqMAOM1fgdf7x/OqWCi94kczNSymkQHHJJ7VfguGJywINZFvKo5PP1NXYJ1HAA/On9UjHRIpVJJWNa3nRiAQQPUGrluwB+Rjz6msiG4BFXbWZiQAaf1KHYftZmrHIxYHf0PPWrSEydAcY7tWbDOw6gVdt7gY7dKTwcF0H7WZbiQBMECpYnCDAHP0qCKZWTJNPSVNw5p/U4WvYTqzaLAdn61Mg4ByKrRypzzTxMo/i/WmsKn0IuyyCT/AKvbn3WnKxAw4GfZajgkB5FOJyc0/qkexSvYecAZIprtkYVR+NBckYpKI4OF9iJSklcYFkyNypj2JqRCFzxSUVtHB01sjP2syIH/AInNuf8AazWrE4bVNOAz80Vyw+mYxWUAP7Ut2/3v5VqIPL1XTNv/AD73Q5/66IP6V0KCgo27lxfNe/Y0bhgyED+/ULOI8K1SS/cB9Xpslu0oDLngV7V7WMeZjlOF3HoaXePQ0jKViANNqlqilqiTuD6Grlq6umAe/eqiAMMmpbcEPtDgD3pjLVWICw+7681CIsDJcGpYmKggUATAlnyfWrCKdgb3FVkOPmqe3JJz7dKAJ94AA9qeEJFRxRkPufrU9ACKpXrS7UPXOaeY1wDk80x1cZ2ioe4DHUoMnn6UI4A5BoUSE8jNOZMLkjBpx3AIwUOWqaLBO4fhUSguvvU0alV5qgLK7XjB6kdQe9XIPmRcQ9BWbEWJKA4yau2EhETF5DkcCgDRt5ygZQuOOlXbaRTgZrNgbdyDnPrVq0JZwu7HvQBqwOq9T2q5BcZO33rNjyn8QPFXYCmzdnnNAGkjZQqpHNW7YLgIpAI71mxuygYPerUMrqA4PNAH6V0UUVmZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH4UTgeneosA9RU04zUGfm24rM3ew1FIJLDjPFOdScYFKw6ijPGKmRAgbYoBOKSPHJ7YpXTeMZxQq7VK56ipAAFILADGaYx5yoob5Bs3/AKU0Pjg/nQA4yN/FxTJLpl+VVJx3odlxnPSq014kZIz+GKAJTNJ3X9aje4YHgVG17GRgKarz3WH4OOKcdwLLzfKfkFMNwF6gCqz3R6bjzUL3jA4B/OrAvi43DIApGuSPlAFUvtZCAk9aY12Qd2aALpuSDyKxtduGXxDpcgzgTqP1qy14WOcmsnXroHWNNJP/AC9J39xUz+Eun8aOt1mfZaTOxxlEx7dKzTO2duPfrT/EFyRZyJn+FRnPXpWebo7sk/wjisIp2ILvmP8A3B+dI0oz82Aaqfbj7/nSG9Yngj8arlAuqw3cc+1NaRwx2rVZJ2DZ3ZpTNLnKNj14qHGN9QHtNLk/L39aAS+dwx71E245ZpMn6UiSlc5Gc0uSC2C7JAQvBaoCFU/MB+VK0+GPy/rVaSRiN27GKQXZHcsY+3XpVSaRyOlTzOZFDE5qvN6ei5qvZqSuBWeRix+XtVaYk8mrDjgn2qvP3/GodJx1QFa4QeWRuJPoaqOu3PHerkoJGQKhaPg7hU2l1ApOBjkdahniJA7fSrkgUnAHTvUTxjjPNL2LAqeT/tmnbE/uj8qn8tP7tRMpUZHNHsSk7EE6JvHyjp6VE/khTvAA78VLOSGBI68UscRecRpHk8HNZShJMtSiQwx2kkMl3cyeXFEMuWNcp4j8canrWdO0iQ2dmnDBfvSj19q1PHmpO9yNJi+VQo8wKcZrBjtFc4ZRjsBWXJIcGk9TMj0+NmyFyM9O9SHTYwp2LgZrZt9Nt8f6rt61I2nxgbUiH481Si0inJHGax4ZF7GzLGM444rM8OePPFvwyvz9hufMtycTWk5JR19PY+h7V389giDaV6jsK5DxroKNA9zHGDg/Nx0rOVG8Sk9T03RfEmieNNFj8S+HZW2O4W4tXHNvIeoJ/l61bzjv1rxH4X+MpfAPitZ7mVv7NvHWHUI9uflJwsgHqp/rXt91C0V20ZYHYxXjocY5HtzVQbasZO9ySKQquCoP1qeCb5CGGKq78AcVKvC49q6I0upm9y7bNlBzyM1chmZTjJqhbHaCcVZilyc7e9aezctxGjb3DZFaNvMjgHd6VkWrbmC461et3xxjoafsANK3udhzjPtV+3uB1Q/XFZds6Ebifwq7BKg7daXs0BpwXb527fqasxXPGBWdBOrnBHSrMUqr83rxSdNLcL2NC2uiHwxq2V2Dcrkn0rMhdVO/NWVnycYA/Cmqcbi5kXUkbHC06JiW59elVEm5xuqxC6gZz0rT2SDmRbjkAPDY47VMjllzuNVUYY3CpEc7fv49qPZIOYtgEnApSCOoquszZ+9mpElJGSKHRVhNqw+jIzik3jFIXyQcdKn2LJGEH+1bb/gWfxFai4Otadnp9jnP/kUVkrJu1a3G3uO9a6rt1axbPTT5z+c4pzXuJeZcN36F6X/V/icU1GYIMMenrTz+8jHamAbRtz0r0kmgSsBJPU0UUUxj494Xkn86kj5+tRo2RtxTkba2MUAXLXcwwW/E1YEWZsrJ06j1qpBKqLuccE81bScGXtjHFAFkSIVxEoHrkVJZFlk34yMVDEoDbQc81NG2wkY7dKALSsXcn3qYFMc/yqvCc4PrirCpuGc0ASLgD5vwoKFuQOD3pwUKo3DNB3djx6UAR+WE5BoIB6ipAcn5k/WnbE2bygxQAwqMfKKFUkfM5HpT0jZzjpmiSKWNtpT6HNACKpBBH51JvkhIKqeT09abFuc7SuPxqdot7Lz09qALNrLcZ8xQAMdDVovI7BwpUZ5xVaEiPCjn3qaG4eFtxUUAadvIdoxk+tTxSlWyWPXOM1nw3THJ5A9qs208ZXcrYz60AasV7l1BFXIZwuN6nk8YNZSTJGykt1PpVj7WiZ8snJ6E9qAP0/ooorMzCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAPwocOQdwP5VEgG87vSrsrgruHfNVHBkfeOmO9Y8xu9hWVecCmEEdRT94zihlLdKTdyBmD6UMCATikeR4uOMUyWYtGQW/KkAyVTI2Sw9qiuJPs6gE555ps9wIgoyTzVe4kM7e2ec0ASSXalcIKrSzAjkc0jlYvuH65qGSdM7mNACyXQK4PrVee4TeOO3rTZJYzyHFQSOpkDZ7U47gTNPx905HSoZJwCMqcmojdBJeWqGe7G8c+tWBaNxxtLAY7EU17hSOB+tVZLxl/hUiojdgdFA+lAFzz1/u1h+K7zy5La6TI8qZWzjpg1dlvMjGDWZ4kRb3S5EMgBPPvipkr6Di+WVzsPEjZtdyH5Wj3DHb/IxWZbyrNaCc9SR1p1jd/wBq+FbC8DbyyBZWB6EcH9AKq2MysjxOckNkYHvWNN3i/IRc/dtwEx+NG1B1/nUXmY+7Sh93LEVoBKrYOVPNO8yX1P5VCr7TlSM07zn9qNAHl2zyaN5HU1EXkJzkUbnP3iKLIB0jNjKmq0k7FSpQ/lVlXAGKhcjdv7UWQFfORgKRj1qGZj5mM8basynPI9aqTff/AOAUAR8HOemKrTj5yAOKsOMiop1KjB9KAKrHDY7VXmdyxUnjPFTuMvgd81BKpJIx0PeiyAgIOeBTJAeOKmHAxTo0D5B9KhqyuBVwfSk8n/bFTyxmMkY49qhwfQ1KdwI5bVXIJIOKdpy+TPJK3IRSaeI2Iz71LYW6z+Yv94EVnNbjW5wF2Rf6hNIzfMJD1NPgsznAFTwx28eqTWk8KrLvJBPpVm3tpI3Py8E5GKwLGxWflLuYU9Y1x8q1YEiBsMufakdCo3+XtFAFCa2WViSOh6Vzniy3RNOnGAMjFdLeX8MeVGM9iDXIeML1v7PlQSAknjmhGq1Z51qsLkZblgMD3HpXuvgzUJ9X8C6LqM7fvJNMiDseSWTMbE+5KV4feK6oJHIOfU8V7T8OrWez8BaNZ3EZR1sA5U9g7M4/QihRV7kzVjYTIO12B5qwOFGfSo0g3EOTUrIRHnNdEehi9yxAygHLD86lic7vlPGaoR96t27hUGa3SsS3Y0LR2DA57VeiZguc9azrVgSDWhEQYwRTFzFiBnGOeDVuF2DLzxVKBwEQe9WkdimEOOaTSDmL1u+G+91NWkdsgBuKzo5hwCDmraybUGPWhJITdy6JygANWUkICt19cVmpcK3BBzVi2lYJgmnZCNCGVd2WXH1qYXBHCg1RScH5WNTxuVHJGPrQBo29wmz3+tSeevTbWejnO5asQSqep5oAuI4DAqwqzEwKZJHWqMTxEfLU3mEKFU+9AFrC59/rS1EJBkZqbhsEGgCFf+QtFjr5Zx+JrbIzrVsg/g0kHHu8pb/2WsSAFr951IzHH8v1rZRt2s3kg/5YpDAv/AUy36sPzqJq7SLjoi/GDsAx2prcMc+tEMzOQQcfWkm5fJ9a7VLmGFFFFUAq5zxTx94Gmp1/CnUAWlChRgZ9qlhEbznA6Dnmq1vKv3MGrUKKvzKevWgCwjMBwamSQqpzzxUKnJB96kyFIJ9aALtq25M+ijFWFZsYB7VWtWDJjP51YjOOfSgCdWyACaUZJwOtJGny78j7wA59TipYxhtskTElc8DrQAbPlyxzzTo0QfMoy1OtAGchhhQeFYc5qVkjViVTBoAhHmO485MVKGUds/SlEe87WU4NP8ownakROfagCNVXdkL1NSLGScJ1pfKGcFSDmpI42RskjpQAwRTL0b9KnjBkjxKcHsKAhIzTg4JxQBLaSJasQwDA1MghLFy/OM/jVWnb0ACkZz2FAGrEySqjgkYHbvVhJlLYCAj3qla53Lj/AL59KlLhZSD1xnFAH6m0UUVmZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH4XNym30FQlQvA7VNJNtOwKMHqaixuBKnOTXObvYYFzyOtDOqcN1qOV8YAPI6gUOxMfz4Bz3NBNmR3MhPI6VUnuTGpK8/U0+8kdB+6J3H1qjcMjn53+Y9MUCHSXDzAFlAx6U1pCASahLiEBAenJqvLeFpjAnIIzmgBZbtQ5Dn5e+Kpz3OfmyRTZ5yQY8ZwaryMJJDtoAma9tjGWzg+1Vpb0gbge1QqpXJI4qCS7UNhlHFXoBM9yzncx49qjLoTuLtTGuFK8KKY0pIwF/Ki6AlmnGM5NRC4UdzUT3AwI2+96UmWY7dgFMCWS5GMiql5cLK+cADGGwOlFxKobywhY4ppVwvPHFBSsXfh7fylr3wvMgI5mtCzY3E9VH6Gp5459MvS90u0Y2sM1zssl3ZXkWpWPyz27B4vRvVT7GuuuriHxDp0etW3llWOLiEn5kbHQ/wBKxceR6LQckuXQrLfNKwEQGPepi+7BB7VnxyGC48tvXj6VaVyw3ZxzVEE6MQwOafvPoKgXdndnj607f/tfrQBLvPoKGlYDIAqISAHlqVnVhhTQBIswx83X2qJ3O08CkLAHBNJMwP3Bn2FACFiRg1Wl5Yn0GKm37fvqV+tQs6byc96AIzyMUydQwyfSpGIJ4qOXpQBVMa+ZnJ4zUV1jkgYqb+PP1qOVGbouaAKY5GafESpJFOMLAZKdKTAHQUbgNkbccECmqik4IpzKScgUqwy7vuUuRNaAIYUIxz+FPt0ELJsYjLgEmnLGQPmApSOwH0rGz2YLc4P4u6JeaZeReJtObdDKdkhX+A5+8fasO28cXUESoYN+B3PNey6RpXhjxHcr4c8V3Zt7O7jdHufK8xYWx8pdOrpuxuAIbbkr8wFePeL/AIdav4P1GV7INcWqMRujzKAB3DYyw9CQCRycVk6bjI2hZvUuf8JSs2wLaFSeclqZdeJLh0MCr9DurnreZmU7ZPMJ5yvalmvoYl/eyqv1NFjXlTLs1wSGklnwevWuU8R6gLkGLzv4jux2qXWfEKoCkTqQOODWLa6fq/ijUhp2iWbzTs3VRlU929qTWg2rIn8M+Hrjxlrlt4cgBZHffPKnSONfvEnt6D1zXvIsLeCFILaPCqgVeeigYArC+HHw7svA2nyQkebd3Khru4A6kfdUf7IrpX+7+NXTjo7nLKUrlRw0OE9qPMZxsIGKmlt2lbcPTFJHZtvGa6FFEkQUL0qzAgaMZ9KX7IKeqbBsFUKWxYtWIIFX42KxAis+1IDYb0q7HIgQAtQQWYmOB7VZhc7egqpE646/5zU6OAuQ1AFpTghjVrzQVG3vzVFWJAwc8VMsr4AxzQBaic56DrVlJgE+XrVJWLexqSKQAYLUAXonGNzMc+1WIZlYgEms5JOfvGrCNyCD3zQBoi4UDA/lT4pmLZU8VTSQOAHOMc1YieNDjdQBdibauSfSrMUqlNxrNhmLDDHirEUwDAryMc0AaCTK8e7v7U+O4KwMzHntVOKRS5Ab3Ap01xG7eTFICccgdqdmwNHwvHDJK0lznlyzYPRVGSfpV7RyWhlvXRs3M7SkZ6BuR+gH5VStIzFpRt0HzXoMZPQpEOWP4ngetWoZth3K3AHQdKcI3epSuX1lVDkZHsamzvAb8apRSGUg+vSrgZUUBjjA5rojYodTlQEZpgkQ9DTkkThd3PpVAOCgHIpTwuaHVgcgcZob7nFACxugI+Yg96tLM8J2hCQehqkEO4ZUH2NW7cjYAztuH8PagC6jENj0pt7/AGi9uRpgh87cuDOG2gZ5+73xUSO2MOcN3xVmANjcelAF2FULkxyALnCrnJqzE6ldtUrf5sjJDAgqatqokOTx9KAJ2t3lMTu7KI5RIoQ/eI7H1FXbV5ioycqnfvVSFkbCSgHn5SSePep7OV2s97RvGSfuORkc+1AFuHaxJMRyec0siLuHX8TUUUxVhlG56c9as5DYzGc49aAAIMAhx17VKsLN8yuc98mkEYPGwj3p6RgZy5oAaV+bDDnNO8vP3acIyegz70BW6igBApUYNIEAOaU5zg9aACTgUAFIkTiTeD3z1p2xvSpEVyAVHt+NAE0F4DMHVSABgnNH2yJtT8kykO0DOSVO0KPfHX2qOO3cOEEoIbkkmrEUkggdixBX7uD1oA/VWiiiszMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA/C8ldhBXP41DNKY4sJFkg+tTTlUBIqq0xycKcGuc6CIMd28euarSRb53meQndyF9KmZ9regzwKpvc/Mdxx/doAZcyASKjPjPUVVnihA3RyZwODTbmclvPlXJBwPaqc12kald7YIxjFBD3Fnu1jj2kZJHXNUXvHVRHv4zmodQuLpbU/Z4zI46Fjis211C9kIivLUq3ds0CNCe66kDPrzVSSYsTiTaaje5beeDiq91dY+5170ATSTlVz5mfbFQSXAJBC5JHrVf7Tvypbt3NNEhT5yMgdKAJzOQCWGPamm69OarvcCU5bgCkEqD7oJoAnMyl95PPpSGcs4ZW6dsVENznIU81KsUpOHAH4Va2DckQiQ+YVp7xlxkGmRpsDAntkVMuQAcdqY2rFC7hYYo0jVL7w5ftdRqrxSALNEy8Ov8AiOxq3PGHFQvbeYmHwcdMigaaSNye0ttUtP7a0dxPD/y2gB/eRN6Y9KzhLOkhkOSmflBGOKzrafUdFmFzp1y0bg9AMg/Ud61rfxVoeqkQeIrdrWQj/j5g5XP+0P4fwzUOLTJFjv4yNsmAD6mple3cZVgfo1Tx+EbXUWWTRNZtbwH+GKVQw/DrUF14V1a1ystjMfQRAE1h7ROVnoA03MatsGOD60pnTswqAabfRKGeCRQO0q4b8aDHIOsbflWnNHuBOJ07kUNcIBkEVAVYDJU/lUZ8zHzdP900c0O4Ek8wcg7wKZ5ntmo3Rm5DYApvmbeDKox6ijmh3AlMoXr/ADqGaVXOA4FKT5ox5qnHoMVG8QDHMgppxezAKBj+JgKZcZMZC9agC3IHAp6dwJpdm1sP61XqXyrjbuaPjHPFNKM33FQfU0FcrGVYqLyn77PwakEWo9VVW9t1AmrExhWT5iab5e08HpTQNQXh4G/4BSgXBHzQv78CoaYhcKjBiR+IqxHdwyMn22yiuI1PKPkZH1FVJEkOMxuaQG4UYWF8fQVNm+g07GX4w+FHw68Q3RuLS3lszIdzeTJj5vc9T+Nctefs7aTIxMXii5C44VgD/Ou+8+7H34mYegUCmS3JI+a1l/77qJRaLVRo4PTv2e/CVnIHv766u8H5kaTYG/75rqdO8N6PoNutnpFhFbwgYEcKBR9eO9XDOP8Anyc/8DprSsfuWpX13HNSlZg6jY2eRYwAMKOgxyaYEHc0jMyyFxAMnqaPNf8A54H860jsQ3cHAB4oT7wpskhzzA3TsaRbhUOWgbj1rdLS9xE1OVQVqH7fF/zxNKL+HOOnttNITVyeNdr5zU69B9KqG+hXB3A89FQipF1CAjOWH4UC5WaEXT/PrU6/6v8AEVmLqcC/8vA+gFTQ6pAykGY8fSgOVmqv+rB9qRXbd1qkmq2+ADOfpkVIupWpOFkoDlZoRud2S2OPSplkXdw6n2BrPS+ti27fn3qZbtEO44FAcrL8cnXipVccHf8AhiqEF/Cz4Lrj61OLm3MgBlGN3IyKBWZfif0Oc1bByAfas0XVsmCky9f71WIr+3/juQP+BCgLM0Iun4VNG4RSW6ZrKXWVP+pjZvoMCporu5nG2dDGCflA6mgLM0XvmiCx26qSx6gc1Z0TTzcOWlQtEj/vGB+8T/CvqaboegXB/wBKvyIYc5yeSavvqkbEWunqBEmQfcex7/XrTSk9hFueVC5QurLgKGQ8BR0A9QOv1p1u+9OmMiqy7XXIHUcgVYtzs+Qn8a1gnFami2LsQ8hUbrUzyBiTv69qpGZiAC/TpUyncoJOeOaoC0kiY+9TkkTzlO6qgfAwGpUdvOU5oA0EmUnl6dGcybhVMuFwMjOetTJMUj3qcn0rQCwfmkz708HDD5sfhUCT7iCRgmnMxZhk1MgLaSZbHv1q7DOuzbWarFe9WIZl42jvSWjA07ZlB3u2KswXKM2MfjmqACsoDvnjt2qzCkQI2elVzIC+inG7selWFDMgCN17VXhYnCseADVu2CrFuI5p7gSQSBiMryvbNWYWLnJ9aqWoDSFj37VciQhhtjY8djQBZopkbMeGP51LcSJBarIsLyMWwViUM3PGcE9KABZFLeWcg44OKRA8Z2v1J6U/GXEfcDIb0oYiVvMbqvFAEYO6TOPSlkVk4pwRQcgU59zD5x+dADYY2YEg5p5YRLscZGcnmmj5eBShWcgEE0ASIIAPmzsVD0PNSo6mEIHByvFRPbp5yEEcjmmxr5TlVPIPQ0Afq7RRRWZmFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfha7IVIYGqU0jL8gNSPK5UjNVLqXysHPJrnOgSaRSh8w4wO9UJ5YWj2hwSCTUt9JGYtxPU8isqWRNjSM+FFACajdBLPahyxfPHpVGeRmQu/YUskYLmSSb5T0rPurtkO0SbgegoE0hJriUgbeSegB5qrcXLK2xgue/NQ3V+kblI5sNjBz2qlNckkOXyfWggnublkYjNU5Lls5Jz9KSWZXyxY5qESopPf60APkfdhlOOe9P+0lk2Z4qvLIGbaDj6U6NH2/Lz9aAJd6+9OX7wphTjjrViKAYDP3oAegywHvUqxlXLbyeOhpqrEshHce9ThAVzVrYNhqKS+Rz7GpzGzL2pkURLfLU4GBg0xt3ITDj72KPKXsKlKM/SkMeBz1oW4irPFEeX6+tZ13GhfaiA++K12iR/vDNV5rRPM+QYBrVyajYDHNnJH+9hGxj3RsE/kani8Q+JdNK/YvEN8mP4RcMR+RJq7JYIE5Tp71XOnK5OFrKVprVG3srq6J4PiH47hwY9ayB0MkEbHH5VP/AMLS8cL9++tWHq9gmfzGKof2Uo+bK/TvTJbME7SPwNTyR7B7Jmkfi34vi5dbKQ+ptB/jUbfF3xMp+fStMYen2Qj+TVmNZj7oUY+tRNZhzkr+tHJHsHsmbA+LuuPxLoel494H/wDiqG+LV+wKv4a0s+n7hv8A4qsSSwTj5B+dMNgACQP1o5I9g9mkbTfFMgbj4N0/d3KMwoHxVjx8/gqyJ9fNb/CsCazO3gfrTI7QbfmJB9hUyhGwnFI6CX4pWx5/4Qez/CQ5/lQfibo8oHn+Ck/4DNj+lYBs4z1LH6rTXso8/Kcfhis3SjJ6k2R0X/CyfD4G0eDyB2/fD/Cj/hYXhOT/AF3hOdT6pOD/ADrnP7PzyHWkbTuR860vYx7sZ0yeN/B7njw5dD281amHjDwJKdraHdKO+Nv+NcsmnDeT5v4AVKLAg5CD8qFSitgtc6qLxF4BYY/su7H0Vf8A4qpP7d8B9TYXq/7Qxx+TZrmILWTP+qB+gqY2jt8phxn3p+zXdisjpRqXgaVdyi+/J/8A4qmG98Dsc+Zer7GN+P8Ax6si30391yO1H2EqceRn3zTdPm0vYLI1zN4DkG0Xk5/7Zv8A4mm7fBYGI9QdRno0Ln+lZn2eQ/ejx75pRaZ6n+VP2P8AeCyLxTwXnB1eTJ/6ZN/8TSPH4Ox8mvunrmJuf/HaoPpyv3OfbFQ3GmuoGxW/Eij2P94LIuTJ4RPH/CTH6mJv/iab9h8I/wDQ1w/98N/8TWVLp74+YHP1H+NRDTEOeG6elNUv7wWRt/2b4WfmPxhbKPRgc/qKDpXhgDP/AAm1qP8AePH8q5y50xt25F/MVBNpUpiO4duoFL2Gt+YLI6g6Z4X/AOh8sP8Avof4Uq6HoUnzx+PNOx2zIorjv7IP/PR/zo/s50yodvxNX7OX8wWR2v8AYOkMMw+NtMJ7j7UvT8acnhnS5eT470vI7C6SuITTwgOVJH1pptW3fJblPej2cv5gsj0AeDYGTP8AwlOmkf8AXynP60L4Iik5TxNpmB1Ju0rz6S1EvKW/HenQacDljaZI/iPahU3f4gsj0SLwOjnbH4k01iOuLtP6mp4/AF196PW9ObI/5+4/8a88XS1JBaPOetSxabDvCeSME9OtX7J9wsj0NPh9qD/dvtOb3+1p/jU6/D3W2bb/AKH+E1ebrphLHyYlGD1K8VbSxQNtZBuHXFHsn3CyPQY/h1rUbbvKtm9lmFW4/hzrjR7/ALBFyMj5/wD61ecxWio20Rkk9MGrcMDINzggjkc0vZSXW4bbHfR/DvWQvz28I9i+P6VLF4FuIOZ73TofeWdc/kTmuEhtmkOJEYEfeOa0LKxjACkLj0Io9nIhzaZ2g0nwpAQ994xt8/8APOH58/8AfOalGveHdHONC0wyyngyzDAPv6/hXK2ts4P7uNQq9CFya1YIIyVJySeuaPZN7lczNN9Uur4lrpht6iJOEHvj1/Gp7W1V5Fk3kAHt3qmqKHZR0xV616D2rZOysS9S9bgF9i1KeGK+lRWf+tWpW/1rfWkAZcfdNTws6qMnqKgqVZUCgH0oAmDAnFPDgBT744qt50eepz2pBPJEcLyAc8igC4mzcMSZ+tTxyqq7Tng1QN6SVBLDnuKkhugQ2Qfvd6rmYFsSMcncKnSUR4D8/SqETs2QTwasLkjJcH6Um7gXVuYnU4J6dCKlhmCAHpkVSikREyVGQamdw8igccUgNS1cYO9yM+lW4HZXzuyCOxrKgl24BParsDpt6nn3oA1IpgwCluSeKurI2RjPTGKy7Zo2YZJ/OtGN4wgwxyKd2gLaZQgZwetXLedTjchPbrVBS7oGA5FXIwUCMwwCOaadwLSn5sgflUkb7Tny8/Wo7U/uw2Cc+gyasaf5skJmuI1STGCFOVH0Pf61QCZ3HIHXtTjG4XcVpGABwGB9xSrI4GCc/WgBMH0NSXBJ2psPHftT8DAOO1RHzkG5mzj1NACGFwMnFOhmUfLtOemaPtMcuEJ5HpS+WqKSo7UACBkkVXYHA6inmJZCX96rgOU8tOp6VLFMY0PmdvagD9W6KKKzMwooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD8IZSu5xkc9OapzkF8H0qxc+Uq+ah6981n3Vx5J3D5siuc6CG/cy/KI+g4OazLtkaA4IwKtXdxjc5bseKypJy0bID1NAFa6lRCGZsAdazb2ZMs6MD6VcvNpjYO2Md6yLwIhIUkgjrQBn30MrAzxN8xOSKrpfTbhHIuM8E4qeW7REKMD9cVXKq5DAUAOdyHAX05pCcnNNUl3wBziiNmabypF2+9BLTuWEjdjkL0qeEooKuuTTAREPXPFSLGRIAT97FBI+OJUJcnHHFTIj4zjr0pUg2jGd3pU1tGxfay8UALBbJje5walEYH3TmnvEFYhW4oSPnr2q1sA0KwbOKmXoPpSeX709Y+Bz2pgJRx36d6d5fvR5eeM9aAIZfIY/uV5qtIjhzx+tXXiC8A1FKAhyRniga3Kvkg96a0QBwGNWW5UhU5+tRPFg5JoNovQj2/Lt9qgaAbzVj51bhM4NNkyfmKYoKuyu1tk5BNQzW/ft61cPAyenrUTYA+bpQF2VDCoGSx/Ko5MLkflVqaRAMKM596ryIH74oKTRDTWUk5Ap7DacZphfBxipbTMm1YQqRyRSEA9RSvJ8p4pqncM4qSRaMD0opCwXqaA1Ww+Jl3YJqZGjLYZuPpUMKox3b6eg3c0FylzJF6FrcjAk/DFWFK4wD0qhCwDcmrkTDbv9s0EFpCAMVKgzhe5qvHKG5A/Wp4ZF3hjxigC0sEDJhxn6CmPYwMcouBjuKkikA+4c+9PJJwSaAKn9njdgOP++aSWyZMfMDn2q35e48tjPtUTtGGKs5OPQUAU2tBvywH5VHNbqCcCrbEb8jpSOFf+HFF7gZ626HO5VPPcVXuLOMkgKv4A1ptEqDPWoWiDPvZcDNC3C+tjL+wL/dFNaxhB+ZP1rX8qLGRzUDsA5XaMfStBtNGcLCFuBET+NI1nbDhozV4FYwSU68DntUcjKWzt/WqTVgs2UzbWmMBTUkFjGQQgH51MkKsM0pJBGMDHoKoRD9iYPjtn1pTaMT5arz2q252R5C5PenCaOEqGiJLenagCCO1hDKsg5+tWIrOEyFxGo9+adHbROfNJzz2qZE2DANADBaxbhyKuW1tE8e3Zn5sEt2+lV1Xcevarlr8koHYjpQBPHAAMNH06AVLDAgOfJNFu7MCw4qxAzmQLu6+1AFy1g8ocjmrsSIVyxxz6VVVySMDkfeHpU8EgYYPAzwaBPYtwRBNzHtmrVvK2QcfWq0MqM5HOD396mSHDb3I254GaCbMtwsWfd/KrG4E9arK6qcxrx71KsiZ4agRLS7ZsZ7U1dxGcD8TTt8mNpYY9MUAJR0pUCk/M2KGABwpyKAHGcntQsm5vmNNAy22hBlFk9e1AFuFl4GaezsjAg8d6rQuWBJGCvT3pDdSbMqCOfSgDREqEYHB9KcjsQM+tUhctIAXWpUnAwu7PPagDSiYFQM81ahmZeDWXbXG5iM8jtVuO5DjacA9hmgDatbkMVA6+vpV+F90y7n9iRWJYTtG+04IatOKZBxjAPTBoA1RJJEwSM4z3qzE5Zlid89yazoZXKhAcACrVnIBJ83Hp7007MDTtnDbecEGrTsA/XtWdBLtJB6DvVtXdyG28GqugLQdzwBxSlSOoqAPzy3OeBT/M28saYEgM38LcdqkVYgN1wdxHoagZsMArdaRSQ5WI7cd+tAEyQktuiIA96WaRs7Cc9qYCcFjJz9KasnzcjPNACliAQvcU5LYyFT/D3NMKksCDTpLhoU3beOwFAH6v0UUVmZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH4KXUhihCHJ9aoXcysvC5qzfPjKFwc+lZtzLtOBXOdBWvJSRyvXrWZdSrAm4HjvzVq8uN+VB/OsXUbmaOQggECgAub5biErt5zWdezCDKjmpw4b5uBntWfeOWbGc+woArzncCe9MAOBx2p0gI+YjFNBc9+KnmAE2q4PAqQxh2yq8/3sUwbFYbufpU8RBOVH4U1qA+FDJwxx7k1PFAQwIbPvmoo1MjZHGO1WrdD+tMzJoAXO4jp1qcDH3R+VRoMDap69aswRjPzfhQAqKSnI596ckB2gg09oju+UcU9FKjH8qtbANMe3jGePSnqFwBgVIsDsMipPIiC570wK+B6Cl4A/wBUT74qUrs+6oNIzS8jyxigCs6tjODUMsW8Vaf7pqBup+tBUVzMrgkHINJIpMZk9KlnCA/IKjydpTsetBqlyoihbepb/IqOXeTjBxUgxHlFB5PNIWDg47GgZE4Z4/LA/GoJCAhJGatA5qrc9CScfTpQBG6qEByCahl4AxxxzUg5GcVHP0x6igCvv2tlhnimud53BeKc8bY6ioX2+arFmyqlcDocnrWZmKxBXg0iMoGCw/OmbwvJU0yQgDf2oAsJznP4VDITnBNRi9XA5NRtOWOQ360AWYWw2N361PFOAMEVShmXd8xqwn3hQBZSZOpXn61PFdkrt3cY6VSqSM7V3egoA1beZQn3eakRiXzyOelZ9vMx6dqtw3Cg4bOaANK2nQIBwOasrIrjORWWJOhX1qxFOwWgC7gsOD+NRFFjYliOfWkgm45NJNcpkALn60nqA2Xyj0PPtTNpbgHFI8oftj6Ub/7px9aErANlUqME54qJs7ec4qWQkryc1G7Aptprcn7Q1nVUOBnPpVf5W+8Bz1BqYqVHPrUYVCMjk+1aG6aW41oCw3E8YwBUDqEOGI/GpiWYlGYgAZGKidUxtJJoB2ew6FQYmbH8WAaAqNyADz2pFlCDy1U48zn8qWMeTkNzlu1aGRInAJYfnTV8ueTKk5AyD2qTZxk9KbFGEVV44PNAEiyhF+YfjThMGOAPxqNZBH8jAEZqOCcXErqsbDyyAT2OQD/WgC2Sd5wasQzAH36ZqspySalh68dc8UAX4Z+ijjJ5qyG8sgq/PrmsyN38wDIq/EC653DjrQBoLOY0Ev3jJwR6VbgMQQAt06GsqGc7tjdP4auxTIFCc56UAaUNyrL5KrxU0PmSRFVbkdMnpVKEYON3QdqmiuHjXHHB60AX4pnkQIyYYdcCp0YFhmPA9SKpwyu43MwA9R1qyrO0OdwGfWgh7lrcSBhu3rTx0FQRsUjAfn6VMOFz7UCFwT0FFNMhH3aUNkbjQAuRnINLE67whYYHQZqNORuHQ8Zpq8SM393GaALBYrLlWxzThIfJJ3c5qInedwpBKuCMGgCZZdzEtKPxFPWXy3Vge9VQ4Vee1SmUKA23ORigC354V/Nj9MHHerdvMCQSvPbistWKKCGyG561bhkcMp3D86ANmGXCxsVwec1et7kA7s1kI4lC7mYbT+dXImckuCMZoA2ormUzbowdm0dauxyB1BRicVj210zFYxwcck1fin8rK5ySOgoA1IJgzHzJ+uOAOtaEVyFOwI2B3IrGguBJmLaAeuTVu2uZjkSt3APNAGojK0vnZBAGOtG4SIwY49zVWK9CN5JQH3qwzKy4B6itFsBIDiNPnyQeeaduAOQ361CYwesmKXevc4+tAEu7P8X60bCOQ/4VGssa9XFP3rxjnPpQA7J9TSHnrRRQB+slFFFZmYUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB+ANxJsjLselZb6nGX+Y8HkVauAkkXlMxyOuKyZYFhlLKT17muc6CO9uFDmRfukmqGoSxSNtVCTjsatXk0bAiQ84yAKzZ5o1ziM/iaAKrm4C5EY/E1QlZd+VRgfUmrFzcb5AUGAP0qnMQDz60AOJLDBNGBjFRgg9KerDAGaVkAmAGGBVuzUbt3c9arEFlKjrU6AqgzTAtQoqtwOtWYwFGRVeFWVEBFXISCBigTWhLbopHTr1q6kSLEHA5zUCRDOR2HNW4gQcGgIxbWxLHEzKMDg0GHy39qen3/xqQEAjPrVrYbQ+3UMhzUXkkNuI7+tWVCOoJNNI+bApmZDsb+D8aa7MAVOOnpU5BHUU1olY5oAokZG3uelRvGu7AHK/fqzOqRhkjOcjP41Wdgpx6jDUFw0ZWm67ux+7TKmZHVslflXoaYAck0GpG3Q/SoinykJ3qZup+tRMQJcntQBGoIHPrUNxGGOAKnchgdpqsWKlmA69KAIWQpESTyDxUUvIyfSpmQhd46E1DP8vX+5igCs8j5xmoz5ZOXzmpGBI4qKV1iXcW5qXsS0rEbu7ts7ZqGZpFYxnpTyTt3AVXmZn+Z+ueakkjZFyeO9NQAtg+lG04zihCBnJoAevynKmrUF0z+maqb19alR1Dgk96ALiyMRkmnLK/3c8Go42DLlTThwaALcTFRketTxEuDIx5zVZHXHXvU0LuvKDOaTuBfiYkcn0qZHbHWq1v8AXtUtC2AmSZQcEn3pXcE5Qn3qJVOQcUpcp070wHb29aCxPU1G0jk5ApPMk9KAJRIqja1JujPAJqByWOWHakoW5cFHqWDs/jzUEhiV/kyOaQZ2gHrUTyAMV8v8c1oD2FmkYnFRgYooSNXk560AtiRDG4xjknNPZQwwe9MnklhbCpTsMyhsVoQHmMo2joKQsT1NLuAXGe1NoAkQ4UcCjgMWUAZOTj8B/SkSMMoPQ/3qako3+U3IIPzntQBYtyWfBqWKVVb6GoLcxqmA4pwIZuPWgCwXVjlScitCBQse5uhFZaEfezxVm0uVVSm7n6UAXh0U+p5qwhYYfsKo28rsN74G3pzVm3feNx6Hp70AadpOsp3A9BzU+5ZCAM1RtbkRykA8Ec4qzHKCPnYDJ45oAvwMjbYHBIPXB5q1EhkQKpO0VmrkAf0q5aSm2TaDQFkaCkMVX0qbccYzVOG5d2w2MfWn75d5KuCMdKCWick5Ap4J37e1RJMGGGNP+8Pl49TQKzA/K2B0o4O4Dq3WkadlYRAdqUSuVOB1FAh/Ma7GPzYqNeVDHrSq7n7w420sLjbtyc+1ACH7ppBM+AueOnSnM4LFgWx3pACVYetAEkbH7vYLkVPBIRF5x6iqqyRLEUZcnFTJuMYAk6DkYoA04LkOAWfbWjayEQ5DZGetYdu6t901o290sSBWdhyMYoA1IGkILIM8Vbju0cKjBg3+yKowXLbQUYdOfpU4di6mMkA+goA2bfceVHOO9WxKznJIz32msmK4BXazVahZkxjv6UAa9uAXDsKm81RISp5xiqNtM27GDkdeKtRzneNxwO9NbgSZYEbjypyKnVoyuSKpSphy6HNTQtlf9cD7VYFhTA2Rt57VKsZRdwAxjNVA6k4GfyqQSkDaaAJ/OT3oaZAuRUKShDkGniQOCCeW6CgD9aaKKKzMwooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD+fWeeGNyd2c+tZU0+92JHQ/pVu5eOXeVwoHTPWs2SeNCRISOMVznQUr598rNGSVC9c1RYsys3U9hU95MNhjtuM+prPnlIXZI68HjmgCCZpEfBj6n1qCVt4zilaVs8v06ZNRZJHWgBydPxpw6imDd2zT0LCPIGTmgCVCN3f8qnX5OX5HtVdmZsAlV9ccVPAVXqwP40AX4wHiV1apon2jgVRjkMhDAYXPQ1djzsDE546UAXoZN0ZfHYVbQ4O7HUVnQXCtnoAB0q3HcArwc0Fxkki5FKCcnrUgO44x0qpFKM5Ix71ZU8YB5q1sPcsxOoXBOKfIwKEAY96qrJtGCM896cZyQQPTjmmQ43HgEdTmlphJwDk01mkJwCaCeWzIbgc5qpL9+rskXB3N+ZqpcxHJ2t+tAxsp/dZ9agY7RnFSMTsxk1E4J6D60Fp3Q1jxu9agmVmGVqZiMYzUDMyOSQcUDIHVovvE0nydmB9qfcSFxgJn8KgHlA/NvFACXeTGADjFVrhifl71LNJhsLlh71DIhlIcEjHNAEEh425wahZEJw8lTOPmORziqk5IkPNJq4mrjLmQqcKO9V8kjk96lUqzDzSSO9MlRS5KEgVLViWrDCMLj2plSY7daTA9BSEMqVRzn0puB6CpYI8SEucj3oAsWv8AqgfU1JTYgAny9O2KlULxkCgB6dPxqeB8DGKiGO1PQgDg80AWIGcHaOeKswu2NrL3qjHIyNkE1Klw2Oc0AX1bOBiklO0A4piTrtHAzimzyFsY4oegCrLkZxS+Z7VECcjmpEyxwuD9aSdwGvJz07VEwcZbnFEzFZCJSQewFBeNkwrkn601HW5SQ3J9TRTXUt0Yj8acsTbc7ifxrQtK4UhBzkNilJA6mkyPUUA1YkQNNH+8kOMelIkfJAlJwKcOBgdPSgADoMVoZEaTFm2474qSkCKDlVGfpTJBPnkce1ADmn2EqOmPnHrUZmcHe/I9Ka4ywL9R0zSFokORnOehoAnhkjYYCEcetTRSZj3AdeKqx3DebhQce1TG4UEgYHNAE8LMARnNSxy5XIFQRyowHygnPpUqyjGxlwfcUAWlYrFtJyMirlnIJOCMqBwfas1JsnYxxkdDUkVy8EYVM8ntQBrRuplDRPt9cVYSRXcIQTz1BrOtZlb/AFeOfvGrcU3lS7l5yKANOO6UIFHb1qYStkf41k/aJnJYAde46Vbsrrcnztk+9AGvaXEQH70HOasx/Nllbg8isqKaXcNq8e9WopZ5Y9nmAYOcg/pQBpJsKjB5H604OQpUjrVeCRchSw4HWrEpAHmLyPagBfL5zmlUbRjNM8/cN+PwpyOHGaDMceFI9qbCf4/0pGfnb5n4YpASOAaAH4wrfWl3BASfSo/Nx8nrQVMnyE9aAHFSy715oSWVM/LxikMhhCwdsnLU2RsDG79aALtgCcjfjBrRg8teGfJHasaMuBjJyDV2KSTcohVTxyTQBrxXTtiPYBx1Aq7bzyBlXPQZrMs5UQEzM24rjg1Zt3lJzHjGe9AGvExeP04q7bvIdmHxWZYzSbjHIBtboTWlat5YAYc+hoAvRzkEKzYxwSBUqyLnKscepqmHDNvX17VPBIXjYOPpmmtwLPmb/mDfrUkaxeaGB/CqysAwAb8M1KhwwYH8apO4E5ml84IrYAqfepON+TVTcSc7qnhdcZIH1NMCWlD7MMw6fdHrUcMhZiNysRyApyakAP3h36H0/wAKAP1vooorMzCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP54bm42q5AwT0zWVcCOSIuXIcDueDV26IulLd8djWdcblhwwBycciuc6DNuL5kYIzpls7VB5IHU1Snn8xtxzU19Dax5nUASAlQe4GelUpJdiEmgBJ50Axg/lSR3MZGzn8RUDTPIPvcVHFl/vyEcetAFwyEttQ/lRHMwk2E8+tVo3tSrMZTke9JFcq02TyMfnQBoLubq4/OnKzg7VbpVSKVmBJTGTxUqS7Bg9aALi3bxgYHOe9XIL5pV+Y4PtWW0obAHrUscrqODQBsGRSoCOOnNTQS7Dgt0rMhnhROZPmParUbhySPQUAacVwzHezDB6AVYW5IIY9B3rOtTHsG8dPeraI0g3yvhSOOKtbGhcinGdzcg9hT/NQ81SSYxL03L6in5XAcv1PSmBZErno35VIsvy89frVSOVBnApxlQ8kUCsh0ssjsUTHPc0yWIqoAPanBlZdyU2Z2I69quyIIGVwcBCeOoqvMzJnjrU8+QdwJ496qyEs3zGpasy47DX3Bc9yKiYtg72/OnzSSAYEf41UkjZ5CVY5HvSGLJPNGTsAx7ioZXEnzvkH/AGaVpZT8uwH3pk0mPlWE/nQA15MjG38qgkeRM/N9KkVrlckx9elRSFnY7hzQBGzk5ZjmqlyRkkflViVZBkA/pUUkYVtzjtQBBHEZBncB9aHgbHXvSuzSMBbr+FObzHAUrg1EtyZblbGOPSlClulSSwhV469/rTI1Zc7jSJE2H1FSyxMiFg1NqwVLcCk3YCO3nZU2uh+tW4zvQMPSoY4GB3VPHwuPamAquFOCOtPQ4O6o8DOaev3RQBMpAOTTgQRkVErEnk1InT8aALIb5RtYZxQCx6tmqpZgTzT4pHXODSewE7nahcjp2qJLvbIqtEOfShpnKFT0qEOhcNjp05pRAnk3SSEqvQ4oEjKpRk/GlVgRlT16801pt3yZrVbGi2FDBulPU8AYNQgkdDUq3BVME9KZURsisW6U0qR2p/2hZD838qUP/doCW4+iiitDERs7Tjrjio/3/cgVLgHg96jUqsuxs4NAEUis7ZJ6UTbHbctSXUflAEdSarhQDkCgB4VkwwYUSCQZfcPWmTsTGD3Bp45gGfpQA+F8/eJHPGKsI5x8+c1UjYg4FOjupNpyueTzQBoB1VtqnIHU1MrqFFZsVw29kERI9c1Yiu8NsdMD1oA0bOdYlYuCODj3qeC6MhBDd+mazUnhaQpnIxwc1Yt5IISsgbIB9aANeNwpKFgScdKfFLjBFUftMY3MM9sc1PbT+YvNAGmWeWPcsm01NZnC/PKc+uetUUuFbCDpjmpVnQJuPY9aBN2NiKZyojV15qW3dVBjlmJrOgkCYI7juatRtuAMYGe9BN2XYiiArvOWHGTU0PP4Cs/fvkDt/DwcVfgDKm89D0+lAh7SM5ACcetIzhSAR1pwlWRSF7U0qGIJ7UANbmUCnnIYBT+NIFVpOR2pV/1Tj3oARkeX5G5UHrTJkwMg8DpUyzBIwh7j0pk4ZNp7FcmgBbcTOd57feq7BKyncImxjg1UhnKuQiZXvVqKVLgFCCgX3oAnWaSV1UK3WtO2uGZvJccADpWVbpjMwzge9XrYlCHB6880Aa8MiyRBQSMVoWhLL5m4knrmsixf92JH5BOBWha3WxBGetAGohCjk1PGQFAJ7ZqjES20t3PNWlO/huw4oAmH3w3oanjceWeDVaBWZXx0HSp4AGAU9Cad7APWUDopNSRy/uyuw+tMhGA3+8aepO1h7GmmwEtcbzLk8KRxVm2EiW4Qtk4xmq1uDu2DoetWUf5cp0XrVAfrpRRRWZmFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH//Z', '123456', '50', '{\"Tempo\":\"M\",\"Quantidade\":\"3\"}', '1', 'ID', NULL, 2000);

-- --------------------------------------------------------

--
-- Estrutura para tabela `promocionais`
--

CREATE TABLE `promocionais` (
  `IDPromocional` int(11) NOT NULL,
  `IDPromocao` int(11) NOT NULL,
  `IDProduto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `promocionais`
--

INSERT INTO `promocionais` (`IDPromocional`, `IDPromocao`, `IDProduto`) VALUES
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `promocoes`
--

CREATE TABLE `promocoes` (
  `IDPromocao` int(11) NOT NULL,
  `NMPromo` varchar(50) NOT NULL,
  `DTInicioPromo` datetime NOT NULL,
  `DTTerminoPromo` datetime NOT NULL,
  `NUDescontoPromo` float NOT NULL,
  `TPDesconto` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `IDFilial` int(11) NOT NULL,
  `STDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `promocoes`
--

INSERT INTO `promocoes` (`IDPromocao`, `NMPromo`, `DTInicioPromo`, `DTTerminoPromo`, `NUDescontoPromo`, `TPDesconto`, `IDFilial`, `STDelete`) VALUES
(1, 'Teste', '2023-09-25 15:12:00', '2023-09-29 15:12:00', 5, '%', 1, NULL),
(2, 'Mes das Crianças', '2023-10-01 00:16:00', '2023-10-31 00:16:00', 10, '%', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `IDServico` int(11) NOT NULL,
  `VLBase` float NOT NULL,
  `DSTipoServico` varchar(50) NOT NULL,
  `IDFilial` varchar(45) NOT NULL,
  `DSGarantiaServico` text NOT NULL,
  `STDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`IDServico`, `VLBase`, `DSTipoServico`, `IDFilial`, `DSGarantiaServico`, `STDelete`) VALUES
(1, 40, 'Troca de tela', '1', '{\"Tipo\":\"D\",\"Tempo\":\"7\"}', NULL),
(2, 50, 'aaaaaaaaaa', '7', '{\"Tipo\":\"D\",\"Tempo\":\"10\"}', NULL),
(3, 50, 'dfssdfsd', '7', '{\"Tipo\":\"D\",\"Tempo\":\"50\"}', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `IDUsuario` int(11) NOT NULL,
  `IDContrato` int(11) DEFAULT 0,
  `NMUsuario` varchar(50) NOT NULL,
  `NMEmailUsuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NMSenhaUsuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DTUltimoAcesso` datetime DEFAULT NULL,
  `IDColaborador` int(11) DEFAULT 0,
  `NVUsuario` float NOT NULL,
  `STUpdate` int(11) DEFAULT 0,
  `PMUsuario` text DEFAULT NULL,
  `STUsuario` int(11) DEFAULT 1,
  `LOGFilial` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`IDUsuario`, `IDContrato`, `NMUsuario`, `NMEmailUsuario`, `NMSenhaUsuario`, `DTUltimoAcesso`, `IDColaborador`, `NVUsuario`, `STUpdate`, `PMUsuario`, `STUsuario`, `LOGFilial`) VALUES
(1, 0, 'freitasdev', 'maxhenrique308@gmail.com', 'SwPx3841', '2023-10-04 16:02:47', 0, 1, 0, NULL, 1, 0),
(2, 1, 'rayssa226', 'teste@gmail.com', '12345', '2023-10-10 01:41:25', 0, 3, 0, NULL, 1, 1),
(3, 1, 'joao12345', 'joao@gmail.com', '12345', '2023-10-10 20:11:55', 1, 3.5, 0, '{\"3.5\":{\"PRO\":[\"1\",\"2\"],\"SER\":[\"1\",\"2\"],\"COM\":[],\"REL\":[],\"PDV\":[],\"FOR\":[],\"PAG\":[],\"PRM\":[],\"CLI\":[],\"FIN\":[],\"VEN\":[]}}', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `IDVenda` int(11) NOT NULL,
  `IDProduto` int(11) NOT NULL,
  `IDFornecedor` int(11) NOT NULL,
  `IDPromocao` int(11) DEFAULT 0,
  `IDCliente` int(11) DEFAULT NULL,
  `IDColaborador` int(11) NOT NULL,
  `NUUnidadesVendidas` float NOT NULL,
  `IDCaixa` int(11) DEFAULT NULL,
  `IDFilial` int(11) NOT NULL,
  `STVenda` int(11) DEFAULT 1,
  `DTVenda` timestamp NOT NULL DEFAULT current_timestamp(),
  `IDPagamento` int(11) DEFAULT 0,
  `VLVenda` float NOT NULL,
  `CDVenda` varchar(50) DEFAULT NULL,
  `IDOrdem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`IDVenda`, `IDProduto`, `IDFornecedor`, `IDPromocao`, `IDCliente`, `IDColaborador`, `NUUnidadesVendidas`, `IDCaixa`, `IDFilial`, `STVenda`, `DTVenda`, `IDPagamento`, `VLVenda`, `CDVenda`, `IDOrdem`) VALUES
(1, 1, 1, 0, 1, 0, 1, 0, 1, 1, '2023-10-04 20:14:21', 1, 15, 'gzcjGMfqHr', 0),
(2, 1, 1, 0, 1, 0, 15, 0, 1, 1, '2023-10-04 20:16:01', 1, 225, 'nDEevoS6kD', 0),
(3, 1, 1, 0, 0, 0, 1, 0, 1, 1, '2023-10-04 20:17:19', 1, 15, 'kDmR1BhUOS', 0),
(4, 1, 1, 0, 0, 0, 1, 0, 1, 1, '2023-10-04 20:17:29', 1, 15, 'hUAmfZllYI', 0),
(5, 1, 1, 0, 0, 0, 1, 0, 1, 1, '2023-10-04 20:20:33', 4, 15, '2tvIi7faYT', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`IDCaixa`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IDCategoria`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`IDCliente`);

--
-- Índices de tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`IDColaborador`);

--
-- Índices de tabela `comissionados`
--
ALTER TABLE `comissionados`
  ADD PRIMARY KEY (`IDComissionado`);

--
-- Índices de tabela `comissoes`
--
ALTER TABLE `comissoes`
  ADD PRIMARY KEY (`IDComissao`);

--
-- Índices de tabela `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`IDLote`);

--
-- Índices de tabela `contapagar`
--
ALTER TABLE `contapagar`
  ADD PRIMARY KEY (`IDConta`);

--
-- Índices de tabela `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`IDContaPagar`);

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`IDContrato`);

--
-- Índices de tabela `crediarios`
--
ALTER TABLE `crediarios`
  ADD PRIMARY KEY (`IDCrediario`);

--
-- Índices de tabela `cupons`
--
ALTER TABLE `cupons`
  ADD PRIMARY KEY (`IDCupom`);

--
-- Índices de tabela `custosordem`
--
ALTER TABLE `custosordem`
  ADD PRIMARY KEY (`IDCusto`);

--
-- Índices de tabela `devedores`
--
ALTER TABLE `devedores`
  ADD PRIMARY KEY (`IDDevedor`);

--
-- Índices de tabela `devolucoes`
--
ALTER TABLE `devolucoes`
  ADD PRIMARY KEY (`IDDevolucao`);

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`IDEmpresa`);

--
-- Índices de tabela `filiais`
--
ALTER TABLE `filiais`
  ADD PRIMARY KEY (`IDFilial`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`IDFornecedor`);

--
-- Índices de tabela `ordemservico`
--
ALTER TABLE `ordemservico`
  ADD PRIMARY KEY (`IDOrdem`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`IDPagamento`);

--
-- Índices de tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`IDPlano`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`IDProduto`);

--
-- Índices de tabela `promocionais`
--
ALTER TABLE `promocionais`
  ADD PRIMARY KEY (`IDPromocional`);

--
-- Índices de tabela `promocoes`
--
ALTER TABLE `promocoes`
  ADD PRIMARY KEY (`IDPromocao`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`IDServico`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDUsuario`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`IDVenda`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `IDCaixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `IDCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `IDCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `IDColaborador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `comissionados`
--
ALTER TABLE `comissionados`
  MODIFY `IDComissionado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comissoes`
--
ALTER TABLE `comissoes`
  MODIFY `IDComissao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `compras`
--
ALTER TABLE `compras`
  MODIFY `IDLote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `contapagar`
--
ALTER TABLE `contapagar`
  MODIFY `IDConta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `contas`
--
ALTER TABLE `contas`
  MODIFY `IDContaPagar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `IDContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `crediarios`
--
ALTER TABLE `crediarios`
  MODIFY `IDCrediario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cupons`
--
ALTER TABLE `cupons`
  MODIFY `IDCupom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `custosordem`
--
ALTER TABLE `custosordem`
  MODIFY `IDCusto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `devedores`
--
ALTER TABLE `devedores`
  MODIFY `IDDevedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `devolucoes`
--
ALTER TABLE `devolucoes`
  MODIFY `IDDevolucao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `IDEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `filiais`
--
ALTER TABLE `filiais`
  MODIFY `IDFilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `IDFornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ordemservico`
--
ALTER TABLE `ordemservico`
  MODIFY `IDOrdem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `IDPagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `IDPlano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `IDProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `promocionais`
--
ALTER TABLE `promocionais`
  MODIFY `IDPromocional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `promocoes`
--
ALTER TABLE `promocoes`
  MODIFY `IDPromocao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `IDServico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `IDVenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
