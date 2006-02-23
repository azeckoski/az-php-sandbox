
CREATE TABLE users ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    username    	varchar(100) NOT NULL UNIQUE,
    password    	varchar(255) NOT NULL,
    firstname   	varchar(100) NULL,
    lastname    	varchar(100) NULL,
    email       	varchar(100) NOT NULL UNIQUE,
    access      	varchar(100) NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    activated   	enum('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(pk)
)

/* only needed if you're working with an older version of the users table */
alter table users add column institution_pk int(10) null;

insert into users (username, password, email) values ('aaronz',PASSWORD('password1'),'aaronz@vt.edu');
insert into users (username, password, email) values ('shardin',PASSWORD('password2'),'shardin@umich.edu');

CREATE TABLE sessions ( 
    pk          	int(10) AUTO_INCREMENT NOT NULL,
    users_pk    	int(10) NOT NULL DEFAULT '0',
    passkey     	varchar(100) NOT NULL,
    date_created	timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(pk),
    FOREIGN KEY (users_pk) REFERENCES users(pk)
);

create table institution (
    pk			int(10) auto_increment not null,
    abbr		varchar(25) null,
    name		varchar(255) not null,
    rep_pk		int(1) null,
    primary key(pk),
    foreign key (rep_pk) references users(pk)
  );
  
insert into institution (name) values ('Albany Medical College');
insert into institution (name) values ('Arizona State University');
insert into institution (name) values ('Australian National University');
insert into institution (name) values ('Boston University School of Management');
insert into institution (name) values ('Brown University');
insert into institution (name) values ('Carleton College');
insert into institution (name) values ('Carnegie Foundation for the Advancement of Teaching');
insert into institution (name) values ('Carnegie Mellon University');
insert into institution (name) values ('Cerritos Community College');
insert into institution (name) values ('Charles Sturt University');
insert into institution (name) values ('Coast Community College District (Coastline Community College)');
insert into institution (name) values ('Columbia University');
insert into institution (name) values ('Cornell University');
insert into institution (name) values ('Dartmouth College');
insert into institution (name) values ('Edgenics');
insert into institution (name) values ('Florida Community College at Jacksonville');
insert into institution (name) values ('Foothill College');
insert into institution (name) values ('Franklin University');
insert into institution (name) values ('Georgetown University');
insert into institution (name) values ('Harvard University');
insert into institution (name) values ('Hosei University IT Research Center');
insert into institution (name) values ('Indiana University');
insert into institution (name) values ('Johns Hopkins University');
insert into institution (name) values ('Lancaster University');
insert into institution (name) values ('Loyola University, Chicago');
insert into institution (name) values ('Luebeck University of Applied Sciences');
insert into institution (name) values ('Maricopa County Community College District');
insert into institution (name) values ('Marist College');
insert into institution (name) values ('MIT');
insert into institution (name) values ('Monash University');
insert into institution (name) values ('Nagoya University');
insert into institution (name) values ('New York University');
insert into institution (name) values ('Northeastern University');
insert into institution (name) values ('North-West University (SA)');
insert into institution (name) values ('Northwestern University');
insert into institution (name) values ('Ohio State University');
insert into institution (name) values ('Pennsylvania State University');
insert into institution (name) values ('Portand State University');
insert into institution (name) values ('Princeton University');
insert into institution (name) values ('Rice University');
insert into institution (name) values ('Ringling School of Art and Design');
insert into institution (name) values ('Roskilde University (Denmark)');
insert into institution (name) values ('Rutgers University');
insert into institution (name) values ('Simon Fraser University');
insert into institution (name) values ('Stanford University');
insert into institution (name) values ('State University of New York System Administration');
insert into institution (name) values ('Stockholm University');
insert into institution (name) values ('SURF/University of Amsterdam');
insert into institution (name) values ('Syracuse University');
insert into institution (name) values ('Texas State University - San Marcos');
insert into institution (name) values ('Tufts University');
insert into institution (name) values ('University College Dublin');
insert into institution (name) values ('Universidad Politecnica de Valencia (Spain)');
insert into institution (name) values ('Universitat de Lleida (Spain)');
insert into institution (name) values ('University College Dublin');
insert into institution (name) values ('University of Arizona');
insert into institution (name) values ('University of British Columbia');
insert into institution (name) values ('University of California, Office of the Chancellor');
insert into institution (name) values ('University of California Berkeley');
insert into institution (name) values ('University of California, Davis');
insert into institution (name) values ('University of California, Los Angeles');
insert into institution (name) values ('University of California, Merced');
insert into institution (name) values ('University of California, Santa Barbara');
insert into institution (name) values ('University of Cambridge, CARET');
insert into institution (name) values ('University of Cape Town, SA');
insert into institution (name) values ('University of Chicago');
insert into institution (name) values ('University of Colorado at Boulder');
insert into institution (name) values ('University College Dublin');
insert into institution (name) values ('University of Delaware');
insert into institution (name) values ('University of Hawaii');
insert into institution (name) values ('University of Hull');
insert into institution (name) values ('University of Illinois at Urbana-Champaign');
insert into institution (name) values ('University of Limerick');
insert into institution (name) values ('University of Melbourne');
insert into institution (name) values ('University of Michigan');
insert into institution (name) values ('University of Minnesota');
insert into institution (name) values ('University of Missouri');
insert into institution (name) values ('University of Nebraska');
insert into institution (name) values ('University of North Texas');
insert into institution (name) values ('University of Oklahoma');
insert into institution (name) values ('University of South Africa (UNISA)');
insert into institution (name) values ('University of Texas at Austin');
insert into institution (name) values ('University of Toronto, Knowledge Media Design Institute');
insert into institution (name) values ('University of Virginia');
insert into institution (name) values ('University of Washington');
insert into institution (name) values ('University of Wisconsin, Madison');
insert into institution (name) values ('Virginia Tech');
insert into institution (name) values ('Weber State University');
insert into institution (name) values ('Whitman College');
insert into institution (name) values ('Yale University');
insert into institution (name) values ('Other');  