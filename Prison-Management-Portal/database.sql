CREATE DATABASE prisondb;

use prisondb;

CREATE TABLE Admin(
	Admin_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    Admin_uname tinytext not null,
    Admin_pwd longtext not null,
    First_name varchar(25) not null,
    Last_name varchar(25) not null
);
CREATE TABLE Jailor(
	Jailor_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    Jailor_uname tinytext not null,
    Jailor_pwd longtext not null,
    First_name varchar(25) not null,
    Last_name varchar(25) not null
);

CREATE TABLE Jailor_phone(
	Jailor_phone varchar(10) not null,
    Jailor_id int(11) not null
);

CREATE TABLE Deleted_jailors(
	Jailor_id int(11) not null PRIMARY KEY,
    Jailor_uname tinytext not null,
    Jailor_pwd longtext not null,
    First_name varchar(25) not null,
    Last_name varchar(25) not null
);
CREATE TABLE Officer(
	Officer_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    Officer_uname tinytext not null,
    Officer_pwd longtext not null,
    First_name varchar(25) not null,
    Last_name varchar(25) not null,
    Title varchar(25) not null,
    Date_of_birth date not null
);
CREATE TABLE Officer_phone(
	Officer_phone varchar(10) not null,
    Officer_id int(11)  not null    
);
CREATE TABLE Prisoner(
	Prisoner_id int(11) AUTO_INCREMENT not null primary key,
    First_name varchar(25) not null,
    Last_name varchar(25) not null,
    Date_in date not null,
    Dob date not null,
    Height int(3) not null,
    Date_out date not null,
    Address longtext not null,
    Section_id int(3) not null,
    Status_inout varchar(3) not null
);

CREATE TABLE Section (
	Section_id int(3) AUTO_INCREMENT not null PRIMARY KEY,
    Section_name varchar(25) not null,
    Jailor_id int(11) not null
);
CREATE TABLE Crime(
	IPC int(11) PRIMARY KEY not null,
    Description longtext
);
CREATE TABLE Commits (
	IPC int(11) NOT NULL,
    Prisoner_id int(11) NOT NULL
);
CREATE TABLE Visitor(
    	Aadhaar varchar(12) PRIMARY KEY not null,
	First_name varchar(25) not null,
    	Last_name varchar(25) not null
);
CREATE TABLE Visit(
	Visitor_aadhaar varchar(12) not null,
	Date_visit DATE not null,
	Time_slot varchar(25) not null,
	Prisoner_id int(11) not null,
	CONSTRAINT `fk_prisoner` FOREIGN KEY (Prisoner_id) REFERENCES Prisoner (Prisoner_id),
	CONSTRAINT `fk_visitor` FOREIGN KEY (Visitor_aadhaar) REFERENCES Visitor (Aadhaar)
);

ALTER TABLE Commits ADD CONSTRAINT fk_1 FOREIGN KEY (IPC) REFERENCES Crime(IPC);

ALTER TABLE Commits ADD CONSTRAINT fk_2 FOREIGN KEY (Prisoner_id) REFERENCES Prisoner(Prisoner_id);
ALTER TABLE Prisoner ADD CONSTRAINT fk_3 FOREIGN KEY (Section_id) REFERENCES Section(Section_id);

ALTER TABLE Section ADD CONSTRAINT fk_4 FOREIGN KEY (Jailor_id) REFERENCES Jailor(Jailor_id) ON DELETE CASCADE;

ALTER TABLE Visitor ADD CONSTRAINT fk_5 FOREIGN KEY (Prisoner_id) REFERENCES Prisoner(Prisoner_id);
ALTER TABLE Officer_phone ADD CONSTRAINT fk_6 FOREIGN KEY (Officer_id) REFERENCES Officer(Officer_id);

ALTER TABLE Jailor_phone ADD CONSTRAINT fk_7 FOREIGN KEY (Jailor_id) REFERENCES Jailor(Jailor_id) ON DELETE CASCADE;
ALTER TABLE Commits ADD CONSTRAINT mul_pk PRIMARY KEY (IPC,Prisoner_id);

CREATE UNIQUE INDEX VISITOR_DUPL_INDEX ON Visit (Date_visit,Time_slot,Visitor_aadhaar);
CREATE UNIQUE INDEX PRISONER_DUPL_INDEX ON Visit (Date_visit,Time_slot,Prisoner_id);
CREATE UNIQUE INDEX PRISONER_ONE_DAY_LIMIT ON Visit (Date_visit,Prisoner_id);
CREATE UNIQUE INDEX VISITOR_ONE_DAY_LIMIT ON Visit (Date_visit,Visitor_aadhaar);

