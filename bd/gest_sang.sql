-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 17 fév. 2022 à 22:59
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gest_sang`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_cat` int(255) NOT NULL,
  `nom_cat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `nom_cat`) VALUES
(1, 'Administrateur'),
(2, 'Laborantin');

-- --------------------------------------------------------

--
-- Structure de la table `donneur`
--

CREATE TABLE `donneur` (
  `id_donneur` int(255) NOT NULL,
  `nom_donneur` varchar(255) NOT NULL,
  `prenom_donneur` varchar(255) NOT NULL,
  `num_tel` varchar(255) NOT NULL,
  `email_don` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `date_naisse` varchar(255) NOT NULL,
  `id_sexe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `group_sang`
--

CREATE TABLE `group_sang` (
  `id_group` int(255) NOT NULL,
  `nom_group` varchar(255) NOT NULL,
  `id_rhesus` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `group_sang`
--

INSERT INTO `group_sang` (`id_group`, `nom_group`, `id_rhesus`) VALUES
(1, 'O', 1),
(2, 'A', 1),
(3, 'B', 1),
(4, 'AB', 1),
(5, 'O', 2),
(6, 'A', 2),
(7, 'B', 2),
(8, 'AB', 2);

-- --------------------------------------------------------

--
-- Structure de la table `hopital`
--

CREATE TABLE `hopital` (
  `id_hopital` int(255) NOT NULL,
  `nom_hopit` varchar(255) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `id_ile` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hopital`
--

INSERT INTO `hopital` (`id_hopital`, `nom_hopit`, `lieu`, `id_ile`) VALUES
(1, 'Hopital de Hombo', 'Mutsamudu', 2),
(2, 'Hopital de Fomboni', 'Fomboni', 3);

-- --------------------------------------------------------

--
-- Structure de la table `ile`
--

CREATE TABLE `ile` (
  `id_ile` int(255) NOT NULL,
  `nom_ile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ile`
--

INSERT INTO `ile` (`id_ile`, `nom_ile`) VALUES
(1, 'Ngazidja'),
(2, 'Ndzouani'),
(3, 'Mwali'),
(4, 'Maore');

-- --------------------------------------------------------

--
-- Structure de la table `labo`
--

CREATE TABLE `labo` (
  `id_labo` int(255) NOT NULL,
  `nom_labo` varchar(255) NOT NULL,
  `id_hop` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `labo`
--

INSERT INTO `labo` (`id_labo`, `nom_labo`, `id_hop`) VALUES
(1, 'Labo EL_Manrouf', 1);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id_pat` int(255) NOT NULL,
  `nom_pat` varchar(255) NOT NULL,
  `prenom_pat` varchar(255) NOT NULL,
  `adresse_pat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rhesus`
--

CREATE TABLE `rhesus` (
  `id_reh` int(255) NOT NULL,
  `nom_reh` varchar(255) NOT NULL,
  `abre_reh` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rhesus`
--

INSERT INTO `rhesus` (`id_reh`, `nom_reh`, `abre_reh`) VALUES
(1, 'Positif', '+'),
(2, 'Negatif', '-');

-- --------------------------------------------------------

--
-- Structure de la table `sang`
--

CREATE TABLE `sang` (
  `id_sang` int(255) NOT NULL,
  `id_group` int(255) NOT NULL,
  `id_reh` int(255) NOT NULL,
  `stock_sang` varchar(255) NOT NULL,
  `id_labo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id_service` int(255) NOT NULL,
  `nom_serv` varchar(255) NOT NULL,
  `id_hop` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sexe`
--

CREATE TABLE `sexe` (
  `id_sexe` int(11) NOT NULL,
  `nom_sexe` varchar(255) NOT NULL,
  `abrev` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sexe`
--

INSERT INTO `sexe` (`id_sexe`, `nom_sexe`, `abrev`) VALUES
(1, 'Masculin', 'M'),
(2, 'Feminin', 'F');

-- --------------------------------------------------------

--
-- Structure de la table `transfusion`
--

CREATE TABLE `transfusion` (
  `id_trans` int(255) NOT NULL,
  `id_patient` int(255) NOT NULL,
  `id_service` int(255) NOT NULL,
  `id_sang` int(255) NOT NULL,
  `nom_med` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel_user` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `passwod` text NOT NULL,
  `id_cat` int(255) NOT NULL,
  `id_labo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `tel_user`, `login`, `passwod`, `id_cat`, `id_labo`) VALUES
(1, 'Soulaimana', 'Abdallah', '3576760', 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, NULL),
(2, 'Hamza', 'Abdel', '4291236', 'abdel', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 2, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_cat`);

--
-- Index pour la table `donneur`
--
ALTER TABLE `donneur`
  ADD PRIMARY KEY (`id_donneur`);

--
-- Index pour la table `group_sang`
--
ALTER TABLE `group_sang`
  ADD PRIMARY KEY (`id_group`);

--
-- Index pour la table `hopital`
--
ALTER TABLE `hopital`
  ADD PRIMARY KEY (`id_hopital`);

--
-- Index pour la table `ile`
--
ALTER TABLE `ile`
  ADD PRIMARY KEY (`id_ile`);

--
-- Index pour la table `labo`
--
ALTER TABLE `labo`
  ADD PRIMARY KEY (`id_labo`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_pat`);

--
-- Index pour la table `rhesus`
--
ALTER TABLE `rhesus`
  ADD PRIMARY KEY (`id_reh`);

--
-- Index pour la table `sang`
--
ALTER TABLE `sang`
  ADD PRIMARY KEY (`id_sang`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `sexe`
--
ALTER TABLE `sexe`
  ADD PRIMARY KEY (`id_sexe`);

--
-- Index pour la table `transfusion`
--
ALTER TABLE `transfusion`
  ADD PRIMARY KEY (`id_trans`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_cat` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `donneur`
--
ALTER TABLE `donneur`
  MODIFY `id_donneur` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `group_sang`
--
ALTER TABLE `group_sang`
  MODIFY `id_group` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `hopital`
--
ALTER TABLE `hopital`
  MODIFY `id_hopital` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ile`
--
ALTER TABLE `ile`
  MODIFY `id_ile` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `labo`
--
ALTER TABLE `labo`
  MODIFY `id_labo` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id_pat` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rhesus`
--
ALTER TABLE `rhesus`
  MODIFY `id_reh` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sang`
--
ALTER TABLE `sang`
  MODIFY `id_sang` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id_service` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sexe`
--
ALTER TABLE `sexe`
  MODIFY `id_sexe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `transfusion`
--
ALTER TABLE `transfusion`
  MODIFY `id_trans` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
