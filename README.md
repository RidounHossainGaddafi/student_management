For creating Database:
CREATE DATABASE university_db;

For creating Table in Database:
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    student_id VARCHAR(50),
    department VARCHAR(100),
    major VARCHAR(100),
    dob DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL,
    course_code VARCHAR(50) NOT NULL,
    course_title VARCHAR(255),
    semester VARCHAR(50),
    grade VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
