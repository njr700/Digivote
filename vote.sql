SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de données : `vote_db`

CREATE DATABASE vote_db;
USE vote_db;

-- Structure de la table `admin`

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `postnom` varchar(50) DEFAULT NULL,
  `matricule` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricule` (`matricule`);

-- AUTO_INCREMENT pour la table `enregistrement`

ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

-- Déchargement des données de la table `admin`

INSERT INTO `admin` (`id`, `nom`, `prenom`, `postnom`, `matricule`, `pwd`) VALUES
(1, 'Manasse', 'Esther', 'Kitumani','AD-KA1SNTC1E', '1111'),
(2, 'Ntenta', 'Gad', 'Ngoyi', 'AD-UYS6GBW8G', '2222'),
(3, 'Mukeba', 'Julia', 'Thornicroft', 'AD-VQUQIKJZO', '3333'),
(4, 'Kiazi', 'Gwenaelle', 'KITUMAINI', 'AD-1RMD1Z2BB', '4444'),
(5, 'Lushima', 'Krys', 'Shotshe', 'AD-N40GRCWZP', '5555'),
(6, 'Kadima', 'Donatien', 'Mwamba', 'AD-VSXKY2IOE', '6666');

-- --------------------------------------------------------

-- Structure de la table `staff`

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `postnom` varchar(50) DEFAULT NULL,
  `matricule` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricule` (`matricule`);

-- AUTO_INCREMENT pour la table `enregistrement`

ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

-- Déchargement des données de la table `staff`

INSERT INTO `staff` (`id`, `nom`, `prenom`, `postnom`, `matricule`, `pwd`) VALUES
(1, 'Manasse', 'Esther', 'Kitumani','AD-KA1SNTC1E', '1234'),
(2, 'Ntenta', 'Gad', 'Ngoyi', 'AD-UYS6GBW8G', '2345'),
(3, 'Mukeba', 'Julia', 'Thornicroft', 'AD-VQUQIKJZO', '3456'),
(4, 'Kiazi', 'Gwenaelle', 'KITUMAINI', 'AD-1RMD1Z2BB', '4567'),
(5, 'Lushima', 'Krys', 'Shotshe', 'AD-N40GRCWZP', '5678'),
(6, 'Kadima', 'Donatien', 'Mwamba', 'AD-VSXKY2IOE', '6789');

-- --------------------------------------------------------

-- Structure de la table `electeur`

CREATE TABLE `electeur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `postnom` varchar(50) DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `numero_identite` varchar(255)  NOT NULL,
  `photo` varchar(255) NOT NULL,
  `defaultPassword` varchar(255) NOT NULL,
  `newPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `electeur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identite` (`numero_identite`);

-- AUTO_INCREMENT pour la table `enregistrement`

ALTER TABLE `electeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

-- Déchargement des données de la table `electeur`

INSERT INTO `electeur` (`id`, `nom`, `prenom`, `postnom`, `adresse`, `numero_identite`, `photo`, `defaultPassword`, `newPassword`) VALUES
(18, 'martine', 'mulongo', 'jane', 'limete 2ème', 'ID-KA1SNTC1E', '44cdc87c-1bf7-43d4-950f-30dd2762c393.jpeg', '', ''),
(19, 'paul', 'thompson', 'ricky', 'limete', 'ID-UYS6GBW8G', 'Business Portraits.jpeg', '', ''),
(20, 'julie', 'mukeba', 'thornicroft', 'limete', 'ID-VQUQIKJZO', 'Seamless Style_ Human Hair Extensions for Flawless Sew-In Transformations.jpeg', '', ''),
(21, 'MANASSE', 'Esther', 'KITUMAINI', '28 Av.Equateur', 'ID-1RMD1Z2BB', 'User Avatar.jpeg', '', ''),
(30, 'Gwen', 'Kiazi', 'Gwenaelle', '11e rue limete/industrielle', 'ID-N40GRCWZP', 'Corporate Portraits - Tracy Wright Corvo Photography.jpeg', 'lolo', ''),
(31, 'naelle', 'kiazi', 'gwen', 'Limete', 'ID-VSXKY2IOE', 'images (1).jpg', 'pass-z3ghtp11', '');

-- --------------------------------------------------------

-- Structure de la table `candidat`

CREATE TABLE `candidat` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `postnom` varchar(50) DEFAULT NULL,
  `poste` varchar(250) NOT NULL,
  `numero_identite` varchar(255) NOT NULL,
  `photo` longblob DEFAULT NULL,
  `defaultPassword` varchar(255) NOT NULL,
  `newPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `candidat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identite` (`numero_identite`);

-- AUTO_INCREMENT pour la table `enregistrement`

