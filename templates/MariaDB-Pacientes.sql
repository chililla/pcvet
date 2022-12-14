CREATE TABLE `pacientes` (
	`pacID` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`nombre` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`naci` DATE NULL DEFAULT NULL,
	`edad` TINYINT(4) NULL DEFAULT NULL,
	`estadocivil` TINYINT(4) NULL DEFAULT NULL,
	`ocupacion` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`sexo` TINYINT(4) NULL DEFAULT NULL,
	`direccion` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`nointerior` INT(11) NULL DEFAULT NULL,
	`noexterior` INT(11) NULL DEFAULT NULL,
	`colonia` VARCHAR(300) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`cp` INT(11) NULL DEFAULT NULL,
	`celular` INT(11) NULL DEFAULT NULL,
	`telcasa` INT(11) NULL DEFAULT NULL,
	`teloffice` INT(11) NULL DEFAULT NULL,
	`email` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`empresaID` INT(11) NULL DEFAULT NULL
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
CHECKSUM=1
;