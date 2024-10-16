<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

// Retrieve student_id from the URL
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate student_id
if ($studentId <= 0) {
    die("Invalid student ID.");
}

// Fetch student details to confirm deletion
$studentQuery = "SELECT * FROM students WHERE id = $studentId AND user_id = $userId";
$result = mysqli_query($con, $studentQuery);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Student not found or you do not have permission to delete.");
}

$student = mysqli_fetch_assoc($result);

// Disable foreign key checks
mysqli_query($con, "SET FOREIGN_KEY_CHECKS=0;");

// Delete student
$deleteQuery = "DELETE FROM students WHERE id = $studentId AND user_id = $userId";

if (mysqli_query($con, $deleteQuery)) {
    echo '<script>alert("Student deleted successfully!");window.location.href = "page.php?student&section_id=' . $student['section_id'] . '";</script>';
} else {
    echo "Error deleting student: " . mysqli_error($con);
}

// Re-enable foreign key checks
mysqli_query($con, "SET FOREIGN_KEY_CHECKS=1;");
