CREATE TABLE facebook_entries ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    users_pk			int(10) NOT NULL,
    image_pk			int(10) NOT NULL,
    date_created		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_modified	timestamp NOT NULL,
    interests   		text NULL,
    url    			varchar(255) NULL,
    approved			enum('0','1') NOT NULL DEFAULT '0',
    viewable			enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(pk)
);

// table for storing uploaded files
CREATE TABLE facebook_images (
	pk					INT(10) NOT NULL AUTO_INCREMENT,
	date_created			timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	name					VARCHAR(100) NOT NULL,
	type					VARCHAR(100) NOT NULL,
	size					INT NOT NULL,
	dimensions			VARCHAR(100) NOT NULL,
	content				BLOB NOT NULL,
	thumb				MEDIUMBLOB,
	thumbtype			VARCHAR(100),
	PRIMARY KEY(pk)
);