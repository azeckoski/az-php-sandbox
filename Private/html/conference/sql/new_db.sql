// new conferences table
CREATE TABLE conferences (
  id int(10) NOT NULL auto_increment,
  confID varchar(50) NOT NULL default '',
  users_pk int(10) NOT NULL default '0',
  date_created timestamp NULL default '0000-00-00 00:00:00',
  date_modified timestamp NOT NULL default CURRENT_TIMESTAMP,
  shirt varchar(50) default NULL,
  special text,
  confHotel enum('Y','N') default 'Y',
  publishInfo enum('Y','N') default 'N',
  jasig enum('Y','N') default 'N',
  fee decimal(7,0) NOT NULL default '0',
  delegate varchar(200) default NULL,
  expectations text,
  activated enum('Y','N') default 'N',
  payeeInfo text,
  transID varchar(100) default NULL,
  PRIMARY KEY  (id)
)


// new proposals table - conf_proposals

CREATE TABLE conf_proposals ( 
    pk           	int(10) AUTO_INCREMENT NOT NULL,
    date_modified	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    date_created 	timestamp NULL DEFAULT NULL,
    confID       	varchar(10) NOT NULL,
    users_pk     	int(10) NOT NULL DEFAULT '0',
    `type`         	varchar(90) NULL,
    new_type     	varchar(20) NULL,
    title        	varchar(100) NULL,
    abstract     	text NULL,
    `desc`         	text NULL,
    speaker      	varchar(200) NULL,
    URL          	varchar(150) NULL,
    bio          	text NULL,
    layout       	varchar(10) NULL,
    `length`       	int(3) NOT NULL DEFAULT '0',
    conflict     	varchar(20) NULL,
    co_speaker   	varchar(250) NULL,
    co_bio       	text NULL,
    approved     	enum('Y','N') NOT NULL DEFAULT 'N',
    PRIMARY KEY(pk)
)

CREATE TABLE conf_proposals_vote ( 
    pk						int(10) AUTO_INCREMENT NOT NULL,
    users_pk				int(10) NOT NULL,
    conf_proposals_pk		int(10) NOT NULL,
    vote					int(2) NOT NULL,
    confID					varchar(10) NOT NULL,
    PRIMARY KEY(pk)
);


// topics table
CREATE TABLE topics (
    pk                  int(10) auto_increment NOT NULL,
    date_created        timestamp NULL,
    date_modified       timestamp NOT NULL default CURRENT_TIMESTAMP,
    topic_name          varchar(100) NOT NULL,
    topic_order         int(6) NOT NULL,
    PRIMARY KEY (pk)
);

// topics linking table
CREATE TABLE proposals_topics (
    pk                  int(10) auto_increment NOT NULL,
    date_created        timestamp NULL,
    date_modified       timestamp NOT NULL default CURRENT_TIMESTAMP,
    proposals_pk        int(10) NOT NULL REFERENCES conf_proposals(pk),
    topics_pk           int(10) NOT NULL REFERENCES topics(pk),
    choice				int(2) NOT NULL,
    PRIMARY KEY (pk)
);

// audience linking table
CREATE TABLE proposals_audiences (
    pk                  int(10) auto_increment NOT NULL,
    date_created        timestamp NULL,
    date_modified       timestamp NOT NULL default CURRENT_TIMESTAMP,
    proposals_pk        int(10) NOT NULL REFERENCES conf_proposals(pk),
    roles_pk            int(10) NOT NULL REFERENCES roles(pk),
    choice              int(2) NOT NULL,
    PRIMARY KEY (pk)
);

// old proposals tables
CREATE TABLE proposal_presentation (
  id int(11) NOT NULL,
  date timestamp NULL default NULL,
  confID varchar(10) NOT NULL default '',
  users_pk int(10) NOT NULL default '0',
  topics varchar(50) NOT NULL default '',
  p_format varchar(90) NOT NULL default '0',
  p_title varchar(100) NOT NULL default '',
  p_abstract text NOT NULL,
  p_desc text NOT NULL,
  p_speaker varchar(200) NOT NULL default '',
  p_URL varchar(150) NOT NULL default '',
  bio text NOT NULL,
  firstname varchar(100) NOT NULL default '',
  lastname varchar(100) NOT NULL default '',
  email1 varchar(100) NOT NULL default '',
  dev int(2) NOT NULL default '0',
  faculty char(2) NOT NULL default '0',
  mgr char(2) NOT NULL default '0',
  librarian char(3) NOT NULL default '',
  sys_admin char(2) NOT NULL default '0',
  univ_admin char(2) NOT NULL default '0',
  ui_dev char(2) NOT NULL default '0',
  support char(2) NOT NULL default '',
  faculty_dev char(2) NOT NULL default '0',
  implementors char(2) NOT NULL default '0',
  instruct_dev char(2) NOT NULL default '0',
  instruct_tech char(3) NOT NULL default '',
  layout varchar(10) NOT NULL default '',
  length int(3) NOT NULL default '0',
  conflict_tues char(2) NOT NULL default '0',
  conflict_wed char(2) NOT NULL default '0',
  conflict_thurs char(2) NOT NULL default '0',
  conflict_fri char(2) NOT NULL default '0',
  co_speaker varchar(250) NOT NULL default '',
  co_bio text NOT NULL,
  approved int(2) NOT NULL default '0',
  PRIMARY KEY  (id)
)


CREATE TABLE proposal_demo (
  id int(11) NOT NULL,
  date timestamp NULL,
  confID varchar(10) NOT NULL default '',
  users_pk int(10) NOT NULL default '0',
  firstname varchar(30) NOT NULL default '',
  lastname varchar(30) NOT NULL default '',
  email1 varchar(70) NOT NULL default '',
  product varchar(100) NOT NULL default '',
  demo_desc text NOT NULL,
  demo_speaker varchar(150) NOT NULL default '',
  demo_url varchar(150) NOT NULL default '',
  PRIMARY KEY  (id)
)
