CREATE DATABASE soap_case_sys;

USE soap_case_sys;

-- user's table
CREATE TABLE users (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(16) NOT NULL
);

INSERT INTO users (username, password) 
VALUES ('admin', '4dm!nC4$3');

-- Select * from users;

-- Patients Table
CREATE TABLE Patients (
    Patient_ID INT AUTO_INCREMENT PRIMARY KEY,
    Patient_Number VARCHAR(50) UNIQUE NOT NULL,
    First_Name VARCHAR(100) NOT NULL,
    Last_Name VARCHAR(100) NOT NULL,
    Age INT(3) NOT NULL,
    Date_of_Birth DATE NOT NULL,
    Contact_Number VARCHAR(15),
    Address TEXT,
    Email VARCHAR(50) NOT NULL,
    Gender ENUM('Male', 'Female', 'Other') NOT NULL
);

-- SOAP Cases Table
CREATE TABLE Patient_Cases (
    Case_ID INT AUTO_INCREMENT PRIMARY KEY,
    Case_Number VARCHAR(50) UNIQUE NOT NULL,
    Patient_Number VARCHAR(50) NOT NULL,
    Diagnosis TEXT NOT NULL,
    Symptoms TEXT NOT NULL,
    Treatment_Plan TEXT,
    Case_Status ENUM('Open', 'In Progress', 'Closed') DEFAULT 'Open',
    Admission_Date DATE NOT NULL,
    Discharge_Date DATE,
    FOREIGN KEY (Patient_Number) REFERENCES Patients(Patient_Number) ON DELETE CASCADE
);

-- Appointments Table
CREATE TABLE Appointments (
    Appointment_ID INT AUTO_INCREMENT PRIMARY KEY,
    Patient_ID INT NOT NULL,
    Appointment_Date DATE NOT NULL,
    Appointment_Time TIME NOT NULL,
    Reason VARCHAR(255) NOT NULL,
    FOREIGN KEY (Patient_ID) REFERENCES Patients(Patient_ID) ON DELETE CASCADE
);


