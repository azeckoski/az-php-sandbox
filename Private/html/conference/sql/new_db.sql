// new conferences table
CREATE TABLE conferences (
  id int(10) NOT NULL auto_increment,
  confID varchar(50) NOT NULL default '',
  users_pk int(10) NOT NULL default '0',
  date_modified timestamp NOT NULL default CURRENT_TIMESTAMP,
  date_created timestamp NULL default '0000-00-00 00:00:00',
  shirt varchar(50) default NULL,
  special text,
  confHotel enum('Y','N') default 'Y',
  publishInfo enum('Y','N') default 'N',
  jasig enum('Y','N') default 'N',
  fee decimal(7,0) NOT NULL default '0',
  delegate varchar(200) default NULL,
  expectations text,
  activated enum('Y','N') default 'N',
  arrived timestamp NULL default NULL,
  printed_badge enum('Y','N') default 'N',
  payeeInfo text,
  transID varchar(100) default NULL,
  PRIMARY KEY  (id)
)

// alter table conferences add arrived timestamp NULL default NULL;
// alter table conferences add printed_badge enum('Y','N') default 'N';

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

//changes to conf_proposals
ALTER TABLE `conf_proposals` ADD `track` VARCHAR( 50 ) NOT NULL;


CREATE TABLE conf_proposals_vote ( 
    pk						int(10) AUTO_INCREMENT NOT NULL,
    date_created			timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    users_pk				int(10) NOT NULL,
    conf_proposals_pk		int(10) NOT NULL,
    vote					int(2) NOT NULL,
    confID					varchar(10) NOT NULL,
    PRIMARY KEY(pk)
);

CREATE TABLE conf_proposals_comments ( 
    pk						int(10) AUTO_INCREMENT NOT NULL,
    date_created			timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    users_pk				int(10) NOT NULL,
    conf_proposals_pk		int(10) NOT NULL,
    comment_text			text NOT NULL,
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

// room scheduling tables
CREATE TABLE conf_rooms ( 
    pk           	int(10) AUTO_INCREMENT NOT NULL,
    date_modified	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    date_created 	timestamp NULL DEFAULT NULL,
    confID       	varchar(10) NOT NULL,
    title			varchar(255) NOT NULL,
    capacity		int(5) NOT NULL DEFAULT 10,
    ordering		int(5) NOT NULL DEFAULT 0,
	room_style		varchar(255) NULL,
    BOF		     	enum('Y','N') NOT NULL DEFAULT 'N',
    PRIMARY KEY(pk)
);

INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(1, '2006-05-09 20:38:42.0', '2006-05-09 20:38:42.0', 'Jun2006', 'Grand A', 100, 1, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(2, '2006-05-09 20:38:42.0', '2006-05-09 20:38:42.0', 'Jun2006', 'Grand B', 100, 2, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(3, '2006-05-09 20:39:13.0', '2006-05-09 20:39:13.0', 'Jun2006', 'Grand C', 100, 3, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(4, '2006-05-09 20:39:24.0', '2006-05-09 20:39:24.0', 'Jun2006', 'Grand D', 100, 4, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(5, '2006-05-09 20:39:48.0', '2006-05-09 20:39:48.0', 'Jun2006', 'Jr A', 100, 5, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(6, '2006-05-09 20:40:08.0', '2006-05-09 20:40:08.0', 'Jun2006', 'Jr B', 100, 6, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(7, '2006-05-09 20:40:08.0', '2006-05-09 20:40:08.0', 'Jun2006', 'Jr C', 100, 7, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(8, '2006-05-09 20:40:08.0', '2006-05-09 20:40:08.0', 'Jun2006', 'Jr D', 100, 8, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(9, '2006-05-09 20:40:19.0', '2006-05-09 20:40:19.0', 'Jun2006', 'Gulf BCD', 100, 9, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(10, '2006-05-09 20:41:11.0', '2006-05-09 20:41:11.0', 'Jun2006', 'Parkville', 50, 10, 'N', NULL);
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(11, '2006-05-09 20:42:37.0', '2006-05-09 20:42:37.0', 'Jun2006', 'Gulf A', 34, 11, 'Y', 'theater');
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(12, '2006-05-09 20:42:37.0', '2006-05-09 20:42:37.0', 'Jun2006', 'Blue', 20, 12, 'Y', 'theater');
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(13, '2006-05-09 20:42:37.0', '2006-05-09 20:42:37.0', 'Jun2006', 'Beluga', 30, 13, 'Y', 'theater');
INSERT INTO conf_rooms(pk, date_modified, date_created, confID, title, capacity, ordering, BOF, room_style)
  VALUES(14, '2006-05-09 20:42:37.0', '2006-05-09 20:42:37.0', 'Jun2006', 'Chart', 8, 14, 'Y', 'board room');

CREATE TABLE conf_timeslots ( 
    pk           	int(10) AUTO_INCREMENT NOT NULL,
    date_modified	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    date_created 	timestamp NULL DEFAULT NULL,
    confID       	varchar(10) NOT NULL,
    ordering		int(6) NOT NULL,
    title			varchar(255) NULL,
    type			varchar(255) NOT NULL DEFAULT 'open',
    start_time		timestamp NOT NULL,
    length_mins		int(5) NOT NULL DEFAULT 30,
    PRIMARY KEY(pk)
);

INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 1, '2006-05-30 7:30', 60, 'coffee', 'Coffee');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 2, '2006-05-30 8:30', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 3, '2006-05-30 10:00', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 4, '2006-05-30 10:15', 105, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 5, '2006-05-30 12:00', 60, 'lunch', 'lunch');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 6, '2006-05-30 13:00', 105, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 7, '2006-05-30 14:45', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 8, '2006-05-30 15:00', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 9, '2006-05-30 16:30', 60, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 10, '2006-05-30 17:30', 120, 'special', 'Karaoke');

INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 11, '2006-05-31 7:30', 60, 'coffee', 'Coffee');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 12, '2006-05-31 8:30', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 13, '2006-05-31 10:00', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 14, '2006-05-31 10:15', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 15, '2006-05-31 11:45', 90, 'lunch', 'lunch');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 16, '2006-05-31 13:15', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 17, '2006-05-31 14:45', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 18, '2006-05-31 15:00', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 19, '2006-05-31 16:30', 60, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 20, '2006-05-31 17:30', 120, 'special', 'Awards');

INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 21, '2006-06-01 7:30', 60, 'coffee', 'Coffee');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 22, '2006-06-01 8:30', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 23, '2006-06-01 10:00', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 24, '2006-06-01 10:15', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 25, '2006-06-01 11:45', 90, 'lunch', 'lunch');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 26, '2006-06-01 13:15', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 27, '2006-06-01 14:45', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 28, '2006-06-01 15:00', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 29, '2006-06-01 16:30', 60, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 30, '2006-06-01 17:30', 120, 'special', 'Tech Demos');

INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 31, '2006-06-02 7:30', 60, 'coffee', 'Coffee');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 32, '2006-06-02 8:30', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 33, '2006-06-02 10:00', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 34, '2006-06-02 10:15', 90, 'event', '');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 35, '2006-06-02 11:45', 30, 'lunch', 'lunch');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 36, '2006-06-02 12:15', 60, 'keynote', 'Keynote2');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 37, '2006-06-02 13:15', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 38, '2006-06-02 13:30', 75, 'keynote', 'Board response to sessions');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 39, '2006-06-02 14:45', 15, 'break', 'break');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 40, '2006-06-02 15:00', 60, 'keynote', 'Executive Director Address');
INSERT INTO conf_timeslots(date_created, confID, ordering, start_time, length_mins, type, title) 
  VALUES(NOW(), 'Jun2006', 41, '2006-06-02 16:00', 60, 'keynote', 'Conference Feedback');

