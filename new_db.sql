
CREATE TABLE users ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    username    	varchar(100) NOT NULL,
    password    	varchar(255) NOT NULL,
    firstname   	varchar(100) NULL,
    lastname    	varchar(100) NULL,
    email       	varchar(100) NULL,
    access      	varchar(100) NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk)
);

CREATE TABLE sessions ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    users_pk    	int(10) NOT NULL DEFAULT '0',
    passkey     	varchar(100) NOT NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk)
);


CREATE TABLE requirements_data ( 
    pk          	varchar(10) AUTO_INCREMENT NOT NULL,
    reporter     	varchar(200) NOT NULL,
    summary      	text NOT NULL,
    description  	text NOT NULL,
    audience     	varchar(100) NOT NULL,
    component    	varchar(100) NOT NULL,
    toolname     	varchar(100) NOT NULL,
    need         	varchar(100) NOT NULL,
    timeframe    	varchar(100) NOT NULL,
    organization 	text NOT NULL,
    projectURL   	text NOT NULL,
    PRIMARY KEY(pk)
);


CREATE TABLE requirement_vote ( 
    pk	         	varchar(10) AUTO_INCREMENT NOT NULL,
    summary     	text NOT NULL,
    rank        	varchar(30) NOT NULL,
    contribute  	varchar(6) NOT NULL,
    resource    	text NOT NULL,
    name        	varchar(100) NOT NULL,
    organization	varchar(200) NOT NULL,
    PRIMARY KEY(pk)
);