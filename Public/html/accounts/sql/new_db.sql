CREATE TABLE users ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    username    		varchar(100) NOT NULL UNIQUE,
    password    		varchar(255) NOT NULL,
    firstname   		varchar(100) NULL,
    lastname    		varchar(100) NULL,
    email       		varchar(100) NOT NULL UNIQUE,
    primaryRole			varchar(100) NULL,
    secondaryRole		varchar(100) NULL,
    city    			varchar(100) NULL,
    state    			varchar(50) NULL,
    zipcode   	 		varchar(20) NULL,
    country   	 		varchar(100) NULL,
    phone    			varchar(20) NULL,
    fax		    		varchar(20) NULL,
    otherInst			varchar(200) NULL,
    institution_pk  	int(10) NULL,
    activated   		enum('0','1') NOT NULL DEFAULT '0',
    admin_accounts		enum('0','1') NOT NULL DEFAULT '0',
    admin_reqs			enum('0','1') NOT NULL DEFAULT '0',
    admin_insts			enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(pk)
);

CREATE TABLE roles ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role_name           varchar(100) NOT NULL,
    role_order          int(6) NOT NULL,
    PRIMARY KEY (pk)
);

/*** EXTRA info to store in users
alter table users add address varchar(200);
alter table users add city varchar(100);
alter table users add state varchar(50);
alter table users add zipcode varchar(20);
alter table users add country varchar(100);
alter table users add phone varchar(20);
alter table users add fax varchar(20);
alter table users add otherInst varchar(200);
update users set otherInst='unknown' where institution_pk='1';
alter table users add primaryRole varchar(100);
alter table users add secondaryRole varchar(100);
alter table users add date_modified timestamp not null;
****/

// the sessions table is a mirror of the users table with session
// information, before you criticize, this is meant to reduce the
// load on the LDAP, basically, user info is only updated when the
// user logs in
CREATE TABLE sessions ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    users_pk    		int(10) NOT NULL DEFAULT '0',
    passkey     		varchar(100) NOT NULL,
    date_created		timestamp NULL,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk)
);

CREATE TABLE users_cache (
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    users_pk    		int(10) NOT NULL DEFAULT '0',
    date_created		timestamp NULL,
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    username    		varchar(100) NOT NULL,
    firstname   		varchar(100) NULL,
    lastname    		varchar(100) NULL,
    email       		varchar(100) NOT NULL,
    primaryRole			varchar(100) NULL,
    secondaryRole		varchar(100) NULL,
    city    			varchar(100) NULL,
    state    			varchar(100) NULL,
    zipcode   	 		varchar(20) NULL,
    country   	 		varchar(100) NULL,
    phone    			varchar(20) NULL,
    fax		    		varchar(20) NULL,
    institution			varchar(100) NULL,
    institution_pk  	int(10) NULL,
    sakaiPerms			text NULL,
    PRIMARY KEY(pk)
);


CREATE TABLE institution (
    pk				int(10) auto_increment not null,
    abbr			varchar(25) null,
    name			varchar(255) NOT NULL,
    type			enum('educational','commercial') NOT NULL DEFAULT 'educational',
    rep_pk			int(10) null,
    repvote_pk		int(10) null,
    primary key(pk)
);

// alter table institution add type enum('educational','commerical') NOT NULL DEFAULT 'educational';
// alter table institution add repvote_pk int(10) null;
// update institution set repvote_pk = rep_pk where rep_pk is not null;

/**** This is the base OTHER institution ****
INSERT INTO `institution` ( `pk` , `abbr` , `name` , `rep_pk` , `type` , `repvote_pk` ) 
VALUES ('1', 'Other', '~ Other (non-Member)', NULL , '', NULL );
****/

// see institution.sql file to import the list of institutions 
// Make sure you have ';' seperators turned on