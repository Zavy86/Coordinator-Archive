--
-- Archive - Setup (1.0.0)
--
-- @package Coordinator\Modules\Archive
-- @author  Manuel Zavatta <manuel.zavatta@gmail.com>
-- @link    http://www.coordinator.it
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `archive__categories`
--

CREATE TABLE IF NOT EXISTS `archive__categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `archive__categories`
--

INSERT IGNORE INTO `archive__categories` (`id`, `deleted`, `name`, `title`, `color`) VALUES
(1, 0, 'Uncategorized', NULL, '#cccccc');

-- --------------------------------------------------------

--
-- Table structure for table `archive__documents`
--

CREATE TABLE IF NOT EXISTS `archive__documents` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `fkCategory` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkCategory` (`fkCategory`),
  CONSTRAINT `archive__documents_ibfk_1` FOREIGN KEY (`fkCategory`) REFERENCES `archive__categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1000000001 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive__documents__logs`
--

CREATE TABLE IF NOT EXISTS `archive__documents__logs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fkObject` int(11) UNSIGNED NOT NULL,
  `fkUser` int(11) UNSIGNED DEFAULT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `alert` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `event` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `properties_json` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fkObject` (`fkObject`),
  CONSTRAINT `archive__documents__logs_ibfk_1` FOREIGN KEY (`fkObject`) REFERENCES `archive__documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Authorizations
--

INSERT IGNORE INTO `framework__modules__authorizations` (`id`,`fkModule`,`order`) VALUES
('archive-manage','archive',1),
('archive-usage','archive',2);

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
