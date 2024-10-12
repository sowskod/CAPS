<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

$scoreId = isset($_GET['score_id']) ? intval($_GET['score_id']) : 0;

// Fetch the student ID associated with the score
$query = "SELECT student_id FROM scores WHERE id = $scoreId";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
$score = mysqli_fetch_assoc($result);
if (!$score) {
    die("Score not found.");
}

// Delete the score
$deleteQuery = "DELETE FROM scores WHERE id = $scoreId";
if (mysqli_query($con, $deleteQuery)) {
    echo '<script>alert("Score deleted successfully!");window.location.href = "student_records.php?student_id=' . $score['student_id'] . '&section_id=' . $_GET['section_id'] . '";</script>';
} else {
    echo "Error deleting score: " . mysqli_error($con);
}