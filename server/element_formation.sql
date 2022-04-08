-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 29 Mars 2021 à 09:02
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1
-- Version de PHP :  7.2.34-18+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `application_entreprise`
--

-- --------------------------------------------------------

--
-- Structure de la table `element_formation`
--

CREATE TABLE `element_formation` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `element_formation`
--

INSERT INTO `element_formation` (`id`, `title`, `father_id`) VALUES
(1, 'EMA', NULL),
(2, 'FIA', 1),
(3, 'FIG', 1),
(4, 'INFRES11', 2),
(5, 'INFRES12', 2),
(6, 'INFRES 12', 3),
(7, 'promo 169', 3),
(8, 'promo 170', 3),
(9, 'promo 171', 3),
(10, 'Commun-1A', 5),
(11, 'Commun-2A', 5),
(12, 'Commun-3A', 5),
(13, 'S5', 10),
(14, 'S7', 11),
(15, 'S8', 11),
(16, '8.1 INFRES GL', 15),
(17, '8.2 INFRES DL', 15),
(18, 'Informatique mobile : Android', 17),
(19, 'Informatique concurrente et répartie', 17),
(20, 'S6', 10),
(21, 'S9', 12),
(22, 'S10', 12),
(23, 'Structures de données et Algorithmique', 20),
(24, 'Mathématiques pour l ingénieur', 20),
(25, 'Surêté de fonctionnement', 17),
(26, 'Anglais', 20),
(27, 'Mission 2', 20);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `element_formation`
--
ALTER TABLE `element_formation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E84B0F942055B9A2` (`father_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `element_formation`
--
ALTER TABLE `element_formation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `element_formation`
--
ALTER TABLE `element_formation`
  ADD CONSTRAINT `FK_E84B0F942055B9A2` FOREIGN KEY (`father_id`) REFERENCES `element_formation` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
