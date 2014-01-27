CREATE TABLE IF NOT EXISTS  `ttm_2014`.`users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(256) NOT NULL,
	`username` VARCHAR(256) NOT NULL,
	`email` VARCHAR(256) NOT NULL,
	`password` VARCHAR(256) NOT NULL,
	`email_code` VARCHAR(256) NOT NULL,
	`email_validated` INT(2) NOT NULL,
	`created` DATETIME NOT NULL,
	`last_login` DATETIME NOT NULL
)ENGINE = INNODB;