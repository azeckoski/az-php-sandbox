
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

// Import a JIRA export saved as a CSV file
//mysqlimport -c jirakey,summary,component,description,audience --fields-optionally-enclosed-by=""" --fields-terminated-by=, --lines-terminated-by="\r\n" --local -usakaiwww -p sakaiweb requirements_data.csv

CREATE TABLE requirements_vote ( 
    pk	         	int(10) AUTO_INCREMENT NOT NULL,
    users_pk		int(10) NOT NULL,
    req_data_pk		int(10) NOT NULL,
    vote		int(2) NOT NULL,
    PRIMARY KEY(pk),
    FOREIGN KEY (users_pk) REFERENCES users(pk),
    FOREIGN KEY (req_data_pk) REFERENCES requirements_data(pk)
);
