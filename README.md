# enrollment

create database enrollment;

CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    course VARCHAR(100),
    profile_picture VARCHAR(255)
);

CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE
);

CREATE TABLE subject (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20) unique,
    subject_name VARCHAR(100)
  );


CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id int,
    day VARCHAR(20),
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (subject_id) REFERENCES subject(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
	
);



CREATE TABLE enroll (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    UNIQUE(student_id, subject_id),
    FOREIGN KEY (student_id) REFERENCES student(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subject(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE faculty_assignment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    subject_id INT,

  FOREIGN KEY (faculty_id) REFERENCES faculty(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subject(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,

   UNIQUE(subject_id)
);





    UNIQUE(subject_id)
);
