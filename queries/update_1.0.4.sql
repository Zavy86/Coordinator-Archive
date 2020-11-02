--
-- Archive - Update (1.0.4)
--
-- @package Coordinator\Modules\Archive
-- @author  Manuel Zavatta <manuel.zavatta@gmail.com>
-- @link    http://www.coordinator.it
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

ALTER TABLE `archive__documents` ADD `fkRegistry` INT(11) UNSIGNED NOT NULL AFTER `fkCategory`;
ALTER TABLE `archive__documents` ADD INDEX(`fkRegistry`);
ALTER TABLE `archive__documents` ADD FOREIGN KEY (`fkRegistry`) REFERENCES `framework`.`registries__registries`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