ALTER TABLE `candidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;


-- Déchargement des données de la table `candidat`

INSERT INTO `candidat` (`id`, `nom`, `prenom`, `postnom`, `poste`, `numero_identite`, `photo`, `defaultPassword`, `newPassword`) VALUES
(1, 'marie anne', 'lukusa', 'marthe', '', 'ID-MA3PL1OYW', 0x30323566646639372d653036392d346563382d383334392d6135366462383335636532642e6a706567, '', ''),
(2, 'maurice', 'parker', 'simon', '', 'ID-QB97OYK25', 0x4c696e6b6564696e2050726f66696c65205469707320616e6420547269636b732e6a706567, '', ''),
(3, 'jean', 'mutombo', 'mitchell', '', 'ID-X33JBXLA6', 0x4d616e2773204865616473686f742e6a706567, '', ''),
(4, 'jane', 'mart', 'mimi', '', 'ID-XRXCTKOQV', 0x436f72706f726174652050686f746f73686f6f74202d20436f72706f72617465204865616473686f74732053696e6761706f72652e6a706567, '', ''),
(5, 'tim', 'thompson', 'lumière', '', 'ID-C69W8TDEH', 0x33643837663235342d376430332d343662382d623934392d6530623839643035336663342e6a706567, '', ''),
(6, 'voldi', 'kamana', 'kamba', 'presidence', 'ID-WXPVFAJXO', 0x75706c6f6164732f696d61676573202831292e6a7067, 'nono', '');

-- --------------------------------------------------------

-- Structure de la table `unique_codes`

CREATE TABLE `unique_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Index pour la table `unique_codes`

ALTER TABLE `unique_codes`
  ADD PRIMARY KEY (`id`);


-- AUTO_INCREMENT pour la table `unique_codes`

ALTER TABLE `unique_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;


-- Déchargement des données de la table `unique_codes`

INSERT INTO `unique_codes` (`id`, `code`) VALUES
(1, 'b77af22334'),
(2, '1276839c4c'),
(3, '9dd2be5aa3'),
(4, 'a44efa8e75'),
(5, 'f669bdf246'),
(6, '26a12274d7'),
(7, '3315a8ed86'),
(8, 'cbd82a8648'),
(9, '0a45aabb8d'),
(10, '9d6ce6a9ce'),
(11, 'a82831d0af'),
(12, '00fbdcdcaa'),
(13, '51122da126'),
(14, 'd16cc5d17d'),
(15, '8353acc293'),
(16, '8cd1ba111d'),
(17, 'c6fbae380f'),
(18, 'd494592238'),
(19, 'ed279bb915'),
(20, 'eec1f597d7'),
(21, 'f2c13bf9eb'),
(22, '2084109214'),
(23, '11160aebac'),
(24, 'c1e39f5091'),
(25, '6ddda191e2'),
(26, '9f226c77c4'),
(27, 'a12bd19a53'),
(28, '2fcf34d172'),
(29, 'ba9678cb41'),
(30, '61f87195dc'),
(31, '45b8657bcb'),
(32, '2594a66744'),
(33, 'e9892d109c'),
(34, 'ef96d20962'),
(35, 'dc880e29cd'),
(36, '09966921be'),
(37, '9f95fed054'),
(38, '6001b11e53'),
(39, '5d041426f1'),
(40, '70fa12e3fa'),
(41, '01ba85a840'),
(42, '43feaa8cb7'),
(43, '50a6cec8bc'),
(44, 'c897d0edfc'),
(45, 'd42397aa61'),
(46, '15209ce48c'),
(47, '56e1ce372b'),
(48, '34448936c7'),
(49, '9ca5eff638'),
(50, '407f08f0e0'),
(51, '4a1d856303'),
(52, '92466c70eb'),
(53, 'c41e7ab1b0'),
(54, '1cf9d1b7c3'),
(55, '3e9c71958c'),
(56, '3d01f5c635'),
(57, '9ca920242a'),
(58, '2ee3b58888'),
(59, 'cf93f3dd4e'),
(60, '783e63b453'),
(61, 'a1c12b4543'),
(62, '67f13166c0'),
(63, '3ea45f36a7'),
(64, '0619bf2a19'),
(65, '23a7c149f6'),
(66, 'db04dd0baa'),
(67, 'c172c3736c'),
(68, '3a3ec6f184'),
(69, 'c9ea13e393'),
(70, '31b2971c43'),
(71, 'c2c9bf3fa5'),
(72, 'f15b33d891'),
(73, 'b4c154a2c7'),
(74, '452000baf4'),
(75, 'b5c1c38af0'),
(76, '8a2ae24c12'),
(77, 'e266eb1d9a'),
(78, 'c9a9a3e1af'),
(79, '3d9bfb4bae'),
(80, '61cc1303fd'),
(81, 'd69f8e52e0'),
(82, '126923fd82'),
(83, 'b978fd4b00'),
(84, 'b47ac5d806'),
(85, '9d517fc867'),
(86, 'e28ae72ffe'),
(87, '28d1bf4dd1'),
(88, '8655ce82e1'),
(89, '92e2c49bdd'),
(90, 'b5996dce54'),
(91, '992442f1f9'),
(92, '74d4a9235a'),
(93, '9f61217925'),
(94, '1bac300810'),
(95, 'e905bb54c9'),
(96, 'e2b479903b');

-- --------------------------------------------------------

-- Structure de la table 'election'

CREATE TABLE election (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NOT NULL,
            date_creation DATETIME NOT NULL,
            heure_debut TIME NOT NULL,
            heure_fin TIME NOT NULL
        );

-- Structure de la table `votes`

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `option_name` varchar(50) NOT NULL,
  `unique_code` varchar(10) NOT NULL,
  `numero_identite` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Index pour la table `votes`

ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numero_identite` (`numero_identite`);

-- AUTO_INCREMENT pour la table `votes`

ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;


-- Contraintes pour la table `votes`

ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`numero_identite`) REFERENCES `electeur` (`numero_identite`);
COMMIT;