CREATE TABLE conf_sessions ( 
    pk           	int(10) AUTO_INCREMENT NOT NULL,
    date_modified	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    date_created 	timestamp NULL DEFAULT NULL,
    confID       	varchar(10) NOT NULL,
    rooms_pk		int(10) NOT NULL REFERENCES conf_rooms(pk),
    timeslots_pk	int(10) NOT NULL REFERENCES conf_timeslots(pk),
    proposals_pk	int(10) NULL,
    convenor_pk		int(10) NULL,
    recorder_pk		int(10) NULL,
    ordering		int(6) NOT NULL,
    title			varchar(255) NULL,
    PRIMARY KEY(pk)
);

// alter table conf_sessions add convenor_pk int(10) null;
// alter table conf_sessions add recorder_pk int(10) null;

INSERT INTO `conf_sessions` ( `pk` , `date_modified` , `date_created` , `confID` , `rooms_pk` , `timeslots_pk` , `proposals_pk` , `ordering` , `title` )
VALUES
 (NULL , NOW( ) , NULL , 'Jun2006', '11', '2', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '12', '2', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '13', '2', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '14', '2', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '11', '4', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '12', '4', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '13', '4', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '14', '4', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '11', '6', NULL , '0', NULL ), 
 (NULL , NOW( ) , NULL , 'Jun2006', '12', '6', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '13', '6', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '14', '6', NULL , '0', NULL ), 
 (NULL , NOW( ) , NULL , 'Jun2006', '11', '8', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '12', '8', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '13', '8', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '14', '8', NULL , '0', NULL ), 
 (NULL , NOW( ) , NULL , 'Jun2006', '11', '12', NULL , '0', NULL ),
 (NULL , NOW( ) , NULL , 'Jun2006', '12', '12', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '12', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '12', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '14',  NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '12', '14',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '14',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '14',  NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '16',  NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '12', '16',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '16',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '16',  NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '18',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '12', '18',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '18',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '18',  NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '22',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '12', '22',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '22',  NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '22',  NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '24', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '12', '24', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '24', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '24', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '26', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '12', '26', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '26', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '26', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '28', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '12', '28', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '28', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '28', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '11', '32', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '12', '32', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '32', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '32', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '11', '34', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '12', '34', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '13', '34', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '34', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '1', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '2', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '3', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '4', '20', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '5', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '6', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '7', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '8', '20', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '9', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '10', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '11', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '12', '20', NULL , '0', NULL ), 
(NULL , NOW( ) , NULL , 'Jun2006', '13', '20', NULL , '0', NULL ),
(NULL , NOW( ) , NULL , 'Jun2006', '14', '20', NULL , '0', NULL )
;