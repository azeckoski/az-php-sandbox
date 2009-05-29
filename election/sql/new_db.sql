CREATE TABLE elections_entries ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    users_pk			int(10) NOT NULL,
    image_pk			int(10) NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    interests   		text NULL,
    url    				varchar(255) NULL,
    approved			enum('0','1') NOT NULL DEFAULT '0',
    viewable			enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(pk)
);

// table for storing uploaded files
CREATE TABLE elections_images (
	pk					INT(10) NOT NULL AUTO_INCREMENT,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	name				VARCHAR(100) NOT NULL,
	type				VARCHAR(100) NOT NULL,
	size				INT NOT NULL,
	dimensions			VARCHAR(100) NOT NULL,
	content				BLOB NOT NULL,
	thumb				MEDIUMBLOB,
	thumbtype			VARCHAR(100),
	PRIMARY KEY(pk)
);

ALTER TABLE `elections_entries` ADD `electionsID` VARCHAR( 10 ) NOT NULL AFTER `users_pk` ;
