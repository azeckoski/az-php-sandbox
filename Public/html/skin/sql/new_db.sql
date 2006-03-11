// table for storing uploaded files
CREATE TABLE files (
	pk				INT(10) NOT NULL AUTO_INCREMENT,
	name				VARCHAR(50) NOT NULL,
	type				VARCHAR(50) NOT NULL,
	size				INT NOT NULL,
	content			MEDIUMBLOB NOT NULL,
	thumb			MEDIUMBLOB,
	date_created		timestamp,
	PRIMARY KEY(pk)
);

// table for storing skin entries
CREATE TABLE skin_data (
	pk				int(10) AUTO_INCREMENT NOT NULL,
	users_pk			int(10) NOT NULL,
	title			varchar(50) NOT NULL,
    description		text,
    zip_pk			int(10) NOT NULL,
    image1_pk		int(10) NOT NULL,
    image2_pk		int(10) NOT NULL,
    image3_pk		int(10) NOT NULL,
    image4_pk		int(10) NOT NULL,
	round			int(4) NOT NULL default 1,
	date_created		timestamp,
    PRIMARY KEY(pk)
);

// table for storing skin votes
CREATE TABLE skin_vote (
	pk				int(10) AUTO_INCREMENT NOT NULL,
	users_pk			int(10) NOT NULL,
	skin_data_pk		int(10) NOT NULL,
	vote				int(2) NOT NULL,
	round			int(4) NOT NULL default 1,
	date_created		timestamp,
	PRIMARY KEY(pk),
	FOREIGN KEY (skin_data_pk) REFERENCES skin_data(pk)
);
