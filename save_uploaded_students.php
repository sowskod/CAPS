<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php'; // Ensure this file contains the database connection code

// Fetch section ID from the query string
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

// Check if the form was submitted with student data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['students'])) {
    $students = $_POST['students'];

    // Prepare to insert data into the students table
    $stmt = $con->prepare("INSERT INTO students (user_id, section_id, student_name, email, courses, sections) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($students as $student) {
        // Validate that required fields exist
        $studentName = isset($student['name']) ? $student['name'] : null;
        $email = isset($student['email']) ? $student['email'] : null;
        $course = isset($student['course']) ? $student['course'] : null;
        $section = isset($student['section']) ? $student['section'] : null;

        // Skip if any of the required fields are missing
        if (empty($studentName) || empty($email) || empty($course) || empty($section)) {
            continue;
        }

        // Bind parameters and execute the query
        $stmt->bind_param('iissss', $userId, $sectionId, $studentName, $email, $course, $section);
        $stmt->execute();
    }

    // After successful insert, redirect to the student page with a success message
    echo '<script>alert("Students saved successfully!");window.location.href = "student.php?section_id=' . $sectionId . '";</script>';
} else {
    echo "No student data to save.";
}
?>
