-- Prison Management System Database
-- Enhanced version with realistic data and better content

CREATE DATABASE IF NOT EXISTS prisondb;
USE prisondb;

-- Drop existing tables if they exist (for clean setup)
DROP TABLE IF EXISTS Visit;
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Commits;
DROP TABLE IF EXISTS Crime;
DROP TABLE IF EXISTS Prisoner;
DROP TABLE IF EXISTS Section;
DROP TABLE IF EXISTS Officer_phone;
DROP TABLE IF EXISTS Officer;
DROP TABLE IF EXISTS Jailor_phone;
DROP TABLE IF EXISTS Deleted_jailors;
DROP TABLE IF EXISTS Jailor;
DROP TABLE IF EXISTS Admin;

-- Admin table
CREATE TABLE Admin(
    Admin_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Admin_uname tinytext NOT NULL,
    Admin_pwd longtext NOT NULL,
    First_name varchar(25) NOT NULL,
    Last_name varchar(25) NOT NULL,
    Email varchar(100),
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Jailor table
CREATE TABLE Jailor(
    Jailor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Jailor_uname tinytext NOT NULL,
    Jailor_pwd longtext NOT NULL,
    First_name varchar(25) NOT NULL,
    Last_name varchar(25) NOT NULL,
    Email varchar(100),
    Date_of_birth date,
    Hire_date date,
    Status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Jailor phone numbers
CREATE TABLE Jailor_phone(
    Jailor_phone varchar(15) NOT NULL,
    Jailor_id int(11) NOT NULL,
    Phone_type ENUM('Primary', 'Secondary', 'Emergency') DEFAULT 'Primary'
);

-- Deleted jailors archive
CREATE TABLE Deleted_jailors(
    Jailor_id int(11) NOT NULL PRIMARY KEY,
    Jailor_uname tinytext NOT NULL,
    Jailor_pwd longtext NOT NULL,
    First_name varchar(25) NOT NULL,
    Last_name varchar(25) NOT NULL,
    Deleted_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Reason_for_deletion text
);

-- Officer table
CREATE TABLE Officer(
    Officer_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Officer_uname tinytext NOT NULL,
    Officer_pwd longtext NOT NULL,
    First_name varchar(25) NOT NULL,
    Last_name varchar(25) NOT NULL,
    Title varchar(50) NOT NULL,
    Date_of_birth date NOT NULL,
    Email varchar(100),
    Hire_date date,
    Department varchar(50),
    Status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Officer phone numbers
CREATE TABLE Officer_phone(
    Officer_phone varchar(15) NOT NULL,
    Officer_id int(11) NOT NULL,
    Phone_type ENUM('Primary', 'Secondary', 'Emergency') DEFAULT 'Primary'
);

-- Prison sections
CREATE TABLE Section (
    Section_id int(3) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Section_name varchar(25) NOT NULL,
    Capacity int(3) DEFAULT 50,
    Current_population int(3) DEFAULT 0,
    Security_level ENUM('Minimum', 'Medium', 'Maximum', 'Super Maximum') DEFAULT 'Medium',
    Jailor_id int(11) NOT NULL,
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Prisoner table
CREATE TABLE Prisoner(
    Prisoner_id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    First_name varchar(25) NOT NULL,
    Last_name varchar(25) NOT NULL,
    Date_in date NOT NULL,
    Dob date NOT NULL,
    Height int(3) NOT NULL,
    Weight int(3),
    Date_out date,
    Address longtext NOT NULL,
    Section_id int(3) NOT NULL,
    Status_inout ENUM('in', 'out', 'transferred', 'released', 'escaped') DEFAULT 'in',
    Crime_category ENUM('Violent', 'Non-Violent', 'Drug-Related', 'White-Collar', 'Sexual') DEFAULT 'Non-Violent',
    Risk_level ENUM('Low', 'Medium', 'High', 'Maximum') DEFAULT 'Medium',
    Medical_conditions text,
    Emergency_contact varchar(100),
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crime definitions (IPC - Indian Penal Code)
CREATE TABLE Crime(
    IPC int(11) PRIMARY KEY NOT NULL,
    Description longtext NOT NULL,
    Category ENUM('Violent', 'Non-Violent', 'Drug-Related', 'White-Collar', 'Sexual', 'Property', 'Cyber') DEFAULT 'Non-Violent',
    Severity ENUM('Minor', 'Major', 'Serious', 'Very Serious') DEFAULT 'Major'
);

-- Prisoner-Crime relationship
CREATE TABLE Commits (
    IPC int(11) NOT NULL,
    Prisoner_id int(11) NOT NULL,
    Conviction_date date,
    Sentence_length_months int(11),
    Fine_amount decimal(10,2),
    PRIMARY KEY (IPC, Prisoner_id)
);

-- Visitor table
CREATE TABLE Visitor(
    Aadhaar varchar(12) PRIMARY KEY NOT NULL,
    First_name varchar(25) NOT NULL,
    Last_name varchar(25) NOT NULL,
    Phone varchar(15),
    Email varchar(100),
    Relationship_with_prisoner varchar(50),
    Address text,
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Visit scheduling
CREATE TABLE Visit(
    Visit_id int(11) AUTO_INCREMENT PRIMARY KEY,
    Visitor_aadhaar varchar(12) NOT NULL,
    Date_visit DATE NOT NULL,
    Time_slot varchar(25) NOT NULL,
    Prisoner_id int(11) NOT NULL,
    Status ENUM('Scheduled', 'Completed', 'Cancelled', 'No-Show') DEFAULT 'Scheduled',
    Notes text,
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Foreign Key Constraints
ALTER TABLE Commits ADD CONSTRAINT fk_commits_crime FOREIGN KEY (IPC) REFERENCES Crime(IPC) ON DELETE CASCADE;
ALTER TABLE Commits ADD CONSTRAINT fk_commits_prisoner FOREIGN KEY (Prisoner_id) REFERENCES Prisoner(Prisoner_id) ON DELETE CASCADE;
ALTER TABLE Prisoner ADD CONSTRAINT fk_prisoner_section FOREIGN KEY (Section_id) REFERENCES Section(Section_id);
ALTER TABLE Section ADD CONSTRAINT fk_section_jailor FOREIGN KEY (Jailor_id) REFERENCES Jailor(Jailor_id) ON DELETE CASCADE;
ALTER TABLE Officer_phone ADD CONSTRAINT fk_officer_phone FOREIGN KEY (Officer_id) REFERENCES Officer(Officer_id) ON DELETE CASCADE;
ALTER TABLE Jailor_phone ADD CONSTRAINT fk_jailor_phone FOREIGN KEY (Jailor_id) REFERENCES Jailor(Jailor_id) ON DELETE CASCADE;
ALTER TABLE Visit ADD CONSTRAINT fk_visit_prisoner FOREIGN KEY (Prisoner_id) REFERENCES Prisoner(Prisoner_id) ON DELETE CASCADE;
ALTER TABLE Visit ADD CONSTRAINT fk_visit_visitor FOREIGN KEY (Visitor_aadhaar) REFERENCES Visitor(Aadhaar) ON DELETE CASCADE;

-- Indexes for better performance
CREATE UNIQUE INDEX VISITOR_DUPL_INDEX ON Visit (Date_visit, Time_slot, Visitor_aadhaar);
CREATE UNIQUE INDEX PRISONER_DUPL_INDEX ON Visit (Date_visit, Time_slot, Prisoner_id);
CREATE UNIQUE INDEX PRISONER_ONE_DAY_LIMIT ON Visit (Date_visit, Prisoner_id);
CREATE UNIQUE INDEX VISITOR_ONE_DAY_LIMIT ON Visit (Date_visit, Visitor_aadhaar);
CREATE INDEX idx_prisoner_status ON Prisoner(Status_inout);
CREATE INDEX idx_prisoner_section ON Prisoner(Section_id);
CREATE INDEX idx_crime_category ON Crime(Category);

-- Insert Admin (keeping same credentials for easy login)
INSERT INTO Admin (Admin_id, Admin_uname, Admin_pwd, First_name, Last_name, Email) 
VALUES (1, 'admin', 'password', 'Tuhin', 'Chakrabarty', 'admin@prison.gov.in');

-- Insert Officers (keeping same usernames/passwords)
INSERT INTO Officer(Officer_id, Officer_uname, Officer_pwd, First_name, Last_name, Title, Date_of_birth, Email, Hire_date, Department) 
VALUES 
(1, 'officer1', 'officer1', 'Shaun', 'Brown', 'Senior Inspector', '1960-01-12', 'shaun.brown@prison.gov.in', '2010-03-15', 'Security'),
(2, 'officer2', 'officer2', 'Michael', 'Johnson', 'Inspector', '1975-06-22', 'michael.johnson@prison.gov.in', '2015-08-10', 'Investigation'),
(3, 'officer3', 'officer3', 'David', 'Williams', 'Deputy Inspector', '1982-11-08', 'david.williams@prison.gov.in', '2018-01-20', 'Administration'),
(4, 'officer4', 'officer4', 'Robert', 'Davis', 'Inspector', '1978-04-30', 'robert.davis@prison.gov.in', '2012-09-05', 'Security'),
(5, 'officer5', 'officer5', 'James', 'Miller', 'Senior Officer', '1985-12-14', 'james.miller@prison.gov.in', '2019-06-12', 'Medical');

INSERT INTO Officer_phone (Officer_phone, Officer_id, Phone_type) VALUES
('9988776655', 1, 'Primary'),
('9876543210', 2, 'Primary'),
('8765432109', 3, 'Primary'),
('7654321098', 4, 'Primary'),
('6543210987', 5, 'Primary');

-- Insert Jailors (keeping same usernames/passwords)
INSERT INTO Jailor(Jailor_id, Jailor_uname, Jailor_pwd, First_name, Last_name, Email, Date_of_birth, Hire_date) 
VALUES 
(1, 'jailor1', 'jailor1', 'Steve', 'Quay', 'steve.quay@prison.gov.in', '1970-03-15', '2012-01-10'),
(2, 'jailor2', 'jailor2', 'Marcus', 'Quay', 'marcus.quay@prison.gov.in', '1972-07-22', '2013-05-20'),
(3, 'jailor3', 'jailor3', 'Jim', 'Smith', 'jim.smith@prison.gov.in', '1968-11-08', '2010-08-15'),
(4, 'jailor4', 'jailor4', 'Cory', 'Roy', 'cory.roy@prison.gov.in', '1975-04-30', '2015-03-12'),
(5, 'jailor5', 'jailor5', 'Rob', 'Cole', 'rob.cole@prison.gov.in', '1980-12-14', '2018-09-25');

INSERT INTO Jailor_phone(Jailor_phone, Jailor_id, Phone_type) VALUES
('8876171369', 1, 'Primary'),
('6559892327', 2, 'Primary'),
('3893906914', 3, 'Primary'),
('7473154442', 4, 'Primary'),
('8251538586', 5, 'Primary');

-- Insert Sections
INSERT INTO Section(Section_id, Section_name, Capacity, Current_population, Security_level, Jailor_id) VALUES 
('111', 'A - General Population', 60, 45, 'Medium', 1),
('222', 'B - High Security', 40, 38, 'Maximum', 2),
('333', 'C - Minimum Security', 80, 52, 'Minimum', 3),
('444', 'D - Medical Ward', 30, 12, 'Medium', 4),
('555', 'E - Solitary Confinement', 20, 8, 'Super Maximum', 5);

-- Insert Crimes (Enhanced IPC descriptions)
INSERT INTO Crime(IPC, Description, Category, Severity) VALUES
(1, 'Title and extent of operation of the Code.', 'Non-Violent', 'Minor'),
(3, 'Punishment of offences committed beyond but which by law may be tried within India.', 'Non-Violent', 'Major'),
(191, 'Giving false evidence.', 'White-Collar', 'Major'),
(300, 'Murder. When culpable homicide is not murder.', 'Violent', 'Very Serious'),
(302, 'Murder.', 'Violent', 'Very Serious'),
(304, 'Culpable homicide not amounting to murder.', 'Violent', 'Serious'),
(307, 'Attempt to murder.', 'Violent', 'Serious'),
(308, 'Attempt to commit culpable homicide.', 'Violent', 'Serious'),
(323, 'Voluntarily causing hurt.', 'Violent', 'Major'),
(324, 'Voluntarily causing hurt by dangerous weapons or means.', 'Violent', 'Major'),
(354, 'Assault or criminal force to woman with intent to outrage her modesty.', 'Sexual', 'Serious'),
(363, 'Kidnapping.', 'Violent', 'Serious'),
(366, 'Kidnapping, abducting or inducing woman to compel her marriage.', 'Violent', 'Serious'),
(376, 'Rape.', 'Sexual', 'Very Serious'),
(378, 'Theft.', 'Property', 'Major'),
(379, 'Theft in dwelling house.', 'Property', 'Major'),
(380, 'Theft in a building, tent or vessel.', 'Property', 'Major'),
(392, 'Robbery.', 'Violent', 'Serious'),
(395, 'Dacoity.', 'Violent', 'Serious'),
(415, 'Cheating.', 'White-Collar', 'Major'),
(420, 'Cheating and dishonestly inducing delivery of property.', 'White-Collar', 'Major'),
(426, 'Mischief.', 'Property', 'Minor'),
(435, 'Mischief by fire or explosive substance.', 'Property', 'Serious'),
(447, 'Criminal trespass.', 'Property', 'Minor'),
(448, 'House-trespass.', 'Property', 'Major'),
(454, 'Lurking house-trespass or house-breaking.', 'Property', 'Major'),
(457, 'Lurking house-trespass or house-breaking by night.', 'Property', 'Serious'),
(465, 'Forgery.', 'White-Collar', 'Major'),
(467, 'Forgery of valuable security, will, etc.', 'White-Collar', 'Serious'),
(468, 'Forgery for purpose of cheating.', 'White-Collar', 'Major'),
(471, 'Using as genuine a forged document.', 'White-Collar', 'Major'),
(489, 'Using as genuine, forged or counterfeit currency-notes or bank-notes.', 'White-Collar', 'Serious'),
(499, 'Defamation.', 'Non-Violent', 'Minor'),
(500, 'Punishment for defamation.', 'Non-Violent', 'Minor'),
(503, 'Criminal intimidation.', 'Non-Violent', 'Major'),
(506, 'Punishment for criminal intimidation.', 'Non-Violent', 'Major'),
(511, 'Punishment for attempting to commit offences punishable with imprisonment for life or other imprisonment.', 'Non-Violent', 'Major');

-- Insert Prisoners (Enhanced with realistic data)
INSERT INTO Prisoner(Prisoner_id, First_name, Last_name, Date_in, Dob, Height, Weight, Date_out, Address, Section_id, Status_inout, Crime_category, Risk_level, Medical_conditions, Emergency_contact) VALUES 
(1, 'Rajesh', 'Agarwal', '2021-05-10', '1993-09-20', 175, 70, '2024-07-20', '123 Main Street, Andheri West, Mumbai, Maharashtra', '111', 'in', 'White-Collar', 'Medium', 'Diabetes Type 2', 'Priya Agarwal - 9876543210'),
(2, 'Amit', 'Gupta', '2021-02-10', '2000-05-25', 180, 75, '2025-09-21', '456 Park Avenue, Connaught Place, Delhi', '222', 'in', 'Violent', 'High', 'Hypertension', 'Sunita Gupta - 8765432109'),
(3, 'Vikram', 'Pandey', '2021-05-07', '1995-05-27', 168, 65, '2027-03-18', '789 Lake Road, Bandra East, Mumbai, Maharashtra', '333', 'in', 'Drug-Related', 'Medium', 'None', 'Rekha Pandey - 7654321098'),
(4, 'Suresh', 'Kumar', '2022-01-15', '1988-12-03', 172, 68, '2026-06-15', '321 Gandhi Street, Koramangala, Bangalore, Karnataka', '111', 'in', 'Property', 'Low', 'Asthma', 'Lakshmi Kumar - 6543210987'),
(5, 'Ramesh', 'Singh', '2022-03-20', '1990-07-14', 178, 72, '2025-12-20', '654 Nehru Road, Salt Lake, Kolkata, West Bengal', '222', 'in', 'Violent', 'High', 'None', 'Geeta Singh - 5432109876'),
(6, 'Dinesh', 'Patel', '2022-06-10', '1985-11-28', 170, 66, '2024-11-10', '987 Tagore Lane, Banjara Hills, Hyderabad, Telangana', '333', 'in', 'Non-Violent', 'Low', 'None', 'Meera Patel - 4321098765'),
(7, 'Arun', 'Sharma', '2022-08-05', '1992-04-16', 175, 70, '2026-02-05', '147 Vivekananda Street, Anna Nagar, Chennai, Tamil Nadu', '444', 'in', 'White-Collar', 'Medium', 'Heart Condition', 'Anita Sharma - 3210987654'),
(8, 'Mohan', 'Verma', '2022-09-12', '1987-08-22', 173, 69, '2025-05-12', '258 Subhash Marg, Civil Lines, Lucknow, Uttar Pradesh', '555', 'in', 'Violent', 'Maximum', 'None', 'Kavita Verma - 2109876543'),
(9, 'Prakash', 'Yadav', '2022-11-30', '1994-01-09', 176, 71, '2026-08-30', '369 Ambedkar Road, MG Road, Pune, Maharashtra', '111', 'in', 'Property', 'Medium', 'None', 'Sita Yadav - 1098765432'),
(10, 'Sanjay', 'Joshi', '2023-01-25', '1989-06-18', 174, 67, '2025-10-25', '741 Indira Colony, Sector 15, Chandigarh', '222', 'in', 'Drug-Related', 'High', 'Hepatitis C', 'Rekha Joshi - 0987654321');

-- Insert Crime-Prisoner relationships
INSERT INTO Commits(IPC, Prisoner_id, Conviction_date, Sentence_length_months, Fine_amount) VALUES
(420, 1, '2021-05-10', 36, 50000.00),
(300, 2, '2021-02-10', 60, 100000.00),
(191, 2, '2021-02-10', 24, 25000.00),
(378, 3, '2021-05-07', 48, 75000.00),
(415, 4, '2022-01-15', 18, 30000.00),
(302, 5, '2022-03-20', 72, 150000.00),
(499, 6, '2022-06-10', 12, 10000.00),
(465, 7, '2022-08-05', 30, 45000.00),
(376, 8, '2022-09-12', 84, 200000.00),
(392, 9, '2022-11-30', 42, 80000.00),
(420, 10, '2023-01-25', 36, 60000.00);

-- Insert Visitors
INSERT INTO Visitor(Aadhaar, First_name, Last_name, Phone, Email, Relationship_with_prisoner, Address) VALUES 
('123456789123', 'Priya', 'Agarwal', '9876543210', 'priya.agarwal@email.com', 'Wife', '123 Main Street, Andheri West, Mumbai, Maharashtra'),
('234567890234', 'Sunita', 'Gupta', '8765432109', 'sunita.gupta@email.com', 'Mother', '456 Park Avenue, Connaught Place, Delhi'),
('345678901345', 'Rekha', 'Pandey', '7654321098', 'rekha.pandey@email.com', 'Sister', '789 Lake Road, Bandra East, Mumbai, Maharashtra'),
('456789012456', 'Lakshmi', 'Kumar', '6543210987', 'lakshmi.kumar@email.com', 'Wife', '321 Gandhi Street, Koramangala, Bangalore, Karnataka'),
('567890123567', 'Geeta', 'Singh', '5432109876', 'geeta.singh@email.com', 'Mother', '654 Nehru Road, Salt Lake, Kolkata, West Bengal'),
('678901234678', 'Meera', 'Patel', '4321098765', 'meera.patel@email.com', 'Wife', '987 Tagore Lane, Banjara Hills, Hyderabad, Telangana'),
('789012345789', 'Anita', 'Sharma', '3210987654', 'anita.sharma@email.com', 'Daughter', '147 Vivekananda Street, Anna Nagar, Chennai, Tamil Nadu'),
('890123456890', 'Kavita', 'Verma', '2109876543', 'kavita.verma@email.com', 'Wife', '258 Subhash Marg, Civil Lines, Lucknow, Uttar Pradesh'),
('901234567901', 'Sita', 'Yadav', '1098765432', 'sita.yadav@email.com', 'Mother', '369 Ambedkar Road, MG Road, Pune, Maharashtra'),
('012345678012', 'Rekha', 'Joshi', '0987654321', 'rekha.joshi@email.com', 'Sister', '741 Indira Colony, Sector 15, Chandigarh');

-- Insert Visits
INSERT INTO Visit(Visitor_aadhaar, Date_visit, Time_slot, Prisoner_id, Status, Notes) VALUES 
('123456789123', '2024-01-15', '10:00-11:00', 1, 'Completed', 'Regular family visit'),
('234567890234', '2024-01-16', '14:00-15:00', 2, 'Completed', 'Mother visited'),
('345678901345', '2024-01-17', '11:00-12:00', 3, 'Completed', 'Sister visit'),
('456789012456', '2024-01-18', '15:00-16:00', 4, 'Completed', 'Wife visit'),
('567890123567', '2024-01-19', '09:00-10:00', 5, 'Completed', 'Mother visit'),
('123456789123', '2024-02-01', '10:00-11:00', 1, 'Scheduled', 'Monthly visit'),
('234567890234', '2024-02-02', '14:00-15:00', 2, 'Scheduled', 'Monthly visit'),
('345678901345', '2024-02-03', '11:00-12:00', 3, 'Scheduled', 'Monthly visit'),
('456789012456', '2024-02-04', '15:00-16:00', 4, 'Scheduled', 'Monthly visit'),
('567890123567', '2024-02-05', '09:00-10:00', 5, 'Scheduled', 'Monthly visit');

-- Update section populations
UPDATE Section SET Current_population = (
    SELECT COUNT(*) FROM Prisoner WHERE Section_id = Section.Section_id AND Status_inout = 'in'
);

-- Insert a deleted jailor for testing
INSERT INTO Deleted_jailors(Jailor_id, Jailor_uname, Jailor_pwd, First_name, Last_name, Reason_for_deletion) 
VALUES (6, 'jailor6', 'jailor6', 'John', 'Doe', 'Retirement');

-- Create a view for dashboard statistics
CREATE OR REPLACE VIEW Dashboard_Stats AS
SELECT 
    (SELECT COUNT(*) FROM Prisoner WHERE Status_inout = 'in') as Total_Prisoners,
    (SELECT COUNT(*) FROM Jailor WHERE Status = 'Active') as Active_Jailors,
    (SELECT COUNT(*) FROM Officer WHERE Status = 'Active') as Active_Officers,
    (SELECT COUNT(*) FROM Section) as Total_Sections,
    (SELECT COUNT(*) FROM Visit WHERE Date_visit = CURDATE()) as Today_Visits,
    (SELECT COUNT(*) FROM Prisoner WHERE Status_inout = 'in' AND Crime_category = 'Violent') as Violent_Criminals,
    (SELECT COUNT(*) FROM Prisoner WHERE Status_inout = 'in' AND Risk_level = 'High') as High_Risk_Prisoners;

-- Create a view for section overview
CREATE OR REPLACE VIEW Section_Overview AS
SELECT 
    s.Section_id,
    s.Section_name,
    s.Capacity,
    s.Current_population,
    s.Security_level,
    CONCAT(j.First_name, ' ', j.Last_name) as Jailor_Name,
    jp.Jailor_phone,
    ROUND((s.Current_population / s.Capacity) * 100, 2) as Occupancy_Percentage
FROM Section s
JOIN Jailor j ON s.Jailor_id = j.Jailor_id
JOIN Jailor_phone jp ON j.Jailor_id = jp.Jailor_id
WHERE jp.Phone_type = 'Primary';

-- Create a view for prisoner details with crimes
CREATE OR REPLACE VIEW Prisoner_Details AS
SELECT 
    p.Prisoner_id,
    CONCAT(p.First_name, ' ', p.Last_name) as Full_Name,
    p.Date_in,
    p.Date_out,
    p.Status_inout,
    p.Crime_category,
    p.Risk_level,
    s.Section_name,
    CONCAT(j.First_name, ' ', j.Last_name) as Jailor_Name,
    GROUP_CONCAT(c.Description SEPARATOR ', ') as Crimes,
    DATEDIFF(p.Date_out, CURDATE()) as Days_Remaining
FROM Prisoner p
JOIN Section s ON p.Section_id = s.Section_id
JOIN Jailor j ON s.Jailor_id = j.Jailor_id
LEFT JOIN Commits cm ON p.Prisoner_id = cm.Prisoner_id
LEFT JOIN Crime c ON cm.IPC = c.IPC
WHERE p.Status_inout = 'in'
GROUP BY p.Prisoner_id;

-- Create a view for visit schedule
CREATE OR REPLACE VIEW Visit_Schedule AS
SELECT 
    v.Visit_id,
    v.Date_visit,
    v.Time_slot,
    v.Status,
    CONCAT(vis.First_name, ' ', vis.Last_name) as Visitor_Name,
    vis.Phone as Visitor_Phone,
    vis.Relationship_with_prisoner,
    CONCAT(p.First_name, ' ', p.Last_name) as Prisoner_Name,
    s.Section_name
FROM Visit v
JOIN Visitor vis ON v.Visitor_aadhaar = vis.Aadhaar
JOIN Prisoner p ON v.Prisoner_id = p.Prisoner_id
JOIN Section s ON p.Section_id = s.Section_id
ORDER BY v.Date_visit, v.Time_slot;

