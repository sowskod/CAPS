<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through user input and update the database
    foreach ($_POST['subject'] as $studentId => $subjectId) {
        $studentId = (int)$studentId;
        $subjectId = (int)$subjectId;
        $updateQuery = "UPDATE students SET subject_id = $subjectId WHERE id = $studentId";
        if (!$con->query($updateQuery)) {
            echo "Error updating student ID $studentId: " . $con->error;
        }
    }
    echo "Subjects assigned successfully!";
}
?>
