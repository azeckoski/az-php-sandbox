// new conferences table
CREATE TABLE conferences (
    id         		int(10) AUTO_INCREMENT NOT NULL,
    confID     		varchar(50) NOT NULL,
    users_pk   		int(10) NOT NULL DEFAULT '0',
    date_created	timestamp NOT NULL,
    date_modified	timestamp NOT NULL,
    shirt      		varchar(50) NULL,
    special    		text NULL,
    confHotel  		enum('Y','N') NULL DEFAULT 'Y',
    publishInfo		enum('Y','N') NULL DEFAULT 'N',
    jasig			enum('Y','N') NULL DEFAULT 'N',
    fee        		decimal(7,0) NOT NULL DEFAULT '0',
    delegate   		varchar(200) NULL,
    expectations	text NULL,
    activated		enum('Y','N') NULL DEFAULT 'N',
    payeeInfo		text NULL,
    transID			varchar(100) NULL,
    PRIMARY KEY(id)
);


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

CREATE TABLE cfp_vancouver_demo (
  id int(11) NOT NULL,
  `date` timestamp NULL,
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

//changes to cfp_vancouver_demo
ALTER TABLE `cfp_vancouver_demo` ADD `users_pk` INT( 10 ) NOT NULL AFTER `confID` ;