INSERT INTO Admin (Admin_id, Admin_uname, Admin_pwd, First_name, Last_name) VALUES (1,'admin','password','Manasvi','Alimchandani');

INSERT INTO Officer(Officer_uname,Officer_pwd,First_name,Last_name,Title,Date_of_birth) VALUES ('officer1','officer1','Shaun','Brown','Inspector','1960-01-12');
INSERT INTO Officer_phone (Officer_phone,Officer_id) VALUES(9988776655,1);

INSERT INTO Jailor(Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES ('jailor1','jailor1','Steve','Quay');
INSERT INTO Section(Section_id,Section_name,Jailor_id) VALUES ('111','A',1);
INSERT INTO Jailor_phone(Jailor_phone,Jailor_id) VALUES(8876171369,1);

INSERT INTO Jailor(Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES ('jailor2','jailor2','Marcus','Quay');
INSERT INTO Section(Section_id,Section_name,Jailor_id) VALUES ('222','B',2);
INSERT INTO Jailor_phone(Jailor_phone,Jailor_id) VALUES(6559892327,2);

INSERT INTO Jailor(Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES ('jailor3','jailor3','Jim','Smith');
INSERT INTO Section(Section_id,Section_name,Jailor_id) VALUES ('333','C',3);
INSERT INTO Jailor_phone(Jailor_phone,Jailor_id) VALUES(3893906914,3);

INSERT INTO Jailor(Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES ('jailor4','jailor4','Cory','Roy');
INSERT INTO Section(Section_id,Section_name,Jailor_id) VALUES ('444','D',4);
INSERT INTO Jailor_phone(Jailor_phone,Jailor_id) VALUES(7473154442,4);

INSERT INTO Jailor(Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES ('jailor5','jailor5','Rob','Cole');
INSERT INTO Section(Section_id,Section_name,Jailor_id) VALUES ('555','E',5);
INSERT INTO Jailor_phone(Jailor_phone,Jailor_id) VALUES(8251538586,5);

INSERT INTO Crime(IPC,Description) VALUES(1,'Title and extent of operation of the Code.');
INSERT INTO Crime(IPC,Description) VALUES(3,'Punishment of offences committed beyond but which by law may be tried within India.');
INSERT INTO Crime(IPC,Description) VALUES(191,'Giving false evidence.');
INSERT INTO Crime(IPC,Description) VALUES(300,'Murder. When culpable homicide is not murder.');
INSERT INTO Crime(IPC,Description) VALUES(378,'Theft.');
INSERT INTO Crime(IPC,Description) VALUES(415,'Cheating.');


INSERT INTO Prisoner(Prisoner_id, First_name, Last_name, Date_in, Dob, Height, Date_out, Address, Section_id, Status_inout) VALUES (1,'Rahul','Agarwal','2021-05-10','1993-09-20','190','2021-07-20','Street1,Mumbai,India','111','in');
INSERT INTO Prisoner(Prisoner_id, First_name, Last_name, Date_in, Dob, Height, Date_out, Address, Section_id, Status_inout) VALUES (2,'Saksham','Gupta','2021-02-10','2000-05-25','200','2022-09-21','Street1,Delhi,India','222','in');
INSERT INTO Prisoner(Prisoner_id, First_name, Last_name, Date_in, Dob, Height, Date_out, Address, Section_id, Status_inout) VALUES (3,'Piyush','Pandey','2021-05-07','1995-05-27','210','2027-03-18','Street5,Delhi,India','333','in');

INSERT INTO Commits(IPC,Prisoner_id) VALUES(1,1);
INSERT INTO Commits(IPC,Prisoner_id) VALUES(300,1);
INSERT INTO Commits(IPC,Prisoner_id) VALUES(191,2);
INSERT INTO Commits(IPC,Prisoner_id) VALUES(3,3);
INSERT INTO Commits(IPC,Prisoner_id) VALUES(415,3);

INSERT INTO Visitor(Aadhaar, First_name, Last_name) VALUES (123456789123,'Vaibhav','Chopra');
INSERT INTO Visit(Visitor_aadhaar, Date_visit, Time_slot, Prisoner_id) VALUES (123456789123,'2021-06-07','10AM-11AM',1);

INSERT INTO Deleted_jailors(Jailor_id,Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES (1,'jailor1','jailor1','Steve','Quay');

