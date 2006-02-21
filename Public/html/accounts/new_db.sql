
CREATE TABLE users ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    username    	varchar(100) NOT NULL,
    password    	varchar(255) NOT NULL,
    firstname   	varchar(100) NULL,
    lastname    	varchar(100) NULL,
    email       	varchar(100) NULL,
    access      	varchar(100) NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    activated   	enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(pk)
)

CREATE TABLE sessions ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    users_pk    	int(10) NOT NULL DEFAULT '0',
    passkey     	varchar(100) NOT NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk)
);


