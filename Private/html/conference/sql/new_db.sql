CREATE TABLE sakaiConf_all ( 
    id         	int(11) AUTO_INCREMENT NOT NULL,
    users_pk   	int(10) NOT NULL DEFAULT '0',
    datea      	timestamp NOT NULL,
    confID     	varchar(10) NOT NULL,
    firstname  	varchar(75) NULL,
    lastname   	varchar(75) NULL,
    badge      	varchar(75) NULL,
    email      	varchar(75) NULL,
    institution	varchar(75) NULL,
    otherInst  	varchar(75) NULL,
    dept       	varchar(75) NULL,
    address1   	varchar(150) NULL,
    address2   	varchar(75) NULL,
    city       	varchar(75) NULL,
    state      	varchar(30) NULL,
    otherState 	varchar(50) NULL,
    zip        	varchar(10) NULL,
    country    	varchar(4) NULL,
    phone      	varchar(20) NULL,
    fax        	varchar(20) NULL,
    shirt      	varchar(10) NULL,
    special    	varchar(100) NULL,
    hotelInfo  	char(2) NULL,
    contactInfo	char(2) NULL,
    jasig      	varchar(4) NOT NULL,
    ospi       	varchar(4) NOT NULL,
    fee        	decimal(7,0) NOT NULL DEFAULT '0',
    title      	varchar(50) NULL,
    delegate   	varchar(100) NULL,
    expectations  	text NULL,
    activated  	enum('Y','N') NULL DEFAULT 'N',
    payeeInfo  	text NULL,
    transID    	varchar(100) NULL,
    PRIMARY KEY(id)
);

// changes to sakai_confall
alter table sakaiConf_all add users_pk int(10) not null default 0;
alter table sakaiConf_all add delegate varchar(100);
alter table sakaiConf_all modify address1 varchar(150);
alter table sakaiConf_all add activated enum('Y','N') default 'N';
alter table sakaiConf_all modify title varchar(50);
alter table sakaiConf_all add payeeInfo text;
alter table sakaiConf_all add transID varchar(100);
alter table sakaiConf_all add expectations text;




CREATE TABLE `cfp_vancouver_presentation` (
  `id` int(11) NOT NULL,
  `date` timestamp NULL default NULL,
  `confID` varchar(10) NOT NULL default '',
  `users_pk` int(10) NOT NULL default '0',
  `topics` varchar(50) NOT NULL default '',
  `p_format` varchar(90) NOT NULL default '0',
  `p_title` varchar(100) NOT NULL default '',
  `p_abstract` text NOT NULL,
  `p_desc` text NOT NULL,
  `p_speaker` varchar(200) NOT NULL default '',
  `p_URL` varchar(150) NOT NULL default '',
  `bio` text NOT NULL,
  `firstname` varchar(100) NOT NULL default '',
  `lastname` varchar(100) NOT NULL default '',
  `email1` varchar(100) NOT NULL default '',
  `dev` int(2) NOT NULL default '0',
  `faculty` char(2) NOT NULL default '0',
  `mgr` char(2) NOT NULL default '0',
  `librarian` char(3) NOT NULL default '',
  `sys_admin` char(2) NOT NULL default '0',
  `univ_admin` char(2) NOT NULL default '0',
  `ui_dev` char(2) NOT NULL default '0',
  `support` char(2) NOT NULL default '',
  `faculty_dev` char(2) NOT NULL default '0',
  `implementors` char(2) NOT NULL default '0',
  `instruct_dev` char(2) NOT NULL default '0',
  `instruct_tech` char(3) NOT NULL default '',
  `layout` varchar(10) NOT NULL default '',
  `length` int(3) NOT NULL default '0',
  `conflict_tues` char(2) NOT NULL default '0',
  `conflict_wed` char(2) NOT NULL default '0',
  `conflict_thurs` char(2) NOT NULL default '0',
  `conflict_fri` char(2) NOT NULL default '0',
  `co_speaker` varchar(250) NOT NULL default '',
  `co_bio` text NOT NULL,
  `approved` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)


//changes to cfp_vancouver_presentation
ALTER TABLE `cfp_vancouver_presentation` CHANGE `p_track` `users_pk` INT( 10 ) NOT NULL DEFAULT '0';
