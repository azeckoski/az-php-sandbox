
CREATE TABLE requirements_data ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    jirakey             varchar(10) NOT NULL UNIQUE,
    summary      	text NOT NULL,
    description  	text NOT NULL,
    audience     	varchar(100) NOT NULL,
    component    	varchar(100) NOT NULL,
    toolname     	varchar(100),
    need         	varchar(100),
    timeframe    	varchar(100),
    PRIMARY KEY(pk)
);



CREATE TABLE requirement_vote ( 
    pk	         	int(10) AUTO_INCREMENT NOT NULL,
    summary     	text NOT NULL,
    rank        	varchar(30) NOT NULL,
    contribute  	varchar(6) NOT NULL,
    resource    	text NOT NULL,
    name        	varchar(100) NOT NULL,
    organization	varchar(200) NOT NULL,
    PRIMARY KEY(pk)
);