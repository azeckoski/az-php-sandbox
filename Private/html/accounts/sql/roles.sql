CREATE TABLE roles ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role_name           varchar(100) NOT NULL,
    role_order          int(6) NOT NULL,
    color				varchar(6),
    PRIMARY KEY (pk)
);

INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(1, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Developer/Programmer', 1, 'ff0000');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(2, '2006-04-15 15:24:42.0', '2006-03-24 14:25:02.0', 'UI/Interaction Designer', 2, 'ff6666');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(3, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'User Support', 3, '00ff00');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(4, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Faculty', 4, 'ff00ff');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(5, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Faculty Development', 5, 'ff66ff');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(6, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Librarian', 6, '6666ff');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(7, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Implementor', 7, '66ff66');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(8, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Instructional Designer', 8, '00ffff');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(9, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Instructional Technologist', 9, '66ffff');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(10, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Manager', 10, 'ffff00');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(11, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'System Administrator', 11, '0000ff');
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order, color)
  VALUES(12, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'University Administration', 12, 'ffff66');