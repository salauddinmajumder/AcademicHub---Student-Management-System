<?php
require_once 'config.php';
include 'layout.php';

$studentId = isset($_GET['student_id']) ? trim($_GET['student_id']) : '';
$enrollments = [];
if ($studentId) {
    try {
        $stmt = $db->prepare("SELECT course_code, course_title, semester, grade FROM enrollments WHERE student_id = ? ORDER BY semester, course_code");
        $stmt->execute([$studentId]);
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Database error: ' . $e->getMessage();
    }
}
?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Enrollment History</h2>
    <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
            <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($studentId); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Student ID" required aria-required="true">
        </div>
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors self-end">Search</button>
    </form>
    <?php if (isset($errorMsg)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <?php echo htmlspecialchars($errorMsg); ?>
        </div>
    <?php endif; ?>
    <?php if ($studentId && empty($enrollments)): ?>
        <p class="text-gray-600 text-center py-4">No data available</p>
    <?php elseif (!empty($enrollments)): ?>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3 text-left">Course Code</th>
                        <th class="border p-3 text-left">Course Title</th>
                        <th class="border p-3 text-left">Semester</th>
                        <th class="border p-3 text-left">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border p-3"><?php echo htmlspecialchars($enrollment['course_code']); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($enrollment['course_title'] ?: '-'); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($enrollment['semester'] ?: '-'); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($enrollment['grade'] ?: '-'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>