-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2024 a las 22:07:08
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdacademy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acaautor`
--

CREATE TABLE `acaautor` (
  `autor_cod_autor` int(11) NOT NULL,
  `autor_nom_autor` varchar(100) NOT NULL,
  `autor_cod_projc` int(11) NOT NULL,
  `autor_cod_tutor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acacarer`
--

CREATE TABLE `acacarer` (
  `carer_cod_carer` int(11) NOT NULL,
  `carer_nom_carer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acacarer`
--

INSERT INTO `acacarer` (`carer_cod_carer`, `carer_nom_carer`) VALUES
(1, 'Desarrollo de software'),
(2, 'Marketing y gestión de negocios'),
(4, 'Administración financiera'),
(5, 'Contabilidad y asesoría tributaria'),
(6, 'Diseño grafico y multimedia'),
(7, 'Gastronomía'),
(8, 'Seguridad e higiene y trabajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acachats`
--

CREATE TABLE `acachats` (
  `chats_cod_chats` int(11) NOT NULL,
  `chats_time_chats` datetime NOT NULL,
  `chats_imsg_chats` int(255) NOT NULL,
  `chats_omsg_chats` int(255) NOT NULL,
  `chats_read_chats` int(11) NOT NULL,
  `chats_msg_chats` char(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acacolec`
--

CREATE TABLE `acacolec` (
  `colec_cod_colec` int(11) NOT NULL,
  `colec_nom_colec` varchar(200) NOT NULL,
  `colec_cod_carer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acacolec`
--

INSERT INTO `acacolec` (`colec_cod_colec`, `colec_nom_colec`, `colec_cod_carer`) VALUES
(1, 'Tesis - páginas web', 5),
(3, 'Tesis - Ingeniería Comercial', 2),
(4, 'Tesis - Licenciatura en Gestión de la Información Gerencial', 5),
(5, 'Tesis - Ingeniería en Diseño Gráfico Computarizado', 6),
(6, 'Tesis - Ingeniería en Contabilidad y Auditoría CTA', 4),
(7, 'Tesis - Ingeniería en Ecoturismo', 7),
(9, 'Tesis - Emprendimiento', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acaconfig`
--

CREATE TABLE `acaconfig` (
  `config_cod_config` int(11) NOT NULL,
  `config_ifec_config` year(4) NOT NULL,
  `config_ffec_config` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acaconfig`
--

INSERT INTO `acaconfig` (`config_cod_config`, `config_ifec_config`, `config_ffec_config`) VALUES
(5, '2021', '2025'),
(6, '2015', '2022');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acaplbrs`
--

CREATE TABLE `acaplbrs` (
  `plbrs_cod_plbrs` int(11) NOT NULL,
  `plbrs_nom_plbrs` varchar(50) NOT NULL,
  `plbrs_cod_projc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acaposts`
--

CREATE TABLE `acaposts` (
  `posts_cod_posts` int(11) NOT NULL,
  `posts_ips_posts` varchar(20) NOT NULL,
  `posts_file_down` int(11) NOT NULL,
  `posts_fec_posts` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acaposts`
--

INSERT INTO `acaposts` (`posts_cod_posts`, `posts_ips_posts`, `posts_file_down`, `posts_fec_posts`) VALUES
(160, '::1', 0, '2023-01-17'),
(161, '::1', 0, '2023-01-17'),
(162, '::1', 0, '2023-01-17'),
(163, '190.99.77.158', 2, '2024-01-16'),
(164, '190.99.77.158', 1, '2024-01-16'),
(165, '190.99.77.158', 0, '2023-12-16'),
(166, '190.99.77.158', 0, '2024-02-07'),
(167, '190.99.77.158', 0, '2024-02-07'),
(168, '190.99.77.158', 0, '2024-01-16'),
(169, '190.99.77.158', 0, '2023-12-16'),
(170, '190.99.77.158', 0, '2024-03-05'),
(171, '190.99.77.158', 0, '2024-01-16'),
(172, '190.99.77.158', 0, '2024-01-16'),
(173, '190.99.77.158', 0, '2024-01-16'),
(174, '190.99.77.158', 0, '2024-01-16'),
(175, '190.99.77.158', 0, '2024-01-17'),
(176, '190.99.77.158', 1, '2024-01-17'),
(177, '190.99.77.158', 0, '2024-01-17'),
(178, '190.99.77.158', 1, '2024-01-17'),
(179, '190.99.77.158', 0, '2024-01-17'),
(180, '190.99.77.158', 0, '2024-01-17'),
(181, '190.99.77.158', 0, '2024-01-17'),
(182, '190.99.77.158', 0, '2024-01-17'),
(183, '190.99.77.158', 0, '2024-01-17'),
(184, '190.99.77.158', 0, '2024-01-17'),
(185, '190.99.77.158', 0, '2024-01-17'),
(186, '190.99.77.158', 0, '2024-01-17'),
(187, '190.99.77.158', 0, '2024-01-17'),
(188, '190.99.77.158', 0, '2024-01-17'),
(189, '190.99.77.158', 0, '2024-01-17'),
(190, '190.99.77.158', 0, '2024-01-17'),
(191, '190.99.77.158', 0, '2024-01-17'),
(192, '190.99.77.158', 0, '2024-01-18'),
(193, '190.99.77.158', 0, '2024-01-18'),
(194, '190.99.77.158', 0, '2024-01-21'),
(195, '190.99.77.158', 0, '2024-01-21'),
(196, '190.99.77.158', 0, '2024-01-21'),
(197, '190.99.77.158', 0, '2024-01-21'),
(198, '190.99.77.158', 0, '2024-01-21'),
(199, '190.99.77.158', 0, '2024-01-21'),
(200, '190.99.77.158', 0, '2024-01-21'),
(201, '190.99.77.158', 0, '2024-01-21'),
(202, '190.99.77.158', 0, '2024-01-22'),
(203, '190.99.77.158', 0, '2024-01-22'),
(204, '190.99.77.158', 0, '2024-01-22'),
(205, '190.99.77.158', 0, '2024-01-22'),
(206, '190.99.77.158', 0, '2024-01-22'),
(207, '190.99.77.158', 0, '2024-01-22'),
(208, '190.99.77.158', 0, '2024-01-22'),
(209, '190.99.77.158', 0, '2024-01-22'),
(210, '190.99.77.158', 0, '2024-01-22'),
(211, '190.99.77.158', 0, '2024-01-22'),
(212, '200.85.83.17', 0, '2024-01-22'),
(213, '190.99.77.158', 0, '2024-01-22'),
(214, '190.99.77.158', 0, '2024-01-22'),
(215, '190.99.77.158', 0, '2024-01-22'),
(216, '157.100.204.141', 0, '2024-01-22'),
(217, '157.100.204.141', 0, '2024-01-22'),
(218, '157.100.204.141', 0, '2024-01-22'),
(219, '157.100.204.141', 0, '2024-01-22'),
(220, '157.100.204.141', 0, '2024-01-22'),
(221, '190.99.77.158', 0, '2024-01-23'),
(222, '190.99.77.158', 0, '2024-01-23'),
(223, '190.99.77.158', 0, '2024-01-23'),
(224, '190.99.77.158', 1, '2024-01-23'),
(225, '190.99.77.158', 0, '2024-01-23'),
(226, '190.99.77.158', 0, '2024-01-23'),
(227, '190.99.77.158', 0, '2024-01-23'),
(228, '190.99.77.158', 0, '2024-01-23'),
(229, '190.99.77.158', 0, '2024-01-23'),
(230, '190.99.77.158', 0, '2024-01-23'),
(231, '157.100.204.141', 0, '2024-01-23'),
(232, '190.99.77.158', 0, '2024-01-24'),
(233, '190.99.77.158', 0, '2024-01-24'),
(234, '190.99.77.158', 0, '2024-01-24'),
(235, '190.99.77.158', 0, '2024-01-24'),
(236, '190.99.77.158', 1, '2024-01-24'),
(237, '190.99.77.158', 1, '2024-01-24'),
(238, '190.99.77.158', 1, '2024-01-24'),
(239, '190.99.77.158', 0, '2024-01-24'),
(240, '190.99.77.158', 1, '2024-01-24'),
(241, '190.99.77.158', 0, '2024-01-24'),
(242, '190.99.77.158', 0, '2024-01-24'),
(243, '190.99.77.158', 1, '2024-01-24'),
(244, '190.99.77.158', 1, '2024-01-24'),
(245, '190.99.77.158', 9, '2024-01-24'),
(246, '190.99.77.158', 9, '2024-01-24'),
(247, '190.99.77.158', 0, '2024-01-24'),
(248, '190.99.77.158', 9, '2024-01-24'),
(249, '190.99.77.158', 9, '2024-01-24'),
(250, '190.99.77.158', 9, '2024-01-24'),
(251, '190.99.77.158', 9, '2024-01-24'),
(252, '190.99.77.158', 9, '2024-01-24'),
(253, '190.99.77.158', 9, '2024-01-24'),
(254, '190.99.77.158', 0, '2024-01-24'),
(255, '190.99.77.158', 9, '2024-01-24'),
(256, '190.99.77.158', 9, '2024-01-24'),
(257, '190.99.77.158', 9, '2024-01-24'),
(258, '190.99.77.158', 9, '2024-01-24'),
(259, '190.99.77.158', 9, '2024-01-24'),
(260, '190.99.77.158', 0, '2024-01-24'),
(261, '190.99.77.158', 0, '2024-01-24'),
(262, '190.99.77.158', 0, '2024-01-24'),
(263, '190.99.77.158', 0, '2024-01-24'),
(264, '190.99.77.158', 0, '2024-01-24'),
(265, '190.99.77.158', 9, '2024-01-24'),
(266, '190.99.77.158', 0, '2024-01-24'),
(267, '190.99.77.158', 9, '2024-01-24'),
(268, '190.99.74.145', 0, '2024-01-25'),
(269, '190.99.74.145', 9, '2024-01-25'),
(270, '190.99.74.145', 9, '2024-01-25'),
(271, '190.99.74.145', 0, '2024-01-25'),
(272, '190.99.74.145', 0, '2024-01-25'),
(273, '190.99.74.145', 0, '2024-01-25'),
(274, '190.99.74.145', 9, '2024-01-25'),
(275, '190.99.74.145', 0, '2024-01-25'),
(276, '200.85.83.48', 0, '2024-01-26'),
(277, '200.85.83.48', 9, '2024-01-26'),
(278, '200.85.83.48', 9, '2024-01-26'),
(279, '200.85.83.48', 0, '2024-01-26'),
(280, '200.85.83.48', 9, '2024-01-26'),
(281, '200.85.83.48', 9, '2024-01-26'),
(282, '200.85.83.48', 0, '2024-01-26'),
(283, '190.99.75.197', 0, '2024-01-28'),
(284, '190.99.75.197', 0, '2024-01-28'),
(285, '190.99.75.197', 0, '2024-01-28'),
(286, '65.154.226.168', 0, '2024-01-29'),
(287, '181.211.10.245', 0, '2024-01-30'),
(288, '190.99.75.197', 0, '2024-01-30'),
(289, '190.99.75.197', 0, '2024-01-30'),
(290, '190.99.75.197', 0, '2024-01-30'),
(291, '190.99.75.197', 11, '2024-01-30'),
(292, '190.99.75.197', 0, '2024-01-30'),
(293, '190.99.75.197', 0, '2024-01-30'),
(294, '190.99.75.197', 0, '2024-01-31'),
(295, '190.99.75.197', 0, '2024-01-31'),
(296, '190.99.75.197', 0, '2024-01-31'),
(297, '190.99.75.197', 0, '2024-01-31'),
(298, '190.99.75.197', 0, '2024-01-31'),
(299, '200.85.80.134', 0, '2024-01-31'),
(300, '200.85.80.134', 0, '2024-01-31'),
(301, '200.85.80.134', 11, '2024-01-31'),
(302, '200.24.141.250', 0, '2024-01-31'),
(303, '200.24.141.250', 0, '2024-01-31'),
(304, '200.24.141.250', 0, '2024-01-31'),
(305, '200.24.141.250', 0, '2024-01-31'),
(306, '200.24.141.250', 0, '2024-01-31'),
(307, '200.24.141.250', 0, '2024-01-31'),
(308, '200.24.141.250', 0, '2024-01-31'),
(309, '181.175.209.142', 0, '2024-01-31'),
(310, '181.175.209.142', 0, '2024-01-31'),
(311, '200.24.141.251', 0, '2024-01-31'),
(312, '200.24.141.251', 0, '2024-01-31'),
(313, '200.24.141.251', 0, '2024-01-31'),
(314, '200.24.141.251', 0, '2024-01-31'),
(315, '200.24.141.251', 0, '2024-01-31'),
(316, '190.99.75.197', 0, '2024-02-01'),
(317, '190.99.75.197', 0, '2024-02-01'),
(318, '190.99.75.197', 0, '2024-02-01'),
(319, '190.99.75.197', 0, '2024-02-01'),
(320, '190.99.75.197', 0, '2024-02-01'),
(321, '190.99.75.197', 0, '2024-02-01'),
(322, '200.7.247.231', 0, '2024-02-01'),
(323, '200.7.247.231', 0, '2024-02-01'),
(324, '200.7.247.231', 0, '2024-02-01'),
(325, '200.7.247.231', 0, '2024-02-01'),
(326, '190.99.75.197', 0, '2024-02-01'),
(327, '190.99.75.197', 0, '2024-02-03'),
(328, '190.99.75.197', 0, '2024-02-03'),
(329, '190.99.75.197', 0, '2024-02-03'),
(330, '190.99.75.197', 0, '2024-02-03'),
(331, '190.99.75.197', 0, '2024-02-03'),
(332, '190.99.75.197', 0, '2024-02-03'),
(333, '190.99.75.197', 0, '2024-02-03'),
(334, '190.99.75.197', 0, '2024-02-03'),
(335, '190.99.75.197', 0, '2024-02-03'),
(336, '190.99.75.197', 0, '2024-02-03'),
(337, '190.99.75.197', 0, '2024-02-03'),
(338, '190.99.75.197', 0, '2024-02-03'),
(339, '190.99.75.197', 0, '2024-02-04'),
(340, '190.99.75.197', 0, '2024-02-04'),
(341, '190.99.75.197', 0, '2024-02-04'),
(342, '190.99.75.197', 0, '2024-02-04'),
(343, '190.99.75.197', 0, '2024-02-04'),
(344, '190.99.75.197', 0, '2024-02-04'),
(345, '190.99.75.197', 0, '2024-02-04'),
(346, '190.99.75.197', 0, '2024-02-04'),
(347, '190.99.75.197', 0, '2024-02-05'),
(348, '190.99.75.197', 0, '2024-02-05'),
(349, '190.99.75.197', 0, '2024-02-05'),
(350, '190.99.75.197', 0, '2024-02-05'),
(351, '190.99.75.197', 0, '2024-02-05'),
(352, '190.99.75.197', 0, '2024-02-05'),
(353, '190.99.75.197', 0, '2024-02-05'),
(354, '190.99.75.197', 0, '2024-02-05'),
(355, '190.99.75.197', 0, '2024-02-05'),
(356, '200.85.83.101', 0, '2024-02-05'),
(357, '200.85.83.101', 0, '2024-02-05'),
(358, '200.85.83.101', 11, '2024-02-05'),
(359, '200.7.247.70', 0, '2024-02-05'),
(360, '200.7.247.70', 0, '2024-02-05'),
(361, '190.99.75.197', 0, '2024-02-06'),
(362, '190.99.75.197', 0, '2024-02-06'),
(363, '190.99.75.197', 0, '2024-02-06'),
(364, '190.99.75.197', 0, '2024-02-06'),
(365, '190.99.75.197', 0, '2024-02-06'),
(366, '190.99.75.197', 0, '2024-02-06'),
(367, '190.99.75.197', 0, '2024-02-06'),
(368, '200.7.247.104', 0, '2024-02-06'),
(369, '200.7.247.104', 0, '2024-02-06'),
(370, '200.7.247.104', 0, '2024-02-06'),
(371, '200.7.247.104', 0, '2024-02-06'),
(372, '200.7.247.104', 0, '2024-02-06'),
(373, '200.7.247.104', 0, '2024-02-06'),
(374, '200.7.247.104', 0, '2024-02-06'),
(375, '190.99.75.197', 0, '2024-02-07'),
(376, '190.99.75.197', 0, '2024-02-07'),
(377, '190.99.75.197', 0, '2024-02-07'),
(378, '190.99.75.197', 0, '2024-02-07'),
(379, '190.99.75.197', 0, '2024-02-07'),
(380, '190.99.75.197', 0, '2024-02-07'),
(381, '190.99.75.197', 0, '2024-02-07'),
(382, '190.99.75.197', 0, '2024-02-07'),
(383, '190.99.75.197', 0, '2024-02-07'),
(384, '181.211.10.245', 0, '2024-02-07'),
(385, '181.211.10.245', 1, '2024-02-07'),
(386, '181.211.10.245', 0, '2024-02-07'),
(387, '181.211.10.245', 0, '2024-02-07'),
(388, '181.211.10.245', 1, '2024-02-07'),
(389, '181.211.10.245', 1, '2024-02-07'),
(390, '190.99.75.197', 0, '2024-02-07'),
(391, '190.99.75.197', 0, '2024-02-07'),
(392, '190.99.75.197', 0, '2024-02-07'),
(393, '190.99.75.197', 0, '2024-02-07'),
(394, '190.99.75.197', 0, '2024-02-07'),
(395, '190.99.75.197', 1, '2024-02-07'),
(396, '181.211.10.245', 0, '2024-02-08'),
(397, '181.211.10.245', 1, '2024-02-08'),
(398, '190.99.75.197', 0, '2024-02-09'),
(399, '190.99.75.197', 0, '2024-02-09'),
(400, '190.99.75.197', 0, '2024-02-09'),
(401, '190.99.75.197', 0, '2024-02-09'),
(402, '190.99.75.197', 0, '2024-02-10'),
(403, '190.99.75.197', 0, '2024-02-10'),
(404, '190.99.75.197', 0, '2024-02-10'),
(405, '190.99.75.197', 0, '2024-02-10'),
(406, '190.99.75.197', 0, '2024-02-10'),
(407, '190.99.75.197', 0, '2024-02-10'),
(408, '190.99.75.197', 0, '2024-02-10'),
(409, '190.99.75.197', 0, '2024-02-10'),
(410, '190.99.75.197', 0, '2024-02-10'),
(411, '190.99.75.197', 0, '2024-02-10'),
(412, '190.99.75.197', 0, '2024-02-10'),
(413, '190.99.75.197', 0, '2024-02-11'),
(414, '190.99.75.197', 0, '2024-02-11'),
(415, '190.99.75.197', 0, '2024-02-12'),
(416, '190.99.75.197', 0, '2024-02-12'),
(417, '190.99.75.197', 0, '2024-02-12'),
(418, '190.99.75.197', 0, '2024-02-12'),
(419, '190.99.75.197', 0, '2024-02-12'),
(420, '190.99.75.197', 0, '2024-02-12'),
(421, '190.99.75.197', 0, '2024-02-13'),
(422, '190.99.75.197', 0, '2024-02-13'),
(423, '190.99.75.197', 0, '2024-02-13'),
(424, '190.99.75.197', 0, '2024-02-13'),
(425, '190.99.75.197', 0, '2024-02-13'),
(426, '190.99.75.197', 0, '2024-02-13'),
(427, '190.99.75.197', 0, '2024-02-13'),
(428, '190.99.75.197', 0, '2024-02-13'),
(429, '190.99.75.197', 11, '2024-02-13'),
(430, '190.99.75.197', 0, '2024-02-13'),
(431, '190.99.75.197', 0, '2024-02-13'),
(432, '190.99.75.197', 0, '2024-02-13'),
(433, '190.99.75.197', 0, '2024-02-13'),
(434, '190.99.75.197', 0, '2024-02-13'),
(435, '190.99.75.197', 9, '2024-02-13'),
(436, '190.99.75.197', 0, '2024-02-13'),
(437, '190.99.75.197', 0, '2024-02-13'),
(438, '190.99.75.197', 15, '2024-02-13'),
(439, '190.99.75.197', 15, '2024-02-13'),
(440, '190.99.75.197', 0, '2024-02-13'),
(441, '190.99.75.197', 1, '2024-02-13'),
(442, '190.99.75.197', 1, '2024-02-13'),
(443, '190.99.75.197', 16, '2024-02-13'),
(444, '190.99.75.197', 16, '2024-02-13'),
(445, '190.99.75.197', 0, '2024-02-13'),
(446, '190.99.75.197', 9, '2024-02-13'),
(447, '190.99.75.197', 0, '2024-02-13'),
(448, '190.99.75.197', 9, '2024-02-13'),
(449, '190.99.75.197', 9, '2024-02-13'),
(450, '190.99.75.197', 0, '2024-02-13'),
(451, '190.99.75.197', 0, '2024-02-13'),
(452, '190.99.75.197', 0, '2024-02-13'),
(453, '190.99.75.197', 0, '2024-02-13'),
(454, '190.99.75.197', 0, '2024-02-13'),
(455, '190.99.75.197', 0, '2024-02-13'),
(456, '190.99.75.197', 18, '2024-02-13'),
(457, '190.99.75.197', 18, '2024-02-13'),
(458, '190.99.75.197', 0, '2024-02-13'),
(459, '190.99.75.197', 0, '2024-02-13'),
(460, '190.99.75.197', 0, '2024-02-13'),
(461, '190.99.75.197', 0, '2024-02-13'),
(462, '190.99.75.197', 18, '2024-02-13'),
(463, '190.99.75.197', 18, '2024-02-13'),
(464, '190.99.75.197', 19, '2024-02-13'),
(465, '190.99.75.197', 19, '2024-02-13'),
(466, '190.99.75.197', 0, '2024-02-13'),
(467, '190.99.75.197', 0, '2024-02-13'),
(468, '190.99.75.197', 0, '2024-02-14'),
(469, '190.99.75.197', 0, '2024-02-14'),
(470, '190.99.75.197', 0, '2024-02-14'),
(471, '190.99.75.197', 9, '2024-02-14'),
(472, '190.99.75.197', 0, '2024-02-14'),
(473, '190.99.75.197', 0, '2024-02-14'),
(474, '190.99.75.197', 1, '2024-02-14'),
(475, '190.99.75.197', 0, '2024-02-14'),
(476, '190.99.75.197', 0, '2024-02-14'),
(477, '190.99.75.197', 19, '2024-02-14'),
(478, '190.99.75.197', 0, '2024-02-14'),
(479, '190.99.75.197', 0, '2024-02-14'),
(480, '190.99.75.197', 0, '2024-02-14'),
(481, '190.99.75.197', 0, '2024-02-14'),
(482, '190.99.75.197', 0, '2024-02-14'),
(483, '190.99.75.197', 0, '2024-02-14'),
(484, '190.99.75.197', 11, '2024-02-14'),
(485, '190.99.75.197', 0, '2024-02-14'),
(486, '181.211.10.245', 0, '2024-02-14'),
(487, '181.211.10.245', 0, '2024-02-14'),
(488, '45.183.137.105', 0, '2024-02-14'),
(489, '190.99.75.197', 0, '2024-02-14'),
(490, '190.99.75.197', 0, '2024-02-14'),
(491, '190.99.75.197', 0, '2024-02-14'),
(492, '190.99.75.197', 0, '2024-02-15'),
(493, '190.99.75.197', 0, '2024-02-15'),
(494, '190.99.75.197', 0, '2024-02-15'),
(495, '190.99.75.197', 0, '2024-02-15'),
(496, '190.99.75.197', 0, '2024-02-15'),
(497, '190.99.75.197', 0, '2024-02-15'),
(498, '190.99.75.197', 0, '2024-02-15'),
(499, '190.99.75.197', 0, '2024-02-15'),
(500, '190.99.75.197', 0, '2024-02-15'),
(501, '190.99.75.197', 0, '2024-02-16'),
(502, '190.99.75.197', 0, '2024-02-16'),
(503, '190.99.75.197', 0, '2024-02-16'),
(504, '181.211.10.245', 0, '2024-02-16'),
(505, '190.99.75.197', 0, '2024-02-17'),
(506, '190.99.75.197', 0, '2024-02-17'),
(507, '190.99.75.197', 0, '2024-02-17'),
(508, 'v', 0, '2024-05-11'),
(509, 'v', 0, '2024-05-11'),
(510, 'v', 0, '2024-05-11'),
(511, 'v', 0, '2024-05-11'),
(512, 'v', 0, '2024-05-11'),
(513, 'v', 0, '2024-05-22'),
(514, 'v', 0, '2024-05-22'),
(515, 'v', 0, '2024-05-22'),
(516, 'v', 0, '2024-05-22'),
(517, 'v', 0, '2024-05-23'),
(518, 'v', 0, '2024-05-23'),
(519, 'v', 0, '2024-05-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acaprojc`
--

CREATE TABLE `acaprojc` (
  `projc_cod_projc` int(11) NOT NULL,
  `projc_mat_projc` varchar(50) NOT NULL,
  `projc_tit_projc` varchar(200) NOT NULL,
  `projc_fec_projc` date NOT NULL,
  `projc_ubi_projc` varchar(200) NOT NULL,
  `projc_rem_projc` text NOT NULL,
  `projc_fil_projc` text NOT NULL,
  `projc_cod_colec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acasolic`
--

CREATE TABLE `acasolic` (
  `solic_cod_solic` int(11) NOT NULL,
  `solic_cod_users` int(11) NOT NULL,
  `solic_prj_solic` text NOT NULL,
  `solic_ubi_solic` text NOT NULL,
  `solic_mot_solic` text NOT NULL,
  `solic_rev_solic` int(11) NOT NULL,
  `solic_fil_solic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acatutor`
--

CREATE TABLE `acatutor` (
  `tutor_cod_tutor` int(11) NOT NULL,
  `tutor_nom_tutor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acatutor`
--

INSERT INTO `acatutor` (`tutor_cod_tutor`, `tutor_nom_tutor`) VALUES
(1, 'Lorena Paucar'),
(2, 'Merino, Milton'),
(3, 'Salazar Tapia, Mónica Patricia'),
(4, 'Parra, Ximena'),
(5, 'Espín, Lorena'),
(6, 'Vizcaíno, Juan; Phd'),
(7, 'Guevara Aguay, Amparo Elizabeth,'),
(8, 'Ulloa, Carmen'),
(9, 'Hidalgo, Myrian'),
(11, 'IUUW'),
(17, 'XXXX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acausers`
--

CREATE TABLE `acausers` (
  `users_cod_users` int(11) NOT NULL,
  `users_usr_users` varchar(50) NOT NULL,
  `users_nom_users` varchar(50) NOT NULL,
  `users_eml_users` varchar(50) NOT NULL,
  `users_pas_users` varchar(255) NOT NULL,
  `users_fec_users` date NOT NULL,
  `users_bit_users` time NOT NULL,
  `users_bio_users` text NOT NULL,
  `users_ocu_users` varchar(50) NOT NULL,
  `users_img_users` text NOT NULL,
  `users_sts_users` int(11) NOT NULL,
  `users_hash_users` text NOT NULL,
  `users_val_users` int(11) NOT NULL,
  `users_res_users` int(11) NOT NULL,
  `users_typ_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acausers`
--

INSERT INTO `acausers` (`users_cod_users`, `users_usr_users`, `users_nom_users`, `users_eml_users`, `users_pas_users`, `users_fec_users`, `users_bit_users`, `users_bio_users`, `users_ocu_users`, `users_img_users`, `users_sts_users`, `users_hash_users`, `users_val_users`, `users_res_users`, `users_typ_users`) VALUES
(1, 'admin', 'admin1', 'admin@gmail.com', '$2y$10$/afW9fdI1FBMNbzPjVbKJ.b1DO.rov6QZFMKmfJW4FN66AlEafEuO', '2023-09-15', '15:05:59', 'Usuario testeado', 'Ninguna', '', 0, '0', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acaxchat`
--

CREATE TABLE `acaxchat` (
  `xchat_cod_xchat` int(11) NOT NULL,
  `xchat_imsg_xchat` int(11) NOT NULL,
  `xchat_omsg_xchat` int(11) NOT NULL,
  `xchat_bell_xchat` int(11) NOT NULL,
  `xchat_evn_xchat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acaautor`
--
ALTER TABLE `acaautor`
  ADD PRIMARY KEY (`autor_cod_autor`),
  ADD KEY `autor_fdk_projc` (`autor_cod_projc`),
  ADD KEY `autor_fk_tutor` (`autor_cod_tutor`);

--
-- Indices de la tabla `acacarer`
--
ALTER TABLE `acacarer`
  ADD PRIMARY KEY (`carer_cod_carer`);

--
-- Indices de la tabla `acachats`
--
ALTER TABLE `acachats`
  ADD PRIMARY KEY (`chats_cod_chats`),
  ADD KEY `chats_fk_imsg` (`chats_imsg_chats`),
  ADD KEY `chats_fk_omsg` (`chats_omsg_chats`);

--
-- Indices de la tabla `acacolec`
--
ALTER TABLE `acacolec`
  ADD PRIMARY KEY (`colec_cod_colec`),
  ADD KEY `colec_fk_carer` (`colec_cod_carer`);

--
-- Indices de la tabla `acaconfig`
--
ALTER TABLE `acaconfig`
  ADD PRIMARY KEY (`config_cod_config`);

--
-- Indices de la tabla `acaplbrs`
--
ALTER TABLE `acaplbrs`
  ADD PRIMARY KEY (`plbrs_cod_plbrs`),
  ADD KEY `plbrs_cod_projc` (`plbrs_cod_projc`);

--
-- Indices de la tabla `acaposts`
--
ALTER TABLE `acaposts`
  ADD PRIMARY KEY (`posts_cod_posts`);

--
-- Indices de la tabla `acaprojc`
--
ALTER TABLE `acaprojc`
  ADD PRIMARY KEY (`projc_cod_projc`),
  ADD KEY `projc_fk_colec` (`projc_cod_colec`);

--
-- Indices de la tabla `acasolic`
--
ALTER TABLE `acasolic`
  ADD PRIMARY KEY (`solic_cod_solic`),
  ADD KEY `solic_fk_users` (`solic_cod_users`);

--
-- Indices de la tabla `acatutor`
--
ALTER TABLE `acatutor`
  ADD PRIMARY KEY (`tutor_cod_tutor`);

--
-- Indices de la tabla `acausers`
--
ALTER TABLE `acausers`
  ADD PRIMARY KEY (`users_cod_users`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acaautor`
--
ALTER TABLE `acaautor`
  MODIFY `autor_cod_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `acacarer`
--
ALTER TABLE `acacarer`
  MODIFY `carer_cod_carer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `acachats`
--
ALTER TABLE `acachats`
  MODIFY `chats_cod_chats` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `acacolec`
--
ALTER TABLE `acacolec`
  MODIFY `colec_cod_colec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `acaconfig`
--
ALTER TABLE `acaconfig`
  MODIFY `config_cod_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `acaplbrs`
--
ALTER TABLE `acaplbrs`
  MODIFY `plbrs_cod_plbrs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `acaposts`
--
ALTER TABLE `acaposts`
  MODIFY `posts_cod_posts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;

--
-- AUTO_INCREMENT de la tabla `acaprojc`
--
ALTER TABLE `acaprojc`
  MODIFY `projc_cod_projc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `acasolic`
--
ALTER TABLE `acasolic`
  MODIFY `solic_cod_solic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `acatutor`
--
ALTER TABLE `acatutor`
  MODIFY `tutor_cod_tutor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `acausers`
--
ALTER TABLE `acausers`
  MODIFY `users_cod_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acaautor`
--
ALTER TABLE `acaautor`
  ADD CONSTRAINT `autor_fk_projc` FOREIGN KEY (`autor_cod_projc`) REFERENCES `acaprojc` (`projc_cod_projc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `autor_fk_tutor` FOREIGN KEY (`autor_cod_tutor`) REFERENCES `acatutor` (`tutor_cod_tutor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `acachats`
--
ALTER TABLE `acachats`
  ADD CONSTRAINT `chats_fk_imsg` FOREIGN KEY (`chats_imsg_chats`) REFERENCES `acausers` (`users_cod_users`),
  ADD CONSTRAINT `chats_fk_omsg` FOREIGN KEY (`chats_omsg_chats`) REFERENCES `acausers` (`users_cod_users`);

--
-- Filtros para la tabla `acacolec`
--
ALTER TABLE `acacolec`
  ADD CONSTRAINT `colec_fk_carer` FOREIGN KEY (`colec_cod_carer`) REFERENCES `acacarer` (`carer_cod_carer`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `acaplbrs`
--
ALTER TABLE `acaplbrs`
  ADD CONSTRAINT `plbrs_cod_projc` FOREIGN KEY (`plbrs_cod_projc`) REFERENCES `acaprojc` (`projc_cod_projc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `acaprojc`
--
ALTER TABLE `acaprojc`
  ADD CONSTRAINT `projc_fk_colec` FOREIGN KEY (`projc_cod_colec`) REFERENCES `acacolec` (`colec_cod_colec`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `acasolic`
--
ALTER TABLE `acasolic`
  ADD CONSTRAINT `solic_fk_users` FOREIGN KEY (`solic_cod_users`) REFERENCES `acausers` (`users_cod_users`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
