<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcademicHub - Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/theme.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-800 p-4 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="text-white text-lg font-bold">AcademicHub</div>
            <div class="space-x-4">
                <a href="home.php" class="text-white hover:bg-blue-900 px-3 py-2 rounded-md transition-colors" aria-current="<?php echo basename($_SERVER['PHP_SELF']) === 'home.php' ? 'page' : ''; ?>">Register Student</a>
                <a href="students.php" class="text-white hover:bg-blue-900 px-3 py-2 rounded-md transition-colors" aria-current="<?php echo basename($_SERVER['PHP_SELF']) === 'students.php' ? 'page' : ''; ?>">Student List</a>
                <a href="courses.php" class="text-white hover:bg-blue-900 px-3 py-2 rounded-md transition-colors" aria-current="<?php echo basename($_SERVER['PHP_SELF']) === 'courses.php' ? 'page' : ''; ?>">Enroll Course</a>
                <a href="history.php" class="text-white hover:bg-blue-900 px-3 py-2 rounded-md transition-colors" aria-current="<?php echo basename($_SERVER['PHP_SELF']) === 'history.php' ? 'page' : ''; ?>">Enrollment History</a>
            </div>
        </div>
    </nav>