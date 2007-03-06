{\rtf1\mac\ansicpg10000\cocoartf102
{\fonttbl\f0\fswiss\fcharset77 Helvetica;\f1\fnil\fcharset77 LastResort;}
{\colortbl;\red255\green255\blue255;}
\margl1440\margr1440\vieww9000\viewh9000\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\ql\qnatural

\f0\fs24 \cf0 -- phpMyAdmin SQL Dump\
-- version 2.6.2-rc1\
-- http://www.phpmyadmin.net\
-- \
-- Host: bengali.web.itd.umich.edu\
-- Generation Time: Jun 06, 2005 at 12:26 PM\
-- Server version: 4.0.20\
-- PHP Version: 5.0.4\
-- \
-- Database: `sakai`\
-- \
\
-- --------------------------------------------------------\
\
-- \
-- Table structure for table `facebook`\
-- \
\
DROP TABLE IF EXISTS `facebook`;\
CREATE TABLE IF NOT EXISTS `facebook` (\
  `id` int(11) NOT NULL auto_increment,\
  `First` varchar(25) default NULL,\
  `Last` varchar(25) default NULL,\
  `Institution` varchar(100) default NULL,\
  `email` varchar(70) default NULL,\
  `pict` varchar(70) default NULL,\
  `interests` text,\
  `url` varchar(250) default NULL,\
  `password` varchar(30) default 'ironchef',\
  PRIMARY KEY  (`id`),\
  FULLTEXT KEY `First` (`First`,`Last`,`Institution`,`interests`)\
) TYPE=MyISAM AUTO_INCREMENT=225 ;\
\
-- \
-- Dumping data for table `facebook`\
-- \
\
REPLACE INTO `facebook` VALUES (1, 'Susan', 'Hardin', 'University of Michigan', 'shardin@umich.edu', '../images/stories/facebook/shardin1.jpg', 'web content, php, mysql', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (2, 'Joseph', 'Hardin', 'University of Michigan', 'hardin@umich.edu', '../images/stories/facebook/Heading_South2.gif', 'Governance, collaboration and research tools, OCW, RDF', 'http://www-personal.umich.edu/~hardin', 'ironchef');\
REPLACE INTO `facebook` VALUES (88, 'Brad', 'Wheeler', 'Indiana University', 'bwheeler@indiana.edu', '../images/stories/facebook/bcw_small.jpg', 'Governance, licensing, community development', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (134, 'Ivo', 'Antoniazzi', 'Teachers College Columbia Univ', 'ia53@columbia.edu', '../images/stories/facebook/caricweb.gif', 'Management/development of CMS', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (131, 'Jeshua', 'Pacifici', 'VIrginia Tech', 'jeshua@vt.edu', '../images/stories/facebook/SEPPmug.gif', 'UI Design, User Support, QA, Learning Outcomes', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (132, 'Tim', 'Altom', 'Indiana University', 'taltom@iupui.edu', '../images/stories/facebook/Tim_AltomReduced.jpg', 'Software design, collaborative environments', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (133, 'Frank', 'Benneker', 'University of Amsterdam', 'w.f.m.benneker@uva.nl', '../images/stories/facebook/frank.png', 'Philosophy (of science); \\r\\nThe Internet & scoial s', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (127, 'Sean', 'DeMonner', 'University of Michigan', 'demonner@umich.edu', '../images/stories/facebook/Sean_DeMonner.jpg', 'User Support, Quality Assurance, Training', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (126, 'Ian', 'Dolphin', 'The University of Hull', 'i.dolphin@hull.ac.uk', '../images/stories/facebook/PB001.jpg', 'Enterprise integration, uPortal, research uses', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (114, 'Ralph', 'Quarles', 'Indiana University', 'quarles@indiana.edu', '../images/stories/facebook/quarles.ralph.iu.jpg', 'Library Resources in Sakai, libraries', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (115, 'Angela', 'Rabuck', 'Rice University', 'adehart@owlnet.rice.edu', '../images/stories/facebook/Angela_Rabuck.jpg', 'Gradebook, Migration, Instructional Design, Develo', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (120, 'Jan', 'Day', 'Blackboard', 'jday@blackboard.com', '../images/stories/facebook/JanPostonDay.jpg', '.', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (121, 'Grame', 'Barty', 'HarvestRoad Limited', 'gbarty@harvestroad.com.au', '../images/stories/facebook/grame.jpg', 'Content bridging\\r\\nObject Repositories\\r\\nReusable Ob', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (27, 'Anthony', 'Whyte', 'University of Michigan', 'arwhyte@umich.edu', '../images/stories/facebook/ARWhyte_02.jpg', 'Java development, web services, SQL', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (124, 'Shizuo', 'Asogawa', 'Carnegie Mellon CyLab Japan', 'sasogawa@cmuj.jp ;sasogawa@zetta.co.jp', '../images/stories/facebook/shizux4a.jpg', 'Classical Languages (classical Chinese,classical G', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (128, 'Rob', 'Lowden', 'Indiana University', 'rlowden@iu.edu', '../images/stories/facebook/rlowden.gif', 'Course Management Systems, E-portfolios, Technolog', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (129, 'Ron', 'Lewis', 'UNC Charlotte', 'rlewis@email.uncc.edu', '../images/stories/facebook/ronlewis.jpg', 'Music, Drawing, Tennis, Basketball, Art, Travel, R', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (130, 'Bill', 'Crosbie', 'Rutgers University', 'bcrosbie@rci.rutgers.edu', '../images/stories/facebook/BillCrosbie-June2005.jpg', 'Enterprise integration, Tool Development, pedagogy', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (122, 'Elliot', 'Metsger', 'Johns Hopkins University', 'emetsger@jhu.edu', '../images/stories/facebook/elliot_metsger_thumb.jpg', 'wsrp, portlets', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (123, 'Garland', 'Elmore', 'Indiana University', 'elmore@iu.edu', '../images/stories/facebook/Garland Elmore.jpg', 'CMS strategies, user support, training, collaborat', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (119, 'Gloria', 'Hardman', 'Yale University', 'gloria.hardman@yale.edu', '../images/stories/facebook/gloria_hardman.jpg', 'user support,  interface design, pedagogy, migrati', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (117, 'Scott', 'Fischbein', 'University of California, Davis', 'email2@climbernet.com', '../images/stories/facebook/scott.jpg', 'tools development, deployment, pedagogy', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (118, 'Ben', 'Brophy', 'MIT', 'benbr@mit.edu', '../images/stories/facebook/benbr.jpg', 'interaction design, PHP, user experience', 'http://web.mit.edu/benbr/notes/', 'ironchef');\
REPLACE INTO `facebook` VALUES (113, 'Scott', 'Diener', 'The University of Auckland', 's.diener@auckland.ac.nz', '../images/stories/facebook/scottdiener.jpg', 'Enterprise integration, innovation support, SOA', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (112, 'Charles', 'Kerns', 'Stanford University', 'charles.kerns@stanford.edu', '../images/stories/facebook/charles.kerns.jpg', 'Educational gaming in history and politics', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (105, 'Robert', 'Brill', 'New York University', 'bobby@nyu.edu', '../images/stories/facebook/bb.jpg', 'running, tennis, golf, travel, food, wine, movies,', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (106, 'Matthew', 'Hyclak', 'Ohio University', 'hyclak@math.ohiou.edu', '../images/stories/facebook/matthew_hyclak.jpg', 'Instructional Design, Open Source, IT/Faculty inte', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (107, 'Ray', 'Barker', 'The rSmart Goup', 'rbarker@rsmart.com', '../images/stories/facebook/raybarker.jpg', 'Full contact origami', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (108, 'Chris', 'Coppola', 'The rSmart Group', 'chris.coppola@rsmart.com', '../images/stories/facebook/coppola_300x230.png', 'portfolio, gradebook, melete, samigo, architecture', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (109, 'Jonah', 'Bossewitch', 'Columbia University', 'jonah@ccnmtl.columbia.edu', '../images/stories/facebook/jonahs_head_2005a.jpg', 'Philosophy, Open Source, Linux, Python, Content Ma', 'http://ccnmtl.columbia.edu/', 'ironchef');\
REPLACE INTO `facebook` VALUES (110, 'Maggie', 'McVay Lynch', 'Portland State University', 'mmlynch@pdx.edu', '../images/stories/facebook/lynch.jpg', 'instructional design, e-learning management, conte', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (111, 'David', 'Goodrum', 'Indiana University', 'goodrum@indiana.edu', '../images/stories/facebook/david_goodrum.jpg', 'Faculty development', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (98, 'Mark', 'Norton', 'Nolaria Consulting', 'markjnorton@earthlink.net', '../images/stories/facebook/SakaiChef.jpg', 'Broad interest in developing eLearning systems, co', 'http://www.nolaria.org', 'ironchef');\
REPLACE INTO `facebook` VALUES (136, 'Brian', 'Nielsen', 'Northwestern University', 'b-nielsen@northwestern.edu', '../images/stories/facebook/bn-380-x-460.jpg', 'faculty development, sociology of science, collabo', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (135, 'Lance', 'Speelmon', 'Indiana University', 'lance@indiana.edu', '../images/stories/facebook/LDS.jpg', 'Sakai 3.0 :)', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (102, 'Magnus', 'Tagesson', 'Stockholm University', 'magnus.tagesson@it.su.se', '../images/stories/facebook/magnus.jpg', 'Pedagogy, evaluation, communication tools, user su', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (104, 'Mara', 'Hancock', 'UC Berkeley', 'mara@media.berkeley.edu', '../images/stories/facebook/mara_hancock2.jpg', 'People and Technology\\r\\n\\r\\n', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (137, 'Pete', 'Boysen', 'Iowa State University', 'pboysen@iastate.edu', '../images/stories/facebook/pete_image.jpg', 'Learning Management, uPortal, Java, Electronic Por', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (138, 'Jim', 'Laffey', 'Univ. of Missouri-Columbia', 'laffeyj@missouri.edu', '../images/stories/facebook/laffey small.jpg', 'Interaction design, social computing', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (139, 'Gissur', 'Jonsson', 'Roskilde University, Denmark(EU)', 'gissurj@ruc.dk', '../images/stories/facebook/summer_gissur_closeup.jpg', 'Enterprise (System integration), Pedagogy, User support', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (140, 'Tim', 'DiLauro', 'Johns Hopkins University', 'timmo@jhu.edu', '../images/stories/facebook/jcard_photo.jpg', 'digital libraries, system architecture, service/repository integration', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (141, 'Charles', 'Severance', 'University of Michigan', 'csev@umich.edu', '../images/stories/facebook/crs160.jpg', 'Coding, ATV Riding', 'http://www.dr-chuck.com', 'ironchef');\
REPLACE INTO `facebook` VALUES (143, 'Malcolm', 'Brown', 'Dartmouth College', 'malcolm.brown@dartmouth.edu', '../images/stories/facebook/malcolm.jpg', 'Pedagogy; User Interface; enterprise', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (144, 'Anthony', 'Cocciolo', 'Teachers College, Columbia University', 'cocciolo@tc.columbia.edu', '../images/stories/facebook/ac.jpg', 'New media & education, philosophy, digtal libraries', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (145, 'Ruvi', 'Wijesuriya', 'Arizona State University', 'ruvi@asu.edu', '../images/stories/facebook/RWatDesk.jpg', 'Course and Content Management Systems, E-Portfolios, Mtn biking, and Scuba... simultaneously.', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (146, 'Joshua', 'Ryan', 'Arizona State University', 'joshua.ryan@asu.edu', '../images/stories/facebook/joshua_ryan_asu.jpg', 'Enterprise integration, Migration, Tool Development, Cycling, Most anything nerdy', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (148, 'Rafizan "Uda"', 'Baharum', 'Center For Professional Development', 'udabahar@umich.edu', '../images/stories/facebook/rafizan_baharum.jpg', 'Java development, Firefox extensions', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (149, 'Michael', 'Farris', 'Texas State University', 'mf03@txstate.edu', '../images/stories/facebook/mike.jpg', '\\r\\n', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (151, 'Paul', 'Gandel', 'Syracuse University', 'pgandel@syr.edu', '../images/stories/facebook/DSC_0346.jpg', '', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (153, 'Wolfgang', 'Schnerring', 'Ostrakon Ltd.', 'schnerring@ostrakon.org', '../images/stories/facebook/wolfgang_schnerring.jpg', 'Software engineering, E-guitar', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (154, 'Edward', 'Maloney', 'Georgetown University', 'ejm@georgetown.edu', '../images/stories/facebook/emaloney.jpg', 'Innovation in Teaching, Learning, and Technology', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (155, 'Christoph', 'Zrenner', 'Ostrakon Ltd.', 'zrenner@ostrakon.org', '../images/stories/facebook/christoph.zrenner.jpg', 'Course Evaluation, Medical Teaching', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (156, 'Vivie', 'Sinou', 'Foothill College', 'sinouvivian@foothill.edu', '../images/stories/facebook/vivies.jpg', 'Human Interaction & Technology', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (157, 'Chris', 'Brandt', 'Univeristy of California, Davis', 'cmbrandt@ucdavis.edu', '../images/stories/facebook/Chris.Brandt.jpg', 'Tablet PCs, PDAs, and SCUBA', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (158, 'Thomas', 'Amsler', 'University of California, Davis', 'tpamsler@ucdavis.edu', '../images/stories/facebook/amsler_pic.jpg', 'Java, Linux, Collaboration-Tools', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (159, 'Mary', 'Miles', 'University of Michigan', 'mmiles@umich.edu', '../images/stories/facebook/Mary.JPG', 'Sakai/SEPP Project Administrative Coordinator', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (160, 'Kathi', 'Reister', 'University of Michigan', 'kreister@umich.edu', '../images/stories/facebook/Kathi.JPG', 'Sakai/SEPP Support Staff', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (161, 'Andy', 'Klesh', 'University of Michigan', 'aklesh@umich.edu', '../images/stories/facebook/Andy.JPG', 'Sakai/SEPP Support Staff', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (162, 'Michael', 'Morrison', 'Syracuse University', 'memorr02@syr.edu', '../images/stories/facebook/mem212.jpg', 'Instructional Technology', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (163, 'Adrian', 'Teo', 'Arizona State University', 'adrian.teo@asu.edu', '../images/stories/facebook/facebook.jpg', 'Distance Learning, Online Course delivery, Systems Integration, anything that has four wheels and go', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (164, 'Clay', 'Fenlason', 'Boston University', 'clayf@bu.edu', '../images/stories/facebook/BoSox.jpg', 'Philosophy\\r\\nPhysics\\r\\nTraveling on the Cheap\\r\\n', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (165, 'Aaron', 'Zeckoski', 'Virginia Tech', 'aaron@vt.edu', '../images/stories/facebook/aaron_z_small.jpg', 'none', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (166, 'Jeff', 'Beeman', 'Arizona State University', 'jeff.beeman@asu.edu', '../images/stories/facebook/jeffb.jpg', 'Instructional Technology, Systems Integration, Multimedia Integration, Web Standards, Everything gam', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (167, 'Randall', 'Embry', 'Indiana University', 'rpembry@indiana.edu', '../images/stories/facebook/randall_embry_20050602-2.jpg', 'portfolio, OSP, content management, repository', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (168, 'Mike', 'Osterman', 'Whitman College', 'ostermmg@whitman.edu', '../images/stories/facebook/whitman_mike_osterman.jpg', 'tool development, web services, enterprise integration, all things music', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (169, 'Anthony', 'Atkins', 'Virginia Tech', 'anthony.atkins@vt.edu', '../images/stories/facebook/anthony_atkins.jpg', 'eportfolios, end user support, back end integration', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (170, 'Lois', 'Brooks', 'Stanford', 'lbrooks@stanford.edu', '../images/stories/facebook/lbrooks.jpg', 'interoperability, photography, governance, content integration, non-work travel', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (171, 'Jutta', 'Treviranus', 'University of Toronto', 'jutta@utoronto.ca', '../images/stories/facebook/juttanor2.JPG', 'Inclusive software design', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (172, 'Baljeet', 'Dhaliwal', 'Simon Fraser University, Canada', 'bsd@sfu.ca', '../images/stories/facebook/batuka_baljeet.jpg', 'Assemble-To-Order LMS', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (173, 'Tom', 'Braziunas', 'North Seattle Community College', 'tbraziun@sccd.ctc.edu', '../images/stories/facebook/Tom_Braziunas.jpg', 'Online course design and instruction, geology, biking, scrabble', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (174, 'Dick', 'Ellis', 'University of Michigan', 'rwellis@umich.edu', '../images/stories/facebook/face.gif', 'tool development, systems integration, vertical applications', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (175, 'Gale', 'MOORE', 'University of Toronto', 'gmoore@kmdi.utoronto.ca', '../images/stories/facebook/gale.jpg', 'knowledge media design', 'http://kmdi.utoronto.ca', 'ironchef');\
REPLACE INTO `facebook` VALUES (176, 'Victor', 'Maijer', 'University of Amsterdam', 'v.n.maijer@uva.nl', '../images/stories/facebook/VictorMaijer.jpg', 'Enterprise, QA and migration', NULL, 'ironchef');\
REPLACE INTO `facebook` VALUES (178, 'Judi', 'Kirkpatrick', 'Kapiolani Community College-U. Hawaii', 'judikirkpatrick@hawaii.rr.com', '../images/stories/facebook/j.kirkpatrick.jpg', 'CMS., EPort., Fac.Dev., OS in ed.', 'http://www2.hawaii.edu/~kirkpatr', 'pass');\
REPLACE INTO `facebook` VALUES (179, 'Per', 'Wising', 'Stockholm University', 'per.wising@it.su.se', '../images/stories/facebook/61055.gif', 'Integration, Architecture, Roadmap, Development', 'http://people.su.se/~wisin/', 'pass');\
REPLACE INTO `facebook` VALUES (180, 'John', 'Leasia', 'University of Michigan', 'jleasia@umich.edu', '../images/stories/facebook/john_leasia_mug.jpg', 'Next gen tools, technology, integration', '', 'pass');\
REPLACE INTO `facebook` VALUES (181, 'Amitava Babi', 'Mitra', 'MIT', 'babi@mit.edu', '../images/stories/facebook/babi_mitra_denver.jpg', 'People and technology, Business models for service organizations, Growing up with my children, Playing squash', 'http://web.mit.edu/amps/', 'pass');\
REPLACE INTO `facebook` VALUES (182, 'Keiko', 'Pitter', 'Whitman College', 'pitterk@whitman.edu', '../images/stories/facebook/mar2005.jpg', '  ', '', 'pass');\
REPLACE INTO `facebook` VALUES (183, 'Allyn', 'Radford', 'HarvestRoad', 'aradford@harvestroad.com', '../images/stories/facebook/AJR.jpg', 'Repository models, Content reuse/sharing, eLearning standards', 'www.harvestroad.com', 'pass');\
REPLACE INTO `facebook` VALUES (184, 'Paul', 'Hertz', 'Northwestern University', 'paul-hertz@northwestern.edu', '../images/stories/facebook/retrato_hertz2.jpg', 'art, music, hiking', 'http://collaboratory.nunet.net/phertz/', 'pass');\
REPLACE INTO `facebook` VALUES (185, 'Michael', 'Maciarello', 'Delaware State University', 'mmaciare@desu.edu', '../images/stories/facebook/mmaciare2.gif', 'free-form databases, portlets, emerging technologies', 'http://cars.desu.edu/faculty/mmaciare', 'pass');\
REPLACE INTO `facebook` VALUES (186, 'Walter', 'Kimball', 'University of Southern Maine', 'wkimball@usm.maine.edu', '../images/stories/facebook/WKimballMainesmall.jpg', 'tennis, cohorts, collaborating', '', 'pass');\
REPLACE INTO `facebook` VALUES (187, 'Stephen', 'Marquard', 'University of Cape Town', 'marquard@ched.uct.ac.za', '../images/stories/facebook/stephen-marquard-jan05.jpg', 'Customizing Sakai, online collaboration, wikis, Jabber/XMPP', 'http://www.cet.uct.ac.za', 'pass');\
REPLACE INTO `facebook` VALUES (188, 'Ted', 'Dodds', 'University of British Columbia', 'ted.dodds@ubc.ca', '../images/stories/facebook/ted_clr_jpg.jpg', 'People and strategy', 'www.estrategy.ubc.ca', 'pass');\
REPLACE INTO `facebook` VALUES (189, 'Chris', 'Amelung', 'University of Missouri-Columbia', 'amelungc@missouri.edu', '../images/stories/facebook/amelung1.jpg', 'web development, collaboration tools, social computing', '', 'pass');\
REPLACE INTO `facebook` VALUES (190, 'Andrew', 'Petro', 'Yale University', 'andrew.petro@yale.edu', '../images/stories/facebook/awp9_yale_200.JPG', 'uPortal JSR-168 CAS wikis ', 'http://tp.its.yale.edu/confluence/display/TP/Andrew+Petro', 'pass');\
REPLACE INTO `facebook` VALUES (191, 'Mike', 'Stanger', 'Simon Fraser University', 'mstanger@sfu.ca', '../images/stories/facebook/MikeStanger2.jpg', 'Deployment and Integration', '', 'pass');\
REPLACE INTO `facebook` VALUES (192, 'Ronald', 'Verhage', 'Hogeschool Zeeland University', 'ronald.verhage@hz.nl', '../images/stories/facebook/RonaldVerhage.jpg', 'Databases, Application development', '', 'pass');\
REPLACE INTO `facebook` VALUES (193, 'Javier', 'Ayala', 'Portland State University', 'ayalaj@pdx.edu', '../images/stories/facebook/3529.jpg', 'faculty development, diversity, curriculum design', '', 'pass');\
REPLACE INTO `facebook` VALUES (194, 'Nate', 'Angell', 'Portland State University', 'angell@pdx.edu', '../images/stories/facebook/angell_nate.jpg', 'educational technology, web communications, critical theory', 'http://web.pdx.edu/~angell/', 'pass');\
REPLACE INTO `facebook` VALUES (196, 'Ian', 'Boston', 'University of Cambridge', 'ian@caret.cam.ac.uk', '../images/stories/facebook/ieb.jpg', 'Architecture, Tools, Integration', 'http://www.caret.cam.ac.uk', 'pass');\
REPLACE INTO `facebook` VALUES (197, 'Eric', 'Fredericksen', 'Cornell University', 'eef22@cornell.edu', '../images/stories/facebook/FredericksenEric.jpg', 'Teaching and learning supported by technology, educational research', 'http://atms.cit.cornell.edu/people/people_profile.cfm?ID=44', 'pass');\
REPLACE INTO `facebook` VALUES (198, 'Beth', 'Harris', 'Fashion Institute of Technology, SUNY', 'beth_harris@fitnyc.edu', '../images/stories/facebook/me2.jpg', 'wondering why the facebook is overwhelmingly male', '', 'pass');\
REPLACE INTO `facebook` VALUES (199, 'Gary', 'Holeman', 'LeTourneau University', 'sakaiconference.garyholeman@xoxy.net', '../images/stories/facebook/Holeman.jpg', 'Guitar, trumpet, music composition and sequencing, baseball, basketball, racquetball, tennis', 'http://www.letu.edu/people/garyholeman', 'pass');\
REPLACE INTO `facebook` VALUES (200, 'Scott', 'Siddall', 'The Longsight Group', 'siddall@longsight.com', '../images/stories/facebook/SES-CLR-FRML.jpg', 'Open source, of course!', 'http://siddall.info', 'pass');\
REPLACE INTO `facebook` VALUES (201, 'Elizabeth', 'Van Gordon', 'Indiana University', 'vgordon@iu.edu', '../images/stories/facebook/DSC01174-3.JPG', 'CMS Migration, Adoption, Faculty and Student Support and Training', '', 'pass');\
REPLACE INTO `facebook` VALUES (202, 'Michael', 'Buchanon', 'Michigan State University', 'buchanon@msu.edu', '../images/stories/facebook/mike_and_goat.jpg', 'martial arts, coding, reading, and meeting new people', 'http://manetheren.cl.msu.edu/~buchanon/', 'pass');\
REPLACE INTO `facebook` VALUES (203, 'Lionel', 'Tolan', 'Simon Fraser University', 'lionel@sfu.ca', '../images/stories/facebook/Photo.jpg', 'Governance, Sailboat Racing', 'www.sfu.ca/~lionel', 'pass');\
REPLACE INTO `facebook` VALUES (204, 'Max', 'Wood', 'The University of Hull', 'm.k.wood@hull.ac.uk', '../images/stories/facebook/18-09-04_1620.jpg', 'Taking drinking lessons from Robert Brill, Face-warming in New Orleans', '', 'pass');\
REPLACE INTO `facebook` VALUES (205, 'Mads Freek', 'Petersen', 'Roskilde University', 'freek@ruc.dk', '../images/stories/facebook/P6060218.JPG', 'enterprise integration', 'http://www.ruc.dk/~freek', 'pass');\
REPLACE INTO `facebook` VALUES (206, 'Peter', 'Knoop', 'University of Michigan', 'knoop@umich.edu', '../images/stories/facebook/Peter.jpg', 'Collaboration and Learning Environments, Instructional Technology for field courses, Cenozoic Paleoceanography', 'http://www-personal.umich.edu/~knoop', 'pass');\
REPLACE INTO `facebook` VALUES (207, 'Diego', 'del Blanco Orobitg', 'Universidad Polit
\f1 \uc0\u65533 
\f0 cnica de Valencia', 'ddelblanco@abierta.upv.es', '../images/stories/facebook/DiegodelBlanco.jpg', 'Cyclism, Nature, Books... ok, Technology too...', 'http://personales.upv.es/~diedelbl/', 'pass');\
REPLACE INTO `facebook` VALUES (209, 'Trisha', 'Gordon', 'University of Virginia', 'psg3a@virginia.edu', '../images/stories/facebook/Hubba-Bubba .jpg', 'bubble-blowing, sleeping in', 'http://www.people.virginia.edu/~psg3a/', 'pass');\
REPLACE INTO `facebook` VALUES (210, 'Cheryl', 'Wogahn', 'Yale University', 'cheryl.wogahn@yale.edu', '../images/stories/facebook/myavatar.jpg', 'Sakai (of course!)', '', 'pass');\
REPLACE INTO `facebook` VALUES (211, 'Sean', 'Keesler', 'Syracuse University', 'smkeesle@syr.edu', '../images/stories/facebook/SeanKeesler.jpg', 'Fishing and Biking.', '', 'pass');\
REPLACE INTO `facebook` VALUES (212, 'Beth', 'Kirschner', 'University of Michigan', 'bkirschn@umich.edu', '../images/stories/facebook/MoscowCircus-small.jpg', 'Software & lion training', '', 'pass');\
REPLACE INTO `facebook` VALUES (213, 'Sue', 'Workman', 'Indiana University', 'sbworkma@indiana.edu', '../images/stories/facebook/sue1203_1.jpg', 'User Support, Knowledge Management', 'http://mypage.iu.edu/~sbworkma/', 'pass');\
REPLACE INTO `facebook` VALUES (214, 'Theron', 'Feist', 'Johns Hopkins University', 'tfeist@jhu.edu', '../images/stories/facebook/Theron.jpg', 'Ice Hockey, My Son, Nerdy Stuff', 'http://www.cer.jhu.edu', 'pass');\
REPLACE INTO `facebook` VALUES (215, 'Allison', 'Bloodworth', 'University of California, Berkeley', 'abloodworth@berkeley.edu', '../images/stories/facebook/Allisonface.jpg', 'collaborative tools, pedagogy, Sakai & uPortal relationship', 'http://eberkeley.berkeley.edu', 'pass');\
REPLACE INTO `facebook` VALUES (216, 'Ian', 'Goh', 'Johns Hopkins University', 'ian.goh@jhu.edu', '../images/stories/facebook/ian.jpg', 'webct,ims content,enterprise standards,mac os x', 'http://homepage.mac.com/iangoh/', 'pass');\
REPLACE INTO `facebook` VALUES (217, 'Mustapha', 'Es-salihe', 'Computer Research Institut of Montreal', 'messalih@crim.ca', '../images/stories/facebook/mustapha_essalihe.jpg', 'Tools architecture and development\\r\\nE-learning standards\\r\\nLearning design', 'http://www.crim.ca', 'pass');\
REPLACE INTO `facebook` VALUES (218, 'Michael', 'Rennick', 'Teachers College, Columbia Univ.', 'michael@frameworkers.com', '../images/stories/facebook/picture-5.jpg', 'learner-centric e-learning, KM', '', 'pass');\
REPLACE INTO `facebook` VALUES (219, 'Becky', 'Nickoli', 'Ivy Tech State College-Central Office', 'rnickoli@ivytech.edu', '../images/stories/facebook/bn.JPG', 'Fitness, Reading, Grandchildren', '', 'pass');\
REPLACE INTO `facebook` VALUES (220, 'Carmen', 'Garner', 'Ivy Tech State College - Central Office', 'cgarner@ivytech.edu', '../images/stories/facebook/ceg.JPG', 'Gardening, Activities with my family', '', 'pass');\
REPLACE INTO `facebook` VALUES (221, 'Abu', 'Moniruzzaman', 'Ivy Tech State College', 'moniruza@hotmail.com', '../images/stories/facebook/abu.jpg', 'Traveling, Politics, World News', '', 'pass');\
REPLACE INTO `facebook` VALUES (222, 'Greg', 'Simmons', 'Appalachian State University', 'simmonsgc@appstate.edu', '../images/stories/facebook/gregpic.jpg', 'TLT, collaborative learning, bonsai', '', 'pass');\
REPLACE INTO `facebook` VALUES (223, 'Shawn', 'Mann', 'Coastline College', 'smann@coastline.edu', '../images/stories/facebook/adopting_monkeys.jpg', 'Attempting to find the time to do absolutely nothing.  This has proven to be an almost impossible undertaking.', 'http://dl.ccc.cccd.edu', 'pass');\
REPLACE INTO `facebook` VALUES (224, 'Jean', 'Kent', 'Seattle Community College District', 'jkent@sccd.ctc.edu', '../images/stories/facebook/jeankent.jpg', 'Tools, pedagogy, ePortfolio', 'http://faculty.northseattle.edu/jkent', 'pass');\
        }