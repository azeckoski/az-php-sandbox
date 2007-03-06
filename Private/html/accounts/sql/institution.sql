// export on March 20, 2006 by AZ
CREATE TABLE institution (
  pk int(10) NOT NULL auto_increment,
  abbr varchar(25) default NULL,
  name varchar(255) NOT NULL default '',
  rep_pk int(1) default NULL,
  `type` enum('educational','commercial') default 'educational',
  repvote_pk int(10) default NULL,
  PRIMARY KEY  (pk),
  KEY rep_pk (rep_pk)
) TYPE=MyISAM AUTO_INCREMENT=94 ;


INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (1, 'Other', '~ Other (non-Member)', NULL, '', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (2, NULL, 'Albany Medical College', 131, 'educational', 131);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (3, NULL, 'Arizona State University', NULL, 'educational', 34);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (4, NULL, 'Australian National University', 199, 'educational', 199);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (5, NULL, 'Boston University School of Management', 31, 'educational', 31);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (6, NULL, 'Brown University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (7, NULL, 'Carleton College', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (8, NULL, 'Carnegie Foundation for the Advancement of Teaching', 168, 'educational', 168);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (9, NULL, 'Carnegie Mellon University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (10, NULL, 'Cerritos Community College', 94, 'educational', 94);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (11, NULL, 'Charles Sturt University', 175, 'educational', 175);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (12, NULL, 'Coast Community College District (Coastline Community College)', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (13, NULL, 'Columbia University', 196, 'educational', 196);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (14, NULL, 'Cornell University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (15, NULL, 'Dartmouth College', 194, 'educational', 194);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (16, NULL, 'Edgenics', 156, 'educational', 156);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (17, NULL, 'Florida Community College at Jacksonville', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (18, NULL, 'Foothill College', 117, 'educational', 117);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (19, NULL, 'Franklin University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (20, NULL, 'Georgetown University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (21, NULL, 'Harvard University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (22, NULL, 'Hosei University IT Research Center', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (23, NULL, 'Indiana University', 165, 'educational', 165);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (24, NULL, 'Johns Hopkins University', 115, 'educational', 115);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (25, NULL, 'Lancaster University', NULL, 'educational', 183);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (26, NULL, 'Loyola University, Chicago', 173, 'educational', 173);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (27, NULL, 'Luebeck University of Applied Sciences', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (28, NULL, 'Maricopa County Community College District', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (29, NULL, 'Marist College', 155, 'educational', 155);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (30, NULL, 'MIT', NULL, 'educational', 9);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (31, NULL, 'Monash University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (32, NULL, 'Nagoya University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (33, NULL, 'New York University', NULL, 'educational', 182);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (34, NULL, 'Northeastern University', NULL, 'educational', 174);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (35, NULL, 'North-West University (SA)', 179, 'educational', 178);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (36, NULL, 'Northwestern University', 141, 'educational', 141);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (37, NULL, 'Ohio State University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (38, NULL, 'Pennsylvania State University', 140, 'educational', 140);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (39, NULL, 'Portand State University', 164, 'educational', 164);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (40, NULL, 'Princeton University', 190, 'educational', 190);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (41, NULL, 'Rice University', 192, 'educational', 192);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (42, NULL, 'Ringling School of Art and Design', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (43, NULL, 'Roskilde University (Denmark)', 162, 'educational', 162);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (44, NULL, 'Rutgers University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (45, NULL, 'Simon Fraser University', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (46, NULL, 'Stanford University', 116, 'educational', 116);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (47, NULL, 'State University of New York System Administration', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (48, NULL, 'Stockholm University', 42, 'educational', 42);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (49, NULL, 'SURF/University of Amsterdam', NULL, 'educational', 181);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (50, NULL, 'Syracuse University', 153, 'educational', 153);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (51, NULL, 'Texas State University - San Marcos', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (52, NULL, 'Tufts University', 139, 'educational', 139);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (53, NULL, 'University College Dublin', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (54, NULL, 'Universidad Politecnica de Valencia (Spain)', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (55, NULL, 'Universitat de Lleida (Spain)', 161, 'educational', 161);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (56, NULL, 'University College Dublin', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (57, NULL, 'University of Arizona', 129, 'educational', 129);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (58, NULL, 'University of British Columbia', 169, 'educational', 169);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (59, NULL, 'California State University, Office of the Chancellor', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (60, 'Berkeley', 'University of California Berkeley', 58, 'educational', 58);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (61, NULL, 'University of California, Davis', 195, 'educational', 195);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (62, 'UCLA', 'University of California, Los Angeles', 10, 'educational', 10);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (63, NULL, 'University of California, Merced', 136, 'educational', 136);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (64, NULL, 'University of California, Santa Barbara', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (65, NULL, 'University of Cambridge, CARET', 43, 'educational', 43);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (66, NULL, 'University of Cape Town, SA', 13, 'educational', 13);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (67, NULL, 'University of Chicago', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (68, NULL, 'University of Colorado at Boulder', 189, 'educational', 189);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (69, NULL, 'University College Dublin', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (70, NULL, 'University of Delaware', NULL, 'educational', 197);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (71, NULL, 'University of Hawaii', 158, 'educational', 176);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (72, NULL, 'University of Hull', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (73, NULL, 'University of Illinois at Urbana-Champaign', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (74, NULL, 'University of Limerick', 185, 'educational', 185);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (75, NULL, 'University of Melbourne', 187, 'educational', 187);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (76, NULL, 'University of Michigan', 191, 'educational', 191);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (77, NULL, 'University of Minnesota', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (78, NULL, 'University of Missouri', 172, 'educational', 172);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (79, NULL, 'University of Nebraska', 166, 'educational', 166);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (80, NULL, 'University of North Texas', NULL, 'educational', 22);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (81, NULL, 'University of Oklahoma', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (82, NULL, 'University of South Africa (UNISA)', 180, 'educational', 180);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (83, NULL, 'University of Texas at Austin', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (84, NULL, 'University of Toronto, Knowledge Media Design Institute', 198, 'educational', 198);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (85, NULL, 'University of Virginia', 177, 'educational', 177);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (86, NULL, 'University of Washington', NULL, 'educational', 202);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (87, NULL, 'University of Wisconsin, Madison', NULL, 'educational', NULL);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (88, 'VT', 'Virginia Tech', 78, 'educational', 78);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (89, NULL, 'Weber State University', 36, 'educational', 36);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (90, NULL, 'Whitman College', NULL, 'educational', 20);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (91, NULL, 'Yale University', 146, 'educational', 146);
INSERT INTO institution (pk, abbr, name, rep_pk, type, repvote_pk) VALUES (93, 'Rsmart', 'The rSmart Group', 163, 'commercial', 163);
