CREATE TABLE users ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    username    		varchar(100) NOT NULL UNIQUE,
    password    		varchar(255) NOT NULL,
    firstname   		varchar(100) NULL,
    lastname    		varchar(100) NULL,
    email       		varchar(100) NOT NULL UNIQUE,
    date_created		timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    activated   		enum('0','1') NOT NULL DEFAULT '0',
    institution_pk  	int(10) NULL,
    admin_accounts	int(2) NULL,
    admin_reqs		int(2) NULL,
    admin_insts		int(2) NULL,
    PRIMARY KEY(pk)
);

//alter table users drop column access;
//alter table users add admin_accounts int(2) NULL;
//alter table users add admin_reqs int(2) NULL;
//alter table users add admin_insts int(2) NULL;

insert into users (username, password, email,activated) values ('aaronz',PASSWORD('password1'),'aaronz@vt.edu','1');
insert into users (username, password, email,activated) values ('shardin',PASSWORD('password2'),'shardin@umich.edu','1');
insert into users (username, password, email,activated) values ('tblake',PASSWORD('password3'),'tblake@vt.edu','1');

CREATE TABLE sessions ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    users_pk    	int(10) NOT NULL DEFAULT '0',
    passkey     	varchar(100) NOT NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk),
    FOREIGN KEY (users_pk) REFERENCES users(pk)
);

CREATE TABLE institution (
    pk			int(10) auto_increment not null,
    abbr			varchar(25) null,
    name			varchar(255) NOT NULL,
    type			enum('educational','commerical') NOT NULL DEFAULT 'educational',
    rep_pk		int(1) null,
    primary key(pk),
    foreign key (rep_pk) references users(pk)
);

// alter table institution add type enum('educational','commerical') NOT NULL DEFAULT 'educational';

// see institution.sql file to import the list of institutions 
// Make sure you have ';' seperators turned on