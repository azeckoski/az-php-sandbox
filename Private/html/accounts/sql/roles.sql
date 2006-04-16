CREATE TABLE roles ( 
    pk          		int(10) AUTO_INCREMENT NOT NULL,
    date_created		timestamp NULL default '0000-00-00 00:00:00',
    date_modified		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role_name           varchar(100) NOT NULL,
    role_order          int(6) NOT NULL,
    PRIMARY KEY (pk)
);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(1, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Developer/Programmer', 1);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(2, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'UI/Interaction Designer', 2);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(3, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'User Support', 3);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(4, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Faculty', 4);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(5, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Faculty Development', 5);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(6, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Librarian', 6);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(7, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Implementor', 7);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(8, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Instructional Designer', 8);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(9, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Instructional Technologist', 9);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(10, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'Manager', 10);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(11, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'System Administrator', 11);
INSERT INTO roles(pk, date_created, date_modified, role_name, role_order)
  VALUES(12, '2006-03-24 14:25:02.0', '2006-03-24 14:25:02.0', 'University Administration', 12);
