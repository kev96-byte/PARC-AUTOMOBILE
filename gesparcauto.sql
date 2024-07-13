-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 08, 2024 at 09:11 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gesparcauto`
--

-- --------------------------------------------------------

--
-- Table structure for table `chauffeur`
--

DROP TABLE IF EXISTS `chauffeur`;
CREATE TABLE IF NOT EXISTS `chauffeur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institution_id` int DEFAULT NULL,
  `nom_chauffeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_chauffeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_chauffeur` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_permis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_chauffeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `matricule_chauffeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5CA777B810405986` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chauffeur`
--

INSERT INTO `chauffeur` (`id`, `institution_id`, `nom_chauffeur`, `prenom_chauffeur`, `telephone_chauffeur`, `num_permis`, `etat_chauffeur`, `delete_at`, `matricule_chauffeur`) VALUES
(1, 8, 'ADJE', 'ANTONIN', NULL, 'BEN-123456-21', 'EN SERVICE', NULL, '234567'),
(2, 8, 'BOSSOU', 'AUGUSTIN', '95689078', 'BEN-083456-19', 'EN SERVICE', NULL, 'BOSSOU'),
(3, 12, 'KPOCAME', 'SERAPHIN', NULL, 'BEN-223433-20', 'EN CONGE', NULL, '113025'),
(4, 12, 'ZABADA', 'RICHARD', NULL, 'BEN-183456-21', 'EN CONGE', NULL, '109876'),
(5, 8, 'AHOUI', 'RICHARD', '95689078', 'BEN-123456-21', 'EN SERVICE', '2024-07-04 05:31:24', '234568');

-- --------------------------------------------------------

--
-- Table structure for table `commune`
--

