# Enrollment Database Schema

## Create Database
```sql
CREATE DATABASE enrollment;
USE enrollment;
```

## Tables

### Student Table
```sql
CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    course VARCHAR(100),
    profile_picture VARCHAR(255)
);
```

### Faculty Table
```sql
CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE
);
```

### Subject Table
```sql
CREATE TABLE subject (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20) UNIQUE,
    subject_name VARCHAR(100)
);
```

### Schedule Table
```sql
CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT,
    day VARCHAR(20),
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (subject_id) REFERENCES subject(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```

### Enrollment Table
```sql
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
```

### Faculty Assignment Table
```sql
CREATE TABLE faculty_assignment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    subject_id INT,
    UNIQUE(subject_id),
    FOREIGN KEY (faculty_id) REFERENCES faculty(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subject(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```
