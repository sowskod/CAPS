<?php
require 'vendor/autoload.php'; // Load Composer dependencies

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
  
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];


include 'db.php'; 


$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;


if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];

    
    $allowedMimeTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    if (in_array($fileType, $allowedMimeTypes)) {
        try {
          
            $spreadsheet = IOFactory::load($fileTmpPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

           
            $stmt = $con->prepare("INSERT INTO students (user_id, section_id, student_number, student_name, email) VALUES (?, ?, ?, ?, ?)");

            foreach ($rows as $index => $row) {
                
                if ($index === 0 || empty($row[0])) {
                    continue;
                }

                
                list($timestamp, $studentNumber, $studentName, $email) = $row;

               
                $stmt->bind_param('iisss', $userId, $sectionId, $studentNumber, $studentName, $email);
                if (!$stmt->execute()) {
                    echo "Error inserting student: " . $stmt->error;
                }
            }



            echo '<script>alert("Students uploaded successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
        } catch (Exception $e) {
            echo "Error loading file: " . $e->getMessage();
        }
    } else {
        echo "Invalid file type. Please upload an Excel file.";
    }
} else {
    echo "No file uploaded or upload error.";
}
