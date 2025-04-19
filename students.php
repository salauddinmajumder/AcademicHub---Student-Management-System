<?php
require_once 'config.php';
include 'layout.php';

$stmt = $db->query("SELECT name, student_id, department, major, email FROM students ORDER BY name");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Student List</h2>
    <?php if (empty($students)): ?>
        <p class="text-gray-600 text-center py-4">No data in the table</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3 text-left">Name</th>
                        <th class="border p-3 text-left">Student ID</th>
                        <th class="border p-3 text-left">Department</th>
                        <th class="border p-3 text-left">Major</th>
                        <th class="border p-3 text-left">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border p-3"><?php echo htmlspecialchars($student['name']); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($student['student_id'] ?: '-'); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($student['department'] ?: '-'); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($student['major'] ?: '-'); ?></td>
                            <td class="border p-3"><?php echo htmlspecialchars($student['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>