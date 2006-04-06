CREATE TABLE users ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    username    		varchar(100) NOT NULL UNIQUE,
    password    		varchar(255) NOT NULL,
    firstname   		varchar(100) NULL,
    lastname    		varchar(100) NULL,
    email       		varchar(100) NOT NULL UNIQUE,
    primaryRole			varchar(100) NULL,
    secondaryRole		varchar(100) NULL,
    address    			varchar(200) NULL,
    city    			varchar(100) NULL,
    state    			varchar(50) NULL,
    zipcode   	 		varchar(50) NULL,
    country   	 		varchar(100) NULL,
    phone    			varchar(20) NULL,
    fax		    		varchar(20) NULL,
    institution			varchar(200) NULL,
    institution_pk  	int(10) NULL,
    sakaiPerms			text NULL,
    userStatus			text NULL,
    PRIMARY KEY(pk)
);

// Password reset command:
// update users set password=PASSWORD('new_pass') where username='shardin';

/*** Changes to the user table
alter table users modify date_modified timestamp not null default CURRENT_TIMESTAMP;
update users set date_modified = NOW();
alter table users add sakaiPerms text;
alter table users add userStatus text;
alter table users add institution varchar(200) not null;
update users set institution = otherInst where institution_pk = 1;
update users join institution on institution.pk = users.institution_pk set users.institution = institution.name where institution_pk > 1;
update users set userStatus='active' where activated='1';
update users set sakaiPerms='admin_accounts' where admin_accounts='1';
update users set secondaryRole = NULL where primaryRole = secondaryRole;

// this has to wait until the provider code is working
alter table users drop column otherInst;
alter table users drop admin_accounts;
alter table users drop admin_reqs;
alter table users drop admin_insts;
alter table users drop activated;
****/

/*** DO NOT ADD THIS TO YOUR USERS TABLE
alter table users add `activated` enum('0','1') NOT NULL default '0';
alter table users add `admin_accounts` enum('0','1') NOT NULL default '0';
alter table users add `admin_reqs` enum('0','1') NOT NULL default '0';
alter table users add `admin_insts` enum('0','1') NOT NULL default '0';
***/

CREATE TABLE roles ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role_name           varchar(100) NOT NULL,
    role_order          int(6) NOT NULL,
    PRIMARY KEY (pk)
);


// the sessions table is a mirror of the users table with session
// information, before you criticize, this is meant to reduce the
// load on the LDAP, basically, user info is only updated when the
// user logs in
CREATE TABLE sessions ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    users_pk    		int(10) NOT NULL DEFAULT '0',
    passkey     		varchar(100) NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk)
);

// This stores a list of permissions for various parts of the system
CREATE TABLE permissions ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    perm_name           varchar(50) NOT NULL UNIQUE,
    perm_description    varchar(250) NOT NULL,
    PRIMARY KEY (pk)
);



CREATE TABLE institution (
    pk				int(10) auto_increment not null,
    name			varchar(255) NOT NULL,
    type			enum('educational','commercial','non-member') NOT NULL DEFAULT 'educational',
    city    		varchar(100) NULL,
    state    		varchar(100) NULL,
    zipcode   		varchar(50) NULL,
    country   		varchar(100) NULL,
    rep_pk			int(10) null,
    repvote_pk		int(10) null,
    primary key(pk)
);

/**
alter table institution modify column type enum('educational','commercial','non-member') NOT NULL DEFAULT 'educational';
alter table institution add city varchar(100) NULL;
alter table institution add state varchar(100) NULL;
alter table institution add zipcode varchar(50) NULL;
alter table institution add country varchar(100) NULL;
**/

/**** This is the base OTHER institution ****
INSERT INTO `institution` ( `pk` , `abbr` , `name` , `rep_pk` , `type` , `repvote_pk` ) 
VALUES ('1', 'Other', '~ Other (non-Member)', NULL , '', NULL );
****/

// see institution.sql file to import the list of institutions 
// Make sure you have ';' seperators turned on