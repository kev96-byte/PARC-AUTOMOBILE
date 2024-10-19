-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 19 oct. 2024 à 16:38
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gesparcauto2`
--

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

DROP TABLE IF EXISTS `affecter`;
CREATE TABLE IF NOT EXISTS `affecter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `demande_id` int DEFAULT NULL,
  `vehicule_id` int DEFAULT NULL,
  `chauffeur_id` int DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_debut_mission` date DEFAULT NULL,
  `date_fin_mission` date DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C290057A80E95E18` (`demande_id`),
  KEY `IDX_C290057A4A4A3511` (`vehicule_id`),
  KEY `IDX_C290057A85C0B3BE` (`chauffeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affecter`
--

INSERT INTO `affecter` (`id`, `demande_id`, `vehicule_id`, `chauffeur_id`, `delete_at`, `date_debut_mission`, `date_fin_mission`, `statut`) VALUES
(5, 19, 15, 12, NULL, '2024-10-18', '2024-10-18', 'Traité'),
(7, 19, 13, 9, NULL, '2024-10-18', '2024-10-18', 'Traité'),
(8, 20, 12, 11, NULL, '2024-10-18', '2024-10-25', 'Traité'),
(9, 1, 13, 10, NULL, '2024-10-21', '2024-10-26', 'Traité'),
(10, 1, 14, 12, NULL, '2024-10-21', '2024-10-26', 'Traité'),
(11, 8, 15, 9, NULL, NULL, NULL, 'Rejeté'),
(12, 2, 12, 10, NULL, NULL, NULL, 'Rejeté'),
(13, 23, 13, 12, NULL, '2024-11-04', '2024-11-06', 'Traité'),
(14, 23, 14, 11, NULL, '2024-11-04', '2024-11-06', 'Traité'),
(15, 21, 15, 9, NULL, '2024-10-21', '2024-10-26', 'Validé'),
(16, 25, 13, 9, NULL, '2024-10-19', '2024-10-19', 'Validé');

-- --------------------------------------------------------

--
-- Structure de la table `assurance`
--

DROP TABLE IF EXISTS `assurance`;
CREATE TABLE IF NOT EXISTS `assurance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicule_id` int DEFAULT NULL,
  `date_debut_assurance` date NOT NULL,
  `date_fin_assurance` date NOT NULL,
  `piece_assurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `type_couverture` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  `type_assurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `compagnie_assurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_386829AE4A4A3511` (`vehicule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assurance`
--

INSERT INTO `assurance` (`id`, `vehicule_id`, `date_debut_assurance`, `date_fin_assurance`, `piece_assurance`, `delete_at`, `type_couverture`, `type_assurance`, `compagnie_assurance`) VALUES
(1, 12, '2024-09-25', '2025-09-24', 'pieceAssurance_CD 2348 RB.pdf', NULL, 'a:2:{i:0;s:43:\"Assurance_Responsabilite_Civile_Obligatoire\";i:1;s:22:\"Assurance_Tous_Risques\";}', 'CAVA', 'NSIA Assurance Bénin'),
(2, 13, '2024-09-30', '2025-09-29', NULL, NULL, 'a:1:{i:0;s:43:\"Assurance_Responsabilite_Civile_Obligatoire\";}', 'CAVA', 'NSIA Assurance Bénin'),
(3, 14, '2024-10-14', '2025-10-13', NULL, NULL, 'a:1:{i:0;s:22:\"Assurance_Tous_Risques\";}', 'CAVA', 'NSIA Assurance Bénin'),
(4, 15, '2024-10-14', '2025-10-13', NULL, NULL, 'a:1:{i:0;s:43:\"Assurance_Responsabilite_Civile_Obligatoire\";}', 'CAVA', 'NSIA Assurance Bénin');

-- --------------------------------------------------------

--
-- Structure de la table `chauffeur`
--

DROP TABLE IF EXISTS `chauffeur`;
CREATE TABLE IF NOT EXISTS `chauffeur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institution_id` int DEFAULT NULL,
  `parc_id` int DEFAULT NULL,
  `nom_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_chauffeur` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_permis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `matricule_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disponibilite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5CA777B810405986` (`institution_id`),
  KEY `IDX_5CA777B8812D24CA` (`parc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chauffeur`
--

INSERT INTO `chauffeur` (`id`, `institution_id`, `parc_id`, `nom_chauffeur`, `prenom_chauffeur`, `telephone_chauffeur`, `num_permis`, `etat_chauffeur`, `delete_at`, `matricule_chauffeur`, `disponibilite`, `photo_chauffeur`) VALUES
(9, 8, 1, 'GANDONOU', 'Pierre', '95689078', 'BEN-183456-21', 'En service', NULL, '345678', 'En mission', NULL),
(10, 8, 1, 'ZONGBEDJI', 'Ignace', '95689078', 'BEN-183456-21', 'En service', NULL, '185678', 'En mission', NULL),
(11, 8, 1, 'BOBJRENOU', 'Aventin', '95689078', 'BEN-333456-21', 'En service', NULL, '336878', 'En mission', NULL),
(12, 8, 1, 'ZINZINDOHOUE', 'Paulin', '97654321', 'BEN-333456-21', 'En service', NULL, '234567', 'En mission', NULL),
(13, 8, 1, 'DOSSOU', 'Bernard', '95689078', 'BEN-453456-21', 'En service', NULL, '345615', 'Disponible', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

DROP TABLE IF EXISTS `commune`;
CREATE TABLE IF NOT EXISTS `commune` (
  `id` int NOT NULL AUTO_INCREMENT,
  `departement_id` int DEFAULT NULL,
  `libelle_commune` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2E2D1EECCF9E01E` (`departement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commune`
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
(77, 12, 'Cotonou', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE IF NOT EXISTS `demande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `demander_id` int DEFAULT NULL,
  `validateur_structure_id` int DEFAULT NULL,
  `traiter_par_id` int DEFAULT NULL,
  `finaliser_par_id` int DEFAULT NULL,
  `structure_id` int DEFAULT NULL,
  `institution_id` int DEFAULT NULL,
  `num_demande` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_demande` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `objet_mission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut_mission` date DEFAULT NULL,
  `date_fin_mission` date DEFAULT NULL,
  `lieuMission` json NOT NULL,
  `nbre_participants` int NOT NULL,
  `nbre_vehicules` int NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `raison_rejet_approbation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `get_raison_rejet_validation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_approbation` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_traitement` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `observations` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_effective_fin_mission` date DEFAULT NULL,
  `date_finalisation_demande` date DEFAULT NULL,
  `reference_note_de_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_signature_note_de_service` date DEFAULT NULL,
  `vehicules` json NOT NULL,
  `chauffeurs` json NOT NULL,
  `cancelled_by_id` int DEFAULT NULL,
  `cancellation_request_by_id` int DEFAULT NULL,
  `cancellation_date` datetime DEFAULT NULL,
  `cancellation_request_date` datetime DEFAULT NULL,
  `cancellation_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validated_by_id` int DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_2694D7A54C21AB48` (`demander_id`),
  KEY `IDX_2694D7A5DF4C0F3E` (`validateur_structure_id`),
  KEY `IDX_2694D7A54546CD3F` (`traiter_par_id`),
  KEY `IDX_2694D7A5E7E17F36` (`finaliser_par_id`),
  KEY `IDX_2694D7A52534008B` (`structure_id`),
  KEY `IDX_2694D7A510405986` (`institution_id`),
  KEY `IDX_2694D7A5187B2D12` (`cancelled_by_id`),
  KEY `IDX_2694D7A52F84F10B` (`cancellation_request_by_id`),
  KEY `IDX_2694D7A5C69DE5E5` (`validated_by_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demande`
--

INSERT INTO `demande` (`id`, `demander_id`, `validateur_structure_id`, `traiter_par_id`, `finaliser_par_id`, `structure_id`, `institution_id`, `num_demande`, `date_demande`, `objet_mission`, `date_debut_mission`, `date_fin_mission`, `lieuMission`, `nbre_participants`, `nbre_vehicules`, `delete_at`, `statut`, `raison_rejet_approbation`, `get_raison_rejet_validation`, `date_approbation`, `date_traitement`, `observations`, `date_effective_fin_mission`, `date_finalisation_demande`, `reference_note_de_service`, `date_signature_note_de_service`, `vehicules`, `chauffeurs`, `cancelled_by_id`, `cancellation_request_by_id`, `cancellation_date`, `cancellation_request_date`, `cancellation_reason`, `validated_by_id`, `validated_at`) VALUES
(1, 13, 10, 19, NULL, 6, 8, '5693979624', '2024-10-17 11:34:46', 'eLEARNING', '2024-10-21', '2024-10-26', '[\"Aguégués\", \"Athiémé\"]', 4, 2, NULL, 'Rejeté', 'ras', NULL, NULL, '2024-10-19 15:34:08', NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"CD 2348 RB\"]', '[\"345615\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 13, 10, 12, NULL, 6, 8, '8017636987', '2024-10-17 11:35:24', 'Prendre part à l\'atelier préparatoire de l\'atelier de transition du Projet Plus', '2024-11-04', '2024-11-09', '[\"Akpro-Misserete\"]', 3, 2, NULL, 'Rejeté', 'Mon nouveau rejet', NULL, NULL, '2024-10-18 22:41:12', NULL, NULL, NULL, '0201-2/MS/DC/SGM/DSI/SA', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, 19, '2024-10-19 15:41:33'),
(3, 16, NULL, NULL, NULL, 6, 8, '9986558868', '2024-10-17 11:36:49', 'ONCHO', '2024-10-23', '2024-10-26', '[\"Agbangnizoun\", \"Akpro-Misserete\"]', 3, 0, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', 16, NULL, '2024-10-17 18:40:18', NULL, 'gdhgfhjfjhg', NULL, NULL),
(4, 16, NULL, NULL, NULL, 6, 8, '3344328400', '2024-10-17 11:37:31', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Avrankou\"]', 0, 0, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0201-2/MS/DC/SGM/DSI/SA', NULL, '[]', '[]', 16, NULL, '2024-10-17 18:21:11', NULL, 'rrdgfhj,', NULL, NULL),
(5, 16, NULL, NULL, NULL, 6, 8, '5985760633', '2024-10-17 11:46:53', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Aplahoue\"]', 0, 0, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[]', '[]', 16, NULL, '2024-10-17 18:42:25', NULL, 'dgbfdbfg', NULL, NULL),
(6, 16, NULL, NULL, NULL, 6, 8, '7519344038', '2024-10-17 11:55:57', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Agbangnizoun\", \"Aplahoue\"]', 2, 2, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', 16, NULL, '2024-10-17 18:47:07', NULL, 'RAS', NULL, NULL),
(7, 16, NULL, NULL, NULL, 6, 8, '2795022922', '2024-10-17 12:09:27', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Aplahoue\"]', 2, 1, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[]', '[]', 16, NULL, '2024-10-17 17:47:39', NULL, 'Mission reportée', NULL, NULL),
(8, 13, 10, 12, NULL, 6, 8, '5729024073', '2024-10-17 12:11:00', 'eLEARNING', '2024-10-21', '2024-10-26', '[\"Allada\"]', 2, 2, NULL, 'Rejeté', 'kgkjb', NULL, NULL, '2024-10-18 22:37:45', NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, 19, '2024-10-19 15:38:51'),
(9, 13, NULL, NULL, NULL, 6, 8, '1365470660', '2024-10-17 12:11:45', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Akpro-Misserete\"]', 3, 1, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[\"CD 2348 RB\"]', '[\"234567\"]', 13, NULL, '2024-10-17 19:09:56', NULL, 'BBBBBBBBBBBBBBBBBBBB', NULL, NULL),
(10, 13, NULL, NULL, NULL, 6, 8, '3753850583', '2024-10-17 12:14:36', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Aguégués\"]', 10, 2, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"BL 9070 RB\", \"BN 2896 RB\", \"CD 2348 RB\"]', '[\"234567\", \"345615\", \"345678\"]', 13, NULL, '2024-10-17 19:09:32', NULL, 'AAAAAAAAAAAAAA', NULL, NULL),
(11, 13, 10, NULL, NULL, 6, 8, '4486044742', '2024-10-17 12:18:07', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Aplahoue\"]', 4, 1, NULL, 'Rejeté', 'aaaaaaaaaaaaaaa', NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"BL 9070 RB\", \"BN 2896 RB\"]', '[\"336878\", \"345615\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 13, 10, 12, NULL, 6, 8, '1295088872', '2024-10-17 12:33:19', 'eLEARNING', '2024-10-28', '2024-11-02', '[\"Aguégués\"]', 1, 1, NULL, 'Rejeté', 'WXCV', NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[\"CD 2348 RB\"]', '[\"345615\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, NULL, NULL, NULL, 6, 8, '6651627833', '2024-10-17 12:36:01', 'eLEARNING', '2024-10-17', '2024-10-17', '[\"Athiémé\"]', 4, 1, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"BN 2896 RB\"]', '[\"234567\"]', 13, NULL, '2024-10-17 19:22:00', NULL, 'QQQQQQQQQQQQQQQQQQ', NULL, NULL),
(14, 13, 10, NULL, NULL, 6, 8, '9753666261', '2024-10-17 12:39:12', 'eSIGL', '2024-10-17', '2024-10-17', '[\"Allada\"]', 3, 1, NULL, 'Approuvé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 16, NULL, NULL, NULL, 6, 8, '5378192325', '2024-10-17 19:07:10', 'eLEARNING', '2024-10-21', '2024-10-26', '[\"Allada\"]', 3, 3, NULL, 'Annulé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[]', '[]', 16, NULL, '2024-10-17 19:08:02', NULL, 'GDZ', NULL, NULL),
(16, 16, 10, NULL, NULL, 6, 8, '4172464449', '2024-10-17 19:08:37', 'eSIGL', '2024-10-17', '2024-10-17', '[\"Aplahoue\"]', 2, 1, NULL, 'Approuvé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 13, 10, NULL, NULL, 6, 8, '2058535515', '2024-10-17 19:18:32', 'Prendre part à l\'atelier préparatoire de l\'atelier de transition du Projet Plus', '2024-10-17', '2024-10-17', '[\"Aguégués\"]', 3, 2, NULL, 'Approuvé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"BL 9070 RB\", \"ONG 928 RB\"]', '[\"234567\", \"345615\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 16, 10, NULL, NULL, 6, 8, '2808402590', '2024-10-18 13:27:20', 'eLEARNING', '2024-10-18', '2024-10-18', '[\"Adjohoun\", \"Allada\"]', 5, 3, NULL, 'Rejeté', 'RAS', NULL, NULL, NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 13, 10, 12, NULL, 6, 8, '2934177363', '2024-10-18 13:50:03', 'eLEARNING', '2024-10-18', '2024-10-18', '[\"Aguégués\", \"Avrankou\"]', 3, 1, NULL, 'Traité', NULL, NULL, NULL, '2024-10-18 22:13:54', NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[\"BL 9070 RB\"]', '[\"345678\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 16, 10, 19, NULL, 6, 8, '3590798805', '2024-10-18 22:16:30', 'eLEARNING', '2024-10-18', '2024-10-25', '[\"Aplahoue\"]', 3, 1, NULL, 'Rejeté', 'Validateur', NULL, NULL, '2024-10-18 22:17:52', NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, 19, NULL),
(21, 16, 10, 12, NULL, 6, 8, '2449256915', '2024-10-19 12:14:27', 'eLEARNING', '2024-10-21', '2024-10-26', '[\"Adjohoun\", \"Akpro-Misserete\"]', 5, 2, NULL, 'Validé', NULL, NULL, NULL, '2024-10-19 15:53:58', NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, 19, '2024-10-19 16:10:42'),
(22, 16, 10, NULL, NULL, 6, 8, '8745592850', '2024-10-19 12:15:28', 'AlafiaCom', '2024-10-28', '2024-11-02', '[\"Aguégués\", \"Athiémé\"]', 4, 1, NULL, 'Rejeté', 'sdossouyovo', NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 16, 10, 19, NULL, 6, 8, '1257617839', '2024-10-19 12:17:56', 'Prendre part à l\'atelier préparatoire de l\'atelier de transition du Projet Plus', '2024-11-04', '2024-11-06', '[\"Adjohoun\", \"Akpro-Misserete\", \"Avrankou\", \"Banikoara\"]', 2, 1, NULL, 'Rejeté', 'Nouveau', NULL, NULL, '2024-10-19 15:29:34', NULL, NULL, NULL, '0201-2/MS/DC/SGM/DSI/SA', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 13, 10, NULL, NULL, 6, 8, '6804396752', '2024-10-19 15:44:42', 'eLEARNING', '2024-10-19', '2024-10-19', '[\"Avrankou\"]', 3, 1, NULL, 'Approuvé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"CD 2348 RB\"]', '[\"336878\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 13, 10, 12, NULL, 6, 8, '5731613934', '2024-10-19 15:45:08', 'eLEARNING', '2024-10-19', '2024-10-19', '[\"Agbangnizoun\"]', 2, 1, NULL, 'Validé', NULL, NULL, NULL, '2024-10-19 16:17:26', NULL, NULL, NULL, '1889/DC/SGM', NULL, '[\"BL 9070 RB\"]', '[\"336878\"]', NULL, NULL, NULL, NULL, NULL, 19, '2024-10-19 16:18:05'),
(26, 13, 10, NULL, NULL, 6, 8, '7421934915', '2024-10-19 15:45:39', 'eLEARNING', '2024-10-19', '2024-10-19', '[\"Akpro-Misserete\"]', 3, 1, NULL, 'Rejeté', 'Rejet Approbateur', NULL, '2024-10-19 15:46:44', NULL, NULL, NULL, NULL, '1192/07/2024/ABMS-DIR/DHASE', NULL, '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demande_commune`
--

DROP TABLE IF EXISTS `demande_commune`;
CREATE TABLE IF NOT EXISTS `demande_commune` (
  `commune_id` int NOT NULL,
  PRIMARY KEY (`commune_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_departement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id`, `libelle_departement`, `region`, `delete_at`) VALUES
(1, 'Alibori', 'Nord', NULL),
(2, 'Atacora', 'Nord', NULL),
(3, 'Borgou', 'Nord', NULL),
(4, 'Donga', 'Nord', NULL),
(5, 'Collines', 'Centre', NULL),
(6, 'Zou', 'Centre', NULL),
(7, 'Mono', 'Sud', NULL),
(8, 'Couffo', 'Sud', NULL),
(9, 'Plateau', 'Sud', NULL),
(10, 'Ouémé', 'Sud', NULL),
(11, 'Atlantique', 'Sud', NULL),
(12, 'Littoral', 'Sud', NULL),
(13, 'bvnvbn', '', '2024-07-28 16:18:32'),
(14, 'BBBBBBBBB', 'Sud', '2024-07-28 18:15:24');

-- --------------------------------------------------------

--
-- Structure de la table `financement`
--

DROP TABLE IF EXISTS `financement`;
CREATE TABLE IF NOT EXISTS `financement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_financement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_financementent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `institution`
--

DROP TABLE IF EXISTS `institution`;
CREATE TABLE IF NOT EXISTS `institution` (
  `id` int NOT NULL AUTO_INCREMENT,
  `niveau_id` int DEFAULT NULL,
  `libelle_institution` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_institution` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `logo_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_postale_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_mail_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_site_web_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3A9F98E5B3E9C81` (`niveau_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `institution`
--

INSERT INTO `institution` (`id`, `niveau_id`, `libelle_institution`, `telephone_institution`, `delete_at`, `logo_institution`, `adresse_postale_institution`, `adresse_mail_institution`, `lien_site_web_institution`) VALUES
(8, 1, 'Ministère de la santé', '21 33 21 63', NULL, '_logo_8.png', 'BP 01-882 Bénin', 'sante.infos@gouv.bj', 'http://www.sante.gouv.bj');

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
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
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Structure de la table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_niveau` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`id`, `libelle_niveau`, `delete_at`) VALUES
(1, 'Niveau central', NULL),
(2, 'Niveau périphérique', NULL),
(3, 'Niveau départemental', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `parc`
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
  `validateur_parc_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CADCF50110405986` (`institution_id`),
  KEY `IDX_CADCF50146FE222E` (`chef_parc_id`),
  KEY `IDX_CADCF501E0CA4B47` (`validateur_parc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parc`
--

INSERT INTO `parc` (`id`, `institution_id`, `chef_parc_id`, `nom_parc`, `delete_at`, `telephone_parc`, `email_parc`, `validateur_parc_id`) VALUES
(1, 8, 12, 'Parc central [ SANTE ]', NULL, '23456789', 'parc_central_ms@gouv.bj', 19),
(2, 8, 22, 'Parc du PNLP', NULL, '23456789', 'parc_pnlp@gouv.bj', 19),
(3, 8, 23, 'Parc ANCQ', NULL, '21 33 45 86', 'parc_ancq@gouv.bj', 19);

-- --------------------------------------------------------

--
-- Structure de la table `structure`
--

DROP TABLE IF EXISTS `structure`;
CREATE TABLE IF NOT EXISTS `structure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_structure_id` int DEFAULT NULL,
  `institution_id` int DEFAULT NULL,
  `parc_id` int DEFAULT NULL,
  `responsable_structure_id` int DEFAULT NULL,
  `libelle_structure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_structure` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_long_structure` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_6F0137EAA277BA8E` (`type_structure_id`),
  KEY `IDX_6F0137EA10405986` (`institution_id`),
  KEY `IDX_6F0137EA812D24CA` (`parc_id`),
  KEY `IDX_6F0137EA1805704` (`responsable_structure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `structure`
--

INSERT INTO `structure` (`id`, `type_structure_id`, `institution_id`, `parc_id`, `responsable_structure_id`, `libelle_structure`, `telephone_structure`, `libelle_long_structure`, `delete_at`) VALUES
(6, 3, 8, 1, 10, 'Direction des Systèmes d\'Information (DSI)', '98653456', NULL, NULL),
(7, 3, 8, 1, NULL, 'Direction de la Planification, de la l\'Administration et des Finances (DPAF)', '98653456', NULL, NULL),
(8, 5, 8, 1, NULL, 'Programme National de Lutte contre le Paludisme (PNLP)', NULL, NULL, NULL),
(9, 1, 8, 3, 20, 'Agence nationale de Contrôle de Qualité des produits de santé et de l’eau (ANCQ)', '40345676', NULL, NULL),
(10, 3, 8, 2, NULL, 'strucrure_1 PNLP', '96789056', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tampon_affecter`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tampon_vehicules`
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
-- Structure de la table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int NOT NULL AUTO_INCREMENT,
  `champ1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_structure`
--

DROP TABLE IF EXISTS `type_structure`;
CREATE TABLE IF NOT EXISTS `type_structure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_type_structure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_structure`
--

INSERT INTO `type_structure` (`id`, `libelle_type_structure`, `delete_at`) VALUES
(1, 'Agence', NULL),
(2, 'Direction générale', NULL),
(3, 'Direction centrale', NULL),
(4, 'Direction technique', NULL),
(5, 'Programme', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `type_vehicule`
--

DROP TABLE IF EXISTS `type_vehicule`;
CREATE TABLE IF NOT EXISTS `type_vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_type_vehicule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_vehicule`
--

INSERT INTO `type_vehicule` (`id`, `libelle_type_vehicule`, `delete_at`) VALUES
(6, 'Véhicule', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institution_id` int DEFAULT NULL,
  `structure_id` int DEFAULT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_verified` tinyint(1) NOT NULL,
  `statut_compte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_first_login` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`),
  UNIQUE KEY `UNIQ_IDENTIFIER_MATRICULE` (`matricule`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_8D93D64910405986` (`institution_id`),
  KEY `IDX_8D93D6492534008B` (`structure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `institution_id`, `structure_id`, `username`, `roles`, `password`, `last_name`, `first_name`, `email`, `delete_at`, `is_verified`, `statut_compte`, `matricule`, `telephone`, `is_first_login`) VALUES
(10, 8, 6, 'sdossouyovo', '[\"ROLE_RESPONSABLE_STRUCTURE\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'DOSSOU-YOVO', 'Sébastiano', 'sdossouyovo@gouv.bj', NULL, 0, 'Activé', '112345', NULL, 0),
(11, 8, 6, 'hyacouvou', '[\"ROLE_POINT_FOCAL\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'YACOUBOU', 'Hawérath', 'hyacoubou@gouv.bj', '2024-09-26 18:15:59', 0, 'Activé', '103456', NULL, 0),
(12, 8, 6, 'vaholou', '[\"ROLE_CHEF_PARC\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'AHOULOU', 'VICTOR', 'vaholou@gouv.bj', NULL, 0, 'Activé', '566989', NULL, 0),
(13, 8, 6, 'afatomon', '[\"ROLE_POINT_FOCAL_AVANCE\"]', '$2y$13$0ZpBXkC2vLVL1seqW28xkOya/gafgBAUAfRL91Tu4uE7OUUijSIFi', 'FATOMON', 'Alex', 'afatomon@gouv.bj', '2024-09-26 18:33:05', 0, 'Activé', '4GNJ8889', NULL, 0),
(16, 8, 6, 'cfzanou', '[\"ROLE_USER\", \"ROLE_POINT_FOCAL\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'ZANOU', 'F. Cyr', 'cfzanou@gouv.bj', NULL, 0, 'Activé', '90344', '41234567', 0),
(17, 8, 6, 'mboko', '[\"ROLE_USER\", \"ROLE_ADMIN_AVANCE\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'BOKO', 'Maurèle', 'mboko@gouv.bj', NULL, 0, 'Activé', '123455', '97249988', 0),
(18, 8, 6, 'meboko', '[\"ROLE_ADMIN\"]', '$2y$13$/dTVQgxhxbaNgbK9XWgbbetQVLwcflAzHJZ9puLdFXtQOZOOKK/ei', 'BOKO', 'Elodie', 'meboko@gouv.bj', NULL, 0, 'Activé', '123445', NULL, 0),
(19, 8, 6, 'ckcecilio', '[\"ROLE_USER\", \"ROLE_VALIDATEUR\"]', '$2y$13$zcSua74vkH5NlV7U1wsspeE6Ihw7qUSm4z0sUpfcrnDrhWqaM0KyG', 'QUENUM', 'Cécilio', 'ckcecilio@gouv.bj', NULL, 0, 'Activé', '140006', '90000000', 0),
(20, 8, 9, 'responsableancq', '[\"ROLE_USER\", \"ROLE_RESPONSABLE_STRUCTURE\"]', '$2y$13$tuy0vlMUuyYfEOQ/ONM1F.e1p2Vv/qSs85R1PRzSqACcjLQnzQfwO', 'ANCQ', 'Responsable', 'responsableancq@gouv.bj', NULL, 0, 'Activé', '456123', '97000000', 1),
(21, 8, 9, 'pointfocalancq', '[\"ROLE_USER\", \"ROLE_POINT_FOCAL_AVANCE\"]', '$2y$13$Re6a.xeEX62HYtUOi8KIl.CgGrIj26rnb.tI8DI30BRqXYHIsjhtm', 'ANCQ', 'Point Focal', 'pointfocalancq@gouv.bj', NULL, 0, 'Activé', '181234', '90000000', 0),
(22, 8, 6, 'chefparcpnlp', '[\"ROLE_USER\", \"ROLE_CHEF_PARC\"]', '$2y$13$jg6Ef4sQirZ68fDvwo/Qi.dSUleK6F7yclZvgifnhb2kThSf2ynFO', 'PNLP', 'ChefParc', 'chefparcpnlp@gouv.bj', NULL, 0, 'Activé', '9876', '94953447', 1),
(23, 8, 9, 'chefparcancq', '[\"ROLE_USER\", \"ROLE_CHEF_PARC\"]', '$2y$13$rbHRARjHzmvL3mPLlJeLg.yNoeTYUrgsKkvEay5e7GmVNZGDlzoKq', 'ANCQ', 'ChefParc', 'chefparcancq@gouv.bj', NULL, 0, 'Activé', '553456', '97249988', 0);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `marque_id` int DEFAULT NULL,
  `financement_id` int DEFAULT NULL,
  `type_vehicule_id` int DEFAULT NULL,
  `institution_id` int DEFAULT NULL,
  `parc_id` int DEFAULT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_chassis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbre_place` int NOT NULL,
  `etat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_acquisition` date DEFAULT NULL,
  `valeur_acquisition` double DEFAULT NULL,
  `kilometrage_initial` double DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `date_mise_en_circulation` date DEFAULT NULL,
  `mise_en_rebut` tinyint(1) DEFAULT NULL,
  `date_fin_assurance` date DEFAULT NULL,
  `date_fin_visite_technique` date DEFAULT NULL,
  `date_vidange` date DEFAULT NULL,
  `alimentation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allumage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assistance_freinage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacite_carburant` double DEFAULT NULL,
  `categorie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cession` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_utile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `climatiseur` tinyint(1) DEFAULT NULL,
  `nbre_cylindre` int DEFAULT NULL,
  `numero_moteur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pma` int DEFAULT NULL,
  `puissance` double DEFAULT NULL,
  `vitesse` double DEFAULT NULL,
  `cylindree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction_assistee` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree_guarantie` int DEFAULT NULL,
  `dure_vie` int DEFAULT NULL,
  `energie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `freins` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pva` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio` tinyint(1) DEFAULT NULL,
  `type_energie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_transmission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disponibilite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_vehicule` longtext COLLATE utf8mb4_unicode_ci,
  `delete_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `nbre_km_pour_renouveller_vidange` int DEFAULT NULL,
  `kilometrage_courant` int DEFAULT NULL,
  `portee_vehicule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_292FFF1D4827B9B2` (`marque_id`),
  KEY `IDX_292FFF1DA737ED74` (`financement_id`),
  KEY `IDX_292FFF1D153E280` (`type_vehicule_id`),
  KEY `IDX_292FFF1D10405986` (`institution_id`),
  KEY `IDX_292FFF1D812D24CA` (`parc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `marque_id`, `financement_id`, `type_vehicule_id`, `institution_id`, `parc_id`, `matricule`, `numero_chassis`, `modele`, `nbre_place`, `etat`, `date_acquisition`, `valeur_acquisition`, `kilometrage_initial`, `date_reception`, `date_mise_en_circulation`, `mise_en_rebut`, `date_fin_assurance`, `date_fin_visite_technique`, `date_vidange`, `alimentation`, `allumage`, `assistance_freinage`, `capacite_carburant`, `categorie`, `cession`, `charge_utile`, `climatiseur`, `nbre_cylindre`, `numero_moteur`, `pma`, `puissance`, `vitesse`, `cylindree`, `direction_assistee`, `duree_guarantie`, `dure_vie`, `energie`, `freins`, `pva`, `radio`, `type_energie`, `type_transmission`, `disponibilite`, `photo_vehicule`, `delete_at`, `nbre_km_pour_renouveller_vidange`, `kilometrage_courant`, `portee_vehicule`) VALUES
(12, 1, NULL, 6, 8, 1, 'CD 2348 RB', 'JM1ABC123456789', '4x4', 7, 'En service', NULL, NULL, 0, NULL, NULL, NULL, '2025-09-24', '2025-09-29', '2024-09-30', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'PJ12345U123456P', NULL, 132, 200, '1500', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'automatique', 'En mission', 'vehicule_CD 2348 RB.jpg', NULL, 300, 200, 'Nord'),
(13, 1, NULL, 6, 8, 1, 'ONG 928 RB', '1HABC82633A123456', 'Toyota Corolla', 5, 'En service', NULL, NULL, 0, NULL, NULL, NULL, '2025-09-29', '2025-09-29', '2024-09-30', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'A876GGYYY123', NULL, 200, 250, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'En mission', NULL, NULL, 5000, 0, 'Nord'),
(14, 1, NULL, 6, 8, 1, 'BN 2896 RB', 'HT3DJ81W3R0009876', 'Toyota Corolla', 9, 'En service', NULL, NULL, 0, NULL, NULL, NULL, '2025-10-13', '2025-10-13', '2024-10-14', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'XZFFTYU8765', NULL, 25, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'En mission', NULL, NULL, 5000, 0, 'Nord'),
(15, 1, NULL, 6, 8, 1, 'BL 9070 RB', '1HABC82633A123456', 'Toyota Corolla', 5, 'En service', NULL, NULL, 0, NULL, NULL, NULL, '2025-10-13', '2025-10-13', '2024-10-14', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'VZFFTYU8765', NULL, 25, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'essence', 'manuelle', 'En mission', NULL, NULL, 5000, 0, 'Nord');

-- --------------------------------------------------------

--
-- Structure de la table `vidange`
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vidange`
--

INSERT INTO `vidange` (`id`, `vehicule_id`, `date_vidange`, `valeur_compteur_kilometrage`, `piece_vidange`) VALUES
(7, 13, '2024-09-30', 0, NULL),
(8, 12, '2024-09-30', 0, NULL),
(9, 14, '2024-10-14', 0, NULL),
(10, 15, '2024-10-14', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `visite`
--

DROP TABLE IF EXISTS `visite`;
CREATE TABLE IF NOT EXISTS `visite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicule_id` int DEFAULT NULL,
  `date_debut_visite` date NOT NULL,
  `date_fin_visite` date NOT NULL,
  `piece_visite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B09C8CBB4A4A3511` (`vehicule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `visite`
--

INSERT INTO `visite` (`id`, `vehicule_id`, `date_debut_visite`, `date_fin_visite`, `piece_visite`) VALUES
(10, 13, '2024-09-30', '2025-09-29', NULL),
(11, 12, '2024-09-30', '2025-09-29', NULL),
(12, 14, '2024-10-14', '2025-10-13', NULL),
(13, 15, '2024-10-14', '2025-10-13', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `FK_C290057A4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `FK_C290057A80E95E18` FOREIGN KEY (`demande_id`) REFERENCES `demande` (`id`),
  ADD CONSTRAINT `FK_C290057A85C0B3BE` FOREIGN KEY (`chauffeur_id`) REFERENCES `chauffeur` (`id`);

--
-- Contraintes pour la table `assurance`
--
ALTER TABLE `assurance`
  ADD CONSTRAINT `FK_386829AE4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Contraintes pour la table `chauffeur`
--
ALTER TABLE `chauffeur`
  ADD CONSTRAINT `FK_5CA777B810405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_5CA777B8812D24CA` FOREIGN KEY (`parc_id`) REFERENCES `parc` (`id`);

--
-- Contraintes pour la table `commune`
--
ALTER TABLE `commune`
  ADD CONSTRAINT `FK_E2E2D1EECCF9E01E` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`);

--
-- Contraintes pour la table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `FK_2694D7A510405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_2694D7A5187B2D12` FOREIGN KEY (`cancelled_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A52534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_2694D7A52F84F10B` FOREIGN KEY (`cancellation_request_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A54546CD3F` FOREIGN KEY (`traiter_par_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A54C21AB48` FOREIGN KEY (`demander_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A5C69DE5E5` FOREIGN KEY (`validated_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A5DF4C0F3E` FOREIGN KEY (`validateur_structure_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2694D7A5E7E17F36` FOREIGN KEY (`finaliser_par_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `institution`
--
ALTER TABLE `institution`
  ADD CONSTRAINT `FK_3A9F98E5B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`) ON DELETE RESTRICT;

--
-- Contraintes pour la table `parc`
--
ALTER TABLE `parc`
  ADD CONSTRAINT `FK_CADCF50110405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_CADCF50146FE222E` FOREIGN KEY (`chef_parc_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_CADCF501E0CA4B47` FOREIGN KEY (`validateur_parc_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `structure`
--
ALTER TABLE `structure`
  ADD CONSTRAINT `FK_6F0137EA10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_6F0137EA1805704` FOREIGN KEY (`responsable_structure_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6F0137EA812D24CA` FOREIGN KEY (`parc_id`) REFERENCES `parc` (`id`),
  ADD CONSTRAINT `FK_6F0137EAA277BA8E` FOREIGN KEY (`type_structure_id`) REFERENCES `type_structure` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64910405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_8D93D6492534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`);

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_292FFF1D10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`),
  ADD CONSTRAINT `FK_292FFF1D153E280` FOREIGN KEY (`type_vehicule_id`) REFERENCES `type_vehicule` (`id`),
  ADD CONSTRAINT `FK_292FFF1D4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_292FFF1D812D24CA` FOREIGN KEY (`parc_id`) REFERENCES `parc` (`id`),
  ADD CONSTRAINT `FK_292FFF1DA737ED74` FOREIGN KEY (`financement_id`) REFERENCES `financement` (`id`);

--
-- Contraintes pour la table `vidange`
--
ALTER TABLE `vidange`
  ADD CONSTRAINT `FK_872AAB8B4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Contraintes pour la table `visite`
--
ALTER TABLE `visite`
  ADD CONSTRAINT `FK_B09C8CBB4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
