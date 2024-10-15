CREATE DATABASE IF NOT EXISTS pms;
USE pms;

-- Teachers table
CREATE TABLE IF NOT EXISTS teachers (
    teacherid INT AUTO_INCREMENT,
    userName VARCHAR(50) NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phoneNumber VARCHAR(20) NOT NULL,
    PRIMARY KEY(teacherid)
);

INSERT INTO teachers (userName, firstName, surname, email, password, phoneNumber)
VALUES ("Chishala", "Backstone", "Chishala", "backstonekchishala@gmail.com", "$2y$10$b7WaCcTUbUWLyjMRLkPSrOoVskmtQfzw6/Jjf5/LAXx.nJ9glvkPC", '0769643348');

-- Admins table
CREATE TABLE IF NOT EXISTS admin (
    adminid INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    firstName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    phoneNumber VARCHAR(15) NOT NULL
);

INSERT INTO admin (userName, password, email, firstName, surname, phoneNumber)
VALUES ("Chishala", "$2y$10$P.NBTPubXW4CTZMGxxmjX.smNEex5SAX3OA4HPumzXW1LX7N5PlYS", "backstonechishala2@gmail.com", "Backstone", "Chishala", '0776432991');

-- Pupils table with default password and examination number as unique identifier
CREATE TABLE IF NOT EXISTS pupils (
    pupilid INT AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    dateOfBirth DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    grade VARCHAR(10) NOT NULL,
    class VARCHAR(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    guardianContact VARCHAR(50) NOT NULL,
    examination_number VARCHAR(11) NOT NULL UNIQUE, -- Added examination_number field
    PRIMARY KEY(pupilid)
);
INSERT INTO pupils(pupilid, username, password, firstName, surname, dateOfBirth, gender, grade, class, adress, guardianContact, examination_number)
VALUES ("Reuben","$2y$10$orii.F6eJ.cw518WrbeQWOAurfgwKeWiAbi.ezMBKXTCKZIcsSjuS", "Reuben", "Lingoshi", "2002-12-15", "male","grade10", "classA", "lusaka", "+260776432991", "2422100001";)

-- Parent table to manage parent information
CREATE TABLE IF NOT EXISTS parents (
    parentid INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phoneNumber VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO parents (firstName, surname, email, phoneNumber, password)
VALUES ("Reuben", "Lingoshi", "lingoshir04@gmail.com", "0779665104", "$2y$10$CBz08Vs9GeZNBg4MQOYTmuj.scJBXwsVxRMS3xgVrnXY8lsunC0U6");

-- Pupil_Parent table to link pupils with their parents
CREATE TABLE IF NOT EXISTS pupil_parent (
    pupilid INT NOT NULL,
    parentid INT NOT NULL,
    FOREIGN KEY (pupilid) REFERENCES pupils(pupilid),
    FOREIGN KEY (parentid) REFERENCES parents(parentid),
    PRIMARY KEY (pupilid, parentid)
);

-- Subjects table to store subject names
CREATE TABLE IF NOT EXISTS subjects (
    subjectid INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(50) NOT NULL UNIQUE
);

-- Insert predefined subjects into the subjects table
INSERT INTO subjects (subject_name)
VALUES 
    ('Mathematics'),
    ('English'),
    ('Science'),
    ('Computer Studies'),
    ('Civic Education'),
    ('Literature'),
    ('Religious Education');

-- Results table to store pupil grades
CREATE TABLE IF NOT EXISTS results (
    resultid INT AUTO_INCREMENT PRIMARY KEY,
    pupilid INT NOT NULL,
    subjectid INT NOT NULL,
    grade VARCHAR(5) NOT NULL,
    date DATE NOT NULL,
    class VARCHAR(10) NOT NULL, -- Added class field
    teacherid INT NOT NULL,
    FOREIGN KEY (pupilid) REFERENCES pupils(pupilid),
    FOREIGN KEY (subjectid) REFERENCES subjects(subjectid),
    FOREIGN KEY (teacherid) REFERENCES teachers(teacherid)
);

-- Classes table to store class information
CREATE TABLE IF NOT EXISTS classes (
    classid INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL,
    teacher_id INT NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacherid)
);
