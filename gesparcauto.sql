-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 04, 2024 at 11:05 AM
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
-- Table structure for table `affecter`
--

DROP TABLE IF EXISTS `affecter`;
CREATE TABLE IF NOT EXISTS `affecter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `demande_id` int DEFAULT NULL,
  `vehicule_id` int DEFAULT NULL,
  `chauffeur_id` int DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_C290057A80E95E18` (`demande_id`),
  KEY `IDX_C290057A4A4A3511` (`vehicule_id`),
  KEY `IDX_C290057A85C0B3BE` (`chauffeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `affecter`
--

INSERT INTO `affecter` (`id`, `demande_id`, `vehicule_id`, `chauffeur_id`, `delete_at`) VALUES
(6, 70, 1, 1, NULL),
(7, 70, 4, 2, NULL),
(8, 70, 5, 6, NULL),
(9, 71, 1, 1, NULL),
(10, 71, 7, 7, NULL),
(11, 72, 1, 1, NULL),
(12, 72, 6, 2, NULL),
(13, 72, 7, 4, NULL),
(14, 72, 10, 6, NULL),
(15, 73, 1, 1, NULL),
(16, 74, 1, 4, NULL),
(17, 74, 6, 2, NULL),
(18, 74, 7, 1, NULL),
(19, 76, 10, 6, NULL),
(20, 78, 1, 1, NULL),
(21, 78, 6, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assurance`
--

DROP TABLE IF EXISTS `assurance`;
CREATE TABLE IF NOT EXISTS `assurance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicule_id` int DEFAULT NULL,
  `date_debut_assurance` date NOT NULL,
  `date_fin_assurance` date NOT NULL,
  `piece_assurance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_386829AE4A4A3511` (`vehicule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assurance`
--

INSERT INTO `assurance` (`id`, `vehicule_id`, `date_debut_assurance`, `date_fin_assurance`, `piece_assurance`, `delete_at`) VALUES
(1, 1, '2021-07-20', '2022-07-19', 'pieceAssurance_DC 3445 RB.pdf', NULL),
(2, 1, '2022-07-20', '2023-07-19', 'pieceAssurance_DC 3445 RB.pdf', NULL),
(3, 1, '2023-08-20', '2024-08-19', 'pieceAssurance_DC 3445 RB.pdf', NULL),
(4, 6, '2023-08-24', '2024-08-23', 'pieceAssurance_ONG 928 RB.pdf', NULL),
(5, 11, '2024-07-24', '2025-07-23', 'pieceAssurance_BH 2345 RB.pdf', NULL),
(6, 8, '2024-07-28', '2025-07-27', 'pieceAssurance_BZ 0897 RB.pdf', NULL),
(7, 7, '2023-08-01', '2024-08-01', 'pieceAssurance_AX 1234 RB.pdf', NULL),
(8, 11, '2023-07-24', '2024-07-23', 'pieceAssurance_BH 2345 RB.pdf', NULL),
(9, 10, '2024-07-31', '2025-07-30', 'pieceAssurance_ONU 1200 RB.pdf', NULL),
(10, 5, '2023-07-29', '2024-07-28', 'pieceAssurance_AX 0505 RB.pdf', NULL);

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
  `disponibilite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_chauffeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5CA777B810405986` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chauffeur`
--

INSERT INTO `chauffeur` (`id`, `institution_id`, `nom_chauffeur`, `prenom_chauffeur`, `telephone_chauffeur`, `num_permis`, `etat_chauffeur`, `delete_at`, `matricule_chauffeur`, `disponibilite`, `photo_chauffeur`) VALUES
(1, 8, 'ADJE', 'ANTONIN', NULL, 'BEN-123456-21', 'EN SERVICE', NULL, '234567', 'Disponible', NULL),
(2, 8, 'BOSSOU', 'AUGUSTIN', '95689078', 'BEN-083456-19', 'En service', NULL, '345678', 'Disponible', NULL),
(3, 12, 'KPOCAME', 'SERAPHIN', NULL, 'BEN-223433-20', 'EN CONGE', NULL, '113025', NULL, NULL),
(4, 12, 'ZABADA', 'RICHARD', NULL, 'BEN-183456-21', 'EN CONGE', NULL, '109876', 'Disponible', NULL),
(5, 8, 'AHOUI', 'RICHARD', '95689078', 'BEN-123456-21', 'EN SERVICE', '2024-07-04 05:31:24', '234568', 'Disponible', NULL),
(6, 8, 'VIGNON', 'Athanase', '', 'BEN-123456-21', 'En service', NULL, '2345684', 'Disponible', '_chauffeur_2345684.jpg'),
(7, 8, 'CHANOU', 'Wilfried', '23456787', 'BEN-123456-21', 'En service', NULL, '2345674', 'Disponible', '_chauffeur_2345674.jpg'),
(8, 8, 'GANDAHO', 'Mathieu', '95689078', 'BEN-123456-21', 'En service', NULL, '678906', 'Disponible', '_chauffeur_678906.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `commune`
--

DROP TABLE IF EXISTS `commune`;
CREATE TABLE IF NOT EXISTS `commune` (
  `id` int NOT NULL AUTO_INCREMENT,
  `departement_id` int DEFAULT NULL,
  `libelle_commune` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL,
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
  `raison_rejet_approbation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `get_raison_rejet_validation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_approbation` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_traitement` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `observations` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_effective_fin_mission` date DEFAULT NULL,
  `date_finalisation_demande` date DEFAULT NULL,
  `traiter_par_id` int DEFAULT NULL,
  `finaliser_par_id` int DEFAULT NULL,
  `reference_note_de_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_signature_note_de_service` date DEFAULT NULL,
  `structure_id` int DEFAULT NULL,
  `institution_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2694D7A54C21AB48` (`demander_id`),
  KEY `IDX_2694D7A5DF4C0F3E` (`validateur_structure_id`),
  KEY `IDX_2694D7A54546CD3F` (`traiter_par_id`),
  KEY `IDX_2694D7A5E7E17F36` (`finaliser_par_id`),
  KEY `IDX_2694D7A52534008B` (`structure_id`),
  KEY `IDX_2694D7A510405986` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande`
--

INSERT INTO `demande` (`id`, `demander_id`, `validateur_structure_id`, `num_demande`, `date_demande`, `objet_mission`, `date_debut_mission`, `date_fin_mission`, `nbre_participants`, `nbre_vehicules`, `delete_at`, `statut`, `lieuMission`, `raison_rejet_approbation`, `get_raison_rejet_validation`, `date_approbation`, `date_traitement`, `observations`, `date_effective_fin_mission`, `date_finalisation_demande`, `traiter_par_id`, `finaliser_par_id`, `reference_note_de_service`, `date_signature_note_de_service`, `structure_id`, `institution_id`) VALUES
(68, 4, 6, NULL, '2024-07-27 08:18:14', 'eLEARNING', '2024-07-27', '2024-07-27', 4, 2, NULL, 'Rejeté', '[\"Adja-Ouerre\", \"Adjohoun\", \"Aplahoue\"]', 'RAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0201-2/MS/DC/SGM/DSI/SA', NULL, 1, 8),
(69, 4, 6, NULL, '2024-07-27 08:19:00', 'AlafiaCom', '2024-07-27', '2024-07-27', 10, 3, NULL, 'Rejeté', '[\"Avrankou\"]', 'RAS', NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, '5900/MS/DC/SGM/DSI/SIS/SA', NULL, 1, 8),
(70, 4, 6, NULL, '2024-07-27 08:19:33', 'eSIGL', '2024-07-27', '2024-07-27', 4, 3, NULL, 'Finalisé', '[\"Abomey\", \"Abomey-Calavi\", \"Adjohoun\", \"Allada\"]', NULL, NULL, NULL, '2024-07-27 11:17:01', 'RAS', '2024-07-27', '2024-07-27', 9, 9, 'N°3218/MS/DC/SGM/DSI/SPGS/SA', NULL, 1, 8),
(71, 4, 6, NULL, '2024-07-27 08:19:59', 'CommCare', '2024-07-27', '2024-07-27', 4, 3, NULL, 'Finalisé', '[\"Agbangnizoun\"]', NULL, NULL, NULL, '2024-07-27 11:26:58', 'RAS', '2024-07-31', '2024-07-31', 9, 9, '\r\nN°5462/MS/DC/SGM/DSI/SA', NULL, 1, 8),
(72, 4, 6, NULL, '2024-07-27 08:20:23', 'AlafiaCom', '2024-07-27', '2024-07-27', 4, 3, NULL, 'Finalisé', '[\"Porto-Novo\"]', NULL, NULL, NULL, '2024-07-31 12:01:24', NULL, '2024-07-31', '2024-07-31', 9, 9, '7898/MS/DC/SGM/ANSSP/SA', NULL, 1, 8),
(73, 4, 6, NULL, '2024-07-31 13:57:42', 'eLEARNING', '2024-07-31', '2024-08-06', 3, 2, NULL, 'Validé', '[\"Adjohoun\", \"Aguégués\", \"Athiémé\"]', NULL, NULL, NULL, '2024-07-31 14:13:37', NULL, NULL, NULL, 9, NULL, '1889/DC/SGM', NULL, 1, 8),
(74, 4, 6, NULL, '2024-07-31 14:43:08', 'eSIGL', '2024-07-31', '2024-07-31', 20, 3, NULL, 'Finalisé', '[\"Adjohoun\", \"Akpro-Misserete\"]', NULL, NULL, NULL, '2024-07-31 15:35:42', NULL, '2024-07-31', '2024-07-31', 9, 9, '1889/DC/SGM', NULL, 1, 8),
(75, 4, 6, NULL, '2024-07-31 14:43:38', 'AlafiaCom', '2024-07-31', '2024-07-31', 20, 3, NULL, 'Rejeté', '[\"Bantè\"]', 'RAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, 1, 8),
(76, 4, 6, NULL, '2024-07-31 14:44:04', 'eLEARNING', '2024-07-31', '2024-07-31', 3, 3, NULL, 'Finalisé', '[\"Akpro-Misserete\"]', NULL, NULL, NULL, '2024-07-31 15:55:13', NULL, '2024-08-05', '2024-08-04', 9, 9, '1889/DC/SGM', NULL, 1, 8),
(77, 4, 6, NULL, '2024-07-31 15:00:05', 'eLEARNING', '2024-07-31', '2024-07-31', 3, 3, NULL, 'Rejeté', '[\"Akpro-Misserete\"]', 'RAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, 1, 8),
(78, 4, 6, NULL, '2024-07-31 17:40:32', 'Formation des relais communautaires', '2024-08-01', '2024-08-02', 10, 3, NULL, 'Finalisé', '[\"Gogounou\", \"Kandi\", \"Segbana\"]', NULL, NULL, NULL, '2024-07-31 18:02:33', 'RAS', '2024-08-05', '2024-08-04', 9, 9, '1889/DC/SGM', NULL, 1, 8),
(79, 4, 6, NULL, '2024-08-03 13:20:52', 'Prendre part à l\'atelier préparatoire de l\'atelier de transition du Projet Plus', '2024-08-04', '2024-08-04', 2, 1, NULL, 'Approuvé', '[\"Grand-Popo\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, 1, 8),
(80, 4, 6, NULL, '2024-08-03 13:22:41', 'Atelier DHIS2', '2024-08-03', '2024-08-03', 4, 2, NULL, 'Approuvé', '[\"Avrankou\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1123/PNDHS/SG/SA', NULL, 1, 8),
(81, 4, NULL, NULL, '2024-08-03 20:32:20', 'eLEARNING', '2024-08-03', '2024-08-03', 2, 5, NULL, 'Initial', '[\"Bantè\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, 1, 8);

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
  `delete_at` datetime DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departement`
--

INSERT INTO `departement` (`id`, `libelle_departement`, `delete_at`, `region`) VALUES
(1, 'Alibori', NULL, 'Nord'),
(2, 'Atacora', NULL, 'Nord'),
(3, 'Borgou', NULL, 'Nord'),
(4, 'Donga', NULL, 'Nord'),
(5, 'Collines', NULL, 'Centre'),
(6, 'Zou', NULL, 'Centre'),
(7, 'Mono', NULL, 'Sud'),
(8, 'Couffo', NULL, 'Sud'),
(9, 'Plateau', NULL, 'Sud'),
(10, 'Ouémé', NULL, 'Sud'),
(11, 'Atlantique', NULL, 'Sud'),
(12, 'Littoral', NULL, 'Sud'),
(13, 'bvnvbn', '2024-07-28 16:18:32', ''),
(14, 'BBBBBBBBB', '2024-07-28 18:15:24', 'Sud');

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
('DoctrineMigrations\\Version20240708150653', '2024-07-08 15:07:07', 170),
('DoctrineMigrations\\Version20240709075055', '2024-07-09 07:51:05', 71),
('DoctrineMigrations\\Version20240709081008', '2024-07-09 08:10:14', 108),
('DoctrineMigrations\\Version20240709095822', '2024-07-09 09:58:29', 585),
('DoctrineMigrations\\Version20240709160639', '2024-07-09 16:08:23', 344),
('DoctrineMigrations\\Version20240711164432', '2024-07-11 16:44:40', 69),
('DoctrineMigrations\\Version20240715050954', '2024-07-15 05:10:02', 82),
('DoctrineMigrations\\Version20240716162909', '2024-07-16 16:29:16', 79),
('DoctrineMigrations\\Version20240717145627', '2024-07-17 14:56:36', 137),
('DoctrineMigrations\\Version20240717194920', '2024-07-17 19:49:31', 471),
('DoctrineMigrations\\Version20240718002907', '2024-07-18 00:29:13', 304),
('DoctrineMigrations\\Version20240720122311', '2024-07-20 12:23:19', 40),
('DoctrineMigrations\\Version20240724163510', '2024-07-24 16:42:19', 63),
('DoctrineMigrations\\Version20240724164249', '2024-07-24 16:42:56', 176),
('DoctrineMigrations\\Version20240724185554', '2024-07-24 18:55:59', 48),
('DoctrineMigrations\\Version20240724190154', '2024-07-24 19:02:00', 36),
('DoctrineMigrations\\Version20240724191919', '2024-07-24 19:19:24', 365),
('DoctrineMigrations\\Version20240724192430', '2024-07-24 19:24:41', 62),
('DoctrineMigrations\\Version20240724192759', '2024-07-24 19:28:03', 88),
('DoctrineMigrations\\Version20240724193341', '2024-07-24 19:38:51', 40),
('DoctrineMigrations\\Version20240724202422', '2024-07-24 20:24:27', 31),
('DoctrineMigrations\\Version20240724221557', '2024-07-24 22:16:05', 383),
('DoctrineMigrations\\Version20240725084722', '2024-07-25 08:47:32', 23),
('DoctrineMigrations\\Version20240725113258', '2024-07-25 11:33:07', 54),
('DoctrineMigrations\\Version20240726142549', '2024-07-26 14:26:05', 138),
('DoctrineMigrations\\Version20240726143449', '2024-07-26 14:34:56', 88),
('DoctrineMigrations\\Version20240726224358', '2024-07-26 22:44:07', 188),
('DoctrineMigrations\\Version20240726225004', '2024-07-26 22:50:09', 218),
('DoctrineMigrations\\Version20240726230704', '2024-07-26 23:07:09', 155),
('DoctrineMigrations\\Version20240727141555', '2024-07-27 14:16:05', 116),
('DoctrineMigrations\\Version20240727142708', '2024-07-27 14:27:16', 19),
('DoctrineMigrations\\Version20240728121631', '2024-07-28 12:16:40', 356),
('DoctrineMigrations\\Version20240728130909', '2024-07-28 13:09:13', 51),
('DoctrineMigrations\\Version20240728163747', '2024-07-28 16:37:51', 68),
('DoctrineMigrations\\Version20240728165033', '2024-07-28 16:50:44', 42),
('DoctrineMigrations\\Version20240728183037', '2024-07-28 18:30:44', 40),
('DoctrineMigrations\\Version20240728205319', '2024-07-28 20:53:24', 20),
('DoctrineMigrations\\Version20240729045701', '2024-07-29 04:57:07', 75),
('DoctrineMigrations\\Version20240729052223', '2024-07-29 05:22:32', 60),
('DoctrineMigrations\\Version20240730090822', '2024-07-30 09:08:27', 80),
('DoctrineMigrations\\Version20240730130007', '2024-07-30 13:00:20', 649),
('DoctrineMigrations\\Version20240730130635', '2024-07-30 13:07:27', 71),
('DoctrineMigrations\\Version20240730133653', '2024-07-30 13:37:03', 69),
('DoctrineMigrations\\Version20240730154121', '2024-07-30 15:41:26', 216),
('DoctrineMigrations\\Version20240731052411', '2024-07-31 05:24:16', 18),
('DoctrineMigrations\\Version20240803123405', '2024-08-03 12:34:21', 449);

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
  `logo_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_postale_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_mail_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_site_web_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3A9F98E5B3E9C81` (`niveau_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institution`
--

INSERT INTO `institution` (`id`, `niveau_id`, `libelle_institution`, `telephone_institution`, `delete_at`, `logo_institution`, `adresse_postale_institution`, `adresse_mail_institution`, `lien_site_web_institution`) VALUES
(8, 1, 'Ministère de la santé', '21 33 21 63', NULL, '_logo_8.png', 'BP 01-882 Bénin', 'sante.infos@gouv.bj', 'http://www.sante.gouv.bj'),
(9, 1, 'Ministère des finances', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'Ministère des Infrastructures', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Ministère des mines', '+229 97 45 56 66', '2024-07-01 08:30:03', NULL, NULL, NULL, NULL),
(12, 1, 'Ministère des sports', '98765432', NULL, NULL, NULL, NULL, NULL),
(13, 2, 'aaaaaaaaaaaaaaaaa', NULL, '2024-06-28 17:13:09', NULL, NULL, NULL, NULL),
(14, 1, 'N.NN?.N?', '21342455', '2024-06-28 17:14:14', NULL, NULL, NULL, NULL),
(15, 11, 'vdsvds', NULL, '2024-06-28 17:18:18', NULL, NULL, NULL, NULL),
(16, 1, 'vcbvcb', NULL, '2024-06-28 17:19:39', NULL, NULL, NULL, NULL),
(17, 1, 'Ministère des mine', '97102345', NULL, NULL, NULL, NULL, NULL),
(18, 1, 'Hopital de zone de calavikkkk', NULL, '2024-07-04 04:34:25', NULL, NULL, NULL, NULL),
(19, 11, 'DBD', NULL, '2024-07-12 11:09:58', NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messenger_messages`
--

INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
(1, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:167:\\\"http://localhost:8000/verify/email?expires=1720521689&signature=gq284ao6DVA3KBgN9dSUk1qQEq89tRqKE7%2B6MfCymhs%3D&token=J6S6zh9L%2B4emsTpwRVFaIo2rE07sBSBurPJR7BgEONU%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:15:\\\"cfzanou@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-09 09:41:29', '2024-07-09 09:41:29', NULL),
(2, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:28:\\\"Sending emails is fun again!\\\";i:1;s:5:\\\"utf-8\\\";i:2;s:56:\\\"<p>See Twig integration for better HTML integration!</p>\\\";i:3;s:5:\\\"utf-8\\\";i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"hello@example.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:15:\\\"you@example.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:24:\\\"Time for Symfony Mailer!\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-09 10:49:43', '2024-07-09 10:49:43', NULL),
(3, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:169:\\\"http://localhost:8000/verify/email?expires=1720525954&signature=GDCOCS8zVSVHOtXy91M5jPcTOyTMuq2SA7jPELlrBLg%3D&token=ohysM4T08l4y%2BC513X123VFchrKh%2FrtqbCQ%2BKM94NCY%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:15:\\\"cfzanou@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-09 10:52:34', '2024-07-09 10:52:34', NULL),
(4, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:175:\\\"http://localhost:8000/verify/email?expires=1720526186&signature=PLUPJAPMThezkpCx9j8FY%2FG3L92JOfxaIEGfGT4%2BN%2B8%3D&token=msLx36cQQ%2BmKfEp%2FO3HF4btocrx%2FrvRRt14zlhkb7X0%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"ckcecilio@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-09 10:56:26', '2024-07-09 10:56:26', NULL),
(5, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:163:\\\"http://localhost:8000/verify/email?expires=1720671922&signature=x44qdWbkXank9KL908vtw0kiJpaKWt5mxICNALhvDSw%3D&token=3U2gC8GvNxIgJbUEuik55EBmu2IuzJai4onz2LXv1lQ%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:19:\\\"sdossouyovo@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-11 03:25:23', '2024-07-11 03:25:23', NULL),
(6, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:167:\\\"http://localhost:8000/verify/email?expires=1720685689&signature=buYh8BYfUyapUZQ8SUflthPsZYwkYnC2gbGKxovusTs%3D&token=i0GvB%2FDOrSdimsokK5OB6qXwawo3h3TE%2BQQTPEzfqys%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"hyacoubou@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-11 07:14:49', '2024-07-11 07:14:49', NULL),
(7, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:165:\\\"http://localhost:8000/verify/email?expires=1720697591&signature=GCJFZPNsZywrcnmfwZj9kjbNdabrfjPOhfY%2BO1Zcnjc%3D&token=DUHmGr6YGI6NKew4z4fvTUUggxsJMDUDatyV7mrCzGo%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"bdossa@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-11 10:33:11', '2024-07-11 10:33:11', NULL),
(8, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:163:\\\"http://localhost:8000/verify/email?expires=1720809318&signature=WKSfjGIsaYNxBBoE8VxqWSVTmbDGm80yHNymJpgpl3U%3D&token=SkKMsP3Hy9MJCu7SMEP04G27I36JhSS7UyK0vpYmO40%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"meboko@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:7:\\\"Support\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:15:\\\"vaholou@gouv.bj\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-07-12 17:35:18', '2024-07-12 17:35:18', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(13, 'ccccccccc', '2024-07-04 04:29:39'),
(14, 'chcj', '2024-07-12 12:53:35'),
(15, 'qwerty', '2024-07-12 12:55:57'),
(16, 'maurèle elodie', '2024-07-12 13:13:44'),
(17, 'ssssss', '2024-07-12 17:10:43');

-- --------------------------------------------------------

--
-- Table structure for table `parc`
--

DROP TABLE IF EXISTS `parc`;
CREATE TABLE IF NOT EXISTS `parc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institution_id` int DEFAULT NULL,
  `chef_parc_id` int DEFAULT NULL,
  `nom_parc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `telephone_parc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_parc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CADCF50110405986` (`institution_id`),
  KEY `IDX_CADCF50146FE222E` (`chef_parc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parc`
--

INSERT INTO `parc` (`id`, `institution_id`, `chef_parc_id`, `nom_parc`, `delete_at`, `telephone_parc`, `email_parc`) VALUES
(1, 8, 9, 'Parc central', NULL, '23456789', 'parc_central_ms@gouv.bj');

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
  `parc_id` int DEFAULT NULL,
  `responsable_structure_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6F0137EA1805704` (`responsable_structure_id`),
  KEY `IDX_6F0137EAA277BA8E` (`type_structure_id`),
  KEY `IDX_6F0137EA10405986` (`institution_id`),
  KEY `IDX_6F0137EA812D24CA` (`parc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `structure`
--

INSERT INTO `structure` (`id`, `type_structure_id`, `institution_id`, `libelle_structure`, `telephone_structure`, `libelle_long_structure`, `delete_at`, `parc_id`, `responsable_structure_id`) VALUES
(1, 1, 8, 'Direction des Systèmes d\'Information (DSI)', '98653456', NULL, NULL, 1, 6),
(2, 3, 8, 'Direction de la Planification, de la l\'Administration et des Finances (DPAF)', '98653456', NULL, NULL, 1, 7),
(3, 5, 8, 'Programme National de Lutte contre le Paludisme (PNLP)', NULL, NULL, NULL, 1, 11),
(4, 1, 10, 'Direction de la Planification, de la l\'Administration et des Finances (DPAF)', NULL, NULL, NULL, 1, 12),
(5, 4, 17, 'Direction des Systèmes d\'Information (DSI)', NULL, NULL, '2024-07-01 14:54:45', 1, NULL),
(6, 1, 8, 'rrrrrrrrrrrrr', NULL, NULL, '2024-07-03 13:09:18', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tampon_affecter`
--

DROP TABLE IF EXISTS `tampon_affecter`;
CREATE TABLE IF NOT EXISTS `tampon_affecter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tampon_matricule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tampon_nom_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tampon_prenom_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tampon_kilometrage` double DEFAULT NULL,
  `tampon_vehicule_id` int DEFAULT NULL,
  `tampon_chauffeur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tampon_vehicules`
--

DROP TABLE IF EXISTS `tampon_vehicules`;
CREATE TABLE IF NOT EXISTS `tampon_vehicules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kilometrerestant` double DEFAULT NULL,
  `checkassurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkvisite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkvidange` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portee_vehicule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, 'Véhicule', NULL),
(4, 'aaaaaaaaaaaaaaaa', '2024-07-02 07:54:11'),
(5, 'xc x', '2024-07-02 08:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_verified` tinyint(1) NOT NULL,
  `statut_compte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution_id` int DEFAULT NULL,
  `structure_id` int DEFAULT NULL,
  `matricule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`),
  UNIQUE KEY `UNIQ_IDENTIFIER_MATRICULE` (`matricule`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_8D93D64910405986` (`institution_id`),
  KEY `IDX_8D93D6492534008B` (`structure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `last_name`, `first_name`, `email`, `delete_at`, `is_verified`, `statut_compte`, `institution_id`, `structure_id`, `matricule`, `telephone`) VALUES
(3, 'meboko', '[\"ROLE_ADMIN\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'BOKO', 'Elodie', 'meboko@gouv.bj', NULL, 0, 'INITIAL', 8, 1, '123445', NULL),
(4, 'cfzanou', '[\"ROLE_POINT_FOCAL\"]', '$2y$13$oXoDBb5KWbRsK9BDFipX/eJ0sNfh3qGS4RTwxHHcpklkL4ZAwYJ5a', 'ZANOU', 'F. Cyr', 'cfzanou@gouv.bj', NULL, 0, 'INITIAL', 8, 1, '123456', NULL),
(5, 'ckcecilio', '[\"ROLE_POINT_FOCAL\"]', '$2y$13$ALlGcuuocPj14mHSgU9RWOo.iF2OK.B.1kuVeNcBlvtXEzxD/lB2y', 'QUENUM', 'Cécilio', 'ckcecilio@gouv.bj', NULL, 0, 'INITIAL', 8, 1, '981234', NULL),
(6, 'sdossouyovo', '[\"ROLE_RESPONSABLE_STRUCTURE\"]', '$2y$13$75mnPR5JiTSWrD3js.Ph1OiwDwhUy73gezAT3yHl3aiPxHOJTZWfC', 'DOSSOU-YOVO', 'Sébastiano', 'sdossouyovo@gouv.bj', NULL, 0, 'INITIAL', 8, 1, '112345', NULL),
(7, 'hyacouvou', '[\"ROLE_RESPONSABLE_STRUCTURE\"]', '$2y$13$Qh.lTIX2ZU9I..l3gFHcv.Qqguw5a6xOtyI324EkIXeCscuUgrs96', 'YACOUBOU', 'Hawérath', 'hyacoubou@gouv.bj', NULL, 0, 'INITIAL', 8, 2, '103456', NULL),
(8, 'bdossa', '[\"ROLE_CABINET\"]', '$2y$13$7lvnQC6bUJKJiIF99uAxSutSuGourJWkq0p7Y1k7wpAzIOECsNsTu', 'DOSSA', 'Bienvenu', 'bdossa@gouv.bj', NULL, 0, 'INITIAL', 8, 4, '890234', NULL),
(9, 'vaholou', '[\"ROLE_CHEF_PARC\"]', '$2y$13$yqYKGL66.jrQklaie/ZfKuq0j2zUGeO8VCNCFsHHa.5A/CUk2z3LW', 'AHOULOU', 'VICTOR', 'vaholou@gouv.bj', NULL, 0, 'INITIAL', 8, 2, '566989', NULL),
(10, 'afatomon', '[\"ROLE_CABINET\"]', '$2y$13$0ZpBXkC2vLVL1seqW28xkOya/gafgBAUAfRL91Tu4uE7OUUijSIFi', 'FATOMON', 'Alex', 'afatomon@gouv.bj', NULL, 0, 'INITIAL', 8, 1, '4GNJ8889', NULL),
(11, 'htokpanou', '[\"ROLE_RESPONSABLE_STRUCTURE\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'TOKPANOU', 'Henriette', 'htokpanou@gouv.bj', NULL, 0, 'Activé', 8, 3, '9876543', '98765434'),
(12, 'bkocou', '[\"ROLE_RESPONSABLE_STRUCTURE\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'KOCOU', 'Bienvenu', 'bkocou@gouv.bj', NULL, 0, 'Activé', 8, 4, '2376547', '56434567');

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
  `kilometrage_initial` double DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `date_mise_en_circulation` date DEFAULT NULL,
  `mise_en_rebut` tinyint(1) DEFAULT NULL,
  `date_fin_assurance` date DEFAULT NULL,
  `date_fin_visite_technique` date DEFAULT NULL,
  `date_vidange` date DEFAULT NULL,
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
  `nbre_km_pour_renouveller_vidange` int DEFAULT NULL,
  `kilometrage_courant` int DEFAULT NULL,
  `portee_vehicule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parc_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_292FFF1DA737ED74` (`financement_id`),
  KEY `IDX_292FFF1D153E280` (`type_vehicule_id`),
  KEY `IDX_292FFF1D10405986` (`institution_id`),
  KEY `IDX_292FFF1D4827B9B2` (`marque_id`),
  KEY `IDX_292FFF1D812D24CA` (`parc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicule`
--

INSERT INTO `vehicule` (`id`, `financement_id`, `type_vehicule_id`, `matricule`, `numero_chassis`, `modele`, `nbre_place`, `etat`, `date_acquisition`, `valeur_acquisition`, `kilometrage_initial`, `date_reception`, `date_mise_en_circulation`, `mise_en_rebut`, `date_fin_assurance`, `date_fin_visite_technique`, `date_vidange`, `alimentation`, `allumage`, `assistance_freinage`, `capacite_carburant`, `categorie`, `cession`, `charge_utile`, `climatiseur`, `nbre_cylindre`, `numero_moteur`, `pma`, `puissance`, `vitesse`, `cylindree`, `direction_assistee`, `duree_guarantie`, `dure_vie`, `energie`, `freins`, `pva`, `radio`, `type_energie`, `type_transmission`, `disponibilite`, `photo_vehicule`, `delete_at`, `institution_id`, `marque_id`, `nbre_km_pour_renouveller_vidange`, `kilometrage_courant`, `portee_vehicule`, `parc_id`) VALUES
(1, NULL, 2, 'DC 3445 RB', '', '', 5, 'En service', NULL, NULL, 8500, NULL, NULL, NULL, '2024-08-19', '2025-07-19', '2024-07-30', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Disponible', 'vehicule_DC 3445 RB.jpg', NULL, 8, 1, 15000, 9800, 'Centre', 1),
(2, NULL, 2, 'AR 5678 RB', '1HGCM82633A123456', 'BMW Série 2 Active Tourer', 9, 'En service', '2021-10-12', 4000000, 17500, '2023-09-14', '2024-07-01', 0, NULL, NULL, '2024-07-28', NULL, 'sans_distributeur', 'afu', 100, 'XVXVW', NULL, '100000', 1, NULL, '12346789', 34, 23, 100, '2345', '1', 24, 10, NULL, 'hydrauliques', '200', 1, 'essence', 'manuelle', 'Disponible', 'vehicule_AR 5678 RB.jpg', NULL, 10, 1, 5000, 17500, 'Centre', 1),
(3, NULL, 1, 'AX 2034 RB', '', '', 7, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Disponible', NULL, '2024-07-03 20:36:50', 8, 1, 5000, 13000, NULL, 1),
(4, NULL, 1, 'CB 5640 RB', '', '', 5, 'En stock', NULL, NULL, 75800, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Disponible', 'vehicule_CB 5640 RB.jpg', NULL, 8, 1, 7000, 86900, NULL, 1),
(5, NULL, 3, 'AX 0505 RB', '1HABC82633A123456', '', 5, 'En service', NULL, NULL, 135457, NULL, NULL, NULL, '2024-07-28', NULL, '2024-07-28', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'ABC123456', NULL, 23, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'automatique', 'Disponible', 'vehicule_AX 0505 RB.jpg', NULL, 8, 9, NULL, 135457, NULL, 1),
(6, NULL, 3, 'ONG 928 RB', 'SDFRTYUII', '', 9, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, '2024-08-23', '2025-07-21', '2024-07-28', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'BBUUNNII98', NULL, 150, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'diesel', 'automatique', 'Disponible', 'vehicule_ONG 928 RB.png', NULL, 8, 18, 5000, 14300, 'Nord', 1),
(7, NULL, 3, 'AX 1234 RB', '', '', 5, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, '2024-08-01', '2024-08-30', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, '12346789', NULL, 98, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'diesel', 'automatique', 'Disponible', 'vehicule_AX 1234 RB.jpg', NULL, 8, 3, 5000, 16000, 'Sud', 1),
(8, NULL, 3, 'BZ 0897 RB', '', '', 5, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, '2025-07-27', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'CCCGGGYYY123', NULL, 35, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'Disponible', 'vehicule_BZ 0897 RB.jpg', NULL, 8, 2, 5000, 13000, NULL, 1),
(9, NULL, 3, 'CD 5446 RB', '', '', 9, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'FFFFTYU8765', NULL, 80, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'Disponible', 'vehicule_CD 5446 RB.jpg', NULL, 8, 20, 5000, 13000, NULL, 1),
(10, NULL, 3, 'ONU 1200 RB', '', '', 5, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, '2025-07-30', '2025-07-30', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'RGHJLOU123456', NULL, 56, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'Disponible', 'vehicule_ONU 1200 RB.jpg', NULL, 8, 14, 5000, 14000, 'Sud', 1),
(11, NULL, 3, 'BH 2345 RB', '', '', 5, 'En service', NULL, NULL, 13000, NULL, NULL, NULL, '2024-07-23', '2025-07-23', '2024-07-28', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'B765489UJFDER', NULL, 76, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'Disponible', 'vehicule_BH 2345 RB.jpg', NULL, 8, 1, 5000, 13000, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vidange`
--

DROP TABLE IF EXISTS `vidange`;
CREATE TABLE IF NOT EXISTS `vidange` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicule_id` int DEFAULT NULL,
  `date_vidange` date NOT NULL,
  `valeur_compteur_kilometrage` double DEFAULT NULL,
  `piece_vidange` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_872AAB8B4A4A3511` (`vehicule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vidange`
--

INSERT INTO `vidange` (`id`, `vehicule_id`, `date_vidange`, `valeur_compteur_kilometrage`, `piece_vidange`) VALUES
(1, 1, '2024-07-28', 8500, NULL),
(2, 2, '2024-07-28', 17500, 'pieceVidange_AR 5678 RB.pdf'),
(3, 5, '2024-07-28', 135457, NULL),
(4, 11, '2024-07-28', 13000, NULL),
(5, 6, '2024-07-28', 13000, 'pieceVidange_ONG 928 RB.pdf'),
(6, 1, '2024-07-30', 8500, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visite`
--

DROP TABLE IF EXISTS `visite`;
CREATE TABLE IF NOT EXISTS `visite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicule_id` int DEFAULT NULL,
  `date_debut_visite` date NOT NULL,
  `date_fin_visite` date NOT NULL,
  `piece_visite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B09C8CBB4A4A3511` (`vehicule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visite`
--

INSERT INTO `visite` (`id`, `vehicule_id`, `date_debut_visite`, `date_fin_visite`, `piece_visite`) VALUES
(1, 1, '2021-07-20', '2022-07-19', 'pieceVisite_DC 3445 RB.pdf'),
(2, 1, '2022-07-20', '2023-07-19', NULL),
(3, 1, '2023-07-20', '2024-07-19', NULL),
(4, 6, '2024-07-22', '2025-07-21', 'pieceVisite_ONG 928 RB.pdf'),
(5, 8, '2024-07-28', '2025-07-27', 'pieceVisite_BZ 0897 RB.pdf'),
(6, 11, '2024-07-24', '2025-07-23', 'pieceVisite_BH 2345 RB.pdf'),
(7, 7, '2023-08-31', '2024-08-30', 'pieceVisite_AX 1234 RB.pdf'),
(8, 1, '2024-07-20', '2025-07-19', 'pieceVisite_DC 3445 RB.pdf'),
(9, 10, '2024-07-31', '2025-07-30', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `FK_C290057A4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `FK_C290057A80E95E18` FOREIGN KEY (`demande_id`) REFERENCES `demande` (`id`),
  ADD CONSTRAINT `FK_C290057A85C0B3BE` FOREIGN KEY (`chauffeur_id`) REFERENCES `chauffeur` (`id`);

--
-- Constraints for table `assurance`
--
ALTER TABLE `assurance`
  ADD CONSTRAINT `FK_386829AE4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

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
  ADD CONSTRAINT `FK_2694D7A510405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_2694D7A52534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_2694D7A54546CD3F` FOREIGN KEY (`traiter_par_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A54C21AB48` FOREIGN KEY (`demander_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A5DF4C0F3E` FOREIGN KEY (`validateur_structure_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A5E7E17F36` FOREIGN KEY (`finaliser_par_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `institution`
--
ALTER TABLE `institution`
  ADD CONSTRAINT `FK_3A9F98E5B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `parc`
--
ALTER TABLE `parc`
  ADD CONSTRAINT `FK_CADCF50110405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_CADCF50146FE222E` FOREIGN KEY (`chef_parc_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `structure`
--
ALTER TABLE `structure`
  ADD CONSTRAINT `FK_6F0137EA10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_6F0137EA1805704` FOREIGN KEY (`responsable_structure_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6F0137EA812D24CA` FOREIGN KEY (`parc_id`) REFERENCES `parc` (`id`),
  ADD CONSTRAINT `FK_6F0137EAA277BA8E` FOREIGN KEY (`type_structure_id`) REFERENCES `type_structure` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64910405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_8D93D6492534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`);

--
-- Constraints for table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_292FFF1D10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_292FFF1D153E280` FOREIGN KEY (`type_vehicule_id`) REFERENCES `type_vehicule` (`id`),
  ADD CONSTRAINT `FK_292FFF1D4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_292FFF1D812D24CA` FOREIGN KEY (`parc_id`) REFERENCES `parc` (`id`),
  ADD CONSTRAINT `FK_292FFF1DA737ED74` FOREIGN KEY (`financement_id`) REFERENCES `financement` (`id`);

--
-- Constraints for table `vidange`
--
ALTER TABLE `vidange`
  ADD CONSTRAINT `FK_872AAB8B4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Constraints for table `visite`
--
ALTER TABLE `visite`
  ADD CONSTRAINT `FK_B09C8CBB4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
