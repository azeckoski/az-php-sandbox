CREATE TABLE topics ( 
	pk           	int(10) AUTO_INCREMENT NOT NULL,
	date_created 	timestamp NULL,
	date_modified	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	topic_name   	varchar(100) NOT NULL,
	topic_order  	int(6) NOT NULL DEFAULT '0',
	PRIMARY KEY (pk)
);

INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(1, '2006-03-24 15:51:27.0', '2006-03-24 15:51:27.0', 'Development', 1);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(2, '2006-03-24 15:51:27.0', '2006-03-24 15:51:27.0', 'Pedagogy', 2);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(3, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Research Collaboration', 3);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(4, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Governance: Sakai Foundation', 4);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(5, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Teaching', 5);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(6, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Local Technical Support', 6);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(7, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Commercial Technical Support', 7);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(8, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Using Portfolios in the Classroom', 8);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(9, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Growing the Sakai Community', 9);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(10, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Learning', 10);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(11, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Reflective Practice for Students and Faculty', 11);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(12, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Overview of Toolset (Melete, Samigo, OSP)', 12);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(13, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'UI Development', 13);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(14, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Assessment of Student Learning', 14);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(15, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Assessment of Programs, Departments', 15);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(16, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Assessment of Institutions of Higher Education', 16);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(17, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'For those New to Sakai', 17);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(18, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Faculty Development', 18);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(19, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Implementation: Pilot', 19);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(20, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Implementation: Production', 20);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(21, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'User Support', 21);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(22, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Instructional Design', 22);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(23, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Sakai Training for Faculty/Staff', 23);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(24, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Sakai Training for Students', 24);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(25, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Institutional Change', 25);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(26, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Licensing/Copyright', 26);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(27, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Visioning for the Future', 27);
INSERT INTO topics(pk, date_created, date_modified, topic_name, topic_order)
  VALUES(28, '2006-03-24 15:51:28.0', '2006-03-24 15:51:28.0', 'Quality Assurance (QA)', 28);
