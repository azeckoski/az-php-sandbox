CREATE TABLE facebook_entries ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    image_pk			int(10) NOT NULL,
    date_created		timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    interests   		text NULL,
    url    				varchar(255) NULL,
    PRIMARY KEY(pk)
);

// table for storing uploaded files
CREATE TABLE facebook_images (
	pk					INT(10) NOT NULL AUTO_INCREMENT,
	date_created		timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	name				VARCHAR(100) NOT NULL,
	type				VARCHAR(100) NOT NULL,
	size				INT NOT NULL,
	content				MEDIUMBLOB NOT NULL,
	thumb				MEDIUMBLOB,
	PRIMARY KEY(pk)
);