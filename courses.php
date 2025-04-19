<?php
session_start();
require_once 'config.php';
include 'layout.php';

$successMsg = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$errorMsgs = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['success']);
unset($_SESSION['errors']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    $studentId = trim($_POST['student_id'] ?? '');
    $courseCode = trim($_POST['course_code'] ?? '');
    $courseTitle = trim($_POST['course_title'] ?? '');
    $semester = trim($_POST['semester'] ?? '');

    $errorMsgs = [];
    if (empty($studentId)) $errorMsgs[] = 'Student ID is required';
    if (empty($courseCode)) $errorMsgs[] = 'Course Code is required';

    if (empty($errorMsgs)) {
        try {
            $stmt = $db->prepare("INSERT INTO enrollments (student_id, course_code, course_title, semester) VALUES (?, ?, ?, ?)");
            $stmt->execute([$studentId, $courseCode, $courseTitle, $semester]);
            $_SESSION['success'] = 'Course enrolled successfully!';
            header('Location: courses.php');
            exit;
        } catch (PDOException $e) {
            $errorMsgs[] = 'Database error: ' . $e->getMessage();
            $_SESSION['errors'] = $errorMsgs;
            header('Location: courses.php');
            exit;
        }
    } else {
        $_SESSION['errors'] = $errorMsgs;
        header('Location: courses.php');
        exit;
    }
}
?>

<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <?php if ($successMsg): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <?php echo htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>
    <?php if ($errorMsgs): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul class="list-disc pl-5">
                <?php foreach ($errorMsgs as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Course Enrollment</h2>
    <form id="enrollForm" method="POST" class="space-y-4">
        <div>
            <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID <span class="text-red-500">*</span></label>
            <input type="text" id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required aria-required="true">
        </div>
        <div>
            <label for="course_code" class="block text-sm font-medium text-gray-700">Course Code <span class="text-red-500">*</span></label>
            <input type="text" id="course_code" name="course_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required aria-required="true">
        </div>
        <div>
            <label for="course_title" class="block text-sm font-medium text-gray-700">Course Title</label>
            <input type="text" id="course_title" name="course_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
            <select id="semester" name="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Semester</option>
                <option value="Fall 2025">Fall 2025</option>
                <option value="Spring 2026">Spring 2026</option>
                <option value="Summer 2026">Summer 2026</option>
            </select>
        </div>
        <button type="submit" name="enroll" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">Enroll</button>
    </form>
</div>

<script>
document.getElementById('enrollForm').addEventListener('submit', function(e) {
    const studentId = document.getElementById('student_id').value.trim();
    const courseCode = document.getElementById('course_code').value.trim();
    let errors = [];
    if (!studentId) errors.push('Student ID is required');
    if (!courseCode) errors.push('Course Code is required');
    if (errors.length) {
        e.preventDefault();
        alert(errors.join('\n'));
    }
});
</script>
</body>
</html>