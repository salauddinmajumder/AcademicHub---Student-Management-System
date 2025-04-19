<?php
// Database connection settings
$host = 'localhost';
$dbName = 'academic_hub';
$user = 'root';  // Update with your MySQL username
$pass = '';      // Update with your MySQL password

try {
    $db = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to database: " . $e->getMessage());
}
?>