DROP TABLE IF EXISTS `commune`;
CREATE TABLE IF NOT EXISTS `commune` (
  `id` int NOT NULL AUTO_INCREMENT,
  `departement_id` int DEFAULT NULL,
  `libelle_commune` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_E2E2D1EECCF9E01E` (`departement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commune`
--

INSERT INTO `commune` (`id`, `departement_id`, `libelle_commune`, `delete_at`) VALUES
(1, 1, 'Malanvile', NULL),
(2, 1, 'Karimama', NULL),
(3, 1, 'Banikoara', NULL),
(4, 1, 'Kandi', NULL),
(5, 1, 'Gogounou', NULL),
(6, 1, 'Segbana', NULL),
(7, 2, 'Natitingou', NULL),
(8, 2, 'Boukoumbe', NULL),
(9, 2, 'Toucoutouna', NULL),
(10, 2, 'Tanguiéta', NULL),
(11, 2, 'Materi', NULL),
(12, 2, 'Cobly', NULL),
(13, 2, 'Kouande', NULL),
(14, 2, 'Kérou', NULL),
(15, 2, 'Ouassa-Péhunco', NULL),
(16, 3, 'Bembèrèkè', NULL),
(17, 3, 'Sinende', NULL),
(18, 3, 'Parakou', NULL),
(19, 3, 'N\'dali', NULL),
(20, 3, 'Nikki', NULL),
(21, 3, 'Kalale', NULL),
(22, 3, 'Perere', NULL),
(23, 3, 'Tchaourou', NULL),
(24, 4, 'Djougou', NULL),
(25, 4, 'Copargo', NULL),
(26, 4, 'Ouake', NULL),
(27, 4, 'Bassila', NULL),
(28, 5, 'Dassa-Zoumè', NULL),
(29, 5, 'Glazoué', NULL),
(30, 5, 'Savalou', NULL),
(31, 5, 'Bantè', NULL),
(32, 5, 'Savè', NULL),
(33, 5, 'Ouèssè', NULL),
(34, 6, 'Zogbodomey', NULL),
(35, 6, 'Bohicon', NULL),
(36, 6, 'Za-Kpota', NULL),
(37, 6, 'Abomey', NULL),
(38, 6, 'Djidja', NULL),
(39, 6, 'Agbangnizoun', NULL),
(40, 6, 'Covè', NULL),
(41, 6, 'Zangnanado', NULL),
(42, 6, 'Ouinhi', NULL),
(43, 7, 'Lokossa', NULL),
(44, 7, 'Athiémé', NULL),
(45, 7, 'Comè', NULL),
(46, 7, 'Bopa', NULL),
(47, 7, 'Houéyogbé', NULL),
(48, 7, 'Grand-Popo', NULL),
(49, 8, 'Klouékanme', NULL),
(50, 8, 'Lalo', NULL),
(51, 8, 'Toviklin', NULL),
(52, 8, 'Aplahoue', NULL),
(53, 8, 'Djakotomey', NULL),
(54, 8, 'Dogbo', NULL),
(55, 9, 'Sakété', NULL),
(56, 9, 'Ifangni', NULL),
(57, 9, 'Pobè', NULL),
(58, 9, 'Kétou', NULL),
(59, 9, 'Adja-Ouerre', NULL),
(60, 10, 'Porto-Novo', NULL),
(61, 10, 'Sèmè-Podji', NULL),
(62, 10, 'Aguégués', NULL),
(63, 10, 'Adjarra', NULL),
(64, 10, 'Akpro-Misserete', NULL),
(65, 10, 'Avrankou', NULL),
(66, 10, 'Adjohoun', NULL),
(67, 10, 'Bonou', NULL),
(68, 10, 'Dangbo', NULL),
(69, 11, 'Abomey-Calavi', NULL),
(70, 11, 'So-Ava', NULL),
(71, 11, 'Allada', NULL),
(72, 11, 'Toffo', NULL),
(73, 11, 'Zè', NULL),
(74, 11, 'Ouidah', NULL),
(75, 11, 'Kpomassè', NULL),
(76, 11, 'Tori-Bossito', NULL),
(77, 12, 'Cotonou', NULL),
(78, 1, 'zzzzzzzzzzzzzzzzz', '2024-07-01 22:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE IF NOT EXISTS `demande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `demander_id` int DEFAULT NULL,
  `validateur_structure_id` int DEFAULT NULL,
  `traite_par_id` int DEFAULT NULL,
  `num_demande` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_demande` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `objet_mission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut_mission` date DEFAULT NULL,
  `date_fin_mission` date DEFAULT NULL,
  `nbre_participants` int NOT NULL,
  `nbre_vehicules` int NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieuMission` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2694D7A54C21AB48` (`demander_id`),
  KEY `IDX_2694D7A5DF4C0F3E` (`validateur_structure_id`),
  KEY `IDX_2694D7A5167FABE8` (`traite_par_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande`
--

INSERT INTO `demande` (`id`, `demander_id`, `validateur_structure_id`, `traite_par_id`, `num_demande`, `date_demande`, `objet_mission`, `date_debut_mission`, `date_fin_mission`, `nbre_participants`, `nbre_vehicules`, `delete_at`, `statut`, `lieuMission`) VALUES
(17, 2, NULL, NULL, NULL, '2024-07-05 18:08:49', 'eSIGL', '2024-07-05', '2024-07-06', 4, 2, NULL, 'INITIAL', '[{}]'),
(18, 2, NULL, NULL, NULL, '2024-07-05 18:12:40', 'eSIGL', '2024-07-05', '2024-07-06', 4, 2, NULL, 'INITIAL', '[{}]'),
(19, 2, NULL, NULL, NULL, '2024-07-05 18:15:42', 'eSIGL', '2024-07-05', '2024-07-06', 4, 2, NULL, NULL, '[{}]'),
(20, 2, NULL, NULL, NULL, '2024-07-05 18:18:33', 'eSIGL', '2024-07-05', '2024-07-06', 4, 2, NULL, NULL, '[{}]'),
(21, 2, NULL, NULL, NULL, '2024-07-05 18:19:40', 'eSIGL', '2024-07-05', '2024-07-06', 4, 2, NULL, NULL, '[{}]'),
(22, 2, NULL, NULL, NULL, '2024-07-05 18:23:26', 'eSIGL', '2024-07-13', '2024-07-12', 4, 2, NULL, NULL, '[{}]'),
(23, 2, NULL, NULL, NULL, '2024-07-05 18:26:37', 'eSIGL', '2024-07-05', '2024-07-06', 4, 2, NULL, 'INITIAL', '[{}]'),
(24, 2, NULL, NULL, NULL, '2024-07-06 05:51:31', 'eSIGL', '2024-07-06', '2024-07-13', 4, 2, NULL, 'INITIAL', '[{}]'),
(25, 2, NULL, NULL, NULL, '2024-07-06 06:25:10', 'eSIGL', '2024-07-05', '2024-07-26', 4, 2, NULL, 'INITIAL', '[{}]'),
(26, 2, NULL, NULL, NULL, '2024-07-06 06:33:42', 'eSIGL', '2024-07-06', '2024-07-07', 4, 2, NULL, 'INITIAL', '[{}]'),
(27, 2, NULL, NULL, NULL, '2024-07-06 06:37:50', 'eSIGL', '2024-07-06', '2024-07-06', 4, 2, NULL, 'INITIAL', '[{}]'),
(28, 2, NULL, NULL, NULL, NULL, 'eSIGL', '2024-07-06', '2024-07-19', 4, 2, NULL, 'INITIAL', '[{}]'),
(29, 2, NULL, NULL, NULL, NULL, 'eLEARNING', '2024-07-06', '2024-07-27', 4, 2, NULL, 'INITIAL', '[{}]'),
(30, 2, NULL, NULL, NULL, '2024-07-06 00:00:00', 'eSIGL', '2024-07-06', '2024-07-13', 4, 2, NULL, 'INITIAL', '[{}]'),
(31, 2, NULL, NULL, NULL, '2024-07-06 00:00:00', 'eLEARNING', '2024-07-06', '2024-07-12', 4, 2, NULL, 'INITIAL', '[{}]'),
(32, 2, NULL, NULL, NULL, NULL, 'eSIGL', '2024-07-06', '2024-07-07', 4, 2, NULL, 'INITIAL', '[{}]'),
(33, 2, NULL, NULL, NULL, '2024-07-06 07:43:46', 'eLEARNING', '2024-07-06', '2024-07-07', 4, 2, NULL, 'INITIAL', '[{}]');

-- --------------------------------------------------------

--
-- Table structure for table `demande_commune`
--

DROP TABLE IF EXISTS `demande_commune`;
CREATE TABLE IF NOT EXISTS `demande_commune` (
  `commune_id` int NOT NULL,
  PRIMARY KEY (`commune_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departement`
--

INSERT INTO `departement` (`id`, `libelle_departement`, `delete_at`) VALUES
(1, 'Alibori', NULL),
(2, 'Atacora', NULL),
(3, 'Borgou', NULL),
(4, 'Donga', NULL),
(5, 'Collines', NULL),
(6, 'Zou', NULL),
(7, 'Mono', NULL),
(8, 'Couffo', NULL),
(9, 'Plateau', NULL),
(10, 'Ouémé', NULL),
(11, 'Atlantique', NULL),
(12, 'Littoral', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240617123051', '2024-06-17 12:31:07', 1086),
('DoctrineMigrations\\Version20240628151507', '2024-06-28 15:15:19', 56),
('DoctrineMigrations\\Version20240701082417', '2024-07-01 08:24:36', 220),
('DoctrineMigrations\\Version20240701142939', '2024-07-01 14:29:44', 177),
('DoctrineMigrations\\Version20240701162315', '2024-07-01 16:23:26', 224),
('DoctrineMigrations\\Version20240702052413', '2024-07-02 05:24:24', 167),
('DoctrineMigrations\\Version20240702092124', '2024-07-02 09:21:31', 27),
('DoctrineMigrations\\Version20240702102418', '2024-07-02 10:24:23', 20),
('DoctrineMigrations\\Version20240702131732', '2024-07-02 13:17:52', 546),
('DoctrineMigrations\\Version20240703133727', '2024-07-03 13:37:51', 342),
('DoctrineMigrations\\Version20240704035104', '2024-07-04 03:51:23', 85),
('DoctrineMigrations\\Version20240704044812', '2024-07-04 04:48:16', 67),
('DoctrineMigrations\\Version20240704065735', '2024-07-04 06:57:42', 78),
('DoctrineMigrations\\Version20240704072810', '2024-07-04 07:28:16', 55),
('DoctrineMigrations\\Version20240704075843', '2024-07-04 07:58:48', 165),
('DoctrineMigrations\\Version20240704095643', '2024-07-04 09:56:52', 695),
('DoctrineMigrations\\Version20240704095830', '2024-07-04 09:58:36', 78),
('DoctrineMigrations\\Version20240704163541', '2024-07-04 16:35:47', 144),
('DoctrineMigrations\\Version20240704181856', '2024-07-04 18:19:07', 133),
('DoctrineMigrations\\Version20240704201820', '2024-07-04 20:18:26', 95),
('DoctrineMigrations\\Version20240705083207', '2024-07-05 08:32:52', 226),
('DoctrineMigrations\\Version20240705083748', '2024-07-05 08:37:55', 178),
('DoctrineMigrations\\Version20240705085400', '2024-07-05 08:54:05', 47),
('DoctrineMigrations\\Version20240705114340', '2024-07-05 11:43:46', 72),
('DoctrineMigrations\\Version20240705123039', '2024-07-05 12:30:48', 138),
('DoctrineMigrations\\Version20240705150523', '2024-07-05 15:40:50', 64),
('DoctrineMigrations\\Version20240705154046', '2024-07-05 15:40:50', 8),
('DoctrineMigrations\\Version20240705175142', '2024-07-05 17:51:45', 156),
('DoctrineMigrations\\Version20240705180338', '2024-07-05 18:03:43', 116),
('DoctrineMigrations\\Version20240706090917', '2024-07-06 09:09:27', 125),
('DoctrineMigrations\\Version20240707164308', '2024-07-07 16:44:24', 60),
('DoctrineMigrations\\Version20240708150653', '2024-07-08 15:07:07', 170);

-- --------------------------------------------------------

--
-- Table structure for table `financement`
--

DROP TABLE IF EXISTS `financement`;
CREATE TABLE IF NOT EXISTS `financement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_financement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_financementent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institution`
--

DROP TABLE IF EXISTS `institution`;
CREATE TABLE IF NOT EXISTS `institution` (
  `id` int NOT NULL AUTO_INCREMENT,
  `niveau_id` int DEFAULT NULL,
  `libelle_institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_institution` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_3A9F98E5B3E9C81` (`niveau_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institution`
--

INSERT INTO `institution` (`id`, `niveau_id`, `libelle_institution`, `telephone_institution`, `delete_at`) VALUES
(8, 1, 'Ministère de la santé', '97102345', NULL),
(9, 1, 'Ministère des finances', NULL, NULL),
(10, 1, 'Ministère des Infrastructures', NULL, NULL),
(11, 1, 'Ministère des mines', '+229 97 45 56 66', '2024-07-01 08:30:03'),
(12, 1, 'Ministère des sports', '98765432', NULL),
(13, 2, 'aaaaaaaaaaaaaaaaa', NULL, '2024-06-28 17:13:09'),
(14, 1, 'N.NN?.N?', '21342455', '2024-06-28 17:14:14'),
(15, 11, 'vdsvds', NULL, '2024-06-28 17:18:18'),
(16, 1, 'vcbvcb', NULL, '2024-06-28 17:19:39'),
(17, 1, 'Ministère des mine', '97102345', NULL),
(18, 1, 'Hopital de zone de calavikkkk', NULL, '2024-07-04 04:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_marque` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marque`
--

INSERT INTO `marque` (`id`, `libelle_marque`, `delete_at`) VALUES
(1, 'Toyota', NULL),
(2, 'Ford', NULL),
(3, 'Honda', NULL),
(4, 'Chevrolet', NULL),
(5, 'Tesla', NULL),
(6, 'Audi', NULL),
(7, 'BMW', NULL),
(8, 'Alfa Rome', NULL),
(9, 'Mercedes-Benz', NULL),
(10, 'Alfa Romeo', NULL),
(11, 'Citroën', NULL),
(12, 'Fiat', NULL),
(13, 'Opel', NULL),
(14, 'Nissan', NULL),
(15, 'Audi', NULL),
(16, 'BMW', NULL),
(17, 'Alfa Rome', NULL),
(18, 'Peugeot', NULL),
(19, 'Renault', NULL),
(20, 'SEAT', NULL),
(21, 'Volkswagen', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_niveau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `niveau`
--

INSERT INTO `niveau` (`id`, `libelle_niveau`, `delete_at`) VALUES
(1, 'Niveau central', NULL),
(2, 'Niveau périphérique', NULL),
(3, 'aaa', '0000-00-00 00:00:00'),
(4, 'aaaaaaaaaaaaaaaaaaaa', '2024-06-17 17:55:17'),
(5, 'yyyyyyyyyyyyyyyyyy', '2024-06-28 14:30:10'),
(6, 'uiiuhiho', '2024-06-20 13:30:56'),
(7, 'iohojoijpoj,pl', '2024-06-28 14:30:01'),
(8, 'bvnvb', '2024-06-28 10:38:15'),
(9, 'WXCW', '2024-06-28 14:28:56'),
(10, 'vc cv vvc', '2024-06-28 14:28:51'),
(11, 'Niveau départemental', NULL),
(12, 'Niveau zone sanitaire', '2024-07-01 08:27:34'),
(13, 'ccccccccc', '2024-07-04 04:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `structure`
--

DROP TABLE IF EXISTS `structure`;
CREATE TABLE IF NOT EXISTS `structure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_structure_id` int DEFAULT NULL,
  `institution_id` int DEFAULT NULL,
  `libelle_structure` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_structure` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_long_structure` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_6F0137EAA277BA8E` (`type_structure_id`),
  KEY `IDX_6F0137EA10405986` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `structure`
--

INSERT INTO `structure` (`id`, `type_structure_id`, `institution_id`, `libelle_structure`, `telephone_structure`, `libelle_long_structure`, `delete_at`) VALUES
(1, 1, 8, 'Direction des Systèmes d\'Information (DSI)', '98653456', NULL, NULL),
(2, 3, 8, 'Direction de la Planification, de la l\'Administration et des Finances (DPAF)', '98653456', NULL, NULL),
(3, 5, 8, 'Programme National de Lutte contre le Paludisme (PNLP)', NULL, NULL, NULL),
(4, 1, 10, 'Direction de la Planification, de la l\'Administration et des Finances (DPAF)', NULL, NULL, NULL),
(5, 4, 17, 'Direction des Systèmes d\'Information (DSI)', NULL, NULL, '2024-07-01 14:54:45'),
(6, 1, 8, 'rrrrrrrrrrrrr', NULL, NULL, '2024-07-03 13:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int NOT NULL AUTO_INCREMENT,
  `champ1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_structure`
--

DROP TABLE IF EXISTS `type_structure`;
CREATE TABLE IF NOT EXISTS `type_structure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_type_structure` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_structure`
--

INSERT INTO `type_structure` (`id`, `libelle_type_structure`, `delete_at`) VALUES
(1, 'Agence', NULL),
(2, 'Direction générale', NULL),
(3, 'Direction centrale', NULL),
(4, 'Direction technique', NULL),
(5, 'Programme', NULL),
(6, 'ZZZZZZZZZZZZZZZ', '2024-07-01 14:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `type_vehicule`
--

DROP TABLE IF EXISTS `type_vehicule`;
CREATE TABLE IF NOT EXISTS `type_vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_type_vehicule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_vehicule`
--

INSERT INTO `type_vehicule` (`id`, `libelle_type_vehicule`, `delete_at`) VALUES
(1, 'Moto', NULL),
(2, 'Ambulance', NULL),
(3, 'Véhicule-Etatique', NULL),
(4, 'aaaaaaaaaaaaaaaa', '2024-07-02 07:54:11'),
(5, 'xc x', '2024-07-02 08:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `last_name`, `first_name`, `email`, `delete_at`) VALUES
(1, 'meboko', '[]', '$2y$13$jL0PPGiCjUNUtpVKxbJMG.by.oNHe4bo/XeuMGc/47Zczr86OP526', 'BOKO', 'Elodie', 'meboko@gouv.bj', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `structure_id` int DEFAULT NULL,
  `institution_id` int DEFAULT NULL,
  `nom_utilisateur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_utilisateur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_utilisateur` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule_utilisateur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `etat_utilisateur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D1C63B32534008B` (`structure_id`),
  KEY `IDX_1D1C63B310405986` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `structure_id`, `institution_id`, `nom_utilisateur`, `prenom_utilisateur`, `date_naissance`, `email`, `telephone_utilisateur`, `login`, `password`, `matricule_utilisateur`, `delete_at`, `etat_utilisateur`) VALUES
(1, 2, 8, 'ASSOGBA', 'Rufin', '1989-06-07', 'meboko@gouv.bj', '97865656', 'jkhk', 'Azert', '112345', NULL, 'Activé'),
(2, 1, 12, 'HGF', 'WDFWDF', '2023-05-11', NULL, NULL, '456', '456', '103456', '2024-07-04 09:18:44', 'Désactivé');

-- --------------------------------------------------------

--
-- Table structure for table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `financement_id` int DEFAULT NULL,
  `type_vehicule_id` int DEFAULT NULL,
  `matricule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_chassis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modele` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbre_place` int NOT NULL,
  `etat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_acquisition` date DEFAULT NULL,
  `valeur_acquisition` double DEFAULT NULL,
  `kilometrage` double DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `date_mise_en_circulation` date DEFAULT NULL,
  `mise_en_rebut` tinyint(1) DEFAULT NULL,
  `date_debut_visite_technique` date DEFAULT NULL,
  `date_fin_visite_technique` date DEFAULT NULL,
  `date_entretien` date DEFAULT NULL,
  `alimentation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allumage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assistance_freinage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacite_carburant` double DEFAULT NULL,
  `categorie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cession` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_utile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `climatiseur` tinyint(1) DEFAULT NULL,
  `nbre_cylindre` int DEFAULT NULL,
  `numero_moteur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pma` int DEFAULT NULL,
  `puissance` double DEFAULT NULL,
  `vitesse` double DEFAULT NULL,
  `cylindree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction_assistee` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree_guarantie` int DEFAULT NULL,
  `dure_vie` int DEFAULT NULL,
  `energie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `freins` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pva` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio` tinyint(1) DEFAULT NULL,
  `type_energie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_transmission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disponibilite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_vehicule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `institution_id` int DEFAULT NULL,
  `marque_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_292FFF1DA737ED74` (`financement_id`),
  KEY `IDX_292FFF1D153E280` (`type_vehicule_id`),
  KEY `IDX_292FFF1D10405986` (`institution_id`),
  KEY `IDX_292FFF1D4827B9B2` (`marque_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicule`
--

INSERT INTO `vehicule` (`id`, `financement_id`, `type_vehicule_id`, `matricule`, `numero_chassis`, `modele`, `nbre_place`, `etat`, `date_acquisition`, `valeur_acquisition`, `kilometrage`, `date_reception`, `date_mise_en_circulation`, `mise_en_rebut`, `date_debut_visite_technique`, `date_fin_visite_technique`, `date_entretien`, `alimentation`, `allumage`, `assistance_freinage`, `capacite_carburant`, `categorie`, `cession`, `charge_utile`, `climatiseur`, `nbre_cylindre`, `numero_moteur`, `pma`, `puissance`, `vitesse`, `cylindree`, `direction_assistee`, `duree_guarantie`, `dure_vie`, `energie`, `freins`, `pva`, `radio`, `type_energie`, `type_transmission`, `disponibilite`, `photo_vehicule`, `delete_at`, `institution_id`, `marque_id`) VALUES
(1, NULL, 2, 'DC 3445 RB', '', '', 5, 'En service', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vehicule_DC 3445 RB.jpg', NULL, 8, 1),
(2, NULL, 2, 'AR 5678 RB', '1HGCM82633A123456', 'BMW Série 2 Active Tourer', 9, 'En service', '2021-10-12', 4000000, 120, '2023-09-14', '2024-07-01', 0, NULL, NULL, NULL, NULL, 'sans_distributeur', 'afu', 100, 'XVXVW', NULL, '100000', NULL, NULL, '12346789', 34, 23, 100, '2345', '1', 24, 10, NULL, 'hydrauliques', '200', 1, 'essence', 'manuelle', NULL, 'vehicule_AR 5678 RB.jpg', NULL, 10, 1),
(3, NULL, 1, 'AX 2034 RB', '', '', 7, 'En service', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-03 20:36:50', 8, 1),
(4, NULL, 1, 'CB 5640 RB', '', '', 5, 'En stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vehicule_CB 5640 RB.jpg', NULL, 8, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chauffeur`
--
ALTER TABLE `chauffeur`
  ADD CONSTRAINT `FK_5CA777B810405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`);

--
-- Constraints for table `commune`
--
ALTER TABLE `commune`
  ADD CONSTRAINT `FK_E2E2D1EECCF9E01E` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`);

--
-- Constraints for table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `FK_2694D7A5167FABE8` FOREIGN KEY (`traite_par_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_2694D7A54C21AB48` FOREIGN KEY (`demander_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_2694D7A5DF4C0F3E` FOREIGN KEY (`validateur_structure_id`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `institution`
--
ALTER TABLE `institution`
  ADD CONSTRAINT `FK_3A9F98E5B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `structure`
--
ALTER TABLE `structure`
  ADD CONSTRAINT `FK_6F0137EA10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_6F0137EAA277BA8E` FOREIGN KEY (`type_structure_id`) REFERENCES `type_structure` (`id`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B310405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_1D1C63B32534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`);

--
-- Constraints for table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_292FFF1D10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_292FFF1D153E280` FOREIGN KEY (`type_vehicule_id`) REFERENCES `type_vehicule` (`id`),
  ADD CONSTRAINT `FK_292FFF1D4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_292FFF1DA737ED74` FOREIGN KEY (`financement_id`) REFERENCES `financement` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
