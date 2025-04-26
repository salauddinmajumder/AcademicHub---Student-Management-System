# AcademicHub - Student Management System

## Overview
AcademicHub is a modern, web-based application designed to manage student registrations, course enrollments, and enrollment histories. Built with PHP, MySQL, HTML, Tailwind CSS, and JavaScript, it offers a user-friendly interface, robust validation, and a responsive design suitable for educational institutions. This project fulfills the requirements of a student management system with a focus on simplicity, accessibility, and professionalism.

## Features
- **Student Registration**: Register students with fields for Name (mandatory), Email (mandatory), Student ID, Department, Major, Date of Birth, and Address. Includes client-side and server-side validation.
- **Student List**: Displays a table of all registered students, showing Name, Student ID, Department, Major, and Email. Shows "No data in the table" when empty.
- **Course Enrollment**: Enroll students in courses with fields for Student ID (mandatory), Course Code (mandatory), Course Title, and Semester. Validates inputs and stores data securely.
- **Enrollment History**: Search by Student ID to view a table of enrolled courses, including Course Code, Course Title, Semester, and Grade (if available). Displays "No data available" when empty.
- **UI/UX**: Features a consistent navigation bar, clear form labels, styled buttons, success/error messages, and responsive tables. Uses Tailwind CSS for a modern, animated design.
- **Accessibility**: Includes ARIA attributes, keyboard navigation, and high-contrast colors for screen reader support and usability.
- **Security**: Uses PDO with prepared statements to prevent SQL injection and `htmlspecialchars` to mitigate XSS attacks.

## Project Structure
```
AcademicHub/
├── home.php              # Page for student registration
├── students.php          # Page to list all students
├── courses.php           # Page for course enrollment
├── history.php           # Page to view enrollment history
├── config.php            # Database connection configuration
├── layout.php            # Common header and navigation
├── assets/
│   └── theme.css         # Custom Tailwind CSS styles
├── db/
│   └── schema.sql        # Database setup script
├── README.md             # Project documentation (this file)
```

## Setup Instructions
Follow these steps to set up and run AcademicHub on your local machine:

1. **Install XAMPP**:
   - Download and install [XAMPP](https://www.apachefriends.org/) for Apache, PHP, and MySQL.
   - Start Apache and MySQL from the XAMPP Control Panel.

2. **Create the Database**:
   - Open phpMyAdmin at `http://localhost/phpmyadmin`.
   - Create a database named `academic_hub`.
   - Navigate to the SQL tab and run the script from `db/schema.sql` to create the `students` and `enrollments` tables.

3. **Configure Project Files**:
   - Create a folder named `AcademicHub` in XAMPP’s `htdocs` directory (e.g., `C:\xampp\htdocs\AcademicHub`).
   - Place the following files in the `AcademicHub` folder: `home.php`, `students.php`, `courses.php`, `history.php`, `config.php`, `layout.php`.
   - Create an `assets` subfolder and save `theme.css` in `AcademicHub/assets`.
   - Create a `db` subfolder and save `schema.sql` in `AcademicHub/db`.
   - Add this `README.md` file to the `AcademicHub` root.

4. **Update Database Credentials**:
   - Open `config.php` and verify or update the database credentials:
     ```php
     $user = 'your_username';  // Default: 'root' for XAMPP
     $pass = 'your_password';  // Default: '' (empty) for XAMPP
     $dbName = 'academic_hub';
     ```

5. **Access the Application**:
   - Open a web browser and navigate to `http://localhost/AcademicHub/home.php`.
   - Use the navigation bar to access other pages (Student List, Enroll Course, Enrollment History).

## Usage
- **Register a Student**:
  - Go to the "Register Student" page (`home.php`).
  - Fill in the form (Name and Email are mandatory) and submit.
  - Check for a success message or error messages if validation fails.
- **View Student List**:
  - Navigate to the "Student List" page (`students.php`).
  - View all registered students in a table or see "No data in the table" if empty.
- **Enroll in a Course**:
  - Go to the "Enroll Course" page (`courses.php`).
  - Enter Student ID and Course Code (mandatory) and optional Course Title and Semester.
  - Submit to enroll and verify the success message.
- **Check Enrollment History**:
  - Visit the "Enrollment History" page (`history.php`).
  - Enter a Student ID and submit to view enrolled courses or see "No data available" if none exist.

## Dependencies
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Web Server**: Apache (included in XAMPP)
- **Tailwind CSS**: Included via CDN
- **Browser**: Any modern browser (Chrome, Firefox, Edge, etc.)

## Accessibility Features
- **ARIA Attributes**: Used for form fields (`aria-required`) and navigation (`aria-current`) to support screen readers.
- **Keyboard Navigation**: All forms and buttons are accessible via keyboard with visible focus states.
- **High Contrast**: Colors meet WCAG guidelines for readability.
- **Clear Labels**: Descriptive labels and error messages enhance usability.

## Security Considerations
- **SQL Injection**: Prevented using PDO prepared statements.
- **XSS**: Mitigated with `htmlspecialchars` for user inputs.
- **Validation**: Both client-side (JavaScript) and server-side (PHP) validation ensure data integrity.




## Author
- **Name**: Salauddin Majumder
- **ID**: 212-15-4227
