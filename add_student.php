<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php'; // Ensure this file contains the database connection code

// Retrieve section_id from the URL
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

// Validate section_id
if ($sectionId <= 0) {
    die("Invalid section ID.");
}

// Fetch section details to confirm it exists
$sectionCheckQuery = "SELECT COUNT(*) AS count FROM sections WHERE id = $sectionId";
$result = mysqli_query($con, $sectionCheckQuery);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    die("Invalid section ID.");
}

// Handle student addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    // Get the form data and sanitize it
    $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
    $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);
    $cpNumber = mysqli_real_escape_string($con, $_POST['cp_number']);
    $program = mysqli_real_escape_string($con, $_POST['program']);
    $course = mysqli_real_escape_string($con, $_POST['course']);

    // SQL query to insert the data into the students table
    $query = "INSERT INTO students (user_id, section_id, student_name, email, cp_number, program, course) 
              VALUES ($userId, $sectionId, '$studentName', '$studentEmail', '$cpNumber', '$program', '$course')";

    if (mysqli_query($con, $query)) {
        echo '<script>alert("Student added successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
    } else {
        echo "Error adding student: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form button {
            padding: 10px 20px;
            background-color: #3498db;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2980b9;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button a {
            text-decoration: none;
            color: #3498db;
        }

        .back-button a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="back-button">
            <a href="page.php?student&section_id=<?php echo htmlspecialchars($sectionId); ?>">Back to Students List</a>
        </div>
        <h2>Add New Student</h2>
        <form method="POST" action="">
            <input type="hidden" name="section_id" value="<?php echo htmlspecialchars($sectionId); ?>">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>

            <label for="student_email">Student Email:</label>
            <input type="email" id="student_email" name="student_email" required>

            <label for="cp_number">Cellphone Number:</label>
            <input type="text" id="cp_number" name="cp_number" required>

            <label for="program">Program:</label>
            <input type="text" id="program" name="program" required>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>

            <button type="submit" name="add_student">Add Student</button>
        </form>
    </div>
</body>

</html>