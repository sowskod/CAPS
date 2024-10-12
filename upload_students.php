<?php
require 'vendor/autoload.php'; // Load Composer dependencies

use PhpOffice\PhpSpreadsheet\IOFactory;

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

// Check if a file was uploaded
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];

    // Validate file type
    $allowedMimeTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    if (in_array($fileType, $allowedMimeTypes)) {
        try {
            // Load the Excel file
            $spreadsheet = IOFactory::load($fileTmpPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Prepare to insert data
            $stmt = $con->prepare("INSERT INTO students (user_id, section_id, student_name, email, courses, sections) VALUES (?, ?, ?, ?, ?, ?)");

            foreach ($rows as $index => $row) {
                // Skip header row
                if ($index === 0 || empty($row[0])) {
                    continue;
                }

                list($studentName, $email, $courses, $sections) = $row;

                // Bind parameters and execute query
                $stmt->bind_param('iissss', $userId, $sectionId, $studentName, $email, $courses, $sections);
                $stmt->execute();
            }

            echo '<script>alert("Students uploaded successfully!");window.location.href = "student.php?section_id=' . $sectionId . '";</script>';
        } catch (Exception $e) {
            echo "Error loading file: " . $e->getMessage();
        }
    } else {
        echo "Invalid file type. Please upload an Excel file.";
    }
} else {
    echo "No file uploaded or upload error.";
}
?>
