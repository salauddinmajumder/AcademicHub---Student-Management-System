<?php
session_start();
require_once 'config.php';
include 'layout.php';

$successMsg = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$errorMsgs = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['success']);
unset($_SESSION['errors']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $major = trim($_POST['major'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $errorMsgs = [];
    if (empty($name)) $errorMsgs[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errorMsgs[] = 'Valid email is required';

    if (empty($errorMsgs)) {
        try {
            $stmt = $db->prepare("INSERT INTO students (name, email, student_id, department, major, dob, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $studentId, $department, $major, $dob, $address]);
            $_SESSION['success'] = 'Student registered successfully!';
            header('Location: home.php');
            exit;
        } catch (PDOException $e) {
            $errorMsgs[] = 'Database error: ' . $e->getMessage();
            $_SESSION['errors'] = $errorMsgs;
            header('Location: home.php');
            exit;
        }
    } else {
        $_SESSION['errors'] = $errorMsgs;
        header('Location: home.php');
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

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Student Registration</h2>
    <form id="regForm" method="POST" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required aria-required="true">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
            <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required aria-required="true">
        </div>
        <div>
            <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
            <input type="text" id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <select id="department" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Department</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Electrical Engineering">Electrical Engineering</option>
                <option value="Business Studies">Business Studies</option>
            </select>
        </div>
        <div>
            <label for="major" class="block text-sm font-medium text-gray-700">Major</label>
            <select id="major" name="major" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Major</option>
                <option value="Software Engineering">Software Engineering</option>
                <option value="Data Science">Data Science</option>
                <option value="Marketing">Marketing</option>
            </select>
        </div>
        <div>
            <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input type="date" id="dob" name="dob" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" rows="4"></textarea>
        </div>
        <button type="submit" name="register" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">Register</button>
    </form>
</div>

<script>
document.getElementById('regForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    let errors = [];
    if (!name) errors.push('Name is required');
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Valid email is required');
    if (errors.length) {
        e.preventDefault();
        alert(errors.join('\n'));
    }
});
</script>
</body>
</html>