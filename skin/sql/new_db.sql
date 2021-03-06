// table for storing uploaded files and images
CREATE TABLE skin_files (
	pk					int(10) NOT NULL AUTO_INCREMENT,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_created		timestamp NULL,
	name				VARCHAR(100) NOT NULL,
	type				VARCHAR(100) NOT NULL,
	size				INT NOT NULL,
	dimensions			VARCHAR(100) NOT NULL,
	content				BLOB NOT NULL,
	thumb				MEDIUMBLOB,
	thumbtype			VARCHAR(100),
	PRIMARY KEY(pk)
);

// table for storing skin entries
CREATE TABLE skin_entries (
	pk					int(10) AUTO_INCREMENT NOT NULL,
	users_pk			int(10) NOT NULL,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_created		timestamp NULL,
    title				varchar(100),
    description			text,
    url					varchar(200),
    skin_zip			int(10) NOT NULL REFERENCES skin_files(pk),
    image1				int(10) NOT NULL REFERENCES skin_files(pk),
    image2				int(10) NOT NULL REFERENCES skin_files(pk),
    image3				int(10) NOT NULL REFERENCES skin_files(pk),
    image4				int(10) NOT NULL REFERENCES skin_files(pk),
	round				int(4) NOT NULL default 1,
	approved			enum('Y','N') default 'N',
	tested				enum('Y','N') default 'N',
	allow_download		enum('Y','N') default 'N',
	score				int(10) not null default 0;
    PRIMARY KEY(pk)
);

// alter table skin_entries add score int(10) not null default 0;

// table for storing skin votes
CREATE TABLE skin_vote (
	pk					int(10) AUTO_INCREMENT NOT NULL,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_created		timestamp NULL,
	users_pk			int(10) NOT NULL,
	skin_entries_pk		int(10) NOT NULL,
	vote_usability		int(2) NOT NULL,
	vote_asthetic		int(2) NOT NULL,
	round				int(4) NOT NULL default 1,
	PRIMARY KEY(pk),
	FOREIGN KEY (skin_entries_pk) REFERENCES skin_entries(pk)
);
