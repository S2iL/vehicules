-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3306
-- Généré le :  Mer 20 Août 2014 à 15:33
-- Version du serveur :  5.5.37
-- Version de PHP :  5.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `glpi`
--

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_configs`
--

CREATE TABLE `glpi_plugin_vehicules_configs` (
`id` int(11) NOT NULL,
  `delay_expired` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '30',
  `delay_whichexpire` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '30'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `glpi_plugin_vehicules_configs`
--

INSERT INTO `glpi_plugin_vehicules_configs` (`id`, `delay_expired`, `delay_whichexpire`) VALUES
(1, '30', '30');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_notificationstates`
--

CREATE TABLE `glpi_plugin_vehicules_notificationstates` (
`id` int(11) NOT NULL,
  `states_id` int(11) NOT NULL DEFAULT '0' COMMENT 'RELATION to glpi_states (id)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_profiles`
--

CREATE TABLE `glpi_plugin_vehicules_profiles` (
`id` int(11) NOT NULL,
  `profiles_id` int(11) NOT NULL DEFAULT '0' COMMENT 'RELATION to glpi_profiles (id)',
  `vehicules` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `open_ticket` char(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `glpi_plugin_vehicules_profiles`
--

INSERT INTO `glpi_plugin_vehicules_profiles` (`id`, `profiles_id`, `vehicules`, `open_ticket`) VALUES
(1, 4, 'w', '1');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_vehiculecarburants`
--

CREATE TABLE `glpi_plugin_vehicules_vehiculecarburants` (
`id` int(11) NOT NULL,
  `entities_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `glpi_plugin_vehicules_vehiculecarburants`
--

INSERT INTO `glpi_plugin_vehicules_vehiculecarburants` (`id`, `entities_id`, `name`, `comment`) VALUES
(5, 0, 'GO', ''),
(6, 0, 'ES', '');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_vehiculegenres`
--

CREATE TABLE `glpi_plugin_vehicules_vehiculegenres` (
`id` int(11) NOT NULL,
  `entities_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `glpi_plugin_vehicules_vehiculegenres`
--

INSERT INTO `glpi_plugin_vehicules_vehiculegenres` (`id`, `entities_id`, `name`, `comment`) VALUES
(1, 0, 'VP', ''),
(2, 0, 'CTTE', ''),
(3, 0, 'CAM', ''),
(5, 0, 'TCP', '');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_vehiculemarques`
--

CREATE TABLE `glpi_plugin_vehicules_vehiculemarques` (
`id` int(11) NOT NULL,
  `entities_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `glpi_plugin_vehicules_vehiculemarques`
--

INSERT INTO `glpi_plugin_vehicules_vehiculemarques` (`id`, `entities_id`, `name`, `comment`) VALUES
(1, 0, 'Peugeot', ''),
(2, 0, 'Renault', ''),
(3, 0, 'Citroën', ''),
(4, 0, 'BMW', '');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_vehiculemodeles`
--

CREATE TABLE `glpi_plugin_vehicules_vehiculemodeles` (
`id` int(11) NOT NULL,
  `entities_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `glpi_plugin_vehicules_vehiculemodeles`
--

INSERT INTO `glpi_plugin_vehicules_vehiculemodeles` (`id`, `entities_id`, `name`, `comment`) VALUES
(1, 0, '206', ''),
(2, 0, '207', ''),
(3, 0, 'X1', '');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_vehicules`
--

CREATE TABLE `glpi_plugin_vehicules_vehicules` (
`id` int(11) NOT NULL,
  `entities_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locations_id` int(11) NOT NULL DEFAULT '0' COMMENT 'RELATION to glpi_locations (id)',
  `date_affectation` date DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `states_id` int(11) NOT NULL DEFAULT '0' COMMENT 'RELATION to glpi_states (id)',
  `users_id` int(11) NOT NULL DEFAULT '0' COMMENT 'RELATION to glpi_users (id)',
  `is_helpdesk_visible` int(11) NOT NULL DEFAULT '1',
  `date_mod` datetime DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `notepad` longtext COLLATE utf8_unicode_ci,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `plugin_vehicules_vehiculetypes_id` int(11) DEFAULT NULL,
  `num_immat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_immat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plugin_vehicules_vehiculemarques_id` int(11) DEFAULT NULL,
  `plugin_vehicules_vehiculemodeles_id` int(11) DEFAULT NULL,
  `code_ident` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `denom_com` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_ident` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plugin_vehicules_vehiculegenres_id` int(11) DEFAULT NULL,
  `plugin_vehicules_vehiculecarburants_id` int(11) DEFAULT NULL,
  `puissance_admin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nb_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ptac` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `glpi_plugin_vehicules_vehicules`
--

INSERT INTO `glpi_plugin_vehicules_vehicules` (`id`, `entities_id`, `name`, `locations_id`, `date_affectation`, `date_expiration`, `states_id`, `users_id`, `is_helpdesk_visible`, `date_mod`, `comment`, `notepad`, `is_deleted`, `plugin_vehicules_vehiculetypes_id`, `num_immat`, `date_immat`, `plugin_vehicules_vehiculemarques_id`, `plugin_vehicules_vehiculemodeles_id`, `code_ident`, `denom_com`, `num_ident`, `plugin_vehicules_vehiculegenres_id`, `plugin_vehicules_vehiculecarburants_id`, `puissance_admin`, `nb_place`, `ptac`) VALUES
(1, 0, '207 blanhe', 4, '2014-08-01', '2014-08-18', 1, 4, 1, '2014-08-20 15:27:11', 'changer le statut', NULL, 0, NULL, 'BB - 456 - CC', '2014-07-01', 1, 2, 'fgsdfgsdfgsdfsdfg', 'az', 'thfghdfghdfghdfgh', 1, 5, '4', '2', '12345'),
(2, 0, '206 bleu', 1, '2014-08-05', '2014-08-20', 1, 4, 1, '2014-08-20 15:11:58', '', NULL, 0, NULL, 'AA - 123 - BB', '2014-08-01', 1, 1, '1234AZZERTY', 'XV33', 'AZERTYUY', 1, 6, '5', '5', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `glpi_plugin_vehicules_vehiculetypes`
--

CREATE TABLE `glpi_plugin_vehicules_vehiculetypes` (
`id` int(11) NOT NULL,
  `entities_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `glpi_plugin_vehicules_vehiculetypes`
--

INSERT INTO `glpi_plugin_vehicules_vehiculetypes` (`id`, `entities_id`, `name`, `comment`) VALUES
(1, 0, 'Fonction', 'Véhicules de fonction'),
(2, 0, 'Service', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `glpi_plugin_vehicules_configs`
--
ALTER TABLE `glpi_plugin_vehicules_configs`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `glpi_plugin_vehicules_notificationstates`
--
ALTER TABLE `glpi_plugin_vehicules_notificationstates`
 ADD PRIMARY KEY (`id`), ADD KEY `states_id` (`states_id`);

--
-- Index pour la table `glpi_plugin_vehicules_profiles`
--
ALTER TABLE `glpi_plugin_vehicules_profiles`
 ADD PRIMARY KEY (`id`), ADD KEY `profiles_id` (`profiles_id`);

--
-- Index pour la table `glpi_plugin_vehicules_vehiculecarburants`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculecarburants`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `glpi_plugin_vehicules_vehiculegenres`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculegenres`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `glpi_plugin_vehicules_vehiculemarques`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculemarques`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `glpi_plugin_vehicules_vehiculemodeles`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculemodeles`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `glpi_plugin_vehicules_vehicules`
--
ALTER TABLE `glpi_plugin_vehicules_vehicules`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`name`), ADD KEY `entities_id` (`entities_id`), ADD KEY `locations_id` (`locations_id`), ADD KEY `date_expiration` (`date_expiration`), ADD KEY `states_id` (`states_id`), ADD KEY `users_id` (`users_id`), ADD KEY `is_helpdesk_visible` (`is_helpdesk_visible`), ADD KEY `is_deleted` (`is_deleted`);

--
-- Index pour la table `glpi_plugin_vehicules_vehiculetypes`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculetypes`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`name`), ADD KEY `entities_id` (`entities_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_configs`
--
ALTER TABLE `glpi_plugin_vehicules_configs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_notificationstates`
--
ALTER TABLE `glpi_plugin_vehicules_notificationstates`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_profiles`
--
ALTER TABLE `glpi_plugin_vehicules_profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_vehiculecarburants`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculecarburants`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_vehiculegenres`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculegenres`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_vehiculemarques`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculemarques`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_vehiculemodeles`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculemodeles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_vehicules`
--
ALTER TABLE `glpi_plugin_vehicules_vehicules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `glpi_plugin_vehicules_vehiculetypes`
--
ALTER TABLE `glpi_plugin_vehicules_vehiculetypes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
