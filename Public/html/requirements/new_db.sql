CREATE TABLE requirements_data ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    jirakey         varchar(10) NOT NULL UNIQUE,
    jiranum         int(5) NOT NULL default 0,
    summary      	text NOT NULL,
    description  	text NOT NULL,
    component    	varchar(255) NOT NULL,
    audience     	varchar(255) NOT NULL,
    round           int(4) NOT NULL default 1,
    PRIMARY KEY(pk)
);

// Import a JIRA export saved as a CSV file
//mysqlimport -c jirakey,summary,component,description,audience --fields-optionally-enclosed-by=""" --fields-terminated-by=, --lines-terminated-by="\r\n" --local -usakaiwww -p sakaiweb requirements_data.csv
// Import the data in the sakai_requirements_data*.sql file
// Make sure you have ';' seperators turned on
// Fix components: update requirements_data set component = replace(component,'\'','|')

CREATE TABLE requirements_vote ( 
    pk	         	int(10) AUTO_INCREMENT NOT NULL,
    users_pk		int(10) NOT NULL,
    req_data_pk		int(10) NOT NULL,
    vote		int(2) NOT NULL,
    round		int(4) NOT NULL default 1,
    official   		enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(pk),
    FOREIGN KEY (users_pk) REFERENCES users(pk),
    FOREIGN KEY (req_data_pk) REFERENCES requirements_data(pk)
);

/**** to get old tables to line up with new structure (use if needed)
alter table requirements_data drop column toolname
alter table requirements_data drop column need
alter table requirements_data drop column timeframe
alter table requirements_data add round int(4) NOT NULL default 1
alter table requirements_vote add round int(4) NOT NULL default 1
alter table requirements_vote add official enum('0','1') NOT NULL DEFAULT '0'
alter table requirements_data add jiranum int(5) not null default 0
update requirements_data set jiranum = replace(jirakey,'REQ-','')
*****/