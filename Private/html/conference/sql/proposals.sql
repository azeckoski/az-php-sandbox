//new conf_proposals table which handles Demos and Presentations
CREATE TABLE `conf_proposals` (
  `id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `date_modified` timestamp NOT NULL,
  `confID` varchar(10) NOT NULL default '',
  `users_pk` int(10) NOT NULL default '0',
  `type` varchar(90) default NULL,
  `new_type` varchar(20) default NULL,
  `title` varchar(100) default NULL,
  `abstract` text,
  `desc` text,
  `speaker` varchar(200) default NULL,
  `URL` varchar(150) default NULL,
  `bio` text,
  `layout` varchar(10) default NULL,
  `length` int(3) NOT NULL default '0',
  `conflict` varchar(20) default NULL,
  `co_speaker` varchar(250) default NULL,
  `co_bio` text,
  `approved` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`)
)

ALTER TABLE `conf_proposals` ADD `sub_track` VARCHAR( 30 ) NOT NULL AFTER `track` ;

//added Pending option
ALTER TABLE `conf_proposals` CHANGE `approved` `approved` ENUM( 'Y', 'N', 'P' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N'

//added on Nov 27 
UPDATE `conf_proposals` SET sub_track = 'Cool Commercial Tool' WHERE sub_track = 'Cool Commercial Offerings';

ALTER TABLE `conf_proposals` ADD `print` ENUM( 'Y', 'N' ) NOT NULL AFTER `poster` ;

//for podcast and presentation urls
ALTER TABLE `conf_proposals` ADD `podcast_url` VARCHAR( 255 ) NOT NULL AFTER `wiki_url` ,
ADD `slides_url` VARCHAR( 255 ) NOT NULL AFTER `podcast_url` ;

