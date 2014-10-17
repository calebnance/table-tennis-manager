CREATE TABLE IF NOT EXISTS  `ttm_2014`.`users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(256) NOT NULL,
	`username` VARCHAR(256) NOT NULL,
	`email` VARCHAR(256) NOT NULL,
	`password` VARCHAR(256) NOT NULL,
	`email_code` VARCHAR(256) NOT NULL,
	`email_validated` INT(2) NOT NULL,
	`is_admin` VARCHAR(10) NOT NULL,
	`created` DATETIME NOT NULL,
	`updated` DATETIME NOT NULL,
	`last_login` DATETIME NOT NULL
)ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS  `ttm_2014`.`match_ref` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`player1` INT( 11 ) NOT NULL,
	`player2` INT( 11 ) NOT NULL,
	`serve_first` INT( 11 ) NOT NULL,
	`date_time_started` DATETIME NOT NULL,
	`total_time` TIME NOT NULL
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS  `ttm_2014`.`match_player` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`match_id` INT( 11 ) NOT NULL,
	`player_id` INT( 11 ) NOT NULL,
	`final_score` INT( 11 ) NOT NULL,
	`aces` INT( 2 ) NOT NULL,
	`bad_serves` INT( 2 ) NOT NULL,
	`frustration` INT( 2 ) NOT NULL,
	`ones` INT( 2 ) NOT NULL,
	`feel_goods` INT( 2 ) NOT NULL,
	`slams_missed` INT( 2 ) NOT NULL,
	`slams_made` INT( 2 ) NOT NULL,
	`digs` INT( 2 ) NOT NULL,
	`foosball` INT( 2 ) NOT NULL,
	`just_the_tip` INT( 2 ) NOT NULL,
	`fabulous` INT( 2 ) NOT NULL,
	`date_created` DATETIME NOT NULL,
	`date_modified` DATETIME NOT NULL,
	`user_created` INT( 11 ) NOT NULL,
	`user_modified` INT( 11 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS  `ttm_2014`.`seasons` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`season_number` INT( 11 ) NOT NULL,
	`start` DATETIME NOT NULL,
	`end` DATETIME NOT NULL,
	`year` INT( 11 ) NOT NULL
) ENGINE = INNODB;
