-- Create database for AcademicHub
CREATE DATABASE IF NOT EXISTS academic_hub;
USE academic_hub;

-- Departments table to store department information
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dept_name VARCHAR(100) NOT NULL UNIQUE,
    dept_code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Semesters table to store available semesters
CREATE TABLE semesters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    semester_name VARCHAR(50) NOT NULL UNIQUE,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses table to store course details
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(50) NOT NULL UNIQUE,
    course_title VARCHAR(255) NOT NULL,
    credits INT NOT NULL CHECK (credits > 0),
    dept_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dept_id) REFERENCES departments(id) ON DELETE RESTRICT
);

-- Students table to store student information
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    student_id VARCHAR(50) UNIQUE,
    dept_id INT,
    major VARCHAR(100),
    dob DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dept_id) REFERENCES departments(id) ON DELETE SET NULL,
    INDEX idx_student_id (student_id)
);

-- Enrollments table to store course enrollment details
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL,
    course_id INT NOT NULL,
    semester_id INT NOT NULL,
    grade VARCHAR(10),
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE RESTRICT,
    UNIQUE (student_id, course_id, semester_id),
    INDEX idx_enrollment_student (student_id)
);

-- Trigger to prevent duplicate enrollments
DELIMITER //
CREATE TRIGGER prevent_duplicate_enrollment
BEFORE INSERT ON enrollments
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1
        FROM enrollments
        WHERE student_id = NEW.student_id
        AND course_id = NEW.course_id
        AND semester_id = NEW.semester_id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Student is already enrolled in this course for the selected semester';
    END IF;
END //
DELIMITER ;

-- Insert sample data for departments
INSERT INTO departments (dept_name, dept_code) VALUES
('Computer Science', 'CS'),
('Electrical Engineering', 'EE'),
('Business Studies', 'BS'),
('Civil Engineering', 'CE'),
('English', 'ENG');

-- Insert sample data for semesters
INSERT INTO semesters (semester_name, start_date, end_date) VALUES
('Fall 2025', '2025-09-01', '2025-12-15'),
('Spring 2026', '2026-01-15', '2026-05-30'),
('Summer 2026', '2026-06-01', '2026-08-15');

-- Insert sample data for courses
INSERT INTO courses (course_code, course_title, credits, dept_id) VALUES
('CS101', 'Introduction to Programming', 3, (SELECT id FROM departments WHERE dept_code = 'CS')),
('CS202', 'Data Structures', 4, (SELECT id FROM departments WHERE dept_code = 'CS')),
('EE101', 'Circuit Analysis', 3, (SELECT id FROM departments WHERE dept_code = 'EE')),
('BS101', 'Principles of Marketing', 3, (SELECT id FROM departments WHERE dept_code = 'BS')),
('CE201', 'Structural Engineering', 4, (SELECT id FROM departments WHERE dept_code = 'CE')),
('ENG101', 'English Literature', 3, (SELECT id FROM departments WHERE dept_code = 'ENG'));

-- Insert sample data for students
INSERT INTO students (name, email, student_id, dept_id, major, dob, address) VALUES
('Alice Smith', 'alice.smith@university.com', 'STU2025001', (SELECT id FROM departments WHERE dept_code = 'CS'), 'Software Engineering', '2000-05-15', '123 Main St, City'),
('Bob Johnson', 'bob.johnson@university.com', 'STU2025002', (SELECT id FROM departments WHERE dept_code = 'EE'), 'Circuit Design', '1999-11-22', '456 Oak Ave, Town');

-- Insert sample data for enrollments
INSERT INTO enrollments (student_id, course_id, semester_id, grade) VALUES
('STU2025001', (SELECT id FROM courses WHERE course_code = 'CS101'), (SELECT id FROM semesters WHERE semester_name = 'Fall 2025'), 'A'),
('STU2025001', (SELECT id FROM courses WHERE course_code = 'CS202'), (SELECT id FROM semesters WHERE semester_name = 'Spring 2026'), NULL),
('STU2025002', (SELECT id FROM courses WHERE course_code = 'EE101'), (SELECT id FROM semesters WHERE semester_name = 'Fall 2025'), 'B+');