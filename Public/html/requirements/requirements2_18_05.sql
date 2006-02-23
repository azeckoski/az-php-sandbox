-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: bengali.web.itd.umich.edu
-- Generation Time: Feb 18, 2006 at 10:43 AM
-- Server version: 4.1.10
-- PHP Version: 5.0.5
-- 
-- Sakai Requirements voting  form tables  from shardin
-- 
-- 
-- Database: `sakai_dev`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `requirement_vote`
-- 

DROP TABLE IF EXISTS `requirement_vote`;
CREATE TABLE IF NOT EXISTS `requirement_vote` (
  `key` varchar(10) NOT NULL default '',
  `summary` text NOT NULL,
  `rank` varchar(30) NOT NULL default '',
  `contribute` varchar(6) NOT NULL default '',
  `resource` text NOT NULL,
  `name` varchar(100) NOT NULL default '',
  `organization` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `requirement_vote`
-- 

INSERT INTO `requirement_vote` VALUES ('REQ-54', 'In tools like Discussion, Announcements, etc. there should be an indication of whether items have been read or remain unread.', 'critical', 'yes', 'developer time', 'Susan Hardin', 'University of Michigan');

-- --------------------------------------------------------

-- 
-- Table structure for table `requirements_data`
-- 

DROP TABLE IF EXISTS `requirements_data`;
CREATE TABLE IF NOT EXISTS `requirements_data` (
  `key` varchar(10) NOT NULL default '',
  `reporter` varchar(200) NOT NULL default '',
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `audience` varchar(100) NOT NULL default '',
  `component` varchar(100) NOT NULL default '',
  `toolname` varchar(100) NOT NULL default '',
  `need` varchar(100) NOT NULL default '',
  `timeframe` varchar(100) NOT NULL default '',
  `designers` text NOT NULL,
  `programmers` text NOT NULL,
  `qa_specialist` text NOT NULL,
  `organization` text NOT NULL,
  `projectURL` text NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `requirements_data`
-- 

INSERT INTO `requirements_data` VALUES ('REQ-93', 'reporter', 'Worksite Menu Items Can Be ReOrganized.', 'The worksite instructor or maintainer will be able to re-order the worksite menu items. For example, if the instructor wants one course menu to read "Announcements, Dropbox, Discussion, Schedule, Assignments" he will be able to rearrange the order through a pull-down menu system. Benefits of this:\r\n\r\n-instructors & maintainers have control over the "flow" of their course and are not restrained by the global menu properties\r\n\r\n-worksites will have more variety in their appearance ', 'audience', 'Site Info', 'toolname', 'need', 'timeframe', 'designers', 'programmers', 'qa_specialist', 'organization', 'projectURL');
INSERT INTO `requirements_data` VALUES ('REQ-92', 'reporter4', ' Availability Dates for Resources', 'An instructor or maintainer will have the ability to configure the read permissions of individual folders or files so that they are available to students,TAs or access users for a specified time period. This feature is similar to timed release option for assignments (open date/ due date).\r\n\r\nThis will allow instructors or maintainers finer control of the availability of documents in the Resources area.', 'audience', 'component', 'toolname', 'need', 'timeframe', 'designers', 'programmers', 'qa_specialist', 'organization', 'projectURL');
INSERT INTO `requirements_data` VALUES ('REQ-91', 'reporter2', 'Configurable Permissions in Resources', '  	The instructor or maintainer of a worksite will have the ability to set permissions for individual folders and files within resources. For example, an instructor could restrict (hide) a folder in Resources until he is ready to make it available to students. The instructor would do:\r\n-Resources\r\n-Click "Folder Permissions" next to the desired sub folder\r\n-Unclick the checkbox next to Student and under "read" (currently this is checked by default and cannot be altered when read is allowed at the site level)\r\n\r\nThe current design of requiring instructors to turn off read permissions at the site level to prevent read access to subfolders is undesirable as it is more likely that instructors will want to turn off access to individual folders & files while leaving the majority of documents as read access.', 'audience', 'Resources', 'toolname', 'need', 'timeframe', 'designers', 'programmers', 'qa_specialist', 'organization', 'projectURL');
INSERT INTO `requirements_data` VALUES ('REQ-90', 'reporter3', 'Migration data from Balckboard v6.3(+) to Sakai', 'As I know Sakai already has a migration tool for Blackboard 5.5. But since Blackboard 5.5 is quite different with v6.3 and v7. I think the migration tool need to be upgraded.\r\nOur university plans for first pilot during summer semester. We need this migration tool as early as possible. (unfortunatly we do not have resource work on this now)\r\nWe talked about this during Austin conference. Zach Thomas (University of Texa) primary involved the tool development for v5.5. I have a impression seems like the new version tool will be ready by end of 1st Q. Has this been scheduled?\r\n  undesirable as it is more likely that instructors will want to turn off access to individual folders & files while leaving the majority of documents as read access.', 'audience', 'Resources', 'toolname', 'need', 'timeframe', 'designers', 'programmers', 'qa_specialist', 'organization', 'projectURL');
