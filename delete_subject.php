<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Disable foreign key checks
    $disableForeignKeyCheckQuery = "SET FOREIGN_KEY_CHECKS = 0";
    $con->query($disableForeignKeyCheckQuery);

    // Delete the subject
    $deleteStmt = $con->prepare("DELETE FROM subjects WHERE id = ?");
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
        header('Location: subjects.php');
    } else {
        echo "Error: " . $deleteStmt->error;
    }

    // Enable foreign key checks
    $enableForeignKeyCheckQuery = "SET FOREIGN_KEY_CHECKS = 1";
    $con->query($enableForeignKeyCheckQuery);

    $deleteStmt->close();
}
?>

